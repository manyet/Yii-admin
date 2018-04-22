<?php

namespace wap\controllers;

use pc\services\CasinoService;
use common\controllers\WapController;

/**
 * 首页控制器
 */
class CasinoController extends WapController {

	/**
	 * 首页
	 */
	public function actionIndex() {
		$list = [['id' => 1]];
		return $this->render('index', ['list' => $list, 'total' => 1]);
	}

	/**
	 * 获取数据
	 */
	public function actionGetData() {
		$get = \Yii::$app->request->get();
		$pageParams['page'] = !empty($get['page']) ? $get['page'] : 1;
		$pageParams['pageSize'] = !empty($get['rows']) ? $get['rows'] : 10;
		$key = !empty($get['key']) ? $get['key'] : '';
		$Service = new CasinoService();
		$data = $Service->getCasinoListByKeyword($key, $pageParams);
		$this->ajaxReturn($data);
	}
    /**
     * 详情
     */
    public function actionDetail() {
        $get = \Yii::$app->request->get();
        $Service =new CasinoService();
        $detail = $Service->findCasino($get);
        return $this->render('detail',['detail' => $detail]);
    }

}
