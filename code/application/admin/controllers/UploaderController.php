<?php

namespace admin\controllers;

use common\controllers\AdminController;

class UploaderController extends AdminController {

	/**
	 * 单图上传
	 */
	public function actionSingle() {
		return $this->render('single');
	}

	/**
	 * 单图上传保存文件
	 */
	public function actionSingleSubmit() {
		if (isset($_FILES['img'])) {
			$extension = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
			if (in_array($extension, ['png', 'jpg', 'bmp', 'jpeg', 'gif'])) {
				$path = DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
				$filename = substr(md5(time() . mt_rand(10000, 99999)) . '.' . $extension, 16);
				$full_path = $path . $filename;
				$result = move_uploaded_file($_FILES['img']['tmp_name'], \Yii::getAlias('@webroot') . $full_path);
				if ($result) {
					$this->success('图片上传成功', \Yii::$app->request->hostInfo . \Yii::getAlias('@web') . str_replace(DIRECTORY_SEPARATOR, '/', $full_path), true);
					exit;
				}
			} else {
				$this->error('不支持的文件类型', '', true);
			}
		}
		$this->error('图片上传失败', '', true);
	}

	/**
	 * 裁剪上传
	 */
	public function actionCropper() {
		return $this->render('cropper');
	}

	/**
	 * 单图上传保存文件
	 */
	public function actionCropperSubmit() {
		$base64_str = \Yii::$app->request->post('img');
		$matchs = explode(',', $base64_str);
		preg_match('/data:image\/(.*);base64/', $matchs[0], $matchs_extension);
		if (isset($matchs[1]) && isset($matchs_extension[1])) {
			$extension = $matchs_extension[1];
			$content = base64_decode($matchs[1]);
			$path = DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
			$filename = substr(md5(time() . mt_rand(10000, 99999)) . '.' . $extension, 16);
			$full_path = $path . $filename;
			if (file_put_contents(\Yii::getAlias('@webroot') . $full_path, $content)) {
				$this->success('图片上传成功', \Yii::$app->request->hostInfo . \Yii::getAlias('@web') . str_replace(DIRECTORY_SEPARATOR, '/', $full_path));
				exit;
			}
		}
		$this->error('图片上传失败');
	}

	/**
	 * 多图上传
	 */
	public function actionMultiple() {
		return $this->render('multiple');
	}

}
