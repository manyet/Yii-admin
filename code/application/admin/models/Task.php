<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 任务
 */
class Task extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'mode', 'description'], 'required'],
            [['id', 'mode', 'status', 'create_time', 'create_by', 'ad_check_1', 'ad_check_2', 'ad_check_3', 'ad_check_4', 'ad_check_5', 'ad_check_6'], 'integer'],
            [
                [
                    'name', 'description', 'ad_pic_1', 'ad_pic_2', 'ad_pic_3', 'ad_pic_4', 'ad_pic_5', 'ad_pic_6',
                    'ad_merchant_1', 'ad_merchant_2', 'ad_merchant_3', 'ad_merchant_4', 'ad_merchant_5', 'ad_merchant_6',
                    'ad_remark_1', 'ad_remark_2', 'ad_remark_3', 'ad_remark_4', 'ad_remark_5', 'ad_remark_6',
                    'ad_url_1', 'ad_url_2', 'ad_url_3', 'ad_url_4', 'ad_url_5', 'ad_url_6', 'name_en', 'description_en'
                ]
                , 'string'
            ],
            [['ad_price_1', 'ad_price_2', 'ad_price_3', 'ad_price_4', 'ad_price_5', 'ad_price_6'], 'number']
        ];
    }

}
