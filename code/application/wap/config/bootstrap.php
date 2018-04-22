<?php

function isLogin() {
	return !!getUserId();
}

/**
 * 获取用户ID
 * @return int
 */
function getUserId()
{
    return getUserInfo('id');
}

/**
 * 获取用户信息
 * @param string $key 某个键值
 * @return array|NULL
 */
function getUserInfo($key = NULL)
{
    $userInfo = session('memberInfo');
    if (empty($userInfo)) {
        return null;
    }
    return is_null($key) ? $userInfo : (isset($userInfo[$key]) ? $userInfo[$key] : NULL);
}

/**
 * 写入登录信息
 * @return boolean
 */
function setUserInfo($info, $remember = false)
{
	setcookie('stay_login', 1, $remember ? 0 : time() - 1, '/');
    return session('memberInfo', $info);
}

/**
 * 注销登录
 * @return boolean
 */
function logout()
{
    return session('memberInfo', null);
}

/**
 * 获取系统配置
 */
function get_system_config($key = NULL) {
	return \admin\services\SystemConfigService::get($key);
}