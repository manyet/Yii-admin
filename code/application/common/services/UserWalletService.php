<?php

namespace common\services;

use common\models\BuyExchange;
use common\models\ElectronicFeb;
use common\models\ModifyOrder;
use common\models\WithdrawalOrder;
use Yii;
use common\models\User;
use common\models\UserWalletRecord;

/**
 * 用户钱包服务
 * 钱包类型（1、公司分，2、现金分，3、娱乐分，4、手续分）
 */
class UserWalletService {

	public static $errMsg = '';

	/**
	 * 获取钱包记录
	 * @param string|array $fields
	 * @param string|array $where
	 * @param int $page
	 * @param int $rows
	 * @return mixed
	 */
	public static function getRecord($user_id , $type, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		$model = UserWalletRecord::find()->alias('a')->orderBy('a.id DESC');
		$model->where(['user_id' => $user_id, 'wallet_type' => $type]);
		!empty($where) && $model->andWhere($where);
		$total = $model->count();
		$offset = ($page - 1) * $rows;
		$model->offset($offset)->limit($rows);
		return ['list' => $model->select($fields)->asArray()->all(), 'total' => $total];
	}
    /**
     * 获取电子记录
     * @param string|array $fields
     * @param string|array $where
     * @param int $page
     * @param int $rows
     * @return mixed
     */
    public static function ElectronicRecord($user_id , $type, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
        $model = ElectronicFeb::find()->alias('a')->orderBy('a.id DESC');
        $model->where(['user_id' => $user_id, 'wallet_type' => $type]);
        !empty($where) && $model->andWhere($where);
        $total = $model->count();
        $offset = ($page - 1) * $rows;
        $model->offset($offset)->limit($rows);
        return ['list' => $model->select($fields)->asArray()->all(), 'total' => $total];
    }
    /**
     * 获取提现订单
     * @param string|array $fields
     * @param string|array $where
     * @param int $page
     * @param int $rows
     * @return mixed
     */
    public static function Withdraw($user_id ,$type,$sta, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
        $model = WithdrawalOrder::find()->alias('a');
        $model->where(['user_id' => $user_id]);
        if ($type!=''){
            $model->andWhere(['withdrawal_type' => $type]);
        }
        if ($sta!=''){
            $model->andWhere(['state' => $sta]);
        }
        !empty($where) && $model->andWhere($where);
        $total = $model->count();
        $offset = ($page - 1) * $rows;
        $model->offset($offset)->limit($rows);
        return ['list' => $model->select($fields)->leftJoin(BuyExchange::tableName() . ' u', 'u.id = a.rate')->orderBy('a.id DESC')->asArray()->all(), 'total' => $total];
    }
    /**
     * 获取提现订单
     */
    public static function getWithdraw($user_id,$type,$sta, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
        return self::Withdraw($user_id,$type,$sta, $fields, $where, $page, $rows);
    }
	/**
	 * 获取公司分记录
	 */
	public static function getCompanyRecord($user_id, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		return self::getRecord($user_id, 1, $fields, $where, $page, $rows);
	}

	/**
	 * 获取现金分记录
	 */
	public static function getCashRecord($user_id, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		return self::getRecord($user_id, 2, $fields, $where, $page, $rows);
	}

	/**
	 * 获取娱乐分记录
	 */
	public static function getEntertainmentRecord($user_id, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		return self::getRecord($user_id, 3, $fields, $where, $page, $rows);
	}

	/**
	 * 获取手续分记录
	 */
	public static function getPoundageRecord($user_id, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		return self::getRecord($user_id, 4, $fields, $where, $page, $rows);
	}

	/**
	 * 获取公司分红记录
	 */
	public static function getDividendRecord($user_id, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
		return self::getRecord($user_id, 5, $fields, $where, $page, $rows);
	}
    /**
     * 获取电子分红记录
     */
    public static function getElectronicRecord($user_id,$type, $fields = '*', $where = NULL, $page = 1, $rows = 10) {
        return self::ElectronicRecord($user_id,$type, $fields, $where, $page, $rows);
    }

