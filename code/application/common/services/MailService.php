<?php

namespace common\services;

use Yii;
use common\models\MailTemplate;
use admin\services\SystemConfigService;

class MailService {

	public function __construct() {
		$this->config = SystemConfigService::get();
		Yii::$app->set('mailer', [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => $this->config['MAIL_SMTP'], //每种邮箱的host配置不一样
				'username' => $this->config['MAIL_USERNAME'],
				'password' => $this->config['MAIL_PASSWORD'],
				'port' => $this->config['MAIL_PORT'],
				'encryption' => 'ssl'
			]
		]);
	}

	public function send($email, $title, $content) {
		$mail = Yii::$app->mailer->compose();
		$mail->setTo($email);
		$mail->setSubject($title);
		$mail->setFrom([$this->config['MAIL_FROM'] => $this->config['MAIL_FROM_NAME']]);
		$mail->setReplyTo([$this->config['MAIL_REPLY'] => $this->config['MAIL_FROM_NAME']]);
		//$mail->setTextBody('zheshisha ');   //发布纯文字文本
		$mail->setHtmlBody($content); //发布可以带html标签的文本
		return $mail->send();
	}

	public function getTemplate($key, $params = []) {
		$useCommonLanguage = useCommonLanguage();
		$title_key = $useCommonLanguage ? 'eng_title' : 'title';
		$content_key = $useCommonLanguage ? 'eng_content' : 'content';
		$template = MailTemplate::find()->select("$title_key,$content_key")->where(['key' => $key])->asArray()->one();
		return [
			'title' => $this->parseContent($template[$title_key], $params),
			'content' => $this->parseContent($template[$content_key], $params)
		];
	}

	public function parseContent($content, $params = []) {
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

}
