<?php

namespace admin\controllers;

use common\controllers\AdminController;

/**
 * 任务
 */
class TaskController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '任务列表';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'add' => '添加',
        'edit' => '编辑',
        'del' => '删除',
        'sale' => '上架',
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
    protected $_table = 'task';

    public function beforeList(&$query) {
        $query->select('a.*,u.username,u.realname')->orderBy('id DESC')->leftJoin('{{%system_user}} u', 'u.id = a.create_by');
        if (($key = \Yii::$app->request->get('kw', '')) != '') {
            $query->andWhere("a.name LIKE '%$key%' OR a.description LIKE '%$key%'");
        }
        if (($status = \Yii::$app->request->get('status', '')) != '') {
            $query->andWhere(['a.status' => $status]);
        }
    }
    
    public function actionAdd() {
        $this->layout = 'index';
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\TaskService();
            $result = $service->add($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('添加任务', '添加任务' . $post['name'], 'ADD_TASK');
            }
            
            $result !== false ? $this->success('任务新增成功') : $this->error('任务新增失败');
        } else {
            $result['admin_title'] = '新增';
			$result['mode'] = 0;
            return $this->render('form', $result);
        }
    }
    
    public function actionEdit() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $this->_checkData($post);
            $service = new \admin\services\TaskService();
            $result = $service->update($post);
            
            if ($result !== false) {
                $systemLogService = new \admin\services\SystemLogService();
                $systemLogService->add('编辑任务', '编辑任务' . $post['name'], 'EDIT_TASK');
            }
            
            $result !== false ? $this->success('任务编辑成功') : $this->error('任务编辑失败');
        } else {
            $this->layout = 'index';
            $id = \Yii::$app->request->get('id');
            $service = new \admin\services\TaskService();
            $result = $service->getInfoById($id);
			$result['admin_title'] = '编辑';
            return $this->render('form', $result);
        }
    }

    private function _checkData(&$post) {
        if (empty($post['name']) || empty($post['name_en'])) {
            $this->error('请输入任务名称');
        }
        if (empty($post['description']) || empty($post['description_en'])) {
            $this->error('请输入任务描述');
        }
		$count = 0;
        for ($i = 1;$i < 7;$i++) {
			if (isset($post['ad_check_' . $i])) {
				if (empty($post['ad_pic_' . $i])) {
					$this->error('请上传图片');
				}
//				if (empty($post['ad_url_' . $i])) {
//					$this->error('请输入跳转链接');
//				}
//				if (empty($post['ad_merchant_' . $i])) {
//					$this->error('请输入广告商');
//				}
//				if (empty($post['ad_price_' . $i])) {
//					$this->error('请输入广告费');
//				}
//				if (empty($post['ad_remark_' . $i])) {
//					$this->error('请输入备注');
//				}
				$post['ad_check_' . $i] = 1;
				$count++;
			} else {
				$post['ad_check_' . $i] = 0;
			}
        }
		
		if ($count === 0) {
			$this->error('至少勾选一个');
		}
    }
    
    public function actionDel() {
        $service = new \admin\services\TaskService();
        $id = \Yii::$app->request->post('id');
        $task = $service->getInfoById($id, 'name');

        $result = $service->del($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('删除任务', '删除任务' . $task['name'], 'DEL_TASK');
        }
        
        $result !== false ? $this->success('任务删除成功') : $this->error('任务删除失败');
    }
    
    public function actionTakeOff() {
        $service = new \admin\services\TaskService();
        $id = \Yii::$app->request->get('id');
        $task = $service->getInfoById($id, 'name');
        
        $result = $service->takeOff($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('下架任务', '下架任务' . $task['name'], 'TAKEOFF_TASK');
        }
        
        $result !== false ? $this->success('任务下架成功') : $this->error('任务下架失败');
    }
    
    public function actionSale() {
        $service = new \admin\services\TaskService();
        $id = \Yii::$app->request->get('id');
        $task = $service->getInfoById($id, 'name');
        
        $result = $service->sale($id);
        if ($result !== false) {
            $systemLogService = new \admin\services\SystemLogService();
            $systemLogService->add('上架任务', '上架任务' . $task['name'], 'SALE_TASK');
        }
        
        $result !== false ? $this->success('任务上架成功') : $this->error('任务上架失败');
    }
	
	public function actionCarousel() {
		$this->layout = 'modal';
		$id = \Yii::$app->request->get('id');
		$service = new \admin\services\TaskService();
		$result = $service->getInfoById($id);
        return $this->render('carousel', $result);
	}

}
