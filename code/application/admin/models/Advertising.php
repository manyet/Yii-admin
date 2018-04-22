<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class Advertising extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [['id', 'a_status', 'a_sort', 'sta_time', 'end_time','create_time'], 'integer'],
            [['title','photo_url','dump_url','description','notes','location'],'string']
        ];
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





































