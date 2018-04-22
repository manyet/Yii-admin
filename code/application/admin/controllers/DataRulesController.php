<?php

namespace admin\controllers;
use Yii;
use admin\services\AdvertisingAService;
use admin\services\DataRulesService;
use admin\models\AdvertisingOpen;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class DataRulesController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = '数据规则';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'add' => '添加编辑页',
        'addlist' => '添加',
        'addlist' => '编辑',
    ];
    /**
     * 开启广告位
     */
    public function actionOpen() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model = new AdvertisingOpen();
            $one = $model->findOne(4);
            $one->setAttributes($post);

            if ($one->validate()) {
                if ($post['open']==1){
                    $success='数据规则已开启' ;
                }else{
                    $success='数据规则已关闭' ;
                }
                $result = $one->update();

                $result !== false ? $this->success($success) : $this->error('开启失败，请稍候重试');
            } else {
                //获得第一条错误
                $this->error(current($one->getFirstErrors()));
            }
        }
    }



    public function actionAdd() {

        $this->layout = 'index';
        $userService = new DataRulesService();
        $list= $userService->findDataRules();
        $result=$list?$list:[];
        $userService = new AdvertisingAService();
        $open = $userService->findAdvertisingOpen(['id'=>4]);
        $view=Yii::$app->view;
        $view->params['open'] = $open;
        return $this->render('add',$result);
    }
    /**
     * 新增广告and修改
     */
    public function actionAddlist() {
        $post = \Yii::$app->request->post();
        if (!empty($post['id'])){
            $model = new \admin\models\DataRules();
            $one = $model->findOne($post['id']);
            $one->setAttributes($post);

            if ($one->validate()) {
                $result = $one->update();
                $result !== false ? $this->success('更新成功') : $this->error('更新失败，请稍候重试');
            } else {
                //获得第一条错误
                $this->error(current($one->getFirstErrors()));
            }
        }else{
//            var_dump($post);exit();
            $userService = new DataRulesService();
            if ($userService->addDataRules($post) === true) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败，请稍候重试');
            }
        }
    }
}
