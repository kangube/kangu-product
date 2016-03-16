<?php 
	
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();

	if(isset($_POST['advert-create-button']))
	{
		try 
		{	
			// Processing the given home and mobile telephone-numbers
			$mobile_phone_number = preg_replace('/\s+/', '', $_POST['advert-mobile-number']);
			$home_phone_number = preg_replace('/\s+/', '', $_POST['advert-home-number']);

			if(preg_match( '/^(\d{4})(\d{3})(\d{3})$/', $mobile_phone_number, $matches))
			{
			    $mobile_phone_number = $matches[1].' '.$matches[2].' '.$matches[3];
			}

			if(preg_match( '/^(\d{3})(\d{2})(\d{2})(\d{2})$/', $home_phone_number, $matches))
			{
			    $home_phone_number = $matches[1].' '.$matches[2].' '.$matches[3].' '.$matches[4];
			}

			$home_phone_number = "+32 ".$home_phone_number;
			$mobile_phone_number = "+32 ".$mobile_phone_number;

			// Splitting the given home adress into an street-adress and a city
			$given_home_adress = explode(",", $_POST['advert-home-adress']);
			$advert_street_adress = $given_home_adress[0];
			$advert_city = preg_replace('/\s+/', '', $given_home_adress[1]);

			// Processing the chosen transportation options
			$chosen_transportation_options = implode(", ", $_POST['advert-transportation']);

			// Calculating the advert price based on the chosen services
			$prices = array(
				'opvang-thuisomgeving' => 3,
				'ophalen-schoolpoort' => 2,
				'vervoer-thuis' => 2,
				'vervoer-naschoolse-activiteiten' => 2,
				'voorzien-maaltijd' => 1,
				'hulp-huiswerktaken' => 2
			);

			$services = $_POST['advert-services'];
			$advert_price = 0;

			foreach($services as $key => $service) {
				if (!isset($prices[$service])) {
					continue;
				}
				$advert_price += $prices[$service];
			}

			// Passing data to the advert class for processing
			$advert->UserId = $userRow['user_id'];
			$advert->Description = $_POST['advert-description'];
			$advert->Price = $advert_price;
			$advert->NumberChildren = $_POST['advert-spots'];
			$advert->School = 'Heilig-hartcollege';
			$advert->MobileNumber = $mobile_phone_number;
			$advert->HomeNumber = $home_phone_number;
			$advert->Email = $_POST['advert-email'];
			$advert->HomeAdress = $advert_street_adress;
			$advert->HomeCity = $advert_city;
			$advert->Transportation = $chosen_transportation_options;
			$advert->Services = $_POST['advert-services'];
			$advert->AvailableDates = $_POST['advert-availability-date'];
			$advert->AvailableStartTimes = $_POST['advert-availability-start-time'];
			$advert->AvailableEndTimes = $_POST['advert-availability-end-time'];
			
			$advert->Save();
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
		<title>Advertentie aanmaken</title>
		<link rel="stylesheet" href="../css/minimum-viable-product.min.css">
		<link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
	</head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="full-width-advert-create">
			<div class="full-height-gradient"></div>

			<div class="advert-create-container">
				<div class="advert-create-introductory-header">
					<h1 class="advert-create-header">Word opvangbiedende ouder</h1>
					<h2 class="advert-create-subheader">kangu laat ouders elkaar naschoolse opvang aanbieden</h2>
				</div>
			
				<div class="advert-create-form-container">
					<form class="advert-create-form" method="post">
						<div class="form-description-container">
							<h3 class="form-header">Over deze advertentie</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Presenteer jouw advertentie op de best mogelijke manier aan de hand van een gepersonaliseerde beschrijving van jezelf en jouw motivatie.</p>
							<textarea placeholder="Geef een korte beschrijving van jezelf en waarom je opvang wil aanbieden." name="advert-description" rows="2" required></textarea>
							<div class="form-error">Het is verplicht om een beschrijving te geven aan je advertentie.</div>
						</div>

						<div class="form-number-children-container">
							<h3 class="form-header">Beschikbare plaatsen</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer het maximum aantal kinderen waarvoor je opvang wenst aan te bieden.</p>
							<div class="number-children-radio-buttons">
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="1">1</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="2">2</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="3">3</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="4">4</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="5">5</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="6">6</label>
							</div>
							<div class="form-error">Geef aan hoeveel kinderen u maximum wenst op te vangen.</div>
						</div>

						<div class="form-contact-information-container">
							<h3 class="form-header">Contact informatie</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Voorzie jouw advertentie van de nodige contact-informatie zodat andere ouders je kunnen contacteren.</p>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="z"></span>
									<input class="form-input" type="tel" name="advert-mobile-number" placeholder="jouw gsm-nummer" required>
								</div>
								<div class="form-error">Dit is geen geldig gsm-nummer.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="q"></span>
									<input class="form-input" type="tel" name="advert-home-number" placeholder="jouw huistelefoonnummer" required>
								</div>
								<div class="form-error">Dit is geen geldig huistelefoonnummer.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="x"></span>
									<input class="form-input" type="email" name="advert-email" placeholder="jouw e-mail adres" required>
								</div>
								<div class="form-error">Dit is geen geldig e-mail adres.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="v"></span>
									<input class="form-input" type="text" name="advert-home-adress" placeholder="jouw adres, jouw gemeente" required>
								</div>
								<div class="form-error">voorbeeld: bosstraat 2, Heist-op-den-Berg</div>
							</div>
						</div>

						<div class="form-transportation-container">
							<h3 class="form-header">Verplaatsingsmogelijkheden</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Geef aan op welke manier je de kinderen van en naar school voert. (Meerdere opties zijn mogelijk)</p>

							<div class="show-for-large transportation-container">
								<div class="transportation">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-transportation[]" id="auto" value="auto">
												<label for="auto"><span></span>Met de auto</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="fiets" value="fiets">
		  										<label for="fiets"><span></span>Met de fiets</label>
			  								</div>
			  							</li>
									</ul>
								</div>

								<div class="vertical-line"></div>

								<div class="transportation">
									<ul>
										<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="openbaar-vervoer" value="openbaar-vervoer">
		  										<label for="openbaar-vervoer"><span></span>Openbaar vervoer</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="wandelend" value="wandelend">
		  										<label for="wandelend"><span></span>Te voet</label>
			  								</div>
			  							</li>
									</ul>
								</div>
							</div>

							<div class="show-for-small hide-for-large transportation-container-mobile">
								<ul>
									<li>
										<div class="checkbox">
											<input type="checkbox" name="advert-transportation[]" id="auto-mobile" value="auto">
											<label for="auto-mobile"><span></span>Met de auto</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="openbaar-vervoer-mobile" value="openbaar-vervoer">
	  										<label for="openbaar-vervoer-mobile"><span></span>Openbaar vervoer</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="fiets-mobile" value="fiets">
	  										<label for="fiets-mobile"><span></span>Met de fiets</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="wandelend-mobile" value="wandelend">
	  										<label for="wandelend-mobile"><span></span>Te voet</label>
		  								</div>
		  							</li>
								</ul>
							</div>
						</div>

						<div class="form-services-container">
							<h3 class="form-header">Aangeboden diensten</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer welke extra diensten je wenst aan te bieden aan andere ouders. Zoals je merkt is het ophalen en tijdelijk opvangen van de kinderen in jouw thuisomgeving standaard inbegrepen.</p>

							<div class="show-for-large services-container">
								<div class="service">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-services[]" id="opvang-thuisomgeving" 
													   value="opvang-thuisomgeving" disabled checked>
				  								<label for="opvang-thuisomgeving"><span></span>Opvang in een thuisomgeving</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-services[]" id="ophalen-schoolpoort" 
				  									   value="ophalen-schoolpoort" disabled checked>
				  								<label for="ophalen-schoolpoort"><span></span>Ophalen aan de schoolpoort</label>
			  								</div>
			  							</li>
									</ul>
								</div>

								<div class="vertical-line"></div>

								<div class="service">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-services[]" id="vervoer-thuis" value="vervoer-thuis">
				  								<label for="vervoer-thuis"><span></span>Vervoer naar thuis na opvang</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-services[]" id="vervoer-activiteiten" 
				  									   value="vervoer-naschoolse-activiteiten">
				  								<label for="vervoer-activiteiten"><span></span>Vervoer naschoolse activiteiten</label>
			  								</div>
			  							</li>
									</ul>
								</div>

								<div class="vertical-line"></div>

								<div class="service">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-services[]" id="voorzien-maaltijd" value="voorzien-maaltijd">
				  								<label for="voorzien-maaltijd"><span></span>Voorzien van een maaltijd</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-services[]" id="hulp-huiswerk" value="hulp-huiswerktaken">
				  								<label for="hulp-huiswerk"><span></span>Hulp bij huiswerktaken</label>
			  								</div>
			  							</li>
									</ul>
								</div>
							</div>


							<div class="show-for-small hide-for-large services-container-mobile">
								<ul>
									<li>
										<div class="checkbox">
											<input type="checkbox" name="advert-services[]" id="opvang-thuisomgeving-mobile" 
												   value="opvang-thuisomgeving" disabled checked>
			  								<label for="opvang-thuisomgeving-mobile"><span></span>Opvang in een thuisomgeving</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-services[]" id="ophalen-schoolpoort-mobile" 
			  									   value="ophalen-schoolpoort" disabled checked>
			  								<label for="ophalen-schoolpoort-mobile"><span></span>Ophalen aan de schoolpoort</label>
		  								</div>
		  							</li>
								
									<li>
										<div class="checkbox">
											<input type="checkbox" name="advert-services[]" id="vervoer-thuis-mobile" value="vervoer-thuis">
			  								<label for="vervoer-thuis-mobile"><span></span>Vervoer naar thuis na opvang</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-services[]" id="vervoer-activiteiten-mobile" 
			  									   value="vervoer-naschoolse-activiteiten">
			  								<label for="vervoer-activiteiten-mobile"><span></span>Vervoer naschoolse activiteiten</label>
		  								</div>
		  							</li>
								
									<li>
										<div class="checkbox">
											<input type="checkbox" name="advert-services[]" id="voorzien-maaltijd-mobile" 
												   value="voorzien-maaltijd">
			  								<label for="voorzien-maaltijd-mobile"><span></span>Voorzien van een maaltijd</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-services[]" id="hulp-huiswerk-mobile" 
			  									   value="hulp-huiswerktaken">
			  								<label for="hulp-huiswerk-mobile"><span></span>Hulp bij huiswerktaken</label>
		  								</div>
		  							</li>
								</ul>
							</div>
						</div>

						<!--<div class="small-12 columns form-availability-container">
							<h3 class="form-header">Beschikbaarheid</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Maak je eigen planning en selecteer op welke dagen je opvang wenst aan te bieden. Alle dagen die je niet selecteert worden automatisch op niet beschikbaar geplaatst.</p>

							<div class="advert-availability-input-fields">
								<div class="small-12 large-4 columns">
									<label>Datum</label>
									<input type="date" name="advert-availability-date[]">
								</div>

								<div class="small-12 large-4 columns">
									<label>Begin-tijd</label>
									<input type="time" name="advert-availability-start-time[]">
								</div>

								<div class="small-12 large-4 columns">
									<label>Eind-tijd</label>
									<input type="time" name="advert-availability-end-time[]">
								</div>
							</div>

							<button id="create-availability-input">Datum toevoegen</button>
						</div>-->

						<div class="small-12 columns form-availability-container">
							<h3 class="form-header">Beschikbaarheid</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer welke diensten je wenst aan te bieden aan andere ouders.</p>

							<div class="small-12 large-5 columns availability-datepicker-container">
								<div class="availability-datepicker"></div>
							</div>

							<div class="small-12 large-7 columns advert-availability-input-fields"></div>
						</div>

						<div class="small-12 columns">
							<p class="show-for-large" style="background-color: blue; color: white; padding: 10px;">Large and up</p>
							<p class="show-for-medium-only" style="background-color: blue; color: white; padding: 10px;">Medium</p>
							<p class="show-for-small-only" style="background-color: blue; color: white; padding: 10px;">Small</p>
						</div>

						<div class="small-12 columns">
							<p>Door deze advertentie aan te maken ga je akkoord met onze <a href="#">termen en condities</a></p>
							<input id="advert-create-button" type="submit" name="advert-create-button" value="Advertentie aanmaken"/>
						</div>
					</form>
				</div>
			</div>
		</div>

		<footer>
			<div style="width: 100vw; background-color: red; padding: 20px 0 20px 0; text-align: center; margin-top: 100px;"><p>Footer bro!</p></div>
		</footer>

		<script src="../js/minimum-viable-product.min.js"></script>
		<script src="https://use.typekit.net/vnw3zje.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
	</body>
</html>