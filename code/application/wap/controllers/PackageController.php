<?php

namespace wap\controllers;

use common\services\UserService;
use common\services\PackageService;
use common\services\RuleService;
use common\controllers\WapController;

/**
 * 配套控制器
 */
class PackageController extends WapController {

    /**
     * 列表
     */
    public function actionIndex() {
		\yii\helpers\Url::remember(\yii\helpers\Url::current(), 'package_return_url');
        $service = new \pc\services\PackageService();
        $page = \yii::$app->request->get('page', 1);
        $rows = \yii::$app->request->get('rows', 6);
		if (useCommonLanguage()) {
			$fileds = 'package_name_en AS package_name,package_description_en AS package_description';
		} else {
			$fileds = 'package_name,package_description';
		}
        $result = $service->getList($page, $rows, 'id,package_image_path,package_value,' . $fileds);
        return $this->render('index', $result);
    }

    /**
     * 详情
     */
    public function actionDetail() {
        $service = new \pc\services\PackageService();
        $id = \yii::$app->request->get('id', 0);
		if (useCommonLanguage()) {
			$fileds = 'package_name_en AS package_name,package_description_en AS package_description,package_detail_en AS package_detail';
		} else {
			$fileds = 'package_name,package_description,package_detail';
		}
        $result = $service->getDetail($id, 'id,package_value,package_image_path,level_name,electron_multiple,daily_dividend_check,task_benefit_check,direct_reward_check,development_reward_check,point_award_check,' . $fileds);
		$have_bought = false;
		if (isLogin()) {
			$user_id = getUserId();
			$result['user_info'] = UserService::getUserInfo($user_id, 'company_integral,entertainment_integral,cash_integral,package_value');
			$result['package_rules'] = RuleService::getRulesByType(1);
			$have_bought = $result['user_info']['package_value'] >= $result['package_value'];
//			$have_bought = intval(PackageOrder::find()->where('user_id = :user_id AND package_id = :id', ['user_id' => $user_id, 'id' => $id])->count()) > 0;
		}
		$result['have_bought'] = $have_bought;
		$result['return_url'] = \yii\helpers\Url::previous('package_return_url');
        return $this->render('detail', $result);
    }

    /**
     * 我的配套
     */
    public function actionMy() {
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,electronic_number,froze_electronic_number,company_integral,entertainment_integral,cash_integral,package_value,electron_multiple');
		if (useCommonLanguage()) {
			$field = 'package_description_en AS package_description,,package_detail_en AS package_detail,package_name_en AS package_name';
		} else {
			$field = 'package_description,package_detail,package_name';
		}
        return $this->render('my', [
			'user_info' => $user_info,
			'my_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo($user_info['rank'], 'level_name,daily_dividend_check,task_benefit_check,direct_reward_check,development_reward_check,point_award_check,' . $field),
		]);
    }

    /**
     * 购买配套
     */
    public function actionBuy() {
		$user_id = $this->checkLogin();
		if (\Yii::$app->request->isPost) {
			$id = \Yii::$app->request->post('package');
			$pay_password = \Yii::$app->request->post('password');
			$pay = \Yii::$app->request->post('pay');
			if (PackageService::buyPackage($id, $user_id, $pay_password, $pay)) {
				$this->success(\Yii::t('app', 'package_buy_success'), \yii\helpers\Url::toRoute('my'));
			} else {
				$this->error(PackageService::$errMsg);
			}
		} else {
			$id = \Yii::$app->request->get('id');
			if (useCommonLanguage()) {
				$all_field = 'package_name_en AS package_name';
				$field = 'package_name_en AS package_name';
			} else {
				$all_field = 'package_name';
				$field = 'package_name';
			}
			$keys = array_values(RuleService::getBalanceKey());
			$user_info = UserService::getUserInfo($user_id, 'rank,package_value,' . join(',', $keys));
			$package_info = PackageService::getPackageInfo($id, 'id,package_name,package_value,level_name');
			if ($user_info['package_value'] >= $package_info['package_value']) {
				$this->error(\Yii::t('app', 'have_bought_package'), \yii\helpers\Url::home());
			}
			$package_rules = RuleService::getRulesByType(1);
			return $this->render('buy', [
				'upgrade_rules' => $package_rules,
				'user_info' => $user_info,
				'package_info' => $package_info
			]);
		}
    }

