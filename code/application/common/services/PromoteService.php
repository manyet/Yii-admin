<?php

namespace common\services;

use Yii;
use common\models\User;
use admin\models\BusinessRule;
use common\services\RewardService;
use common\services\UserService;
use common\services\PackageService;
use common\services\ElectronService;
use common\services\LanguageService;
use common\services\TemplateMessageService;

/**
 * 代理提成业务层
 */
class PromoteService {

	/**
	 * @var int 错误编码
	 */
	public $errCode = 0;

	/**
	 * @var string 错误信息
	 */
	public $errMsg = '';

	/**
	 * @var boolean 开启调试
	 */
	public $debug = false;

	public function __construct($debug = false) {
		$this->debug = $debug;
	}

	/**
	 * 推荐用户成为会员
	 * @param int $user_id 消费用户的ID
	 * @param float $expense 消费金额
	 * @param string $promote_type 推广类型（1、购买配套，2、充值配套，3、复投配套）
	 * @param array $extra_data 额外数据，用户信息、等等
	 * @return boolean 是否奖励成功
	 */
	public function rewardToUser($user_id, $expense, $promote_type, $extra_data = array()) {
		if (empty($user_id)) {
			$this->errCode = 21001;
			$this->errMsg = '会员ID为空';
			return false;
		}
		if (empty($expense)) {
			$this->errCode = 21003;
			$this->errMsg = '购买金额为空';
			return false;
		}

		// 获取用户信息
		$user_info = UserService::getUserInfo($user_id, 'rank,position,promoter_id,parent_id,parents');
		if (empty($user_info)) {
			$this->errCode = 21005;
			$this->errMsg = \Yii::t('app', 'player_not_exist');
			return false;
		}

		/* 数据类型转换 */
		$promoter_id = intval($user_info['promoter_id']);
		$expense = floatval($expense);
		$user_id = intval($user_id);

		// 发放直推奖励
		$promoter_benifit = 0;
		if (!empty($promoter_id)) {
			$promoter_info = UserService::getUserInfo($promoter_id, 'rank,direct_reward_ratio,language,package_value');
			if (!empty($promoter_info['rank'])) {
				$config = $this->getMyPackageConfig($promoter_info['rank']);
				$rate = floatval($promoter_info['direct_reward_ratio']);
				if (intval($config['direct_reward_check']) === 1 && $rate > 0) {
					$commission = $expense * $rate / 100;
					$rule = BusinessRule::find()->select('limit_type,limit_value')->where('id = 3')->asArray()->one();
					if ($rule['limit_type'] != 1) {
						if ($rule['limit_type'] == 2) {
							$limit = $promoter_info['package_value'];
						} else if ($rule['limit_type'] == 3) {
							$limit = $rule['limit_value'];
						}
						$start = strtotime(date('Y-m-d'));
						$end = $start + 86400;
						$today_commission = \pc\services\PromoteCommissionService::getCommissionByToady($promoter_id, $start, $end);
						$limit -= $today_commission;
						if ($limit > 0) {
							if ($commission > $limit) {
								$commission = $limit;
							}
						} else {
							$commission = 0;
						}
					}
					if ($commission > 0) {
						$award_added = RewardService::rewardToUser($promoter_id, $promoter_info['rank'], $expense, $commission, $rate, 3, [
							'commission_from' => $user_id,
							'type' => $promote_type
						]);
						$result = ElectronService::decreaseFroze($promoter_id, $commission, 2, \Yii::t('app', 'commission_direct_reward', [], LanguageService::getUserLanguage($promoter_info['language'])));
						if (!$result || $award_added === false) {
							$this->errCode = 30001;
							$this->errMsg = '直推奖励发放失败';
							return false;
						}
						$promoter_benifit += $commission;
					}
				}
			}
		}

		if (!empty($user_info['parent_id'])) {
			return $this->handleParents($user_id, $expense, $promote_type, [
				'position' => $user_info['position'],
				'rank' => $user_info['rank'],
				'promoter_id' => $promoter_id,
				'promoter_benifit' => $promoter_benifit,
				'parents' => $user_info['parents']
			]);
		}
	
		return true;
	}

