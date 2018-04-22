<?php

namespace wap\controllers;

use common\models\User;
use common\services\LanguageService;
use common\services\UserWalletService;
use pc\models\WalletRule;
use pc\services\DailyCommissionService;
use pc\services\DevelopCommissionService;
use pc\services\PointCommissionService;
use pc\services\PromoteCommissionService;
use pc\services\TaskCommissionService;
use wap\services\FaqService;
use Yii;
use yii\helpers\Url;
use common\services\UserService;
use common\controllers\WapController;

/**
 * 首页控制器
 */
class UserController extends WapController {

	/**
	 * 首页
	 */
	public function actionIndex() {
		$user_id = $this->checkLogin(Url::toRoute('index'));
		$user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,(SELECT level_name FROM ' . \pc\models\Package::tableName() . ' WHERE id = rank) AS level_name');
		return $this->render('index', $user_info);
	}

	/**
	 * 登录页
	 */
	public function actionLogin() {
		if (isLogin()) {
			$getUrl = \Yii::$app->request->get('returnUrl');
			$this->redirect(empty($getUrl) ? (empty(Yii::$app->request->referrer) ?  Yii::$app->homeUrl : Yii::$app->request->referrer) : urldecode($getUrl));
		} else {
			return $this->render('login');
		}
	}

