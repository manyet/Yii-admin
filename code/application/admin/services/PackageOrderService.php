<?php

namespace admin\services;

use admin\models\PackageOrder;

class PackageOrderService {

    public function add($post) {
        $model = new PackageOrder();
        $model->setAttributes($post);
        return $model->insert();
    }
    
    public function getInfoById($id, $fields = '*') {
        $model = new PackageOrder();
        $packageOrder = $model->find()->select($fields)->where(['id' => $id])->asArray()->one();
        return $packageOrder;
    }
    
    public function cancel($post) {
        $columns = [
            'package_status' => 1,
            'update_by' => getUserId(),
            'update_time' => time(),
            'remark' => $post['remark']
        ];
        $model = new PackageOrder();
        $packageOrder = $model->findOne($post['id']);
        $packageOrder->setAttributes($columns);
        return $packageOrder->update() !== false;
    }

}
