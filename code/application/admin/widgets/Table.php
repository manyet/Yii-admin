<?php

namespace admin\widgets;

/**
 * 表格生成辅助类
 */
class Table extends \yii\base\Widget {

	/**
	 * 表格列
	 * @var string
	 */
	public $columns = array();

	/**
	 * 操作列
	 * @var string
	 */
	public $operations = array();

	/**
	 * 表格样式
	 * @var string
	 */
	public $className = 'table table-hover';

	/**
	 * 排序的名称
	 * @var string
	 */
	public $sort = '';

	/**
	 * 行颜色
	 * @var string
	 */
	public $rowColor = '';

	/**
	 * 勾选操作
	 * @var string
	 */
	public $checkbox = '';

	/**
	 * 列表数据结果集
	 * @var array
	 */
	public $list = array();

	/**
	 * 表格ID
	 * @var string
	 */
	public $id = '';

	/**
	 * 默认配置
	 * @var array
	 */
	public $defaults = array(
		'valign' => 'middle', // 垂直对其方式
		'align' => 'center', // 列表行水平对齐方式
		'halign' => 'center' // 标题行水平对齐方式
	);

	public function run() {
		// 处理生成表格参数
		$params = [
			'columns' => $this->columns,
		];
		// 设置样式名称
		if ($this->className !== '') {
			$params['className'] = $this->className;
		}
		// 设置表格ID
		if ($this->id !== '') {
			$params['id'] = $this->id;
		}
		// 开启排序
		if ($this->sort !== '' && checkAuth(\Yii::$app->controller->id . '/' . 'save-order')) {
			$params['sort'] = $this->sort;
		}
		// 开启勾选
		if ($this->checkbox !== '') {
			$params['checkbox'] = $this->checkbox;
		}
		// 设置行颜色
		if ($this->rowColor !== '') {
			$params['rowColor'] = $this->rowColor;
		}
		// 操作列
		if (!empty($this->operations)) {
			foreach ($this->operations as $key => $one) {
				if (!checkAuth($one['path'])) { // 权限验证
					unset($this->operations[$key]);
				}
			}
			if (!empty($this->operations)) {
				$params['operations'] = array_values($this->operations);
			}
		}
		$params_json = json_encode($params);
		// 列表数据JSON
		$list_json = json_encode($this->list);
		// 表格容器ID
		$container_id = 'table-con-' . uniqid();
		// 返回内容
		return <<<html
<div class="table-responsive" id="$container_id"></div>
<script>$("#$container_id").html($.table.render($params_json,$list_json));</script>
html;
	}

}
