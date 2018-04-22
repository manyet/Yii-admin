<?php

namespace common\services;

use admin\models\WalletRule;

/**
 * 参数配置业务类
 */
class RuleService {

	/**
	 * 获取操作可用钱包规则
	 * @param int $type 类型（1、购买配套，2、充值，3、复投，4、转让）
	 * @return array
	 */
	public static function getRulesByType($type) {
		$types = [
			'1' => 'package_buy_open',
			'2' => 'package_recharge_open',
			'3' => 'package_recast_open',
			'4' => 'transfer_score_open'
		];
		$fields = [
			'1' => ['package_lowest_ratio', 'package_highest_ratio'],
			'2' => ['recharge_lowest_ratio', 'recharge_highest_ratio', 'recharge_lowest_value'],
			'3' => ['recast_lowest_value', 'recast_multiple'],
			'4' => ['transfer_lowest_value', 'transfer_multiple', 'company_score_ratio', 'cash_score_ratio', 'entertainment_score_ratio']
		];
		$field = $fields[$type];
		$field[] = 'id';
		return WalletRule::find()->select($field)->where($types[$type] . ' = 1')->asArray()->all();
	}

	public static function getTypeName($type = true) {
		$types = [
			'1' => \Yii::t('app', 'wallet_company_score'),
			'2' => \Yii::t('app', 'wallet_cash_score'),
			'3' => \Yii::t('app', 'wallet_entertainment_score')
		];
		if ($type === true) {
			return $types;
		}
		return isset($types[$type]) ? $types[$type] : NULL;
	}

	public static function getBalanceKey($type = true) {
		$types = [
			'1' => 'company_integral',
			'2' => 'cash_integral',
			'3' => 'entertainment_integral'
		];
		if ($type === true) {
			return $types;
		}
		return isset($types[$type]) ? $types[$type] : NULL;
	}

	/**
	 * 获取余额名称和信息
	 */
	public static function getBalanceInfo($user_info) {
		$arr = array();
		foreach (RuleService::getTypeName() as $key => $value) {
			$arr['scoreNames']['pay[' . $key . ']'] = $value;
			$arr['balances']['pay[' . $key . ']'] = $user_info[RuleService::getBalanceKey($key)];
		}
		return $arr;
	}

}
