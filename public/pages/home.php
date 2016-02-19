<?php

	require_once("../php-assets/class.session.php");	
	require_once("../php-assets/class.user.php");
	
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>
  
  <h5>welcome : <?php echo $userRow['user_email']; ?></h5>
  <a href='logout.php'>Log out</a>
  <br/>
  <a href="home.php"><button>Home</button></a>
  <a href="advert_create.php"><button>Create an advert</button></a>
  <a href="advert.php"><button>See all adverts</button></a>

</body>
</html>