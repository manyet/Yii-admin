<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 微信多图文
 */
class WechatArticles extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%wechat_articles}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['article_id', 'create_at', 'create_by'], 'required'],
		];
	}

}
