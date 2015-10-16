<?php

class TopicController extends BaseController{
	public static function index(){
		self::check_logged_in();

		$topics = Topic::all();
		//Kint::dump($topics);
		View::make('home.html', array('topics' => $topics));
	}

	public static function show($id){
		self::check_logged_in();

		//$topic = Topic::find($id);
		//$replies = Reply::repliesForTopic($id);
		$replies = Reply::getAllReplyInfo($id);
		$topic = Topic::getAllTopicInfo($id);
		//Kint::dump($topic);
		View::make('topic/show_topic.html', array('topic' => $topic, 'replies' => $replies));
	}

	public static function new_topic(){
		self::check_logged_in();

		View::make('topic/new_topic.html');
	}

	public static function store(){
		self::check_logged_in();

		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'topic');
		$v->rule('lengthMin', 'topic', 5);
		$v->rule('required', 'content');
		$v->rule('lengthMin', 'content', 10);

		$topic = new Topic(array(
			'topic_topic' => $params['topic'],
			'topic_content' => $params['content'],
			'kayttaja_id' => $_SESSION['user']
			));

		if($v->validate()){
			$topic->save();
			Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi viestiketju on luotu!'));
		}else {
			//Kint::dump($v->errors());
			View::make('topic/new_topic.html', array('errors' => $v->errors(), 'message' => 'NOPE', 'topic' => $topic));

		}
	}

	public static function edit($id){
		self::check_logged_in();
		$currentUser = self::get_user_logged_in();
		$topic = Topic::find($id);

		if($currentUser->id != $topic->kayttaja_id){
			Redirect::to('/', array('message' => 'Ei oikeuksia!'));
		}

		View::make('topic/edit_topic.html', array('topic' => $topic));
	}

	public static function update(){
		self::check_logged_in();

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
			//Kint::dump($v->errors());
			View::make('topic/edit_topic.html', array('errors' => $v->errors(), 'message' => 'NOPE', 'topic' => $topic));

		}
	}

	public static function destroy($id){
		self::check_logged_in();
		self::check_admin();
		
		$topic = new Topic(array('id' => $id));
		$topic->destroy();
		Redirect::to('/', array('message' => 'Ketju poistettu!'));
	}
}