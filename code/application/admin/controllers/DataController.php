<?php

namespace admin\controllers;

use common\models\User;
use common\models\PlatformInfo;
use common\services\PackageService;
use common\controllers\AdminController;

/**
 * 数据展示
 */
class DataController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '数据展示';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	public function actionIndex() {
		$this->layout = 'index';
		$player_count = User::find()->count();
		$bought_count = User::find()->where('rank != 0')->count();
		$data = PlatformInfo::find()->asArray()->one();
		$data['bought_package_count'] = User::find()->where('rank != 0')->count();
		$data['no_package_count'] = $player_count - $bought_count;
		$data['player_count'] = $player_count;
		$data['packages'] = PackageService::getAvailablePackage('package_name,total_sales,level_name');
		return $this->render('index', $data);
	}

}
