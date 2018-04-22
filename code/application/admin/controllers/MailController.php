<?php

namespace admin\controllers;

use common\models\MailTemplate;
use common\controllers\AdminController;

/**
 * 邮件
 */
class MailController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '邮件管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '模板列表',
		'edit' => '编辑模板',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '模板列表'
	];

	protected $_table = 'mail_template';

	public function beforeList(&$query) {
		$query->select('id,name,title,eng_title');
	}

	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = MailTemplate::findOne($post['id']);
			$model->setAttributes($post);
			$model->setAttribute('update_by', getUserId());
			$model->setAttribute('update_time', time());
			if ($model->update() === false) {
				$this->error('邮件模板编辑失败');
			} else {
				$this->success('邮件模板编辑成功');
			}
		} else {
			$this->layout = 'index';
			$id = \Yii::$app->request->get('id');
			if (empty($id)) {
				$this->error('模板不存在');
			}
			$data = MailTemplate::find()->where('id = :id', ['id' => $id])->asArray()->one();
			return $this->render('form', ['row' => $data]);
		}
	}

}
