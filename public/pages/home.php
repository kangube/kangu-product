<?php
session_start();
include_once '../php-includes/dbconnect.php';

if(!isset($_SESSION['userSession']))
{
	header("Location: index.php");
}

$query = $MySQLi_CON->query("SELECT * FROM tbl_user WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$MySQLi_CON->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['user_email']; ?></title>
</head>
<body>

Welkom, <?php echo $userRow['user_firstname']; ?>
<a href="logout.php?logout">Logout</a>

</body>
</html>