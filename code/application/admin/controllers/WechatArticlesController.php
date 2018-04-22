<?php

namespace admin\controllers;

use common\controllers\AdminController;
use common\services\WechatArticleService;
use common\services\WechatArticlesService;

/**
 * 微信图文管理
 */
class WechatArticlesController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '微信多图文管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '列表',
		'add' => '添加',
		'edit' => '编辑',
		'del' => '删除',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

	protected $_table = 'wechat_articles';

	public function actionAdd() {
		$this->layout = 'index';
		return $this->render('form');
	}

	public function actionEdit() {
		$this->layout = 'index';
		$id = \Yii::$app->request->get('id');
		if (empty($id)) {
			$this->error('多图文不存在');
		}
		$info = WechatArticlesService::getDetailById($id, 'id,title,local_url');
		if (empty($info)) {
			$this->error('多图文不存在');
		}
		return $this->render('form', $info);
	}

	/**
	 * 保存
	 */
	public function actionSave() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (empty($post['id'])) {
				if (WechatArticlesService::addArticles($post)) {
					$this->success('多图文添加成功');
				} else {
					$this->error('多图文添加失败');
				}
			} else {
				$id = $post['id'];
				unset($post['id']);
				if (WechatArticlesService::updateArticles($id, $post)) {
					$this->success('多图文编辑成功');
				} else {
					$this->error('多图文编辑失败');
				}
			}
		} else {
			$this->error('非法请求');
		}
	}

	public function actionSearch() {
		$keyword = \Yii::$app->request->get('kw', '');
		$list = WechatArticleService::search($keyword, 'id,title,local_url');
		$this->ajaxReturn($list);
	}

	public function actionChoose() {
		$id = \Yii::$app->request->get('id', '');
		$data = [];
		$data['list'] = WechatArticlesService::getArticlesList();
		return $this->render('choose', $data);
	}

}
