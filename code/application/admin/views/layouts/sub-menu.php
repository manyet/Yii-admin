<?php
// 一级菜单
foreach ($menus as $row) {
	$spm = $parent_spm . '.' . $row['id'];
?>
  <li<?php if (isset($row['children'])) { ?> class="treeview"<?php } ?> data-menu-spm="<?= $spm ?>" data-menu-parent="<?= $row['parent_id'] ?>">
	<a href="javascript:;"<?php if (!isset($row['children'])) { ?> data-open-page="<?= $row['url'] ?>"<?php } ?>>
	  <i class="<?php if (isset($row['icon']) && $row['icon'] !== '') { echo $row['icon']; } else { echo 'fa fa-circle-o'; } ?>"></i>
	  <span><?= $row['name'] ?></span>
	  <?php if (isset($row['children'])) { ?>
	  <span class="pull-right-container">
		<i class="fa fa-angle-left pull-right"></i>
	  </span>
	  <?php } ?>
	</a>
	<?php if (isset($row['children'])) { ?>
	<ul class="treeview-menu">
	<?php
	// 二级菜单
	echo $this->render('sub-menu', ['menus' => $row['children'], 'parent_id' => $row['id'], 'parent_spm' => $spm]);
	?>
	</ul>
    <?php } ?>
  </li>
<?php
}
?>