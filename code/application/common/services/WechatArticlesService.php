<?php

namespace common\services;

use common\models\WechatArticle;
use common\models\WechatArticles;

class WechatArticlesService {

	public static $errMsg = '';

	public static function search($keyword, $fields = '*') {
		return WechatArticles::find()->select($fields)->where([
				'or',
				['like', 'title', $keyword],
				['like', 'author', $keyword],
			])->asArray()->all();
	}

	public static function getArticlesList($fields = '*') {
		return WechatArticles::find()->select($fields)->asArray()->all();
	}

	public static function getDetailById($id, $fields = '*') {
		$info = WechatArticles::find()->select('id,article_id')->where('id = :id', ['id' => $id])->asArray()->one();
		if (empty($info)) {
			return NULL;
		}
		$info['articles'] = WechatArticle::find()->where("id IN ({$info['article_id']})")->orderBy(["field (`id`,{$info['article_id']})" => SORT_ASC])->select($fields)->asArray()->all();
		return $info;
	}

	public static function addArticles($data) {
		$model = new WechatArticles();
		$data['create_at'] = date('Y-m-d H:i:s');
		$data['create_by'] = getUserId();
		$model->setAttributes($data);
		if (!$model->insert()) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

	public static function updateArticles($id, $data) {
		$model = WechatArticles::findOne($id);
		$model->setAttributes($data);
		if ($model->update() === false) {
			self::$errMsg = current($model->getFirstErrors());
			return false;
		}
		return true;
	}

}
