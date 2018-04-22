<?php

namespace admin\services;

use admin\models\Faq;
use admin\models\FaqType;

class FaqService {
    public $errorMsg;
    public function addFaq($post){
        $columns = [
            'sort' => $post['sort'],
            'type_id' => $post['type_id'],
            'question' => $post['question'],
            'equestion' => $post['equestion'],
            'answer' => $post['answer'],
            'eanswer' => $post['eanswer'],
            'create_time' => time(),
        ];
        $model = new Faq();
        $model->isNewRecord = true;
        $model->setAttributes($columns);
        if (false === $model->validate()) {
            $this->errorMsg = $model->getFirstError($post);

            return $this->errorMsg;
        }
        return $model->insert();
    }
    /**
     * 根据id获得类型
     */
    public function FindFaqType() {
        $fields = "*";
        $Model = new FaqType();
        return $Model->find()->select($fields)->asArray()->all();
    }

    /**
     * 根据id获得FAQ
     */
    public function getFaq($params=[]) {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = [':id' => $params['id']];

        $Model = new Faq();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }


}
