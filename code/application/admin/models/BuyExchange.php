<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 汇率管理
 */
class BuyExchange extends CommonActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%exchange_rate}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['currency','e_currency', 'buy_exchange_rate','sell_exchange_rate', 'create_time'], 'required', 'message' => '{attribute}不能为空'],
			[['create_time', 'update_time'], 'integer'],
			[['operator','is_deleted'], 'safe']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'currency' => '币种',
			'buy_exchange_rate' => '购买/充值汇率',
			'buy_exchange_rate' => '提现汇率',
			'create_time' => '创建时间',
		];
	}


}
