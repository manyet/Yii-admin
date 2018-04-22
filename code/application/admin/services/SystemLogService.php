<?php

namespace admin\services;

use Yii;
use admin\models\SystemLog;

class SystemLogService {

	/**
	 * 添加日志
	 * @param string $title 操作标题
	 * @param string $content 操作内容
	 * @param string $type 操作类型
	 * @return boolean
	 */
	public static function add($title, $content = '', $type = 'SUCCESS') {
		$ip = Yii::$app->request->userIP;
		$columns = [
			'title' => $title,
			'content' => $content,
			'ip' => $ip,
			'isp' => str_replace(array('未分配或者内网IP|0|0|0|0', '|'), array('未分配或者内网IP', ''), \library\Ip2Region\Ip2Region::query($ip)),
			'type' => strtoupper($type),
			'create_by' => getUserId(),
			'from' => Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id,
			'create_time' => time()
		];
        $headers = Yii::$app->request->headers;
        if ($headers->has('User-Agent')) {
           $columns['user_agent'] =  $headers->get('User-Agent');
        }
		$roleModel = new SystemLog();
		$roleModel->setAttributes($columns);
		return $roleModel->insert();
	}

	/**
	 * 清空所有日志
	 */
	public static function delAll() {
		return Yii::$app->db->createCommand()->truncateTable(SystemLog::tableName())->execute() !== false;
	}

}
