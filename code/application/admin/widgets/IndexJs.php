<?php

namespace admin\widgets;

/**
 * 后端公用JS
 */
class IndexJs extends \yii\base\Widget {

	public $params = array();

	public function run() {
		$url_suffix = \Yii::$app->urlManager->suffix;
		$web_root = \Yii::getAlias('@web');
		$script_url = \Yii::$app->request->getScriptUrl();
		if (\Yii::$app->urlManager->showScriptName === false) {
			$script_url = substr($script_url, 0, strrpos($script_url, '/'));
		}
		$csrf_param = \Yii::$app->request->csrfParam;
		$csrf_token = \Yii::$app->request->csrfToken;
		return <<<TEXT
<script>function getCsrf(){return {name:'$csrf_param',value:'$csrf_token'};}with(window){webRoot="$web_root/";appPath="$script_url/";suffix="$url_suffix";}</script>
TEXT;
	}

}
