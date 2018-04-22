<?php

namespace admin\services;

use admin\models\SystemUser;
use admin\models\SystemRole;
use admin\models\LoginModel;

class SystemUserService {

	public $errorMessage = '';
	public $errorCode = 0;
	public $scenario = NULL;

	public function __construct($scenario = NULL) {
		$this->scenario = $scenario;
	}

	public function checkAdmin($params) {
		$loginModel = new LoginModel();
		!is_null($this->scenario) && $loginModel->setScenario($this->scenario);
		$loginModel->setAttributes($params);
		if ($loginModel->validate()) {
			$adminModel = new SystemUser();
			$fields = "id,username,pwd,role_id,status,password_hash,realname,avatar,create_time";
			$conditions = "username = :username AND is_deleted = 0";
			$bind_params = [':username' => $params['username']];
			$result = $adminModel->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
			if (empty($result) || $result['pwd'] !== md5($params['password'] . $result['password_hash'])) {
				$this->errorMessage = '用户名或密码错误';
				$this->errorCode = 20002;
				return false;
			} else if (intval($result['status']) !== 1) {
				$this->errorMessage = '您的账户已被停用';
				$this->errorCode = 20003;
				return false;
			} else {
				unset($result['password_hash'], $result['status'], $result['pwd']);
				return $result;
			}
		} else {
			$this->errorMessage = $loginModel->getFirstErrorMessage();
			$this->errorCode = 20001;
			return false;
		}
	}

	/**
	 * 根据id获得用户信息
	 */
	public function getInfoById($params = []) {
		$fields = "id,username,avatar,role_id,status,realname,create_time";
		$conditions = 'id = :id';
		$bind_params = [':id' => $params['id']];

		$userModel = new SystemUser();
		return $userModel->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
	}

	/**
	 * 更新用户信息
	 */
	public function updateInfo($post) {
		$columns = [
			'role_id' => $post['role_id'],
			'status' => $post['status'],
			'realname' => $post['realname'],
			'update_by' => getUserId(),
			'update_time' => time()
		];
		$userModel = new SystemUser();
		$one = $userModel->findOne($post['id']);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 添加系统用户
	 */
	public function addAdminUser($post) {
		$password_hash = $this->getPasswordHash();

		$columns = [
			'username' => $post['username'],
			'pwd' => md5($post['pwd'] . $password_hash),
			'password_hash' => $password_hash,
			'role_id' => $post['role_id'],
			'status' => $post['status'],
			'realname' => $post['realname'],
			'create_by' => getUserId(),
			'create_time' => time()
		];

		$userModel = new SystemUser();
		$userModel->setAttributes($columns);
		return $userModel->insert();
	}

	/**
	 * 检测用户名是否存在
	 * @param $username
	 */
	public function existAdminUser($username) {
		$conditions = "username = :username";
		$bind_params = [':username' => $username];
		$userModel = new SystemUser();
		$info = $userModel->find()->select('id')->where($conditions, $bind_params)->asArray()->one();
		return !empty($info);
	}

	public function getPasswordHash() {
		return getRandomString(6);
	}

	/**
	 * 修改系统用户密码
	 */
	public function updateAdminPwd($post) {
		$password_hash = $this->getPasswordHash();
		if (empty($post['pwd'])) {
			return false;
		}
		$columns = [
			'pwd' => md5($post['pwd'] . $password_hash),
			'password_hash' => $password_hash,
		];
		$userModel = new SystemUser();
		$one = $userModel->findOne($post['id']);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	public static function getUserList($where = NULL, $page = 1, $rows = 10) {
		$model = SystemUser::find()->alias('a')->orderBy('a.id DESC');
		$offset = ($page - 1) * $rows;
		$model->offset($offset)->limit($rows);
		$table_name = SystemRole::tableName();
		!is_null($where) && $model->where($where);
		$model->andWhere(['is_deleted' => 0]);
		return $model->select("a.*,(SELECT GROUP_CONCAT(`name`) FROM $table_name WHERE FIND_IN_SET(id,a.role_id)) AS `role`")
//            ->leftJoin('{{%role}} r', 'a.role_id = r.id')
						->asArray()->all();
	}

	/**
	 * 获取用户数量
	 */
	public static function getUserCount($where = NULL) {
		$model = SystemUser::find();
		!is_null($where) && $model->where($where);
		$model->andWhere(['is_deleted' => 0]);
		return intval($model->count());
	}

	/**
	 * 删除
	 */
	public static function delUser($id) {
		$model = SystemUser::findOne($id);
		if (empty($model)) {
			return false;
		}
		$model->setAttribute('is_deleted', 1);
		return $model->update() !== false;
	}

	/**
	 * 启用
	 */
	public static function resume($id) {
		$columns = [
			'status' => 1
		];
		$menuModel = new SystemUser();
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 禁用
	 */
	public static function forbid($id) {
		$menuModel = new SystemUser();
		$columns = [
			'status' => 0
		];
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

}
