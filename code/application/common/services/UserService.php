<?php

namespace common\services;

use common\models\WithdrawalOrder;
use common\models\TransferOrders;
use common\models\UserWalletRecord;
use pc\models\ExchangeRate;
use Yii;
use common\models\User;
use common\models\PackageOrder;
use admin\models\MossPackage;

/**
 * 用户
 */
class UserService {

	public static $errMsg = '';

	public static function getUsernameFormat() {
		return '/^[a-zA-Z0-9]{1,12}$/';
	}

	public static function getPasswordFormat() {
		return '/^\w{8,}$/';
	}

	public static function checkUsernameFormat($username) {
		return preg_match(self::getUsernameFormat(), $username);
	}

	public static function checkPasswordFormat($password) {
		return preg_match(self::getPasswordFormat(), $password);
	}

	public static function getEncodePassword($uname, $pwd, $salt, $key = NULL) {
		is_null($key) && $key = Yii::$app->params['passwordEncodeKey'];
		return md5($uname . '-' . $salt . '|' . $pwd . $key);
	}

	public static function getEncodePayPassword($password) {
		return md5(md5($password, true));
	}

	public static function login($uname, $pwd) {
//		$info = User::find()->select('id,uname,pwd,salt,realname,status,parent_id,language')->where('`uname` = :uname OR `email` = :uname', ['uname' => $uname])->asArray()->one();
		$info = User::find()->select('id,uname,pwd,salt,realname,status,parent_id,language')->where('`uname` = :uname', ['uname' => $uname])->asArray()->one();
		if ($info['pwd'] !== self::getEncodePassword($info['uname'], $pwd, $info['salt'])) {
			self::$errMsg = Yii::t('app', 'login_error');
			return false;
		} else if (intval($info['status']) !== 1) {
			self::$errMsg = Yii::t('app', 'account_frozen');
			return false;
		} else {
			unset($info['pwd'], $info['salt']);
			return $info;
		}
	}

	public static function createInviteCode(){
		$invite_code = getRandomString(6);
		$count = User::find()->where('invite_code = :invite_code', ['invite_code' => $invite_code])->count();
		if (intval($count) > 0) {
			return self::createInviteCode();
		}
		return $invite_code;
	}

	public static function register(array $data) {
		if (!self::checkUsernameFormat($data['uname'])) {
			return false;
		}
		$model = new User();
		$data['invite_code'] = self::createInviteCode();
//		if (!empty($data['promoter_invite_code'])) {
//			$data['promoter_id'] = User::find()->select('id')->where('invite_code = :invite_code', ['invite_code' => $data['promoter_invite_code']])->scalar();
//		}
		$data['language'] = Yii::$app->language;
		$data['create_time'] = $data['bind_time'] = time();
		$data['salt'] = getRandomString(6);
		$data['pwd'] = self::getEncodePassword($data['uname'], $data['pwd'], $data['salt']);
		$model->setAttributes($data);
		return $model->insert();
	}

	public static function getUserInfo($user_id, $fields = '*') {
		return User::find()->select($fields)->alias('u')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
	}

	public static function getUserInfoByUsername($username, $fields = '*') {
		return User::find()->select($fields)->where('uname = :uname', ['uname' => $username])->asArray()->one();
	}

	public static function validatePayPasswordByPassword($input_password, $pay_password) {
		return self::getEncodePayPassword($input_password) == $pay_password;
	}

	/**
	 * 验证支付密码是否正确
	 */
	public static function validatePayPassword($user_id, $password) {
		$user_info = User::find()->select('pay_pwd')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
		return $user_info['pay_pwd'] == self::getEncodePayPassword($password);
	}

	/**
	 * 验证登录密码是否正确
	 */
	public static function validatePassword($user_id, $password) {
		$user_info = User::find()->select('uname,pwd,salt')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
		return $user_info['pwd'] == self::getEncodePassword($user_info['uname'], $password, $user_info['salt']);
	}

