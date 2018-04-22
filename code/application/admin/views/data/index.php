<?php $this->beginBlock('container') ?>
<section class="content-header">
	<h1>
	  莫斯概览
	  <small>平台数据展示</small>
	</h1>
</section>
<section class="content animated fadeInUp">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="ion ion-pinpoint"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">平台总收入</span>
					<span class="info-box-number"><?= number_format($achievement, 2) ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-maroon"><i class="fa fa-strikethrough"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">已提现总额</span>
					<span class="info-box-number"><?= number_format($apply_cash, 2) ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-orange"><i class="ion ion-podium"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">平台项目投资总额</span>
					<span class="info-box-number"><?= number_format($dividend, 2) ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-teal"><i class="ion  ion-ios-people-outline"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">已入驻娱乐场</span>
					<span class="info-box-number"><?= number_format($casino_count) ?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">莫斯配套占比</h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				  </div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php
					$colors = ['info', 'danger', 'success', 'warning', 'primary'];
					$length = count($colors);
					foreach ($packages as $k => $one) {
					?>
					<div class="progress-group">
						<span class="progress-text"><?= $one['package_name'] ?> - <?= $one['level_name'] ?></span>
						<span class="progress-number"><b><?= $one['total_sales'] ?></b>/<?= $bought_package_count ?></span>
						<div class="progress sm">
						  <div class="progress-bar progress-bar-<?= $colors[$k % $length] ?>" style="width: <?= $one['total_sales'] / $bought_package_count * 100 ?>%"></div>
						</div>
					</div>
					<?php } ?>
				</div>
				<!-- /.footer -->
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-default">
				<div class="box-header with-border">
				  <h3 class="box-title">已购买配套比例</h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				  </div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <div class="row">
					<div class="col-md-8">
					  <div class="chart-responsive">
						<canvas id="pieChart" height="150"></canvas>
					  </div>
					  <!-- ./chart-responsive -->
					</div>
					<!-- /.col -->
					<div class="col-md-4" id="legend"></div>
					<!-- /.col -->
				  </div>
				  <!-- /.row -->
				</div>
				<!-- /.footer -->
			</div>
		</div>
	</div>
</section>
<script src="<?= get_plugin_url('chartjs/Chart.min.js') ?>"></script>
<script>
var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
var pieChart = new Chart(pieChartCanvas);
var PieData = [
{
  value: <?= $bought_package_count ?>,
  color: "#f56954",
  highlight: "#f56954",
  label: "已购配套玩家"
},
{
  value: <?= $no_package_count ?>,
  color: "#00a65a",
  highlight: "#00a65a",
  label: "普通注册玩家"
}
];
var pieOptions = {
segmentShowStroke: true,
segmentStrokeColor: "#fff",
segmentStrokeWidth: 1,
percentageInnerCutout: 50, // This is 0 for Pie charts
animationSteps: 100,
animationEasing: "easeOutBounce",
animateRotate: true,
animateScale: false,
responsive: true,
maintainAspectRatio: false,
legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend chart-legend clearfix\"><%for (var i=0; i<segments.length; i++){%><li><i class=\"fa fa-circle-o\" style=\"color:<%=segments[i].fillColor%>\"></i> <%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
tooltipTemplate: "<%=label%> <%=value%>"
};
var doughnut = pieChart.Doughnut(PieData, pieOptions);
var legend = doughnut.generateLegend();
$('#legend').html(legend);
</script>
<?php $this->endBlock() ?>