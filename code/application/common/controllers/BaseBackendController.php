<?php

namespace common\controllers;

use admin\services\PageService;

/**
 * 后台公共控制器
 */
class BaseBackendController extends BaseController
{

    /**
     * @var string 模块名称
     */
    public $module_title = '管理后台';

    /**
     * @var string 控制器名称
     */
    public $controller_title = '';

    /**
     * @var string 方法名称
     */
    public $action_title = '';

    /**
     * @var string 操作的表
     */
    protected $_table = '';

    /**
     * @var string 主表主键
     */
    protected $_table_pk = 'id';

    /**
     * @var string 主表别名
     */
    protected $_table_alias = 'a';

    /**
     * @var string 排序字段
     */
    protected $_table_sort = 'sort';

    /**
     * @var string 状态字段
     */
    protected $_table_status = 'status';

    /**
     * @var boolean 分页开关
     */
    protected $_page_on = true;

    /**
     * 列表前置操作的回调名称
     */
    protected $_callback_before_list = 'beforeList';

    /**
     * 列表后置操作的回调名称
     */
    protected $_callback_after_list = 'afterList';

    /**
     * 删除前置操作的回调名称
     */
    protected $_callback_before_del = 'beforeDel';

    /**
     * 排序后置操作的回调名称
     */
    protected $_callback_after_del = 'afterDel';

    /**
     * 排序前置操作的回调名称
     */
    protected $_callback_before_save_order = 'beforeSaveOrder';

    /**
     * 排序后置操作的回调名称
     */
    protected $_callback_after_save_order = 'afterSaveOrder';

    /**
     * 改变状态前置操作的回调名称
     */
    protected $_callback_before_change_status = 'beforeChangeStatus';

    /**
     * 改变状态后置操作的回调名称
     */
    protected $_callback_after_change_status = 'afterChangeStatus';

    /**
     * @var boolean 是否验证已登录
     */
    protected $_check_login = true;

    /**
     * @var boolean 是否验证权限
     */
    protected $_check_auth = true;

    /**
     * 不需要进行权限验证的模块
     */
    protected $_allow_list = array(
        'main/login',
        'main/do-login',
        'main/logout'
    );

    /**
     * 关闭默认布局
     */
    public $layout = false;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        // 初始化绑定模型，默认与控制器同名
        empty($this->_table) && $this->_table = strtolower(substr(__CLASS__, strrpos(__CLASS__, '\\') + 1, -10));
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        // 登录检查
        if ($this->_check_login) {
            if (!isLogin()) { // 未登录
                $this->warning('当前登录已失效，请重新登录！', \yii\helpers\Url::to(['main/login']));
            } else {
                if ($this->_check_auth && !$this->checkAuth()) { // 权限检查
                    $this->error('没有该页面访问权限！');
                }
            }
        }

