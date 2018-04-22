<?php

namespace admin\services;

use admin\models\TransferOrder;

class TransferOrderService {

    public function add($post) {
        $model = new TransferOrder();
        $model->setAttributes($post);
        return $model->insert();
    }
    
}
