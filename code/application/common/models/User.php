<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 用户
 */
class User extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['create_time'], 'required'],
			[['uname', 'realname', 'nickname', 'mobile', 'pwd', 'salt', 'pay_pwd', 'email', 'invite_code', 'promoter_invite_code', 'birthday', 'language', 'parents'], 'string'],
			[[
				'package_value', 'daily_dividend_ratio', 'task_benefit_ratio', 'direct_reward_ratio',
				'development_reward_ratio', 'point_award_ratio', 'electronic_number', 'electron_multiple',
				'froze_electronic_number', 'company_integral', 'total_company_integral',
				'entertainment_integral', 'total_entertainment_integral', 'cash_integral',
				'total_cash_integral', 'poundage_integral', 'total_poundage_integral', 'promoter_benifit',
				'company_dividend', 'task_income', 'direct_reward', 'indirect_reward', 'point_reward', 'daily_dividend',
				'total_company_dividend', 'total_task_income', 'total_direct_reward', 'total_indirect_reward', 'total_point_reward', 'total_daily_dividend'
			], 'number'],
			[['rank', 'gender', 'rank_time', 'promoter_id', 'parent_id', 'identity', 'status', 'create_time', 'bind_time', 'position', 'level', 'mail_verified', 'max_level'], 'integer'],
		];
	}

}
