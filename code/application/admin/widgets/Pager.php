<?php

namespace admin\widgets;

use yii\base\Widget;
use admin\services\PageService;

/**
 * 分页挂件
 */
class Pager extends Widget {

	/**
	 * 总记录数
	 * @var int
	 */
	public $total = 0;

	/**
	 * 生成的表格ID
	 * @var string
	 */
	public $id = '';

	/**
	 * 每页条数
	 * @var int
	 */
	public $rows = 0;

	public function __construct($config = []) {
		parent::__construct($config);
		if ($this->rows === 0) {
			$this->rows = PageService::getRows();
		}
	}

	public function run() {
		$total = $this->total; // 总记录数
		$page = max(\Yii::$app->request->get('page'), 1); // 当前页码过滤小于1的页数
		$rows = $this->rows; // 每页条数
		setcookie('rows', $rows, 0, '/'); // 缓存每页条数
		$pageCount = ceil($total / $rows); // 总页数
		$page = min($page, $pageCount); // 当前页码过滤大于总页数的页数
//		if ($total <= 0 || $pageCount == 1) { // 记录数目为零，不显示分页
		if ($total <= 0) { // 记录数目为零，不显示分页
			return '';
		}
		$start = ($page - 1) * $rows + 1; // 记录开始条数
		$end_count = $rows; // 当前页数据条数
		if ($page >= $pageCount) { // 最后一页
			$last_page_record_count = $total % $rows; // 最后一页的记录数
			$end_count = $last_page_record_count > 0 ? $last_page_record_count : $rows; // 最后一页的记录条数处理
		}
		$end = $start + $end_count - 1; // 记录结束条数
		$url = \Yii::$app->request->url; // 页面基础URL
		$id = $this->id === '' ? 'pager-' . uniqid() : $this->id; // 分页元素ID
		return <<<HTML
<div class="row" style="line-height:26px">
	<div class="col-md-6">当前显示 $start 到 $end 条，共 $total 条记录</div>
	<div class="col-md-6">
		<table class="pull-right">
			<tr>
				<td style="padding-right:8px">每页
					<select style="border:0" id="$id-select"><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option></select> 条
				</td>
				<td id="$id"></td>
			</tr>
		</table>
	</div>
</div>
<script>$("#$id-select").change(function(){ $.page.redirect((new URI(location.hash.substr(1))).setParam({page:1,rows:this.value}).toURL())}).val('$rows');$("#$id").myPager({pageCount:$pageCount,current:$page,url:'$url',rows:$rows});</script>
HTML;
	}

}
