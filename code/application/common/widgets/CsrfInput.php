<?php

namespace common\widgets;

/**
 * 后端公用JS
 */
class CsrfInput extends \yii\base\Widget {

	public $params = array();

	public function run() {
		$csrf_param = \Yii::$app->request->csrfParam;
		$csrf_token = \Yii::$app->request->getCsrfToken();
		return <<<TEXT
<input name="$csrf_param" value="$csrf_token" type="hidden"/>
TEXT;
	}

}
