<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * 系统公共控制器
 */
class BaseController extends Controller {

	/**
	 * 返回响应
	 * @param $data
	 * @param string $format
	 * @return mixed
	 */
	public function ajaxReturn($data, $format = 'json') {
		switch (strtolower($format)) {
			case 'raw':
				Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
				break;
			case 'json':
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				break;
			case 'html':
				Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
				break;
			case 'jsonp':
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSONP;
				break;
			case 'xml':
				Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
				break;
		}
		Yii::$app->response->data = $data;
		//send()方法调用后，不能追加其他功能
		Yii::$app->response->send();
		exit;
	}

	protected function warning($message = '', $jumpUrl = '', $ajax = false) {
		$this->dispatchJump($message, -1, $jumpUrl, $ajax);
	}

	/**
	 * 操作错误跳转的快捷方法
	 * @access protected
	 * @param string $message 错误信息
	 * @param string $jumpUrl 页面跳转地址
	 * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
	 * @return void
	 */
	protected function error($message = '', $jumpUrl = '', $ajax = false) {
		$this->dispatchJump($message, 0, $jumpUrl, $ajax);
	}

	/**
	 * 操作成功跳转的快捷方法
	 * @access protected
	 * @param string $message 提示信息
	 * @param string $jumpUrl 页面跳转地址
	 * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
	 * @return void
	 */
	protected function success($message = '', $jumpUrl = '', $ajax = false) {
		$this->dispatchJump($message, 1, $jumpUrl, $ajax);
	}

	/**
	 * 默认跳转操作 支持错误导向和正确跳转
	 * 调用模板显示 默认为public目录下面的success页面
	 * 提示页面为可配置 支持模板标签
	 * @param string $message 提示信息
	 * @param Boolean $status 状态
	 * @param string $jumpUrl 页面跳转地址
	 * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
	 * @access private
	 * @return void
	 */
	private function dispatchJump($message, $status = 1, $jumpUrl = '', $ajax = false) {
		if (true === $ajax || \Yii::$app->request->isAjax) {// AJAX提交
			$data = is_array($ajax) ? $ajax : array();
			$data['info'] = $message;
			$data['status'] = $status;
			$data['url'] = $jumpUrl;
			$this->ajaxReturn($data);
		}
		$render_data = array();
		if (is_int($ajax))
			$render_data['waitSecond'] = $ajax;
		if (!empty($jumpUrl))
			$render_data['jumpUrl'] = $jumpUrl;
		// 提示标题
		$render_data['msgTitle'] = $status ? Yii::t('app', '操作成功') : Yii::t('app', '发生错误');
		//如果设置了关闭窗口，则提示完毕后自动关闭窗口
//        if($this->get('closeWin'))    $render_data['jumpUrl'] = 'javascript:window.close();';
		$render_data['status'] = $status;   // 状态
		//保证输出不受静态缓存影响
//        C('HTML_CACHE_ON',false);
		if ($status) { //发送成功信息
			$render_data['message'] = $message; // 提示信息
			// 成功操作后默认停留1秒
			if (!isset($render_data['waitSecond']))
				$render_data['waitSecond'] = '1';
			// 默认操作成功自动返回操作前页面
			if (!isset($render_data['jumpUrl']))
				$render_data['jumpUrl'] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : \Yii::$app->homeUrl;
			echo $this->render('/common/success', $render_data);
			exit;
		}else {
			$render_data['message'] = $message; // 提示信息
			//发生错误时候默认停留3秒
			if (!isset($render_data['waitSecond']))
				$render_data['waitSecond'] = '3';
			// 默认发生错误的话自动返回上页
			if (!isset($render_data['jumpUrl']))
				$render_data['jumpUrl'] = 'javascript:history.back();';
			echo $this->render('/common/error', $render_data);
			// 中止执行  避免出错后继续执行
			exit;
		}
	}

}
