<?php

namespace admin\controllers;

use admin\services\SystemLogService;
use admin\models\SystemUser;
use common\controllers\AdminController;

/**
 * 系统日志
 */
class LogController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '系统日志';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'del' => '删除',
		'del-all' => '清空日志',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	protected $_table = 'system_log';

	public function beforeList(&$query) {
		$query->select('a.*,u.username,u.realname')->orderBy('id DESC')->leftJoin(SystemUser::tableName() . ' u', 'u.id = a.create_by');
		if (($key = \Yii::$app->request->get('kw', '')) != '') {
			$query->andWhere("u.username LIKE '%$key%' OR u.realname LIKE '%$key%' OR a.ip LIKE '%$key%' OR a.isp LIKE '%$key% OR a.title LIKE '%$key%' OR a.content LIKE '%$key%'");
		}
//		if (($ip = \Yii::$app->request->get('ip', '')) != '') {
//			$query->andWhere("a.ip LIKE '%$ip%'");
//		}
//		if (($isp = \Yii::$app->request->get('isp', '')) != '') {
//			$query->andWhere("a.isp LIKE '%$isp%'");
//		}
//		if (($title = \Yii::$app->request->get('title', '')) != '') {
//			$query->andWhere("a.title LIKE '%$title%'");
//		}
		if (($start_date = \Yii::$app->request->get('start_date', '')) != '') {
			$start_date = strtotime($start_date);
			$query->andWhere("a.create_time >= $start_date");
		}
		if (($end_date = \Yii::$app->request->get('end_date', '')) != '') {
			$end_date = strtotime($end_date);
			$query->andWhere("a.create_time <= $end_date");
		}
	}

	/**
	 * 清空日志
	 */
	public function actionDelAll() {
		if (\Yii::$app->request->isPost) {
			if (SystemLogService::delAll()) {
				$this->success('日志清空成功');
			} else {
				$this->error('日志清空失败，请稍后再试');
			}
		}
	}

}
