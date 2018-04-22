<?php

namespace admin\services;

use admin\models\MudcodeOrder;

class MudcodeOrderService {

    public function add($post) {
        $model = new MudcodeOrder();
        $model->setAttributes($post);
        return $model->insert();
    }
    
}
