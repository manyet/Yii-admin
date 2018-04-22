<?php

namespace admin\services;

use admin\models\SystemConfig;

/**
 * 参数配置业务类
 */
class SystemConfigService {

	const CACHE_KEY = 'config';

	public static function getConfigList($group = '', $field = '*') {
		$where = '`status` = 1';
		$group !== '' && $where .= ' AND `group` = ' . $group;
		return SystemConfig::find()->select($field)->where($where)->orderBy('`sort`')->asArray()->all();
	}

	public static function getAllGroup() {
		return array(
			'1' => '网站配置',
			'2' => '系统配置',
//			'3' => '邮件配置'
		);
	}

	public static function get($key = NULL) {
		static $config = NULL;
		if (is_null($config)) {
			// 从缓存读取
			$config = self::getFromCache();
			if (empty($config)) { // 从数据库读取
				$config = self::getFromDb();
				self::set($config); // 将配置写入缓存
			}
		}
		return is_null($key) ? $config : (isset($config[$key]) ? $config[$key] : NULL);
	}

	public static function getFromCache() {
		return S(self::CACHE_KEY);
	}

	public static function getFromDb() {
		$list = self::getConfigList('', '`name`,value,`type`');
		$config = array();
		foreach ($list as $row) {
			$config[$row['name']] = $row['type'] == 3 ? explode(',', $row['value']) : $row['value'];
		}
		return $config;
	}

	public static function set($key, $value = '') {
		$config = self::get();
		if (is_array($key)) {
			foreach ($key as $k => $val) {
				$config[$k] = $val;
			}
		} else {
			$config[$key] = $value;
		}
		S(self::CACHE_KEY, $config);
		return true;
	}

	public static function save($data) {
		foreach ($data as $key => &$value) {
			is_array($value) && $value = join(',', $value);
			$model = SystemConfig::findOne(['name' => $key]);
			$model->setAttributes([
				'value' => $value,
				'update_time' => time()
			]);
			if ($model->update(false) === false) {
				return false;
			}
		}
		return self::set($data);
	}

	public static function refresh() {
		return S(self::CACHE_KEY, NULL);
	}

}
