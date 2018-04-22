<?php

namespace admin\controllers;

/**
 * 公共控制器
 */
class CommonController extends \common\controllers\BaseController {

	public $layout = false;

	/**
	 * 错误页面提示
	 */
	public function actionError() {
		$status_code = \Yii::$app->errorHandler->exception->statusCode;
		switch ($status_code) {
			case 404:
				$message = '页面没找到';
				break;
			case 500:
				$message = '服务器内部错误';
				break;
			default:
				$message = '网络错误';
		}
		return $this->render(empty($status_code) || !file_exists(\Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . $status_code . '.php') ? 'error' : $status_code, ['message' => $message, 'name' => $message]);
	}

}
