<?php

namespace admin\controllers;

use common\models\NoticeCompany;
use common\controllers\AdminController;

class FeedbackController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '业务反馈';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'detail' => '查看详情',
		'del' => '删除'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	public $_table = 'notice_company';

	public function beforeList(&$query) {
		$query->select('id,content,create_time')->orderBy('id DESC');
		$start_date = \Yii::$app->request->get('start', '');
        $end_date = \Yii::$app->request->get('end', '');
        if ($start_date !== '') {
            $query->andWhere(['>=', 'a.create_time', strtotime($start_date)]);
        }
		if ($end_date !== '') {
            $query->andWhere(['<=', 'a.create_time', strtotime($end_date)]);
        }
		$this->layout = 'index';
	}

	/**
	 * 新增
	 */
	public function actionDetail($id) {
		$this->layout = 'modal';
		$info = NoticeCompany::find()->where('id = :id', ['id' => $id])->asArray()->one();
		return $this->render('detail', $info);
	}

}
