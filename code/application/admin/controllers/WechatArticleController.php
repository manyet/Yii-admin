<?php

namespace admin\controllers;

use common\controllers\AdminController;
use common\services\WechatArticleService;

/**
 * 微信文章管理
 */
class WechatArticleController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '微信文章管理';

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

	protected $_table = 'wechat_article';

	public function actionAdd() {
		$this->layout = 'index';
		return $this->render('form');
	}

	public function actionEdit() {
		$this->layout = 'index';
		$id = \Yii::$app->request->get('id');
		if (empty($id)) {
			$this->error('文章不存在');
		}
		$info = WechatArticleService::getArticleById($id);
		if (empty($info)) {
			$this->error('文章不存在');
		}
		return $this->render('form', $info);
	}

	/**
	 * 保存
	 */
	public function actionSave() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (empty($post['local_url'])) {
				$this->error('请上传封面图片');
			}
			if (empty($post['id'])) {
				if (WechatArticleService::addArticle($post)) {
					$this->success('文章添加成功');
				} else {
					$this->error('文章添加失败');
				}
			} else {
				$id = $post['id'];
				unset($post['id']);
				if (WechatArticleService::updateArticle($id, $post)) {
					$this->success('文章编辑成功');
				} else {
					$this->error('文章编辑失败');
				}
			}
		} else {
			$this->error('非法请求');
		}
	}

}
