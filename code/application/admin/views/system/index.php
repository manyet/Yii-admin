<?php $this->beginBlock('title') ?>
系统信息
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<div class="row">
<div class="col-md-4">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">系统环境</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width="120px">PHP 版本</td>
							<td><?= phpversion() ?></td>
						</tr>
						<tr>
							<td width="120px">Yii 版本</td>
							<td><?= Yii::getVersion() ?></td>
						</tr>
						<tr>
							<td width="120px">CGI</td>
							<td><?= php_sapi_name() ?></td>
						</tr>
						<tr>
							<td width="120px">Uname</td>
							<td><?= php_uname() ?></td>
						</tr>
						<tr>
							<td width="120px">Server</td>
							<td><?= $_SERVER['SERVER_SOFTWARE'] ?></td>
						</tr>
						<tr>
							<td width="120px">Cache 驱动</td>
							<td><?= get_class(Yii::$app->cache) ?></td>
						</tr>
						<tr>
							<td width="120px">Session 驱动</td>
							<td><?= get_class(Yii::$app->session) ?></td>
						</tr>
						<tr>
							<td width="120px">系统时区</td>
							<td><?= date_default_timezone_get() ?></td>
						</tr>
						<tr>
							<td width="120px">PHP 上传大小</td>
							<td><?= $maxUpload ?></td>
						</tr>
						<!--<tr>
							<td width="120px">Locale</td>
							<td>zh-CN</td>
						</tr>
						<tr>
							<td width="120px">Env</td>
							<td>local</td>
						</tr>
						<tr>
							<td width="120px">URL</td>
							<td>http://oa.wzjo2o.com</td>
						</tr>-->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">数据库</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width="120px">MySQL 版本</td>
							<td><?= Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION) ?></td>
						</tr>
						<tr>
							<td width="120px">数据库路径</td>
							<td><?= $dbPath ?></td>
						</tr>
						<tr>
							<td width="120px">文件尺寸</td>
							<td><?= $dbSize ?></td>
						</tr>
						<tr>
							<td width="120px">支持驱动</td>
							<td><?= join(',', Yii::$app->db->pdo->getAvailableDrivers()) ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">系统要求</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width="120px">PHP</td>
							<td><label class="label label-primary">>=5.4.0</label></td>
						</tr>
						<tr>
							<td width="120px">MySQL</td>
							<td><label class="label label-primary">>=5.1.0</label></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<?php $this->endBlock() ?>