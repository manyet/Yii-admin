<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 菜单
 */
class SystemMenu extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_menu}}';
    }

	public static function primaryKey() {
		return ['id'];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'parent_id', 'sort', 'create_by', 'update_by', 'create_time', 'update_time'], 'integer'],
            [['name', 'url', 'icon', 'params'], 'string'],
            [['name', 'url', 'parent_id'], 'required', 'message' => '{attribute}不能为空'],
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
            'name' => '菜单名',
            'status' => '状态',
            'create_time' => '创建时间',
            'url' => '链接地址'
        ];
    }
}