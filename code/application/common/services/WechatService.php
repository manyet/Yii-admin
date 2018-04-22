<?php

namespace common\services;

class WechatService {

	public static function getReplyType($key = true) {
		$types = [
			'text' => '文本',
			'news' => '图文',
//			'news' => '图片',
//			'news' => '语音',
//			'news' => '音乐',
//			'news' => '视频'
		];
		if ($key === true) {
			return $types;
		}
		return isset($types[$key]) ? $types[$key] : null;
	}

}
