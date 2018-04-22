<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 业务规则
 */
class BusinessRule extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%business_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['business_name'], 'required'],
            [['id', 'create_time', 'create_by', 'limit_type'], 'integer'],
            [['business_name'], 'string'],
            [['cash_score_ratio', 'entertainment_score_ratio', 'company_score_ratio', 'procedures_score_ratio', 'limit_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'business_name' => '业务名称',
            'cash_score_ratio' => '现金分比例',
            'entertainment_score_ratio' => '娱乐分比例',
            'company_score_ratio' => '公司分比例',
            'procedures_score_ratio' => '手续分比例',
            'create_time' => '创建时间',
            'create_by' => '创建人',
            'limit_type' => '日封顶类型',
            'limit_value' => '固定封顶值',
        ];
    }

}
