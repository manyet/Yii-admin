<?php $this->beginBlock('title'); ?>任务图片<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<style>.modal-dialog{width: 800px;}</style>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php
			$first_indicators = false;
			$count_indicators = 0;
			for ($i = 1; $i < 7; $i++) {
				$pic = ${'ad_pic_' . $i};
				if (!empty($pic)) {
					$count_indicators++;
					if ($count_indicators === 1) {
						$first_indicators = true;
					}
					
		?>
		<li data-target="#carousel-example-generic" data-slide-to="<?= $i?>" class="<?php if ($first_indicators){echo 'active';}?>"></li>
		<?php } ?>
		<?php $first_indicators = false;} ?>
	</ol>
	<div class="carousel-inner">
		<?php
			$first_inner = false;
			$count_inner = 0;
			for ($i = 1; $i < 7; $i++) {
				$pic = ${'ad_pic_' . $i};
				if (!empty($pic)) {
					$count_inner++;
					if ($count_inner === 1) {
						$first_inner = true;
					}
		?>
		<div class="item <?php if ($first_inner){echo 'active';}?>">
			<img src="<?= $pic?>" alt="First slide">
		</div>
		<?php } ?>
		<?php $first_inner = false;} ?>
	</div>
	<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		<span class="fa fa-angle-left"></span>
	</a>
	<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		<span class="fa fa-angle-right"></span>
	</a>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer'); ?>
<button type="button" class="btn btn-white hide" data-dismiss="modal">关闭</button>
<?php $this->endBlock() ?>

