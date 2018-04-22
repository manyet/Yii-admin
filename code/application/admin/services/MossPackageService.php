<?php

namespace admin\services;

use admin\models\MossPackage;

class MossPackageService {

    public function add($post) {
        $model = new MossPackage();
        
        $post['create_time'] = time();
        $post['create_by'] = getUserId();
        
        $model->setAttributes($post);
        return $model->insert();
    }
    
    public function getInfoById($id, $fields = '*') {
        $model = new MossPackage();
        $mossPackage = $model->find()->select($fields)->where(['id' => $id])->asArray()->one();
        return $mossPackage;
    }
    
    public function update($post) {
        $model = new MossPackage();
        $mossPackage = $model->findOne($post['id']);
        $mossPackage->setAttributes($post);
        return $mossPackage->update() !== false;
    }

    public function del($id) {
        $model = new MossPackage();
        $mossPackage = $model->findOne($id);
        $mossPackage->setAttributes(['is_deleted' => 1]);
        return $mossPackage->update() !== false;
    }
    
    public function takeOff($id) {
        $columns = [
            'package_status' => 0
        ];
        $model = new MossPackage();
        $mossPackage = $model->findOne($id);
        $mossPackage->setAttributes($columns);
        return $mossPackage->update() !== false;
    }
    
    public function sale($id) {
        $columns = [
            'package_status' => 1
        ];
        $model = new MossPackage();
        $mossPackage = $model->findOne($id);
        $mossPackage->setAttributes($columns);
        return $mossPackage->update() !== false;
    }

}
