<?php

namespace common\controllers;

use Yii;
use yii\helpers\Url;

/**
 * Wap基础控制器类
 */
class WapController extends BaseController {

	public $layout = 'default';

	public function beforeAction($action) {
		if (!parent::beforeAction($action)) {
			return false;
		}
		Yii::setAlias('@static', '@web/static'); // 静态文件目录
		Yii::setAlias('@js', '@static/js'); // JS文件路径
		Yii::setAlias('@css', '@static/css'); // CSS文件路径
		Yii::setAlias('@img', '@static/img'); // 图片文件路径
		Yii::setAlias('@plug', '@static/plug'); // 插件文件路径
		if (!get_system_config('WEB_SITE_CLOSE')) {
			$this->layout = false;
			exit($this->render('//layouts/close'));
		}
		if (isLogin() && isset($_COOKIE['stay_login'])) {
			Yii::$app->session->setTimeout(3600);
		}
		return true;
	}

	/**
	 * 检查是否已经登陆
	 * @return mixed 登录后返回用户ID，登录前跳转登录页面
	 */
	protected function checkLogin($return_url = NULL) {
		$user_id = getUserId();
		if (!empty($user_id))
			return $user_id;
		/* 跳转登录页面 */
		$url = Url::toRoute(['user/login', 'returnUrl' => urlencode(is_null($return_url) ? Yii::$app->request->getUrl() : $return_url)]);
		if (Yii::$app->request->isAjax) {
			$this->error('请先登录', $url);
		} else {
			header('Location:' . $url);
			exit();
		}
	}

}
