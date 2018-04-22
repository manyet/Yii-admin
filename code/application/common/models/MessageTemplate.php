<?php

namespace common\models;

/**
 * 消息模板
 */
class MessageTemplate extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_template}}';
    }

	public function rules() {
		return [
			[['title'], 'required', 'message' => '{attribute}不能为空']
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'key'             => '',
            'title'           => '标题',
            'mobile_content'  => '短信内容',
            'message_content' => '消息内容',
            'is_send_mobile'  => '是否发送短信',
            'is_send_message' => '是否发送消息'
        ];
    }
}