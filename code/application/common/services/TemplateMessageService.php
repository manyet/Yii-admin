<?php

namespace common\services;

use common\models\User;
use knight\models\Knight;
use common\models\Shop;
use common\models\MessageTemplate;
use common\models\NoticeIndividual;
use common\models\NoticeCompany;

/**
 * 模板消息
 */
class TemplateMessageService {

	public static $errMsg = '操作成功';

	/**
	 * 发送消息给用户
	 */
	public static function sendToClient($client_id, $tpl_id, $params = []) {
		return self::sendTemplateMessage($client_id, 1, $tpl_id, $params);
	}

	/**
	 * 发送消息给骑士
	 */
	public static function sendToRyder($ryder_id, $tpl_id, $params = []) {
		return self::sendTemplateMessage($ryder_id, 2, $tpl_id, $params);
	}

	/**
	 * 发送消息给商家
	 */
	public static function sendToStore($store_id, $tpl_id, $params = []) {
		return self::sendTemplateMessage($store_id, 3, $tpl_id, $params);
	}

	/**
	 * 发送消息给总部
	 */
	public static function sendToCompany($tpl_id, $params = []) {
		return self::sendTemplateMessage(NULL, 4, $tpl_id, $params);
	}

	/**
	 * 发送模板消息
	 * @param int $user_id
	 * @param int $type 发送对象 1：用户，2：骑士，3：商家，4：总部
	 * @param string $tpl_id
	 * @param array $params
	 */
	public static function sendTemplateMessage($user_id, $type, $tpl_id, $params = []) {
		$template = self::getTemplateInfo($tpl_id);
		if (!$template) { // 模板不存在
			return false;
		}
		if (is_array($user_id)) {
			$mobile = $user_id['mobile'];
			$user_id = $user_id['user_id'];
		}
		// 是否发送消息
		if (intval($template['is_send_message']) === 1) {
			$content = self::parseContent($template['message_content'], $params);
			if (!$content) {
				self::$errMsg = '消息模板内容为空';
				return false;
			}
			if ($type <= 3) {
				$model = new NoticeIndividual();
				// 发送消息
				$model->setAttributes([
							'individual_id' => $user_id,
							'title' => $template['title'],
							'content' => $content,
							'type' => $type,
							'create_time' => time()
						]);
				$result = $model->insert();
			} else { // 总部提醒
				$model = new NoticeCompany();
				// 发送消息
				$model->setAttributes([
							'individual_id' => $user_id,
							'title' => $template['title'],
							'content' => $content,
							'type' => $type,
							'create_time' => time()
						]);
				$result = $model->insert();
			}
			if (!$result) {
				self::$errMsg = '发送消息失败';
				return false;
			}
		}
		// 是否发送短信
		if ($type <= 3 && intval($template['is_send_mobile']) === 1) {
			$content = self::parseContent($template['mobile_content'], $params);
			if (!$content) {
				self::$errMsg = '短信模板内容为空';
				return false;
			}
			if (empty($mobile)) {
				if ($type === 1) { // 用户
					$mobile = User::find()->select('phone')->where("appUserId = '$user_id'")->scalar();
				} else if ($type === 2) { // 骑士
					$mobile = Knight::find()->select('knight_phone')->where("id = '$user_id'")->scalar();
				} else if ($type === 3) { // 商家
					$mobile = Shop::find()->select('phone')->where("tmerchantId = '$user_id'")->scalar();
				} else {
					self::$errMsg = '不支持的发送类别';
					return false;
				}
			}
			if (empty($mobile)) {
				self::$errMsg = '手机号为空';
				return false;
			}
			$smsService = new SmsService();
			$sendResult = $smsService->sendAsync($mobile, $content);
			if (!$sendResult) {
				self::$errMsg = $smsService->errMsg;
				return false;
			}
		}
		return true;
	}

	public static function getTemplateInfo($tpl_id, $fields = '*') {
		return MessageTemplate::find()->select($fields)->where(['key' => $tpl_id])->asArray()->one();
	}

	public static function parseContent($content, $params = []) {
		if (empty($content)) {
			return false;
		}
		global $send_array;
		$send_array = $params;
		$temp = preg_replace_callback('/\{\{(\w+)\}\}/i', function ($m) {
			global $send_array;
			return isset($send_array[$m[1]]) ? $send_array[$m[1]] : '';
		}, $content);
		return $temp;
	}

	public static function getMobileContent($tpl_id, $params = []) {
		$content = MessageTemplate::find()->select('mobile_content')->where(['key' => $tpl_id])->scalar();
		return self::parseContent($content, $params);
	}

	public static function getMessageContent($tpl_id, $params = []) {
		$content = MessageTemplate::find()->select('message_content')->where(['key' => $tpl_id])->scalar();
		return self::parseContent($content, $params);
	}

}
