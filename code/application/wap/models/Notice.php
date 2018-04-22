<?php

namespace wap\models;

use yii\db\ActiveRecord;

/**
 *消息
 */
class Notice extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%notice}}';
    }

}