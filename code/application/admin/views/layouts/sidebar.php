<ul class="sidebar-menu tree" id="side-menu">
<?php
// 一级菜单
foreach ($menus as $first) {
	if (!empty($first['children'])) {
		echo $this->render('sub-menu.php', ['menus' => $first['children'], 'parent_id' => $first['id'], 'parent_spm' => $first['id']]);
	}
}
?>
</ul>