<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 总部消息
 */
class ModifyOrder extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%modify_order}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {
        return [
            [['user_id','create_time','balance_after', 'order_num',
                'balance_before', 'value', 'modify_type','type'], 'safe'],
        ];
    }

}
