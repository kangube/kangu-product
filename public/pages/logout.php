<?php
	require_once('../php-assets/class.session.php');
	require_once('../php-assets/class.user.php');
	
	$user_logout = new USER();
	
	/*
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('login.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('login.php');
	}*/

	// Voorwa al die moeite als alles wa ge moet doen is een sessie wegdoen?
	// De eerste if werkt al ni omda ge zegt als de user ingelogd is, da ge af de pagina moet en ni moogt uitloggen
	// De tweede if moet ten eerste al nen if else zijn en al die hassle moet er ni zijn want ge hebt maar 2 lijnen code nodig

	session_destroy();
	$user_logout->redirect('login.php');

