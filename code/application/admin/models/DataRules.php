<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class DataRules extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%data_rules}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [[  'play_num','play_day', 'play_week'],'integer','message' => '请输入正确{attribute}人数值'],
            [[  'play_num','play_day', 'play_week','betting_num',
                'betting_day','betting_week','st_money',
                'nd_money','rd_money', 'th_money', 'td_money','create_time',
            ],'double','message' => '请输入正确{attribute}数值'],
            [['st_name', 'nd_name','rd_name', 'th_name', 'td_name',],'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'play_num' => '玩家数值初始值',
            'play_day' => '玩家数值每日叠加值',
            'play_week' => '玩家数值每周再加值',
            'betting_num' => '赌资数值初始值',
            'betting_day' => '赌资数值每日叠加值',
            'betting_week' => '赌资数值每周再加值',
            'st_money' => '1st金额','nd_money' => '2nd金额',
            'rd_money' => '3rd金额','td_money' => '4td金额',
            'th_money' => '5th金额','create_time' => '创建时间',
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





































