<?php

namespace admin\controllers;

use common\models\CompanyDividend;
use common\controllers\AdminController;

/**
 * 邮件
 */
class InvestmentController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '投资平台';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '列表',
		'change-status' => '改变状态'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '列表'
	];

	protected $_table = 'company_dividend';

	public function beforeList(&$query) {
		\yii\helpers\Url::remember(\yii\helpers\Url::current(), 'investment/index');
		$query->select('id,start_date,interest_rate,old_interest_rate,create_time,name,status,achievement');
	}

	public function beforeDel($id) {
		$info = CompanyDividend::find()->select('status')->where('id = ' . $id)->asArray()->one();
		if ($info ['status'] == 1) {
			$this->error('不能删除已启用的项目');
		}
	}

	public function beforeChangeStatus($id, $status) {
		CompanyDividend::updateAll(['status' => 0]);
	}

	public function actionAdd() {
		$returnUrl = \yii\helpers\Url::previous('investment/index');
		empty($returnUrl) && $returnUrl = \yii\helpers\Url::toRoute('index');
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (empty($post['img_path'])) {
				$this->error('请上传项目图片');
			}
			$model = new CompanyDividend();
			$post['status'] = 0;
			$post['create_time'] = time();
			$model->setAttributes($post);
			if ($model->insert()) {
				$this->success('项目添加成功', $returnUrl);
			} else {
				$this->error('项目添加失败');
			}
		} else {
			$this->layout = 'index';
			return $this->render('form', ['returnUrl' => $returnUrl]);
		}
	}

	public function actionEdit() {
		$returnUrl = \yii\helpers\Url::previous('investment/index');
		empty($returnUrl) && $returnUrl = \yii\helpers\Url::toRoute('index');
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = CompanyDividend::findOne($post['id']);
//			if ($post['status'] != $model->status) {
//				if ($post['status'] == 1) {
//					CompanyDividend::updateAll(['status' => 0]);
//				} else {
//					$this->error('不能禁用该项目');
//				}
//			}
			if (empty($post['img_path'])) {
				$this->error('请上传项目图片');
			}
			$model->setAttributes($post);
			if ($model->update() !== false) {
				$this->success('项目修改成功', $returnUrl);
			} else {
				$this->error('项目修改失败');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$data = CompanyDividend::find()->where('id = ' . $id)->asArray()->one();
			$this->layout = 'index';
			$data['returnUrl'] = $returnUrl;
			return $this->render('form', $data);
		}
	}

}
