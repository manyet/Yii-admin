<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 总部消息
 */
class NoticeCompany extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%notice_company}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['create_time', 'type'], 'integer'],
			[['title', 'content', 'individual_id'], 'string'],
		];
	}

}
