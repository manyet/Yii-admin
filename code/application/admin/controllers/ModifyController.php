<?php

namespace admin\controllers;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class ModifyController extends AdminController {
    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '公司分订单';

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
    protected $_table = 'modify_order';

    protected $status = 0;

    public function beforeList(&$query)
    {
        $getParams = \Yii::$app->request->get();
        $keyword = array_key_exists('kw', $getParams) && $getParams['kw'] !== '' ? $getParams['kw'] : '';
        $query->select('a.*,u.realname,u.uname,u.identity')->leftJoin('{{%user}} u', 'u.id = a.user_id')->orderBy('create_time DESC');
        if ($keyword !== '') {
            $query->where([
                'or',
                ['like', 'a.order_num', $keyword],
                ['like', 'u.uname', $keyword],
                ['like', 'u.realname', $keyword],
            ]);
        }
        if (($status = \Yii::$app->request->get('status', '')) != '') {
            $query->andWhere(['a.modify_type' => $status]);
        } if (($type = \Yii::$app->request->get('type', '')) != '') {
            $query->andWhere(['u.identity' => $type]);
        }
        if (\Yii::$app->request->get('export') !== NULL) {
            $select = $query->select;
            $query->select($select);
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
        //	玩家姓名	玩家账号	身份	调整前余额	调整分值	调整后余额	申请时间	调整类型
        $header = [
            'order_num' => '订单编号',
            'realname' => '玩家姓名',
            'uname' => '玩家账号',
            'identity|getidentity' => '身份',
            'balance_before' => '调整前余额',
            'type|getvalue' => '调整类型',
            'value' => '调整分值',
            'balance_after' => '调整后余额',
            'create_time|get_date,Y-m-d H:i:s' => '申请时间',
            'modify_type|getmodify' => '调整类型',
        ];
        $objPHPExcel->addNewSheet()->renderData($header, $data)->download('公司分订单' . date('Y-d-m'));
    }

}
