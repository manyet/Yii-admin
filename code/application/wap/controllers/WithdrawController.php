<?php

namespace wap\controllers;
use common\controllers\WapController;
use common\services\LanguageService;
use common\services\UserService;
use common\services\UserWalletService;
use pc\models\ExchangeRate;
use pc\services\BankCardService;
use yii\helpers\Url;

/**
 * 提现控制器
 */
class WithdrawController extends WapController {
    /**
     * 首页
     */
    public function actionIndex() {
        $user_id = $this->checkLogin();
        $bank = BankCardService::getInfo($user_id, '*');
        $Service= new UserService();
        $exchange= $Service->FindExchange();
        return $this->render('index',['bank'=>$bank,'exchange'=>$exchange]);
    }
    public function actionSure() {
        $user_id = $this->checkLogin();
        $post = \Yii::$app->request->post();
        $user_info = UserService::getUserInfo($user_id, '*');
        if(!is_numeric(str_replace(' ', '', $post['bank_no']))){
            $this->error(\Yii::t('app', 'bank_no'));
        }
        if($post['id']==1&&$post['money']>$user_info['cash_integral']){
            $this->error(\Yii::t('app', 'Lack_of_cash'));
        }
        if($post['id']==2&&$post['money']>$user_info['company_dividend']){
            $this->error(\Yii::t('app', 'withdraw_of_dividend'));
        }
        $this->success('', Url::toRoute(['check']).'?id='.$post['id'].'&bank='.$post['bank'].'&branch='.$post['branch'].
            '&holder='.$post['holder'].'&bank_no='.$post['bank_no'].'&money='.$post['money'].'&rate='.$post['rate']);
    }
    public function actionCheck(){
        $user_id = $this->checkLogin();
        $get = \Yii::$app->request->get();
        $user_info = UserService::getUserInfo($user_id, '*');
        if ($get['id']==1){
            $money=$user_info['cash_integral']-$get['money'];
        }if ($get['id']==2){
            $money=$user_info['company_dividend']-$get['money'];
        }
        $model = ExchangeRate::find()->where('id = ' . $get['rate']);
        $Rate = $model->asArray()->one();
        return $this->render('check',['money'=>$money,'rate'=>$Rate]);
    }
    public function actionExtract(){
        $post = \Yii::$app->request->post();
        $post['user_id'] = $this->checkLogin();
        $user_info = UserService::getUserInfo($post['user_id'], '*');

        if (empty($post['pass'])){
            $this->error(\Yii::t('app','transfer_payment'));
        }
        // 支付密码
        if (empty($user_info['pay_pwd'])) {
            $url = \yii\helpers\Url::toRoute('user/info');
            $this->error(\Yii::t('app', 'please_set_pay_password', ['url' => $url]));
        }
        if (!UserService::validatePayPasswordByPassword($post['pass'], $user_info['pay_pwd'])) {
            $this->error(\Yii::t('app','pay_password_error'));
        }
        $service= new UserService();
        $services= new UserWalletService();
        if ($post['withdrawal_type']==1){
            $service->upCompany($post['user_id'],$post['money'],2,7,2, \Yii::t('app', 'explain_log_score_Withdrawal', [], LanguageService::getUserLanguage($user_info['language'])));
        }if ($post['withdrawal_type']==2){
            $services->change($post['user_id'],$post['money'],2,7,5,\Yii::t('app', 'explain_log_Withdrawal', [], LanguageService::getUserLanguage($user_info['language'])));
        }
        $service->addWithdrawal($post);
        if ($post['withdrawal_type']==1){
            $Url=Url::toRoute('user/cash');
        }if ($post['withdrawal_type']==2){
            $Url=Url::toRoute('user/dividend');
        }
        $this->success(\Yii::t('app','wap_withdraw'), $Url);

    }

}