<?php

namespace admin\services;


use admin\models\Casino;

class CasinoService {
    /**
     * 添加赌场
     */

    public function addCasino($post)
    {
        $params = [
            'casino_name' => $post['casino_name'],
            'notes' => $post['notes'],
            'from' => $post['from'],
            'position' => $post['position'],
            'projects' => $post['projects'],
            'casino_picture' => $post['casino_picture'],
            'details' => $post['details'],
            'e_casino_name' => $post['e_casino_name'],
            'e_notes' => $post['e_notes'],
            'e_from' => $post['e_from'],
            'e_position' => $post['e_position'],
            'e_projects' => $post['e_projects'],
            'e_details' => $post['e_details'],
            'flag_picture' => $post['flag_picture'],
            'casino_bank' => $post['casino_bank'],
            'casino_bank_banch' => $post['casino_bank_banch'],
            'casino_bank_holder' => $post['casino_bank_holder'],
            'casino_bank_no' => $post['casino_bank_no'],
            'player' => $post['player'],
            'create_time' => time(),
        ];
//        var_dump($params);exit();
        $model = new Casino();
        $model->isNewRecord = true;
        $model->setAttributes($params);
        if (!$model->insert()) {
            return current($model->getFirstErrors());
        }
        return true;
    }
    /**
     * 查找赌场信息
     */
    public function findCasino($post) {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new Casino();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }
    /**
     * 删除
     */
    public static function delCasino($id) {
        $model = Casino::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }

}