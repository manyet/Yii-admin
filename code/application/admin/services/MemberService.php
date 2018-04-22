<?php

namespace admin\services;

use common\models\ProportionRecord;

class MemberService {

	/**
	 * 增加调整流水
	 */
	public static function addProportionRecord($post) {
		$Model = new ProportionRecord();
		$columns = [
			'user_id' => $post['id'],
			'proportion_before' =>$post['proportion'],
			'proportion_after' =>$post['ratio'],
			'type' =>$post['type'],
			'create_time' =>time(),
		];
        $Model->setAttributes($columns);
        if (!$Model->insert()) {
            return current($Model->getFirstErrors());
        }
        return true;
	}

}
