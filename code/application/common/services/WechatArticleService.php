<?php

namespace common\services;

use common\models\WechatArticle;

class WechatArticleService {

	public static $errMsg = '';

	public static function search($keyword, $fields = '*') {
		return WechatArticle::find()->select($fields)->where([
				'or',
				['like', 'title', $keyword],
				['like', 'author', $keyword],
			])->asArray()->all();
	}

	public static function getArticleList($id, $fields = '*') {
		return WechatArticle::find()->select($fields)->where('id = :id', ['id' => $id])->asArray()->one();
	}

	public static function getArticleById($id, $fields = '*') {
		return WechatArticle::find()->select($fields)->where('id = :id', ['id' => $id])->asArray()->one();
	}

	public static function addArticle($data) {
		$model = new WechatArticle();
		$data['create_at'] = date('Y-m-d H:i:s');
		$data['create_by'] = getUserId();
		$model->setAttributes($data);
		if (!$model->insert()) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

	public static function updateArticle($id, $data) {
		$model = WechatArticle::findOne($id);
		$model->setAttributes($data);
		if ($model->update() === false) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

	public static function getDetailUrl($row) {
		if (!empty($row['content_source_url'])) {
			return $row['content_source_url'];
		}
		return \Yii::$app->params['frontUrl'] . '/article/detail.html?id=' . $row['id'];
	}

}
