<?php

namespace admin\controllers;

use admin\services\SystemRoleService;
use admin\models\SystemRoleAccess;
use admin\services\SystemNodeService;
use admin\services\PageService;
use common\controllers\AdminController;
use admin\widgets\Pager;

/**
 * 角色管理
 */
class RoleController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '角色管理';

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
		'access' => '授权',
		'access-refresh' => '刷新节点'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	public function actionIndex() {
		$this->layout = 'index';
		$rows = PageService::getRows();
		$total = SystemRoleService::getRoleCount(NULL);
		$pageCount = ceil($total / $rows);
		$page = min(\Yii::$app->request->get('page', 1), $pageCount);
		// 计算偏移量
		$list = SystemRoleService::getRoleList('*', NULL, $page, $rows);
		return $this->render('index', ['list' => $list, 'total' => $total, 'pager' => Pager::widget(['total' => $total, 'rows' => $rows])]);
	}

	/**
	 * 角色授权
	 */
	public function actionAccess($id) {
		$this->layout = 'index';
		$this->action_title = '角色授权';
		if (empty($id)) {
			$this->error('非法请求');
		}
		$nodes = (new SystemNodeService())->getAccesses();
		$access = SystemRoleAccess::getAccessByRoles($id);
		return $this->render('access', ['nodes' => $nodes, 'access' => $access]);
	}

	/**
	 * 保存授权
	 */
	public function actionAccessSave() {
		$id = \Yii::$app->request->post('id');
		if (empty($id)) {
			$this->error('非法请求');
		}
		$nodes = \Yii::$app->request->post('nodes');
		// 处理数据批量插入
		$data = [];
		if (!empty($nodes)) {
			foreach ($nodes as $one) {
				$data[] = [$id, $one];
			}
		}
		// 更新权限列表
		$result = SystemRoleAccess::saveAccess($id, $data);
		if ($result) {
			$this->success('授权保存成功', \yii\helpers\Url::toRoute('role/index'));
		} else {
			$this->error('授权保存失败，请稍候重试');
		}
	}

	/**
	 * 刷新权限节点
	 */
	public function actionAccessRefresh() {
		if ((new SystemNodeService())->refresh()) {
			$this->success('权限节点刷新成功');
		} else {
			$this->error('权限节点刷新失败，请稍候重试');
		}
	}

	/**
	 * 新增
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (SystemRoleService::addRole($post)) {
				$this->success('角色新增成功');
			} else {
				$this->error('角色新增失败，请稍候重试');
			}
		} else {
			$this->layout = 'modal';
			return $this->render('form');
		}
	}

	/**
	 * 编辑
	 */
	public function actionEdit() {
		$roleService = new SystemRoleService();
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (SystemRoleService::updateRole($post['id'], $post)) {
				$this->success('角色编辑成功');
			} else {
				$this->error('角色编辑失败，请稍候重试');
			}
		} else {
			$result = SystemRoleService::getRoleById(['id' => \Yii::$app->request->get('id')]);
			$this->layout = 'modal';
			return $this->render('form', $result);
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
				$result = SystemRoleService::resume($id);
				$text = '启用';
			} else {
				$result = SystemRoleService::forbid($id);
				$text = '禁用';
			}
			if ($result !== false) {
				$this->success("角色{$text}成功");
			} else {
				$this->error("角色{$text}失败，请稍后再试");
			}
		} else {
			$this->error('不支持该请求方式');
		}
	}

	/**
	 * 删除菜单
	 */
	public function actionDel() {
		if (SystemRoleService::delRole(\Yii::$app->request->post('id'))) {
			$this->success('角色删除成功');
		} else {
			$this->error('角色删除失败，请稍后再试');
		}
	}

}
