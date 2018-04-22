<?php

namespace admin\controllers;

use common\controllers\AdminController;
use admin\services\TemplateService;

class TemplateController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '消息模板';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
//		'add' => '新增',
		'edit' => '编辑'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];
	public $_table = 'message_template';

	public function beforeList(&$query) {
		$query->select('id,key,title,is_send_mobile,is_send_message,is_send_system');
		$this->layout = 'index';
	}

	/**
	 * 新增
	 */
	public function actionAdd() {
		return $this->form();
	}

	/**
	 * 编辑
	 */
	public function actionEdit() {
		return $this->form();
	}

	/**
	 * @return string
	 */
	public function form($tpl = 'form') {
		$templateService = new TemplateService();
		if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
			$postParams = \Yii::$app->request->post();
			$params = array();
			$params['title'] = $postParams['title'];
			if (array_key_exists('params', $postParams)) {
				$params['params'] = $postParams['params'];
			}
			if (array_key_exists('key', $postParams)) {
				$params['key'] = $postParams['key'];
			}
			$params['mobile_content'] = $postParams['mobile_content'];
			$params['message_content'] = $postParams['message_content'];
			$params['system_content'] = $postParams['system_content'];
			$params['description'] = $postParams['description'];
			$params['is_send_mobile'] = intval(isset($postParams['is_send_mobile']));
			$params['is_send_message'] = intval(isset($postParams['is_send_message']));
			$params['is_send_system'] = intval(isset($postParams['is_send_system']));
			if (empty($postParams['id'])) {
				$result = $templateService->addTemplate($params);
				if ($result) {
					$this->success('消息模板添加成功');
				} else {
					$this->error('消息模板添加失败');
				}
			} else {
				$condition['id'] = $postParams['id'];
				$result = $templateService->updateTemplate($condition, $params);
				if ($result) {
					$this->success('消息模板编辑成功');
				} else {
					$this->error('消息模板编辑失败');
				}
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$this->layout = 'modal';
			if (empty($id)) {
				return $this->render($tpl);
			} else {
				$result = $templateService->getInfo($id);
				return $this->render($tpl, $result);
			}
		}
	}

}
