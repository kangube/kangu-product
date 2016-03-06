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

	$a1 = new Advert();
	$oneAdvert = $a1->getOne();
?>

<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
        <link href="https://file.myfontastic.com/wfY5TXHecmqLMkPUKHzNrK/icons.css" rel="stylesheet">
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="small-12 columns advert-detail-header">
	        <div class="advert-detail-title-container">
	        	<img src="http://soocurious.com/fr/wp-content/uploads/2015/06/image-singe-telephone.jpg" alt="profiel foto" />
	            <h1 class="advert-detail-title">Christel Janssens</h1>
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
			    	<p>Drinking vinegar typewriter williamsburg deep v tote bag cornhole. Cliche affogato kinfolk shoreditch, actually +1 DIY twee occupy bitters sartorial kale chips put a bird on it fanny pack ugh. Squid actually pug vegan, locavore ennui tumblr +1 truffaut mixtape lo-fi chartreuse drinking vinegar bitters. Pop-up blog bushwick aesthetic quinoa tofu. Green juice single-origin coffee vice pitchfork DIY.</p>
					<div class="small-12 medium-6 large-6 columns">
			    		<div class="border-right">
				    		<span data-icon="e"></span>
				    		<p>Basisschool Heilig-hartcollege</p>
				    		<span data-icon="o"></span>
				    		<p>Plaats voor 2 kinderen</p>
			    		</div>
			    	</div>
			    	<div class="small-12 medium-6 large-6 columns">
				    	<div class="large-12 columns float-right">
				    		<span data-icon="b"></span>
				    		<p>Tussen 5 - 9 euro per uur</p>
				    		<span data-icon="a"></span>
				    		<p>Verplaatsing met de auto</p>
			    		</div>
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
			    	<p>somethingsomething@gmail.com</p>
			    	<span data-icon="z"></span>
			    	<p>+32 440 555 555</p>
			    	<span data-icon="q"></span>
			    	<p>+32 440 555 555</p>
			    	<span class="double-line-height" data-icon="v"></span>
			    	<p>Bullshitstraat 22 <br> 2220, Heist-op-den-berg</p>
				</div>
				<div class="small-12 medium-7 large-9 columns">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d80140.98660363081!2d4.5042499072459785!3d51.1194218869208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1snl!2sbe!4v1457276638613" frameborder="0" style="border:0" allowfullscreen></iframe>
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
				    	<span class="extra" data-icon="b"></span>
				    	<p>Opvang in een thuisomgeving</p>
				    	<span class="extra" data-icon="b"></span>
				    	<p>Ophalen aan de schoolpoort</p>
					</div>
				</div>
				<div class="large-4 columns">
			    	<div class="large-10 large-centered columns">
				    	<span class="extra" data-icon="b"></span>
				    	<p>Opvang in een thuisomgeving</p>
				    	<span class="extra" data-icon="b"></span>
				    	<p>Ophalen aan de schoolpoort</p>
				    </div>
				</div>
				<div class="large-4 columns border-left">
			    	<div class="large-10 columns float-right">
				    	<span class="extra" data-icon="b"></span>
				    	<p>Opvang in een thuisomgeving</p>
				    	<span class="extra" data-icon="b"></span>
				    	<p>Ophalen aan de schoolpoort</p>
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

				<div id="results"></div>
				<div id="searchresults"></div>
		    </div>
		</div>
		
		<!--<?php
			/*while($advert = $oneAdvert->fetch(PDO::FETCH_ASSOC))
			{
				echo "Advert creator: ".$advert["user_firstname"].' '.$advert["user_lastname"]."<br />";
				echo "Advert location: ".$advert["user_adress"].', '.$advert["user_city"]."<br />";
				echo "Contact email: ".$advert["user_email"]."<br />";
				echo "Contact home number: ".$advert["user_home_number"]."<br />";
				echo "Contact mobile number: ".$advert["user_mobile_number"]."<br />";
				echo "Description: ".$advert["advert_description"]."<br />";
				echo "Price: ".$advert["advert_price"]."<br />";
				echo "Spots left: ".$advert["advert_spots"]."<br />";
				echo "Advert school: ".$advert["advert_school"]."<br />";
				echo "Advert transport: ".$advert["advert_transport"]."<br />";
			}*/
		?>-->
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>