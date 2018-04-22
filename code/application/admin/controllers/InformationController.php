<?php

namespace admin\controllers;

use common\models\Information;
use common\controllers\AdminController;

/**
 * 资讯管理
 */
class InformationController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '资讯管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'add' => '添加',
		'edit' => '编辑',
		'del' => '删除'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];
	protected $_table = 'information';

	public function beforeList(&$query) {
		$getParams = \Yii::$app->request->get();
		$keyword = array_key_exists('kw', $getParams) && $getParams['kw'] !== '' ? $getParams['kw'] : '';
		$query->select('a.*');
		if ($keyword !== '') {
			$query->where([
				'or',
				['like', 'a.title', $keyword],
				['like', 'a.author', $keyword],
			]);
		}
	}

	/**
	 * 添加
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = Information::findOne($post['id']);
			$model->setAttributes($post);
			$model->setAttribute('create_by', getUserId());
			$model->setAttribute('create_time', time());
			if ($model->insert()) {
				$this->success('资讯添加成功');
			} else {
				$this->error('资讯添加失败');
			}
		} else {
			$this->layout = 'index';
			return $this->render('form');
		}
	}

	/**
	 * 编辑
	 */
	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = Information::findOne($post['id']);
			$model->setAttributes($post);
			$model->setAttribute('update_time', time());
			if ($model->update() !== false) {
				$this->success('资讯编辑成功');
			} else {
				$this->error('资讯编辑失败');
			}
		} else {
			$result = Information::find()->where('id = :id', ['id' => \Yii::$app->request->get('id')])->asArray()->one();
			$this->layout = 'index';
			return $this->render('form', $result);
		}
	}

}
