<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 平台信息
 */
class PlatformInfo extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%platform_info}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['achievement'], 'required'],
			[['pv', 'uv'], 'int'],
			[['achievement', 'dividend', 'apply_cash'], 'number'],
		];
	}

}
