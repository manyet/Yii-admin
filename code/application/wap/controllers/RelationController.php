<?php

namespace wap\controllers;

use Yii;
use common\models\User;
use common\services\LanguageService;
use common\services\UserService;
use common\services\UserWalletService;
use pc\models\WalletRule;
use common\controllers\WapController;

/**
 * 用户关系
 */
class RelationController extends WapController {

	/**
	 * 直推关系
	 */
    public function actionDirect() {
        $user_id = $this->checkLogin();
		return $this->render('direct');
    }

	/**
	 * 获取下级
	 */
    public function actionGetData() {
        $user_id = $this->checkLogin();
        $page = \yii::$app->request->get('page', 1);
        $rows = \yii::$app->request->get('rows', 10);
        $kw = \yii::$app->request->get('kw', '');
		$fields = [
			'u.id',
			'uname',
			'nickname',
			'bind_time',
			'promoter_benifit',
			'IF(rank = 0, \'' . \Yii::t('app', 'no_package')
			. '\', (SELECT level_name FROM ' . \admin\models\MossPackage::tableName()
			. ' WHERE id = u.rank)) AS rank_name'
		];
        $this->ajaxReturn(UserService::getPromoteList($user_id, $fields, "uname LIKE '%$kw%' OR nickname LIKE '%$kw%'", $page, $rows));
    }

	/**
	 * 转分
	 */
	public function actionTransfer(){
        $post = \Yii::$app->request->post();
        $model= new WalletRule();
        $Rule=$model->find()->select('*')->where('id ='.$post['type'])->asArray()->one();
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, '*');
        if (empty($post['password'])){
            $this->error(\Yii::t('app','transfer_payment'));
        }
        // 支付密码
        if (empty($user_info['pay_pwd'])) {
            $url = \yii\helpers\Url::toRoute('user/info');
            $this->error(\Yii::t('app', 'please_set_pay_password', ['url' => $url]));
        }
        if (!UserService::validatePayPasswordByPassword($post['password'], $user_info['pay_pwd'])) {
            $this->error(\Yii::t('app','pay_password_error'));
        }
        $userModel= new User();
        $Sure=$userModel->find()->select('*')->where('id = :id', ['id' =>$post['user_id']])->asArray()->one();
        $service=new UserWalletService();
        if ($post['type']==1){
            $text='公司分 ';
        }if ($post['type']==2){
            $text='现金分 ';
        }if ($post['type']==3){
            $text='娱乐分 ';
        }
        $service->change($user_id,$post['value'],2,6,$post['type'],\Yii::t('app', 'explain_log_score_to',[], LanguageService::getUserLanguage($Sure['language'])).$Sure['uname']);
        $Companyamount=$post['value']*$Rule['company_score_ratio']/100;
        $Cashamount=$post['value']*$Rule['cash_score_ratio']/100;
        $entertainmentamount=$post['value']*$Rule['entertainment_score_ratio']/100;
        $User_service= new UserService();
        if ($Companyamount>0){
        $User_service->addCompany($Sure['id'],$Companyamount,1,6,1,$user_info['uname'].\Yii::t('app', 'explain_log_score',[], LanguageService::getUserLanguage($Sure['language'])));
        }if ($Cashamount>0){
        $User_service->addCash($Sure['id'],$Cashamount,1,6,2,$user_info['uname'].\Yii::t('app', 'explain_log_score',[], LanguageService::getUserLanguage($Sure['language'])));
        }if ($entertainmentamount>0){
        $User_service->addEntertainment($Sure['id'],$entertainmentamount,1,6,3,$user_info['uname'].\Yii::t('app', 'explain_log_score',[], LanguageService::getUserLanguage($Sure['language'])));
        }
        $into_wallet='公司分 '.number_format($Companyamount,2).',现金分 '.number_format($Cashamount,2).',娱乐分 '.number_format($entertainmentamount,2);
        $User_service->addOrder($user_id,$text.number_format($post['value'],2),$Sure['uname'],$into_wallet);
         $this->success(\Yii::t('app', 'Transfer_success'));
    }

}