	/**
	 * 提交登录
	 */
	public function actionSubmitLogin() {
		if (\Yii::$app->request->isPost) {
			$vcode = trim(Yii::$app->request->post('vcode', ''));
			if ($vcode === '') {
				$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'vcode'));
			}
			$model = new \pc\models\Login();
			$model->setAttributes(['verifyCode' => $vcode]);
			if (!$model->validate()) {
				$this->error(Yii::t('app', 'vcode_error'));
			}
			$uname = trim(\Yii::$app->request->post('username', ''));
			if ($uname === '') {
				$this->error(Yii::t('app', 'please_enter') . Yii::t('app', 'username'));
			}
			$pwd = trim(\Yii::$app->request->post('password', ''));
			if ($pwd === '') {
				$this->error(Yii::t('app', 'please_enter') . Yii::t('app', 'password'));
			}
			$result = UserService::login($uname, $pwd);
			if ($result !== false) {
				setUserInfo($result, Yii::$app->request->post('keep'));
				setcookie('fun', $uname, 0, '/');
				if (!empty($result['language'])) { // 设置语言
					\common\services\LanguageService::setLanguage($result['language'], false);
				}
				$this->success(Yii::t('app', 'login_success'));
			} else {
				$this->error(UserService::$errMsg);
			}
		}
	}

	/**
	 * 注册页
	 */
	public function actionRegister() {
		return $this->render('register');
	}

	/**
	 * 用户协议
	 */
	public function actionAgreement() {
		return $this->render('agreement');
	}

	/**
	 * 登出系统
	 */
	public function actionLogout() {
		logout();
		$this->redirect(Url::toRoute(['login', 'returnUrl' => Yii::$app->request->getReferrer()]));
	}

	public function actions()
	{
		return  [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => null,
				'backColor' => 0xffffff,//背景颜色
				'maxLength' => 6, //最大显示个数
				'minLength' => 6,//最少显示个数
				'padding' => 5,//间距
				'height' => 38,//高度
				'width' => 130,  //宽度
				'foreColor' => 0x3c8dbc,     //字体颜色
				'offset' => 4,        //设置字符偏移量 有效果
			],
		];
	}
    /**
     * 关于我们
     */
	public  function actionAbout(){
        return $this->render('about');
    }
    /**
     * 常见问题
     */
    public  function actionFaq(){
        $server=new FaqService();
        $result=$server->FindFaqType();
        return $this->render('faq',['result' => $result,]);
    }
    /**
     * 常见问题列表详情
     */
    public  function actionFaqlist(){
        $get = \Yii::$app->request->get();
        $server=new FaqService();
        $result=$server->getFaqListByKeyword($get['id']);
        return $this->render('faqlist',['result' => $result,]);
    }
    /**
     * 公司分流水页面
     */
    public  function actionCompany(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,package_value,electron_multiple,electronic_number,froze_electronic_number,company_integral,entertainment_integral,cash_integral,company_dividend,total_daily_dividend,total_point_reward,total_task_income,total_direct_reward,total_indirect_reward');
        return $this->render('company',['user_info' => $user_info,]);
    }
    /**
     * 获取公司分流水数据
     */
    public function actionGetCompanyList() {
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $data = UserWalletService::getCompanyRecord($user_id, '*',$where = NULL, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
    * 现金分流水页面
    */
    public  function actionCash(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,package_value,electron_multiple,electronic_number,froze_electronic_number,company_integral,entertainment_integral,cash_integral,company_dividend,total_daily_dividend,total_point_reward,total_task_income,total_direct_reward,total_indirect_reward');
        return $this->render('cash',['user_info' => $user_info,]);
    }
    /**
     * 获取公司分流水数据
     */
    public function actionGetCashList() {
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $data = UserWalletService::getCashRecord($user_id, '*',$where = NULL, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
    * 娱乐分流水页面
    */
    public  function actionEntertainment(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,package_value,electron_multiple,electronic_number,froze_electronic_number,company_integral,entertainment_integral,cash_integral,company_dividend,total_daily_dividend,total_point_reward,total_task_income,total_direct_reward,total_indirect_reward');
        return $this->render('entertainment',['user_info' => $user_info,]);
    }
    /**
     * 获取娱乐分流水数据
     */
    public function actionGetEntertainmentList() {
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $data = UserWalletService::getEntertainmentRecord($user_id, '*',$where = NULL, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 公司分红流水页面
     */
    public  function actionDividend(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'uname,rank,identity,package_value,electron_multiple,electronic_number,froze_electronic_number,company_integral,entertainment_integral,cash_integral,company_dividend,total_daily_dividend,total_point_reward,total_task_income,total_direct_reward,total_indirect_reward');
        return $this->render('dividend',['user_info' => $user_info,]);
    }
    /**
     * 获取公司分红流水数据
     */
    public function actionGetDividendList() {
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $data = UserWalletService::getDividendRecord($user_id, '*',$where = NULL, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 提现页面
     */
    public  function actionRecord(){
        $this->checkLogin();
        return $this->render('record');
    }
    /**
     * 提现流水
     */
    public  function actionRecordList(){
        $user_id = $this->checkLogin();
        $get = \Yii::$app->request->get();
        $pageParams['page']=!empty($get['page'])?$get['page']:'';
        $pageParams['rows']=!empty($get['rows'])?$get['rows']:'';
        $pageParams['type']=!empty($get['type'])?$get['type']:'';
        /* 字段处理 */
        if (useCommonLanguage()) {
            $currency = 'e_currency AS currency';
        } else {
            $currency = 'currency';
        }
        $data = UserWalletService::getWithdraw($user_id,$pageParams['type'],$sta=NUll,'a.*,'.$currency,$where = NULL, $pageParams['page'], $pageParams['rows']);
        $this->ajaxReturn($data);
    }
    /**
     * 转分申请
     */
    public  function actionTransfer(){
        $this->checkLogin();
        $get = \Yii::$app->request->get();
        if ($get['id']==1){
            $Url='company';
        }if ($get['id']==2){
            $Url='cash';
        }if ($get['id']==3){
            $Url='entertainment';
        }
        $model= new WalletRule();
        $Rule=$model->find()->select('*')->where('id ='.$get['id'])->asArray()->one();
        return $this->render('transfer',['rule' => $Rule,'Url' => $Url]);
    }
    /**
     * 验证
     */
    public  function actionSure(){
        $user_id = $this->checkLogin();
        $post = \Yii::$app->request->post();
        $model= new WalletRule();
        $Rule=$model->find()->select('*')->where('id ='.$post['id'])->asArray()->one();
        if ($Rule['transfer_score_open']!=1){
            $this->error(Yii::t('app', 'transfer_pack'));
        }
        $model= new User();
        $user=$model->find()->select('*')->where('uname = :id', ['id' =>$post['uname']])->asArray()->one();
        $user_info = UserService::getUserInfo($user_id, 'uname,company_integral,cash_integral,entertainment_integral');
        if (empty($user)){
            $this->error(Yii::t('app', 'transfer_user'));
        }if (empty($user['realname'])){
            $this->error(Yii::t('app', 'transfer_ename'));
        }if ($user['realname']!=$post['name']){
            $this->error(Yii::t('app', 'transfer_ername'));
        }
        if ($user['uname']==$user_info['uname']){
            $this->error(Yii::t('app', 'transfer_eror'));
        }
        if ($post['id']==1&&!empty($post['value'])&&$post['value']>$user_info['company_integral']){
            $this->error(Yii::t('app', 'balance_not_enough', ['score' => Yii::t('app', 'wallet_company_score')]));
        }if ($post['id']==2&&!empty($post['value'])&&$post['value']>$user_info['cash_integral']){
            $this->error(Yii::t('app', 'balance_not_enough', ['score' => Yii::t('app', 'wallet_cash_score')]));
        }if ($post['id']==3&&!empty($post['value'])&&$post['value']>$user_info['entertainment_integral']) {
            $this->error(Yii::t('app', 'balance_not_enough', ['score' => Yii::t('app', 'wallet_entertainment_score')]));
        }
        $this->success('', Url::toRoute(['check']).'?id='.$post['id'].'&uid='.$user['id'].'&value='.$post['value']);
    }
    /**
     * 验证
     */
    public  function actionCheck(){
        $user_id=$this->checkLogin();
        $get = \Yii::$app->request->get();
        $model= new User();
        $user=$model->find()->select('id,uname,realname,company_integral,cash_integral,entertainment_integral')->where('id = :id', ['id' =>$get['uid']])->asArray()->one();
        $user_info = UserService::getUserInfo($user_id, 'uname,company_integral,cash_integral,entertainment_integral');
        if ($get['id']==1){
            $title=Yii::t('app', 'wallet_company_score');
            $integral=$user_info['company_integral']-$get['value'];
        }if ($get['id']==2){
            $title=Yii::t('app', 'wallet_cash_score');
            $integral=$user_info['cash_integral']-$get['value'];
        }if ($get['id']==3){
            $title=Yii::t('app', 'wallet_entertainment_score');
            $integral=$user_info['entertainment_integral']-$get['value'];
        }
        return $this->render('check',['user' => $user,'title'=>$title,'integral'=>$integral,
            'user_info'=>$user_info,'id'=>$get['id']]);
    }
    /**
     * 确认转让
     */
    public  function actionSureSubmit(){
        $user_id=$this->checkLogin();
        $post = \Yii::$app->request->post();
        $userModel= new User();
        $user_info = UserService::getUserInfo($user_id, '*');
        if (empty($post['password'])){
            $this->error(Yii::t('app','transfer_payment'));
        }
        // 支付密码
        if (empty($user_info['pay_pwd'])) {
            $url = \yii\helpers\Url::toRoute('user/info');
            $this->error(Yii::t('app', 'please_set_pay_password', ['url' => $url]));
        }
        if (!UserService::validatePayPasswordByPassword($post['password'], $user_info['pay_pwd'])) {
            $this->error(Yii::t('app','pay_password_error'));
        }
        $Sure=$userModel->find()->select('*')->where('id = :id', ['id' =>$post['uid']])->asArray()->one();
        $model= new WalletRule();
        $Rule=$model->find()->select('*')->where('id ='.$post['id'])->asArray()->one();
        if($Rule['transfer_score_open']==0){
            $this->error(Yii::t('app', 'transfer_pack'));
        }
        $service= new UserService();
        if ($post['id']==1){
            $service->upCompany($user_id,$post['integral'],2,6,1,\Yii::t('app', 'explain_log_score_to',[], LanguageService::getUserLanguage($user_info['language'])).$Sure['uname']);
        }if ($post['id']==2){
            $service->upCompany($user_id,$post['integral'],2,6,2,\Yii::t('app', 'explain_log_score_to',[], LanguageService::getUserLanguage($user_info['language'])).$Sure['uname']);
        }if ($post['id']==3){
            $service->upCompany($user_id,$post['integral'],2,6,3,\Yii::t('app', 'explain_log_score_to',[], LanguageService::getUserLanguage($user_info['language'])).$Sure['uname']);
        }
        $Companyamount=$post['integral']*$Rule['company_score_ratio']/100;
        $Cashamount=$post['integral']*$Rule['cash_score_ratio']/100;
        $entertainmentamount=$post['integral']*$Rule['entertainment_score_ratio']/100;
        if ($Companyamount>0) {
            $service->addCompany($Sure['id'], $Companyamount, 1, 6, 1, $user_info['uname'] . \Yii::t('app', 'explain_log_score', [],
                    LanguageService::getUserLanguage($Sure['language'])));
        }
        if ($Cashamount>0) {
            $service->addCash($Sure['id'], $Cashamount, 1, 6, 2, $user_info['uname'] . \Yii::t('app', 'explain_log_score', [],
                    LanguageService::getUserLanguage($Sure['language'])));
        }
        if ($entertainmentamount>0){
            $service->addEntertainment($Sure['id'],$entertainmentamount,1,6,3,$user_info['uname'].\Yii::t('app', 'explain_log_score',[], LanguageService::getUserLanguage($Sure['language'])));
        }
        $into_wallet='公司分 '.number_format($Companyamount,2).',现金分 '.number_format($Cashamount,2).',娱乐分 '.number_format($entertainmentamount,2);
        $service->addOrder($user_id,'公司分 '.$post['integral'],$Sure['uname'],$into_wallet);
        if ($post['id']==1){
            $Url=Url::toRoute('company');
        }if ($post['id']==2){
            $Url=Url::toRoute('cash');
        }if ($post['id']==3){
            $Url=Url::toRoute('entertainment');
        }
        $this->success(Yii::t('app','Transfer_success'), $Url);

    }

    /**
     * 每日分红
     */
    public  function actionDailyCommission(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'total_daily_dividend');
        return $this->render('daily-commission',['user_info' => $user_info,]);
    }
    /**
     * 每日分红流水
     */
    public  function actionDailyCommissionList(){
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $Service=new DailyCommissionService();
        $data = $Service->getList($user_id, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 任务收益
     */
    public  function actionTaskCommission(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'total_task_income');
        return $this->render('task-commission',['user_info' => $user_info,]);
    }
    /**
     * 任务收益流水
     */
    public  function actionTaskCommissionList(){
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $Service=new TaskCommissionService();
        $data = $Service->getList($user_id, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 直推奖励
     */
    public  function actionPromoteCommission(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'total_direct_reward');
        return $this->render('promote-commission',['user_info' => $user_info,]);
    }
    /**
     * 直推奖励流水
     */
    public  function actionPromoteCommissionList(){
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $Service=new PromoteCommissionService();
        $data = $Service->getList($user_id, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 发展奖励
     */
    public  function actionDevelopCommission(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'total_indirect_reward');
        return $this->render('develop-commission',['user_info' => $user_info,]);
    }
    /**
     * 发展奖励流水
     */
    public  function actionDevelopCommissionList(){
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $Service=new DevelopCommissionService();
        $data = $Service->getList($user_id, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
    /**
     * 发展奖励
     */
    public  function actionPointCommission(){
        $user_id = $this->checkLogin();
        $user_info = UserService::getUserInfo($user_id, 'total_point_reward');
        return $this->render('point-commission',['user_info' => $user_info,]);
    }
    /**
     * 发展奖励流水
     */
    public  function actionPointCommissionList(){
        $get = \Yii::$app->request->get();
        $pageParams['page'] = $get['page'];
        $pageParams['pageSize'] =$get['rows'];
        $user_id = $this->checkLogin();
        $Service=new PointCommissionService();
        $data = $Service->getList($user_id, $pageParams['page'], $pageParams['pageSize']);
        $this->ajaxReturn($data);
    }
	
	public function actionBasicInfo() {
		$user_id = $this->checkLogin();
		$result['user_info'] = UserService::getUserInfo($user_id);
		$has_lower = \common\models\User::find()->where('parent_id = ' . $user_id)->count() > 0;
		$result['has_lower'] = $has_lower;
		return $this->render('basic-info', $result);
	}
	
	public function actionSaveInfo() {
		$user_id = $this->checkLogin();
		$post = \yii::$app->request->post();
		$post['id'] = $user_id;
		if (!empty($post['promoter_invite_code'])) {
			$user = UserService::getInfoByParams(['invite_code' => $post['promoter_invite_code']], 'id');
			if (empty($user)) {
				$this->error(Yii::t('app', 'user_invitation_code_error'));
			}
			if ($user['id'] === $user_id) {
				$this->error(Yii::t('app', 'user_bind_self_invitation_code'));
			}
		}
		$result = UserService::saveUser($post);
		$result !== false ? $this->success(Yii::t('app', 'user_save_success')) : $this->error(Yii::t('app', 'user_save_failure'));
	}
	
	public function actionSecurityInfo() {
		$user_id = $this->checkLogin();
		$result['user_info'] = UserService::getUserInfo($user_id);
		$result['user_info']['bank_card'] = \pc\services\BankCardService::getInfo($user_id, 'card_number')['card_number'];
		return $this->render('security-info', $result);
	}
	
	public function actionBindEmail() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if (filter_var($post['old_email'], FILTER_VALIDATE_EMAIL) === false || filter_var($post['new_email'], FILTER_VALIDATE_EMAIL) === false) {
				$this->error(Yii::t('app', 'email') . ' ' . Yii::t('app', 'format_error'));
			}
			if ($post['old_email'] === $post['new_email']) {
				$this->error(Yii::t('app', 'user_mailbox_binded'));
			}
			$user = UserService::getInfoByParams(['id' => $user_id, 'email' => $post['old_email']]);
			if (empty($user)) {
				$this->error(Yii::t('app', 'user_current_mailbox_error'));
			}
			$data = [];
			$data['user_id'] = $user_id;
			$data['email'] = $post['new_email'];
			$data['expiry'] = time() + 86400;
			$url = Url::toRoute(['user/update-email', 'token' => encode(json_encode($data)), 'language' => \Yii::$app->language], true);
			$mail = new \common\services\MailService();
			$template = $mail->getTemplate('bind-email', [
				'link' => $url,
				'email' => $data['email'],
				'username' => $user['uname'],
				'date' => date('Y-m-d'),
				'period' => 24
			]);
			if ($mail->send($data['email'], $template['title'], $template['content'])) {
				$this->success($data['email']);
			} else {
				$this->error(Yii::t('app', 'mail_send_fail'));
			}
		} else {
			return $this->render('bind-email');
		}
	}
	
	public function actionUpdateEmail() {
		$language = Yii::$app->request->get('language');
		\common\services\LanguageService::setLanguage($language, false);
		$token = Yii::$app->request->get('token');
		if (empty($token) || ($json = decode($token)) === false || !($data = json_decode($json, true))) {
			$this->error(Yii::t('app', 'access_deny'), Url::toRoute('user/register'));
		}
		if (time() > $data['expiry']) {
			return $this->render('email-expiry');
		}
		
		$params = ['id' => $data['user_id']];
		$columns = ['email' => $data['email']];
		$result = UserService::updateInfoByParasm($params, $columns);
		if ($result) {
			return $this->render('email-success');
		} else {
			$this->error(Yii::t('app', 'user_bind_mailbox_error'), Url::toRoute('user/info'));
		}
	}
	
	public function actionUpdatePwd() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if ($post['pwd'] !== $post['rpwd']) {
				$this->error(Yii::t('app', 'user_pwd_reset'));
			}

			$user = UserService::getUserInfo($user_id, 'id,uname,pwd,salt');
			if ($user['pwd'] !== UserService::getEncodePassword($user['uname'], $post['opwd'], $user['salt'])) {
				$this->error(Yii::t('app', 'user_pwd_error'));
			}

			$new_pwd = UserService::getEncodePassword($user['uname'], $post['pwd'], $user['salt']);
			$result = UserService::updatePwd($user['id'], $new_pwd);
			if ($result) {
				setUserInfo(NULL);
				$this->success(Yii::t('app', 'user_pwd_modify_success'), Url::toRoute(['user/login', 'returnUrl' => Url::toRoute('user/security-info')]));
			} else {
				$this->error(Yii::t('app', 'user_pwd_modify_failure'));
			}
		} else {
			return $this->render('update-pwd');
		}
	}
	
	public function actionSaveBankCard() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if ($post['card_number'] !== $post['rcard_number']) {
				$this->error(Yii::t('app', 'user_bank_card_reset'));
			}

			$post['user_id'] = $user_id;
			$servie = new \pc\services\BankCardService();
			$result = $servie->add($post);
			if ($result) {
				$this->success(Yii::t('app', 'user_save_success'));
			} else {
				$this->error(Yii::t('app', 'user_save_failure'));
			}
		} else {
			return $this->render('save-bankcard');
		}
	}
	
	public function actionBindBankCard() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if ($post['bind_card_number'] !== $post['bind_rcard_number']) {
				$this->error(Yii::t('app', 'user_bank_card_reset'));
			}

			$servie = new \pc\services\BankCardService();
			$result = $servie->update($user_id, $post);
			if ($result) {
				$this->success(Yii::t('app', 'user_bind_card_success'));
			} else {
				$this->error(Yii::t('app', 'user_bind_card_failure'));
			}
		} else {
			return $this->render('bind-bankcard');
		}
	}
	
	public function actionSavePayPwd() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if ($post['pay_pwd'] !== $post['pay_rpwd']) {
				$this->error(Yii::t('app', 'user_pwd_reset'));
			}

			$result = UserService::savePayPwd($user_id, $post['pay_pwd']);
			if ($result) {
				$this->success(Yii::t('app', 'user_ppwd_setting_success'));
			} else {
				$this->error(Yii::t('app', 'user_ppwd_setting_failure'));
			}
		} else {
			return $this->render('save-paypwd');
		}
	}
	
	public function actionUpdatePayPwd() {
		$user_id = $this->checkLogin();
		if (\yii::$app->request->isPost) {
			$post = \yii::$app->request->post();
			if ($post['pay_npwd'] !== $post['pay_rnpwd']) {
				$this->error(Yii::t('app', 'user_pwd_reset'));
			}

			$user = UserService::getUserInfo($user_id, 'id,pay_pwd');
			if ($user['pay_pwd'] !== UserService::getEncodePayPassword($post['pay_opwd'])) {
				$this->error(Yii::t('app', 'user_pwd_error'));
			}

			$result = UserService::savePayPwd($user_id, $post['pay_npwd']);
			if ($result) {
				$this->success(Yii::t('app', 'user_ppwd_modify_success'));
			} else {
				$this->error(Yii::t('app', 'user_ppwd_modify_failure'));
			}
		} else {
			return $this->render('update-paypwd');
		}
	}
	
	public function actionFindPayPwd() {
		$user_id = $this->checkLogin();
		$user = UserService::getUserInfo($user_id, 'id,email,uname');
		if (!empty($user)) {
			$code = getRandomString(8);
			$mail = new \common\services\MailService();
			$template = $mail->getTemplate('find-pay-password', [
				'username' => $user['uname'],
				'code' => $code,
				'date' => date('Y-m-d'),
			]);
			if ($mail->send($user['email'], $template['title'], $template['content'])) {
				session('wap_pay_pwd_expiry', time() + 600);
				session('wap_pay_pwd_code', $code);
				session('wap_pay_pwd_id', $user['id']);
				session('wap_pay_pwd_email', $user['email']);
				$result['email'] = getHiddenEmail($user['email']);
				return $this->render('find-paypwd', $result);
				//$this->success(getHiddenEmail($user['email']));
			} else {
				$this->error(Yii::t('app', 'mail_send_fail'));
			}
		} else {
			$this->error(Yii::t('app', 'palyer_not_exist'));
		}
	}
	
	public function actionFindPayPwdCode() {
		$user_id = session('wap_pay_pwd_id');
		$wap_pay_pwd_error_times = session('wap_pay_pwd_error_times');
		if (empty($wap_pay_pwd_error_times)) {
			$wap_pay_pwd_error_times = 0;
		}
		$expiry = session('wap_pay_pwd_expiry');
		if (Yii::$app->request->isPost) {
			if ($wap_pay_pwd_error_times >= 3 || empty($expiry) || $expiry < time()) {
				session('wap_pay_pwd_error_times', 0);
				$this->error(Yii::t('app', 'please_resend_key'), Url::toRoute('find-password'));
			}
			$key = trim(Yii::$app->request->post('pay_key', ''));
			if ($key === '') {
				$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key'));
			}
			$code = session('wap_pay_pwd_code');
			if ($code == $key) {
				session('wap_pay_pwd_error_times', 0);
				session('wap_pay_pwd_code_verified', 1);
				$this->success('');
			} else {
				session('wap_pay_pwd_error_times', ++$wap_pay_pwd_error_times);
				$this->error(Yii::t('app', 'key_error'));
			}
		} 
	}
	
	public function actionFindPayPwdReset() {
		$user_id = session('wap_pay_pwd_id');
		$is_verified = session('wap_pay_pwd_code_verified');
		if (Yii::$app->request->isPost) {
			if (!empty($user_id) && !empty($is_verified)) {
				$password = trim(Yii::$app->request->post('reset_pwd', ''));
				if ($password === '') {
					$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'password'));
				}
				$cpassword = trim(Yii::$app->request->post('reset_rpwd', ''));
				if ($cpassword === '') {
					$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'confirm_password'));
				}
				if ($password == $cpassword) {
					$model = \common\models\User::findOne($user_id);
					$pwd = UserService::getEncodePayPassword($password);
					$model->setAttribute('pay_pwd', $pwd);
					if ($model->update() !== false) {
						session('wap_pay_pwd_code', NULL);
						session('wap_pay_pwd_id', NULL);
						session('wap_pay_pwd_code_verified', NULL);
						$this->success(Yii::t('app', 'user_pay_pwd_reset_success'));
					} else {
						$this->error(Yii::t('app', 'user_pay_pwd_reset_failure'));
					}
				} else {
					$this->error(Yii::t('app', 'user_pwd_reset'));
				}
			}
		} else {
			return $this->render('reset-paypwd');
		}
	}

	public function actionFindPasswordReset() {
		$user_id = session('password_id');
		$is_verified = session('password_code_verified');
		if (Yii::$app->request->isPost) {
			if (!empty($user_id) && !empty($is_verified)) {
				$password = trim(Yii::$app->request->post('password', ''));
				if ($password === '') {
					$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'password'));
				}
				$cpassword = trim(Yii::$app->request->post('cpassword', ''));
				if ($cpassword === '') {
					$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'confirm_password'));
				}
				if ($password == $cpassword) {
					$model = User::findOne($user_id);
					$pwd = UserService::getEncodePassword($model->uname, $password, $model->salt);
					$model->setAttribute('pwd', $pwd);
					if ($model->update() !== false) {
						session('password_code', NULL);
						session('password_id', NULL);
						session('password_code_verified', NULL);
						$this->success(Yii::t('app', 'user_pwd_modify_success'), Url::toRoute(['login', 'returnUrl' => Yii::$app->homeUrl]));
					} else {
						$this->error(Yii::t('app', 'user_pwd_modify_failure'));			
					}
				} else {
					$this->error(Yii::t('app', 'user_pwd_reset'));
				}
			}
		} else {
			if (!empty($user_id) && !empty($is_verified)) {
				return $this->render('find-password-reset');
			} else {
				$this->redirect(Url::toRoute('find-password'));
			}
		}
	}

	public function actionFindPasswordCode() {
		$user_id = session('password_id');
		$password_error_times = session('password_error_times');
		if (empty($password_error_times)) {
			$password_error_times = 0;
		}
		$expiry = session('password_expiry');
		if (Yii::$app->request->isPost) {
			if ($password_error_times >= 3 || empty($expiry) || $expiry < time()) {
				session('password_error_times', 0);
				$this->error(Yii::t('app', 'please_resend_key'), Url::toRoute('find-password'));
			}
			$key = trim(Yii::$app->request->post('key', ''));
			if ($key === '') {
				$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key'));
			}
			$code = session('password_code');
			if ($code == $key) {
				session('password_error_times', 0);
				session('password_code_verified', 1);
				$this->success('', Url::toRoute('find-password-reset'));
			} else {
				session('password_error_times', ++$password_error_times);
				$this->error(Yii::t('app', 'key_error'));
			}
		} else {
			if (!empty($user_id) && $password_error_times < 3 && !empty($expiry) && $expiry > time()) {
				return $this->render('find-password-code');
			} else {
				session('password_error_times', 0);
				$this->redirect(Url::toRoute('find-password'));
			}
		}
	}

	public function actionFindPassword() {
		if (Yii::$app->request->isPost) {
			$vcode = trim(Yii::$app->request->post('vcode', ''));
			if ($vcode === '') {
				$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'vcode'));
			}
			$model = new \pc\models\Login();
			$model->setAttributes(['verifyCode' => $vcode]);
			if (!$model->validate()) {
				$this->error(Yii::t('app', 'vcode_error'));
			}
			$username = trim(Yii::$app->request->post('username'));
			if ($username === '') {
				$this->error(Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'username'));
			}
			$info = User::find()->where('uname = :uname', ['uname' => $username])->select('id,email')->asArray()->one();
			if (!empty($info)) {
				$code = getRandomString(8);
				$mail = new \common\services\MailService();
				$template = $mail->getTemplate('find-password', [
					'username' => $username,
					'code' => $code,
					'date' => date('Y-m-d'),
				]);
				if ($mail->send($info['email'], $template['title'], $template['content'])) {
					session('password_expiry', time() + 600);
					session('password_code', $code);
					session('password_id', $info['id']);
					session('password_email', $info['email']);
					$this->success('', Url::toRoute('find-password-code'));
				} else {
					$this->error(Yii::t('app', 'mail_send_fail'));
				}
			} else {
				$this->error(Yii::t('app', 'palyer_not_exist'));
			}
		} else {
			$this->view->params['returnUrl'] = Url::toRoute('index');
			return $this->render('find-password');
		}
	}

}
