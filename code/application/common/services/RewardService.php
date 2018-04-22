<?php

namespace common\services;

use Yii;
use common\models\User;
use common\services\UserWalletService;
use common\services\CompanyDividend;
use admin\models\BusinessRule;
use admin\models\MossPackage;
use common\services\PlatformService;

/**
 * 奖励服务类
 */
class RewardService {

	public static $errMsg = '';

	/**
	 * 业绩分发到各个钱包
	 * @param int $user_id
	 * @param float $amount
	 * @param int $type 奖励类型（1、每日分红，2、每日任务，3、直推奖励，4、发展奖励，5、见点奖励）
	 * @return float
	 */
	public static function addToWallets($user_id, $amount, $type) {
		$remarks = getRewardName();
		$rules = BusinessRule::find()->where('id = :id', ['id' => $type])->select('cash_score_ratio,entertainment_score_ratio,company_score_ratio,procedures_score_ratio')->asArray()->one();
		if ($amount > 0) {
			if (!empty($rules['cash_score_ratio'])) {
				$ratio = floatval($rules['cash_score_ratio']);
				if ($ratio > 0) {
					UserWalletService::increaseCash($user_id, $amount * $ratio / 100, $type, $remarks[$type]);
				}
			}
			if (!empty($rules['entertainment_score_ratio'])) {
				$ratio = floatval($rules['entertainment_score_ratio']);
				if ($ratio > 0) {
					UserWalletService::increaseEntertainment($user_id, $amount * $ratio / 100, $type, $remarks[$type]);
				}
			}
			if (!empty($rules['procedures_score_ratio'])) {
				$ratio = floatval($rules['procedures_score_ratio']);
				if ($ratio > 0) {
					UserWalletService::increasePoundage($user_id, $amount * $ratio / 100, $type, $remarks[$type]);
				}
			}
			if (!empty($rules['company_score_ratio'])) { // 公司分红
				$ratio = floatval($rules['company_score_ratio']);
				if ($ratio > 0) {
					$dividend = $amount * $ratio / 100;
					if ($dividend > 0) {
						$result = CompanyDividend::increase($user_id, $dividend, $type, getRewardName($type));
						if (!$result) {
							return false;
						}
					}
//					UserWalletService::increaseCompany($user_id, $amount * floatval($rules['company_score_ratio']) / 100, $type, $remarks[$type]);
				}
			}
		}
		return true;
	}

	/**
	 * 每日分红
	 */
	public static function rewardCompanyDividendToUser($user_id, $amount) {
		return self::handleReward($user_id, $amount, 1);
	}

	/**
	 * 任务收益
	 */
	public static function rewardTaskIncomeToUser($user_id, $amount) {
		return self::handleReward($user_id, $amount, 2);
	}

	/**
	 * 直推奖励
	 */
	public static function rewardDirectRewardToUser($user_id, $amount, $from_id, $promote_type) {
		return self::handleReward($user_id, $amount, 3, [
			'commission_from' => $from_id,
			'type' => $promote_type
		]);
	}

	/**
	 * 发展奖励
	 */
	public static function rewardIndirectRewardToUser($user_id, $amount) {
		return self::handleReward($user_id, $amount, 4);
	}

	/**
	 * 见点奖励
	 */
	public static function rewardPointRewardToUser($user_id, $amount, $from_id, $promote_type) {
		// 见点奖励记录
		return self::handleReward($user_id, $amount, 5, [
			'commission_from' => $from_id,
			'type' => $promote_type
		]);
	}

	public static function rewardToUser($user_id, $user_rank, $amount, $commission, $rate, $type, $extra_data = array()) {
		// 添加记录
		$tables = [
			'1' => [
				'user_daily_commission',
				'total_daily_dividend',
				'daily_dividend'
			],
			'2' => [
				'user_task_commission',
				'total_task_income',
				'task_income'
			],
			'3' => [
				'user_promote_commission',
				'total_direct_reward',
				'direct_reward'
			],
			'4' => [
				'user_develop_commission',
				'total_indirect_reward',
				'indirect_reward'
			],
			'5' => [
				'user_point_commission',
				'total_point_reward',
				'point_reward'
			]
		];
		$extra_data['user_id'] = $user_id;
		$extra_data['user_rank'] = $user_rank;
		$extra_data['achievement'] = $amount;
		$extra_data['percentage'] = $rate;
		$extra_data['commission'] = $commission;
		$extra_data['create_time'] = time();
		if (\Yii::$app->db->createCommand()->insert("{{%{$tables[$type][0]}}}", $extra_data)->execute() === false) {
			return false;
		}
		$result = \Yii::$app->db->createCommand('UPDATE ' . User::tableName() .
				" SET {$tables[$type][1]} = {$tables[$type][1]} + {$extra_data['commission']}, {$tables[$type][2]} = {$tables[$type][2]} + {$extra_data['commission']} WHERE id = $user_id")
				->execute() !== false;
		if (!$result) {
			return false;
		}
		return self::addToWallets($user_id, $extra_data['commission'], $type);
	}

	/**
	 * 奖励给用户
	 * @param int $user_id 用户ID
	 * @param int $amount 推广金额
	 * @param int $type 奖励类型（1、每日分红，2、每日任务，3、直推奖励，4、发展奖励，5、见点奖励）
	 */
	public static function handleReward($user_id, $amount, $type, $extra_data = array()) {
		$fields = [
			'1' => 'daily_dividend_ratio',
			'2' => 'task_benefit_ratio',
			'3' => 'direct_reward_ratio',
			'4' => 'development_reward_ratio',
			'5' => 'point_award_ratio'
		];
		$user_info = User::find()->select('rank,' . $fields[$type] . ' AS rate')->where('id = :id', ['id' => $user_id])->asArray()->one();
		if (empty($user_info['rank'])) {
//			$user_info['rank'] = MossPackage::find()->orderBy('package_value')->select('id')->scalar();
			return true;
		}
		$has_reward = self::hasReward($user_info['rank'], $type);
		if ($has_reward) {
			$rate = floatval($user_info['rate']);
			if ($rate > 0) {
				$commission = $amount * $rate / 100;
				return self::rewardToUser($user_id, $user_info['rank'], $amount, $commission, $rate, $type, $extra_data);
			}
		}
		return true;
	}

	/**
	 * 获取奖励配置
	 * @param int $rank 配套等级
	 * @param int $type 奖励类型（1、每日分红，2、每日任务，3、直推奖励，4、发展奖励，5、见点奖励）
	 */
	public static function hasReward($rank, $type) {
		if (empty($rank)) {
			return false;
		}
		$fields = [
			'1' => 'daily_dividend_check',
			'2' => 'task_benefit_check',
			'3' => 'direct_reward_check',
			'4' => 'development_reward_check',
			'5' => 'point_award_check',
		];
		return intval(MossPackage::find()->select($fields[$type])->where('id = :rank', ['rank' => $rank])->scalar()) === 1;
	}

}
