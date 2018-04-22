<?php

/**
 * 资源文件路径
 */
function get_static_url($path = '')
{
    return \Yii::getAlias('@web') . '/static/' . $path;
}

/**
 * CSS资源文件路径
 */
function get_css_url($path = '')
{
    return get_static_url('dist/css/' . $path);
}

/**
 * JS资源文件路径
 */
function get_js_url($path = '')
{
    return get_static_url('dist/js/' . $path);
}

/**
 * 图片资源文件路径
 */
function get_img_url($path = '')
{
    return get_static_url('dist/img/' . $path);
}

/**
 * 获取插件目录路径
 */
function get_plugin_url($path = '')
{
    return get_static_url('plugin/' . $path);
}

/**
 * 后台框架资源文件路径
 */
function get_platform_url($path = '')
{
    return get_static_url('platform/' . $path);
}

/**
 * 是否已经登录
 * @return bool
 */
function isLogin()
{
    return !!session('user');
}

/**
 * 获取用户信息
 * @param string $key 某个键值
 * @return array|NULL
 */
function getUserInfo($key = NULL)
{
    $userInfo = session('user');
    if (is_null($userInfo)) {
        return null;
    }
    return is_null($key) ? $userInfo : (isset($userInfo[$key]) ? $userInfo[$key] : NULL);
}

/**
 * 获取用户信息
 */
function getUserId(){
	return getUserInfo('id');
}

/**
 * 权限检查
 */
function checkAuth($path){
	static $rbac = NULL;
	if (is_null($rbac)) {
		$rbac = new \library\RBAC(getUserId());
	}
	return $rbac->checkAuth($path);
}

/**
 * 获取系统配置
 */
function get_system_config($key = NULL) {
	return \admin\services\SystemConfigService::get($key);
}

function renderTable($config) {
	return \admin\widgets\Table::widget($config);
}

function getCommonJs(){
	return \admin\widgets\CommonJs::widget();
}

function getIndexJs(){
	return \admin\widgets\IndexJs::widget();
}

/**
 * 判断是否是合法的固定长度字符串   只允许数字或者字母
 * @param $str
 * @param int $min 最小长度
 * @param int $max 最大长度
 * @return int
 */
function is_str_len($str, $min = 6, $max = 20)
{
    return preg_match('/^[A-Za-z0-9]{' . $min . ',' . $max . '}$/', $str);
}

function is_str_lennum($str, $min = 3, $max = 3)
{
    return preg_match('/^[0-9]{' . $min . ',' . $max . '}$/', $str);
}
function is_exchange($str)
{
    return preg_match('/^[0-9]+(\.[0-9]+)?$/',$str);
}
/**
 * 统计字符串中子串个数
 * @param $string
 * @param string $delimiter
 * @return mixed
 */
function get_string_count($string, $delimiter = ',')
{
    return count(array_filter(explode($delimiter, $string)));//分割->去空->计数;
}

/**
 * 兑换泥码钱包消耗
 */
function getCasinoWallet($amount) {
	return '娱乐分 ' . number_format($amount, 2);
}

function getCasinoUserRank($key = TRUE) {
	$remarks = [
		'1' => '管理员',
		'2' => '员工'
	];
	if ($key === TRUE) {
		return $remarks;
	}
	return isset($remarks[$key]) ? $remarks[$key] : NULL;
}