        return true;
    }

    /**
     * 权限检查
     */
    protected function checkAuth()
    {
        if (method_exists($this, 'checkDynamicAuth')) {
            if ($this->checkDynamicAuth() === false) {
                return false;
            }
        }
        $path = $this->id . '/' . $this->action->id;
        if (in_array($path, $this->_allow_list)) {
            return true;
        }

        return checkAuth($path);
    }

    public function getTableName($table)
    {
        is_null($table) && $table = $this->_table;
        if (strpos($table, '!') === 0) {
            $table = substr($table, 1);
        } else {
            $table = "{{%{$table}}}";
        }

        return "$table AS {$this->_table_alias}";
    }

    /**
     * 默认首页方法
     */
    public function actionIndex()
    {
        return $this->renderIndex();
    }

    /**
     * 渲染列表页面
     * @param string $table 数据表名称
     * @param string|array $where 模板名称
     * @param string $tpl 模板名称
     * @return boolean|string 渲染完毕的HTML
     */
    public function renderIndex($table = null, $where = array(), $tpl = 'index')
    {
        $data = $this->getList($table, $where);
		$this->layout = 'index';
        return $this->render($tpl, $data);
    }

    /**
     * 获取数据列表
     * @param string $table 数据表名称
     * @param string|array $where 查询条件
     * @return array 数据结果集
     */
    protected function getList($table = null, $where = array())
    {
        // 指定操作表名
//        is_null($table) && $table = $this->_table;
        // 创建查询生成器
        $query = new \yii\db\Query();
        // 默认查询条件
        !empty($where) && $query->andWhere($where);
        // 执行前置操作
        if ($this->{$this->_callback_before_list}($query) === false) {
            return false;
        }
        $query->from($this->getTableName($table));
        // 页面输出变量数组
        $data = array();
        // 缓存排序规则，统计总数时，去掉排序规则
        $order_by = $query->orderBy;
        !empty($order_by) && $query->orderBy(null);
        // 查询数据和记录数
        if (!empty($query->groupBy)) { // 存在 GROUP BY 的时候，统计记录总数方式变更
            $old_query = $query;
            // 通过子查询的方式实现
            $query = (new \yii\db\Query())->from(['sub' => $old_query]);
            // 记录总数
            $data['total'] = $query->count();
            // 查询数据时，恢复排序规则
            !empty($order_by) && $old_query->orderBy($order_by);
            // 重新指定恢复排序后的子查询
            $query->from(['sub' => $old_query]);
        } else { // 普通数据查询
            // 记录总数
            $data['total'] = $query->count();
            // 查询数据时，恢复排序规则
            !empty($order_by) && $query->orderBy($order_by);
        }
        // 是否数据开启分页
        if ($this->_page_on) {
            $rows = PageService::getRows();
            // 分页控件
			$pager = $this->pager;
            $data['pager'] = $pager::widget(array('total' => $data['total'], 'rows' => $rows));
            if ($data['pager'] === '') {
                unset($data['pager']);
            }
			$pageCount = ceil($data['total'] / $rows);
            // 计算偏移量
            $offset = (min(\Yii::$app->request->get('page', 1), $pageCount) - 1) * $rows;
            $query->offset($offset)->limit($rows);
        }
        // 查询数据
        $data['list'] = $query->all();
        // 执行后置操作
        if ($this->{$this->_callback_after_list}($data['list']) === false) {
            return false;
        }

        // 返回结果
        return $data;
    }

    /**
     * 列表前置操作
     * @param \yii\db\Query $query 查询对象
     */
    public function beforeList(&$query)
    {

    }

    /**
     * 列表后置操作
     * @param array $list 查询结果集
     */
    public function afterList(&$list)
    {

    }

    /**
     * 排序
     */
    public function actionSaveOrder()
    {
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($this->{$this->_callback_before_save_order}($post[$this->_table_sort]) === false) {
                return false;
            }
            $success = false;
            if (!empty($post[$this->_table_sort])) {
                foreach ($post[$this->_table_sort] as $key => $value) {
                    $result = \Yii::$app->db->createCommand()->update($this->getTableName($this->_table),
                        [$this->_table_sort => $value], [$this->_table_pk => $key])->execute();
                    if ($result === false) {
                        $this->error('排序操作失败');
                    }
                }
                $success = true;
            }
            if ($this->{$this->_callback_after_save_order}($post[$this->_table_sort], $success) !== false) {
                if ($success) {
                    $this->success('排序操作成功');
                } else {
                    $this->error('没有要排序的数据');
                }
            }
        } else {
            $this->error('不支持该请求方式');
        }
    }

    /**
     * 排序前置操作
     * @param array $sort_list 排序数据列表
     */
    public function beforeSaveOrder(&$sort_list)
    {

    }

    /**
     * 排序后置操作
     * @param array $sort_list 排序数据列表
     * @param boolean $result 操作结果
     */
    public function afterSaveOrder(&$sort_list, $result)
    {

    }

    /**
     * 更改数据状态
     */
    public function actionChangeStatus()
    {
        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->post('id', '');
            if ($id === '' || $id == 0) {
                $this->error('参数传入缺失');
            }
            $status = \Yii::$app->request->post('status', '');
            if ($status === '') {
                $status = 0;
            }
            if ($this->{$this->_callback_before_change_status}($id, $status) === false) {
                return false;
            }
            $result = \Yii::$app->db->createCommand()
                    ->update($this->getTableName($this->_table), [$this->_table_status => $status],
                        [$this->_table_pk => $id])
                    ->execute() !== false;
            if ($this->{$this->_callback_after_change_status}($id, $status, $result) !== false) {
                if ($result) {
                    $this->success('数据状态更改成功');
                } else {
                    $this->error('数据状态更改失败');
                }
            }
        } else {
            $this->error('不支持该请求方式');
        }
    }

    public function beforeChangeStatus($id, $status)
    {

    }

    public function afterChangeStatus($id, $status, $result)
    {

    }

    /**
     * 表单添加操作
     * @param string $table
     * @param string|array $where
     * @param string $tpl
     * @return boolean
     */
    protected function _add($table = null, $where = array(), $tpl = 'form')
    {
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            unset($data[\Yii::$app->request->csrfParam]);
            if ($this->_callback('beforeFormSubmit', $data) === false) {
                return false;
            }
            if ($this->_callback('beforeAddSubmit', $data) === false) {
                return false;
            }
            is_null($table) && $table = $this->_table;
            // 添加操作
            $model_name = ucfirst($table);
            $path = COMMON_PATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model_name . '.php';
            if (file_exists($path)) {
                $namespace = '\\common\\models\\' . $model_name;
                $model = new $namespace();
                $model->setScenario('add');
                $model->setAttributes($data);
                if ($model->insert()) {
                    $result = true;
                } else {
                    $result = false;
                    $this->error(current($model->getFirstErrors()));
                }
            } else {
                $result = \Yii::$app->db->createCommand()->insert($this->getTableName($table),
                        $data)->execute() !== false;
//				$insert_id = \Yii::$app->db->getLastInsertID();
            }
            if ($this->_callback('afterAddSubmit', $data, $result) === false) {
                return false;
            }
            if ($this->_callback('afterFormSubmit', $data, $result) === false) {
                return false;
            }
            if ($result) {
                $this->success('数据新增成功');
            } else {
                $this->error('数据新增失败，请稍候重试');
            }
        } else {
            if ($this->_callback('beforeForm') === false) {
                return false;
            }
            if ($this->_callback('beforeAdd') === false) {
                return false;
            }
            if ($this->_callback('afterAdd') === false) {
                return false;
            }
            if ($this->_callback('afterForm') === false) {
                return false;
            }

			$this->layout = 'modal';
            return $this->render($tpl);
        }
    }

    /**
     * 表单编辑操作
     * @param string $table
     * @param string|array $where
     * @param string $tpl
     * @return boolean
     */
    protected function _edit($table = null, $where = array(), $tpl = 'form')
    {
        if (\Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            unset($data[\Yii::$app->request->csrfParam]);
            if ($this->_callback('beforeFormSubmit', $data) === false) {
                return false;
            }
            if ($this->_callback('beforeEditSubmit', $data, $where) === false) {
                return false;
            }
            is_null($table) && $table = $this->_table;
            // 保存操作
            $model_name = ucfirst($table);
            $path = COMMON_PATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $model_name . '.php';
            if (file_exists($path)) {
                $namespace = '\\common\\models\\' . $model_name;
                $model = new $namespace();
                $where['id'] = $data['id'];
                $model->setScenario('edit');
                $one = $model->findOne($where);
                $one->setAttributes($data);
                if ($one->update() !== false) {
                    $result = true;
                } else {
                    $result = false;
                    $this->error(current($one->getFirstErrors()));
                }
            } else {
                $result = \Yii::$app->db->createCommand()->update($this->getTableName($table), $data,
                        $where)->execute() !== false;
            }
            if ($this->_callback('afterEditSubmit', $data, $result) === false) {
                return false;
            }
            if ($this->_callback('afterFormSubmit', $data, $result) === false) {
                return false;
            }
            if ($result) {
                $this->success('数据编辑成功');
            } else {
                $this->error('数据编辑失败，请稍候重试');
            }
        } else {
            if ($this->_callback('beforeForm') === false) {
                return false;
            }
            $id = \Yii::$app->request->get('id', '');
            $query = new \yii\db\Query();
            if ($this->_callback('beforeEdit', $query, $id) === false) {
                return false;
            }
//            is_null($table) && $table = $this->_table;
            !empty($where) && $query->andWhere($where);
            $table_pk = "{$this->_table_alias}." . $this->_table_pk;
            $data = $query->from($this->getTableName($table))->andWhere($table_pk . ' = :id',
                [$this->_table_pk => $id])->one();
            if (empty($data)) {
                $this->error('该记录不存在');
            }
            if ($this->_callback('afterEdit', $data) === false) {
                return false;
            }
            if ($this->_callback('afterForm') === false) {
                return false;
            }

			$this->layout = 'modal';
            return $this->render($tpl, $data);
        }
    }

    /**
     * 编辑操作
     */
    public function actionEdit()
    {
        return $this->_edit();
    }

    /**
     * 新增操作
     */
    public function actionAdd()
    {
        return $this->_add();
    }

    /**
     * 刪除操作
     */
    public function actionDel()
    {
        $id = \Yii::$app->request->post('id');
        is_array($id) && $id = join(',', $id);
        if (!\Yii::$app->request->isPost || empty($id)) {
            $this->error('非法请求');
        }

        if ($this->_callback($this->_callback_before_del, $id) === false) {
            return false;
        }

        $result = \Yii::$app->db->createCommand("DELETE {$this->_table_alias} FROM {$this->getTableName($this->_table)} WHERE {$this->_table_alias}.{$this->_table_pk} IN (:id)")
                ->bindValues([':id' => $id])
                ->execute() !== false;

        if ($this->_callback($this->_callback_after_del, $id, $result) !== false) {
            if ($result) {
                $this->success('数据删除成功');
            } else {
                $this->error('数据删除失败，请稍候重试');
            }
        }
    }

    /**
     * 执行回调函数
     * @param string $method 回调函数名称
     * @param mixed $params1
     * @param mixed $params2
     * @return mixed|null
     */
    protected function _callback($method, &$params1 = array(), &$params2 = array())
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($params1, $params2);
        }

        return null;
    }

}
