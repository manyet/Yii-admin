<?php

namespace admin\controllers;

use common\controllers\AdminController;

/**
 * 业务规则
 */
class BusinessRuleController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '业务规则';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'add' => '添加',
        'edit' => '编辑',
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
    protected $_table = 'business_rule';
    
    /**
     * @var boolean 分页开关
     */
    protected $_page_on = false;

    public function beforeList(&$query) {
        $query->select('a.*,u.username,u.realname')->leftJoin('{{%system_user}} u', 'u.id = a.create_by');
    }
    
    public function actionAdd() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\BusinessRuleService();
            $result = $service->add($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('添加业务规则', '添加业务规则' . $post['business_name'], 'ADD_WALLET_RULE');
            }
            
            $result !== false ? $this->success('业务规则新增成功') : $this->error('业务规则新增失败');
        } else {
            $this->layout = 'modal';
            $result = [];
            return $this->render('form', $result);
        }
    }
    
    private function _checkData(&$post) {
        $arr = [
            'company_score' => '公司分红',
            'cash_score' => '现金分',
            'entertainment_score' => '娱乐分',
            'procedures_score' => '手续分'
        ];
        $arr_wallet = [];
        foreach ($arr as $key => $name) {
            if (isset($post[$key . '_ratio']) && $post[$key . '_ratio'] != '') {
                $arr_wallet[] = $post[$key . '_ratio'];
            }
        }
        if (!empty($arr_wallet) && array_sum($arr_wallet) != 100) {
            $this->error('钱包发放比例合计为100%');
        }
		if (intval($post['limit_type']) === 3 && $post['limit_value'] == '') {
			$this->error('请输入固定值');
		}
    }
    
    public function actionEdit() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\BusinessRuleService();
            $result = $service->update($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('编辑业务规则', '编辑业务规则' . $post['business_name'], 'EDIT_WALLET_RULE');
            }
            
            $result !== false ? $this->success('业务规则编辑成功') : $this->error('业务规则编辑失败');
        } else {
            $this->layout = 'modal';
            $id = \Yii::$app->request->get('id');
            $service = new \admin\services\BusinessRuleService();
            $result = $service->getInfoById($id);
            return $this->render('form', $result);
        }
    }

}
