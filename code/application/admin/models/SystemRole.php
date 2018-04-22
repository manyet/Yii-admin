<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 角色
 */
class SystemRole extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_by', 'update_by', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string'],
            [['name', 'status'], 'required'],
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
            'name' => '角色名',
            'auth' => '权限',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }
}