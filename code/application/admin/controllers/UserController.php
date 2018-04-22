<?php

namespace admin\controllers;

use admin\models\SystemUser;
use admin\services\SystemUserService;
use admin\services\SystemRoleService;
use admin\services\PageService;
use common\controllers\AdminController;
use admin\widgets\Pager;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class UserController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '系统用户';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'add' => '添加',
		'edit' => '编辑',
		'del' => '删除',
		'change-status' => '更改状态',
		'update-pwd' => '修改密码'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	public function actionIndex() {
		$where = NULL;
		if (($key = \Yii::$app->request->get('key', '')) != '') {
			$where = "username LIKE '%$key%' OR realname LIKE '%$key%'";
		}
		$total = SystemUserService::getUserCount();
		$rows = PageService::getRows();
		$pageCount = ceil($total / $rows);
		$page = min(\Yii::$app->request->get('page', 1), $pageCount);
		$list = SystemUserService::getUserList($where, $page, $rows);
		$this->layout = 'index';
		return $this->render('index', ['list' => $list, 'total' => $total, 'pager' => Pager::widget(['total' => $total, 'rows' => $rows])]);
	}

	/**
	 * 新增
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$userService = new SystemUserService();
			$exist_res = $userService->existAdminUser($post['username']);
			if ($exist_res) {
				$this->error('用户名已经存在');
			}
			$post['role_id'] = isset($post['role_id']) && is_array($post['role_id']) ? join(',', $post['role_id']) : '';
//			$userModel = new SystemUser();
//			$userModel->attributes = $post;
//			if (!$userModel->validate()) {
//				$this->error(current($userModel->getFirstErrors()));
//			}

			if ($userService->addAdminUser($post)) {
				$this->success('用户新增成功');
			} else {
				$this->error('用户新增失败，请稍候重试');
			}
		} else {
			$this->layout = 'modal';
			$result = [];
			$result['roles'] = SystemRoleService::getActiveRoles();
			return $this->render('form', $result);
		}
	}

	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$post['role_id'] = isset($post['role_id']) && is_array($post['role_id']) ? join(',', $post['role_id']) : '';

			$model = new SystemUser();
//			//验证字段  验证器  参数
//			$dynamicModel->addRule('id', 'required', ['message' => 'id不能为空！'])
//					->addRule('realname', 'required', ['message' => '真实姓名不能为空！'])
//					->addRule('role_id', 'required', ['message' => '角色不能为空！'])
//					->addRule('status', 'required', ['message' => '状态不能为空！']);
			$one = $model->findOne($post['id']);
			$one->setAttributes($post);

			if ($one->validate()) {
				$result = $one->update();
				$result !== false ? $this->success('用户编辑成功') : $this->error('用户编辑失败，请稍候重试');
			} else {
				//获得第一条错误
				$this->error(current($one->getFirstErrors()));
			}
		} else {
			$userService = new SystemUserService();
			$result = $userService->getInfoById(['id' => \Yii::$app->request->get('id')]);
			$result['roles'] = SystemRoleService::getActiveRoles();
			$this->layout = 'modal';
			return $this->render('form', $result);
		}
	}

	/**
	 * 修改密码
	 */
	public function actionUpdatePwd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();

			if (!is_str_len($post['pwd'])) {
				$this->error('请输入正确的密码');
			}
			$userService = new SystemUserService();
			$result = $userService->updateAdminPwd($post);

			if ($result !== false) {
				$this->success('密码修改成功');
			} else {
				$this->error('密码修改失败，请稍候重试');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$userService = new SystemUserService();
			$result = $userService->getInfoById(['id' => $id]);
			$this->layout = 'modal';
			return $this->render('update-pwd', $result);
		}
	}

	/**
	 * 修改个人密码
	 */
	public function actionMyPwd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$post['id'] = getUserId();

			if (!is_str_len($post['pwd'])) {
				$this->error('请输入正确的密码');
			}
			$userService = new SystemUserService();
			$result = $userService->updateAdminPwd($post);

			if ($result !== false) {
				session('user', NULL);
				$this->success('密码修改成功');
			} else {
				$this->error('密码修改失败，请稍候重试');
			}
		} else {
			$userService = new SystemUserService();
			$result = $userService->getInfoById(['id' => getUserId()]);
			$this->layout = 'modal';
			return $this->render('my-pwd', $result);
		}
	}

	/**
	 * 修改个人资料
	 */
	public function actionMyInfo() {
		$table_name = SystemUser::tableName();
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (\Yii::$app->db->createCommand()->update($table_name, [
						'avatar' => $post['avatar']
							], 'id = ' . getUserId())->execute() !== false) {
				// 更新头像缓存
				$user = session('user');
				$user['avatar'] = $post['avatar'];
				session('user', $user);

				$this->success('用户信息修改成功');
			} else {
				$this->error('用户信息修改失败，请稍候重试');
			}
		} else {
			$info = \Yii::$app->db->createCommand('SELECT avatar,realname,username FROM ' . $table_name . ' WHERE id = ' . getUserId())->queryOne();
			$this->layout = 'modal';
			return $this->render('my-info', $info);
		}
	}

	/**
	 * 删除菜单
	 */
	public function actionDel() {
		$id = \Yii::$app->request->post('id');
		$rbac = new \library\RBAC($id);
		if ($rbac->isAdministrator()) {
			$this->error('不能删除系统管理员');
		} else if (getUserId() == $id) {
			$this->error('不能删除自己');
		}
		if (SystemUserService::delUser($id)) {
			$this->success('用户删除成功');
		} else {
			$this->error('用户删除失败，请稍后再试');
		}
	}

	public function actionChangeStatus() {
		if (\Yii::$app->request->isPost) {
			$id = \Yii::$app->request->post('id', '');
			if ($id === '' || $id == 0) {
				$this->error('参数传入缺失');
			}
			$status = \Yii::$app->request->post('status');

			if ($status == 1) {
				$result = SystemUserService::resume($id);
				$text = '启用';
			} else {
				$result = SystemUserService::forbid($id);
				$text = '禁用';
			}
			if ($result !== false) {
				$this->success("用户{$text}成功");
			} else {
				$this->error("用户{$text}失败，请稍后再试");
			}
		} else {
			$this->error('不支持该请求方式');
		}
	}

}
