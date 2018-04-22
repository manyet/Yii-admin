<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "mbb_shop_class".
 *
 * @property int $id
 * @property string $name
 * @property int $dr
 * @property int $sort
 * @property int $create_time
 * @property string $pic_path
 */
class ShopClass extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%shop_class}}";
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'create_time', 'sort'], 'required', 'message' => '{attribute}不能为空！'],
            [['name', 'pic_path'], 'string', 'message' => '非法请求，{attribute}类型不对！'],
            [['create_time', 'sort'], 'integer', 'message' => '非法请求，{attribute}类型不对！'],
            [['dr'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '餐饮分类id',
            'name' => '餐饮分类名',
            'dr' => '删除状态',
            'sort' => '排序',
            'pic_path' => '图标地址',
            'create_time' => '添加时间'
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
     * @return array|ActiveRecord[]
     */
    public function getShopClassList()
    {
        return static::find()
            ->select([
                'id',/*ID*/
                'name',/*餐饮分类名*/
                'sort',/*排序*/
                'pic_path',/*图片地址*/
            ])
            ->where('1 = 1')
            //->createCommand()->getRawSql();
            ->asArray()
            ->all();
    }

    /**
     * 获取一条餐饮分类信息
     * @param $id
     * @return array|null|ActiveRecord
     */
    public function getShopClassInfo($id)
    {
        return static::find()
            ->select([
                'id',/*ID*/
                'name',/*餐饮分类名*/
                'sort',/*排序*/
                'pic_path',/*图标地址*/
            ])
            ->where('id = :ID', ['ID' => $id])
            //->createCommand()->getRawSql();
            ->asArray()
            ->one();
    }
}