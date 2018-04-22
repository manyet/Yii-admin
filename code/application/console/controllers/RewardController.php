<?php

namespace console\controllers;

use admin\models\BusinessRule;
use common\models\User;
use common\models\PlatformInfo;
use common\models\CompanyDividendInterestRecord;
use common\services\PackageService;
use common\services\ElectronService;
use common\services\RewardService;
use common\services\UserWalletService;
use common\services\CompanyDividend;
use common\services\LanguageService;
use yii\console\Controller;

/**
 * 奖励处理
 *
 * @author jindewen <jindewen@21cn.com>
 */
class RewardController extends Controller
{

	private function handleUser($pageCount, $where, $fields, $callback) {
		$model = User::find()->where($where);
		$total = intval($model->count());
		$totalPage = ceil($total / $pageCount);
		for ($page = 0; $page < $totalPage; $page++) {
			$data = $model->select($fields)->limit($pageCount)->offset($page * $pageCount)->asArray()->all();
			$callback($data);
		}
	}

	/**
	 * 获取全部配套配置
	 */
	public function getAllPackageConfig() {
		static $config = NULL;
		if (empty($config)) {
			$packages = PackageService::getAllPackage('id,daily_dividend_check,development_reward_check');
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
	public function getMyPackageConfig($rank) {
		$configs = $this->getAllPackageConfig();
		if (isset($configs[$rank])) {
			return $configs[$rank];
		}
		return false;
	}

	/**
	 * 每日任务
	 */
    public function actionDailyEvent() {
		echo date('Y-m-d H:i:s') . ' ';
		$develop_limit = $develop_limit_value = $daily_limit = $daily_limit_value = false; // 收益封顶值
		$develop_limit_type = $daily_limit_type = 1;
		$limit_data = BusinessRule::find()->select('id,limit_type,limit_value')->where('id IN (1,4)')->asArray()->all();
		foreach ($limit_data as $one) {
			if ($one['id'] == 1) {
				$daily_limit = $one['limit_type'] != 1;
				$daily_limit_value = $one['limit_value'];
				$daily_limit_type = $one['limit_type'];
			} else if ($one['id'] == 4) {
				$develop_limit = $one['limit_type'] != 1;
				$develop_limit_value = $one['limit_value'];
				$develop_limit_type = $one['limit_type'];
			}
		}
		$fields ='id,language,package_value,total_offseted_achievement,total_offseted_achievement,left_offset_achievement,left_offseted_achievement,right_offseted_achievement,right_offset_achievement,rank,daily_dividend_ratio,development_reward_ratio,electronic_number,froze_electronic_number';
		$where = 'rank > 0 AND (froze_electronic_number > 0 OR (left_offset_achievement > 0 AND right_offset_achievement > 0))';
		$transaction = \Yii::$app->db->beginTransaction();
		$this->handleUser(300, $where, $fields, function ($data) use ($transaction, $develop_limit, $develop_limit_value, $develop_limit_type, $daily_limit, $daily_limit_value, $daily_limit_type) {
			foreach ($data as $one) {
				$user_data = [];
				// 获取用户配套配置
				$config = $this->getMyPackageConfig($one['rank']);
				// 处理封顶值
				if ($develop_limit_type == 2) $develop_limit_value = $one['package_value'];
				if ($daily_limit_type == 2) $daily_limit_value = $one['package_value'];
				LanguageService::setLanguageTemp($one['language']);
				// 处理见点奖励
				$rate = floatval($one['development_reward_ratio']);
				if (intval($config['development_reward_check']) === 1 && $rate > 0 && ($one['left_offset_achievement'] > 0 && $one['right_offset_achievement'] > 0)) {
					$left_rest = $right_rest = 0.00;
					if ($one['left_offset_achievement'] >= $one['right_offset_achievement']) {
						$value = floatval($one['right_offset_achievement']);
						$left_rest = $one['left_offset_achievement'] - $one['right_offset_achievement'];
					} else {
						$value = floatval($one['left_offset_achievement']);
						$right_rest = $one['right_offset_achievement'] - $one['left_offset_achievement'];
					}
					$commission = $value * $rate / 100;
					// 发展奖励根据配套金额封顶
					if ($develop_limit && $commission > $develop_limit_value) {
						$commission = $develop_limit_value;
					}
					if ($commission > 0) {
						$user_data['froze_electronic_number'] = $one['froze_electronic_number'] - $commission;
						$result = RewardService::rewardToUser($one['id'], $one['rank'], $value, $commission, $one['development_reward_ratio'], 4, [
							'yesterday_commission' => $value
						]);
						if (!$result) {
							$transaction->rollBack();
							exit('point reward error: ' . json_encode($one) . PHP_EOL);
						}
						$result = ElectronService::addLog($one['id'], $commission, 2, 2, 2, $one['froze_electronic_number'], $user_data['froze_electronic_number'], \Yii::t('app', 'commission_development_reward'));
						if (!$result) {
							$transaction->rollBack();
							exit('electronic log error: ' . json_encode($one) . PHP_EOL);
						}
						// 更新待返电子分
						$one['froze_electronic_number'] = $user_data['froze_electronic_number'];
					}
					$user_data['yesterday_develop_reward'] = $value;
					$user_data['total_offseted_achievement'] = $one['total_offseted_achievement'] + $value;
					$user_data['left_offset_achievement'] = $left_rest;
					$user_data['right_offset_achievement'] = $right_rest;
					$user_data['left_offseted_achievement'] = $one['left_offseted_achievement'] + $value;
					$user_data['right_offseted_achievement'] = $one['right_offseted_achievement'] + $value;
				}
				// 处理每日分红
				$rate = floatval($one['daily_dividend_ratio']);
				if (intval($config['daily_dividend_check']) === 1 && $one['froze_electronic_number'] > 0) {
					$commission = $one['electronic_number'] * $one['daily_dividend_ratio'] / 100;
					if ($daily_limit && $commission > $daily_limit_value) { // 每日分红根据固定值封顶
						$commission = $daily_limit_value;
					}
					if ($commission > $one['froze_electronic_number']) {
						$commission = $one['froze_electronic_number'];
					}
					if ($commission > 0) {
						$result = RewardService::rewardToUser($one['id'], $one['rank'], $one['electronic_number'], $commission, $one['daily_dividend_ratio'], 1, [
							'yesterday_commission' => $one['electronic_number']
						]);
						if (!$result) {
							$transaction->rollBack();
							exit('daily reward error: ' . json_encode($one) . PHP_EOL);
						}
						$user_data['froze_electronic_number'] = $one['froze_electronic_number'] - $commission;
						$result = ElectronService::addLog($one['id'], $commission, 2, 2, 2, $one['froze_electronic_number'], $user_data['froze_electronic_number'], \Yii::t('app', 'commission_daily_dividend'));
						if (!$result) {
							$transaction->rollBack();
							exit('electronic log error: ' . json_encode($one) . PHP_EOL);
						}
					}
				}
				if (empty($user_data)) {
					continue;
				}
				// 更新用户信息
				$result = \Yii::$app->db->createCommand()->update(User::tableName(), $user_data, ['id' => $one['id']])->execute() !== false;
				if (!$result) {
					$transaction->rollBack();
					exit('update user info error: ' . json_encode($one) . PHP_EOL);
				}
			}
		});
		$transaction->commit();
		exit('daily event success' . PHP_EOL);
	}

	/**
	 * 发放公司分红
	 * @param int $times 第几次发放奖励
	 */
	public function actionCompanyDividend() {
		echo date('Y-m-d H:i:s') . ' ';
		$config = CompanyDividend::getActiveProject('interest_rate,old_interest_rate,achievement');
		if (!empty($config)) {
			$achievement = $config['achievement'];
			$info = PlatformInfo::find()->select('wait_dividend,dividend_times')->asArray()->one();
			$is_reward = $info['wait_dividend'] >= $achievement;
			if ($is_reward) { // 累计分红金额达到100万
				$times = intval($info['dividend_times']) + 1;
				$new_rate = $config['interest_rate'];
				$old_rate = $config['old_interest_rate'];
				$fields ='id,language,stay_dividend_reward,old_dividend_reward';
				$where = 'rank > 0 AND (stay_dividend_reward > 0 OR old_dividend_reward > 0)';
				$transaction = \Yii::$app->db->beginTransaction();
				global $total;
				$total = 0;
				$this->handleUser(300, $where, $fields, function ($data) use ($transaction, $times, $new_rate, $old_rate) {
					global $total;
					foreach ($data as $one) {
						$model = new CompanyDividendInterestRecord();
						$new_dividend = floatval($one['stay_dividend_reward']);
						$old_dividend = floatval($one['old_dividend_reward']);
						$new_interest = $new_dividend * $new_rate / 100;
						$old_interest = $old_dividend * $old_rate / 100;
						$total_interest = $new_interest + $old_interest;
						$model->setAttributes([
							'item' => $times,
							'user_id' => $one['id'],
							'dividend' => $new_dividend,
							'old_dividend' => $old_dividend,
							'dividend_interest' => $new_interest,
							'old_dividend_interest' => $old_interest,
							'interest_rate' => $new_rate,
							'old_interest_rate' => $old_rate,
							'total_dividend' => $new_dividend + $old_dividend,
							'total_dividend_interest' => $total_interest,
							'create_time' => time()
						]);
						if (!$model->insert()) {
							var2file($model->getErrors());
							$transaction->rollBack();
							exit('insert user dividend record error: ' . json_encode($one) . PHP_EOL);
						}
						// 发放奖励并添加钱包记录
						$result = UserWalletService::increaseDividend($one['id'], $total_interest, 21, \Yii::t('app', 'times', ['time' => $times], LanguageService::getUserLanguage($one['language'])));
						if (!$result) {
							$transaction->rollBack();
							exit('give user dividend error: ' . json_encode($one) . PHP_EOL);
						}
						// 更新用户信息
						$result = \Yii::$app->db->createCommand('UPDATE ' . User::tableName() . ' SET stay_dividend_reward = 0, old_dividend_reward = old_dividend_reward + '
								. $one['stay_dividend_reward']
								. ' WHERE id = ' . $one['id'])->execute() !== false;
						if (!$result) {
							$transaction->rollBack();
							exit('update user dividend error: ' . json_encode($one) . PHP_EOL);
						}
						$total += $total_interest;
					}
				});
				if (\common\services\PlatformService::dividendSuccess($achievement, $new_rate, $old_rate, $times, $total)) {
					$transaction->commit();
					exit('No.' . $times . ' dividend success' . PHP_EOL);
				} else {
					$transaction->rollBack();
					exit('update dividend status error' . PHP_EOL);
				}
			}
		}
		exit('dividend handle success' . PHP_EOL);
	}

}