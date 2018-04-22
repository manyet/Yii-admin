<?php

namespace common\services;

use Yii;
use common\services\UserService;
use common\services\UserWalletService;
use admin\models\MossPackage;
use common\models\PackageOrder;
use common\services\PromoteService;
use common\services\ElectronService;
use common\models\User;

/**
 * 配套
 */
class PackageService {

	public static $errMsg = '';

	public static function getAllPackage($fields = '*') {
		return MossPackage::find()->select($fields)->asArray()->all();
	}

	public static function getRankInfo($fields = '*') {
		return MossPackage::find()->select($fields)->asArray()->all();
	}

	public static function getAvailablePackage($fields = '*') {
		return MossPackage::find()->select($fields)->orderBy('package_value')->where("package_status = 1 AND is_deleted = 0")->asArray()->all();
	}

	public static function getUserAvailablePackage($value, $fields = '*') {
		return MossPackage::find()->select($fields)->orderBy('package_value')->where("package_value > $value AND package_status = 1 AND is_deleted = 0")->asArray()->all();
	}

	public static function getPackageInfo($id, $fields = '*') {
		return MossPackage::find()->select($fields)->where("id = $id")->asArray()->one();
	}

	public static function buyPackage($id, $user_id, $password, $pay) {
		if (empty($id)) {
			self::$errMsg = '请选择要购买的配套';
			return false;
		}
		$keys = array_values(RuleService::getBalanceKey());
		$user_info = UserService::getUserInfo($user_id, 'rank,pay_pwd,package_value,' . join(',', $keys));
		// 支付密码
		if (empty($user_info['pay_pwd'])) {
			$url = \yii\helpers\Url::toRoute('user/info');
			self::$errMsg = Yii::t('app', 'please_set_pay_password', ['url' => $url]);
			return false;
		}
		if (!UserService::validatePayPasswordByPassword($password, $user_info['pay_pwd'])) {
			self::$errMsg = Yii::t('app', 'pay_password_error');
			return false;
		}
		$total = 0;
		foreach ($pay as $key => $value) {
			$total += $value;
		}
		$fields = 'package_value,package_status,daily_dividend_ratio,task_benefit_ratio,direct_reward_ratio,development_reward_ratio,point_award_ratio,electron_multiple';
		$package = MossPackage::find()->select($fields)->where('id = :id', ['id' => $id])->asArray()->one();
		if ($total != $package['package_value']) {
			self::$errMsg = \Yii::t('app', 'money_sum_error');
			return false;
		}
		// 配套是否在售
		if (intval($package['package_status']) !== 1) {
			self::$errMsg = '该配套已下架';
			return false;
		}
		// 是否购买过此配套
//		$count = PackageOrder::find()->where('user_id = :user_id AND package_id = :id', ['user_id' => $user_id, 'id' => $id])->count();
//		if (intval($count) > 0) {
//			self::$errMsg = \Yii::t('app', 'have_bought_package');
//			return false;
//		}
		$package_value = floatval($package['package_value']);
		// 现在的等级是否允许买此配套
		if ($user_info['package_value'] >= $package_value) {
			self::$errMsg = \Yii::t('app', 'have_bought_package');
			return false;
		}
		$transaction = Yii::$app->db->beginTransaction();
		// 验证规则配置
		$config = RuleService::getRulesByType(1);
		$multiple = 100;
		foreach ($config as $row) {
			if (!empty($pay[$row['id']])) {
				if ($row['package_lowest_ratio'] > 0 && $pay[$row['id']] < $total * $row['package_lowest_ratio'] / 100) {
					self::$errMsg = Yii::t('app', 'at_least_use', ['value' => $row['package_lowest_ratio'] . '%', 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($pay[$row['id']] > $total * $row['package_highest_ratio'] / 100) {
					self::$errMsg = Yii::t('app', 'at_most_use', ['value' => $row['package_highest_ratio'] . '%', 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($pay[$row['id']] % $multiple != 0) {
					self::$errMsg = Yii::t('app', 'must_be_multiple', ['multiple' => $multiple, 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				// 写入积分流水
				if ($pay[$row['id']] > $user_info[RuleService::getBalanceKey($row['id'])]) {
					self::$errMsg = Yii::t('app', 'balance_not_enough', ['score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				$result = UserWalletService::change($user_id, $pay[$row['id']], 2, 11, $row['id'], Yii::t('app', 'package_buy'));
				if (!$result) {
					self::$errMsg = '扣除' . RuleService::getTypeName($row['id']) . '失败';
					return false;
				}
			}
		}
		// 写入配套订单
		if (!self::createOrder($id, $user_id, $package_value)) {
			$transaction->rollBack();
			self::$errMsg = '写入配套订单失败';
			return false;
		}
		$time = time();
		// 更新用户配套
		$data = [
			'rank' => $id,
			'rank_time' => $time,
			'daily_dividend_ratio' => $package['daily_dividend_ratio'],
			'task_benefit_ratio' => $package['task_benefit_ratio'],
			'direct_reward_ratio' => $package['direct_reward_ratio'],
			'development_reward_ratio' => $package['development_reward_ratio'],
			'point_award_ratio' => $package['point_award_ratio'],
			'package_value' => $package_value,
			'electron_multiple' => $package['electron_multiple']
		];
		$model = User::findOne($user_id);
		$increase_number = $package_value * floatval($package['electron_multiple']);
		// 写入电子分待返
		$balance_after = $froze_balance_after = $model->froze_electronic_number + $increase_number;
		ElectronService::addLog($user_id, $increase_number, 1, 3, 2, $model->froze_electronic_number, $froze_balance_after, Yii::t('app', 'package_buy'));
//		$balance_after = $model->electronic_number + $increase_number;
//		ElectronService::addLog($user_id, $increase_number, 1, 3, 1, $model->electronic_number, $balance_after, Yii::t('app', 'package_buy'));
		if ($model->froze_electronic_number < 0) {
			$balance_after = $increase_number;
		}
		// 分红电子分变化值
		$number = $balance_after - $model->electronic_number;
		$type = $number >= 0 ? 1 : 2;
		ElectronService::addLog($user_id, abs($number), $type, 3, 1, $model->electronic_number, $balance_after, Yii::t('app', 'package_buy'));
		$model->setAttribute('electronic_number', $balance_after);
		$model->setAttribute('froze_electronic_number', $froze_balance_after);
		$model->setAttributes($data);
		if ($model->update() === false) {
			$transaction->rollBack();
			self::$errMsg = '更新用户配套失败';
			return false;
		}
		$service = new PromoteService();
		$result = $service->rewardToUser($user_id, $package_value, 1);
		if (!$result) {
			$transaction->rollBack();
			self::$errMsg = '写入推广信息失败';
			return false;
		}
		$transaction->commit();
		return true;
	}

	/**
	 * 配套充值
	 * @param type $user_id
	 * @param type $password
	 * @param type $pay
	 * @return boolean
	 */
	public static function recharge($user_id, $password, $pay) {
		$keys = array_values(RuleService::getBalanceKey());
		$user_info = UserService::getUserInfo($user_id, 'rank,pay_pwd,electron_multiple,' . join(',', $keys));
		// 支付密码
		if (empty($user_info['pay_pwd'])) {
			$url = \yii\helpers\Url::toRoute('user/info');
			self::$errMsg = Yii::t('app', 'please_set_pay_password', ['url' => $url]);
			return false;
		}
		if (!UserService::validatePayPasswordByPassword($password, $user_info['pay_pwd'])) {
			self::$errMsg = Yii::t('app', 'pay_password_error');
			return false;
		}
		$total = 0;
		foreach ($pay as $key => $value) {
			$total += $value;
		}
		// 验证规则配置
		$config = RuleService::getRulesByType(2);
		$multiple = 100;
		$transaction = Yii::$app->db->beginTransaction();
		foreach ($config as $row) {
			if (!empty($pay[$row['id']])) {
				if ($row['recharge_lowest_ratio'] > 0 && $pay[$row['id']] < $total * $row['recharge_lowest_ratio'] / 100) {
					self::$errMsg = Yii::t('app', 'at_least_use', ['value' => $row['recharge_lowest_ratio'] . '%', 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($pay[$row['id']] > $total * $row['recharge_highest_ratio'] / 100) {
					self::$errMsg = Yii::t('app', 'at_most_use', ['value' => $row['recharge_highest_ratio'] . '%', 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($row['recharge_lowest_value'] > 0 && $pay[$row['id']] < $row['recharge_lowest_value']) {
					self::$errMsg = Yii::t('app', 'at_least_use', ['value' => $row['recharge_lowest_value'], 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($pay[$row['id']] % $multiple != 0) {
					self::$errMsg = Yii::t('app', 'must_be_multiple', ['multiple' => $multiple, 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				// 写入积分流水
				if ($pay[$row['id']] > $user_info[RuleService::getBalanceKey($row['id'])]) {
					self::$errMsg = Yii::t('app', 'balance_not_enough', ['score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				$result = UserWalletService::change($user_id, $pay[$row['id']], 2, 13, $row['id'], Yii::t('app', 'package_recharge'));
				if (!$result) {
					$transaction->rollBack();
					self::$errMsg = '扣除' . RuleService::getTypeName($row['id']) . '失败';
					return false;
				}
			}
		}
		$multiple = floatval($user_info['electron_multiple']);
		// 写入电子分待返
		$model = User::findOne($user_id);
		$increase_number = $total * $multiple;
		$balance_after = $model->electronic_number + $increase_number;
		ElectronService::addLog($user_id, $increase_number, 1, 4, 1, $model->electronic_number, $balance_after, Yii::t('app', 'package_recharge'));
		$model->setAttribute('electronic_number', $balance_after);
		$balance_after = $model->froze_electronic_number + $increase_number;
		ElectronService::addLog($user_id, $increase_number, 1, 4, 2, $model->froze_electronic_number, $balance_after, Yii::t('app', 'package_recharge'));
		$model->setAttribute('froze_electronic_number', $balance_after);
		if ($model->update() === false) {
			$transaction->rollBack();
			self::$errMsg = '更新用户信息失败';
			return false;
		}
		$service = new PromoteService();
		$result = $service->rewardToUser($user_id, $total, 2);
		if (!$result) {
			$transaction->rollBack();
			self::$errMsg = '写入推广信息失败';
			return false;
		}
//		self::$errMsg = $model->getAttribute('electronic_number') . ',' . $model->getAttribute('froze_electronic_number');
		$transaction->commit();
		return true;
	}

	/**
	 * 复投
	 * @param type $user_id
	 * @param type $password
	 * @param type $pay
	 */
	public static function recast($user_id, $password, $pay) {
		$keys = array_values(RuleService::getBalanceKey());
		$user_info = UserService::getUserInfo($user_id, 'rank,pay_pwd,electron_multiple,' . join(',', $keys));
		// 支付密码
		if (empty($user_info['pay_pwd'])) {
			$url = \yii\helpers\Url::toRoute('user/info');
			self::$errMsg = Yii::t('app', 'please_set_pay_password', ['url' => $url]);
			return false;
		}
		if (!UserService::validatePayPasswordByPassword($password, $user_info['pay_pwd'])) {
			self::$errMsg = Yii::t('app', 'pay_password_error');
			return false;
		}
		$total = 0;
		foreach ($pay as $key => $value) {
			$total += $value;
		}
		// 验证规则配置
		$config = RuleService::getRulesByType(3);
		$transaction = Yii::$app->db->beginTransaction();
		foreach ($config as $row) {
			if (!empty($pay[$row['id']])) {
				if ($row['recast_lowest_value'] > 0 && $pay[$row['id']] < $row['recast_lowest_value']) {
					self::$errMsg = Yii::t('app', 'at_least_use', ['value' => $row['recast_lowest_value'], 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				} else if ($pay[$row['id']] % $row['recast_multiple'] != 0) {
					self::$errMsg = Yii::t('app', 'must_be_multiple', ['multiple' => $row['recast_multiple'], 'score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				// 写入积分流水
				if ($pay[$row['id']] > $user_info[RuleService::getBalanceKey($row['id'])]) {
					self::$errMsg = Yii::t('app', 'balance_not_enough', ['score' => RuleService::getTypeName($row['id'])]);
					return false;
				}
				$result = UserWalletService::change($user_id, $pay[$row['id']], 2, 13, $row['id'], Yii::t('app', 'package_recast'));
				if (!$result) {
					$transaction->rollBack();
					self::$errMsg = '扣除' . RuleService::getTypeName($row['id']) . '失败';
					return false;
				}
			}
		}
		$multiple = floatval($user_info['electron_multiple']);
		// 写入电子分待返
		$model = User::findOne($user_id);
		$increase_number = $total * $multiple;
		$balance_after = $model->froze_electronic_number + $increase_number;
		ElectronService::addLog($user_id, $increase_number, 1, 5, 2, $model->froze_electronic_number, $balance_after, Yii::t('app', 'package_recast'));
		$model->setAttribute('froze_electronic_number', $balance_after);
		if ($model->update() === false) {
			$transaction->rollBack();
			self::$errMsg = '更新用户信息失败';
			return false;
		}
		$service = new PromoteService();
		$result = $service->rewardToUser($user_id, $total, 3);
		if (!$result) {
			$transaction->rollBack();
			self::$errMsg = '写入推广信息失败';
			return false;
		}
//		self::$errMsg = $model->getAttribute('froze_electronic_number');
		$transaction->commit();
		return true;
	}

	public static function createOrder($id, $user_id, $price) {
		// 修改销量
		$model = MossPackage::findOne($id);
		$model->setAttribute('total_sales', $model->total_sales + 1);
		if ($model->update() === false) {
			return false;
		}
		// 写入配套订单
		$order = [
			'package_id' => $id,
			'user_id' => $user_id,
			'buy_time' => time(),
			'order_num' => self::createOrderNumber(),
			'price' => $price
		];
		$order_model = new PackageOrder();
		$order_model->setAttributes($order);
		return $order_model->insert();
	}

	public static function createOrderNumber(){
		$order_number = (useCommonLanguage() ? 'EN' : 'CN') . date('Ymd') . strtoupper(getRandomString(4));
		$count = PackageOrder::find()->where('order_num = :order_num', ['order_num' => $order_number])->count();
		if (intval($count) > 0) {
			return self::createOrderNumber();
		}
		return $order_number;
	}

}
