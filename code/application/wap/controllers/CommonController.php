<?php

namespace wap\controllers;

use common\controllers\WapController;

/**
 * 公共控制器
 *
 * @date 2016-11-12 13:43:02
 */
class CommonController extends WapController {

	/**
	 * 错误页面提示
	 */
	public function actionError() {
		switch (\Yii::$app->errorHandler->exception->statusCode) {
			case 404:
				$message = \Yii::t('app', 'page_not_found');
				break;
			default:
				$message = \Yii::t('app', 'network_error');
		}
		$this->error($message);
	}

}
