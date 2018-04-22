<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 邮件模板
 */
class MailTemplate extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%mail_template}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['key'], 'required'],
			[['title', 'eng_title', 'content', 'eng_content', 'params'], 'string'],
			[['update_by', 'update_time'], 'integer'],
		];
	}

}
