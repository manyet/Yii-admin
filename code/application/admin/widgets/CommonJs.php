<?php

namespace admin\widgets;

/**
 * 后端公用JS
 */
class CommonJs extends \yii\base\Widget {

	public $params = array();

	public function run() {
		$module = \Yii::$app->controller->module->id;
		$controller = \Yii::$app->controller->id;
		$action = \Yii::$app->controller->action->id;
		return <<<TEXT
<script>window.module={"name":"$module","controller":"$controller","action":"$action"};</script>
TEXT;
	}

}
