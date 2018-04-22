<?php

namespace admin\controllers;

use common\services\WechatConfigService;
use common\controllers\AdminController;

/**
 * 公众号配置
 */
class WechatConfigController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '公众号配置';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '列表',
		'add' => '添加',
		'edit' => '编辑',
		'del' => '删除',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '列表'
	];

	protected $_table = 'wechat_config';

	/**
	 * 添加公众号
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$config = \Yii::$app->request->post();
			if (WechatConfigService::addConfig($config)) {
				$this->success('公众号添加成功');
			} else {
				$this->error('公众号添加失败');
			}
		} else {
			$this->layout = 'modal';
			return $this->render('form');
		}
	}

	/**
	 * 编辑公众号配置
	 */
	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$config = \Yii::$app->request->post();
			$id = $config['id'];
			unset($config['id']);
			if (WechatConfigService::saveConfig($id, $config)) {
				$this->success('公众号编辑成功');
			} else {
				$this->error('公众号编辑失败');
			}
		} else {
			$this->layout = 'modal';
			$id = \Yii::$app->request->get('id');
			$info = WechatConfigService::getConfigById($id);
			return $this->render('form', $info);
		}
	}

	/**
	 * 刷新缓存
	 */
	public function actionRefresh() {
		if (SystemConfigService::refresh()) {
			$this->success('缓存刷新成功');
		} else {
			$this->error('缓存刷新失败');
		}
	}

}
