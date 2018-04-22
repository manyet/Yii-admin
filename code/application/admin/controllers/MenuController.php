<?php

namespace admin\controllers;

use admin\services\SystemMenuService;
use admin\services\SystemNodeService;
use common\controllers\AdminController;

/**
 * 菜单管理
 */
class MenuController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '菜单管理';

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
		'save-order' => '排序',
		'refresh' => '刷新缓存',
		'refresh-node' => '刷新选择器'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	/**
	 * 菜单管理
	 * @return string
	 */
	public function actionIndex() {
		$result = SystemMenuService::getMenuList();
		$this->layout = 'index';
		return $this->render('index', ['list' => getSelectTree($result)]);
	}

	/**
	 * 选择菜单图标
	 */
	public function actionIcon() {
		return $this->render('icon');
	}

	/**
	 * 新增
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (SystemMenuService::addMenu($post)) {
				$this->_deleteMenuCache();
				$this->success('菜单新增成功');
			} else {
				$this->error('菜单新增失败，请稍后重试');
			}
		} else {
			$this->layout = 'modal';
			$nodes = (new SystemNodeService())->getMenus();
			return $this->render('form', ['nodes' => $nodes]);
		}
	}

	/**
	 * 编辑
	 */
	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (SystemMenuService::updateMenuInfo($post['id'], $post)) {
				$this->_deleteMenuCache();
				$this->success('菜单编辑成功');
			} else {
				$this->error('菜单编辑失败，请稍后重试');
			}
		} else {
			$result = SystemMenuService::getMenuById(\Yii::$app->request->get('id'));
			$this->layout = 'modal';
			$nodes = (new SystemNodeService())->getMenus();
			$result['nodes'] = $nodes;
			return $this->render('form', $result);
		}
	}

	public function actionRefresh() {
		$this->_deleteMenuCache();
		$this->success('菜单缓存更新成功');
	}

	public function actionRefreshNode() {
		$service = new SystemNodeService();
		if ($service->refresh(2)) {
			$data = [];
			$returnNodes = \Yii::$app->request->get('returnNodes');
			if (!empty($returnNodes)) {
				$data['nodes'] = $service->getMenus();
			}
			$this->success('菜单选择器更新成功', '', $data);
		} else {
			$this->error('菜单选择器更新失败');
		}
	}

	/**
	 * 删除菜单
	 */
	public function actionDel() {
		if (SystemMenuService::delMenu(\Yii::$app->request->post('id'))) {
			$this->_deleteMenuCache();
			$this->success('菜单删除成功');
		} else {
			$this->error('菜单删除失败，请稍后再试');
		}
	}

	/**
	 * 加载菜单
	 */
	public function actionLoadMenu() {
		$menus = SystemMenuService::getMenuList('id,name,parent_id');
		$select_tree = getSelectTree($menus);
		$this->ajaxReturn($select_tree, 'JSON');
	}

	public function actionSaveOrder() {
		if (SystemMenuService::sortMenu(\Yii::$app->request->post('sort'))) {
			$this->_deleteMenuCache();
			$this->success('菜单排序成功');
		} else {
			$this->error('菜单排序失败，请稍候重试');
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
				$result = SystemMenuService::resume($id);
				$text = '启用';
			} else {
				$result = SystemMenuService::forbid($id);
				$text = '禁用';
			}
			if ($result !== false) {
				$this->_deleteMenuCache();
				$this->success("菜单{$text}成功");
			} else {
				$this->error("菜单{$text}失败，请稍后再试");
			}
		} else {
			$this->error('不支持该请求方式');
		}
	}

	/**
	 * 清除菜单缓存
	 */
	private function _deleteMenuCache() {
		SystemMenuService::refresh();
	}

}
