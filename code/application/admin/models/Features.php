<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/9
 * Time: 17:34
 */

namespace admin\models;

use yii\db\ActiveRecord;

class Features extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%features}}';
    }

    /**
     * 验证规则
     * @return array
     */

    public function rules()
    {
        return [
            [['title1','features_Picture1', 'summary1','details1',
              'title2','features_Picture2', 'summary2','details2',
              'title3','features_Picture3', 'summary3','details3',
              'title4','features_Picture4', 'summary4','details4',
              'title5','features_Picture5', 'summary5','details5',
              'title6','features_Picture6', 'summary6','details6',
              'e_title1', 'e_summary1','e_details1',
              'e_title2', 'e_summary2','e_details2',
              'e_title3', 'e_summary3','e_details3',
              'e_title4', 'e_summary4','e_details4',
              'e_title5', 'e_summary5','e_details5',
              'e_title6', 'e_summary6','e_details6',
              'features_open1', 'features_open3','features_open5',
              'features_open2', 'features_open4','features_open6',
            ],'safe']
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





































