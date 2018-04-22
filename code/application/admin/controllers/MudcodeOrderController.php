<?php

namespace admin\controllers;

use common\controllers\AdminController;

/**
 * 泥码订单
 */
class MudcodeOrderController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '泥码订单';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
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
    protected $_table = 'exchange_record';

    public function beforeList(&$query) {
        $query->select('a.*,u.uname,u.realname,c.casino_name')
            ->leftJoin('{{%user}} u', 'u.id = a.user_id')
            ->leftJoin('{{%casino}} c', 'c.id = a.casino_id')
            ->orderBy('a.create_time DESC');

        if (($key = \Yii::$app->request->get('kw', '')) != '') {
            $query->andWhere("a.number LIKE '%$key%' OR u.realname LIKE '%$key%' OR u.uname LIKE '%$key%' OR c.casino_name LIKE '%$key%'");
        }

        if (($start_date = \Yii::$app->request->get('start_date', '')) != '') {
            $start_date = strtotime($start_date);
            $query->andWhere("a.create_time >= $start_date");
        }
        if (($end_date = \Yii::$app->request->get('end_date', '')) != '') {
            $end_date = strtotime($end_date);
            $query->andWhere("a.create_time <= $end_date");
        }
        
        if (\Yii::$app->request->get('export') !== null) {
            $this->_page_on = false;
        }
    }
    
    public function afterList(&$list) {
        if (\Yii::$app->request->get('export') !== null) {
            $this->_export($list);
        }
    }
    
    /**
     * 导出操作
     */
    private function _export($data = []) {
        require LIBRARY_PATH . '/phpExcel/Excel.php';
        $objPHPExcel = new \Excel();
        //表头
        $header = [
            'number' => '订单编号',
            'realname' => '玩家姓名',
            'uname' => '玩家账号',
            'amount|getCasinoWallet' => '钱包消耗',
            'count' => '兑换泥码',
            'casino_name' => '兑换赌场',
            'code' => '核销码',
            'create_time|get_now_date,Y-m-d H:i:s' => '兑换时间',
        ];
        $objPHPExcel->addNewSheet()->renderData($header, $data)->download('泥码订单记录' . date('Y-d-m'));
    }

}
