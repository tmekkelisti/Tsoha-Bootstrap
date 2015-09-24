<?php

class Topic extends BaseModel{
	public $id, $topic_topic, $topic_content, $topic_added, $kayttaja_id, $category_id;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Topic');
		$query->execute();
		$rows = $query->fetchAll();
		$topics = array();


		foreach ($rows as $row) {
			$topics[] = new Topic(array(
				'id' => $row['id'],
				'topic_topic' => $row['topic_topic'],
				'topic_content' => $row['topic_content'],
				'topic_added' => $row['topic_added'],
				'kayttaja_id' => $row['kayttaja_id'],
				'category_id' => $row['category_id']
				));
		}
		return $topics;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Topic WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$topic = new Topic(array(
				'id' => $row['id'],
				'topic_topic' => $row['topic_topic'],
				'topic_content' => $row['topic_content'],
				'topic_added' => $row['topic_added'],
				'kayttaja_id' => $row['kayttaja_id'],
				'category_id' => $row['category_id']
				));
			return $topic;
		}
		return null;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Topic (topic_topic, topic_content, topic_added, kayttaja_id) VALUES (:topic_topic, :topic_content, NOW(), :kayttaja_id) RETURNING id');
		$query->execute(array('topic_topic' => $this->topic_topic, 'topic_content' => $this->topic_content, 'kayttaja_id' => $this->kayttaja_id));
		$row = $query->fetch();

		//Kint::trace();
		//Kint::dump($row);

		$this->id = $row['id'];
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Topic SET topic_content = :content WHERE id = :id');
		$query->execute(array('content' => $this->topic_content, 'id' => $this->id));
		$row = $query->fetch();
	}

	public function destroy(){
		$query = DB::connection()->prepare('DELETE FROM Topic WHERE id = :id');
		$query->execute(array('id' => $this->id));
		$query->fetch();
	}

	public function getAllTopicInfo($id){
		$query = DB::connection()->prepare('SELECT Topic.topic_topic, Topic.topic_content, Topic.topic_added, Kayttaja.user_name AS user_name
			FROM Topic
			INNER JOIN Kayttaja
			ON Topic.kayttaja_id = Kayttaja.id
			WHERE topic.id = :id');
		$query->execute(array('id' => $id));
		$taulu = $query->fetch();
		return $taulu;
	}

}