<?php

namespace admin\controllers;

use admin\services\SystemUserService;
use admin\models\SystemRoleAccess;
use admin\widgets\Sidebar;
use admin\services\SystemMenuService;
use admin\services\SystemLogService;
use common\controllers\AdminController;

class MainController extends AdminController {

	protected $_check_login = false;

	/**
	 * 首页
	 */
	public function actionIndex() {
		if (isLogin()) {
			$menus = SystemMenuService::getMenus();
			return $this->render('index', [
				'info' => session('user'),
				'menus' => $menus,
				'sidebar' => Sidebar::widget(['menus' => $menus])
			]);
		} else {
			$this->redirect(['login']);
		}
	}

	/**
	 * 登陆页
	 */
	public function actionLogin() {
		if (isLogin()) {
			$this->redirect(\Yii::$app->homeUrl);
		} else {
			return $this->render('login', ['error_times' => intval(session('loginErrorTimes'))]);
		}
	}

	/**
	 * 登陆动作
	 */
	public function actionDoLogin() {
		if (\Yii::$app->request->isPost) {
			$error_times = intval(session('loginErrorTimes'));
			if ($error_times >= 10) {
				$this->error('错误次数太多，请20分钟后重试');
			}
			$scenario = NUll;
			if ($error_times >= 3) { // 要求输入验证码
				$scenario = 'errorFlow';
			}
			$post = \Yii::$app->request->post();
			$service = new SystemUserService($scenario);
			$res = $service->checkAdmin($post);
			if ($res) {
				// 处理权限列表
				$rbac = new \library\RBAC($res['id']);
				if (!$rbac->isAdministrator()) {
					$access_list = SystemRoleAccess::getAccessByRoles($res['role_id']);
					if (empty($access_list)) {
						$this->error('您的账号还没授予权限');
					}
					$rbac->initAccess($access_list);
				}
				$uname_key = 'uk';
				// 是否记住用户名
				if (!isset($post['remember'])) {
					setcookie($uname_key, '', time() - 1, '/');
				} else {
					setcookie($uname_key, $post['username'], 0, '/');
				}
				session('user', $res); // 写入用户信息
				session('loginErrorTimes', NULL);
				SystemLogService::add('系统登录', '用户登录系统成功', 'LOGIN_SUCCESS');
//				$redirect_url = \Yii::$app->request->get('redirectURL', '');
//				$this->success('登录成功，正在跳转页面', \Yii::$app->homeUrl . ($redirect_url === '' ? '' : '#' . $redirect_url));
				$this->success('登录成功，正在跳转页面', \Yii::$app->homeUrl);
				
			} else {
				session('loginErrorTimes', $error_times + 1);
				SystemLogService::add('系统登录', '[ ' . $post['username'] . ' ] 尝试登录失败，' . $service->errorMessage, 'LOGIN_FAIL');
				$this->error($service->errorMessage);
			}
		}
	}

	/**
	 * 退出登录
	 */
	public function actionLogout() {
		session('user', null);
		$this->success('退出登录成功', \yii\helpers\Url::toRoute('login'));
	}

	public function actions()
    {
        return  [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => null,
				'backColor' => 0xffffff,//背景颜色
				'maxLength' => 6, //最大显示个数
				'minLength' => 6,//最少显示个数
				'padding' => 5,//间距
				'height' => 40,//高度
				'width' => 130,  //宽度
				'foreColor' => 0x3c8dbc,     //字体颜色
				'offset' => 4,        //设置字符偏移量 有效果
			],
		];
	}

}
