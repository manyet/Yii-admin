<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class RechargeRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recharge_record}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [

            [
                [
                    'id',
                    'amount',
                    'ryder_id',
                    'user_id',
                    'type',
                    'create_time',
                ],
                'safe'
            ],
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





