	/**
	 * 获取公司分余额
	 */
	public static function getCompanyBalance($user_id) {
		return User::find()->select('company_integral')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 获取娱乐分余额
	 */
	public static function getEntertainmentBalance($user_id) {
		return User::find()->select('entertainment_integral')->where("id = '$user_id'")->scalar();
	}

	/**
	 * 获取现金分余额
	 */
	public static function getCashBalance($user_id) {
		return User::find()->select('cash_integral')->where("id = '$user_id'")->scalar();
	}

	public static function getMyPackageInfo($rank, $fields = '*') {
		return MossPackage::find()->select($fields)->where("id = '$rank'")->asArray()->one();
	}

	public static function getMyPackages($user_id, $fields = '*') {
		return PackageOrder::find()->select($fields)->where("user_id = '$user_id'")->asArray()->all();
	}

	public static function getMyPackagesCount($user_id) {
		return PackageOrder::find()->where("user_id = '$user_id'")->count();
	}

	public static function getPromoteList($user_id, $fields = '*', $where = NULL, $page = 1, $pageSize = 15) {
		$query = User::find()->where('promoter_id = :user_id', ['user_id' => $user_id]);
		!empty($where) && $query->andWhere($where);
		$count = $query->count();
        $list = $query->alias('u')->offset(($page - 1) * $pageSize)->select($fields)->orderBy('id DESC')->limit($pageSize)->asArray()->all();
		return [
			'list' => $list,
			'total' => intval($count)
		];
	}
    /**
     * 转让改变公司分
     */
    public static function upCompany($user_id, $amount, $type, $change_type,$wallet_type, $remark = '') {
        return self::change($user_id, $amount, $type, $change_type, $wallet_type,$remark);
    }
    public static function change($user_id, $amount, $type, $change_type, $wallet_type, $remark = '') {
        $types = ['1' => 'company_integral', '2' => 'cash_integral', '3' => 'entertainment_integral', '4' => 'poundage_integral'];
        $key = $types[$wallet_type];
        $user = User::findOne($user_id);
        $balance_before = floatval($user->{$key});
        $amount = floatval($amount);
        $balance_after = $balance_before - $amount;
        $user->setAttribute($key, $balance_after);
        if ($user->update() === false) {
            return false;
        }
        return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
    }
    public static function addCompany($user_id, $Companyamount, $type, $change_type, $wallet_type, $remark = '') {
        $types = ['1' => 'company_integral', '2' => 'cash_integral', '3' => 'entertainment_integral', '4' => 'poundage_integral'];
        $key = $types[$wallet_type];
        $user = User::findOne($user_id);
        $balance_before = floatval($user->{$key});
        $amount = floatval($Companyamount);
        $balance_after = $balance_before + $amount;
        $user->setAttribute($key, $balance_after);
        if ($user->update() === false) {
            return false;
        }
        return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
    }
    public static function addCash($user_id, $Cashamount, $type, $change_type, $wallet_type, $remark = '') {
        $types = ['1' => 'company_integral', '2' => 'cash_integral', '3' => 'entertainment_integral', '4' => 'poundage_integral'];
        $key = $types[$wallet_type];
        $user = User::findOne($user_id);
        $balance_before = floatval($user->{$key});
        $amount = floatval($Cashamount);
        $balance_after = $balance_before + $amount;
        $user->setAttribute($key, $balance_after);
        if ($user->update() === false) {
            return false;
        }
        return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
    }
    public static function addEntertainment($user_id, $entertainmentamount, $type, $change_type, $wallet_type, $remark = '') {
        $types = ['1' => 'company_integral', '2' => 'cash_integral', '3' => 'entertainment_integral', '4' => 'poundage_integral'];
        $key = $types[$wallet_type];
        $user = User::findOne($user_id);
        $balance_before = floatval($user->{$key});
        $amount = floatval($entertainmentamount);
        $balance_after = $balance_before + $amount;
        $user->setAttribute($key, $balance_after);
        if ($user->update() === false) {
            return false;
        }
        return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
    }
    public static function addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark) {

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
	
	public static function saveUser($post) {
		$model = new User();
		$user = $model->findOne($post['id']);
		$user->setAttributes($post);
		return $user->update() !== false;
	}
	
	public static function updatePwd($id, $pwd) {
		$model = new User();
		$user = $model->findOne($id);
		$user->setAttributes(['pwd' => $pwd]);
		return $user->update() !== false;
	}
	
	public static function savePayPwd($id, $pwd) {
		$model = new User();
		$user = $model->findOne($id);
		$data['pay_pwd'] = self::getEncodePayPassword($pwd);
		$user->setAttributes($data);
		return $user->update() !== false;
	}
    public static function addOrder($user_id,$consumption, $into, $into_wallet) {

        $model = new TransferOrders();
        $model->setAttributes([
            'user_id' => $user_id,
            'order_num' => self::createOrderNumber(),
            'consumption' => $consumption,
            'into' => $into,
            'into_wallet' => $into_wallet,
            'create_time' => time()
        ]);
        return $model->insert();
    }
    public static function createOrderNumber(){
        $order_number = (useCommonLanguage() ? 'EN' : 'CN') . date('Ymd') . strtoupper(getRandomString(4));
        $count = TransferOrders::find()->where('order_num = :order_num', ['order_num' => $order_number])->count();
        if (intval($count) > 0) {
            return self::createOrderNumber();
        }
        return $order_number;
    }
	
	public static function getInfoByParams($params = [], $fields = '*') {
		return User::find()->select($fields)->where($params)->asArray()->one();
	}
	
	public static function updateInfoByParasm($params = [], $columns = []) {
		if (empty($params) || empty($columns)) {
			return false;
		}
		$model = new User();
		$user = $model->findOne($params);
		$user->setAttributes($columns);
		return $user->update() !== false;
	}
    /**
     * 根据id获得类型
     */
    public function FindExchange() {
        $fields = "*";
        $Model = new ExchangeRate();
        return $Model->find()->select($fields)->where('is_deleted = 0')->asArray()->all();
    }
    public static function createWithdrawalOrderNumber(){
        $order_number = (useCommonLanguage() ? 'EN' : 'CN') . date('Ymd') . strtoupper(getRandomString(4));
        $count = WithdrawalOrder::find()->where('order_num = :order_num', ['order_num' => $order_number])->count();
        if (intval($count) > 0) {
            return self::createWithdrawalOrderNumber();
        }
        return $order_number;
    }
    public static function addWithdrawal($post) {
        $model = new WithdrawalOrder();
        $model->setAttributes([
            'user_id' => $post['user_id'],
            'order_num' => self::createWithdrawalOrderNumber(),
            'withdrawal_type' => $post['withdrawal_type'],
            'bank' => $post['bank'],
            'branch' => $post['branch'],
            'bank_no' => $post['bank_no'],
            'holder' => $post['holder'],
            'rate' => $post['rate'],
            'integral' => $post['out_integral'],
            'money' => $post['money'],
            'state' => 0,
            'application_time' => time()
        ]);
        return $model->insert();
    }
}
