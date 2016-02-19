<?php
	//include_once("../php-assets/class.session.php");
	include_once("../php-assets/class.user.php");
	//include_once("../php-assets/class.advert.php");
	
	/*
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	*/
	
	$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kangu-product";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}





	if(isset($_POST['SubmitButton']))
	{ 
		if(isset($_POST['descending']) && $_POST['descending'] == 'checked') 
		{
	    	echo "Allebei aangevinkt";
	    	$sql = "SELECT advert_id, advert_name FROM tbl_advert DESC";
			$result = mysqli_query($conn, $sql);

			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) 
			    {
			        echo "id: " . $row["advert_id"]. " - Name: " . $row["advert_name"]. "<br>";
			    }
			
		}	
	} 

mysqli_close($conn); 
?>
<html>
<head>
	<title>Alle advertenties</title>
	<script type="text/javascript" src="//code.jquery.com/jquery-2.2.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{

			//-----------
			$("#results" ).load( "../php-assets/class.pagination.php"); //load initial records

    		$("#hide").click(function(e) {
        		$("#results").hide();
        		$("#searchresults").show();

    		});
			//executes code below when user click on pagination links
			$("#results").on( "click", ".pagination a", function (e)
			{
				e.preventDefault();
				$(".loading-div").show(); //show loading element
				var page = $(this).attr("data-page"); //get page number from link
				$("#results").load("../php-assets/class.pagination.php",{"page":page}, function()
				{ //get content from PHP page
					$(".loading-div").hide(); //once done, hide loading element
				});
			});
		});
</script>
<style>
.loading-div{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.56);
	z-index: 999;
	display:none;
}
.loading-div img {
	margin-top: 20%;
	margin-left: 50%;
}

/* Pagination style */
.pagination{margin:0;padding:0;}
.pagination li{
	display: inline;
	padding: 6px 10px 6px 10px;
	border: 1px solid #ddd;
	margin-right: -1px;
	font: 15px/20px Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	box-shadow: inset 1px 1px 5px #F4F4F4;
}
.pagination li a{
    text-decoration:none;
    color: rgb(89, 141, 235);
}
.pagination li.first {
    border-radius: 5px 0px 0px 5px;
}
.pagination li.last {
    border-radius: 0px 5px 5px 0px;
}
.pagination li:hover{
	background: #CFF;
}
.pagination li.active{
	background: #F0F0F0;
	color: #333;
}
</style>
</head>
<body>
<div id="container">
	<h5>welcome : <?php //echo $userRow['user_email']; ?></h5>
  	<a href='logout.php'>Log out</a>
  	
  	<br/>
  	
  	<a href="home.php"><button>Home</button></a>
  	<a href="advert_create.php"><button>Create an advert</button></a>
	<a href="advert.php"><button>See all adverts</button></a>
	
	<br/>
	<br/>
	
	<h3>Advertentie zoeken</h3>
	<form action="search.php" method="GET" name="search">
    	<label>Locatie</label><br/>
    	<input type="text" name="location" placeholder="Locatie" required />
    	<br/>
    	<label>Prijs in EUR</label><br/>
    	<input type="text" name="price" placeholder="Prijs" value="5" required>
    	<br/>
    	<label>Aantal kinderen</label><br/>
    	<input type="text" name="children" placeholder="Aantal kinderen" value="1" required
    	<br/>
    	<input type="submit" value="Search"/>
	</form>

	<br/>
	

	<h3>Alle advertenties</h3>
	<form action="" method="post">
  		<label>Descending</label>
  		<input type="checkbox" name="descending" value="checked"/>
  		<br/>
  		<input type="submit" name="SubmitButton" value="Filter"/>
	</form>  

	<div class="loading-div"><img src="../assets/ajax-loader.gif" ></div>
	<div id="results"><!-- database content will be loaded here --></div>

</div>
</body>
</html>