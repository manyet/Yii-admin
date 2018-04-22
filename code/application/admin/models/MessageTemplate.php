<?php
/**
 * Created by BBM
 * DateTime: 2016-12-09 14:17
 */

namespace admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tsk_message_template".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $mobile_content
 * @property string $message_content
 * @property integer $is_send_mobile
 * @property integer $is_send_message
 * @property string $params
 */
class MessageTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_template}}';
    }

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_send_mobile', 'is_send_message', 'is_send_system', 'update_by', 'update_time'], 'integer'],
            [['title', 'message_content', 'mobile_content', 'system_content', 'params', 'description'], 'string'],
            [['key', 'title'], 'required', 'message' => '{attribute}不能为空'],
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
            'key' => '',
            'title' => '标题',
            'mobile_content' => '短信内容',
            'message_content' => '消息内容',
            'is_send_mobile' => '是否发送短信',
            'is_send_message' => '是否发送消息',
            'params' => '支持参数'
        ];
    }
}