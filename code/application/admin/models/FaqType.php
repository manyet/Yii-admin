<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * 评价
 */
class FaqType extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq_type}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['sort', ], 'number','message' => '{attribute}为纯数字'],
            [['type_name','type_ename' ], 'unique','message' => '{attribute}已存在！'],
            [['create_time', ], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sort' => '排序',
            'type_name' => '类型名称',
            'type_ename' => '英文类型名称',
            'create_time' => '创建时间',
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