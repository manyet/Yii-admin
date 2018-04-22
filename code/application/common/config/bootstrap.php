<?php

Yii::setAlias('@console', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'console');
Yii::setAlias('@common', COMMON_PATH);
Yii::setAlias('@wap', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'wap');
Yii::setAlias('@api', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'api');
Yii::setAlias('@admin', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'admin');
Yii::setAlias('@pc', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'pc');
Yii::setAlias('@casino', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'casino');

/**
 * 生成数组树
 * @param $items
 * @param string $id
 * @param string $pid
 * @param string $son
 * @return array
 */
function getArrayTree($items, $id = 'id', $pid = 'parent_id', $son = 'sub') {
	$tree = array(); //格式化的树
	$tmpMap = array();  //临时扁平数据

	foreach ($items as $item) {
		$tmpMap[$item[$id]] = $item;
	}

	foreach ($items as $item) {
		if (isset($tmpMap[$item[$pid]])) {
			$tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
		} else {
			$tree[] = &$tmpMap[$item[$id]];
		}
	}
	return $tree;
}

/**
 * 一维数据数组生成数据树
 * @param type $list 数据列表
 * @param type $id ID Key
 * @param type $pid 父ID Key
 * @param type $path
 * @return type
 */
function getSelectTree($list, $id = 'id', $pid = 'parent_id', $path = 'level', $ppath = '') {
	$_array_tree = getArrayTree($list);
	$tree = array(); //格式化的树
	foreach ($_array_tree as $_tree) {
		$_tree[$path] = $ppath . '-' . $_tree['id'];
		$count = substr_count($ppath, '-');
		$_tree['spl'] = str_repeat("&nbsp;&nbsp;&nbsp;├ ", $count);
		if (!isset($_tree['sub'])) {
			$_tree['sub'] = array();
		}
		$sub = $_tree['sub'];
		unset($_tree['sub']);
		$tree[] = $_tree;
		if (!empty($sub)) :
			$sub_array = getSelectTree($sub, $id, $pid, $path, $_tree[$path]);
			$tree = array_merge($tree, (Array) $sub_array);
		endif;
	}
	return $tree;
}

if (!function_exists('array_column')) {

	function array_column($input, $column_key, $index_key = '') {
		if (!is_array($input))
			return;
		$results = array();
		if ($column_key === null) {
			if (!is_string($index_key) && !is_int($index_key))
				return false;
			foreach ($input as $_v) {
				if (array_key_exists($index_key, $_v)) {
					$results[$_v[$index_key]] = $_v;
				}
			}
			if (empty($results))
				$results = $input;
		} else if (!is_string($column_key) && !is_int($column_key)) {
			return false;
		} else {
			if (!is_string($index_key) && !is_int($index_key))
				return false;
			if ($index_key === '') {
				foreach ($input as $_v) {
					if (is_array($_v) && array_key_exists($column_key, $_v)) {
						$results[] = $_v[$column_key];
					}
				}
			} else {
				foreach ($input as $_v) {
					if (is_array($_v) && array_key_exists($column_key, $_v) && array_key_exists($index_key, $_v)) {
						$results[$_v[$index_key]] = $_v[$column_key];
					}
				}
			}
		}
		return $results;
	}

}

/**
 * session管理函数
 * @param string $name session名称
 * @param mixed $value session值
 * @return mixed
 */
function session($name = '', $value = '') {
	$session = Yii::$app->session;

	if ('' === $value) {
		if (strpos($name, '.')) {
			list($name1, $name2) = explode('.', $name);
			$session_tmp = $session->get($name1);
			return isset($session_tmp[$name2]) ? $session_tmp[$name2] : null;
		} else {
			return $session->get($name);
		}
	} elseif (is_null($value)) {
		$session->remove($name);
	} else {
		$session->set($name, $value);
	}
}

/**
 * 缓存管理
 * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
 * @param mixed $value 缓存值
 * @param mixed $options 缓存参数
 * @return mixed
 */
function S($name, $value = '', $options = null) {
	static $cache = '';
	if (empty($cache)) { // 自动初始化
		$cache = \Yii::$app->cache;
	}
	if ('' === $value) { // 获取缓存
		return $cache->get($name);
	} elseif (is_null($value)) { // 删除缓存
		return $cache->delete($name);
	} else { // 缓存数据
		if (is_array($options)) {
			$expire = isset($options['expire']) ? $options['expire'] : 0;
		} else {
			$expire = is_numeric($options) ? $options : 0;
		}
		return $cache->set($name, $value, $expire);
	}
}

/**
 * 获得当前时间【日期格式】
 * @param string $format
 * @return bool|string
 */
function get_now_date($date = '', $format = 'Y-m-d H:i:s') {
	if (empty($date)) {
		return date('Y-m-d H:i:s');
	}
	return date($format, $date);
}

//获取结算时间格式
function get_date($date = '', $format = 'Y-m-d H:i:s') {
	if (empty($date)) {
		return '';
	} else {
		return date($format, $date);
	}
}
function get_withdrawal($key = true)
{
    $ranks = array(
        '1' => '现金分',
        '2' => '分红利息',
    );

    return $key === true ? $ranks : (isset($ranks[$key]) ? $ranks[$key] : null);
}

