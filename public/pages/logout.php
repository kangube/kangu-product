<?php
	require_once('../php-assets/class.session.php');
	require_once('../php-assets/class.user.php');
	
	$user_logout = new USER();
	
	session_destroy();
	$user_logout->redirect('login.php');
?>
