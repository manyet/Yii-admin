<?php

namespace admin\services;

use admin\models\WalletRule;

class WalletRuleService {

    public function add($post) {
        $model = new WalletRule();
        
        $post['create_time'] = time();
        $post['create_by'] = getUserId();
        
        $model->setAttributes($post);
        return $model->insert();
    }
    
    public function update($post) {
        $model = new WalletRule();
        $walletRule = $model->findOne($post['id']);
        $walletRule->setAttributes($post);
        return $walletRule->update() !== false;
    }
    
    public function getInfoById($id, $fields = '*') {
        $model = new WalletRule();
        $walletRule = $model->find()->select($fields)->where(['id' => $id])->asArray()->one();
        return $walletRule;
    }

}
