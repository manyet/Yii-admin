<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 系统说明
 */
class Description extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%description}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['key'], 'required'],
			[['name', 'content', 'eng_content'], 'string'],
			[['update_by', 'update_time'], 'integer'],
		];
	}

}
