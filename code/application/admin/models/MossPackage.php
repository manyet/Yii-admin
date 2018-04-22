<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 莫斯配套
 */
class MossPackage extends CommonActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%moss_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['package_name', 'level_name', 'package_value', 'electron_multiple'], 'required'],
            [
                ['id', 'create_by', 'create_time', 'package_status', 'total_sales', 'effective_hierarchy', 'daily_dividend_check', 'task_benefit_check', 'direct_reward_check',
                 'development_reward_check', 'point_award_check', 'count', 'is_deleted'
                ]
                , 'integer'
            ],
            [
				[
					'package_name', 'level_name', 'package_description', 'package_image_path', 'package_name_en', 'package_description_en',
					'package_detail', 'package_detail_en'
				]
				, 'string'
			],
			[
                ['package_value', 'electron_multiple', 'daily_dividend_ratio', 'task_benefit_ratio', 'direct_reward_ratio',
					'development_reward_ratio', 'point_award_ratio',
                 
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
            'package_name' => '配套名称',
            'level_name' => '等级名称',
            'package_value' => '配套价值',
            'electron_multiple' => '电子分倍数',
            'create_time' => '发布时间',
            'package_status' => '配套状态',
            'total_sales' => '总销量',
            'daily_dividend_ratio' => '每日分红比例',
            'task_benefit_ratio' => '任务收益比例',
            'direct_reward_ratio' => '直推奖励比例',
            'development_reward_ratio' => '发展奖励比例',
            'point_award_ratio' => '见点奖比例',
            'effective_hierarchy' => '有效层级',
            'package_description' => '配套描述',
            'package_image_path' => '配套图片路径',
            'create_by' => '创建人',
            'daily_dividend_check' => '每日分红勾选',
            'task_benefit_check' => '任务收益勾选',
            'direct_reward_check' => '直推奖励勾选',
            'development_reward_check' => '发展奖励勾选',
            'point_award_check' => '见点奖勾选',
            'package_name_en' => '配套名称-英文',
            'package_description_en' => '配套描述-英文',
            'package_detail' => '配套详细介绍',
            'package_detail_en' => '配套详情介绍-英文',
            'count' => '显示人数',
            'is_deleted' => '是否已删除',
        ];
    }

}
