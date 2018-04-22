<?php

namespace admin\controllers;
use admin\services\AdvertisingBService;
use Yii;
use admin\models\AdvertisingOpen;
use admin\services\AdvertisingAService;
use admin\services\SystemLogService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class AdvertisingBController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = 'MESPC广告位B';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'add' => '添加编辑页',
        'addlist' => '添加',
        'addlist' => '编辑',
        'del' => '删除',
        'release' => '发布',
    ];

    /**
     * 菜单模块选择器
     * @var array
     */
    public $menu = [
        'index' => '首页'
    ];
    protected $_table = 'advertising_b';

    protected $status = 0;

    public function beforeList(&$query)
    {
        $getParams = \Yii::$app->request->get();
        $keyword = array_key_exists('keyword', $getParams) && $getParams['keyword'] !== '' ? $getParams['keyword'] : '';
        $query->select([]);

        if ($keyword !== '') {
            $query->where([
                'or',
                ['like', 'advertising_name', $keyword],
                ['like', 'advertising_describe', $keyword],
            ]);
        }
        $query->orderBy('id desc');

    }

    /**
     * @return array列表数组
     */
    public function afterList(&$list)
    {
        $userService = new AdvertisingAService();
        $open = $userService->findAdvertisingOpen(['id'=>2]);
        $view=Yii::$app->view;
        $view->params['open'] = $open;

    }
    /**
     * 开启广告位
     */
    public function actionOpen() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $userService = new AdvertisingBService();
            $result = $userService->checkAdvertisingB();
            if ($post['open']==1){
                $note='无广告组发布，开启广告位失败' ;
            }else{
                $note='无广告组发布，关闭广告位失败' ;
            }
            if(empty($result['id'])){
                $this->error($note);
            }
            $model = new AdvertisingOpen();
            $one = $model->findOne(2);
            $one->setAttributes($post);

            if ($one->validate()) {
                //写入日志
                $LogService = new SystemLogService();
                if ($post['open']==1){
                    $Log='开启广告位B' ;
                    $success='广告已开启' ;
                }else{
                    $Log='关启广告位B' ;
                    $success='广告已关闭' ;
                }
                $LogService->add('广告位B开关',$Log,'Open');
                $result = $one->update();

                $result !== false ? $this->success($success) : $this->error('开启失败，请稍候重试');
            } else {
                //获得第一条错误
                $this->error(current($one->getFirstErrors()));
            }
        }
    }
    /**
     * 新增页面展示
     */
    public function actionAdd() {
        $this->layout = 'index';
        $post['id']= \Yii::$app->request->get('id');
        $view=Yii::$app->view;
        if ($post['id']){
            $userService = new AdvertisingBService();
            $result = $userService->findAdvertisingB($post);
            $title='编辑广告组';
            $view->params['title'] = $title;
        }else{
            $title='新增广告组';
            $view->params['title'] = $title;
            $result=[];
        }
//        var_dump($result);exit();
        return $this->render('add',$result);
    }
    /**
     * 新增广告and修改
     */
    public function actionAddlist() {
        $post = \Yii::$app->request->post();
        if ($post['id']){

            if (empty($post['advertising_name'])){
                $this->error('广告组名称不能为空');
            }
            if (empty($post['advertising_describe'])){
                $this->error('广告组描述不能为空');
            }

            if (empty($post['advertising_Picture1'])) {
                $this->error('序号1图片上传不能为空');
            }
            if (!is_exchange($post['price1'])&&!empty($post['price1'])) {
                $this->error('序号1请输入正确广告费');

            }
            if (empty($post['advertising_Picture2'])) {
                $this->error('序号2图片上传不能为空');
            }
            if (!is_exchange($post['price2'])&&!empty($post['price2'])) {
                $this->error('序号2请输入正确广告费');

            }
            if (empty($post['advertising_Picture3'])) {
                $this->error('序号3图片上传不能为空');
            }
            if (!is_exchange($post['price3'])&&!empty($post['price3'])) {
                $this->error('序号3请输入正确广告费');

            }
            if (empty($post['advertising_Picture4'])) {
                $this->error('序号4图片上传不能为空');
            }
            if (!is_exchange($post['price4'])&&!empty($post['price4'])) {
                $this->error('序号4请输入正确广告费');

            }
            if (isset($post['b_open1'])){
                $post['b_open1']=1;
            }else{
                $post['b_open1']=0;
            }if (isset($post['b_open2'])){
                $post['b_open2']=1;
            }else{
                $post['b_open2']=0;
            }if (isset($post['b_open3'])){
                $post['b_open3']=1;
            }else{
                $post['b_open3']=0;
            }if (isset($post['b_open4'])){
                $post['b_open4']=1;
            }else{
                $post['b_open4']=0;
            }
            $model = new \admin\models\AdvertisingB();
            $one = $model->findOne($post['id']);
            $one->setAttributes($post);

            if ($one->validate()) {
                $result = $one->update();
                $result !== false ? $this->success('广告编辑成功') : $this->error('广告编辑失败，请稍候重试');
            } else {
                //获得第一条错误
                $this->error(current($one->getFirstErrors()));
            }
        }else{
            $post = \Yii::$app->request->post();
            if (empty($post['advertising_name'])){
                $this->error('广告组名称不能为空');
            }
            if (empty($post['advertising_describe'])){
                $this->error('广告组描述不能为空');
            }

            if (empty($post['advertising_Picture1'])) {
                $this->error('序号1图片上传不能为空');
            }
            if (!is_exchange($post['price1'])&&!empty($post['price1'])) {
                $this->error('序号1请输入正确广告费');

            }
            if (empty($post['advertising_Picture2'])) {
                $this->error('序号2图片上传不能为空');
            }
            if (!is_exchange($post['price2'])&&!empty($post['price2'])) {
                $this->error('序号2请输入正确广告费');

            }
            if (empty($post['advertising_Picture3'])) {
                $this->error('序号3图片上传不能为空');
            }
            if (!is_exchange($post['price3'])&&!empty($post['price3'])) {
                $this->error('序号3请输入正确广告费');

            }
            if (empty($post['advertising_Picture4'])) {
                $this->error('序号4图片上传不能为空');
            }
            if (!is_exchange($post['price4'])&&!empty($post['price4'])) {
                $this->error('序号4请输入正确广告费');

            }
            if (isset($post['b_open1'])){
                $post['b_open1']=1;
            }else{
                $post['b_open1']=0;
            }if (isset($post['b_open2'])){
                $post['b_open2']=1;
            }else{
                $post['b_open2']=0;
            }if (isset($post['b_open3'])){
                $post['b_open3']=1;
            }else{
                $post['b_open3']=0;
            }if (isset($post['b_open4'])){
                $post['b_open4']=1;
            }else{
                $post['b_open4']=0;
            }
            $userService = new AdvertisingBService();
            $u['id']=$userService->getIdB();
            if (!empty($u['id'])){
                $u['open']=0;
                $userService->UpB($u);
            }
            if ($userService->addAdvertisingB($post) === true) {
                //写入日志
                $LogService = new SystemLogService();
                $Log='添加广告A';
                $LogService->add('添加广告A',$Log,'addAdvertisingA');
                $this->success('广告新增成功');
            } else {
                $this->error('广告新增失败，请稍候重试');
            }
        }
    }
    /**
     * 删除广告A
     */
    public function actionDel() {
        $id = \Yii::$app->request->post('id');

        is_array($id) && $id = join(',', $id);
        if (!\Yii::$app->request->isPost || empty($id)) {
            $this->error('非法请求');
        }
        $service = new AdvertisingBService();
        $result = $service->delAdvertisingB($id);
        if (!$result) {
            $this->error($service->errMsg);
        }
        //写入日志
        $LogService = new SystemLogService();
        $Log='';
        $LogService->add('删除广告A',$Log,'delAdvertisingB');
        $this->success('删除成功');
    }
    /**
     * 广告A发布
     */
    public function actionRelease(){
        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->post('id', '');
            if ($id === '' || $id == 0) {
                $this->error('参数传入缺失');
            }
            $status = \Yii::$app->request->post('status');
            if ($status == 1) {
                $userService = new AdvertisingBService();
                $u['id']=$userService->getIdB();
                if (!empty($u['id'])){
                    $u['open']=0;
                    $userService->UpB($u);
                }
                $result = AdvertisingBService::ReleaseB($id);
                $text = '发布';
            } else {
                $userService = new AdvertisingBService();
                $u['id']=$userService->getIdB();
                if (!empty($u['id'])){
                    $u['open']=0;
                    $userService->UpB($u);
                }
                $result = AdvertisingBService::ReleaseB($id);
                $text = '发布';
            }
            if ($result !== false) {
                $this->success("{$text}成功");
            } else {
                $this->error("{$text}失败");
            }
        } else {
            $this->error('不支持该请求方式');
        }

    }

}
