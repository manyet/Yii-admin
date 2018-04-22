<?php

namespace admin\services;

class PageService {

	public static function getRows() {
		return \Yii::$app->request->get('rows', isset($_COOKIE['rows']) && intval($_COOKIE['rows']) !== 0 ? $_COOKIE['rows'] : get_system_config('LIST_ROWS'));
	}

}
