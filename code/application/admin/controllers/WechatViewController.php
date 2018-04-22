<?php

namespace admin\controllers;

use common\services\WechatArticlesService;
use common\controllers\AdminController;

/**
 * 微信预览
 */
class WechatViewController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '微信预览';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'text' => '文本回复',
		'news' => '图文回复',
	];

	public $layout = 'wechat-view';

	/**
	 * 文字回复
	 */
	public function actionText() {
		$content = \Yii::$app->request->get('content', '');
		return $this->render('text', [
			'content' => $content
		]);
	}

	/**
	 * 回复图文
	 */
	public function actionNews() {
		$id = \Yii::$app->request->get('id');
		$info = WechatArticlesService::getDetailById($id);
		return $this->render('news', empty($info) ? [] : $info);
	}

	/**
	 * 回复语音
	 */
	public function actionVoice() {
		return 'voice';
	}

	/**
	 * 回复视频
	 */
	public function actionVideo() {
		return 'video';
	}

	/**
	 * 回复图片
	 */
	public function actionImage() {
		return 'image';
	}


}
