<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "t_shop".
 *
 * @property integer $shopId
 * @property string $shopName
 * @property integer $tmerchantId
 * @property string $shopPath
 * @property string $lat
 * @property string $lng
 * @property string $phone
 * @property string $content
 * @property int $starLevel
 * @property string $approval
 * @property int $approvalStatus
 * @property string $approvaltime
 * @property int $operStatus
 * @property string $creator
 * @property string $creattime
 * @property string $modifier
 * @property string $activetime
 * @property string $modtime
 * @property int $dr
 * @property string $picPath
 * @property int $manageType
 * @property int $wifiSupport
 * @property string $email
 * @property string $manageStart
 * @property string $manageEnd
 * @property string $keyword
 * @property int $langType
 *
 * @property ShopExtra[] $shopExtra
 */
class Shop extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        preg_match("/dbname=([^;]+)/i", self::getDb()->dsn, $matches);

        return $matches[1] . '.t_shop';
    }

    public function rules()
    {
        return [
            [
                [
                    'operStatus',
                    'langType',
                    'shopName',
                    'lat',
                    'lng',
                    'phone',
                ],
                'required',
                'message' => '{attribute}不能为空！'
            ],
            [['operStatus', 'langType'], 'integer'],
            [['shopName', 'lat', 'lng', 'phone', 'email', 'content', 'manageStart', 'manageEnd', 'keyword'], 'string'],
            [
                [
                    'shopId',
                    'email',
                    'tmerchantId',
                    'shopPath',
                    'starLevel',
                    'approval',
                    'approvalStatus',
                    'approvaltime',
                    'creator',
                    'creattime',
                    'modifier',
                    'activetime',
                    'modtime',
                    'wifiSupport',
                    'manageStart',
                    'manageEnd',
                    'keyword',
                    'dr',
                    'picPath',
                    'manageType',
                    'content'
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
            'shopId' => '店铺id',
            'shopName' => '店铺名',
            'tmerchantId' => '商家ID',
            'shopPath' => '店铺LOGO',
            'lat' => '经度',
            'lng' => '纬度',
            'phone' => '联系电话',
            'content' => '商家信息',
            'starLevel' => '店铺登记',
            'approval' => '审批人',
            'approvalStatus' => '审批状态',
            'approvaltime' => '审批时间',
            'operStatus' => '营业状态',
            'creator' => '创建人',
            'creattime' => '创建时间',
            'modifier' => '修改人',
            'activetime' => '有效期',
            'modtime' => '有效期',
            'dr' => '删除标识',
            'picPath' => '图片地址',
            'manageType' => '经营品类',
            'wifiSupport' => 'wifi支持',
            'email' => '电子邮件',
            'manageStart' => '营业时间开始',
            'manageEnd' => '营业结束时始',
            'keyword' => '关键字',
            'langType' => '语言类型'
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

    public function getShopExtra()
    {
        return $this->hasOne(ShopExtra::className(), ['id' => 'shopId'])->select([
            'class_id',/*餐饮分类id*/
            //'cook_time',/*出餐时间*/
            'delivery_fee',/*配送费*/
            'online_delivery_fee',/*线上配送费*/
            'delivery_time',/*配送时间*/
            'min_order_fee',/*最小订餐费*/
            'average_cost',/*人均消费*/
            'is_frozen',/*冻结状态*/
            'support_take_out',/*外卖状态*/
            'is_accept_order',/*接单状态*/
            'is_recommend',/*外卖状态*/
            'order_total',/*每月订单数*/
            'keywords',/*关键字*/
            'level',/*关键字*/
            'brokerage',/*佣金比例*/
            'other_charge',/*其他费用*/
        ]);
    }

    /**
     * 根据店铺shop_id获取店铺信息详情
     * @param $id
     * @return array|null|ActiveRecord
     */
    public function getShopInfoById($id)
    {
        return static::find()
            ->select([
                'a.shopId',/*店铺ID*/
                'merchant_id' => 'a.tmerchantId',/*商家ID*/
                'shop_name' => 'a.shopName',/*店铺名*/
                'shop_path' => 'a.shopPath',/*店铺LOGO*/
                'a.lat',/*经度*/
                'a.lng',/*纬度*/
                'a.phone',/*联系电话*/
                'a.content',/*商家信息*/
                'star_level' => 'a.starLevel',/*店铺等级*/
                'a.approval',/*审批人*/
                'approval_status' => 'a.approvalStatus',/*审批状态*/
                'approval_time' => 'a.approvaltime',/*审批时间*/
                'open_status' => 'a.operStatus',/*营业状态*/
                'a.creator',/*创建人*/
                'create_time' => 'a.creattime',/*创建时间*/
                'a.modifier',/*修改人*/
                'active_time' => 'a.activetime',/*有效期*/
                'mod_time' => 'a.modtime',/*有效时间*/
                'a.dr',/*删除标识*/
                'pic_path' => 'a.picPath',/*图片地址*/
                'manage_type' => 'a.manageType',/*经营品类*/
                'wifi_support' => 'a.wifiSupport',/*wifi支持*/
                'a.email',/*电子邮件*/
                'manage_start' => 'a.manageStart',/*营业时间开始*/
                'manage_end' => 'a.manageEnd',/*营业时间结束*/
                'a.keyword',/*关键字*/
                'lang_type' => 'a.langType'/*语言类型*/
            ])
            ->alias('a')
            ->with(['shopExtra'])
            ->where('a.shopId = :shop_id', ['shop_id' => $id])
            //->createCommand()->getRawSql();
            ->asArray()
            ->one();
    }

    /**
     * 根据商家id获取店铺信息详情
     * @param $id
     * @return array|null|ActiveRecord
     */
    public function getShopInfoByMerchantId($id)
    {
        return static::find()
            ->select([
                'a.shopId',/*店铺ID*/
                'shop_name' => 'a.shopName',/*店铺名*/
                'shop_path' => 'a.shopPath',/*店铺LOGO*/
                'a.lat',/*经度*/
                'a.lng',/*纬度*/
                'a.phone',/*联系电话*/
                'a.content',/*商家信息*/
                'star_level' => 'a.starLevel',/*店铺等级*/
                'a.approval',/*审批人*/
                'approval_status' => 'a.approvalStatus',/*审批状态*/
                'approval_time' => 'a.approvaltime',/*审批时间*/
                'open_status' => 'a.operStatus',/*营业状态*/
                'a.creator',/*创建人*/
                'create_time' => 'a.creattime',/*创建时间*/
                'a.modifier',/*修改人*/
                'active_time' => 'a.activetime',/*有效期*/
                'mod_time' => 'a.modtime',/*有效时间*/
                'a.dr',/*删除标识*/
                'pic_path' => 'a.picPath',/*图片地址*/
                'manage_type' => 'a.manageType',/*经营品类*/
                'wifi_support' => 'a.wifiSupport',/*wifi支持*/
                'a.email',/*电子邮件*/
                'manage_start' => 'a.manageStart',/*营业时间开始*/
                'manage_end' => 'a.manageEnd',/*营业时间结束*/
                'a.keyword',/*关键字*/
                'lang_type' => 'a.langType'/*语言类型*/
            ])
            ->alias('a')
            ->with(['shopExtra'])
            ->where('a.tmerchantId = :merchantId', ['merchantId' => $id])
            ->asArray()
            ->one();
    }
}