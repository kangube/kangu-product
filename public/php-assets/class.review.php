<?php

require_once('class.dbconfig.php');

class Review
{	
	private $m_sAdvertID;
	private $m_sUserID;
	private $m_sRating;
	private $m_sDescription;

	private $conn;
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'AdvertID':
				$this->m_sAdvertID = $p_sValue;
				break;

			case 'UserID':
				$this->m_sUserID = $p_sValue;
				break;

			case 'Rating':
				$this->m_sRating = $p_sValue;
				break;

			case 'Description':
				$this->m_sDescription = $p_sValue;
				break;

		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'AdvertID':
				return $this->m_sAdvertID;
				break;

			case 'UserID':
				return $this->m_sUserID;
				break;

			case 'Rating':
				return $this->m_sRating;
				break;

			case 'Description':
				return $this->m_sDescription;
				break;

		}
	}

	public function createReview() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("INSERT INTO tbl_review
			(fk_advert_id, fk_user_id, review_rating, review_description, review_date) 
			VALUES (:advertid, :userid, :rating, :description, CURDATE())");
		$statement->bindValue(':advertid', $this->AdvertID );
		$statement->bindValue(':userid', $this->UserID );
		$statement->bindValue(':rating', $this->Rating );
		$statement->bindValue(':description', $this->Description );
		$statement->execute();
	}

}
?>