<?php

namespace admin\controllers;

use common\controllers\AdminController;
use admin\services\NoticeService;
/**
 * 消息管理
 */
class NoticeController extends AdminController {
    

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '消息列表';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '消息列表',
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
    protected $_table = 'notice';
    
    public static $type = [
        1 => '普通玩家',
        2 => '领导人'
    ];

    public function beforeList(&$query) {
        $query ->orderBy(['a.create_time' => SORT_DESC]);

        //消息标题
        if (($keyword = \Yii::$app->request->get('keyword', '')) != '') {
            $query->where([
                'or',
                ['like', 'title', $keyword],
            ]);
        }
        //拼接时间日期
        $start_date = \Yii::$app->request->get('start_date', '');
        $end_date = \Yii::$app->request->get('end_date', '');
        if ($start_date !== '' && $end_date === '') {
            $query->andWhere(['>=', 'a.create_time', strtotime($start_date)]);
        } else if ($start_date === '' && $end_date !== '') {
            $query->andWhere(['<=', 'a.create_time', strtotime($end_date)]);
        } else if ($start_date !== '' && $end_date !== '') {
            $query->andWhere(['between', 'a.create_time', strtotime($start_date), strtotime($end_date)]);
        }
    }

    public function afterList(&$list) {
        $type_temp = [];
        foreach ($list as $k => $l) {
            $type_arr = explode(',', $l['type']);
            foreach ($type_arr as $t) {
                if (array_key_exists($t, self::$type)) {
                    $type_temp[] = self::$type[$t];
                }
            }
            $list[$k]['type'] = implode(',', $type_temp);
            unset($type_temp, $type_arr);
        }
        //var_dump($list);
    }
    
    public function actionView() {
        $id = \Yii::$app->request->get('id');
        
        $service = new NoticeService();
        $result = $service->getInfoById($id);

        $type_temp = [];
        $type_arr = explode(',', $result['type']);
        foreach ($type_arr as $t) {
            if (array_key_exists($t, self::$type)) {
                $type_temp[] = self::$type[$t];
            }
        }
        $type_str = implode(',', $type_temp);
        unset($type_temp, $type_arr);
        $result['type'] = $type_str;
        
        //var_dump($result);
        $this->layout = 'modal';
        return $this->render('view', $result);
    }
    
    public function actionDel() {
        $id = \Yii::$app->request->post('id');
        if (!\Yii::$app->request->isPost || empty($id)) {
            $this->error('非法请求');
        }

        $service = new NoticeService();
        $result = $service->deleteById($id);

        if (!$result) {
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }
    
    public function actionEdit() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $type_id = empty($post['type_id']) ? '' : join(',', $post['type_id']);
            $post['type'] = $type_id;

            $noticeService = new NoticeService();
            $result = $noticeService->updateInfo($post);
            $result !== false ? $this->success() : $this->error();
        } else {
            $id = \Yii::$app->request->get('id');
            $noticeService = new NoticeService();
            $result = $noticeService->getInfoById(['id' => $id]);
            $this->layout = 'modal';
            return $this->render('form', $result);
        }
    }
    
    public function actionAdd() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $post['user_id'] = getUserId();
            if (empty($post['type_id'])) {
                $this->error('发送对象不能为空');
            }

            $type_id = empty($post['type_id']) ? '' : join(',', $post['type_id']);
            $post['type'] = $type_id;
            $noticeService = new NoticeService();
            $result = $noticeService->addNotice($post);

            $result !== false ? $this->success() : $this->error();
        } else {
            $this->layout = 'modal';
            return $this->render('form');
        }
    }

}
