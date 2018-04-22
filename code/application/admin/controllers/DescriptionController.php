<?php

namespace admin\controllers;

use common\models\Description;
use common\services\DescriptionService;
use common\controllers\AdminController;

/**
 * 角色管理
 */
class DescriptionController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '角色管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'edit' => '编辑',
		'refresh' => '更新缓存'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	protected $_table = 'description';

	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = Description::findOne($post['id']);
			$model->setAttributes($post);
			$model->setAttribute('update_by', getUserId());
			$model->setAttribute('update_time', time());
			if ($model->update() !== false) {
				$this->success('说明更新成功');
			} else {
				$this->error('说明更新失败');
			}
		} else {
			$this->layout = 'modal';
			$id = \Yii::$app->request->get('id');
			$data = Description::find()->select('id,name,content,eng_content')->where('id = :id', ['id' => $id])->asArray()->one();
			return $this->render('form', $data);
		}
	}

	public function actionRefresh() {
		DescriptionService::refresh();
		$this->success('说明更新成功');
	}

}
