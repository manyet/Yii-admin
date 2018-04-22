<?php

namespace common\controllers;

/**
 * 后台公共控制器
 */
class AdminController extends BaseBackendController {

	/**
	 * 模块名称
	 * @var string
	 */
	public $module_title = '管理后台';

	public $pager = '\admin\widgets\Pager';

	/**
	 * 是否验证已登录
	 * @var boolean
	 */
	protected $_check_login = true;

	/**
	 * 是否验证权限
	 * @var boolean
	 */
	protected $_check_auth = true;

	/**
	 * 不需要进行权限验证的模块
	 */
	protected $_allow_list = array(
		'main/login',
		'main/do-login',
		'main/logout'
	);

}
