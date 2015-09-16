<?php

class TopicController extends BaseController{
	public static function index(){
		$topics = Topic::all();
		View::make('home.html', array('topics' => $topics));
	}

	public static function show($id){
		$topic = Topic::find($id);
		$replies = Reply::repliesForTopic($id);
		Kint::dump($replies);
		View::make('topic/show_topic.html', array('topic' => $topic, 'replies' => $replies));
	}

	public static function new_topic(){
		View::make('topic/new_topic.html');
	}

	public static function store(){
		$params = $_POST;
		$topic = new Topic(array(
			'topic_topic' => $params['topic'],
			'topic_content' => $params['content'],
			));
		
		//Kint::dump($params);
		//Kint::dump($topic);

		$topic->save();

		Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi viestiketju on luotu!'));
	}
}