	/**
	 * 发放上级提成
	 * @param int $user_id 用户ID
	 * @param float $expense 费用
	 * @param int $promote_type 推广类型
	 * @param int $extra_data 额外数据
	 * @return boolean
	 */
	public function handleParents($user_id, $expense, $promote_type, $extra_data = array()) {
		if (isset($extra_data['parents'])) {
			$parenIds = $extra_data['parents'];
		} else {
			$parenIds = Yii::$app->db->createCommand("SELECT getParentIds($user_id, 0)")->queryScalar();
		}
		$field = 'id,rank,package_value,position,point_award_ratio,parent_id,language';
		$parent_list = User::find()->select($field)->where("id IN ({$parenIds})")->orderBy(["field (`id`,{$parenIds})" => SORT_ASC])->asArray()->all();

		$rule = BusinessRule::find()->select('limit_type,limit_value')->where('id = 3')->asArray()->one();

		/* 增加级别奖励和业绩 */
		// 初始化第一个提成用户
		$pre_user = [
			'id' => $user_id,
			'position' => $extra_data['position'],
			'rank' => $extra_data['rank']
		];
		$level = 1;
		// 开始计算提成
		foreach ($parent_list as $current_user) {
			$config = $this->getMyPackageConfig($current_user['rank']);
			$percentage = $benifit = 0;
			if (!empty($current_user['rank'])) {
				// 发放见点奖励
				$percentage = floatval($current_user['point_award_ratio']);
				if (intval($config['direct_reward_check']) === 1 && $percentage > 0 && intval($config['effective_hierarchy']) >= $level) {
					$benifit = $expense * $percentage / 100;
					if ($rule['limit_type'] != 1) {
						if ($rule['limit_type'] == 2) {
							$limit = $current_user['package_value'];
						} else if ($rule['limit_type'] == 3) {
							$limit = $rule['limit_value'];
						}
						$start = strtotime(date('Y-m-d'));
						$end = $start + 86400;
						$today_commission = \pc\services\PointCommissionService::getCommissionByToady($current_user['id'], $start, $end);
						$limit -= $today_commission;
						if ($limit > 0) {
							if ($benifit > $limit) {
								$benifit = $limit;
							}
						} else {
							$benifit = 0;
						}
					}
					if ($benifit > 0) {
						if ($current_user['id'] == $extra_data['promoter_id']) {
							$extra_data['promoter_benifit'] += $benifit;
						}
						$award_added = RewardService::rewardToUser($current_user['id'], $current_user['rank'], $expense, $benifit, $percentage, 5, [
							'commission_from' => $user_id,
							'type' => $promote_type
						]);
						$result = ElectronService::decreaseFroze($current_user['id'], $benifit, 2, \Yii::t('app', 'commission_point_award', [], LanguageService::getUserLanguage($current_user['language'])));
						if (!$result || $award_added === false) {
							$this->errCode = 40001;
							$this->errMsg = '见点奖励发放失败';
							return false;
						}
					}
				}
			}
			// 更新用户业绩
			$user_achievement_updated = $this->updateUserAchievement($current_user['id'], $expense, $pre_user['position']);
			if (!$user_achievement_updated) {
				$this->errCode = 20031;
				$this->errMsg = '用户业绩更新失败';
				return false;
			}
			// 添加提成记录，待月结清算
			$result = $this->addAchievementRecord(array(
				'by_who' => $pre_user['id'],
				'by_who_rank' => $pre_user['rank'],
				'user_id' => $current_user['id'],
				'user_rank' => $current_user['rank'],
				'position' => $pre_user['position'],
				'achievement' => $expense,
				'parent_id' => $current_user['parent_id'],
				'develop_who' => $user_id,
				'type' => $promote_type,
				'create_time' => time(),
//				'promoter_id' => $user_id
				'commission' => $benifit,
				'percentage' => $percentage,
			));
			if (!$result) { // 记录添加失败，进行回滚
				$this->errCode = 20060;
				$this->errMsg = '上级提成记录添加失败';
				return false;
			}

			$pre_user = $current_user; // 更新当前下级
			$level++;
		}
		// 更新给与推荐者奖励总额
		if (!empty($extra_data['promoter_id']) && !empty($extra_data['promoter_benifit']) && $extra_data['promoter_benifit'] > 0) {
			$result = $this->updatePromoterBenifit($user_id, $extra_data['promoter_benifit']);
			if ($result === false) {
				$this->errCode = 30001;
				$this->errMsg = '更新推广者奖励总额失败';
				return false;
			}
		}
		return true;
	}

	/**
	 * 更新用户业绩
	 * @param int $user_id 用户
	 * @param int $expense 消费金额
	 * @param int $side 用户位置
	 * @return boolean
	 */
	public function updateUserAchievement($user_id, $expense, $side) {
		$fields = [
			'reward_time = reward_time + 1',
			'total_achievement = total_achievement + ' . $expense,
		];
		if ($side == 2) {
			$fields[] = 'right_achievement = right_achievement + ' . $expense . ', right_offset_achievement = right_offset_achievement + ' . $expense;
		} else {
			$fields[] = 'left_achievement = left_achievement + ' . $expense . ', left_offset_achievement = left_offset_achievement + ' . $expense;
		}
		return Yii::$app->db->createCommand('UPDATE ' . User::tableName() . ' SET ' . join(',', $fields) . " WHERE id = {$user_id}")->execute() > 0;
	}

	/**
	 * 添加提成记录，月结结算
	 */
	public function addAchievementRecord($data) {
		// 写入记录
		$result = Yii::$app->db->createCommand()->insert(\common\models\AchievementRecord::tableName(), $data)->execute();
		return $result > 0;
	}

	public function updatePromoterBenifit($user_id, $amount) {
		return Yii::$app->db->createCommand('UPDATE ' . User::tableName() . ' SET promoter_benifit = promoter_benifit + ' . $amount . ' WHERE id = ' . $user_id)->execute() !== false;
	}

	/**
	 * 获取全部配套配置
	 */
	protected function getAllPackageConfig() {
		static $config = NULL;
		if (empty($config)) {
			$packages = PackageService::getAllPackage('id,direct_reward_check,point_award_check,effective_hierarchy');
			$config = array();
			foreach ($packages as $one) {
				$config[$one['id']] = $one;
			}
		}
		return $config;
	}

	/**
	 * 获取我的配套配置
	 * @param int $rank
	 */
	protected function getMyPackageConfig($rank) {
		$configs = $this->getAllPackageConfig();
		if (isset($configs[$rank])) {
			return $configs[$rank];
		}
		return false;
	}

}
