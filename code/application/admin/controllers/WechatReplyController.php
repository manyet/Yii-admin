<?php

namespace admin\controllers;

use common\controllers\AdminController;
use common\services\WechatKeywordService;

/**
 * 微信自动回复
 */
class WechatReplyController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '微信自动回复';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'subscribe' => '关注回复'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'subscribe' => '关注回复'
	];

	/**
	 * 关注回复
	 */
	public function actionSubscribe() {
		$this->layout = 'index';
		$data = WechatKeywordService::getByKey('subscribe');
		return $this->render('subscribe', empty($data) ? [] : $data);
	}

	/**
	 * 保存配置
	 */
	public function actionSubscribeSubmit() {
		if (\Yii::$app->request->isPost) {
			$data = \Yii::$app->request->post();
			if (empty($data['id'])) {
				$result = WechatKeywordService::add($data);
			} else {
				$keys = $data['keys'];
				unset($data['keys']);
				$result = WechatKeywordService::update($keys, $data);
			}
			if ($result) {
				$this->success('保存成功');
			} else {
				$this->error('保存失败');
			}
		} else {
			$this->error('非法请求');
		}
	}

}
