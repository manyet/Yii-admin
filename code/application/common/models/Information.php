<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 资讯
 */
class Information extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%information}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['title', 'local_url', 'author', 'create_time', 'create_by'], 'required'],
			[['title', 'local_url', 'author', 'content', 'digest'], 'string'],
			[['update_time'], 'integer']
		];
	}

}
