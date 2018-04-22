<?php

namespace common\services;

use common\models\ExchangeRecord;

/**
 * 兑换业务类
 */
class ExchangeService {

	/**
	 * 获取兑换记录
	 * @param string|array $fields
	 * @param string|array $where
	 * @param int $page
	 * @param int $rows
	 * @return mixed
	 */
	public static function getRecord($fields = '*', $where = NULL, $page = 1, $rows = 10) {
		$model = ExchangeRecord::find();
		!empty($where) && $model->andWhere($where);
		$total = $model->count();
		$offset = ($page - 1) * $rows;
		$model->offset($offset)->limit($rows)->orderBy('id DESC');
		return ['list' => $model->select($fields)->asArray()->all(), 'total' => $total];
	}

	public static function addLog($data, $language) {
		$data['number'] = self::createOrderNumber($language);
		$model = new ExchangeRecord();
		$model->setAttributes($data);
		if ($model->insert()) {
			return \Yii::$app->db->lastInsertID;
		}
		return false;
	}

	public static function createOrderNumber($language) {
		$code = (useCommonLanguage($language) ? 'EN' : 'CN') . date('Ymd') . strtoupper(getRandomString(4));
		$isExists = ExchangeRecord::find()->where("number = '$code'")->count() > 0;
		if ($isExists) {
			return self::createOrderNumber();
		}
		return $code;
	}

}
