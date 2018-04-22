<?php

namespace console\controllers;

use common\services\SmsService;
use yii\console\Controller;

/**
 * 短信处理
 *
 * @author jindewen <jindewen@21cn.com>
 */
class SmsController extends Controller
{
    /**
     * 定时处理待发送短信
     */
    public function actionHandle()
    {
		$sms = new SmsService();
		echo date('Y-m-d H:i:s') . ' ';
		echo $sms->handleAsyncData() ? 'success' : 'error';
		echo PHP_EOL;
    }

}