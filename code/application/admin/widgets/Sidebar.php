<?php

namespace admin\widgets;

use yii\base\Widget;

/**
 * 左侧菜单挂件
 */
class Sidebar extends Widget {

	public $menus;

	public function run() {
		$data = array();
		$data['menus'] = $this->menus;
		return $this->render('//layouts/sidebar', $data);
	}

}
