<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 公司分红发放记录
 */
class CompanyDividendGrantRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%company_dividend_grant_record}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['dividend', 'wait_dividend', 'achievement', 'interest_rate', 'old_interest_rate', 'create_time', 'item', 'total_interest'], 'required'],
		];
	}


}
