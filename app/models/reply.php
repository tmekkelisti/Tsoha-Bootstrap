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
}