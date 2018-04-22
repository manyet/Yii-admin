<?php

namespace library;

/**
 * 基于角色的访问控制
 */
class RBAC {

	/**
	 * 用户表名
	 * @var string
	 */
	public $table_auth_user = 'admin';

	/**
	 * 用户表主键名
	 * @var string
	 */
	public $pk_auth_user = 'id';

	/**
	 * 角色列名
	 * @var string
	 */
	public $field_auth_group = 'role_id';

	/**
	 * 角色表主键名
	 * @var string
	 */
	public $pk_auth_group = 'id';

	/**
	 * 角色表名
	 * @var string
	 */
	public $table_auth_group = 'role';

	/**
	 * 授权模块表名
	 * @var string
	 */
	public $table_auth_group_access = 'role_access';

	/**
	 * 需要检测权限的用户ID
	 * @var int
	 */
	private $user_id;

	/**
	 * 可用权限列表
	 * @var array
	 */
	public $access_list = array();

	public function __construct($user_id) {
		$this->user_id = $user_id;
	}

	/**
	 * 判断用户有没该模块的权限
	 * @param string|array $path
	 * @return boolean
	 */
	public function checkAuth($path) {
		if ($this->isAdministrator()) {
			return true;
		}
		// 权限存在于权限列表
		if (empty($this->access_list)) {
			$this->access_list = session('access');
		}

//		// 验证权限
//		$result = \Yii::$app->db->createCommand("SELECT COUNT(1) FROM {{%{$this->table_auth_group_access}}} WHERE `path` = '{$path}' AND `{$this->field_auth_group}` = (SELECT {$this->field_auth_group} FROM {{%{$this->table_auth_user}}} WHERE `{$this->pk_auth_user}` = {$this->user_id})")->queryScalar();

		return isset($this->access_list[$path]);
	}

	public function initAccess($access_list) {
		$access_session = [];
		foreach ($access_list as $access) {
			$access_session[$access] = 1;
		}
		session('access', $access_session); // 缓存权限信息
	}

	/**
	 * 判断用户是否超级管理员
	 * @return boolean
	 */
	public function isAdministrator() {
		return intval($this->user_id) === 1;
	}

}
