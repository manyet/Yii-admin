<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * 微信多图文
 */
class WechatKeyword extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%wechat_keyword}}';
	}

	/**
	 * 验证规则
	 * @return array
	 */
	public function rules() {
		return [
			[['keys', 'type', 'create_by', 'create_at'], 'required'],
			[['content', 'video_desc', 'video_url', 'video_title', 'music_desc', 'music_image', 'music_url', 'music_title', 'voice_url', 'image_url'], 'string'],
			[['news_id', 'create_by', 'status'], 'integer'],
		];
	}

}
