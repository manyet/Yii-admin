<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 微信文章
 */
class WechatArticle extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%wechat_article}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['title', 'local_url', 'author', 'create_at', 'create_by'], 'required'],
			[['title', 'local_url', 'author', 'content', 'digest', 'content_source_url'], 'string'],
			[['show_cover_pic'], 'integer']
		];
	}

}
