<?php

namespace common\services;

use common\models\WechatConfig;

class WechatConfigService {

	public static function getConfigById($id, $fields = '*') {
		return WechatConfig::find()->select($fields)->where('id = :id', ['id' => $id])->asArray()->one();
	}

	public static function getConfigByAppId($app_id, $fields = '*') {
		return WechatConfig::find()->select($fields)->where('appid = :appid', ['appid' => $app_id])->asArray()->one();
	}

	public static function saveConfig($id, $config) {
		$model = WechatConfig::findOne($id);
		$model->setAttributes($config);
		return $model->update() !== false;
	}

	public static function addConfig($config) {
		$model = new WechatConfig();
		$model->setAttributes($config);
		return $model->insert();
	}

	public static function getType($key = true) {
		$types = ['1' => '服务号', '2' => '订阅号'];
		if ($key === true) {
			return $types;
		}
		return isset($types[$key]) ? $types[$key] : null;
	}

}
