<?php

namespace admin\services;

use admin\models\AdvertisingB;
use admin\models\AdvertisingOpen;

class AdvertisingBService {

    public $errorMessage = '';
    public $errorCode = 0;
    public $scenario = NULL;
    /**
     * 判断添加广告组发布
     */
    public function checkAdvertisingB($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];
        $Model = new AdvertisingB();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 查找广告A
     */
    public function findAdvertisingB($post) {
//        var_dump($post);exit();
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new AdvertisingB();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }

    /**
     * 添加汇率
     */

    public function addAdvertisingB($post)
    {
        $params = [
            'advertising_name' => $post['advertising_name'],
            'advertising_describe' => $post['advertising_describe'],
            'advertisers_1' => $post['advertisers_1'],'advertising_Picture1' => $post['advertising_Picture1'],
            'advertisers_2' => $post['advertisers_2'],'advertising_Picture2' => $post['advertising_Picture2'],
            'advertisers_3' => $post['advertisers_3'],'advertising_Picture3' => $post['advertising_Picture3'],
            'advertisers_4' => $post['advertisers_4'],'advertising_Picture4' => $post['advertising_Picture4'],
            'advertising_Path1' => $post['advertising_Path1'],'price1' => $post['price1'],
            'advertising_Path2' => $post['advertising_Path2'],'price2' => $post['price2'],
            'advertising_Path3' => $post['advertising_Path3'],'price3' => $post['price3'],
            'advertising_Path4' => $post['advertising_Path4'],'price4' => $post['price4'],
            'note1' => $post['note1'],'note2' => $post['note2'],'note3' => $post['note3'],
            'note4' => $post['note4'],'b_open1' => $post['b_open1'],'b_open2' => $post['b_open2'],
            'b_open3' => $post['b_open3'], 'b_open4' => $post['b_open4'],
            'create_time' => time(),
            'open' => 1,
        ];
        $model = new AdvertisingB();
        $model->isNewRecord = true;
        $model->setAttributes($params);
        if (!$model->insert()) {
            return current($model->getFirstErrors());
        }
        return true;
    }
    /**
     * 根据状态获取id
     */
    public function getIdB($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];

        $Model = new AdvertisingB();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 修改状态
     */
    public function UpB($post)
    {
        $id = $post['id'];
        $columns = [];
        $columns['open'] = $post['open'];
        $model = new AdvertisingB();
        $result = $model->findOne($id);
        $result->setAttributes($columns);
        if ($result->update() === false) {
            $this->errMsg = current($result->getFirstErrors());

            return false;
        }

        return true;
    }
    /**
     * 删除
     */
    public static function delAdvertisingB($id) {
        $model = AdvertisingB::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }
    /**
     * 发布
     */
    public static function ReleaseB($id) {
        $columns = [
            'open' => 1
        ];
        $menuModel = new AdvertisingB();
        $one = $menuModel->findOne($id);
        $one->setAttributes($columns);
        return $one->update() !== false;
    }

}
