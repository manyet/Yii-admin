<?php

namespace common\services;

use common\models\User;
use common\models\UserElectronRecord;

/**
 * 电子分业务类
 */
class ElectronService {

	/**
	 * 改变分红电子分
	 */
	public static function increaseBonus($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 1, $remark);
	}

	public static function decreaseBonus($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 1, $remark);
	}

	/**
	 * 改变待返电子分
	 */
	public static function increaseFroze($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 2, $remark);
	}

	public static function decreaseFroze($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 2, $remark);
	}

	public static function change($user_id, $amount, $type, $change_type, $wallet_type, $remark = '') {
		if (floatval($amount) == 0) {
			return true;
		}
		$types = ['1' => 'electronic_number', '2' => 'froze_electronic_number'];
		$key = $types[$wallet_type];
		$user = User::findOne($user_id);
		$balance_before = floatval($user->{$key});
		$amount = floatval($amount);
		if ($type == 1) {
			$balance_after = $balance_before + $amount;
		} else {
//			if ($balance_before < $amount) { // 余额不足
//				return false;
//			}
			$balance_after = $balance_before - $amount;
		}
		$user->setAttribute($key, $balance_after);
		if ($user->update() === false) {
			return false;
		}
		return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
	}

	public static function addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark = '') {
		$model = new UserElectronRecord();
		$model->setAttributes([
			'user_id' => $user_id,
			'value' => $amount,
			'type' => $type,
			'change_type' => $change_type,
			'wallet_type' => $wallet_type,
			'before_feb' => $balance_before,
			'after_feb' => $balance_after,
			'remark' => $remark,
			'create_time' => time()
		]);
		return $model->insert();
	}

}
