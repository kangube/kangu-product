<?php

	class Db 
	{
		private static $db; //static = wijzigt niet per object

		public static function getInstance()
		{
			//static = geen object nodig om aan te roepen
			if(self::$db != null)
			{
				//echo "no new connection";
				return self::$db;
			}
			else
			{
				//echo "new connection";
				self::$db = new PDO('mysql:host=localhost; dbname=kangu-product', 'root', 'root');
				return self::$db;
			}
		}
	}

?>