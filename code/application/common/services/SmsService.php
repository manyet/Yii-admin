<?php

namespace common\services;

use common\models\SmsAsync;
use common\models\SmsRecord;

class SmsService {

	private $email = 'oscaryJH@gmail.com';
	private $password = '9118';
	public $errMsg = '';
	public $retry_times = 10;

	/**
	 * 发送实时短信通知
	 * @param string $recipient 60180000000; 60180000000
	 * @param string $content
	 */
	public function send($recipient, $content) {
		$URL = "https://www.sms123.net/xmlgateway.php";

		$xml = "<root>";

		$xml .= "<command>sendPrivateSMS</command>";
		$xml .= "<sendType>shortCode</sendType>";

		$xml .= "<email>{$this->email}</email>";
		$xml .= "<password>{$this->password}</password>";
		$xml .= "<params>";
		$xml .= "<items>";

		$xml .= "<recipient>{$recipient}</recipient>";
		$xml .= "<textMessage>";

		$xml .= htmlspecialchars($content);
		$xml .= "</textMessage>";
		$xml .= "</items>";
		$xml .= "</params>";
		$xml .= "</root>";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		if (!$response || $info['http_code'] !== 200) {
			$this->errMsg = 'Sms request error';
			return false;
		}

		$result = $this->xmlToArray($response);
		$log_result = $this->addLog($recipient, $content, $result['status'], json_encode($result));
		if (!$log_result) {
			$this->errMsg = 'Sms log error';
			return false;
		}

		if (intval($result['status']) !== 1) {
			$this->errMsg = $result['msg'];
			return false;
		}
		return true;
	}

	/**
	 * 发送异步短信通知
	 * @param string $recipient 60180000000; 60180000000
	 * @param string $content
	 */
	public function sendAsync($recipient, $content) {
		$recipient = preg_replace('/^\+/', '', $recipient);
		if (preg_match('/^6?011?\d{8}$/', $recipient)) {
			$model = new SmsAsync();
			$model->setAttributes([
				'recipient' => $recipient,
				'content' => $content,
				'status' => 0,
				'create_time' => time()
			]);
			return $model->insert();
		}
		return true;
	}

	public function handleAsyncData() {
		$result = true;
		$asyncData = SmsAsync::find()->select('id,recipient,content')->where('status = 0 AND times < ' . $this->retry_times)->asArray()->all();
		foreach ($asyncData as $one) {
			$sendResult = $this->send($one['recipient'], $one['content']);
			$data = ['update_time' => time()];
			if ($sendResult) {
				$data['status'] = 1;
			}
			// 更新数据状态
			$model = SmsAsync::findOne($one['id']);
			$model->setAttributes($data);
			$model->times = $model->times + 1;
			if ($model->update() === false) {
				$result = false;
			}
		}
		return $result;
	}

	public function addLog($recipient, $content, $status, $result) {
		$model = new SmsRecord();
		$model->setAttributes([
			'recipient' => $recipient,
			'content' => $content,
			'status' => $status,
			'result' => $result,
			'create_time' => time()
		]);
		return $model->insert();
	}

	public function xmlToArray($xml) {
		//禁止引用外部xml实体 
		libxml_disable_entity_loader(true);

		$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

		$val = json_decode(json_encode($xmlstring), true);

		return $val;
	}

}
