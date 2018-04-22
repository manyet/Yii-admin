<?php

namespace admin\services;

use admin\models\AdvertisingC;

class AdvertisingCService {

    public $errorMessage = '';
    public $errorCode = 0;
    public $scenario = NULL;
    /**
     * 判断添加广告组发布
     */
    public function checkAdvertisingC($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];
        $Model = new AdvertisingC();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 查找广告A
     */
    public function findAdvertisingC($post) {
//        var_dump($post);exit();
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new AdvertisingC();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }

    /**
     * 添加汇率
     */

    public function addAdvertisingC($post)
    {
//        var_dump($post);exit();
        $params = [
            'advertising_name' => $post['advertising_name'],
            'advertising_describe' => $post['advertising_describe'],
            'casino_name1' => $post['casino_name1'],'advertising_Picture1' => $post['advertising_Picture1'],
            'casino_name2' => $post['casino_name2'],'advertising_Picture2' => $post['advertising_Picture2'],
            'casino_name3' => $post['casino_name3'],'advertising_Picture3' => $post['advertising_Picture3'],
            'casino_name4' => $post['casino_name4'],'advertising_Picture4' => $post['advertising_Picture4'],
            'advertising_Path1' => $post['advertising_Path1'],'price1' => $post['price1'],
            'advertising_Path2' => $post['advertising_Path2'],'price2' => $post['price2'],
            'advertising_Path3' => $post['advertising_Path3'],'price3' => $post['price3'],
            'advertising_Path4' => $post['advertising_Path4'],'price4' => $post['price4'],
            'number1' => $post['number1'],'number2' => $post['number2'],'number3' => $post['number3'],
            'flag_Picture2' => $post['flag_Picture2'],'flag_Picture1' => $post['flag_Picture1'],
            'flag_Picture3' => $post['flag_Picture3'],'flag_Picture4' => $post['flag_Picture4'],
            'number4' => $post['number4'],
            'create_time' => time(),
            'open' => 1,
        ];
        $model = new AdvertisingC();
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
    public function getIdC($params = []) {
        $fields = "id";
        $conditions = 'open = :id';
        $bind_params = [':id' => 1];

        $Model = new AdvertisingC();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 修改状态
     */
    public function UpC($post)
    {
        $id = $post['id'];
        $columns = [];
        $columns['open'] = $post['open'];
        $model = new AdvertisingC();
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
    public static function delAdvertisingC($id) {
        $model = AdvertisingC::findOne($id);
        if (empty($model)) {
            return false;
        }
        return $model->delete();
    }
    /**
     * 发布
     */
    public static function ReleaseC($id) {
        $columns = [
            'open' => 1
        ];
        $menuModel = new AdvertisingC();
        $one = $menuModel->findOne($id);
        $one->setAttributes($columns);
        return $one->update() !== false;
    }

}
