<?php

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * 消息
 */
class Notice extends ActiveRecord {

    public static function tableName() {
        return '{{%notice}}';
    }

}
