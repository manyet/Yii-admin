<?php

namespace admin\services;

use admin\models\SystemMenu;

class SystemMenuService {

	const CACHE_KEY = 'menu';

	public static $sort = '`sort`,id';

	/**
	 * 获得所有菜单
	 */
	public static function getMenuList($fields = '*') {
		return SystemMenu::find()->select($fields)->orderBy(self::$sort)->asArray()->all();
	}

	/**
	 * 获得顶级菜单
	 */
	public static function getTopMenu() {
		$fields = "id,name,parent_id,icon";
		$conditions = 'parent_id = :parent_id';
		$bind_params = [':parent_id' => 0];
		return SystemMenu::find()->select($fields)->where($conditions, $bind_params)->orderBy(self::$sort)->asArray()->all();
	}

	/**
	 * 根据id获得用户信息
	 */
	public static function getMenuById($id, $fields = '*') {
		$conditions = 'id = :id';
		$bind_params = [':id' => $id];
		return SystemMenu::find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
	}

	/**
	 * 菜单批量排序
	 * @param type $sort_data
	 */
	public static function sortMenu($sort_data) {
		$table_name = SystemMenu::tableName();
		foreach ($sort_data as $id => $sort) {
			if (\Yii::$app->db->createCommand()
					->update($table_name, ['sort' => $sort], 'id = :id', ['id' => $id])
					->execute() === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * 更新菜单信息
	 */
	public static function updateMenuInfo($id, $post) {
		$columns = [
			'parent_id' => $post['parent_id'],
			'name' => $post['name'],
			'url' => $post['url'],
			'params' => $post['params'],
			'sort' => $post['sort'],
			'status' => $post['status'],
			'icon' => $post['icon'],
            'update_by' => getUserId(),
            'update_time' => time()
		];
		$menuModel = new SystemMenu();
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 删除菜单
	 */
	public static function delMenu($id) {
		$model = SystemMenu::findOne($id);
		if (empty($model)) {
			return false;
		}
		return $model->delete();
	}

	/**
	 * 添加菜单
	 */
	public static function addMenu($post) {
		$columns = [
			'parent_id' => $post['parent_id'],
			'name' => $post['name'],
			'url' => $post['url'],
			'params' => $post['params'],
			'sort' => $post['sort'],
			'status' => $post['status'],
			'icon' => $post['icon'],
            'create_by' => getUserId(),
            'create_time' => time()
		];
		$menuModel = new SystemMenu();
		$menuModel->setAttributes($columns);
		return $menuModel->insert();
	}

	/**
	 * 重置子菜单
	 * 当顶级菜单被删除，其子菜单被重置为顶级菜单
	 * @param $parent_id
	 * @return int
	 */
	public function resetSubMenu($parent_id) {
		$columns = [
			'parent_id' => 0
		];
		$conditions = "parent_id = :parent_id";
		$bind_params = [
			':parent_id' => $parent_id
		];
		$menuModel = new SystemMenu();
		return $menuModel->updateAll($columns, $conditions, $bind_params) !== false;
	}

	/**
	 * 启用菜单
	 * @param int $id 菜单ID
	 */
	public static function resume($id) {
		$columns = [
			'status' => 1
		];
		$menuModel = new SystemMenu();
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	/**
	 * 禁用菜单，其子菜单全部被禁用
	 * @param int $id 菜单ID
	 */
	public static function forbid($id) {
		$conditions = "parent_id = :parent_id";
		$bind_params = [
			':parent_id' => $id
		];
		$menuModel = new SystemMenu();
		$sub_menus = $menuModel->find()->select('id')->where($conditions, $bind_params)->asArray()->all();
		foreach ($sub_menus as $one) {
			if (!self::forbid($one['id'])) {
				return false;
			}
		}
		$columns = [
			'status' => 0
		];
		$one = $menuModel->findOne($id);
		$one->setAttributes($columns);
		return $one->update() !== false;
	}

	public static function refresh() {
		return S(self::CACHE_KEY, NULL);
	}

	public static function getMenus() {
		$data = S(self::CACHE_KEY); // 从缓存读取菜单HTML
		if (empty($data)) { // 从数据库读取菜单
			$list = SystemMenu::find()->select('id,parent_id,name,icon,url,params')
					->where('`status` = 1')->orderBy(self::$sort)->asArray()->all();
			$data = getArrayTree($list, 'id', 'parent_id', 'children');
			S(self::CACHE_KEY, $data); // 缓存菜单HTML
		}
		return self::filterMenu($data);
	}

	public static function filterMenu($menus){
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['children'])) {
                $menu['children'] = self::filterMenu($menu['children']);
            }
            if (!empty($menu['children'])) {
                $menu['url'] = '#';
            } elseif (stripos($menu['url'], 'http') === 0) {
                continue;
            } elseif ($menu['url'] !== '#' && checkAuth($menu['url'])) {
                $menu['url'] = self::toUrl($menu['url'], $menu['params']);
            } else {
                unset($menus[$key]);
            }
        }
        return $menus;
	}

	public static function toUrl($route, $param = '') {
		$url = \yii\helpers\Url::toRoute($route);
		$param != '' && $url .= (strpos($url, '?') !== false ? '&' : '?') . $param;
		return $url;
	}

}
