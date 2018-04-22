<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 配套订单
 */
class PackageOrder extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%package_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'package_id', 'buy_time'], 'required'],
            [['id', 'user_id', 'package_id', 'buy_time', 'package_status', 'update_time', 'update_by'], 'integer'],
            [['remark', 'order_num'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'package_id' => '配套ID',
            'buy_time' => '购买时间',
            'package_status' => '配套状态',
            'remark' => '备注',
            'update_time' => '更新时间',
            'update_by' => '更新人',
            'order_num' => '订单编号',
        ];
    }

}
