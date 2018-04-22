<?php

namespace admin\services;

use admin\models\Contact;
class ContactService {

    /**
     * 添加汇率
     */

    public function addContact($post)
    {
        $params = [
            'address' => $post['address'],
            'email' => $post['email'],
            'tel' => $post['tel'],
            'fax' => $post['fax'],
            'explain' => $post['explain'],
            'protocol' => $post['protocol'],
            'create_time' => time(),
        ];
        $model = new Contact();
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
    public function findContact($post) {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new Contact();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }

}
