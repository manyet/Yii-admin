<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 赌场用户
 */
class CasinoUser extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%casino_user}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['create_time', 'uname', 'casino_id'], 'required'],
			[['uname', 'realname', 'nickname', 'mobile', 'pwd', 'salt', 'pay_pwd', 'email', 'language'], 'string'],
			[[
				'total_income', 'clear_account', 'unclear_account'
			], 'number'],
			[['gender', 'identity', 'status', 'create_time'], 'integer'],
		];
	}

}
