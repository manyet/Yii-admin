<?php

namespace common\services;

use Yii;
use common\models\CasinoUser;
use admin\models\Casino;

/**
 * 赌场用户
 */
class CasinoUserService {

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
//		$info = CasinoUser::find()->select('id,uname,pwd,salt,realname,status,parent_id,language')->where('`uname` = :uname OR `email` = :uname', ['uname' => $uname])->asArray()->one();
		$info = CasinoUser::find()->select('id,uname,pwd,salt,realname,status,language,casino_id,identity')->where('`uname` = :uname AND is_deleted = 0', ['uname' => $uname])->asArray()->one();
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

	/**
	 * 注册用户
	 * @param array $data 数据
	 * @return boolean
	 */
	public static function register(array $data) {
		if (!self::checkUsernameFormat($data['uname'])) {
			return false;
		}
		$model = new CasinoUser();
		$data['invite_code'] = self::createInviteCode();
//		if (!empty($data['promoter_invite_code'])) {
//			$data['promoter_id'] = CasinoUser::find()->select('id')->where('invite_code = :invite_code', ['invite_code' => $data['promoter_invite_code']])->scalar();
//		}
		$data['language'] = Yii::$app->language;
		$data['create_time'] = $data['bind_time'] = time();
		$data['salt'] = self::getSalt();
		$data['pwd'] = self::getEncodePassword($data['uname'], $data['pwd'], $data['salt']);
		$model->setAttributes($data);
		return $model->insert();
	}

	public static function getSalt() {
		return getRandomString(6);
	}

	public static function updatePassword($id, $pwd) {
		$uname = CasinoUser::find()->select('uname')->where('id = :id', ['id' => $id])->scalar();
		$salt = self::getSalt();
		$columns = [
			'pwd' => self::getEncodePassword($uname, $pwd, $salt),
			'salt' => $salt,
		];
		$userModel = new CasinoUser();
		$one = $userModel->findOne($id);
		$one->setAttributes($columns);

		return $one->update() !== false;
	}

	public static function getUserInfo($user_id, $fields = '*') {
		return CasinoUser::find()->select($fields)->alias('u')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
	}

	public static function getUserInfoByUsername($username, $fields = '*') {
		return CasinoUser::find()->select($fields)->where('uname = :uname', ['uname' => $username])->asArray()->one();
	}

	public static function validatePayPasswordByPassword($input_password, $pay_password) {
		return self::getEncodePayPassword($input_password) == $pay_password;
	}

	/**
	 * 验证支付密码是否正确
	 */
	public static function validatePayPassword($user_id, $password) {
		$user_info = CasinoUser::find()->select('pay_pwd')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
		return $user_info['pay_pwd'] == self::getEncodePayPassword($password);
	}

	/**
	 * 验证登录密码是否正确
	 */
	public static function validatePassword($user_id, $password) {
		$user_info = CasinoUser::find()->select('uname,pwd,salt')->where('id = :user_id', ['user_id' => $user_id])->asArray()->one();
		return $user_info['pwd'] == self::getEncodePassword($user_info['uname'], $password, $user_info['salt']);
	}

	/**
	 * 获取账户余额
	 */
	public static function getCasinoAmount($casino_id) {
		return Casino::find()->select('unclear_account')->where('id = :user_id', ['user_id' => $casino_id])->scalar();
	}

}
