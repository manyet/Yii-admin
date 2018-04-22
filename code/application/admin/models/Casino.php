<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 汇率管理
 */
class Casino extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%casino}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['casino_name', 'notes','from', 'position','projects','casino_picture','details',
        'e_casino_name', 'e_notes','e_from', 'e_position','e_projects','e_details','flag_picture','casino_bank','casino_bank_holder'], 'required', 'message' => '{attribute}不能为空'],
            [['create_time','player','casino_bank_no'], 'integer','message' => '人数为整数'],
            [['casino_bank_banch'], 'safe'],
            [['clear_account', 'unclear_account'], 'number'],
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
