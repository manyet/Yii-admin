<?php

namespace admin\controllers;
use admin\models\FaqType;
use admin\services\FaqTypeService;
use Yii;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class FaqTypeController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = 'FAQ类型管理';

    /**
     * 需要权限控制的方法
     * @var array
     */
    public $access = [
        'index' => '首页',
        'add' => '添加',
        'edit' => '编辑',
        'del' => '删除',
		'save-order' => '排序',
    ];

    /**
     * 菜单模块选择器
     * @var array
     */
    public $menu = [
        'index' => '首页'
    ];
    protected $_table = 'faq_type';

    protected $status = 0;
    public function beforeList(&$query)
    {
        $query->select([]);
        $sort = '`sort`,id';
        $query->orderBy($sort);

    }

    /**
     * @return array列表数组
     */
    public function afterList(&$list)
    {
    }
    /**
 * @return 添加
 */
    public function actionAdd()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $userService= new FaqTypeService();
            $list=$userService->addFaqType($post);
//            var_dump($list);exit();
            if ( $list=== true) {
                $this->success('新增成功');
            } else {
                $this->error($list);
            }
        } else {
            $view=Yii::$app->view;
            $title='新增';
            $view->params['title'] = $title;
            $this->layout = 'modal';
            $result = [];
            return $this->render('form', $result);
        }
    }
    /**
     * @return 修改
     */
    public function actionEdit()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model = new \admin\models\FaqType();
            $one = $model->findOne($post['id']);
            $one->setAttributes($post);

            if ($one->validate()) {
                $result = $one->update();
                $result !== false ? $this->success('编辑成功') : $this->error('编辑失败，请稍候重试');
            } else {
                //获得第一条错误
                $this->error(current($one->getFirstErrors()));
            }

        } else {
            $view=Yii::$app->view;
            $title='编辑';
            $view->params['title'] = $title;
            $this->layout = 'modal';
            $post = \Yii::$app->request->get();
            $userService= new FaqTypeService();
            $result=$userService->getFaqType($post);
            return $this->render('form', $result);
        }
    }
    //删除
    public function actionDel()
    {
        $id = \Yii::$app->request->post('id');

        is_array($id) && $id = join(',', $id);
        if (!\Yii::$app->request->isPost || empty($id)) {
            $this->error('非法请求');
        }
        $service = new FaqTypeService();
        $find = $service->getFaq($id);
        if(!empty($find)){
            $this->error('操作失败，该类型下有内容信息，请返回FAQ删除内容后再操作…');
        }
        $result = $service->delFaq($id);

        if (!$result) {
            $this->error($service->errMsg);
        }
        $this->success('删除成功');

    }
}

