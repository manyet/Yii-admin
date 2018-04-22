<?php

namespace admin\models;

use common\models\CommonActiveRecord;

/**
 * 角色权限
 */
class SystemRoleAccess extends CommonActiveRecord {

	public static function tableName() {
		return '{{%system_role_access}}';
	}

	/**
	 * 获取权限节点
	 * @return array
	 */
	public static function getAccessByRoles($role_ids) {
		if (is_string($role_ids)) {
			$role_ids = explode(',', $role_ids);
		}
		return self::find()->select('path')->distinct('path')->where(['IN', 'role_id', $role_ids])->column();
	}

	/**
	 * 获取权限列表
	 * @return array
	 */
	public static function saveAccess($role_id, $data) {
		$table_name = self::tableName();
		$result = self::deleteAll('role_id = :role_id', ['role_id' => $role_id]) !== false;
		return $result && \Yii::$app->db->createCommand()->batchInsert($table_name, ['role_id', 'path'], $data)->execute() !== false;
	}

}