	/**
	 * 获取公司分余额
	 */
	public static function getCompanyBalance($user_id) {
		return User::find()->select('company_integral')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 获取现金分余额
	 */
	public static function getCashBalance($user_id) {
		return User::find()->select('cash_integral')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 获取娱乐分余额
	 */
	public static function getEntertainmentBalance($user_id) {
		return User::find()->select('entertainment_integral')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 获取娱乐分余额
	 */
	public static function getPoundageBalance($user_id) {
		return User::find()->select('poundage_integral')->where("id = '$user_id'")->scalar();
	}


	/**
	 * 获取公司分红余额
	 */
	public static function getDividendBalance($user_id) {
		return User::find()->select('company_dividend')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 改变公司分
	 */
	public static function increaseCompany($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 1, $remark);
	}

	public static function decreaseCompany($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 1, $remark);
	}

	/**
	 * 改变现金分
	 */
	public static function increaseCash($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 2, $remark);
	}

	public static function decreaseCash($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 2, $remark);
	}

	/**
	 * 改变娱乐分
	 */
	public static function increaseEntertainment($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 3, $remark);
	}

	public static function decreaseEntertainment($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 3, $remark);
	}

	/**
	 * 改变手续分
	 */
	public static function increasePoundage($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 4, $remark);
	}

	public static function decreasePoundage($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 4, $remark);
	}

	/**
	 * 改变公司分红
	 */
	public static function increaseDividend($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 1, $change_type, 5, $remark);
	}

	public static function decreaseDividend($user_id, $amount, $change_type, $remark = '') {
		return self::change($user_id, $amount, 2, $change_type, 5, $remark);
	}

	public static function change($user_id, $amount, $type, $change_type, $wallet_type, $remark = '') {
		if (floatval($amount) == 0) {
			return true;
		}
		$types = ['1' => 'company_integral', '2' => 'cash_integral', '3' => 'entertainment_integral', '4' => 'poundage_integral', '5' => 'company_dividend'];
		$key = $types[$wallet_type];
		$user = User::findOne($user_id);
		$balance_before = floatval($user->{$key});
		$amount = floatval($amount);
		if ($type == 1) {
			$total_key = 'total_' . $key;
			$user->setAttribute($total_key, $user->{$total_key} + $amount);
			$balance_after = $balance_before + $amount;
		} else {
			if ($balance_before < $amount) { // 余额不足
				return false;
			}
			$balance_after = $balance_before - $amount;
		}
		$user->setAttribute($key, $balance_after);
		if ($user->update() === false) {
			return false;
		}
		return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
	}

	public static function addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark = '') {
		$model = new UserWalletRecord();
		$model->setAttributes([
			'user_id' => $user_id,
			'value' => $amount,
			'type' => $type,
			'change_type' => $change_type,
			'wallet_type' => $wallet_type,
			'balance_before' => $balance_before,
			'balance_after' => $balance_after,
			'remark' => $remark,
			'create_time' => time()
		]);
		return $model->insert();
	}

    public static function createModifyOrderNumber(){
        $order_number = (useCommonLanguage() ? 'EN' : 'CN') . date('Ymd') . strtoupper(getRandomString(4));
        $count = ModifyOrder::find()->where('order_num = :order_num', ['order_num' => $order_number])->count();
        if (intval($count) > 0) {
            return self::createModifyOrderNumber();
        }
        return $order_number;
    }

    public static function addModify($user_id, $amount, $type, $modify_type, $balance_before, $balance_after) {
        $model = new ModifyOrder();
        $model->setAttributes([
            'user_id' => $user_id,
            'value' => $amount,
            'type' => $type,
            'modify_type' => $modify_type,
            'balance_before' => $balance_before,
            'balance_after' => $balance_after,
            'order_num' => self::createModifyOrderNumber(),
            'create_time' => time()
        ]);
        return $model->insert();
    }

}
