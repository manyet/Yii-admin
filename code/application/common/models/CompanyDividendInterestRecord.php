<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 公司分红利息记录
 */
class CompanyDividendInterestRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%company_dividend_interest_record}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['dividend', 'old_dividend', 'dividend_interest', 'old_dividend_interest', 'interest_rate', 'old_interest_rate', 'total_dividend', 'total_dividend_interest', 'create_time', 'user_id', 'item'], 'required'],
		];
	}


}
