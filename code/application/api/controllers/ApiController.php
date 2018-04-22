<?php

namespace api\controllers;

use yii\web\Controller;

/**
 * API接口公共类
 */
class ApiController extends Controller {

	/**
	 * 是否验证接口请求规则
	 * @var boolean
	 */
	public $validate_on = true;

	/**
	 * 请求数据
	 * @var array
	 */
	public $data = array();

	/**
	 * 编码格式
	 * @var string
	 */
	public $charset = 'UTF-8';

	/**
	 * 默认的数据返回格式
	 * @var string
	 */
	public $default_format = 'json';

	/**
	 * 系统通信KEY
	 */
	const KEY = 'K064FE48K064FE48818FBbE0818FBbE0';

	/**
	 * 错误代码KEY
	 */
	const ERROR_CODE_KEY = 'code';

	/**
	 * 错误消息KEY
	 */
	const ERROR_MESSAGE_KEY = 'msg';

	/**
	 * 系统错误列表
	 */
	protected $systemErrors = array(
		10001 => '系统错误',
		10002 => 'HTTP错误',
		10005 => 'TOKEN错误',
		10006 => '不支持该请求类型'
	);

	/**
	 * 是否记录接口请求
	 * @var boolean
	 */
	public $log_on = true;

	/**
	 * 接口日志记录表
	 * @var string
	 */
	public $log_table = '{{%api_log}}';

	/**
	 * 接口请求开始时间
	 * @var int
	 */
	protected $_start_time;

	/**
	 * 接口请求结束时间
	 * @var int
	 */
	protected $_end_time;

	/**
	 * 接口验证TOKEN
	 * @var string
	 */
	protected $_request_token = '';

	/**
	 * 接口初始化
	 */
	public function init() {
		$this->enableCsrfValidation = false;
		parent::init();

		// 记录请求日志
		if ($this->log_on) {
			ob_start();
			// 记录开始请求时间
			$this->_start_time = $_SERVER['REQUEST_TIME'];
		}

		$request = \Yii::$app->request;
		if ($request->isGet) {
			$this->data = $request->get();
		} else if ($request->isPost) {
			$this->data = $request->post();
		} else if ($request->isPut) {
			$this->data = $request->put();
		} else if ($request->isDelete) {
			$this->data = $request->delete();
		} else {
			$this->systemError(10006); // 请求类型不支持
		}

		if (isset($this->data['token'])) {
			$this->_request_token = $this->data['token'];
			unset($this->data['token']);
		}

		// 验证接口规则
		if ($this->validate_on) {
			$this->validate();
		}
	}

	/**
	 * 验证接口请求规则
	 */
	public function validate() {
		if (empty($this->_request_token) || !isset($this->data['timestamp']) || !$this->checkToken()) {
			$this->systemError(10005); // Token错误
		}
	}

	/**
	 * 效验TOKEN是否错误
	 * @param string $token
	 * @param string|int $timestamp
	 * @return boolean
	 */
	public function checkToken() {
		if (time() - intval($this->data['timestamp']) > 1800) { // TOKEN有效期30分钟
			return false;
		}

		// 重排数据
		ksort($this->data);

		return $this->_request_token === md5(http_build_query($this->data) . '&key=' . \Yii::$app->params['apiKey']);
	}

	/**
	 * 获取请求数据
	 * @param string $key
	 * @param mixed $default 默认值
	 * @param mixed 返回值
	 */
	public function getRequestData($key = NULL, $default = NULL) {
		if (is_null($key)) {
			return empty($this->data) ? $default : $this->data;
		}
		return isset($this->data[$key]) ? $this->data[$key] : $default;
	}

	/**
	 * 输出成功提示
	 * @param string $msg 消息提示
	 */
	protected function success($msg = '', $data = array(), $format = NULL) {
		$ret = [self::ERROR_CODE_KEY => 0];
		$msg != '' && $ret[self::ERROR_MESSAGE_KEY] = $msg;
		$this->response(array_merge($ret, $data), $format);
	}

	/**
	 * 输出错误提示
	 * @param int $code 错误码
	 * @param string $msg 消息提示
	 */
	protected function error($code, $msg = '', $data = array(), $format = NULL) {
		$ret = [self::ERROR_CODE_KEY => $code];
		$msg != '' && $ret[self::ERROR_MESSAGE_KEY] = $msg;
		$this->response(array_merge($ret, $data), $format, FALSE);
	}

	/**
	 * 输出系统错误
	 */
	public function systemError($code) {
		$this->error($code, $this->systemErrors[$code]);
	}

	/**
	 * 输出消息
	 * @param array $data
	 * @param boolean $continue
	 */
	public function response($data, $format = NULL, $continue = TRUE) {
		is_null($format) && $format = $this->default_format;
		switch ($format) {
			case 'xml':
				header('Content-Type:text/xml;charset=' . $this->charset);
				$this->xmlRerutn($data);
				break;
			default : // 默认为JSON
				header('Content-Type:application/json;charset=' . $this->charset);
				echo (json_encode($data));
		}
		!$continue && exit();
	}

	public function xmlRerutn($data, $charset = NULL) {
		is_null($charset) && $charset = $this->charset;
		//创建新的xml文件  
		$dom = new DOMDocument('1.0', $charset);

		//建立<response>元素  
		$response = $dom->createElement('response');
		$dom->appendChild($response);

		//建立<books>元素并将其作为<response>的子元素  
		$books = $dom->createElement('books');
		$response->appendChild($books);

		//为book创建标题  
		$title = $dom->createElement('title');
		$titleText = $dom->createTextNode('PHP与AJAX');
		$title->appendChild($titleText);

		//为book创建isbn元素  
		$isbn = $dom->createElement('isbn');
		$isbnText = $dom->createTextNode('1-21258986');
		$isbn->appendChild($isbnText);

		//创建book元素  
		$book = $dom->createElement('book');
		$book->appendChild($title);
		$book->appendChild($isbn);

		//将<book>作为<books>子元素  
		$books->appendChild($book);

		//在一字符串变量中建立XML结构，并输出
		echo $dom->saveXML();
	}

	/**
	 * 记录接口请求信息
	 */
	public function log() {
		$data = array(
			'request_url' => \Yii::$app->request->url,
			'start_time' => $this->_start_time,
			'end_time' => $this->_end_time,
			'data' => json_encode($this->data),
			'output' => ob_get_contents(),
			'client_ip' => $_SERVER['REMOTE_ADDR'],
			'token' => $this->_request_token
		);
		// 写入数据库
		return \Yii::$app->db->createCommand()->insert($this->log_table, $data)->execute();
	}

	/**
	 * 接口请求完毕，记录请求参数
	 */
	public function __destruct() {
		// 记录接口请求信息
		if ($this->log_on) {
			// 记录请求结束时间
			$this->_end_time = time();
			// 写入接口请求日志
			$this->log();
		}
	}

}
