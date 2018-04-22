<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 个体消息
 */
class NoticeIndividual extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%notice_individual}}';
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
