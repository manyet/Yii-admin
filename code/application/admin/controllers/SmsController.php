<?php

namespace admin\controllers;

use common\controllers\AdminController;
use common\models\SmsRecord;

class SmsController extends AdminController
{

	/**
	 * 控制器名称
	 * @var string
	 */
	public $controller_title = '短信记录';

	/**
	 * 需要权限控制的方法
	 * @var array
	 */
	public $access = [
		'index' => '首页',
		'view' => '查看'
	];

	/**
	 * 菜单模块选择器
	 * @var array
	 */
	public $menu = [
		'index' => '首页'
	];

    public $_table = 'sms_record';

    public function beforeList(&$query)
    {
        $query->select('id,recipient,status,create_time');
        if (($mobile = \Yii::$app->request->get('mobile', '')) != '') {
            $query->andWhere(['like', 'recipient', $mobile]);
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

    public function actionView(){
        $id = \Yii::$app->request->get('id', '');
        if (!empty($id)) {
			$result = SmsRecord::find()->where('id = :id', ['id' => $id])->asArray()->one();
        }
		$this->layout = 'modal';
		return $this->render('view', empty($result) ? [] : $result);
    }

}
