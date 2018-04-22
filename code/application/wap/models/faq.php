<?php

namespace wap\models;

use yii\db\ActiveRecord;

/**
 *
 */
class Faq extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq}}';
    }

}