    /**
     * 升级配套
     */
    public function actionUpgrade() {
		$user_id = $this->checkLogin();
		if (\Yii::$app->request->isPost) {
			$id = \Yii::$app->request->post('package');
			$pay_password = \Yii::$app->request->post('password');
			$pay = \Yii::$app->request->post('pay');
			if (PackageService::buyPackage($id, $user_id, $pay_password, $pay)) {
				$this->success(\Yii::t('app', 'package_upgrade_success'), \yii\helpers\Url::toRoute('my'));
			} else {
				$this->error(PackageService::$errMsg);
			}
		} else {
			if (useCommonLanguage()) {
				$all_field = 'package_name_en AS package_name';
				$field = 'package_name_en AS package_name';
			} else {
				$all_field = 'package_name';
				$field = 'package_name';
			}
			$keys = array_values(RuleService::getBalanceKey());
			$user_info = UserService::getUserInfo($user_id, 'rank,package_value,' . join(',', $keys));
			$available_package = PackageService::getUserAvailablePackage($user_info['package_value'], 'id,package_value,level_name,' . $all_field);
			$package_rules = RuleService::getRulesByType(1);
			return $this->render('upgrade', [
				'available_package' => $available_package,
				'upgrade_rules' => $package_rules,
				'user_info' => $user_info,
				'my_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo($user_info['rank'], 'level_name,' . $field)
			]);
		}
    }

	public function actionUpgradeNext() {
		$user_id = $this->checkLogin();
		$keys = array_values(RuleService::getBalanceKey());
		$user_info = UserService::getUserInfo($user_id, 'rank,package_value,' . join(',', $keys));
		if (useCommonLanguage()) {
			$field = 'package_name_en AS package_name';
		} else {
			$field = 'package_name';
		}
		return $this->render('upgrade-next', [
			'user_info' => $user_info,
			'my_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo($user_info['rank'], 'level_name,' . $field),
			'up_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo(\Yii::$app->request->get('package'), 'level_name,package_value,electron_multiple,' . $field)
		]);
	}

    /**
     * 充值配套
     */
    public function actionRecharge() {
		$user_id = $this->checkLogin();
		if (\Yii::$app->request->isPost) {
			$pay_password = \Yii::$app->request->post('password');
			$pay = \Yii::$app->request->post('pay');
			if (PackageService::recharge($user_id, $pay_password, $pay)) {
				$this->success(\Yii::t('app', 'package_recharge_success'), \yii\helpers\Url::toRoute('my'));
			} else {
				$this->error(PackageService::$errMsg);
			}
		} else {
			if (useCommonLanguage()) {
				$field = 'package_name_en AS package_name';
			} else {
				$field = 'package_name';
			}
			$keys = array_values(RuleService::getBalanceKey());
			$user_info = UserService::getUserInfo($user_id, 'rank,electron_multiple,' . join(',', $keys));
			$recharge_rules = RuleService::getRulesByType(2);
			return $this->render('recharge', [
				'recharge_rules' => $recharge_rules,
				'user_info' => $user_info,
				'my_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo($user_info['rank'], 'level_name,' . $field)
			]);
		}
    }

	public function actionRechargeNext() {
		$user_id = $this->checkLogin();
		$user_info = UserService::getUserInfo($user_id, 'electron_multiple');
		return $this->render('recharge-next', [
			'user_info' => $user_info
		]);
	}

    /**
     * 复投配套
     */
    public function actionRecast() {
		$user_id = $this->checkLogin();
		if (\Yii::$app->request->isPost) {
			$pay_password = \Yii::$app->request->post('password');
			$pay = \Yii::$app->request->post('pay');
			if (PackageService::recast($user_id, $pay_password, $pay)) {
				$this->success(\Yii::t('app', 'package_recast_success'), \yii\helpers\Url::toRoute('my'));
			} else {
				$this->error(PackageService::$errMsg);
			}
		} else {
			if (useCommonLanguage()) {
				$field = 'package_name_en AS package_name';
			} else {
				$field = 'package_name';
			}
			$keys = array_values(RuleService::getBalanceKey());
			$user_info = UserService::getUserInfo($user_id, 'rank,electron_multiple,' . join(',', $keys));
			$recast_rules = RuleService::getRulesByType(3);
			return $this->render('recast', [
				'recast_rules' => $recast_rules,
				'user_info' => $user_info,
				'my_package_info' => empty($user_info['rank']) ? NULL : UserService::getMyPackageInfo($user_info['rank'], 'level_name,' . $field)
			]);
		}
    }

	public function actionRecastNext() {
		$user_id = $this->checkLogin();
		$user_info = UserService::getUserInfo($user_id, 'electron_multiple');
		return $this->render('recast-next', [
			'user_info' => $user_info
		]);
	}

}
