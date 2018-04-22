<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 泥码订单
 */
class MudcodeOrder extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%mudcode_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_num', 'wallet_consume', 'exchange_mudcode', 'write_off_code', 'user_id', 'casino_id', 'exchange_time'], 'required'],
            [['id', 'user_id', 'casino_id', 'exchange_mudcode', 'exchange_time'], 'integer'],
            [['order_num', 'wallet_consume', 'write_off_code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'order_num' => '订单编号',
            'user_id' => '用户ID',
            'wallet_consume' => '钱包消耗',
            'exchange_mudcode' => '兑换泥码',
            'casino_id' => '赌场ID',
            'write_off_code' => '核销码',
            'exchange_time' => '兑换时间',
        ];
    }

}
