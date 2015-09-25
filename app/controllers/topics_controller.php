<?php

class TopicController extends BaseController{
	public static function index(){
		$topics = Topic::all();
		View::make('home.html', array('topics' => $topics));
	}

	public static function show($id){
		//$topic = Topic::find($id);
		//$replies = Reply::repliesForTopic($id);
		$replies = Reply::getAllReplyInfo($id);
		$topic = Topic::getAllTopicInfo($id);
		Kint::dump($topic);
		View::make('topic/show_topic.html', array('topic' => $topic, 'replies' => $replies));
	}

	public static function new_topic(){
		View::make('topic/new_topic.html');
	}

	public static function store(){
		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'topic');
		$v->rule('lengthMin', 'topic', 5);
		$v->rule('required', 'content');
		$v->rule('lengthMin', 'content', 10);



		if($v->validate()){
			$topic = new Topic(array(
			'topic_topic' => $params['topic'],
			'topic_content' => $params['content'],
			'kayttaja_id' => $_SESSION['user']
			));

			$topic->save();
			Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi viestiketju on luotu!'));
		}else {
			Kint::dump($v->errors());
			View::make('topic/new_topic.html', array('errors' => $v->errors(), 'message' => 'NOPE'));

		}
	}

	public static function edit($id){
		$topic = Topic::find($id);
		View::make('topic/edit_topic.html', array('topic' => $topic));
	}

	public static function update(){
		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'content');
		$v->rule('lengthMin', 'content', 10);

		$topic = Topic::find($params['topic-id']);


		if($v->validate()){
			$topic->topic_content = $params['content'];

			$topic->update();
			Redirect::to('/topic/' . $topic->id, array('message' => 'Aloitusviestiä muokattu!'));
		}else {
			Kint::dump($v->errors());
			View::make('topic/edit_topic.html', array('errors' => $v->errors(), 'message' => 'NOPE', 'topic' => $topic));

		}
	}

	public static function destroy($id){
		$topic = new Topic(array('id' => $id));
		$topic->destroy();
		Redirect::to('/', array('message' => 'Ketju poistettu!'));
	}
}