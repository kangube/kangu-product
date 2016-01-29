<?php
session_start();
include_once '../php-includes/dbconnect.php';

if(isset($_SESSION['userSession'])!="")
{
	header("Location: home.php");
	exit;
}

if(isset($_POST['btn-login']))
{
	$email = $MySQLi_CON->real_escape_string(trim($_POST['user_email']));
	$upass = $MySQLi_CON->real_escape_string(trim($_POST['user_password']));
	
	$query = $MySQLi_CON->query("SELECT user_id, user_email, user_password FROM tbl_user WHERE user_email='$email'");
	$row=$query->fetch_array();
	
	if(password_verify($upass, $row['user_password']))
	{
		$_SESSION['userSession'] = $row['user_id'];
		header("Location: home.php");
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; email or password does not exists !
				</div>";
	}
	
	$MySQLi_CON->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>
<body>
	<div class="signin-form">

		<div class="container">
	     
	        
	       <form class="form-signin" method="post" id="login-form">
	      
	        <h2 class="form-signin-heading">Login</h2>
	        
	        <?php
			if(isset($msg)){
				echo $msg;
			}
			?>
	        
	        <div class="form-group">
	        	<input type="email" class="form-control" placeholder="Email address" name="user_email" required />
	        </div>
	        
	        <div class="form-group">
	        	<input type="password" class="form-control" placeholder="Password" name="user_password" required />
	        </div>
	        
	        <div class="form-group">
	            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">Login</button>             
	        </div>  
	 
	      </form>
	      <a href="register.php"><button>Register</button></a>
	    </div>    
	</div>
</body>
</html>