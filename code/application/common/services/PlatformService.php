<?php

namespace common\services;

use Yii;
use common\models\PlatformInfo;
use common\models\CompanyDividendGrantRecord;

/**
 * 平台信息
 */
class PlatformService {

	public static $errMsg = '';

	public static function increaseAchievement($amount) {
		return Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET achievement = achievement + ' . $amount)->execute() !== false;
	}

	public static function increaseCasinoCount($amount = 1) {
		return Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET casino_count = casino_count + ' . $amount)->execute() !== false;
	}

	public static function decreaseCasinoCount($amount = 1) {
		return Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET casino_count = casino_count - ' . $amount)->execute() !== false;
	}

	public static function increaseApplyCash($amount) {
		return Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET apply_cash = apply_cash + ' . $amount)->execute() !== false;
	}

	public static function increaseDividend($amount, $type) {
		return Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET dividend = dividend + ' . $amount . ', wait_dividend = wait_dividend + ' . $amount)->execute() !== false;
	}

	public static function dividendSuccess($achievement, $rate, $old_rate, $times, $total_interest) {
		$update_field = 'wait_dividend = wait_dividend - IF(wait_dividend > ' . $achievement . ', ' . $achievement . ', wait_dividend), dividend_times = ' . $times;
		$result = Yii::$app->db->createCommand('UPDATE ' . PlatformInfo::tableName() . ' SET ' . $update_field)->execute() !== false;
		if (!$result) {
			return false;
		}
		$info = PlatformInfo::find()->select('dividend,wait_dividend')->asArray()->one();
		return self::addLog($info['dividend'], $info['wait_dividend'], $times, $achievement, $rate, $old_rate, $total_interest);
	}

	public static function getDividendTotal() {
		return PlatformInfo::find()->select('dividend')->scalar();
	}

	public static function getDividendTimes() {
		return PlatformInfo::find()->select('dividend_times')->scalar();
	}

	public static function addLog($dividend, $wait_dividend, $times, $achievement, $interest_rate, $old_interest_rate, $total_interest) {
		$data = [
			'dividend' => $dividend,
			'wait_dividend' => $wait_dividend,
			'item' => $times,
			'interest_rate' => $interest_rate,
			'old_interest_rate' => $old_interest_rate,
			'achievement' => $achievement,
			'total_interest' => $total_interest,
			'create_time' => time()
		];
		$model = new CompanyDividendGrantRecord();
		$model->setAttributes($data);
		return $model->insert();
	}

}
