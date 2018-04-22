<?php

namespace admin\services;

use admin\models\Features;

class FeaturesService {

    /**
     * 添加汇率
     */

    public function addFeatures($post)
    {
        $params = [
            'title1' => $post['title1'],'features_Picture1' => $post['features_Picture1'],
            'title2' => $post['title2'],'features_Picture2' => $post['features_Picture2'],
            'title3' => $post['title3'],'features_Picture3' => $post['features_Picture3'],
            'title4' => $post['title4'],'features_Picture4' => $post['features_Picture4'],
            'title5' => $post['title5'],'features_Picture5' => $post['features_Picture5'],
            'title6' => $post['title6'],'features_Picture6' => $post['features_Picture6'],
            'e_title1' => $post['e_title1'], 'e_title2' => $post['e_title2'], 'e_title3' => $post['e_title3'],
            'e_title4' => $post['e_title4'], 'e_title5' => $post['e_title5'], 'e_title6' => $post['e_title6'],
            'summary1' => $post['summary1'],'details1' => $post['details1'],
            'summary2' => $post['summary2'],'details2' => $post['details2'],
            'summary3' => $post['summary3'],'details3' => $post['details3'],
            'summary4' => $post['summary4'],'details4' => $post['details4'],
            'summary5' => $post['summary5'],'details5' => $post['details5'],
            'summary6' => $post['summary6'],'details6' => $post['details6'],
            'e_summary1' => $post['e_summary1'],'e_details1' => $post['e_details1'],
            'e_summary2' => $post['e_summary2'],'e_details2' => $post['e_details2'],
            'e_summary3' => $post['e_summary3'],'e_details3' => $post['e_details3'],
            'e_summary4' => $post['e_summary4'],'e_details4' => $post['e_details4'],
            'e_summary5' => $post['e_summary5'],'e_details5' => $post['e_details5'],
            'e_summary6' => $post['e_summary6'],'e_details6' => $post['e_details6'],
            'features_open1' => $post['features_open1'],'features_open4' => $post['features_open4'],
            'features_open2' => $post['features_open2'],'features_open5' => $post['features_open5'],
            'features_open3' => $post['features_open3'],'features_open6' => $post['features_open6'],

        ];
        $model = new Features();
        $model->isNewRecord = true;
        $model->setAttributes($params);
        if (!$model->insert()) {
            return current($model->getFirstErrors());
        }
        return true;
    }
    /**
     * 查找功能
     */
    public function findFeatures($post) {
        $fields = "*";
        $conditions = 'id = :id';
        $bind_params = ['id' => $post['id']];
        $Model = new Features();
        return $Model->find()->select($fields)->where($conditions, $bind_params)->asArray()->one();

    }

}
