<?php

namespace admin\controllers;

use common\controllers\AdminController;

/**
 * 莫斯配套
 */
class MossPackageController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '莫斯配套';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'add' => '添加',
        'edit' => '编辑',
        'del' => '删除',
        'sale' => '发售',
        'take-off' => '下架',
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
    protected $_table = 'moss_package';

	/**
	 * 列表前置方法
	 * @param \yii\db\Query $query
	 */
    public function beforeList(&$query) {
        $query->select('a.*,u.username,u.realname')->where(['a.is_deleted' => 0])->orderBy('a.create_time DESC')->leftJoin('{{%system_user}} u', 'u.id = a.create_by');
        if (($key = \Yii::$app->request->get('kw', '')) != '') {
            $query->andWhere("a.package_name LIKE '%$key%'");
        }
        if (($status = \Yii::$app->request->get('status', '')) != '') {
            $query->andWhere(['a.package_status' => $status]);
        }
    }
    
    public function actionAdd() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\MossPackageService();
            $result = $service->add($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('添加配套', '添加配套' . $post['package_name'], 'ADD_MOSS_PACKAGE');
            }
            
            $result !== false ? $this->success('配套新增成功') : $this->error('配套新增失败');
        } else {
            $this->layout = 'index';
            $result = [];
            return $this->render('form', $result);
        }
    }
    
    public function actionEdit() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\MossPackageService();
            $result = $service->update($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('编辑配套', '编辑配套' . $post['package_name'], 'EDIT_MOSS_PACKAGE');
            }
            
            $result !== false ? $this->success('配套编辑成功') : $this->error('配套编辑失败');
        } else {
            $this->layout = 'index';
            $id = \Yii::$app->request->get('id');
            $service = new \admin\services\MossPackageService();
            $result = $service->getInfoById($id);
            return $this->render('form', $result);
        }
    }

    private function _checkData(&$post) {
        $arr = [
            'daily_dividend' => '每日分红',
            'task_benefit' => '任务收益',
            'direct_reward' => '直推奖励',
            'development_reward' => '发展奖励',
            'point_award' => '见点奖',
        ];
        $count = 0;
        foreach ($arr as $key => $name) {
            if (isset($post[$key]['checked'])) {
                $post[$key . '_check'] = 1;
                $count++;
                if (!isset($post[$key]['rate']) || $post[$key]['rate'] == '') {
                    $this->error('请输入' .$name . '比例');
                }
                if ($post[$key]['rate'] > 100) {
                    $this->error($name . '比例不能超过100%');
                }
				if (isset($post['point_award']['checked']) && empty($post['effective_hierarchy'])) {
					$this->error('请输入有效层级');
				}
			} else {
                $post[$key . '_check'] = 0;
            }
            if (isset($post[$key]['rate'])) {
                $post[$key . '_ratio'] = $post[$key]['rate'];
            }
            unset($post[$key]);
        }

        if ($count === 0) {
            $this->error('配套业务不能为空');
        }

    }
    
    public function actionDel() {
        $service = new \admin\services\MossPackageService();
        $id = \Yii::$app->request->get('id');
		
		$moss_package = $service->getInfoById($id, 'package_name, package_status, total_sales');
		if ($moss_package['total_sales'] > 0) {
			$this->error('有销量的配套不能删除');
		}
        
        $result = $service->del($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('删除配套', '删除配套' . $moss_package['package_name'], 'DEL_MOSS_PACKAGE');
        }
        
        $result !== false ? $this->success('配套删除成功') : $this->error('配套删除失败');
    }
    
    public function actionTakeOff() {
        $service = new \admin\services\MossPackageService();
        $id = \Yii::$app->request->get('id');
        $moss_package = $service->getInfoById($id, 'package_name');
        
        $result = $service->takeOff($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('下架配套', '下架配套' . $moss_package['package_name'], 'TAKEOFF_MOSS_PACKAGE');
        }
        
        $result !== false ? $this->success('配套下架成功') : $this->error('配套下架失败');
    }
    
    public function actionSale() {
        $service = new \admin\services\MossPackageService();
        $id = \Yii::$app->request->get('id');
        $moss_package = $service->getInfoById($id, 'package_name');
        
        $result = $service->sale($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('发售配套', '发售配套' . $moss_package['package_name'], 'SALE_MOSS_PACKAGE');
        }
        
        $result !== false ? $this->success('配套发售成功') : $this->error('配套发售失败');
    }

}
