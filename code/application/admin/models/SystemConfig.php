<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 后台用户
 */
class SystemConfig extends CommonActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%system_config}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['status', 'create_time', 'update_time'], 'integer'],
			[['name'], 'unique'],
			[['value'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => '配置名称',
			'value' => '配置值',
			'status' => '状态',
			'update_time' => '更新时间',
			'create_time' => '创建时间'
		];
	}

}