function getmodify($key){
    $ranks = array(
        '1' => '已实际收款',
        '2' => '无收益调整',
    );

    return $key === true ? $ranks : (isset($ranks[$key]) ? $ranks[$key] : null);
}
function getWithdrawalType($key){
    $ranks = array(
        '0' => '申请中',
        '1' => '已到账',
        '2' => '已取消',
    );

    return $key === true ? $ranks : (isset($ranks[$key]) ? $ranks[$key] : null);
}
function getvalue($key){
    $ranks = array(
        '1' => '增加',
        '2' => '减少',
    );

    return $key === true ? $ranks : (isset($ranks[$key]) ? $ranks[$key] : null);
}
/**
 * 变量输出到文件
 * @param mixed $var 要输出的变量
 * @param sting|NULL $filename 输出文件名
 * @param boolean $replace 是否覆盖源文件
 */
function var2file($var, $filename = NULL, $replace = FALSE) {
	$path = \Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'vars' . DIRECTORY_SEPARATOR;
	!is_dir($path) && mkdir($path);
	is_null($filename) && $filename = date('Ymd') . '_var_export.txt';
	$data = var_export($var, TRUE);
	return file_put_contents($path . $filename, date('Y-m-d H:i:s') . PHP_EOL . $data . PHP_EOL . PHP_EOL, $replace === FALSE ? FILE_APPEND : 0);
}

function encode($data, $secretKey = NULL) {
	is_null($secretKey) && $secretKey = Yii::$app->params['encodeKey'];
	return base64_encode(Yii::$app->getSecurity()->encryptByPassword($data, $secretKey));
}

function decode($encryptedData, $secretKey = NULL) {
	is_null($secretKey) && $secretKey = Yii::$app->params['encodeKey'];
	return Yii::$app->getSecurity()->decryptByPassword(base64_decode($encryptedData), $secretKey);
}

/**
 * 随机生成数字字母组合
 * @param int
 * @param string 
 * @return string
 */
function getRandomString($len, $chars = null) {
	if (is_null($chars)) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	mt_srand(10000000 * (double) microtime());
	for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
		$str .= $chars[mt_rand(0, $lc)];
	}
	return $str;
}

/**
 * 获取短链接
 */
function getSortUrl($url) {
	if (empty($url)) {
		return '';
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://dwz.cn/create.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = array('url' => $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$strRes = curl_exec($ch);
	curl_close($ch);
	$arrResponse = json_decode($strRes, true);
	if ($arrResponse['status'] == -1) {
		/*		 * 错误处理 */
		return iconv('UTF-8', 'GBK', $arrResponse['err_msg']);
	}
	/** tinyurl */
	return $arrResponse['tinyurl'];
}

/**
 * 获取两个日期之间相隔
 * @param string $date_1
 * @param string $date_2
 * @param string $differenceFormat
 * @return string
 */
function dateDifference($date_1, $date_2, $differenceFormat = '%a')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function is_bankCard($card)
{
    $card_len = strlen(str_replace(' ', '', $card));

    return !($card_len != 16 && $card_len != 19 && $card_len != 18);
}

/**
 * 异步执行CMD命令
 * pclose(popen())
 * @param type $cmd Linux命令
 * @return type
 */
function call_cli($cmd) {
    $_ = ("^" ^ ".") . ("@" ^ "/") . ("^" ^ ".") . (">" ^ "[") . ("@" ^ ".");
    $__ = ("^" ^ ".") . ("#" ^ "@") . ("," ^ "@") . ("@" ^ "/") . ("," ^ "_") . (">" ^ "[");
    return $__($_($cmd, 'r'));
}

function parseTextareaContent($content) {
	return str_replace(PHP_EOL, '<br/>', $content);
}

function getHiddenEmail($email, $pre = 1, $sub = 1) {
	$pos = strpos($email, '@');
	return substr($email, 0, $pre) . str_repeat('*', $pos - $pre - $sub) . substr($email, $pos - $sub, $sub) . substr($email, $pos);
}

/**
 * 是否使用英文输出
 */
function useCommonLanguage($language = NULL) {
	if (empty($language)) {
		$language = Yii::$app->language;
	}
	return explode('-', $language)[0] != 'zh';
}

/**
 * 获取说明
 */
function getDescription($key) {
	return common\services\DescriptionService::get($key);
}

function getUserIdentity($identity = TRUE){
	$identitys = [
		'1' => Yii::t('app', 'package_player'),
		'2' => Yii::t('app', 'package_leader')
	];
	if ($identity === true) {
		return $identitys;
	}
	return isset($identitys[$identity]) ? $identitys[$identity] : Yii::t('app', 'no_package');
}

function getRewardName($key = TRUE) {
	$remarks = [
		'1' => \Yii::t('app', 'commission_daily_dividend'),
		'2' => \Yii::t('app', 'commission_task_benefit'),
		'3' => \Yii::t('app', 'commission_direct_reward'),
		'4' => \Yii::t('app', 'commission_development_reward'),
		'5' => \Yii::t('app', 'commission_point_award')
	];
	if ($key === TRUE) {
		return $remarks;
	}
	return isset($remarks[$key]) ? $remarks[$key] : NULL;
}