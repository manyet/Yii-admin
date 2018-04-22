<?php

namespace admin\services;

use admin\models\SystemUser;
use admin\models\Notice;

/**
 * 消息
 */
class NoticeService extends AdminService {

    public function getInfoById($id) {
        $fields = "n.*, u.username";
        $where = ['n.id' => $id];
        $model = new Notice();
        $notice = $model->find()->select($fields)->alias('n')->leftJoin(SystemUser::tableName() . ' u', 'u.id = n.user_id')->where($where)->asArray()->one();
        
        return $notice;
    }
    
    public function deleteById($id) {
        $model = new Notice();
        $one = $model->findOne($id);

        return $one->delete();
    }
    
    public function updateInfo($post) {
        $columns = [
            'type' => $post['type'],
            'title' => $post['title'],
            'content' => $post['content'],
            'remark' => $post['remark'],
        ];

        $noticeModel = new Notice();
        $result = $noticeModel->findOne($post['id']);
        $result->setAttributes($columns, FALSE);
        return $result->update();
    }
    
    public function addNotice($post) {
        $columns = [
            'type' => $post['type'],
            'title' => $post['title'],
            'content' => $post['content'],
            'create_time' => time(),
            'remark' => $post['remark'],
            'user_id' => $post['user_id']
        ];
        
        $model = new Notice();
        $model->setAttributes($columns, FALSE);
        
        return $model->insert();
    }

}
