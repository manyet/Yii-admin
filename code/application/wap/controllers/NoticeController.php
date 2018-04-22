<?php

namespace wap\controllers;

use common\controllers\WapController;

/**
 *  消息
 */
class NoticeController extends WapController {

	/**
	 * 首页
	 */
	public function actionIndex() {
		$user_id = $this->checkLogin();
		$service = new \wap\services\NoticeService();
		$user = \common\services\UserService::getInfoByParams(['id' => $user_id], 'identity');
		$notice = $service->getUnread($user_id, $user['identity']);
		$result['unread'] = count($notice);
		return $this->render('index', $result);
	}

	/**
	 * 获取数据
	 */
	public function actionGetData() {
		$user_id = $this->checkLogin();
		$user = \common\services\UserService::getInfoByParams(['id' => $user_id], 'identity');
		$get = \Yii::$app->request->get();
		$page = !empty($get['page']) ? $get['page'] : 1;
		$pageSize = !empty($get['rows']) ? $get['rows'] : 10;
		$service = new \wap\services\NoticeService();
		$result = $service->getList($page, $pageSize, $user['identity'], $user_id);
		$this->ajaxReturn($result);
	}
	
	public function actionDetail() {
		$user_id = $this->checkLogin();
		$id = \yii::$app->request->get('id', 0);
		
		$service = new \pc\services\NoticeService();
		$result = $service->getInfoById($id);
		
		$status = \pc\services\NoticeService::getNoticeStatus($user_id, $id);
		if ($status != 1) {
			$service->addNoticeRecord($user_id, $id);
		}

		return $this->render('detail', $result);
	}
	
	public function actionReadAll() {
		$user_id = $this->checkLogin();
		$service = new \wap\services\NoticeService();
		$user = \common\services\UserService::getInfoByParams(['id' => $user_id], 'identity');
		$notice = $service->getUnread($user_id, $user['identity']);
		if (!empty($notice)) {
			$data = [];
			foreach ($notice as $key => $value) {
				$data[$key]['user_id'] = $user_id;
				$data[$key]['notice_id'] = $value['id'];
				$data[$key]['create_time'] = time();
			}
			unset($notice);
		} else {
			$this->error();
		}
		
		$result = $service->readAll($data);
		if ($result) {
			$this->success();
		} else {
			$this->error();
		}
	}

}
