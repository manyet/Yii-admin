<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 转分订单
 */
class TransferOrder extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%transfer_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_num', 'wallet_consume', 'transfer_account', 'transfer_wallet', 'user_id', 'transfer_time'], 'required'],
            [['id', 'user_id', 'transfer_time'], 'integer'],
            [['order_num', 'wallet_consume', 'transfer_account', 'transfer_wallet'], 'string'],
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
            'transfer_account' => '转入账户',
            'transfer_wallet' => '转入钱包',
            'transfer_time' => '转分时间',
        ];
    }

}
