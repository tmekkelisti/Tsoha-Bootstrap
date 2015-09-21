<?php

class ReplyController extends BaseController{
	
	public static function store(){
		$params = $_POST;
		$reply = new Reply(array(
			'reply_content' => $params['content']
			,'topic_id' => $params['topic-id']
			));
		
		Kint::dump($params);
		//Kint::dump($reply);

		$reply->save();

		Redirect::to('/topic/' . $params['topic-id'], array('message' => 'Vastattu ketjuun'));
	}
}