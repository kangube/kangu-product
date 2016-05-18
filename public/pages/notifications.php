<?php
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.notification.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	//echo $userRow['user_firstname'].' '.$userRow['user_lastname'];

	$n1 = new Notification();
  $getAllNotifications = $n1->getAllNotifications();

  if(!empty($_POST['delete']))
  {
    try 
    { 
      $n1->NotificationID = $_POST['id'];
      
      $n1->DeleteNotification();
    }
    catch(Exception $e)
    {
      $error = $e->getMessage();
    }
  }

  if(!empty($_POST['read']))
  {
    try 
    { 
      $n1->NotificationID = $_POST['id'];
      
      $n1->ReadNotification();
    }
    catch(Exception $e)
    {
      $error = $e->getMessage();
    }
  }

  if(!empty($_POST['acceptbooking']))
  {
    try 
    { 
      $n1->BookingID = $_POST['bookingid'];
      
      $n1->AcceptBooking();
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

		<?php

			while($notification = $getAllNotifications->fetch(PDO::FETCH_ASSOC))
        	{                 
          		if ($notification['fk_user_id'] == $userRow['user_id']) {
          			if ($notification['notification_status'] == 'unread') {
          				if ($notification['notification_type'] == 'accept') {
                    echo "<form action='' method='post'>";
                    echo "NEW NOTIFICATION<br/>";
            				echo $notification['notification_date'];
            				echo "<br/>";
            				echo $notification['notification_message'];
                    echo "<input type='hidden' name='id' value='".$notification['notification_id']."' />";
                    echo "<input type='hidden' name='bookingid' value='".$notification['notification_fk_booking_id']."' />";
                    if ($notification['booking_status'] == 'pending') {
                      echo "<input type='submit' name='acceptbooking' value='Accepteer boeking' />";
                    }elseif ($notification['booking_status'] == 'accepted') {
                      echo "<input type='submit' value='Boeking is geaccepteerd' disabled/>";
                    }
                    echo "<input type='submit' name='delete' value='Delete notification' />";
                    echo "<input type='submit' name='read' value='Mark as read' />";
            				echo "<br/>";
            				echo "<br/>";
                    echo "</form>";
                  }elseif ($notification['notification_type'] == 'review') {
                    echo "<form action='' method='post'>";
                    echo "NEW NOTIFICATION<br/>";
                    echo $notification['notification_date'];
                    echo "<br/>";
                    echo $notification['notification_message'];
                    echo "<a href='review.php?id=".$notification['fk_advert_id']."'>Review schrijven</a>";
                    echo "<input type='hidden' name='id' value='".$notification['notification_id']."' />";
                    echo "<input type='submit' name='delete' value='Delete notification' />";
                    echo "<input type='submit' name='read' value='Mark as read' />";
                    echo "<br/>";
                    echo "<br/>";
                    echo "</form>";
                  }
          			}else {
          				if ($notification['notification_type'] == 'accept') {
                    echo "<form action='' method='post'>";
                    echo $notification['notification_date'];
                    echo "<br/>";
                    echo $notification['notification_message'];
                    if ($notification['booking_status'] == 'pending') {
                      echo "<input type='submit' name='acceptbooking' value='Accepteer boeking' />";
                    }elseif ($notification['booking_status'] == 'accepted') {
                      echo "<input type='submit' value='Boeking is geaccepteerd' disabled/>";
                    }
                    echo "<input type='hidden' name='id' value='".$notification['notification_id']."' />";
                    echo "<input type='submit' name='delete' value='Delete notification' />";
                    echo "<br/>";
                    echo "<br/>";
                    echo "</form>";
                  }elseif ($notification['notification_type'] == 'review') {
                    echo "<form action='' method='post'>";
                    echo $notification['notification_date'];
                    echo "<br/>";
                    echo $notification['notification_message'];
                    echo "<a href='review.php?id=".$notification['fk_advert_id']."'>Review schrijven</a>";
                    echo "<input type='hidden' name='id' value='".$notification['notification_id']."' />";
                    echo "<input type='submit' name='delete' value='Delete notification' />";
                    echo "<br/>";
                    echo "<br/>";
                    echo "</form>";
                  }
          			}
          		}
        	}

		?>


		<?php include('../php-includes/footer.php'); ?>
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>