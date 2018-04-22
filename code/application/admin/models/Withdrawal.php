<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 汇率管理
 */
class Withdrawal extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%withdrawal_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_num', 'user_id', 'bank', 'branch', 'bank_no', 'holder',
                'rate', 'integral', 'money', 'application_time','state','remark','handling_time','state','create_by'],'safe']
        ];
    }

    /**
     * 返回表单验证的第一个错误
     * @param string $attribute
     * @return array
     */
    public function getFirstError($attribute)
    {
        return current($this->getFirstErrors());
    }


}
