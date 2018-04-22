<?php

namespace common\models;

/**
 * 业绩记录表
 *
 * @date 2016-11-15 10:24:31
 */
class AchievementRecord extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%user_achievement_record}}';
	}

}
