<?php

namespace wap\models;

use yii\db\ActiveRecord;

/**
 *
 */
class FaqType extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq_type}}';
    }

}