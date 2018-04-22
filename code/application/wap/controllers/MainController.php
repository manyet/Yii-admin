<?php

namespace wap\controllers;

use common\services\CommonService;
use common\controllers\WapController;
use pc\services\AdvertisingService;

/**
 * 首页控制器
 */
class MainController extends WapController {

	/**
	 * 首页
	 */
	public function actionIndex() {
		/* 字段处理 */
		if (useCommonLanguage()) {
			$package_field = 'package_name_en AS package_name';
		} else {
			$package_field = 'package_name';
		}
		/* 获取轮播图 */
		$carousel = CommonService::getCarousel('wap', 'advertising_Path,wap_Picture');
		/* 获取展示规则 */
        $features = CommonService::getFeatures('wap', 'title');
        /* 获取展示配套 */
		$package_service = new \pc\services\PackageService();
		$packages = $package_service->getALl('id,package_image_path,package_value,' . $package_field);
        /* 热门娱乐场 */
        $open['C'] = AdvertisingService::findAdvertisingOpen(3);
        $AdvertisingC = AdvertisingService::findAdvertisingC();
		return $this->render('index', [
			'packages' => $packages,
			'carousel' => $carousel,
			'features' => $features,
			'AdvertisingC' => $AdvertisingC,
			'open' => $open,
		]);
	}
    public  function actionDetail(){
        /* 功能介绍 */
        $features = AdvertisingService::findFeatures();
        return $this->render('detail',['features'=>$features]);
    }

}
