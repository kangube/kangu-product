<?php

require_once('class.dbconfig.php');

class Vote
{	
	private $m_iUserId;
	private $m_iReviewId;

	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'UserId':
				$this->m_iUserId = $p_sValue;
				break;

			case 'ReviewId':
				$this->m_iReviewId = $p_sValue;
				break;
		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'UserId':
				return $this->m_iUserId;
				break;

			case 'ReviewId':
				return $this->m_iReviewId;
				break;
		}
	}
	
	public function Vote() {
		$conn = Db::getInstance();
		$vote_query = "INSERT INTO tbl_upvote(fk_user_id, fk_review_id) VALUES ('$this->UserId', '$this->ReviewId');";
	   	$statement = $conn->prepare($vote_query);
		$statement->execute();
	}

	public function HasVoted() {
		$user_has_voted = $this->conn->prepare("SELECT * from tbl_upvote WHERE fk_user_id=$this->UserId AND fk_review_id=$this->ReviewId");
		$user_has_voted->execute();
		if($user_has_voted->rowCount() == 1) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>