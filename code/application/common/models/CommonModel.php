<?php

namespace common\models;

use yii\base\Model;
use yii\db\Query;

/**
 * 公共模型
 */
class CommonModel extends Model
{

    public $bind_model;

    public $transaction;

    public $db;

    public $command;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Yii::$app->db;
    }

    /**
     * 获取查询对象
     * @return Query
     */
    public function _getQueryObject()
    {
        return new Query();
    }

    /**
     * 获取操作对象
     * @return \yii\db\Command
     */
    public function _getActionObject()
    {
        if ($this->command) {
            return $this->command;
        } else {
            $this->command = $this->db->createCommand();
            return $this->command;
        }
    }

    /**
     * 获得验证规则的第一条错误
     * @return mixed
     */
    public function getFirstErrorMessage()
    {
        return current($this->getFirstErrors());
    }

    /**
     * 基本多条查询语句
     * @param $b_count
     * @param $fields
     * @param string $conditions
     * @param array $bind_params
     * @param string $order_by
     * @param string $limit
     * @return array
     */
    public function select_base($b_count = false, $fields = "*", $conditions = '', $bind_params = [], $order_by = "", $limit = '', $table_name = '')
    {
        $query = $this->_getQueryObject();

        if ($b_count === false) {
            $query = $query->select($fields);
        } else {
            $query = $query->select('count(1) as `_num`');
        }

        if ($conditions) {
            $query = $query->where($conditions, $bind_params);
        }

        if ($order_by) {
            $query = $query->orderBy($order_by);
        }

        if ($limit) {
            list($_offset, $_length) = explode(',', $limit);
            $query = $query->limit($_length)->offset($_offset);
        }

        $table_name = !empty($table_name) ? $table_name : $this->bind_model;

        $result = $query->from($table_name)->all();
        if ($b_count) {
            $result = $result[0]['_num'];
        }

        return $result;
    }

    /**
     * 查询单条查询语句
     * @param $fields               查询的字段
     * @param string $conditions 条件
     * @param array $bind_params 条件绑定参数
     * @param string $table_name 模型名
     */
    public function find_base($fields, $conditions = '', $bind_params = [], $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        $query = $this->_getQueryObject()->select($fields)->from($table_name);

        if ($conditions) {
            $query = $query->where($conditions, $bind_params);
        }
        return $query->one();
    }


    public function getFieldScalar($fields = '*', $condition = '1=1', $bind_params = [], $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        $query = $this->_getQueryObject()->select($fields)->from($table_name);
        return $query->where($condition, $bind_params)->scalar();
    }

    public function getFieldColumn($fields = '*', $condition = '1=1', $bind_params = [], $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        $query = $this->_getQueryObject()->select($fields)->from($table_name);
        return $query->where($condition, $bind_params)->column();
    }

    /**
     * 更新单条数据语句
     * @param $columns      需要更新的数据
     * @param $conditions   条件
     * @param $bind_params  条件绑定参数
     * @return int
     */
    public function update_base($columns, $conditions, $bind_params, $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        return $this->_getActionObject()->update($table_name, $columns, $conditions, $bind_params)->execute();
    }

    /**
     * 插入数据操作
     * @param array $columns
     * @return $this
     */
    public function insert_base($columns = [], $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        return $this->_getActionObject()->insert($table_name, $columns)->execute();
    }

    /**
     * 删除单条数据语句
     * @param $conditions       条件
     * @param $bind_params      条件绑定参数
     * @return int
     */
    public function delete_base($conditions, $bind_params, $table_name = '')
    {
        $table_name = !empty($table_name) ? $table_name : $this->bind_model;
        return $this->_getActionObject()->delete($table_name, $conditions, $bind_params)->execute();
    }

}
