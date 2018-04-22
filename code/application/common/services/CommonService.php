<?php

namespace common\services;

use pc\services\AdvertisingService;

/**
 * 公共业务
 */
class CommonService {

	public static $carousel_cache_key = 'carousel_';
	public static $carousel_length = 6;
	public static $features_cache_key = 'features_';
	public static $features_length = 6;

	/**
	 * 获取轮播
	 */
	public static function getCarousel($type = 'pc', $fields = '*') {
		$open = AdvertisingService::findAdvertisingOpen(1);
		if (!$open) { // 是否开启轮播图
			return NULL;
		}
		$cache_key = self::$carousel_cache_key . $type;
		$data = S($cache_key);
		if (empty($data)) {
			$data = [];
			!is_array($fields) && $fields = explode(',', $fields);
			$feature_field = ['c_open1,c_open2,c_open3,c_open4,c_open5,c_open6'];
			$need_path = in_array('advertising_Path', $fields);
			$need_image = in_array('advertising_Picture', $fields);
			$need_wap_image = in_array('wap_Picture', $fields);
			if ($need_path) {
				$feature_field[] = 'advertising_Path1,advertising_Path2,advertising_Path3,advertising_Path4,advertising_Path5,advertising_Path6';
			}
			if ($need_image) {
				$feature_field[] = 'advertising_Picture1,advertising_Picture2,advertising_Picture3,advertising_Picture4,advertising_Picture5,advertising_Picture6';
			}
			if ($need_wap_image) {
				$feature_field[] = 'wap_Picture1,wap_Picture2,wap_Picture3,wap_Picture4,wap_Picture5,wap_Picture6';
			}
			$pic_key = $type == 'wap' ? 'wap_Picture' : 'advertising_Picture';
			$carousel = AdvertisingService::findAdvertisingA(join(',', $feature_field));
			for ($i = 1; $i <= self::$carousel_length; $i++) {
				if (!empty($carousel[$pic_key . $i]) && intval($carousel['c_open' . $i]) === 1) {
					$tmp = array();
					$need_image && $tmp['advertising_Picture'] = $carousel['advertising_Picture' . $i];
					$need_path && $tmp['advertising_Path'] = $carousel['advertising_Path' . $i];
					$need_wap_image && $tmp['wap_Picture'] = $carousel['wap_Picture' . $i];
					$data[] = $tmp;
				}
			}
			S($cache_key, $data);
		}
		return $data;
	}

	/**
	 * 获取功能介绍
	 */
	public static function getFeatures($type = 'pc', $fields = '*') {
		$cache_key = self::$features_cache_key . $type;
		$data = S($cache_key);
		if (empty($data)) {
			!is_array($fields) && $fields = explode(',', $fields);
			$need_title = in_array('title', $fields);
			$need_details = in_array('details', $fields);
			$need_summary = in_array('summary', $fields);
			$need_image = in_array('features_Picture', $fields);
			$feature_field = ['features_open1,features_open2,features_open3,features_open4,features_open5,features_open6'];
			if ($need_title) {
				$feature_field[] = 'e_title1,title1,e_title2,title2,e_title3,title3,e_title4,title4,e_title5,title5,e_title6,title6';
			}
			if ($need_details) {
				$feature_field[] = 'e_details1,details1,e_details2,details2,e_details3,details3,e_details4,details4,e_details5,details5,e_details6,details6';
			}
			if ($need_summary) {
				$feature_field[] = 'e_summary1,summary1,e_summary2,summary2,e_summary3,summary3,e_summary4,summary4,e_summary5,summary5,e_summary6,summary6';
			}
			if ($need_image) {
				$feature_field[] = 'features_Picture1,features_Picture2,features_Picture3,features_Picture4,features_Picture5,features_Picture6';
			}
			$service = new AdvertisingService();
			$features = $service->findFeatures(join(',', $feature_field));
			$data = [];
			for ($i = 1; $i <= self::$features_length; $i++) {
				if (intval($features['features_open' . $i]) === 1) {
					$tmp = array('id' => $i);
					if ($need_title) {
						$tmp['title'] = $features['title' . $i];
						$tmp['e_title'] = $features['e_title' . $i];
					}
					if ($need_details) {
						$tmp['details'] = $features['details' . $i];
						$tmp['e_details'] = $features['e_details' . $i];
					}
					if ($need_summary) {
						$tmp['summary'] = $features['summary' . $i];
						$tmp['e_summary'] = $features['e_summary' . $i];
					}
					if ($need_image) {
						$tmp['features_Picture'] = $features['features_Picture' . $i];
					}
					$data[] = $tmp;
				}
			}
			S($cache_key, $data);
		}
		return $data;
	}

	/**
	 * 刷新轮播图缓存
	 */
	public static function refreshCarousel($type = 'pc') {
		return S(self::$carousel_cache_key . $type, NULL);
	}

	/**
	 * 刷新功能介绍缓存
	 */
	public static function refreshFeatures($type = 'pc') {
		return S(self::$features_cache_key . $type, NULL);
	}

}
