<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 汇率管理
 */
class ElectronicFeb extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%electronic_feb}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'before_feb','after_feb','value','type','change_type','remark','wallet_type','create_time'],'safe']
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
