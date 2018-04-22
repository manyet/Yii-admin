<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 调整比例流水
 */
class ProportionRecord extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%proportion_record}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return [
            [['user_id', 'create_time', 'proportion_before', 'proportion_after', 'type'], 'required'],
        ];
    }

}
