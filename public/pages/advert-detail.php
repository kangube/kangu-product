<?php
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.pagination-reviews.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$oneAdvert = $advert->getOne();
	$advert_information = $oneAdvert->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
        <link href="https://file.myfontastic.com/wfY5TXHecmqLMkPUKHzNrK/icons.css" rel="stylesheet">
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4&callback=initMap"></script>
        <title>Alle advertenties</title>
		<script type="text/javascript" src="//code.jquery.com/jquery-2.2.0.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{

				//-----------
				$("#reviews" ).load( "../php-assets/class.pagination-reviews.php"); //load initial records

	    		$("#hide").click(function(e) {
	        		$("#reviews").hide();

	    		});
				//executes code below when user click on pagination links
				$("#reviews").on( "click", ".pagination a", function (e)
				{
					e.preventDefault();
					$(".loading-div").show(); //show loading element
					var page = $(this).attr("data-page"); //get page number from link
					$("#reviews").load("../php-assets/class.pagination-reviews.php",{"page":page}, function()
					{ //get content from PHP page
						$(".loading-div").hide(); //once done, hide loading element
					});
				});
			});
		</script>
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="small-12 columns advert-detail-header">
	        <div class="advert-detail-title-container">
	        	<img src=<?php echo $advert_information['user_image_path']; ?> alt="profiel foto" />
	            <h1 class="advert-detail-title"><?php echo $advert_information["user_firstname"]." ".$advert_information["user_lastname"]; ?></h1>
	            <h3 class="advert-detail-subtitle">Ouder van Floor en Kilian</h3>
	        </div>
        </div>
        <div class="row">
	        <div class="small-12 columns advert-detail-button-container">
	        	<a class="small-7 medium-5 large-3 small-centered columns boeking-button" href="#">Boeking aanvragen</a>
	        </div>
	    </div>
	    <div class="row small-collapse">
		    <div class="small-10 small-centered medium-12 medium-uncentered large-12 columns advert-detail-calendar">
			    <div class="small-12 medium-6 large-6 columns">
			    	<h2>Over deze advertentie</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    	<p><?php echo $advert_information["advert_description"]; ?></p>
					<div class="small-12 medium-6 large-6 columns">
			    		<div class="border-right">
				    		<span data-icon="e"></span>
				    		<p>Basisschool <?php echo $advert_information["advert_school"]; ?></p>
				    		<span data-icon="o"></span>
				    		<p>Plaats voor <?php echo $advert_information["advert_spots"]; ?> kinderen</p>
			    		</div>
			    	</div>
			    	<div class="small-12 medium-6 large-6 columns">
			    		<span data-icon="m"></span>
			    		<p>Tussen 5 - <?php echo $advert_information["advert_price"]; ?> euro per uur</p>
			    		<span data-icon="k"></span>
			    		<p>Verplaatsing met <?php echo $advert_information["advert_transport"]; ?></p>
			    	</div>
			    </div>
			    <div class="small-12 medium-6 large-6 columns">
			    	<h2>Beschikbaarheid</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    	<table class="small-12 columns">
				    	<thead>
							<tr>
								<th class="weekdagen" colspan="7">Februari 2016</th>
							</tr>
							<tr class="hide-for-small-only">
								<td class="weekdagen">Maandag</td>
								<td class="weekdagen">Dinsdag</td>
								<td class="weekdagen">Woensdag</td>
								<td class="weekdagen">Donderdag</td>
								<td class="weekdagen">Vrijdag</td>
							</tr>
							<tr class="hide-for-medium">
								<td class="weekdagen">Ma</td>
								<td class="weekdagen">Di</td>
								<td class="weekdagen">Wo</td>
								<td class="weekdagen">Do</td>
								<td class="weekdagen">Vr</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
							</tr>
							<tr>
								<td>8</td>
								<td>9</td>
								<td>10</td>
								<td>11</td>
								<td>12</td>
							</tr>
							<tr>
								<td>15</td>
								<td>16</td>
								<td>17</td>
								<td>18</td>
								<td>19</td>
							</tr>
							<tr>
								<td>22</td>
								<td>23</td>
								<td>24</td>
								<td>25</td>
								<td>26</td>
							</tr>
							<tr>
								<td>29</td>
								<td>1</td>
								<td>2</td>
								<td>3</td>
								<td>4</td>
							</tr>
						</tbody>
					</table>
			    </div>
		  	</div>
		</div>
		<div class="row small-collapse">
		    <div class="small-10 small-centered medium-12 medium-uncentered large-12 columns advert-detail-map">
				<div class="small-12 medium-5 large-3 columns">
			    	<h2>Contact informatie</h2>
			    	<hr class="blue-horizontal-line"></hr>

			    	<span data-icon="x"></span>
			    	<p><?php echo $advert_information["user_email"]; ?></p>
			    	<span data-icon="z"></span>
			    	<p><?php echo "+32 " . $advert_information["user_mobile_number"]; ?></p>
			    	<span data-icon="q"></span>
			    	<p><?php echo "+32 " . $advert_information["user_home_number"]; ?></p>
			    	<span class="double-line-height" data-icon="v"></span>
			    	<p><?php echo $advert_information["user_adress"] . "<br>" . $advert_information["user_city"]; ?></p>
				</div>
				<div class="small-12 medium-7 large-9 columns">
					<!--<iframe
					  frameborder="0" style="border:0"
					  src=<?php echo "https://www.google.com/maps/embed/v1/place?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4
					    &q=" . $advert_information["user_adress"] . "," . $advert_information["user_city"];?> allowfullscreen>
					</iframe>-->
					<iframe
					  frameborder="0" style="border:0"
					  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4
					    &q=akkerstraat,lier" allowfullscreen>
					</iframe>	
				</div>
		    </div>
		</div>

		<div class="row small-collapse advert-detail-services">
		    <div class="small-10 small-centered medium-12 medium-uncentered large-12 columns">
				<div class="small-12 columns">
			    	<h2>Aangeboden diensten</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>
			</div>
			<div class="small-10 small-centered medium-12 medium-uncentered large-12 columns">
				<div class="large-4 columns end">
					<div class="border-right">
				    	<span class="extra" data-icon="m"></span>
				    	<p>Opvang in een thuisomgeving</p>
				    	<span class="extra" data-icon="m"></span>
				    	<p>Ophalen aan de schoolpoort</p>
					</div>
				</div>
				<div class="large-4 columns">
			    	<div class="large-10 large-centered columns mrglnul">
				    	<span class="extra" data-icon="m"></span>
				    	<p>Vervoer naar thuis na opvang</p>
				    	<span class="extra" data-icon="m"></span>
				    	<p>Vervoer naschoolse activiteiten</p>
				    </div>
				</div>
				<div class="large-4 columns border-left">
			    	<div class="large-10 columns float-right mrgrnul">
				    	<span class="extra" data-icon="m"></span>
				    	<p>Voorzien van een maaltijd</p>
				    	<span class="extra" data-icon="m"></span>
				    	<p>Hulp bij huiswerk taken</p>
				    </div>
				</div>
		    </div>
		</div>

		<div class="row small-collapse advert-detail-ratings">
		    <div class="small-10 small-centered medium-12 medium-uncentered large-12 columns">
				<div class="small-12 columns">
			    	<h2>Ratings &amp; reviews</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

			    <div class="small-12 medium-12 large-12 columns small-collapse">
			    	<div id="reviews"></div>
			    </div>
			    </div>
			</div>
		</div>

		<div class="test">
		<div class="row large-collapse advert-detail-container">
	    	<div class="large-12 small-centered columns">
			    <div class="large-12 columns">
			    	<h2>Vergelijkbare advertenties</h2>
			    	<hr class="red-horizontal-line"></hr>
			    </div>
			    <?php
					$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE tbl_advert.advert_school = '". $advert_information['advert_school']."' LIMIT 3");
					$advert_results->execute();
					$advert_results->bind_result($advert_id, $advert_creator, $advert_description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city);

					while($advert_results->fetch()) 
					{
						$shorten = strpos($advert_description, ' ', 145);
						$final_advert_description = substr($advert_description, 0, $shorten)." ...";

						echo "
							<div class='advert-container columns end'>
							  	<a href='advert-detail.php?id=".$advert_id."' class='advert-link'>
									<div class='advert'>
						    			<div class='small-12 columns'>
							    			<div class='small-2 columns'>
							    				<img class='advert-profile-image' src='".$user_profile_image."'>
							    			</div>
							    			
							    			<div class='small-10 columns'>
								    			<ul class='advert-information-list'>
								    				<li>".$user_first_name.' '.$user_last_name."</li>
								    				<li data-icon='d'>".$user_city."</li>
								    			</ul>
							    			</div>
						    			</div>

										<p class='advert-description'>".$final_advert_description."</p>
						
						    			<div class='small-6 columns'>
							    			<div class='advert-price'>
								    			<p>".$advert_price."</p>
								    			<p>p/u</p>
							    			</div>
							    		</div>

							    		<div class='small-6 columns'>
							    			<div class='advert-spots'>
							    				<p>".$advert_spots."</p>
								    			<p>plaatsen</p>
							    			</div>
							    		</div>
				    	
							    		<p class='advert-school' data-icon='e'>Basisschool ".$advert_school."</p>
						    		</div>
						    	</a>
					    	</div>
					    ";
					}    
				?>
		    </div>
		</div>
		</div>
		
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>