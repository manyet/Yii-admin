<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mbb_shop_class".
 *
 * @property int $id
 * @property string $shop_id
 * @property int $class_id
 * @property string $class_name
 * @property int $usable
 *
 */
class ShopClassConn extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%shop_class_conn}}";
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['class_id', 'shop_id'], 'required', 'message' => '{attribute}不能为空！'],
            ['shop_id', 'string', 'message' => '非法请求，{attribute}类型不对！'],
            ['class_id', 'integer', 'message' => '非法请求，{attribute}类型不对！'],
            [['class_name', 'usable'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => '餐饮分类id',
            'shop_id' => '店铺id',
            'class_name' => '分类名',
            'usable' => '有效状态'
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

    /**
     * 获取全部餐饮分类
     * @param $id
     * @return array|ActiveRecord[]
     */
    public function getShopClassConnList($id)
    {
        return static::find()
            ->select([
                'class_id',/*分类id*/
                'shop_id',/*店铺id*/
                'class_name',/*餐饮分类名*/
                'usable',/*餐饮分类名*/
            ])
            ->where('shop_id = :shopId', ['shopId' => $id])
            ->asArray()
            ->all();
    }
}