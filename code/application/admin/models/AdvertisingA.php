<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class AdvertisingA extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising_a}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [[ 'advertising_name', 'advertising_describe'], 'required'],
            [['create_time', 'open'], 'integer'],
            [['advertisers_1','advertisers_2','advertisers_3','advertisers_4','advertisers_5','advertisers_6',
            'advertising_Picture1','advertising_Picture2','advertising_Picture3','advertising_Picture4',
                'advertising_Picture5','advertising_Picture6', 'advertising_Path1','advertising_Path2',
            'advertising_Path3','advertising_Path4','advertising_Path5','advertising_Path6','open',
            'price1','price2','price3','price4','price5','price6','note1','note4','note3','note2','note5','note6',
                'c_open6','c_open5','c_open4','c_open3','c_open2','c_open1',
                'wap_Picture1','wap_Picture2','wap_Picture3','wap_Picture4','wap_Picture5','wap_Picture6',
            ],'safe']
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





































