<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * 评价
 */
class Evaluate extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%evaluate}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'content',
                    'score',
                    'delivery_time',
                    'anonymous',
                    'create_time',
                    'user_id',
                    'shop_id',
                    'order_id'
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'score' => '评分',
            'delivery_time' => '配送时间',
            'anonymous' => '匿名状态',
            'create_time' => '评价时间',
            'user_id' => '关联用户id',
            'shop_id' => '关联店铺id',
            'order_id' => '关联订单id',
        ];
    }

    /**
     * 返回表单验证的第一个错误
     * @param array $attribute
     * @return array
     */
    public function getFirstError($attribute)
    {
        return current($this->getFirstErrors());
    }
}