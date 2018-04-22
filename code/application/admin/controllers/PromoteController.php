<?php

namespace admin\controllers;

use common\controllers\AdminController;
use common\models\User;

class PromoteController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '直推关系';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '查看列表',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '查看列表'
	];
	public $_table = 'user_promote_record';

	public function beforeList(&$query) {
		$query->select('a.id,pu.uname AS promoter_uname,pu.realname AS promoter_realname,u.identity,u.uname,u.realname,a.create_time')
				->leftJoin(User::tableName(). ' u', 'a.user_id = u.id')
				->leftJoin(User::tableName(). ' pu', 'a.promoter_id = pu.id')
				->orderBy('id DESC');
		if (($key = \Yii::$app->request->get('key', '')) != '') {
			$query->andFilterWhere(['or',
				['like', 'u.uname', $key],
				['like', 'u.realname', $key],
			]);
		}
		if (($promoter = \Yii::$app->request->get('promoter', '')) != '') {
			$query->andFilterWhere(['or',
				['like', 'pu.uname', $promoter],
				['like', 'pu.realname', $promoter],
			]);
		}
	}

}
