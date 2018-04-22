<?php

namespace admin\models;

use common\models\CommonModel;

class LoginModel extends CommonModel {

	public $username;
	public $password;
	public $vcode;

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			['username', 'required', 'message' => '请输入用户名'],
			['password', 'required', 'message' => '请输入密码'],
			['vcode', 'required', 'message' => '请输入图形验证码', 'on' => 'errorFlow'],
			['vcode', 'captcha', 'captchaAction' => 'main/captcha', 'message' => '图形验证码不正确', 'on' => 'errorFlow'],
		];
	}

}
