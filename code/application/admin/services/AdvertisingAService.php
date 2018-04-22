<?php

namespace admin\services;

use admin\models\AdvertisingA;
use admin\models\AdvertisingOpen;

class AdvertisingAService {

    public $errorMessage = '';
    public $errorCode = 0;
    public $scenario = NULL;
    /**
     * 判断添加广告组发布
     */
    public function checkAdvertising($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];
        $Model = new AdvertisingA();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 查找广告A
     */
    public function findAdvertisingA($post) {
//        var_dump($post);exit();
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new AdvertisingA();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }
    /**
     * 判断表中开启id
     */
    public function findAdvertisingOpen($post) {
        $fields = "id,name,open";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new AdvertisingOpen();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }
    /**
     * 添加汇率
     */

    public function addAdvertising($post)
    {
        $params = [
            'advertising_name' => $post['advertising_name'],
            'advertising_describe' => $post['advertising_describe'],
            'advertisers_1' => $post['advertisers_1'],'advertising_Picture1' => $post['advertising_Picture1'],
            'advertisers_2' => $post['advertisers_2'],'advertising_Picture2' => $post['advertising_Picture2'],
            'advertisers_3' => $post['advertisers_3'],'advertising_Picture3' => $post['advertising_Picture3'],
            'advertisers_4' => $post['advertisers_4'],'advertising_Picture4' => $post['advertising_Picture4'],
            'advertisers_5' => $post['advertisers_5'],'advertising_Picture5' => $post['advertising_Picture5'],
            'advertisers_6' => $post['advertisers_6'],'advertising_Picture6' => $post['advertising_Picture6'],
            'advertising_Path1' => $post['advertising_Path1'],'price1' => $post['price1'],
            'advertising_Path2' => $post['advertising_Path2'],'price2' => $post['price2'],
            'advertising_Path3' => $post['advertising_Path3'],'price3' => $post['price3'],
            'advertising_Path4' => $post['advertising_Path4'],'price4' => $post['price4'],
            'advertising_Path5' => $post['advertising_Path5'],'price5' => $post['price5'],
            'advertising_Path6' => $post['advertising_Path6'],'price6' => $post['price6'],
            'note1' => $post['note1'],'note2' => $post['note2'],'note3' => $post['note3'],
            'note4' => $post['note4'],'note5' => $post['note5'],'note6' => $post['note6'],
            'c_open1' => $post['c_open1'],'c_open2' => $post['c_open2'],'c_open3' => $post['c_open3'],
            'c_open4' => $post['c_open4'],'c_open5' => $post['c_open5'],'c_open6' => $post['c_open6'],
            'wap_Picture1' => $post['wap_Picture1'],'wap_Picture2' => $post['wap_Picture2'],
            'wap_Picture3' => $post['wap_Picture3'], 'wap_Picture4' => $post['wap_Picture4'],
            'wap_Picture5' => $post['wap_Picture5'],'wap_Picture6' => $post['wap_Picture6'],
            'create_time' => time(),
            'open' => 1,
        ];
        $model = new AdvertisingA();
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
    public function getId($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];

        $Model = new AdvertisingA();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 修改状态
     */
    public function Up($post)
    {
        $id = $post['id'];
        $columns = [];
        $columns['open'] = $post['open'];
        $model = new AdvertisingA();
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
    public static function delAdvertisingA($id) {
        $model = AdvertisingA::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }
    /**
     * 发布
     */
    public static function Release($id) {
        $columns = [
            'open' => 1
        ];
        $menuModel = new AdvertisingA();
        $one = $menuModel->findOne($id);
        $one->setAttributes($columns);
        return $one->update() !== false;
    }

}
