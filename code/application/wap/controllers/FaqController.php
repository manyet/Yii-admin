<?php
namespace wap\controllers;
use wap\services\FaqService;
use common\controllers\WapController;

/**
 * 首页控制器
 */
class FaqController extends WapController {
    /**
     * 关于我们
     */
    public  function actionAbout(){
        return $this->render('about');
    }
    /**
     * 常见问题
     */
    public  function actionIndex(){
        $server=new FaqService();
        $result=$server->FindFaqType();
        return $this->render('index',['result' => $result,]);
    }
    /**
     * 常见问题列表详情
     */
    public  function actionFaqlist(){
        $get = \Yii::$app->request->get();
        $server=new FaqService();
        $result['faq_type']=$server->getFaqType($get['id']);
        /* 字段处理 */
        if (useCommonLanguage()) {
            $type = $result['faq_type']['type_ename'];
        } else {
            $type = $result['faq_type']['type_name'];
        }
        $result=$server->getFaqListByKeyword($get['id']);

        return $this->render('faqlist',['result' => $result,'type'=>$type]);
    }


}
