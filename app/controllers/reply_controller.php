<?php

class ReplyController extends BaseController{
	
	public static function store(){
		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'content');
		$v->rule('lengthMin', 'content', 6);
		$v->rule('required', 'topic-id');
		$v->rule('numeric', 'topic-id');

		if($v->validate()){
			$reply = new Reply(array(
			'reply_content' => $params['content'],
			'topic_id' => $params['topic-id'],
			'kayttaja_id' => $_SESSION['user']
			));		
			//Kint::dump($params);
			//Kint::dump($reply);
			$reply->save();
			Redirect::to('/topic/' . $params['topic-id'], array('message' => 'Vastattu ketjuun'));
		}else{
			$topic = Topic::find($params['topic-id']);
			$replies = Reply::repliesForTopic($params['topic-id']);
			View::make('topic/show_topic.html', array('topic' => $topic, 'replies' => $replies, 'errors' => $v->errors()));
		}


	}
}