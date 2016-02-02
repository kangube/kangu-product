<?php
session_start();
require_once('../php-assets/class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);	
	
	if($uname=="")	{
		$error[] = "provide username !";	
	}
	else if($umail=="")	{
		$error[] = "provide email id !";	
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please enter a valid email address !';
	}
	else if($upass=="")	{
		$error[] = "provide password !";
	}
	else if(strlen($upass) < 6){
		$error[] = "Password must be atleast 6 characters";	
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_firstname, user_email FROM tbl_user WHERE user_firstname=:uname OR user_email=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['user_firstname']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($row['user_email']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($uname,$umail,$upass)){	
					$user->redirect('register.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Account aanmaken</title>

		<!-- Required css and js files -->

		<link rel="stylesheet" href="../css/minimum-viable-product.min.css">
	</head>

	<body>

	<!--<div class="signin-form">

	<div class="container">
	    	
	        <form method="post" class="form-signin">
	            <h2 class="form-signin-heading">Register</h2>
	            <?php
				//if(isset($error))
				{
				 	//foreach($error as $error)
				 	{
						 ?>
	                     <div class="alert alert-danger">
	                        <?php //echo $error; ?>
	                     </div>
	                     <?php
					}
				}
				//else if(isset($_GET['joined']))
				{
					 ?>
	                 <div class="alert alert-info">
	                      Successfully registered! <a href='login.php'>login</a> here
	                 </div>
	                 <?php
				}
				?>
	            <div class="form-group">
	            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Firstname" value="<?php //if(isset($error)){echo $uname;}?>" />
	            </div>
	            <div class="form-group">
	            <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail" value="<?php //if(isset($error)){echo $umail;}?>" />
	            </div>
	            <div class="form-group">
	            	<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary" name="btn-signup">
	                	Register
	                </button>
	            </div>
	            <br />
	            <label><a href="login.php">Login</a></label>
	        </form>
	       </div>
	</div>

	</div>-->

	<div class="full-width">
		<div class="row">
			<div class="large-10 small-centered columns registration-panel">

				<div class="large-4 columns registration-introduction-panel">
					<h1>Vind de ideale naschoolse opvang</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

					<div class="social-links-container">
						<a href="https://www.facebook.com/Kangu-1659271094353142/" class="icon">
							<svg version="1.1" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
		                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M26,19.2h-3.5c0,5,0,11.7,0,11.7h-5c0,0,0-6.6,0-11.7h-3.3v-3.3h3.3v-1.9c0-1.8,0.6-4.7,4.4-4.7l3.9,0v3.8c0,0-1.9,0-2.3,0c-0.4,0-1,0.2-1,1.1v1.7h3.9L26,19.2z"/>
		                    </svg>
						</a>

						<a href="https://twitter.com/kangu_be" class="icon">
							<svg viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
		                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M28.8,15.6c0,0.2,0,0.4,0,0.6
		                        c0,5.8-4.4,12.5-12.5,12.5c-2.5,0-4.8-0.7-6.7-2c2.3,0.3,4.6-0.3,6.5-1.8c-1.9,0-3.5-1.3-4.1-3c0.7,0.1,1.3,0.1,2-0.1c-2-0.4-3.5-2.2-3.5-4.3c0,0,0,0,0-0.1c0.6,0.3,1.3,0.5,2,0.5c-1.2-0.8-2-2.1-2-3.7c0-0.8,0.2-1.6,0.6-2.2c2.2,2.7,5.4,4.4,9,4.6C20,16.4,20,16,20,15.7c0-2.4,2-4.4,4.4-4.4c1.3,0,2.4,0.5,3.2,1.4c1-0.2,3.3-0.4,3.3-0.4C30.2,13.1,29.6,15,28.8,15.6z"/>
		                    </svg>
						</a>

						<a href="mailto:info@kangu.be" class="icon">
		                    <svg viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
		                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M9.2,17.4l7.2,3.7l-7.2,4.3V17.4z
		                         M30.8,29.2H9.2v-1.8l8.9-5.3l1.9,1l1.9-1l8.9,5.2V29.2z M30.8,25.4l-7.2-4.2l7.2-3.7V25.4z M30.8,15.7L20,21.3L9.2,15.7v-2.8h21.7V15.7z"/>
		                    </svg>
		                </a> 
					</div>
				</div>

				<div class="large-8 columns registration-input-panel">
					<h1>Account aanmaken</h1>
					<hr></hr>

					<form method="post" class="form-signin">
						<div class="row">
							<div class="large-6 medium-6 small-12 columns">
								<input type="text" placeholder="jouw voornaam">
							</div>

							<div class="large-6 medium-6 small-12 columns">
								<input type="text" placeholder="jouw achternaam">
							</div>

							<div class="large-12 medium-12 small-12 columns">
								<input type="email" placeholder="jouw e-mail adres">
								<input type="password" placeholder="Kies een wachtwoord">

								<p class="terms_conditions">Door een account aan te maken ga je akkoord met onze termen en condities.</p>
							</div>

							<div class="large-12 medium-12 small-12 columns">
								<input type="submit" class="create-account-btn" value="Account aanmaken">
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

		<script src="../js/minimum-viable-product.min.js"></script>
		<script src="https://use.typekit.net/vnw3zje.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>