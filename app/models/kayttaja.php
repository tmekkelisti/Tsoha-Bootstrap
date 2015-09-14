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
}