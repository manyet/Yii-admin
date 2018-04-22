<?php

namespace admin\controllers;

use admin\services\SystemConfigService;
use common\controllers\AdminController;

/**
 * 角色管理
 */
class ConfigController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '参数配置';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '全局参数',
		'edit' => '编辑全局参数',
		'refresh' => '刷新配置缓存',
		'mail' => '邮件配置'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '全局参数',
		'mail' => '邮件配置'
	];

	/**
	 * 首页
	 */
	public function actionIndex() {
		$type = \Yii::$app->request->get('type', '1');
		$list = SystemConfigService::getConfigList($type, '`name`,`type`,title,value,`group`,extra,remark,required,pattern,invalid_tip');
		return $this->render('index', [
			'list' => $list,
			'type' => $type,
			'groups' => SystemConfigService::getAllGroup()
		]);
	}

	/**
	 * 保存配置
	 */
	public function actionSave() {
		if (\Yii::$app->request->isPost) {
			$config = \Yii::$app->request->post('config');
			if (SystemConfigService::save($config)) {
				$this->success('配置保存成功');
			} else {
				$this->error('配置保存失败');
			}
		} else {
			$this->error('非法请求');
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

	public function actionMail() {
		if (\Yii::$app->request->post()) {
			$this->success('123');
		} else {
			$this->layout = 'index';
			return $this->render('mail');
		}
	}

}
