<?php

namespace admin\services;

use admin\models\DataRules;
class DataRulesService {

    /**
     * 添加汇率
     */

    public function addDataRules($post)
    {
        $params = [
            'play_num' => $post['play_num'],'play_day' => $post['play_day'],
            'play_week' => $post['play_week'],'betting_num' => $post['betting_num'],
            'betting_day' => $post['betting_day'],'betting_week' => $post['betting_week'],
            'st_name' => $post['st_name'],'st_money' => $post['st_money'],
            'nd_name' => $post['nd_name'],'nd_money' => $post['nd_money'],
            'rd_name' => $post['rd_name'],'rd_money' => $post['rd_money'],
            'td_name' => $post['td_name'],'td_money' => $post['td_money'],
            'th_name' => $post['th_name'],'th_money' => $post['th_money'],
            'create_time' => time(),

        ];
        $model = new DataRules();
        $model->isNewRecord = true;
        $model->setAttributes($params);
        if (!$model->insert()) {
            return current($model->getFirstErrors());
        }
        return true;
    }
    /**
     * 查找功能
     */
    public function findDataRules() {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => 1];
        $Model = new DataRules();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }


}
