<?php

namespace wap\widgets;

use Yii;

/**
 * 前端公用JS
 */
class SeaJs extends \yii\base\Widget {

	public $params = array();

	public function run() {
		$js_path = Yii::getAlias('@js');
		$date = date('Ymd');
		$text = <<<TEXT
<script src="$js_path/sea.js"></script>
<script src="$js_path/config.js?v=$date"></script>
TEXT;
		return $text;
	}

}
