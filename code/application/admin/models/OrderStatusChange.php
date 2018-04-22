<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class OrderStatusChange extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_status_change}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [['id', 'order_id', 'store_id', 'old_status', 'new_status', 'create_time'], 'integer'],
            [['notes'], 'string']
        ];
    }

    /**
     * 获取商家指定时间段内的接单数
     * @param $post
     * @return array|null|ActiveRecord
     */
    public function getOrderCountByTime($post)
    {
        $fields = 'count(0) as num';
        $where = "store_id='" . $post['id'] . "' AND new_status=4";
        if ($post['type'] == 1) {
            $where .= ' AND create_time>=' . strtotime($post['time']) . " AND create_time<=" . (strtotime($post['time']) + 3600 * 24);
        }
        if ($post['type'] == 2) {
            $where .= ' AND create_time>=' . strtotime($post['time']) . " AND create_time<=" . strtotime($post['time'] . "+1 month");
        }
        if ($post['type'] == 3) {
            $where .= ' AND create_time>=' . strtotime($post['time']) . " AND create_time<=" . strtotime($post['time'] . "+3 month");
        }

        return static::find()->select($fields)->where($where)->asArray()->one();
    }

    /**
     * 返回表单验证的第一个错误
     * @param string $attribute
     * @return array
     */
    public function getFirstError($attribute)
    {
        return current($this->getFirstErrors());
    }
}





































