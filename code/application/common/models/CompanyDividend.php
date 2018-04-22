<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 公司分红
 */
class CompanyDividend extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%company_dividend}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['achievement', 'start_date', 'img_path', 'interest_rate', 'old_interest_rate', 'status', 'name', 'name_en', 'description', 'description_en', 'create_time'], 'required'],
		];
	}


}
