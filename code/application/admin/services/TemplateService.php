<?php
/**
 * Created by BBM
 * DateTime: 2016-12-12 15:47
 */

namespace admin\services;

use admin\models\MessageTemplate;

class TemplateService
{
    /**
     * 根据id获得模板信息
     * @param $id
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public function getInfo($id)
    {
        if(empty($id) || !is_numeric($id))
        {
            return false;
        }
        return MessageTemplate::find()->where(['id' => $id])->asArray()->one();
    }

    /**
     * @param $params
     * @return bool
     */
    public function addTemplate($params)
    {
        $model = new MessageTemplate();
		$model->setAttributes($params);
        return $model->save();
    }

    /**
     * @param array $condition
     * @param array $params
     * @return bool
     */
    public function updateTemplate($condition, $params)
    {
        $model = MessageTemplate::findOne($condition['id']);
		$model->setAttributes($params);
        return $model->save();
    }

	/**
	 * 获取模板列表
	 * @return boolean
	 */
    public function getList($fields = '*')
    {
        return MessageTemplate::find()->select($fields)->asArray()->all();
    }

}