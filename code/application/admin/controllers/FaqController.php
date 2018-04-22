<?php

namespace admin\controllers;
use Yii;
use admin\services\FaqService;
use common\controllers\AdminController;

/**
 * 系统用户管理控制器
 * @date 2016-11-09 15:41
 */
class FaqController extends AdminController {

    /**
     * 控制器名称
     * @var string
     */
    public $controller_title = 'FAQ管理';

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
    protected $_table = 'faq';

    protected $status = 0;

    public function beforeList(&$query)
    {
        $getParams = \Yii::$app->request->get();
        $keyword = array_key_exists('keyword', $getParams) && $getParams['keyword'] !== '' ? $getParams['keyword'] : '';
        $query->select('a.*, u.type_name')
            ->leftJoin('end_faq_type u', 'u.id = a.type_id');

        if (($status = \Yii::$app->request->get('status', '')) != '') {
            $query->andWhere('`type_id` = ' . $status);
        }
        $sort = 'a.sort,a.id';
        $query->orderBy($sort);

    }

    /**
     * @return array列表数组
     */
    public function afterList(&$list)
    {
        $userService= new FaqService();
        $result=$userService->FindFaqType();
        $view=Yii::$app->view;
        $view->params['result'] = $result;

    }
    /**
     * @return 添加
     */
    public function actionAdd()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $userService= new FaqService();
            $result=$userService->addFaq($post);
//            var_dump($post);exit();
            if ( $result=== true) {
                $this->success('新增成功');
            } else {
                $this->error($result);
            }
        } else {
            $userService= new FaqService();
            $list=$userService->FindFaqType();
            $view=Yii::$app->view;
            $view->params['list'] = $list;
            $this->layout = 'modal';
            $result=[];
            $view=Yii::$app->view;
            $title='新增';
            $view->params['title'] = $title;
            return $this->render('form', $result);
        }
    }
    /**
     * @return 添加
     */
    public function actionEdit()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $model = new \admin\models\Faq();
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
            $get = \Yii::$app->request->get();
            $userService= new FaqService();
            $result=$userService->getFaq($get);
            $list=$userService->FindFaqType();
            $view=Yii::$app->view;
            $view->params['list'] = $list;
            $this->layout = 'modal';
            return $this->render('form', $result);
        }
    }

}
