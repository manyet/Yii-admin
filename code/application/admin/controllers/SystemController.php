<?php

namespace admin\controllers;

use Yii;
use common\controllers\AdminController;

/**
 * 系统管理
 */
class SystemController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '系统管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '系统信息',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '系统信息'
	];

	public function actionIndex() {
		$this->layout = 'index';
		$dbPath = Yii::$app->db->createCommand('SHOW VARIABLES LIKE \'DATADIR\'')->queryOne();
		if(@ini_get('file_uploads')) {
			$maxUpload = ini_get('upload_max_filesize');
		} else {
			$maxUpload = '<font color="red">不允许上传</font>';
		}
		return $this->render('index', [
			'maxUpload' => $maxUpload,
			'dbPath' => $dbPath['Value'],
			'dbSize' => $this->_mysql_db_size()
		]);
	}

	private function _mysql_db_size() {
		if (!preg_match('/dbname=(.+)($|;)/', Yii::$app->db->dsn, $a)) {
			return 'unknown';
		}
		$sql = 'SHOW TABLE STATUS FROM ' . $a[1];
		$tblPrefix = Yii::$app->db->tablePrefix;
		if ($tblPrefix != null) {
			$sql .= " LIKE '{$tblPrefix}%'";
		}
		$row = Yii::$app->db->createCommand($sql)->queryAll();
		$size = 0;
		foreach ($row as $value) {
			$size += $value["Data_length"] + $value["Index_length"];
		}
		return round(($size / 1048576), 2) . 'M';
	}

}
