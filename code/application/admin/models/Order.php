<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [['id', 'order_id', 'store_id', 'old_status','new_status','offpay_type'], 'integer'],
            [['notes'],'string']
        ];
    }

}





































