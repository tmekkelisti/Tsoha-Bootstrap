<?php

class UserController extends BaseController{
	public static function login(){
		View::make('user/login.html');
	}

	public static function handle_login(){
		$params = $_POST;
		$user = Kayttaja::auth($params['username'], $params['password']);

		if(!$user){
			View::make('user/login.html', array('message' => 'Käyttäjätunnus tai salasana väärin'));
		}else{
			$_SESSION['user'] = $user->id;
			Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->user_name . '!'));
		}
	}

	public static function logout(){
		$_SESSION['user'] = null;
		Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
	}

	public static function show($id){
		$user = Kayttaja::find($id);
		$topicsCount = Topic::getNumberOfTopicsByUser($id);
		$repliesCount = Reply::getNumberOfRepliesByUser($id);
		Kint::dump($topicsCount);
		View::make('user/show_user.html', array('user' => $user, 'topicsCount' => $topicsCount, 'repliesCount' => $repliesCount));
	}

	public static function new_user(){
		View::make('user/new_user.html');
	}

	public static function store(){
		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'username');
		$v->rule('lengthMin', 'username', 4);
		$v->rule('required', 'password');
		$v->rule('lengthMin', 'password', 6);

		if($v->validate()){
			$kayttaja = new Kayttaja(array(
				'user_name' => $params['username'],
				'user_password' => $params['password']
				));
			//Kint::dump($kayttaja);
			$kayttaja->save();
			Redirect::to('/login', array('message' => 'Kirjaudu nyt uusilla tunnuksilla sisään'));
		}else{
			View::make('user/new_user.html', array('errors' => $v->errors(), 'message' => 'NOPE!'));
		}
	}
	
}