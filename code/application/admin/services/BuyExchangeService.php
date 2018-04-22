<?php

namespace admin\services;

use admin\models\BuyExchange;

class BuyExchangeService {

	public $errorMessage = '';
	public $errorCode = 0;
	public $scenario = NULL;
    /**
     * 判断添加币种是否已经存在
     */
    public function checkBuyExchange($params = []) {
        $fields = "id,currency,buy_exchange_rate,sell_exchange_rate,operator,create_time,is_deleted";
        $conditions = 'currency = :id';
        $bind_params = [':id' => $params['currency']];
        $Model = new BuyExchange();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 判断修改币种是否已经存在
     */
    public function UpBuyExchange($post) {
        $fields = "id,currency,buy_exchange_rate,sell_exchange_rate,operator,create_time,is_deleted";
        $conditions = 'currency = :currency';
        $bind_params = ['currency' => $post['currency']];
        $conditions1 = 'id != :id';
        $bind_params1 = ['id' => $post['id']];
        $Model = new BuyExchange();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->andWhere($conditions1,$bind_params1)->asArray()->one();

    }
    /**
     * 判断修改币种是否已经存在
     */
    public function findBuyExchange($post) {
        $fields = "id,currency,buy_exchange_rate,operator,sell_exchange_rate,create_time,is_deleted";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new BuyExchange();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }
    /**
     * 添加汇率
     */

    public function addExchange($post)
    {
        $operator = getUserId();

        $params = [
            'currency' => $post['currency'],
            'e_currency' => $post['e_currency'],
            'buy_exchange_rate' => $post['buy_exchange_rate'],
            'sell_exchange_rate' => $post['sell_exchange_rate'],
            'operator' => $operator,
            'create_time' => time(),
        ];
        if (!is_exchange($post['buy_exchange_rate'])) {
            $errorMessage = '请输入正确购买/充值汇率';

            return $errorMessage;
        }
        if (!is_exchange($post['sell_exchange_rate'])) {
            $errorMessage = '请输入正确提现汇率';

            return $errorMessage;
        }

        $model = new BuyExchange();
        $model->isNewRecord = true;
        $model->setAttributes($params);
        if (!$model->insert()) {
            return current($model->getFirstErrors());
        }
        return true;
    }
    /**
     * 根据id获得汇率
     */
    public function getBuyExchange($params = []) {
        $fields = "id,currency,e_currency,buy_exchange_rate,sell_exchange_rate,create_time";
        $conditions = 'id = :id';
        $bind_params = [':id' => $params['id']];

        $Model = new BuyExchange();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();
    }
    /**
     * 删除汇率
     */
    public function del($post)
    {

        $id = $post['id'];
        $columns = [];
        if (array_key_exists('is_deleted', $post) && !empty($post['is_deleted'])) {
            $columns['is_deleted'] = $post['is_deleted'];
        }
        $model = new BuyExchange();
        $result = $model->findOne($id);
        $result->setAttributes($columns);
        if ($result->update() === false) {
            $this->errMsg = current($result->getFirstErrors());

            return false;
        }

        return true;
    }

}
