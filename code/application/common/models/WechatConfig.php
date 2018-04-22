<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 微信配置
 */
class WechatConfig extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%wechat_config}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['appid', 'appsecret', 'name', 'token', 'type'], 'required'],
			[['appid', 'appsecret', 'name', 'token', 'encodingaeskey', 'subscribe_url'], 'string'],
			[['type'], 'integer']
		];
	}

}
