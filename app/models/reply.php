<?php

class Reply extends BaseModel{
	public $id, $reply_content, $reply_added, $kayttaja_id, $topic_id;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function repliesForTopic($id){
		// $query = DB::connection()->prepare('SELECT * FROM Reply WHERE topic_id = :id');
		// $query->execute(array('id' => $id));
		// $row = $query->fetchAll();
		

		// if($row){
		// 	$replies = new Reply(array(
		// 		'id' => $row['id'],
		// 		'reply_content' => $row['reply_content'],
		// 		'reply_added' => $row['reply_added'],
		// 		'kayttaja_id' => $row['kayttaja_id'],
		// 		'topic_id' => $row['topic_id']
		// 		));
		// 	return $replies;
		// }
		// return null;
		$topic_id = $id;
		$query = DB::connection()->prepare('SELECT * FROM reply where topic_id = :id');
		$query->execute(array($topic_id));
		$rows = $query->fetchAll();
		$replies = array();

		foreach ($rows as $row) {
			$replies[] = new Reply(array(
				'id' => $row['id'],
				'reply_content' => $row['reply_content'],
				'reply_added' => $row['reply_added'],
				'kayttaja_id' => $row['kayttaja_id'],
				'topic_id' => $row['topic_id']
				));
		}
		return $replies;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Reply (reply_content, topic_id, reply_added, kayttaja_id) VALUES (:reply_content, :topic_id, NOW(), :kayttaja_id) RETURNING topic_id');
		$query->execute(array('reply_content' => $this->reply_content, 'topic_id' => $this->topic_id, 'kayttaja_id' => $this->kayttaja_id));
		$row = $query->fetch();

		//Kint::trace();
		Kint::dump($row);

		//$this->id = $row['id'];
	}

	public function getAllReplyInfo($id){
		$query = DB::connection()->prepare('SELECT Reply.id, Reply.reply_content, Reply.reply_added, Kayttaja.user_name, Kayttaja.id AS user_id, Kayttaja.user_added
			FROM Reply
			INNER JOIN Kayttaja
			ON Reply.kayttaja_id = Kayttaja.id

			WHERE topic_id = :id
			ORDER BY Reply.reply_added ASC
			');
		$query->execute(array('id' => $id));
		$rows = $query->fetchAll();
		$replies = array();

		foreach ($rows as $row) {
			$replies[] = array(
				'id' => $row['id'],
				'reply_content' => $row['reply_content'],
				'reply_added' => $row['reply_added'],
				'user_name' => $row['user_name'],
				'user_id' => $row['user_id'],
				'user_added' => $row['user_added']
				);
		}


		return $replies;
	}

	public static function getNumberOfRepliesByUser($id){
		$query = DB::connection()->prepare('SELECT COUNT(Reply.id) FROM Reply
				WHERE kayttaja_id = :id');
		$query->execute(array('id' => $id));
		return $query->fetch();
	}

}