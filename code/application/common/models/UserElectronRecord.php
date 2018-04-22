<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 用户电子分记录
 */
class UserElectronRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%electronic_feb}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['user_id', 'create_time', 'wallet_type'], 'required'],
			[['remark'], 'string'],
			[['before_feb', 'after_feb', 'value'], 'number'],
			[['type', 'change_type', 'user_id', 'wallet_type', 'create_time'], 'integer'],
		];
	}

}
