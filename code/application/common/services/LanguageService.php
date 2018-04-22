<?php

namespace common\services;

use Yii;
use common\models\User;

/**
 * 语言服务类
 */
class LanguageService {


	public static function getLanguage() {
		return Yii::$app->language;
	}

	public static function setLanguage($locale, $update = true) {
		$languages = self::getAvailableLanguage();
		if (!isset($languages[$locale])) {
			return false;
		}
		if ($update && isLogin()) {
			$model = User::findOne(getUserId());
			$model->setAttribute('language', $locale);
			$model->update();
		}
		$l_cookie = new \yii\web\Cookie(['name' => 'language', 'value' => $locale, 'expire' => time() + 3600 * 24 * 30]);
		Yii::$app->response->cookies->add($l_cookie);
		Yii::$app->language = $locale;
	}

	public static function getAvailableLanguage() {
		return [
			'en-US' => 'English',
			'zh-CN' => '中文',
		];
	}

	public static function setLanguageTemp($language) {
		static $default_language = NULL;
		if (empty($default_language)) {
			$default_language = Yii::$app->params['systemDefaultLanguage'];
		}
		Yii::$app->language = empty($language) ? $default_language : $language;
	}

	public static function getLanguageName($language = NULL) {
		if (is_null($language)) {
			$language = Yii::$app->params['systemDefaultLanguage'];
		}
		$arr = self::getAvailableLanguage();
		return isset($arr[$language]) ? $arr[$language] : '未知';
	}

	public static function getUserLanguage($language) {
		return empty($language) ? Yii::$app->params['systemDefaultLanguage'] : $language;
	}

}
