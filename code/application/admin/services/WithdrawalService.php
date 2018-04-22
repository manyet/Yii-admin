<?php

namespace admin\services;



use admin\models\ElectronicFeb;
use admin\models\Withdrawal;
use common\models\User;

class WithdrawalService {
    public function getWithdrawal($id){
        $fields = "a.*,u.uname,u.realname,r.currency";
        $where = ['a.id' => $id];;
        $model = new Withdrawal();
        $notice = $model->find()->select($fields)->alias('a')
            ->leftJoin('{{%user}} u', 'u.id = a.user_id')->leftJoin('{{%exchange_rate}} r', 'r.id = a.rate')->where($where)->asArray()->one();

        return $notice;
    }


    public static function Febchange($user_id, $amount, $type, $change_type, $wallet_type, $remark = '') {
        if ($amount == 0) {
            return true;
        }
        $types = ['1' => 'electronic_number', '2' => 'froze_electronic_number'];
        $key = $types[$wallet_type];
        $user = User::findOne($user_id);
        $balance_before = floatval($user->{$key});
        $amount = floatval($amount);
        if ($type == 1) {
            $total_key = '' . $key;
            $user->setAttribute($total_key, $user->{$total_key} + $amount);
            $balance_after = $balance_before + $amount;
        } else {
            if ($balance_before < $amount) { // 余额不足
                return false;
            }
            $balance_after = $balance_before - $amount;
        }
        $user->setAttribute($key, $balance_after);
        if ($user->update() === false) {
            return false;
        }
        return self::addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark);
    }

    public static function addLog($user_id, $amount, $type, $change_type, $wallet_type, $balance_before, $balance_after, $remark) {
        $model = new ElectronicFeb();
        $model->setAttributes([
            'user_id' => $user_id,
            'value' => $amount,
            'type' => $type,
            'change_type' => $change_type,
            'wallet_type' => $wallet_type,
            'before_feb' => $balance_before,
            'after_feb' => $balance_after,
            'remark' => $remark,
            'create_time' => time()
        ]);
        return $model->insert();
    }


}