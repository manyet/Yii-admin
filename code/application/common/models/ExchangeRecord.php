<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 兑换记录
 */
class ExchangeRecord extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%exchange_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_id', 'amount', 'create_by', 'create_time', 'code', 'number', 'casino_id'],
                'required',
                'message' => '{attribute}不能为空！'
            ],
			[['status', 'count'], 'integer'],
			['remark', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'goods_id' => '商品',
            'price' => '加入时的价格',
            'store_id' => '店铺ID',
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