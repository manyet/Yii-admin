<?php

namespace wap\services;

use wap\models\Notice;

class NoticeService {

	public function getList($page, $pageSize, $type, $user_id) {
		$fields = "n.*,IF(nr.user_id = {$user_id},1,0) AS n_status";
		$where = "FIND_IN_SET('{$type}',n.type) AND nr.user_id = {$user_id} OR (n.id NOT IN (SELECT nr2.notice_id from {{%notice_record}} nr2 WHERE nr2.user_id = {$user_id}) AND FIND_IN_SET('{$type}',n.type))";
		$query = Notice::find()->alias('n')->select([$fields])->where($where)->leftJoin('{{%notice_record}} nr', 'nr.notice_id = n.id')->groupBy('n.id');
        $total = $query->count();
        $list = $query->offset(($page - 1) * $pageSize)->orderBy('n.create_time DESC')->limit($pageSize)->asArray()->all();
        return ['list' => $list, 'total' => $total];
    }
	
	public function getUnread($user_id, $type) {
		$sql = "SELECT * FROM {{%notice}} n WHERE FIND_IN_SET('{$type}',n.type) AND n.id NOT IN (SELECT nr.notice_id from {{%notice_record}} nr WHERE nr.user_id = {$user_id})";
		return \Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function readAll($data = []) {
		if (empty($data)) {
			return false;
		}
		return \Yii::$app->db->createCommand()->batchInsert('{{%notice_record}}', ['user_id', 'notice_id', 'create_time'], $data)->execute();
	}
	
	public function getRecordByUserId($user_id) {
		$sql = "SELECT * FROM {{%notice_record}} WHERE user_id = {$user_id}";
		return \Yii::$app->db->createCommand($sql)->queryAll();
	}
	
}
