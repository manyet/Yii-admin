<?php

namespace common\services;

use common\models\CompanyDividend as CompanyDividendModel;
use common\models\User;
use common\models\CompanyDividendRecord;
use common\services\PlatformService;

/**
 * 公司分红业务类
 */
class CompanyDividend {

	public static function getActiveProject($fields = '*') {
		return CompanyDividendModel::find()->where('status = 1')->select($fields)->asArray()->one();
	}

	public static function increase($user_id, $dividend, $type, $remark = '') {
		$result = PlatformService::increaseDividend($dividend, $type);
		if (!$result) {
			return false;
		}
		$result = \Yii::$app->db->createCommand('UPDATE ' . User::tableName() .
						" SET stay_dividend_reward = stay_dividend_reward + $dividend, total_dividend_reward = total_dividend_reward + $dividend WHERE id = $user_id")
						->execute() !== false;
		if (!$result) {
			return false;
		}
		return self::addLog($user_id, $dividend, $type, $remark);
	}

	public static function decrease($user_id, $dividend, $type, $remark = '') {
		$result = \Yii::$app->db->createCommand('UPDATE ' . User::tableName() .
						" SET stay_dividend_reward = stay_dividend_reward - $dividend, total_dividend_reward = total_dividend_reward - $dividend WHERE id = $user_id")
						->execute() !== false;
		if (!$result) {
			return false;
		}
		return self::addLog($user_id, -$dividend, $type, $remark);
	}

	public static function addLog($user_id, $dividend, $type, $remark = '') {
		$model = new CompanyDividendRecord();
		$model->setAttributes([
			'user_id' => $user_id,
			'value' => $dividend,
			'balance' => User::find()->where('id = ' . $user_id)->select('total_dividend_reward')->scalar(),
			'type' => $type,
			'remark' => $remark,
			'create_time' => time()
		]);
		return $model->insert();
	}

}
