<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 公司分红记录
 */
class CompanyDividendRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%company_dividend_record}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['value', 'create_time', 'user_id', 'type', 'balance'], 'required'],
			[['remark'], 'string'],
		];
	}


}
