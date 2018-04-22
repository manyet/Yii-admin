<?php

namespace admin\controllers;
use admin\services\AdvertisingAService;
use Yii;
use admin\models\AdvertisingOpen;
use admin\services\AdvertisingCService;
use admin\services\SystemLogService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class AdvertisingCController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = 'MESPC广告位C';

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
    protected $_table = 'advertising_c';

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
        $open = $userService->findAdvertisingOpen(['id'=>3]);
        $view=Yii::$app->view;
        $view->params['open'] = $open;

    }
    /**
     * 开启广告位
     */
    public function actionOpen() {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $userService = new AdvertisingCService();
            $result = $userService->checkAdvertisingC();
            if ($post['open']==1){
                $note='无广告组发布，开启广告位失败' ;
            }else{
                $note='无广告组发布，关闭广告位失败' ;
            }
            if(empty($result['id'])){
                $this->error($note);
            }
            $model = new AdvertisingOpen();
            $one = $model->findOne(3);
            $one->setAttributes($post);

            if ($one->validate()) {
                //写入日志
                $LogService = new SystemLogService();
                if ($post['open']==1){
                    $Log='开启广告位C' ;
                    $success='广告已开启' ;
                }else{
                    $Log='关启广告位C' ;
                    $success='广告已关闭' ;
                }
                $LogService->add('广告位C开关',$Log,'Open');
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
            $userService = new AdvertisingCService();
            $result = $userService->findAdvertisingC($post);
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
                $this->error('Top1图片上传不能为空');
            }
            if (empty($post['flag_Picture1'])) {
                $this->error('Top1国旗上传不能为空');
            }
            if (empty($post['casino_name1'])) {
                $this->error('Top1赌场名称不能为空');
            }
            if (empty($post['price1'])) {
                $this->error('Top1赌资金额不能为空');
            }
            if (!is_exchange($post['price1'])&&!empty($post['price1'])) {
                $this->error('Top1请输入正确广告费');

            }
            if (empty($post['number1'])) {
                $this->error('Top1玩家人数不能为空');
            }
            if (empty($post['advertising_Picture2'])) {
                $this->error('Top2图片上传不能为空');
            }
            if (empty($post['flag_Picture2'])) {
                $this->error('Top2国旗上传不能为空');
            }
            if (empty($post['casino_name2'])) {
                $this->error('Top2赌场名称不能为空');
            }

            if (empty($post['price2'])) {
                $this->error('Top1赌资金额不能为空');
            }
            if (!is_exchange($post['price2'])&&!empty($post['price2'])) {
                $this->error('Top2请输入正确赌资金额');

            }
            if (empty($post['number2'])) {
                $this->error('Top2玩家人数不能为空');
            }
            if (empty($post['advertising_Picture3'])) {
                $this->error('Top3图片上传不能为空');
            }
            if (empty($post['flag_Picture3'])) {
                $this->error('Top3国旗上传不能为空');
            }
            if (empty($post['casino_name3'])) {
                $this->error('Top3赌场名称不能为空');
            }
            if (empty($post['price3'])) {
                $this->error('Top3赌资金额不能为空');
            }
            if (!is_exchange($post['price3'])&&!empty($post['price3'])) {
                $this->error('Top3请输入正确赌资金额');

            }
            if (empty($post['number3'])) {
                $this->error('Top3玩家人数不能为空');
            }
            if (empty($post['advertising_Picture4'])) {
                $this->error('Top4图片上传不能为空');
            }
            if (empty($post['flag_Picture4'])) {
                $this->error('Top4国旗上传不能为空');
            }
            if (empty($post['casino_name4'])) {
                $this->error('Top4赌场名称不能为空');
            }
            if (empty($post['price4'])) {
                $this->error('Top4赌资金额不能为空');
            }
            if (!is_exchange($post['price4'])&&!empty($post['price4'])) {
                $this->error('Top4请输入正确赌资金额');

            }
            if (empty($post['number4'])) {
                $this->error('Top4玩家人数不能为空');
            }
            $model = new \admin\models\AdvertisingC();
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
                $this->error('Top1图片上传不能为空');
            }
            if (empty($post['flag_Picture1'])) {
                $this->error('Top1国旗上传不能为空');
            }
            if (empty($post['casino_name1'])) {
                $this->error('Top1赌场名称不能为空');
            }
            if (empty($post['price1'])) {
                $this->error('Top1赌资金额不能为空');
            }
            if (!is_exchange($post['price1'])&&!empty($post['price1'])) {
                $this->error('Top1请输入正确广告费');

            }
            if (empty($post['number1'])) {
                $this->error('Top1玩家人数不能为空');
            }
            if (empty($post['advertising_Picture2'])) {
                $this->error('Top2图片上传不能为空');
            }
            if (empty($post['flag_Picture2'])) {
                $this->error('Top2国旗上传不能为空');
            }
            if (empty($post['casino_name2'])) {
                $this->error('Top2赌场名称不能为空');
            }

            if (empty($post['price2'])) {
                $this->error('Top1赌资金额不能为空');
            }
            if (!is_exchange($post['price2'])&&!empty($post['price2'])) {
                $this->error('Top2请输入正确赌资金额');

            }
            if (empty($post['number2'])) {
                $this->error('Top2玩家人数不能为空');
            }
            if (empty($post['advertising_Picture3'])) {
                $this->error('Top3图片上传不能为空');
            }
            if (empty($post['flag_Picture3'])) {
                $this->error('Top3国旗上传不能为空');
            }
            if (empty($post['casino_name3'])) {
                $this->error('Top3赌场名称不能为空');
            }
            if (empty($post['price3'])) {
                $this->error('Top3赌资金额不能为空');
            }
            if (!is_exchange($post['price3'])&&!empty($post['price3'])) {
                $this->error('Top3请输入正确赌资金额');

            }
            if (empty($post['number3'])) {
                $this->error('Top3玩家人数不能为空');
            }
            if (empty($post['advertising_Picture4'])) {
                $this->error('Top4图片上传不能为空');
            }
            if (empty($post['flag_Picture4'])) {
                $this->error('Top4国旗上传不能为空');
            }
            if (empty($post['casino_name4'])) {
                $this->error('Top4赌场名称不能为空');
            }
            if (empty($post['price4'])) {
                $this->error('Top4赌资金额不能为空');
            }
            if (!is_exchange($post['price4'])&&!empty($post['price4'])) {
                $this->error('Top4请输入正确赌资金额');

            }
            if (empty($post['number4'])) {
                $this->error('Top4玩家人数不能为空');
            }
            $userService = new AdvertisingCService();
            $u['id']=$userService->getIdC();
            if (!empty($u['id'])){
                $u['open']=0;
                $userService->UpC($u);
            }
            if ($userService->addAdvertisingC($post) === true) {
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
        $service = new AdvertisingCService();
        $result = $service->delAdvertisingc($id);
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
                $userService = new AdvertisingCService();
                $u['id']=$userService->getIdC();
                if (!empty($u['id'])){
                    $u['open']=0;
                    $userService->UpC($u);
                }
                $result = AdvertisingCService::ReleaseC($id);
                $text = '发布';
            } else {
                $userService = new AdvertisingCService();
                $u['id']=$userService->getIdC();
                if (!empty($u['id'])){
                    $u['open']=0;
                    $userService->UpC($u);
                }
                $result = AdvertisingCService::ReleaseC($id);
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
