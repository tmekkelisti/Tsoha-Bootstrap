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
		$query = DB::connection()->prepare('INSERT INTO Reply (reply_content, topic_id, reply_added) VALUES (:reply_content, :topic_id, NOW()) RETURNING topic_id');
		$query->execute(array('reply_content' => $this->reply_content, 'topic_id' => $this->topic_id));
		$row = $query->fetch();

		//Kint::trace();
		Kint::dump($row);

		//$this->id = $row['id'];
	}
}