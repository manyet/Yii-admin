<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * 评价
 */
class Faq extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['sort', ], 'number','message' => '{attribute}为纯数字'],
            [['type_id','answer','eanswer' ], 'required','message' => '{attribute}不能为空，请前往类型管理添加'],
            [['question','equestion' ], 'unique','message' => '{attribute}已存在！'],
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
            'question' => '问题',
            'equestion' => '英文问题',
            'answer' => '答案',
            'eanswer' => '英文答案',
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