<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 绑定记录
 */
class PromoteRecord extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user_promote_record}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['user_id', 'create_time', 'parent_id', 'promoter_id', 'type'], 'required'],
		];
	}

}
