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
		//Kint::dump($topicsCount);
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

		if(Kayttaja::isUsernameInDB($params['username'])){
			View::make('user/new_user.html', array('message' => 'Käyttäjätunnus jo olemassa! Valitse toinen.'));
		}

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

	public static function all(){
		self::check_logged_in();
		self::check_admin();

		$users = Kayttaja::all();

		View::make('user/all_users.html', array('users' => $users));
	}

	public static function update($id){
		self::check_logged_in();
		self::check_admin();

		if(isset($_POST['admin'])){
			$admin = 1;
		}else{
			$admin = 0;
		}

		$user = Kayttaja::find($id);
		$user->user_admin = $admin;
		$user->update();
		Redirect::to('/user', array('message' => 'Käyttäjän oikeuksia muokattu'));
	}

	public static function edit($id){
		self::check_logged_in();

		$currentUser = self::get_user_logged_in();
		$user = Kayttaja::find($id);


		if($currentUser->id != $user->id){
			Redirect::to('/', array('message' => 'Ei oikeuksia!'));
		}

		View::make('user/edit_user.html', array('user' => $user));
	}
	
	public static function updateUser($id){
		self::check_logged_in();

		$params = $_POST;

		$v = new Valitron\Validator($params);
		$v->rule('required', 'username');
		$v->rule('lengthMin', 'username', 4);
		$v->rule('required', 'password');
		$v->rule('lengthMin', 'password', 6);

		$currentUser = self::get_user_logged_in();
		$user = Kayttaja::find($id);

		if($currentUser->id != $user->id){
			Redirect::to('/', array('message' => 'Ei oikeuksia!'));
		}

		if(Kayttaja::isUsernameInDB($params['username'])){
			View::make('user/new_user.html', array('message' => 'Käyttäjätunnus jo olemassa! Valitse toinen.'));
		}


		if($v->validate()){
			$user->user_name = $params['username'];
			$user->user_password = $params['password'];

			
			//Kint::dump($user);
			$user->updateUser();
			Redirect::to('/user/' . $user->id, array('message' => 'Käyttäjän tietoja muokattu'));
		}else{
			View::make('user/edit_user.html', array('errors' => $v->errors(), 'message' => 'NOPE', 'user' => $user));
		}
	}

	public static function destroy($id){
		self::check_logged_in();
		self::check_admin();
		
		$user = new Kayttaja(array('id' => $id));
		$user->destroy();
		Redirect::to('/user', array('message' => 'Käyttäjä poistettu!'));
	}
}