<?php
	include_once("Db.class.php");
	class Date
	{
		
		private $m_sDate;
		private $m_sTimeStart;
		private $m_sTimeEnd;

		public function __set($p_sProperty, $p_sValue)
		{
			switch ($p_sProperty) 
			{
				case 'Date':
					if(empty($p_sValue))
						{
							throw new Exception("Date cannot be empty");
						}
					else 
						{
							$this->m_sDate = $p_sValue;
						};
					break;

				case 'TimeStart':
					if(empty($p_sValue))
						{
							throw new Exception("Time cannot be empty");
						}
					else 
						{
							$this->m_sTimeStart = $p_sValue;
						};
					break;

				case 'TimeEnd':
					if(empty($p_sValue))
						{
							throw new Exception("Time cannot be empty");
						}
					else 
						{
							$this->m_sTimeEnd = $p_sValue;
						};
					break;
			}
		}

		public function __get($p_sProperty)
		{
			switch ($p_sProperty) 
			{
				case 'Date':
					return $this->m_sDate;
					break;
			}
			switch ($p_sProperty) 
			{
				case 'TimeStart':
					return $this->m_sTimeStart;
					break;
			}
			switch ($p_sProperty) 
			{
				case 'TimeEnd':
					return $this->m_sTimeEnd;
					break;
			}
		}

		public function Save()
		{
			$conn = Db::getInstance();
			//$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("INSERT INTO tbl_availability
				(availability_date, availability_time_start, availability_time_end) 
				VALUES 
				(:availability_date, :availability_time_start, :availability_time_end)");
			$statement->bindValue(':availability_date', $this->Date );
			$statement->bindValue(':availability_time_start', $this->TimeStart );
			$statement->bindValue(':availability_time_end', $this->TimeEnd );
			$statement->execute();

			//echo "gelukt";
		}

	}
?>