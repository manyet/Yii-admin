<?php

namespace wap\services;


use wap\models\Faq;
use wap\models\FaqType;

class FaqService {

    public $errorMsg;

    public function getFaqListByKeyword($key)
    {
        $fields = "*";
        $Model = new Faq();
        return $Model->find()->select($fields)->where(['type_id' => $key])->asArray()->all();
    }
    /**
     * 获得类型
     */
    public function FindFaqType() {
        $fields = "*";
        $Model = new FaqType();
        return $Model->find()->select($fields)->asArray()->all();
    }

    /**
     * 根据id获得类型
     */
    public function getFaqType($id) {
        return FaqType::find()->select('*')->where(['id' => $id])->asArray()->one();
    }


}
