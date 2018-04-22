<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 用户积分流水
 */
class PackageOrder extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%package_order}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['user_id', 'order_num', 'package_id', 'buy_time', 'price'], 'required'],
			[['remark', 'order_num'], 'string'],
			[['package_status', 'update_by', 'update_time', 'buy_time', 'package_id'], 'integer'],
		];
	}

}
