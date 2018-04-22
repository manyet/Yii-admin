<?php

namespace admin\controllers;

use common\models\CasinoUser;
use admin\services\CasinoService;
use admin\services\SystemLogService;
use common\services\PlatformService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class CasinoController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '娱乐场列表';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'addlist' => '添加',
		'addlist' => '编辑',
		'user' => '人员管理',
		'user-add' => '人员添加',
		'user-edit' => '人员编辑',
		'user-del' => '人员删除',
		'user-change-status' => '改变人员状态',
		'user-password' => '修改人员密码',
		'del' => '删除',
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];
	protected $_table = 'casino';
	protected $status = 0;

	public function beforeList(&$query) {
		\yii\helpers\Url::remember(\yii\helpers\Url::current(), 'casino/index');
		$getParams = \Yii::$app->request->get();
		$keyword = array_key_exists('keyword', $getParams) && $getParams['keyword'] !== '' ? $getParams['keyword'] : '';
		$query->select([]);

		if ($keyword !== '') {
			$query->where([
				'or',
				['like', 'casino_name', $keyword],
			]);
		}
	}

	public function userBeforeList(){

	}

	/**
	 * 人员管理
	 */
	public function actionUser($id) {
		$this->_callback_before_list = 'userBeforeList';
		$where = 'is_deleted = 0 AND casino_id = ' . $id;
		if (($key = \Yii::$app->request->get('key', '')) != '') {
			$where .= " AND uname LIKE '%$key%' OR realname LIKE '%$key%'";
		}
		$returnUrl = \yii\helpers\Url::previous('casino/index');
		empty($returnUrl) && $returnUrl = \yii\helpers\Url::toRoute('index');
		$this->view->params['returnUrl'] = $returnUrl;
		$this->view->params['casino_name'] = \admin\models\Casino::find()->select('casino_name')->where('id = :id', ['id' => $id])->scalar();
		return parent::renderIndex('casino_user', $where, 'user');
	}

	/**
	 * 人员删除
	 */
	public function actionUserDel() {
		if (\Yii::$app->request->isPost) {
			$id = \Yii::$app->request->post('id');
			$model = CasinoUser::findOne($id);
			!empty($model) && $model->setAttribute('is_deleted', 1);
			if ($model->update() !== false) {
				$this->success('人员删除成功');
			} else {
				$this->error('人员删除失败');
			}
		}
	}

	/**
	 * 改变人员状态
	 */
	public function actionUserChangeStatus() {
		if (\Yii::$app->request->isPost) {
			$id = \Yii::$app->request->post('id');
			$model = CasinoUser::findOne($id);
			if ($model->status == 1) {
				$status = 0;
				$text = '禁用';
			} else {
				$status = 1;
				$text = '启用';
			}
			!empty($model) && $model->setAttribute('status', $status);
			if ($model->update() !== false) {
				$this->success('人员' . $text . '成功');
			} else {
				$this->error('人员' . $text . '失败');
			}
		}
	}

	/**
	 * 人员添加
	 */
	public function actionUserAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = new CasinoUser();
			$post['create_time'] = time();
			$post['salt'] = \common\services\CasinoUserService::getSalt();
			$post['pwd'] = \common\services\CasinoUserService::getEncodePassword($post['uname'], $post['pwd'], $post['salt']);
			$model->setAttributes($post);
			if ($model->insert()) {
				$this->success('人员添加成功');
			} else {
				$this->error('人员添加失败，请稍候重试');
			}
		} else {
			$this->layout = 'modal';
			return $this->render('user-form');
		}
	}

	/**
	 * 人员编辑
	 */
	public function actionUserEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$model = CasinoUser::findOne($post['id']);
			$model->setAttributes($post);
			if ($model->update() !== false) {
				$this->success('人员编辑成功');
			} else {
				$this->error('人员编辑失败，请稍候重试');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$result = CasinoUser::find()->where(['id' => $id])->asArray()->one();
			$this->layout = 'modal';
			return $this->render('user-form', $result);
		}
	}

	/**
	 * 修改人员密码
	 */
	public function actionUserPassword() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			if (!is_str_len($post['pwd'])) {
				$this->error('请输入正确的密码');
			}
			if (\common\services\CasinoUserService::updatePassword($post['id'], $post['pwd'])) {
				$this->success('密码修改成功');
			} else {
				$this->error('密码修改失败，请稍候重试');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$result = CasinoUser::find()->where(['id' => $id])->asArray()->one();
			$this->layout = 'modal';
			return $this->render('user-password', $result);
		}
	}

	/**
	 * 新增页面展示
	 */
	public function actionAdd() {
		$this->layout = 'index';
		if (\Yii::$app->request->get('id')) {
			$view = \Yii::$app->view;
			$title = '编辑';
			$view->params['title'] = $title;
			$post['id'] = \Yii::$app->request->get('id');
			$userService = new CasinoService();
			$result = $userService->findCasino($post);
		} else {
			$view = \Yii::$app->view;
			$title = '新增';
			$view->params['title'] = $title;
			$result = [];
		}
		$returnUrl = \yii\helpers\Url::previous('casino/index');
		empty($returnUrl) && $returnUrl = \yii\helpers\Url::toRoute('index');
		$this->view->params['returnUrl'] = $returnUrl;
		return $this->render('add', $result);
	}

	/**
	 * 新增页面展示
	 */
	public function actionAddlist() {
		if (\Yii::$app->request->post('id')) {
			$post = \Yii::$app->request->post();
			if (empty($post['casino_name'])) {
				$this->error('娱乐场名称不能为空');
			} if (empty($post['e_casino_name'])) {
				$this->error('英文娱乐场名称不能为空');
			}
			if (empty($post['notes'])) {
				$this->error('列表简述不能为空');
			}if (empty($post['e_notes'])) {
				$this->error('英文列表简述不能为空');
			}
			if (strlen($post['notes']) > 30) {
				$this->error('列表简述不超过30字');
			}
			$newStr = preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', $post['notes']);
			if (mb_strlen($newStr, "utf-8") > 30) {
				$this->error('列表简述不超过30字');
			}
			if (empty($post['from'])) {
				$this->error('来自国家不能为空');
			}if (empty($post['e_from'])) {
				$this->error('英文来自国家不能为空');
			}
			if (empty($post['position'])) {
				$this->error('地理位置不能为空');
			} if (empty($post['e_position'])) {
				$this->error('英文地理位置不能为空');
			}
			if (empty($post['projects'])) {
				$this->error('娱乐项目不能为空');
			}if (empty($post['e_projects'])) {
				$this->error('英文娱乐项目不能为空');
			}if (empty($post['casino_bank'])) {
				$this->error('银行名称不能为空');
			}if (empty($post['casino_bank_holder'])) {
				$this->error('持卡人不能为空');
			}if (empty($post['casino_bank_no'])) {
				$this->error('银行卡号不能为空');
			}if (!empty($post['casino_bank_no']) && !is_numeric($post['casino_bank_no'])) {
				$this->error('请输入正确的银行卡号');
			}
			if (empty($post['casino_picture'])) {
				$this->error('通用展示图不能为空');
			}
//            if (!is_numeric($post['player'])||strpos($post['player'],".")!==false||$post['player']<0) {
//                $this->error('请输入正确的人数');
//            }
			if (!empty($post['player']) && !is_numeric($post['player'])) {
				$this->error('请输入正确的人数');
			}
			if (empty($post['flag_picture'])) {
				$this->error('国旗不能为空');
			}
			if (empty($post['details'])) {
				$this->error('详情描述不能为空');
			}if (empty($post['e_details'])) {
				$this->error('英文详情描述不能为空');
			}
			$model = new \admin\models\Casino();
			$one = $model->findOne($post['id']);
			$one->setAttributes($post);

			if ($one->validate()) {
				$result = $one->update();
				$result !== false ? $this->success('娱乐场编辑成功') : $this->error('娱乐场编辑失败，请稍候重试');
			} else {
				//获得第一条错误
				$this->error(current($one->getFirstErrors()));
			}
		} else {
			$post = \Yii::$app->request->post();
			if (empty($post['casino_name'])) {
				$this->error('娱乐场名称不能为空');
			} if (empty($post['e_casino_name'])) {
				$this->error('英文娱乐场名称不能为空');
			}
			if (empty($post['casino_bank'])) {
				$this->error('银行名称不能为空');
			}if (empty($post['casino_bank_holder'])) {
				$this->error('持卡人不能为空');
			}if (empty($post['casino_bank_no'])) {
				$this->error('银行卡号不能为空');
			}if (!empty($post['casino_bank_no']) && !is_numeric($post['casino_bank_no'])) {
				$this->error('请输入正确的银行卡号');
			}
			if (empty($post['notes'])) {
				$this->error('列表简述不能为空');
			}if (empty($post['e_notes'])) {
				$this->error('英文列表简述不能为空');
			}
			if (strlen($post['notes']) > 30) {
				$this->error('列表简述不超过30字');
			}
			$newStr = preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', $post['notes']);
			if (mb_strlen($newStr, "utf-8") > 30) {
				$this->error('列表简述不超过30字');
			}
			if (empty($post['from'])) {
				$this->error('来自国家不能为空');
			}if (empty($post['e_from'])) {
				$this->error('英文来自国家不能为空');
			}
			if (empty($post['position'])) {
				$this->error('地理位置不能为空');
			} if (empty($post['e_position'])) {
				$this->error('英文地理位置不能为空');
			}
			if (empty($post['projects'])) {
				$this->error('娱乐项目不能为空');
			}if (empty($post['e_projects'])) {
				$this->error('英文娱乐项目不能为空');
			}
			if (empty($post['casino_picture'])) {
				$this->error('通用展示图不能为空');
			} if (!empty($post['player']) && !is_numeric($post['player'])) {
				$this->error('请输入正确的人数');
			}
			if (empty($post['flag_picture'])) {
				$this->error('国旗不能为空');
			}
			if (empty($post['details'])) {
				$this->error('详情描述不能为空');
			}if (empty($post['e_details'])) {
				$this->error('英文详情描述不能为空');
			}
			$Service = new CasinoService();
			if ($Service->addCasino($post) === true) {
				$server = new PlatformService();
				$server->increaseCasinoCount();
				$this->success('娱乐场新增成功');
			} else {
				$this->error('娱乐场新增失败，请稍候重试');
			}
		}
	}

	/**
	 * 删除娱乐场
	 */
	public function actionDel() {
		$id = \Yii::$app->request->post('id');

		is_array($id) && $id = join(',', $id);
		if (!\Yii::$app->request->isPost || empty($id)) {
			$this->error('非法请求');
		}
		$service = new CasinoService();
		$result = $service->delCasino($id);
		if (!$result) {
			$this->error($service->errMsg);
		}
		//写入日志
		$LogService = new SystemLogService();
		$Log = '';
		$LogService->add('删除娱乐场', $Log, 'delCasino');
		$server = new PlatformService();
		$server->decreaseCasinoCount();
		$this->success('删除成功');
	}

}
