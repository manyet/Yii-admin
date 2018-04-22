<?php

namespace admin\controllers;

use admin\services\MemberService;
use admin\services\WithdrawalService;
use common\controllers\AdminController;
use common\models\User;
use common\services\CompanyDividend;
use common\services\ElectronService;
use common\services\LanguageService;
use common\services\PlatformService;
use common\services\UserWalletService;

class MemberController extends AdminController
{

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '用户管理';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '查看列表',
		'detail' => '查看详情'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '查看列表'
	];

    public $_table = 'user';

    public function beforeList(&$query)
    {
        $query->select('id,uname,realname,card_number,identity,status,create_time');
        if (($key = \Yii::$app->request->get('key', '')) != '') {
            $query->andFilterWhere(['or',
				['like', 'uname', $key],
				['like', 'realname', $key],
				['like', 'card_number', $key]
			]);
        }
        if (($identity = \Yii::$app->request->get('identity', '')) != '') {
            $query->andWhere('identity = :identity', ['identity' => $identity]);
        }
        //时间搜索条件拼装
        $start_date = \Yii::$app->request->get('start_date', '');
        $end_date = \Yii::$app->request->get('end_date', '');
        if ($start_date !== '') {
            $query->andWhere(['>=', 'create_time', strtotime($start_date)]);
        }
		if ( $end_date !== '') {
            $query->andWhere(['<=', 'create_time', strtotime($end_date)]);
        }
        $query->orderBy('id DESC');
    }

    public function actionDetail(){
        $id = \Yii::$app->request->get('id', '');
        if (empty($id)) {
			$this->error('参数传入错误');
        }
		$result = User::find()->where('id = :id', ['id' => $id])->alias('u')->select(['*','IF(rank = 0, \'未购买\', (SELECT level_name FROM ' . \admin\models\MossPackage::tableName() . ' WHERE id = u.rank)) AS rank_name'])->asArray()->one();
        if (empty($result)) {
			$this->error('用户不存在');
        }
		$this->layout = 'index';
		return $this->render('detail', $result);
    }

    public function actionBindCard(){
        $id = \Yii::$app->request->get('id', '');
        if (empty($id) || intval(User::find()->where('id = :id', ['id' => $id])->count()) <= 0) {
			$this->error('用户不存在');
        }
        $value = \Yii::$app->request->post('value', '');
		if (empty($value)) {
			$this->error('请输入会员卡号');
		}
        if (intval(User::find()->where('card_number = :card_number', ['card_number' => $value])->count()) > 0) {
			$this->error('该会员卡已绑定其他用户');
        }
		$model = User::findOne($id);
        if (!empty($model->card_number)) {
			$this->error('该会员已绑定会员卡');
        }
		$model->setAttribute('card_number', $value);
		$result = $model->update() !== false;
        if ($result) {
			$this->success('会员卡绑定成功');
        } else {
			$this->error('会员卡绑定失败');
		}
    }
    public function actionIdentity(){
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model = User::findOne($post['id']);
            $model->setAttribute('identity', $post['identity']);
            $result = $model->update() !== false;
            if ($result){
                $this->success('调整身份成功');
            }else{
                $this->error('调整身份失败');

            }
        } else {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->alias('u')->select(['*','IF(rank = 0, \'未购买\', (SELECT level_name FROM ' . \admin\models\MossPackage::tableName() . ' WHERE id = u.rank)) AS rank_name'])->asArray()->one();
            if (empty($result)) {
                $this->error('用户不存在');
            }
            $this->layout = 'modal';
            return $this->render('identity', $result);
        }

    }
    public function actionCompany(){
        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->asArray()->one();
            if (empty($result)) {
                $this->error('用户不存在');
            }
            $remark=\Yii::t('app', 'background_adjustment', [], LanguageService::getUserLanguage($result['language']));
            $post = \Yii::$app->request->post();
            if (empty($post['type'])) {
                $this->error('请选择调整形式');
            }
            if (!is_numeric($post['value'])) {
                $this->error('请输入正确调整数值');
            }
            if ($post['value']<0) {
                $this->error('请输入正确调整数值');
            }
            if ($post['type']==2) {
                if ($post['value']>$post['company_integral']) {
                    $this->error('积分不足');
                }
            }
            if($post['identity']==1){
                $server=new PlatformService();
                if ($post['type']==1){
                    $server->increaseAchievement($post['value']);
                } else if ($post['type']==2){
                    $server->increaseAchievement(-$post['value']);
                }
            }
            if ($post['type']==1){
                $company_integral=$post['company_integral']*1+$post['value']*1;
            }
            if ($post['type']==2){
                $company_integral=$post['company_integral']*1-$post['value']*1;
            }
            $userService = new UserWalletService();

            $result=$userService->change($post['id'], $post['value'],$post['type'],1,1,$remark);
            $userService->addModify($post['id'], $post['value'],$post['type'],$post['identity'],$post['company_integral'],$company_integral);
            if ($result !== false) {
                $this->success('调整成功');
            } else {
                $this->error('调整失败');
            }
        } else {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->asArray()->one();
			if (empty($result)) {
                $this->error('用户不存在');
            }
            $this->layout = 'modal';
            return $this->render('company', $result);
        }

    }
    public function actionTrim(){
        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->asArray()->one();
            if (empty($result)) {
                $this->error('用户不存在');
            }
            $remark=\Yii::t('app', 'background_adjustment', [], LanguageService::getUserLanguage($result['language']));
            $post = \Yii::$app->request->post();
            $type = \Yii::$app->request->get('type');
            if (empty($post['type'])) {
                $this->error('请选择调整形式');
            }
            if (!is_numeric($post['value'])) {
                $this->error('请输入正确调整数值');
            }
            if ($post['value']<0) {
                $this->error('请输入正确调整数值');
            }
            if ($post['type']==2&&$type!=7) {
                if ($post['value']>$post['company_integral']) {
                    $this->error('积分不足');
                }
            }
            if ($type<5){
                $userService = new UserWalletService();
                $result=$userService->change($post['id'], $post['value'],$post['type'],1,$type,$remark);
                if ($result !== false) {
                    $this->success('调整成功');
                } else {
                    $this->error('调整失败');
                }
            }
            if ($type==5){
                $userService = new CompanyDividend();
                if ($post['type']==1){
                    $result=$userService->increase($post['id'], $post['value'],6,$remark);
                }else{
                    $result=$userService->decrease($post['id'], $post['value'],6,$remark);
                }
                if ($result !== false) {
                    $this->success('调整成功');
                } else {
                    $this->error('调整失败');
                }
            }
            if ($type==6){
                $userService = new ElectronService();
                if ($post['type']==1){
                    $result=$userService->increaseBonus($post['id'], $post['value'],1,$remark);
                }else{
                    $result=$userService->decreaseBonus($post['id'], $post['value'],1,$remark);
                }
                if ($result !== false) {
                    $this->success('调整成功');
                } else {
                    $this->error('调整失败');
                }
            }
            if ($type==7){
                $userService = new ElectronService();
                if ($post['type']==1){
                    $result=$userService->increaseFroze($post['id'], $post['value'],1,$remark);
                }else{
                    $result=$userService->decreaseFroze($post['id'], $post['value'],1,$remark);
                }
                if ($result !== false) {
                    $this->success('调整成功');
                } else {
                    $this->error('调整失败');
                }
            }

        } else {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->asArray()->one();
			if (empty($result)) {
                $this->error('用户不存在');
            }
            if (\Yii::$app->request->get('type')==2){
                $result['title']='现金分';
                $result['integral']=$result['cash_integral'];
            }if (\Yii::$app->request->get('type')==3){
                $result['title']='娱乐分';
                $result['integral']=$result['entertainment_integral'];
            }if (\Yii::$app->request->get('type')==5){
                $result['title']='公司分红';
                $result['integral']=$result['stay_dividend_reward'];
            }if (\Yii::$app->request->get('type')==6){
                $result['title']='分红电子分';
                $result['integral']=$result['electronic_number'];
            }if (\Yii::$app->request->get('type')==7){
                $result['title']='电子分余额';
                $result['integral']=$result['froze_electronic_number'];
            }
            $this->layout = 'modal';
            return $this->render('trim', $result);
        }

    }
    public function actionAssort(){
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if($post['ratio']<0){
                $this->error('请输入正确的调整比例');
            }if($post['ratio']>100){
                $this->error('请输入正确的调整比例');
            }
            $model = User::findOne($post['id']);
            $server=new MemberService();
            if (\Yii::$app->request->get('type')==1){
                $model->setAttribute('daily_dividend_ratio', empty($post['ratio'])?'0.00':$post['ratio']);
                $result = $model->update() !== false;
                $post['type']=\Yii::$app->request->get('type');
                $server->addProportionRecord($post);
            }if (\Yii::$app->request->get('type')==2){
                $model->setAttribute('task_benefit_ratio', empty($post['ratio'])?'0.00':$post['ratio']);
                $result = $model->update() !== false;
                $post['type']=\Yii::$app->request->get('type');
                $server->addProportionRecord($post);
            }if (\Yii::$app->request->get('type')==3){
                $model->setAttribute('direct_reward_ratio', empty($post['ratio'])?'0.00':$post['ratio']);
                $result = $model->update() !== false;
                $post['type']=\Yii::$app->request->get('type');
                $server->addProportionRecord($post);
            }if (\Yii::$app->request->get('type')==4){
                $model->setAttribute('development_reward_ratio', empty($post['ratio'])?'0.00':$post['ratio']);
                $result = $model->update() !== false;
                $post['type']=\Yii::$app->request->get('type');
                $server->addProportionRecord($post);
            }if (\Yii::$app->request->get('type')==5){
                $model->setAttribute('point_award_ratio', empty($post['ratio'])?'0.00':$post['ratio']);
                $result = $model->update() !== false;
                $post['type']=\Yii::$app->request->get('type');
                $server->addProportionRecord($post);
            }

            if ($result){
                $this->success('调整比例成功');
            }else{
                $this->error('调整比例失败');

            }
        } else {
            $id = \Yii::$app->request->get('id', '');
            if (empty($id)) {
                $this->error('参数传入错误');
            }
			$result = User::find()->where('id = :id', ['id' => $id])->alias('u')->select(['*','IF(rank = 0, \'未购买\', (SELECT level_name FROM ' . \admin\models\MossPackage::tableName() . ' WHERE id = u.rank)) AS rank_name'])->asArray()->one();
			if (empty($result)) {
                $this->error('用户不存在');
            }
            $this->layout = 'modal';
            if (\Yii::$app->request->get('type')==1){
                $result['title']='每日分红';
                $result['ratio']= $result['daily_dividend_ratio'];
            }if (\Yii::$app->request->get('type')==2){
                $result['title']='任务收益';
                $result['ratio']=$result['task_benefit_ratio'];
            }if (\Yii::$app->request->get('type')==3){
                $result['title']='直推奖励';
                $result['ratio']=$result['direct_reward_ratio'];
            }if (\Yii::$app->request->get('type')==4){
                $result['title']='发展奖励';
                $result['ratio']=$result['development_reward_ratio'];
            }if (\Yii::$app->request->get('type')==5){
                $result['title']='见点奖';
                $result['ratio']=$result['point_award_ratio'];
            }
            return $this->render('assort', $result);
        }

    }

}
