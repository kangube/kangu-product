<?php
session_start();
if(isset($_SESSION['userSession'])!="")
{
	header("Location: home.php");
}
include_once '../php-includes/dbconnect.php';

if(isset($_POST['btn-signup']))
{
	$uname = $MySQLi_CON->real_escape_string(trim($_POST['user_firstname']));
	$email = $MySQLi_CON->real_escape_string(trim($_POST['user_email']));
	$upass = $MySQLi_CON->real_escape_string(trim($_POST['user_password']));
	
	$new_password = password_hash($upass, PASSWORD_DEFAULT);
	
	$check_email = $MySQLi_CON->query("SELECT user_email FROM tbl_user WHERE user_email='$email'");
	$count=$check_email->num_rows;
	
	if($count==0){
		
		
		$query = "INSERT INTO tbl_user(user_firstname,user_email,user_password) VALUES('$uname','$email','$new_password')";

		
		if($MySQLi_CON->query($query))
		{
			$msg = "<div class='alert alert-success'>
						Successfully registered !
					</div>";
		}
		else
		{
			$msg = "<div class='alert alert-danger'>
						Error while registering !
					</div>";
		}
	}
	else{
		
		
		$msg = "<div class='alert alert-danger'>
					Sorry, email already taken !
				</div>";
			
	}
	
	$MySQLi_CON->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
</head>

<body>
	<div class="signin-form">

		<div class="container">
	     
	        
	       <form class="form-signin" method="post" id="register-form">
	      
	        <h2 class="form-signin-heading">Register</h2>
	        
	        <?php
			if(isset($msg)){
				echo $msg;
			}
			else{
				?>
	            <div class='alert alert-info'>
					All the fields are mandatory !
				</div>
	            <?php
			}
			?>
	          
	        <div class="form-group">
	        	<input type="text" class="form-control" placeholder="First name" name="user_firstname" required  />
	        </div>
	        
	        <div class="form-group">
	        	<input type="email" class="form-control" placeholder="Email address" name="user_email" required  />
	        </div>
	        
	        <div class="form-group">
	        	<input type="password" class="form-control" placeholder="Password" name="user_password" required  />
	        </div>
	        
	        <div class="form-group">
	            <button type="submit" class="btn btn-default" name="btn-signup">Create Account</button>    
	        </div> 
	      
	      </form>
		<a href="login.php"><button>Login</button></a>  
	    </div>
	    
	</div>
</body>
</html>