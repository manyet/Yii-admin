<?php

namespace common\services;

use common\models\Description;

class DescriptionService {

	const CACHE_KEY = 'description';

	public static function get($key = NULL) {
		static $config = NULL;
		if (empty($config)) {
			$config = self::getFromCache();
			if (empty($config)) { // 从数据库读取
				$config = self::getFromDb();
				self::set($config); // 将配置写入缓存
			}
		}
		if (is_null($key)) {
			return $config;
		}
		return isset($config[$key]) ? str_replace(PHP_EOL, '<br/>', $config[$key][useCommonLanguage() ? 'eng_content' : 'content']) : NULL;
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
		return S(self::CACHE_KEY, $config);
	}

	public static function getFromCache() {
		return S(self::CACHE_KEY);
	}

	public static function getFromDb() {
		$list = Description::find()->select('key,eng_content,content')->asArray()->all();
		$config = array();
		foreach ($list as $row) {
			$key = $row['key'];
			unset($row['key']);
			$config[$key] = $row;
		}
		return $config;
	}

	public static function refresh() {
		return S(self::CACHE_KEY, NULL);
	}

}
