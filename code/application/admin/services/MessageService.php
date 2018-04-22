<?php
/**
 * Created by BBM
 * DateTime: 2016-11-18 15:04
 */

namespace admin\services;

use admin\models\Message;

class MessageService
{
    /**
     * 添加一条消息
     * @param $params
     * @return bool
     */
    public function addMessage($params){
        $model = new Message();
        if(array_key_exists('user_id', $params) && is_numeric($params['user_id']))
        {
            $model->user_id = $params['user_id'];
        }
        if(array_key_exists('title', $params) && !empty($params['title']))
        {
            $model->title = $params['title'];
        }
        if(array_key_exists('content', $params) && !empty($params['content']))
        {
            $model->content = $params['content'];
        }
        if(array_key_exists('status', $params) && is_numeric($params['status']))
        {
            $model->status = $params['status'];
        }
        return $model->save();
    }

    /**
     * @param $condition
     * @param $params
     * @return bool|string
     */
    public function updateMessage($condition, $params)
    {
        if(!is_array($condition) || !is_array($params) || empty($condition) || empty($params))
        {
            return '参数错误';
        }
        $model = Message::findOne($condition['id']);
        if (array_key_exists('user_id',$params) && is_numeric($params['user_id'])) {
            $model->user_id = $params['user_id'];
        }
        if (array_key_exists('title',$params) && !empty($params['title'])) {
            $model->title = $params['title'];
        }
        if (array_key_exists('content',$params) && !empty($params['content'])) {
            $model->content = $params['content'];
        }
        if (array_key_exists('status',$params) && is_numeric($params['status'])) {
            $model->status = $params['status'];
        }
        return $model->save();
    }
}