<?php

namespace admin\controllers;

use common\controllers\AdminController;
use admin\services\SendNoteRecordService;

class NoteController extends AdminController
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

    public $_table = 'send_note_record';

    public function beforeList(&$query)
    {
        $query->select('id,user_id,key,code,mobile,send_time');
        if (($key = \Yii::$app->request->get('key', '')) != '') {
            $query->andWhere(['like', 'key', $key]);
        }
        if (($mobile = \Yii::$app->request->get('mobile', '')) != '') {
            $query->andWhere('mobile=:mobile', [':mobile' => $mobile]);
        }
        //时间搜索条件拼装
        $start_date = \Yii::$app->request->get('start_date', '');
        $end_date = \Yii::$app->request->get('end_date', '');
        if ($start_date !== '' && $end_date === '') {
            $query->andWhere(['>=', 'send_time', strtotime($start_date)]);
        } else if ($start_date === '' && $end_date !== '') {
            $query->andWhere(['<=', 'send_time', strtotime($end_date)]);
        } else if ($start_date !== '' && $end_date !== '') {
            $query->andWhere(['between', 'send_time', strtotime($start_date), strtotime($end_date)]);
        }

        $query->orderBy('id DESC');

		// 处理类型列表
		$typeList = (new \admin\services\TemplateService())->getList('key,title');
		$newArr = [];
		foreach ($typeList as &$row) {
			$newArr[$row['key']] = $row['title'];
		}
		// 短信类型筛选
		$this->getView()->params['typeList'] = $newArr;
    }

	public function afterList(&$list) {
		foreach ($list as &$row) {
			if ($row['key'] != '' && isset($this->getView()->params['typeList'][$row['key']])) {
				$row['key'] = $this->getView()->params['typeList'][$row['key']];
			}
		}
		$this->layout = 'index';
	}

    public function actionView(){
        $sendNoteRecordService = new SendNoteRecordService();
        $id = \Yii::$app->request->get('id', '');
		$result = [];
        if ($id === '' || $id == 0) {
            $result = $sendNoteRecordService->getInfo($id);
//            $result['send_time'] = date('Y-m-d H:i:s',$result['send_time']);
//            $result['expiry_time'] = date('Y-m-d H:i:s',$result['expiry_time']);
        }
		$this->layout = 'modal';
		return $this->render('view', $result);
    }
}