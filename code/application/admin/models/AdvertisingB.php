<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class AdvertisingB extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising_b}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [[ 'advertising_name', 'advertising_describe','advertising_Picture1',
                'advertising_Picture2','advertising_Picture3','advertising_Picture4',], 'required'],
            [['create_time', 'open'], 'integer'],
            [['advertisers_1','advertisers_2','advertisers_3','advertisers_4',

                'advertising_Path1','advertising_Path2',
                'advertising_Path3','advertising_Path4','open',
                'price1','price2','price3','price4','note1','note4','note3','note2',
                'b_open4','b_open3','b_open2','b_open1',
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





































