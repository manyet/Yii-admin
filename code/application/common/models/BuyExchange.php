<?php

namespace common\models;


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


}
