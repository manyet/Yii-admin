<?php
/* @var $this \yii\web\View */

echo getCommonJs();

// 样式区块
if (isset($this->blocks['style'])) {
	echo $this->blocks['style'];
}

if (isset($this->blocks['container'])) { echo $this->blocks['container']; } else {
?>
<section class="content">
<div class="box">
  <div class="box-header with-border">
	<h3 class="box-title"><?php if (isset($this->blocks['title'])) { echo $this->blocks['title']; } else { ?><?= $this->context->action_title ?><?php } ?></h3>

	<?php if (isset($this->blocks['tool'])) { ?>
	<div class="pull-right">
	  <?= $this->blocks['tool'] ?>
	</div>
	<?php } ?>
  </div>
  <div class="box-body animated fadeInUp">
	<?php
	if (isset($this->blocks['search'])) { echo $this->blocks['search']; }
	if (isset($this->blocks['content'])) { echo $this->blocks['content']; }
	?>
  </div>
  <?php if (isset($this->blocks['footer'])) { ?>
  <div class="box-footer"><?= $this->blocks['footer'] ?></div>
  <?php } ?>
</div>
</div>
<?php
}
// 脚本区块
if (isset($this->blocks['script'])) {
	echo $this->blocks['script'];
}
?>