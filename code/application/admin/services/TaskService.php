<?php

namespace admin\services;

use admin\models\Task;

class TaskService {

    public function add($post) {
        $model = new Task();
        
        $post['create_time'] = time();
        $post['create_by'] = getUserId();
        
        $model->setAttributes($post);
        return $model->insert();
    }
    
    public function getInfoById($id, $fields = '*') {
        $model = new Task();
        $task = $model->find()->select($fields)->where(['id' => $id])->asArray()->one();
        return $task;
    }
    
    public function update($post) {
        $model = new Task();
        $task = $model->findOne($post['id']);
        $task->setAttributes($post);
        return $task->update() !== false;
    }

    public function del($id) {
        $model = Task::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }
    
    public function takeOff($id) {
        $columns = [
            'status' => 0
        ];
        $model = new Task();
        $task = $model->findOne($id);
        $task->setAttributes($columns);
        return $task->update() !== false;
    }
    
    public function sale($id) {
        $columns = [
            'status' => 1
        ];
        $model = new Task();
        $task = $model->findOne($id);
        $task->setAttributes($columns);
        return $task->update() !== false;
    }

}
