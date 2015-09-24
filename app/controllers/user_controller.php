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
	
}