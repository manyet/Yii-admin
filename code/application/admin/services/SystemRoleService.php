<?php

namespace admin\services;

use admin\models\SystemRole;

class SystemRoleService {

	/**
	 * 获取角色列表
	 */
	public static function getRoleList($fields = '*', $where = NULL, $page = 1, $rows = 10) {
		$model = SystemRole::find()->select($fields);
		$offset = ($page - 1) * $rows;
		$model->offset($offset)->limit($rows);
		!is_null($where) && $model->where($where);
		return $model->asArray()->all();
	}

	/**
	 * 获取角色数量
	 */
	public static function getRoleCount($where = NULL) {
		$model = SystemRole::find();
		!is_null($where) && $model->where($where);
		return intval($model->count());
	}

	/**
	 * 获得激活状态的角色
	 * @return array
	 */
	public static function getActiveRoles() {
		return SystemRole::find()->select('id,name')->where('`status` = 1')
						->asArray()->all();
	}

	/**
	 * 根据id获得用户信息
	 */
	public static function getRoleById($params = []) {
		$fields = "id,name,status,create_time";
		$conditions = 'id = :id';
		$bind_params = [':id' => $params['id']];

		return SystemRole::find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
	}

	/**
	 * 更新角色信息
	 */
	public static function updateRole($id, $post) {
		$columns = [
			'name' => $post['name'],
			'status' => $post['status'],
			'update_by' => getUserId(),
			'update_time' => time()
		];
		$userModel = new SystemRole();
		$one = $userModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 添加角色
	 */
	public static function addRole($post) {
		$columns = [
			'name' => $post['name'],
			'status' => $post['status'],
			'create_by' => getUserId(),
			'create_time' => time()
		];
		$roleModel = new SystemRole();
		$roleModel->setAttributes($columns);
		return $roleModel->insert();
	}

	/**
	 * 启用
	 */
	public static function resume($id) {
		$columns = [
			'status' => 1
		];
		$menuModel = new SystemRole();
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 禁用
	 */
	public static function forbid($id) {
		$menuModel = new SystemRole();
		$columns = [
			'status' => 0
		];
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 删除
	 */
	public static function delRole($id) {
		$model = SystemRole::findOne($id);
		if (empty($model)) {
			return false;
		}
		return $model->delete();
	}

}
