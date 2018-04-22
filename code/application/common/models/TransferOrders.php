<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 用户
 */
class TransferOrders extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%transfer_orders}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return [
            [['create_time'], 'required'],
            [['order_num','user_id','consumption','into','into_wallet',], 'safe'],
        ];
    }

}
