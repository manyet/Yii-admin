<?php

namespace admin\controllers;

use common\controllers\AdminController;

/**
 * 配套订单
 */
class PackageOrderController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '配套订单';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'cancel' => '取消',
        'view' => '查看',
    ];

    /**
     * 菜单模块选择器
     * @var array
     */
    public $menu = [
        'index' => '首页'
    ];

    /**
     * 表名
     * @var string
     */
    protected $_table = 'package_order';

    public function beforeList(&$query) {
        $query->select('a.*,u.uname,u.realname,p.package_name,p.package_value')
            ->leftJoin('{{%user}} u', 'u.id = a.user_id')
            ->leftJoin('{{%moss_package}} p', 'p.id = a.package_id')
            ->orderBy('a.buy_time DESC');

        if (($key = \Yii::$app->request->get('kw', '')) != '') {
            $query->andWhere("a.order_num LIKE '%$key%' OR u.realname LIKE '%$key%' OR u.uname LIKE '%$key%'");
        }

        if (($status = \Yii::$app->request->get('status', '')) != '') {
            $query->andWhere(['a.package_status' => $status]);
        }
    }

//    public function actionCancel() {
//        if (\Yii::$app->request->isPost) {
//            $post = \Yii::$app->request->post();
//            $service = new \admin\services\PackageOrderService();
//            $package_order = $service->getInfoById($post['id'], 'order_num');
//
//            $result = $service->cancel($post);
//            if ($result !== false) {
//                $systemLogService = new \admin\services\SystemLogService();
//                $systemLogService->add('取消配套订单', '取消配套订单' . $package_order['order_num'], 'CANCEL_PACKAGE_ORDER');
//            }
//
//            $result !== false ? $this->success('取消订单成功') : $this->error('取消订单失败');
//        } else {
//            $this->layout = 'modal';
//            $result['id'] = \Yii::$app->request->get('id');
//            return $this->render('form', $result);
//        }
//    }

    public function actionView() {
        $this->layout = 'modal';
        $id = \Yii::$app->request->get('id');
        $service = new \admin\services\PackageOrderService();
        $result = $service->getInfoById($id, 'remark');
        return $this->render('view', $result);
    }

}
