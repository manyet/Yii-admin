<?php

namespace admin\services;

use admin\models\BusinessRule;

class BusinessRuleService {

    public function add($post) {
        $model = new BusinessRule();
        
        $post['create_time'] = time();
        $post['create_by'] = getUserId();
        
        $model->setAttributes($post);
        return $model->insert();
    }
    
    public function update($post) {
        $model = new BusinessRule();
        $businessRule = $model->findOne($post['id']);
        $businessRule->setAttributes($post);
        return $businessRule->update() !== false;
    }
    
    public function getInfoById($id, $fields = '*') {
        $model = new BusinessRule();
        $businessRule = $model->find()->select($fields)->where(['id' => $id])->asArray()->one();
        return $businessRule;
    }

}
