<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 钱包规则
 */
class WalletRule extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%wallet_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [
				[
					'id', 'create_time', 'create_by', 'recast_multiple', 'transfer_multiple', 'package_buy_open', 'package_recharge_open',
					'package_recast_open', 'transfer_score_open'
				]
				, 'integer'
			],
			[['wallet_name'], 'string'],
            [
                [
                    'package_lowest_ratio', 'package_highest_ratio', 'recast_lowest_value', 'transfer_lowest_value', 'company_score_ratio',
					'cash_score_ratio', 'entertainment_score_ratio', 'recharge_lowest_ratio', 'recharge_highest_ratio', 'recharge_lowest_value'
                ]
                , 'number'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'wallet_name' => '钱包名称',
            'create_time' => '创建时间',
            'create_by' => '创建人',
            'package_lowest_ratio' => '配套最低比例',
            'package_highest_ratio' => '配套最高比例',
            'recast_lowest_value' => '复投最低值',
            'recast_multiple' => '复投倍数',
            'transfer_lowest_value' => '转分最低值',
            'transfer_multiple' => '转分倍数',
            'company_score_ratio' => '公司分比例',
            'cash_score_ratio' => '现金分比例',
            'entertainment_score_ratio' => '娱乐分比例',
            'package_buy_open' => '开启购买配套',
            'package_recharge_open' => '开启配套充值',
            'package_recast_open' => '开启复投配套',
            'transfer_score_open' => '开启转让分数',
            'recharge_lowest_ratio' => '配套充值最低比例',
            'recharge_highest_ratio' => '配套充值最高比例',
            'recharge_lowest_value' => '充值配套最低分值',
        ];
    }

}
