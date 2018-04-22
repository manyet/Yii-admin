<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 角色
 */
class SystemLog extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'title', 'ip'], 'required'],
            [['id', 'create_by', 'create_time'], 'integer'],
            [['isp', 'content', 'type', 'user_agent'], 'string'],
            //[['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_agent' => '客户端信息',
            'from' => '来源',
            'ip' => 'IP地址',
			'isp' => '网络运营商',
            'title' => '标题',
            'content' => '内容',
            'create_by' => '操作人',
            'create_time' => '操作时间',
            'type' => '类型',
        ];
    }
}