<?php
/**
 * Created by BBM
 * DateTime: 2016-11-18 12:00
 */

namespace admin\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class MessageModel
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $title
 * @property string  $content
 * @property integer $status
 * @property string  $create_date
 * @package wap\models
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['content'], 'string'],
            //[['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => '用户ID',
            'title'       => '标题',
            'content'     => '内容',
            'status'      => '状态',
            'create_date' => '生成时间',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert)
            {
                $this->create_date = time();
                $this->status = 0;
            }
            else
            {
                $this->status = 1;
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}