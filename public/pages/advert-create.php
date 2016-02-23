<?php 
	
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$a1 = new Advert();

	if(!empty($_POST))
	{
		try 
		{	
			
			$a1->ID = $_POST['ID'];
			$a1->Name = $_POST['name'];
			$a1->Info = $_POST['info'];

			$a1->Save();

			$succes = "Thank you for creating an advert!";


		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create an advert</title>
<link rel="stylesheet" type="text/css" media="all" href="css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/screen.css" />
</head>
<body>
<div>
	<h5>welcome : <?php echo $userRow['user_email']; ?></h5>
  	<a href='logout.php'>Log out</a>
  	<br/>
  	<a href="home.php"><button>Home</button></a>
  	<a href="advert_create.php"><button>Create an advert</button></a>
	<a href="advert.php"><button>See all adverts</button></a>

	<form method="post" action="">
		<fieldset>
		<legend>Create an advert</legend>
			<?php if(isset($error)): ?>
			<div class="error">
			<?php echo $error;?>
			</div>
			<?php endif; ?>

			<?php if(isset($succes)): ?>
			<div class="feedback">
			<?php echo $succes;?>
			</div>
			<?php endif; ?>

			<input type="text" id="ID" name="ID" 
			hidden value="<?php echo $userRow['user_id']; ?>"/>

			<label for="name">Name</label><br/>
			<input type="text" id="name" name="name"/>

			<br/>
			
			<label for="info">Info</label><br/>
			<input type="text" id="info" name="info"/>
	
			<br />
			<br />
		
			<input class="submit" type="submit" id="btnSubmit" value="Create advert" />
		</fieldset>
	</form>

</div>
</body>
</html>