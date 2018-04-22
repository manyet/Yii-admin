<?php

namespace common\services;

use common\models\WechatKeyword;

class WechatKeywordService {

	public static $errMsg = '';

	public static function getByKey($key, $fields = '*') {
		return WechatKeyword::find()->select($fields)->where('`keys` = :keys', ['keys' => $key])->asArray()->one();
	}

	public static function add($data) {
		$model = new WechatKeyword();
		$data['create_at'] = date('Y-m-d H:i:s');
		$data['create_by'] = getUserId();
		$model->setAttributes($data);
		if (!$model->insert()) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

	public static function update($key, $data) {
		$model = WechatKeyword::findOne(['keys' => $key]);
		$model->setAttributes($data);
		if ($model->update() === false) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

}
