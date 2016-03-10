<?php
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.advert.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$oneAdvert = $advert->getOne();
	$advert_information = $oneAdvert->fetch(PDO::FETCH_ASSOC);
	$simAdvert = $advert->getSimilar();
	$advert_similar = $simAdvert->fetch(PDO::FETCH_ASSOC);

	$similar_query = "SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.advert_school = '".$advert_similar['advert_school']."' WHERE tbl_advert.advert_id != " . $advert_similar['advert_id'].";";
	//echo $similar_query . "<br><br>";
	$conn = Db::getInstance();
	$similar_adverts = $conn->prepare($similar_query);
	$similar_adverts = $conn->execute();

	/*while($adverts = $similar_adverts)
	{
		echo "Advert price: ".$advert_similar["advert_price"]."<br />";
		echo "Advert school: ".$advert_similar["advert_school"]."<br /><br />";
		
	}*/
?>

<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
        <link href="https://file.myfontastic.com/wfY5TXHecmqLMkPUKHzNrK/icons.css" rel="stylesheet">
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMSIUIRS-lEyN5iRVhoCyvJ3FfVEdhE-s&callback=initMap"></script>
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="small-12 columns advert-detail-header">
	        <div class="advert-detail-title-container">
	        	<img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" />
	            <h1 class="advert-detail-title"><?php echo $advert_information["user_firstname"]." ".$advert_information["user_lastname"]; ?></h1>
	            <h3 class="advert-detail-subtitle">Ouder van Floor en Kilian</h3>
	        </div>
        </div>
        <div class="row">
	        <div class="small-12 columns advert-detail-container">
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
					<iframe src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyBMSIUIRS-lEyN5iRVhoCyvJ3FfVEdhE-s" frameborder="0" style="border:0" allowfullscreen></iframe>					
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
				<div class="large-4 columns">
					<div class="border-right">
				    	<span class="extra" data-icon="m"></span>
				    	<p>Opvang in een thuisomgeving</p>
				    	<span class="extra" data-icon="m"></span>
				    	<p>Ophalen aan de schoolpoort</p>
					</div>
				</div>
				<div class="large-4 columns">
			    	<div class="large-10 large-centered columns">
				    	<span class="extra" data-icon="m"></span>
				    	<p>Vervoer naar thuis na opvang</p>
				    	<span class="extra" data-icon="m"></span>
				    	<p>Vervoer naschoolse activiteiten</p>
				    </div>
				</div>
				<div class="large-4 columns border-left">
			    	<div class="large-10 columns float-right">
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
			    <div class="small-12 medium-6 large-6 columns small-collapse">
			    	<div class="small-12 medium-12 large-12 columns">
			    		<span><img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" /></span>
			    		<p class="lhplus">Jan Janssens</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p>Asymmetrical pop-up brooklyn, try-hard waistcoat pabst small batch bespoke bushwick retro pour-over austin kombucha neutra sartorial. Tofu cornhole four loko, gastropub wolf fingerstache DIY keytar kitsch street art umami ramps. Blue bottle dreamcatcher polaroid hoodie, cred poutine microdosing tacos pork belly. Disrupt man bun four dollar toast green juice ethical, blue bottle slow-carb.</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p class="float-left"><i>9 Februari 2016</i></p>
			    		<a class="rate-button float-right" href="#">
			    			<span data-icon="r"></span>
			    			<p>Behulpzaam</p>
			    		</a>
			    	</div>
			    </div>
			    <div class="small-12 medium-6 large-6 columns small-collapse">
			    	<div class="small-12 medium-12 large-12 columns">
			    		<span><img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" /></span>
			    		<p class="lhplus">Jan Janssens</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p>Listicle everyday carry jean shorts fingerstache messenger bag art party. Pitchfork blue bottle actually, iPhone keytar tote bag VHS cronut typewriter trust fund pork belly leggings cardigan. Vinyl meggings fap shabby chic mlkshk, yuccie narwhal yr salvia banjo. Man braid cardigan artisan dreamcatcher.</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p class="float-left"><i>9 Februari 2016</i></p>
			    		<a class="rate-button float-right" href="#">
			    			<span data-icon="r"></span>
			    			<p>Behulpzaam</p>
			    		</a>
			    	</div>
			    </div>
			    <div class="small-12 medium-6 large-6 columns small-collapse">
			    	<div class="small-12 medium-12 large-12 columns">
			    		<span><img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" /></span>
			    		<p class="lhplus">Jan Janssens</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p>Listicle everyday carry jean shorts fingerstache messenger bag art party. Pitchfork blue bottle actually, iPhone keytar tote bag VHS cronut typewriter trust fund pork belly leggings cardigan. Vinyl meggings fap shabby chic mlkshk, yuccie narwhal yr salvia banjo. Man braid cardigan artisan dreamcatcher.</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p class="float-left"><i>9 Februari 2016</i></p>
			    		<a class="rate-button float-right" href="#">
			    			<span data-icon="r"></span>
			    			<p>Behulpzaam</p>
			    		</a>
			    	</div>
			    </div>
			    <div class="small-12 medium-6 large-6 columns small-collapse">
			    	<div class="small-12 medium-12 large-12 columns">
			    		<span><img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" /></span>
			    		<p class="lhplus">Jan Janssens</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p>Listicle everyday carry jean shorts fingerstache messenger bag art party. Pitchfork blue bottle actually, iPhone keytar tote bag VHS cronut typewriter trust fund pork belly leggings cardigan. Vinyl meggings fap shabby chic mlkshk, yuccie narwhal yr salvia banjo. Man braid cardigan artisan dreamcatcher.</p>
			    	</div>
			    	<div class="small-12 medium-12 large-12 columns">
			    		<p class="float-left"><i>9 Februari 2016</i></p>
			    		<a class="rate-button float-right" href="#">
			    			<span data-icon="r"></span>
			    			<p>Behulpzaam</p>
			    		</a>
			    	</div>
			    </div>
			</div>
		</div>

		<div class="large-collapse advert-overview-container">
	    	<div class="large-12 small-centered columns">
			    <div class="large-12 columns">
			    	<h2>Vergelijkbare advertenties</h2>
			    	<hr class="red-horizontal-line"></hr>
			    </div>
		    </div>
		</div>
		
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>