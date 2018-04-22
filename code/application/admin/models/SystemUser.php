<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 后台用户
 */
class SystemUser extends CommonActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%system_user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['username', 'pwd', 'role_id', 'status', 'realname', 'password_hash', 'create_time'], 'required', 'message' => '{attribute}不能为空'],
			[['status', 'create_by', 'update_by', 'create_time', 'update_time', 'is_deleted'], 'integer'],
			[['username'], 'unique'],
			[['username', 'pwd', 'avatar', 'realname'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'username' => '用户名',
			'pwd' => '密码',
			'logo' => '头像地址',
			'role_id' => '角色',
			'status' => '状态',
			'password_hash' => '密码安全字段',
			'realname' => '昵称',
			'create_time' => '创建时间',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRoleName() {
		return $this->hasOne(Role::className(), ['id' => 'role_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getApplys() {
		return $this->hasMany(Apply::className(), ['admin_id' => 'id']);
	}

}
