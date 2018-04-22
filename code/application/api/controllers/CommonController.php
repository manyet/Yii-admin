<?php

namespace api\controllers;

/**
 * Site controller
 */
class CommonController extends ApiController {

	public $validate_on = false;

	/**
	 * 默认首页
	 */
	public function actionIndex() {
		echo '请通过接口调用';
	}

	/**
	 * 错误页面提示
	 */
	public function actionError() {
		switch (\Yii::$app->errorHandler->exception->statusCode) {
			case 404:
				$message = '接口不存在';
				break;
			case 500:
				$message = '内部错误';
				break;
			default:
				$message = '网络错误';
		}
		$this->error(10002, $message);
	}

}
