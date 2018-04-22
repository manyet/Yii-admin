<?php

namespace wap\controllers;

use common\models\ExchangeTmp;
use common\services\UserService;
use common\services\ExchangeService;
use common\controllers\WapController;

/**
 * 首页控制器
 */
class ExchangeController extends WapController {

	/**
	 * 首页
	 */
	public function actionIndex() {
		$user_id = $this->checkLogin();
		$user_info = UserService::getUserInfo($user_id, 'entertainment_integral');
		return $this->render('index', ['user_info' => $user_info]);
	}

	/**
	 * 验证
	 */
	public function actionVerify() {
		if (\Yii::$app->request->isPost) {
			$user_id = $this->checkLogin();
			$amount = \Yii::$app->request->post('amount');
			if (!is_numeric($amount)) {
				$this->error(\Yii::t('app', 'wap_exchange_point'));
			}
			$user_info = UserService::getUserInfo($user_id, 'entertainment_integral');
			if ($amount > $user_info['entertainment_integral']) {
				$this->error(\Yii::t('app', 'balance_not_enough', ['score' => \Yii::t('app', 'wallet_entertainment_score')]));
			}
			$remark = \Yii::$app->request->post('remark');
			$this->success('', \yii\helpers\Url::toRoute(['qrcode', 'amount' => $amount, 'remark' => $remark]));
		}
	}

	/**
	 * 生成临时编号
	 */
	public function actionGenerate() {
		if (\Yii::$app->request->isPost) {
			$user_id = $this->checkLogin();
			$amount = \Yii::$app->request->post('amount');
			if (!is_numeric($amount)) {
				$this->error(\Yii::t('app', 'wap_exchange_point'));
			}
			$user_info = UserService::getUserInfo($user_id, 'entertainment_integral');
			if ($amount > $user_info['entertainment_integral']) {
				$this->error(\Yii::t('app', 'balance_not_enough', ['score' => \Yii::t('app', 'wallet_entertainment_score')]), \yii\helpers\Url::toRoute('index'));
			}
			$model = new ExchangeTmp();
			$old_code = \Yii::$app->request->post('code', '');
			$model->deleteAll("(code = '$old_code' AND user_id = $user_id) OR expire < " . time());
			$code = $this->createCode();
			$remark = \Yii::$app->request->post('remark');
			$model->setAttributes([
				'code' => $code,
				'user_id' => $user_id,
				'amount' => $amount,
				'remark' => $remark,
				'create_time' => time()
			]);
			$model->setAttribute('expire', $model->getAttribute('create_time') + \Yii::$app->params['qrcodeExpire']);
			if ($model->insert()) {
				$this->success('', \Yii::$app->params['casinoUrl'] . '/scan/index.html?code=' . $code, ['code' => $code, 'amount' => $amount]);
			} else {
				$this->error('二维码创建失败');
			}
		}
	}

	private function createCode() {
		$code = '6' . getRandomString(10, '1234567890');
		$isExists = ExchangeTmp::find()->where('code = ' . $code)->count() > 0;
		if ($isExists) {
			return $this->createCode();
		}
		return $code;
	}

	/**
	 * 检查是否支付成功
	 */
	public function actionCheck() {
		if (\Yii::$app->request->isPost) {
			$code = \Yii::$app->request->post('code');
			if (empty($code)) {
				$this->error();
			}
			$model = ExchangeTmp::findOne(['code' => $code]);
			if (empty($model)) {
				$this->success();
			} else {
				$this->error();
			}
		}
	}

	/**
	 * 二维码
	 */
	public function actionQrcode() {
		$user_id = $this->checkLogin();
		$amount = \Yii::$app->request->get('amount');
		$remark = \Yii::$app->request->get('remark');
		return $this->render('qrcode', ['amount' => $amount, 'remark' => $remark]);
	}

	/**
	 * 兑换泥码流水页
	 */
	public function actionRecord() {
		$user_id = $this->checkLogin();
		return $this->render('record');
	}

	/**
	 * 兑换泥码流水页
	 */
	public function actionGetData() {
		$user_id = $this->checkLogin();
		$page = \Yii::$app->request->get('page', 1);
		$rows = \Yii::$app->request->get('rows', 10);
		if (useCommonLanguage()) {
			$fields = 'e_casino_name AS casino_name';
		} else {
			$fields = 'casino_name';
		}
		$data = ExchangeService::getRecord('amount,create_time,(SELECT ' . $fields . ' FROM end_casino WHERE id = casino_id) AS casino_name', ['user_id' => $user_id], $page, $rows);
		$this->ajaxReturn($data);
	}

}
