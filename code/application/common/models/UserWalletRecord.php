<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 用户
 */
class UserWalletRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user_wallet_record}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['user_id', 'create_time', 'wallet_type'], 'required'],
			[['remark'], 'string'],
			[['balance_after', 'balance_before', 'value'], 'number'],
			[['type', 'change_type', 'user_id', 'wallet_type', 'create_time'], 'integer'],
		];
	}

}
