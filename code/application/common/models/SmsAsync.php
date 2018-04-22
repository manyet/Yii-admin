<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 异步短信
 */
class SmsAsync extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%sms_async}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['recipient', 'content', 'create_time', 'status'], 'required'],
			[['update_time'], 'integer']
		];
	}


}
