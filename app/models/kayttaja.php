<?php

class Kayttaja extends BaseModel{
	public $id, $user_name, $user_password, $user_added, $user_admin;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja');
		$query->execute();
		$rows = $query->fetchAll();
		$kayttajat = array();


		foreach ($rows as $row) {
			$kayttajat[] = new Kayttaja(array(
				'id' => $row['id'],
				'user_name' => $row['user_name'],
				'user_password' => $row['user_password'],
				'user_added' => $row['user_added'],
				'user_admin' => $row['user_admin']
				));
		}
		return $kayttajat;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$user = new Kayttaja(array(
				'id' => $row['id'],
				'user_name' => $row['user_name'],
				'user_password' => $row['user_password'],
				'user_added' => $row['user_added'],
				'user_admin' => $row['user_admin']
			));
			return $user;
		}
		return null;
	}

	public static function isUsernameInDB($user_name){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE user_name = :user_name');
		$query->execute(array('user_name' => $user_name));
		$row = $query->fetch();

		if($row){
			return true;
		}
		return false;
	}

	public static function auth($username, $password){
		$query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE user_name = :username AND
		 user_password = :password LIMIT 1'); 
		$query->execute(array(':username' => $username, ':password' => $password));
		$row = $query->fetch();

		if($row){
			$user = new Kayttaja(array(
				'id' => $row['id'],
				'user_name' => $row['user_name'],
				'user_password' => $row['user_password'],
				'user_added' => $row['user_added'],
				'user_admin' => $row['user_admin']
			));
			return $user;
		}else{
			return null;
		}
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Kayttaja (user_name, user_password, user_added, user_admin)
		 VALUES (:user_name, :user_password, NOW(), false) RETURNING id');
		$query->execute(array('user_name' => $this->user_name, 'user_password' => $this->user_password)); 
		$row = $query->fetch();

		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Kayttaja SET user_admin = :user_admin WHERE id = :id');
		$query->execute(array('user_admin' => $this->user_admin, 'id' => $this->id));
		$row = $query->fetch();
	}

	public function updateUser(){
		$query = DB::connection()->prepare('UPDATE Kayttaja SET user_name = :user_name, user_password = :user_password WHERE id = :id');
		$query->execute(array('user_name' => $this->user_name, 'user_password' => $this->user_password, 'id' => $this->id));
		$row = $query->fetch();
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE id = :id');
		$query->execute(array('id' => $this->id));
		$query->fetch();
	}
	
}