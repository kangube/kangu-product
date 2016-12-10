<?php
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.review.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$r1 = new Review();

  if(!empty($_POST['createReview']))
  {
    try 
    { 
      $r1->AdvertID = $_POST['advertID'];
      $r1->UserID = $_POST['userID'];
      $r1->Rating = $_POST['rating'];
      $r1->Description = $_POST['description'];
      
      $r1->createReview();
    }
    catch(Exception $e)
    {
      $error = $e->getMessage();
    }
  }

?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

    <form action="" method="post">
      <input type="hidden" name="advertID" value="<?php echo $_GET['id'];?>">
      <input type="hidden" name="userID" value="<?php echo $userRow['user_id'];?>">
      Rating
      <select name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      Beschrijving
      <input type="text" name="description" placeholder="Leg kort uit wat je van de boeking vondt">
      <input type="submit" name="createReview" value="Review">
    </form>


		<?php include('../php-includes/footer.php'); ?>
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>