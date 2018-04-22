<?php

namespace admin\controllers;

use Yii;
use admin\services\FeaturesService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class FeaturesController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '功能介绍';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'add' => '添加编辑页',
		'addlist' => '添加',
		'addlist' => '编辑',
	];

	/**
	 * 新增页面展示
	 */
	public function actionAdd() {
		$this->layout = 'index';

		$post['id'] = 1;
		$userService = new FeaturesService();
		$list = $userService->findFeatures($post);
		$result = $list ? $list : [];
		return $this->render('add', $result);
	}

	/**
	 * 新增广告and修改
	 */
	public function actionAddlist() {
		$post = Yii::$app->request->post();
		if (isset($post['features_open1'])) {
			$post['features_open1'] = 1;
		} else {
			$post['features_open1'] = 0;
		}if (isset($post['features_open2'])) {
			$post['features_open2'] = 1;
		} else {
			$post['features_open2'] = 0;
		}if (isset($post['features_open3'])) {
			$post['features_open3'] = 1;
		} else {
			$post['features_open3'] = 0;
		}if (isset($post['features_open4'])) {
			$post['features_open4'] = 1;
		} else {
			$post['features_open4'] = 0;
		}if (isset($post['features_open5'])) {
			$post['features_open5'] = 1;
		} else {
			$post['features_open5'] = 0;
		}if (isset($post['features_open6'])) {
			$post['features_open6'] = 1;
		} else {
			$post['features_open6'] = 0;
		}
		if (!empty($post['id'])) {
			$model = new \admin\models\Features();
			$one = $model->findOne($post['id']);
			$one->setAttributes($post);

			if ($one->validate()) {
				$result = $one->update();
				if ($result !== false) {
					\common\services\CommonService::refreshFeatures('pc');
					\common\services\CommonService::refreshFeatures('wap');
					$this->success('更新发布成功');
				} else {
					$this->error('更新发布失败，请稍候重试');
				}
			} else {
				//获得第一条错误
				$this->error(current($one->getFirstErrors()));
			}
		} else {
			$userService = new FeaturesService();
			if ($userService->addFeatures($post) === true) {
				\common\services\CommonService::refreshFeatures('pc');
				\common\services\CommonService::refreshFeatures('wap');
				$this->success('更新发布成功');
			} else {
				$this->error('更新发布失败，请稍候重试');
			}
		}
	}

}
