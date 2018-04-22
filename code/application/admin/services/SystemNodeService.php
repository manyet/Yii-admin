<?php

namespace admin\services;

/**
 * 系统节点
 */
class SystemNodeService {

	/**
	 * 控制器后缀
	 * @var string
	 */
	public $controller_suffix = 'Controller.php';

	/**
	 * 控制器文件夹
	 * @var string
	 */
	public $controller_dir = 'controllers';

	/**
	 * URL分割符
	 * @var string
	 */
	public $url_separator = '/';

	/**
	 * 驼峰命名转换分隔符
	 * @var string
	 */
	public $camel_separator = '-';

	/**
	 * 不做权限控制的模块
	 * @var array
	 */
	public $exception_dir = array(
		'common',
		'console',
		'tests'
	);

	/**
	 * 模块路径
	 * @var string
	 */
	public $module_path = '';

	public function __construct() {
		$this->module_path = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
	}

	public function refresh($type = 1) {
		$data = $this->getNodes(\Yii::$app->controller->module->id, $type);
		if ($type === 1) {
			$filename = 'auth-nodes.php';
		} else {
			$filename = 'menu-nodes.php';
		}
		return file_put_contents(\Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . $filename,  '<?php return ' . var_export($data, true) . '; ?>') !== 0;
//		foreach ($this->getNodes('admin') as $row) {
//			$data[] = [$row['title'], $row['path'], $row['is_menu']];
//		}
//		return (new \common\models\Node())->updateNodes($data);
	}

	public function getAccesses() {
		$file = \Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'auth-nodes.php';
		if (!file_exists($file)) {
			$this->refresh();
		}
		return require $file;
//		$model = new \common\models\Node();
//		return $this->parse($model->getAccessNodes());
	}

	public function getMenus() {
		$file = \Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'menu-nodes.php';
		if (!file_exists($file)) {
			$this->refresh(2);
		}
		return require $file;
//		$model = new \common\models\Node();
//		return $this->parse($model->getMenuNodes());
	}

	/**
	 * 获取模块下的权限列表
	 * @param string $module
	 * @return array
	 */
	private function getNodes($module = NULL, $type = 1, $base_path = '') {
		if (is_null($module)) {
			$module = \Yii::$app->controller->module->id;
		}
		$namespace = "\\{$module}\\{$this->controller_dir}\\" . str_replace('/', '\\', $base_path);
//		$path = \Yii::getAlias('@' . $module) . DIRECTORY_SEPARATOR . $this->controller_dir;
		$path = $this->module_path . $module . DIRECTORY_SEPARATOR . $this->controller_dir . DIRECTORY_SEPARATOR . $base_path;

		// 获取权限列表
		$list = array();
		foreach (scandir($path) as $file) {
			// 忽略系统文件夹
			if ($file === '.' || $file === '..') {
				continue;
			}
			// 处理多级目录的控制器
			if (is_dir($path . $file)) {
				$sub_controllers = $this->getNodes($module, $type, $base_path . $file . DIRECTORY_SEPARATOR);
				if (!empty($sub_controllers)) {
					$list = array_merge($list, $sub_controllers);
				} else {
					continue;
				}
			}
			// 忽略其他文件
			if (strpos($file, $this->controller_suffix) === false) {
				continue;
			}

			$class_name = str_replace('.php', '', $file);
			$class_file = $namespace . $class_name;
			$vars = get_class_vars($class_file);

			// 菜单 或者 权限
			$key = $type === 1 ? 'access' : 'menu';

			if (isset($vars[$key])) { // 处理权限方法
				$module_name = $this->getControllerId($file, $base_path);
				$methods = get_class_methods($class_file);
				$list[$module_name]['title'] = $vars['controller_title'];
				foreach ($vars[$key] as $action_id => $title) {
					if (in_array($this->getActionName($action_id), $methods)) {
						$list[$module_name]['children'][] = array(
							'title' => $title,
							'path' => $module_name . $this->url_separator . $action_id,
//							'is_menu' => intval(isset($menu[$action_id]))
						);
					}
				}
			}
			unset($vars);
		}
		return $list;
	}

	/**
	 * 通过文件名获取控制器名称
	 * @param string $filename
	 * @return string
	 */
	public function getControllerId($filename, $path = '') {
		return str_replace('\\', '/', $path) . \yii\helpers\Inflector::camel2id(str_replace($this->controller_suffix, '', $filename), $this->camel_separator);
	}

	/**
	 * 通过操作ID获取操作名称
	 * @param string $action_id
	 * @return string
	 */
	public function getActionName($action_id) {
		return 'action' . \yii\helpers\Inflector::id2camel($action_id, $this->camel_separator);
	}

	/**
	 * 获取路径下的全部模块
	 * @param string $path
	 * @return array|NULL
	 */
	private function getModules($path) {
		if (!is_dir($path)) {
			return NULL;
		}
		$data = array();
		foreach (scandir($path) as $file) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			$file_path = $path . DIRECTORY_SEPARATOR . $file;
			if (is_dir($file_path)) {
				$data[$file] = $this->getModules($file_path);
				continue;
			}
			if (strpos($file, '.php') !== false) {
				$data[$path][] = $this->getControllerId($file);
			}
		}
		return $data;
	}

	/**
	 * 转换节点
	 */
	private function parse($nodes) {
		$list = array();
		foreach ($nodes as $one) {
			$separator_pos = strrpos($one['path'], $this->url_separator);
			$controller = substr($one['path'], 0, $separator_pos);
			$action = substr($one['path'], $separator_pos + 1);
			$list[$controller]['children'][$action] = [
				'title' => $one['title'],
				'path' => $one['path']
			];
		}
		// 顶级元素名称
//		foreach ($list as $controller => &$row) {
//			$row['title'] = $parent_nodes[$controller];
//		}
		return $list;
	}

}
