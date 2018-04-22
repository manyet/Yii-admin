<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 短信记录
 */
class SmsRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%sms_record}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['recipient', 'content', 'create_time', 'status'], 'required'],
			[['result'], 'string']
		];
	}


}
