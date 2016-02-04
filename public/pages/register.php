<?php
session_start();
require_once('../php-assets/class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['register-button']))
{
	$user_first_name = strip_tags($_POST['user-first-name']);
	$user_last_name = strip_tags($_POST['user-last-name']);
	$user_email = strip_tags($_POST['user-email']);
	$user_password = strip_tags($_POST['user-password']);
	
	if($user_first_name=="")	{
		$error[] = "Vergeet je voornaam niet in te vullen.";	
	}
	else if($user_last_name=="")	{
		$error[] = "Vergeet je achternaam niet in te vullen.";	
	}
	else if($user_email=="")	{
		$error[] = "Vergeet je e-mail adres niet in te vullen.";	
	}
	else if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Geef een geldig e-mail adres in.';
	}
	else if($user_password=="")	{
		$error[] = "Kies een wachtwoord dat minstens 8 karakters lang is, 1 cijfer en 1 hoofdletter bevat.";
	}
	else if(strlen($user_password) < 8){
		$error[] = "Je wachtwoord moet minstens 8 karakters lang zijn.";	
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_firstname, user_email FROM tbl_user WHERE user_firstname=:user_first_name OR user_email=:user_email");
			$stmt->execute(array(':user_first_name'=>$user_first_name, ':user_email'=>$user_email));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['user_email']==$user_email) {
				$error[] = "Er is al een account aangemaakt met dit e-mail adres.";
			}
			else
			{
				if($user->register($user_first_name,$user_last_name,$user_email,$user_password)){	
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
<html class="no-js" lang="nl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Account aanmaken</title>
		<link rel="stylesheet" href="../css/minimum-viable-product.min.css">
	</head>

	<body>
		<div class="full-width">
			<div class="half-height-gradient"></div>

			<div class="row">
				<div class="large-10 medium-11 small-12 small-centered columns registration-panel" data-equalizer data-equalize-on="large">

					<div class="large-5 columns registration-introduction-panel show-for-large" data-equalizer-watch>
						<h1 class="introduction-header">Vind de ideale naschoolse opvang</h1>
						<p class="introduction-paragraph">Kangu is een online platform waarbinnen jonge ouders naschoolse opvang kunnen zoeken of aanbieden.</p>

						<p class="introduction-paragraph">Ben je op zoek naar een geschikte naschoolse opvangplaats voor uw kinderen? of wil je toch eerder opvang aanbieden om andere ouders te helpen en zo wat bij te verdienen? Maak dan gratis een account aan en krijg toegang tot het platform!</p>

						<ul class="introduction-social-links-list">
							<li>
								<a href="https://www.facebook.com/Kangu-1659271094353142/" class="icon">
									<svg version="1.1" viewBox="0 0 40 40" enable-background="new 0 0 35 35" xml:space="preserve">
				                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M26,19.2h-3.5c0,5,0,11.7,0,11.7h-5c0,0,0-6.6,0-11.7h-3.3v-3.3h3.3v-1.9c0-1.8,0.6-4.7,4.4-4.7l3.9,0v3.8c0,0-1.9,0-2.3,0c-0.4,0-1,0.2-1,1.1v1.7h3.9L26,19.2z"/>
				                    </svg>
								</a>
							</li>

							<li>
								<a href="https://twitter.com/kangu_be" class="icon">
									<svg viewBox="0 0 40 40" enable-background="new 0 0 35 35" xml:space="preserve">
				                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M28.8,15.6c0,0.2,0,0.4,0,0.6
				                        c0,5.8-4.4,12.5-12.5,12.5c-2.5,0-4.8-0.7-6.7-2c2.3,0.3,4.6-0.3,6.5-1.8c-1.9,0-3.5-1.3-4.1-3c0.7,0.1,1.3,0.1,2-0.1c-2-0.4-3.5-2.2-3.5-4.3c0,0,0,0,0-0.1c0.6,0.3,1.3,0.5,2,0.5c-1.2-0.8-2-2.1-2-3.7c0-0.8,0.2-1.6,0.6-2.2c2.2,2.7,5.4,4.4,9,4.6C20,16.4,20,16,20,15.7c0-2.4,2-4.4,4.4-4.4c1.3,0,2.4,0.5,3.2,1.4c1-0.2,3.3-0.4,3.3-0.4C30.2,13.1,29.6,15,28.8,15.6z"/>
				                    </svg>
								</a>
							</li>

							<li>
								<a href="mailto:info@kangu.be" class="icon">
				                    <svg viewBox="0 0 40 40" enable-background="new 0 0 35 35" xml:space="preserve">
				                        <path d="M20,0C9,0,0,9,0,20s9,20,20,20s20-9,20-20S31,0,20,0z M9.2,17.4l7.2,3.7l-7.2,4.3V17.4z
				                         M30.8,29.2H9.2v-1.8l8.9-5.3l1.9,1l1.9-1l8.9,5.2V29.2z M30.8,25.4l-7.2-4.2l7.2-3.7V25.4z M30.8,15.7L20,21.3L9.2,15.7v-2.8h21.7V15.7z"/>
				                    </svg>
				                </a>
			                </li>
						</ul>
					</div>

					<div class="large-7 columns registration-input-panel" data-equalizer-watch>
						<h1 class="registration-header">Account aanmaken</h1>
						<hr class="blue-horizontal-line"></hr>

						<form method="post" novalidate>
							<div class="row">
								<div class="large-6 medium-6 small-12 columns">
									<input type="text" placeholder="jouw voornaam" name="user-first-name" required>
								</div>

								<div class="large-6 medium-6 small-12 columns">
									<input type="text" placeholder="jouw achternaam" name="user-last-name" required>
								</div>

								<div class="large-12 columns">
									<input type="email" placeholder="jouw e-mail adres" name="user-email" required>
									<input type="password" placeholder="Kies een wachtwoord" name="user-password" required>
									
									<?php
										if(isset($error)) {
											foreach($error as $error) { ?>
												<div class="large-12 columns error-callout">
													<?php echo $error; ?>
												</div>
									  <?php }
										} else if(isset($_GET['joined'])) { ?>
											<!-- A redirect to the advert overview-page must go here -->
								  <?php } else { ?>
								  				<p class="terms_conditions">Door een account aan te maken ga je akkoord met onze <a href="#">termen en condities<a>.</p>
								  <?php } ?>

									<input type="submit" class="create-account-btn" value="Account aanmaken" name="register-button">
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