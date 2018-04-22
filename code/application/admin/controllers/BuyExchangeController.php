<?php

namespace admin\controllers;
use admin\services\BuyExchange;
use admin\services\BuyExchangeService;
use admin\services\SystemLogService;
use admin\services\SystemUserService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class BuyExchangeController extends AdminController {

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '充值/购买汇率';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'add' => '添加',
        'info' => '详情',
		'edit' => '编辑',
		'del' => '删除',
	];

    /**
     * 菜单模块选择器
     * @var array
     */
    public $menu = [
        'index' => '首页'
    ];
    protected $_table = 'exchange_rate';

    protected $status = 0;

    public function beforeList(&$query)
    {
        $getParams = \Yii::$app->request->get();
        $keyword = array_key_exists('keyword', $getParams) && $getParams['keyword'] !== '' ? $getParams['keyword'] : '';
        $query->select([]);

        if ($keyword !== '') {
            $query->where([
                'or',
                ['like', 'currency', $keyword],
                ['like', 'e_currency', $keyword],
            ]);
            $query->andWhere('is_deleted = 0');
        } else {
            $query->where('is_deleted = 0');
        }
        if (($start = \Yii::$app->request->get('start', '')) != '') {

            $query->andWhere('create_time >= ' . strtotime($start));
        }
        if (($end = \Yii::$app->request->get('end', '')) != '') {
            $query->andWhere('create_time >0');
            $query->andWhere('create_time <= ' . strtotime($end));
        }

    }

    /**
     * @return array列表数组
     */
    public function afterList(&$list)
    {

    }
    /**
	 * 新增购买/充值汇率
	 */
	public function actionAdd() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
			$userService = new BuyExchangeService();
            $result = $userService->checkBuyExchange(['currency'=>$post['currency']]);
            if(!empty($result)&&$result['is_deleted']==0){
                $this->error('汇率已存在');
            }
			if ($userService->addExchange($post) === true) {
                //写入日志
                $LogService = new SystemLogService();
                $Log='购买/充值汇率：'.$post['buy_exchange_rate'].'，提现汇率：'.$post['sell_exchange_rate'];
                $LogService->add('添加汇率'.$post['currency'],$Log,'addExchange');
				$this->success('汇率新增成功');
			} else {
				$this->error('汇率新增失败，请稍候重试');
			}
		} else {
			$this->layout = 'modal';
			$result = [];
			return $this->render('form', $result);
		}
	}
    /**
     * 修改购买/充值汇率
     */
	public function actionEdit() {
		if (\Yii::$app->request->isPost) {
			$post = \Yii::$app->request->post();
            $userService = new BuyExchangeService();
            $result = $userService->UpBuyExchange($post);
            if(!empty($result)&&$result['is_deleted']==0){
                $this->error('币种已存在');
            }
            if (!is_exchange($post['buy_exchange_rate'])) {
                $this->error('请输入正确购买/充值汇率');
            }
            if (!is_exchange($post['sell_exchange_rate'])) {
                $this->error('请输入正确提现汇率');

            }
			$post['update_time']=time();
			$model = new \admin\models\BuyExchange();
			$one = $model->findOne($post['id']);
			$one->setAttributes($post);

			if ($one->validate()) {
			    //写入日志
                $LogService = new SystemLogService();
                $Log='购买/充值汇率：'.$post['buy_exchange_rate'].'，提现汇率：'.$post['sell_exchange_rate'];
                $LogService->add('修改汇率'.$post['currency'],$Log,'EditExchange');
				$result = $one->update();
				$result !== false ? $this->success('汇率编辑成功') : $this->error('汇率编辑失败，请稍候重试');
			} else {
				//获得第一条错误
				$this->error(current($one->getFirstErrors()));
			}
		} else {
			$userService = new BuyExchangeService();
			$result = $userService->getBuyExchange(['id' => \Yii::$app->request->get('id')]);
			$this->layout = 'modal';
			return $this->render('form', $result);
		}
	}
    /**
     * 汇率详情
     */
    public function actionInfo() {

        $post['id'] = \Yii::$app->request->get('id');
        $service = new BuyExchangeService();
        $result = $service->findBuyExchange($post);
        $userService = new SystemUserService();
        $user = $userService->getInfoById(['id' => $result['operator']]);
        $result['operator']=$user['username'];
        $this->layout = 'modal';
        return $this->render('info', $result);
    }

	/**
	 * 删除汇率
	 */
	public function actionDel() {

        $id = \Yii::$app->request->post('id');

        is_array($id) && $id = join(',', $id);
        if (!\Yii::$app->request->isPost || empty($id)) {
            $this->error('非法请求');
        }
        $post['id']=$id;
        $post['is_deleted']=1;
        $service = new BuyExchangeService();
        $result = $service->del($post);
        $find = $service->findBuyExchange($post);

        if (!$result) {
            $this->error($service->errMsg);
        }
        //写入日志
        $LogService = new SystemLogService();
        $Log='';
        $LogService->add('删除汇率'.$find['currency'],$Log,'DelExchange');
        $this->success('删除成功');
	}


}
