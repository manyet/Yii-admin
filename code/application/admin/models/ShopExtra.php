<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mbb_shop_extra".
 *
 * @property string $id
 * @property int $class_id
 * @property int $cook_time
 * @property string $delivery_fee
 * @property int $delivery_time
 * @property string $min_order_fee
 * @property string $average_cost
 * @property int $is_frozen
 * @property int $support_take_out
 * @property int $is_recommend
 * @property int $order_total
 * @property int $keywords
 *
 * @property ShopClass[] $shopClass
 */
class ShopExtra extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%shop_extra}}";
    }

    public function rules()
    {
        return [
            [
                [
                    'id',
                    'is_frozen',
                ],
                'required',
                'message' => '{attribute}不能为空！'
            ],
            [['id'], 'string', 'message' => '非法请求，{attribute}类型不对！'],
            [
                ['is_frozen'],
                'integer',
                'message' => '非法请求，{attribute}类型不对！'
            ],
            ['is_frozen', 'in', 'range' => [0, 1], 'message' => '{attribute}不合法'],
            [
                [
                    'class_id',
                    'cook_time',
                    'delivery_fee',
                    'online_delivery_fee',
                    'delivery_time',
                    'min_order_fee',
                    'average_cost',
                    'support_take_out',
                    'is_accept_order',
                    'is_recommend',
                    'order_total',
                    'keywords',
                    'brokerage',
                    'other_charge',
                ],
                'safe'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '店铺id',
            'class_id' => '餐饮分类id',
            'cook_time' => '出餐时间',
            'delivery_fee' => '配送费',
            'online_delivery_fee' => '线上配送费',
            'delivery_time' => '配送时间',
            'min_order_fee' => '最小订餐费',
            'average_cost' => '人均消费',
            'is_frozen' => '冻结状态',
            'support_take_out' => '外卖状态',
            'is_accept_order' => '接单状态',
            'is_recommend' => '推荐状态',
            'order_total' => '每月订单数',
            'keywords' => '关键字',
            'brokerage' => '佣金比例',
            'other_charge' => '其他费用',
        ];
    }

    /**
     * 获取店铺附表的信息
     */
    public function getShopExtra()
    {
        return $this->hasOne(ShopClass::className(), ['id' => 'class_id'])->select([
            'class_name' => 'name',/*餐饮分类*/
        ]);
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