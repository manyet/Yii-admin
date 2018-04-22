<?php

namespace admin\services;

use admin\models\Faq;
use admin\models\FaqType;

class FaqTypeService {
    public $errorMsg;
   public function addFaqType($post){
       $columns = [
           'sort' => $post['sort'],
           'type_name' => $post['type_name'],
           'type_ename' => $post['type_ename'],
           'create_time' => time(),
       ];
       $model = new FaqType();
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
    public function getFaqType($params=[]) {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = [':id' => $params['id']];

        $Model = new FaqType();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 根据id获得关联类型下的数据
     */
    public function getFaq($params=[]) {
        $fields = "*";
        $conditions = 'type_id = :id';
        $bind_params = [':id' => $params];

        $Model = new Faq();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }

    /**
     * 删除
     */
    public static function delFaq($id) {
        $model = FaqType::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }


}
