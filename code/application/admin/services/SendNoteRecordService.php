<?php
/**
 * Created by BBM
 * DateTime: 2016-12-02 14:04
 */

namespace admin\services;

use admin\models\SendNoteRecordModel;

class SendNoteRecordService
{
    /**
     * 插入一条信息进`tsk_send_note_record`
     * @param array $params
     * @return bool
     */
    public function addNoteRecord($params)
    {
        $model = new SendNoteRecordModel();
        $model->user_id      = $params['user_id'];
        $model->key          = $params['key'];
        $model->code         = $params['code'];
        $model->mobile       = $params['mobile'];
        $model->session_name = array_key_exists('session_name',$params)?$params['session_name']:'';
        $model->send_time    = $params['send_time'];
        $model->expiry_time  = $params['expiry_time'];
        $model->content      = $params['content'];
        $model->error_info   = $params['error_info'];
        return $model->save();
    }

    /**
     * 获取一条信息
     * @param $id
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public function getInfo($id)
    {
        if(empty($id) || !is_numeric($id))
        {
            return false;
        }
        return SendNoteRecordModel::find()->where(['id' => $id])->asArray()->one();
    }
}