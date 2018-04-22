<?php

namespace wap\controllers;

use common\services\LanguageService;
use common\services\UserWalletService;
use pc\services\BankCardService;
use Yii;
use common\services\PlatformService;
use common\services\UserService;
use common\models\CompanyDividendInterestRecord;
use common\models\CompanyDividendRecord;
use common\services\CompanyDividend;
use common\controllers\WapController;

/**
 * 投资平台控制器
 */
class InvestmentController extends WapController {

	/**
	 * 列表
	 */
	public function actionIndex() {
		$user_id = $this->checkLogin();
		$Service = new UserService();
		$data = [
			'total' => PlatformService::getDividendTotal(),
			'user_info' => UserService::getUserInfo($user_id, 'total_company_dividend,total_dividend_reward,company_dividend'),
		];
		if (useCommonLanguage()) {
			$fields = 'name_en AS name,description_en AS description';
		} else {
			$fields = 'name,description';
		}
		$data['project'] = CompanyDividend::getActiveProject('start_date,img_path,' . $fields);
		return $this->render('index', $data);
	}

	public function actionDetail() {
		$user_id = $this->checkLogin();
		return $this->render('detail');
	}

	public function actionGetDetailData() {
		$user_id = $this->checkLogin();
		$model = CompanyDividendInterestRecord::find()->where('user_id = ' . $user_id);
		$data['total'] = $model->count();
		$data['list'] = $model->select('id,create_time,item,old_dividend,old_interest_rate,old_dividend_interest,dividend,interest_rate,dividend_interest,total_dividend_interest')->asArray()->all();
		$this->ajaxReturn($data);
	}

	public function actionDividend() {
		$user_id = $this->checkLogin();
		return $this->render('dividend');
	}

	public function actionGetData() {
		$user_id = $this->checkLogin();
		$model = CompanyDividendRecord::find()->where('user_id = ' . $user_id);
		$start = Yii::$app->request->get('start', '');
		if ($start !== '') {
			$model->andWhere('create_time >= ' . strtotime($start));
		}
		$end = Yii::$app->request->get('end', '');
		if ($end !== '') {
			$model->andWhere('create_time < ' . (strtotime($end) + 86400));
		}
		$total = $model->count();
		$rows = 10;
		$page = Yii::$app->request->get('page', 1);
		$list = $model->offset($page - 1)->limit($rows)->orderBy('id DESC')->asArray()->all();
		$this->ajaxReturn(['list' => $list, 'total' => $total]);
	}

}
