<?php 
	
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	// Gathering the logged user's personal information
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	// Creating a new advert
	$advert = new Advert();

	// Checking if the logged user has already created an advert
	$check_user_has_advert = $auth_user->hasAdvert($userRow['user_id']);
	if($check_user_has_advert === true) {
		$auth_user->redirect('advert-overview.php');
	}

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
			$advert_service_names = $advert->GetServiceNames();
			$serviceNamesArray = $advert_service_names->fetchAll(PDO::FETCH_COLUMN, 0);

			$advert_service_prices = $advert->GetServicePrices();
			$servicePricesArray = $advert_service_prices->fetchAll(PDO::FETCH_COLUMN, 0);

			$CombinedServicesArray = array_combine($serviceNamesArray, $servicePricesArray);

			$services = $_POST['advert-services'];
			$advert_price = 0;

			foreach(array_unique($services) as $key => $service) {
				if (!isset($CombinedServicesArray[$service])) {
					continue;
				}
				$advert_price += $CombinedServicesArray[$service];
			}

			// Processing the given children information
			$children_names = $_POST['advert-child-name'];
			$children_first_names = array();
			$children_last_names = array();

			foreach ($children_names as $name) {
				$child_full_name = explode(' ', $name, 2);
				if (!isset($child_full_name[0])) {
				   $child_full_name[0] = null;
				}

				$children_first_names[] = $child_full_name[0];
				if (!isset($child_full_name[1])) {
				   $child_full_name[1] = null;
				}

				$children_last_names[] = $child_full_name[1];
			}

			// Passing data to the advert class for processing
			$advert->UserId = $userRow['user_id'];
			$advert->Description = $_POST['advert-description'];
			$advert->Price = $advert_price;
			$advert->NumberChildren = $_POST['advert-spots'];
			$advert->ChildFirstName = $children_first_names;
			$advert->ChildLastName = $children_last_names;
			$advert->ChildClass = $_POST['advert-child-class'];
			$advert->School = $_POST['advert-school'];
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

			header("Location: advert-create-confirmation.php");
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
					<form class="advert-create-form" method="post" data-abide novalidate>
						<div class="form-description-container">
							<h3 class="form-header">Over deze advertentie</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Presenteer jouw advertentie op de best mogelijke manier aan de hand van een gepersonaliseerde beschrijving van jezelf en jouw motivatie.</p>
							<textarea placeholder="Geef een korte beschrijving van jezelf en waarom je opvang wil aanbieden." name="advert-description" rows="5" cols="10" required></textarea>
						</div>

						<div class="form-number-children-container">
							<h3 class="form-header">Over jouw kinderen</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Voorzie jouw advertentie van praktische informatie over je kinderen zodat andere ouders je makkelijker kunnen herkennen.</p>

							<div class="number-children-container">
								<div class="form-icon-input-field">
									<div class="form-icon-input-container">
										<span class="form-icon" data-icon="o"></span>
										<input class="form-input" type="text" name="advert-child-name[]" placeholder="Voor- en achternaam van jouw kind" required>
									</div>
								</div>

								<div class="form-icon-input-field">
									<div class="form-icon-input-container">
										<span class="form-icon" data-icon="e"></span>
										<input class="form-input" type="text" name="advert-child-class[]" placeholder="Klasnummer van jouw kind" required>
									</div>
								</div>
							</div>

							<a class="advert-add-child-button">Kind toevoegen</a>
						</div>

						<div class="form-number-spots-container">
							<h3 class="form-header">Beschikbare plaatsen</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer het maximum aantal kinderen waarvoor je per dag opvang wil aanbieden.</p>
							<div class="number-spots-radio-buttons">
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="1">1</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="2">2</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="3">3</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="4">4</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="5">5</label>
								<label class="badge radio-button"><input type="radio" name="advert-spots" value="6">6</label>
							</div>
						</div>

						<div class="form-school-container">
							<h3 class="form-header">Basisschool</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Geef aan naar welke school je kinderen gaan zodat andere ouders weten op welke school je opvang aanbiedt.</p>
							<div class="form-icon-input-container">
								<span class="form-icon" data-icon="e"></span>
								<select class="form-input advert-school-input" name="advert-school" required></select>
							</div>
						</div>

						<div class="form-contact-information-container">
							<h3 class="form-header">Contact-informatie</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Voorzie jouw advertentie van de nodige contact-informatie zodat andere ouders je kunnen contacteren indien nodig.</p>

							<div class="form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="z"></span>
									<input class="form-input" type="tel" name="advert-mobile-number" placeholder="jouw gsm-nummer" required>
								</div>
							</div>

							<div class="form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="q"></span>
									<input class="form-input" type="tel" name="advert-home-number" placeholder="jouw huistelefoonnummer" required>
								</div>
							</div>

							<div class="form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="x"></span>
									<input class="form-input" type="email" name="advert-email" placeholder="jouw e-mail adres" required>
								</div>
							</div>

							<div class="form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="v"></span>
									<input class="form-input" type="text" name="advert-home-adress" placeholder="jouw adres, jouw gemeente" required>
								</div>
							</div>
						</div>

						<div class="form-transportation-container">
							<h3 class="form-header">Verplaatsingsmogelijkheden</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Geef aan op welke manier(en) je de kinderen van en naar school voert. (Meerdere opties zijn mogelijk)</p>

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
							<p class="form-subheader">Selecteer welke extra diensten je wenst aan te bieden aan andere ouders naast het ophalen en tijdelijk opvangen van de kinderen. (Meerdere opties zijn mogelijk)</p>

							<div class="show-for-large services-container">
								<div class="service">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-services[]" id="opvang-thuisomgeving" 
													   value="opvang-thuisomgeving" disabled checked>
				  								<label for="opvang-thuisomgeving"><span></span>Opvang in een thuisomgeving</label>
			  								</div>

			  								<input type="hidden" name="advert-services[]" value="opvang-thuisomgeving">
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-services[]" id="ophalen-schoolpoort" 
				  									   value="ophalen-schoolpoort" disabled checked>
				  								<label for="ophalen-schoolpoort"><span></span>Ophalen aan de schoolpoort</label>
			  								</div>

			  								<input type="hidden" name="advert-services[]" value="ophalen-schoolpoort">
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

		  								<input type="hidden" name="advert-services[]" value="opvang-thuisomgeving">
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-services[]" id="ophalen-schoolpoort-mobile" 
			  									   value="ophalen-schoolpoort" disabled checked>
			  								<label for="ophalen-schoolpoort-mobile"><span></span>Ophalen aan de schoolpoort</label>
		  								</div>

		  								<input type="hidden" name="advert-services[]" value="ophalen-schoolpoort">
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

						<div class="form-availability-container">
							<h3 class="form-header">Beschikbaarheid</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Stel je eigen opvangplanning op door de dagen te selecteren waarop je opvang wil aanbieden. De dagen die je niet geselecteerd hebt zullen automatisch op niet beschikbaar gezet worden.</p>
							<div id="availability-datepicker"></div>
							<div class="advert-availability-slots"></div>
						</div>

						<div class="small-12 columns form-error-container" data-abide-error>
							<p>Er zitten enkele fouten in het formulier, kijk na of alles is ingevuld en probeer het vervolgens nogmaals.</p>
						</div>

						<div class="form-submit-container">
							<p>Door deze advertentie aan te maken ga je akkoord met onze <a href="#">termen en condities</a></p>
							<input id="advert-create-button" type="submit" name="advert-create-button" value="Advertentie aanmaken"/>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
		<script src="https://use.typekit.net/vnw3zje.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
		<script>
			var disabledDates = new Array();

		    $(document).ready(function() {
		    	checkSize();
			    $(window).resize(checkSize);

				function checkSize() {
					var currentSize = Foundation.MediaQuery.current;
					var numberOfMonths = $('#availability-datepicker').datepicker('option', 'numberOfMonths');
				    if (currentSize == 'small' || currentSize == 'medium') {
						$('#availability-datepicker').datepicker('option', 'numberOfMonths', 1);
					}
					else if (currentSize == 'large' || currentSize == 'xlarge' || currentSize == 'xxlarge') {
						$('#availability-datepicker').datepicker('option', 'numberOfMonths', [1,2]);
					}
				}
			});

		    $('#availability-datepicker').multiDatesPicker({
		        inline: true,
			    dateFormat: 'yy-mm-dd',
			    firstDay: 1,
			    showOtherMonths: true,
			    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
			    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
			    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
			    onSelect: function (selected) {
			    	if ($.inArray(selected, disabledDates) > -1) {
						//alert("Date is in the array: "+disabledDates);
					}
					else {
						disabledDates.push(selected);
						$(".advert-availability-slots").css("display", "block").append("<div class='availability-slot-created'></div>");
					}
			    },
			    beforeShowDay: function (date) {
			        var td = date.getDay();
			        var ret = [(date.getDay() != 0 && date.getDay() != 6),'',(td != 'Za' && td != 'Zo')?'':'only on workday'];
			        return ret;
			    }
		    });


		    $(".advert-availability-slots").arrive(".availability-slot-created", function() {
				var date_sort_asc = function (date1, date2) {
					if (date1 > date2) {
						return 1;
					}
					else if (date1 < date2) {
						return -1;
					}

					return 0;
				};

				disabledDates.sort(date_sort_asc);
				$(".advert-availability-slots").contents('.availability-slot-created').remove();
				$(".advert-availability-slots .advert-availability-dates").contents().remove();

				for (var i = 0; i < disabledDates.length; i++) {
					var date_format = disabledDates[i].split("-");
					var date_day = date_format[2];
					var date_month = date_format[1];
					var date_year = date_format[0];

					function GetShortMonthName(date_month) {
						var months = ["Jan.", "Feb.", "Mrt.", "Apr.", "Mei", "Jun.", "Jul.", "Aug.", "Sep.", "Okt.", "Nov.", "Dec."];
						return months[date_month-1];
					}

					function GetFullMonthName(date_month) {
						var months = ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"];
						return months[date_month-1];
					}

					date_month_short = GetShortMonthName(date_month);
					date_month_full = GetFullMonthName(date_month);
					format_date_month = date_format[1].replace(/^0+/, '');

					if ($(".advert-availability-month[data-availability-format='"+format_date_month+'-'+date_year+"']").length === 0) {
						$(".advert-availability-slots").append("<div class='advert-availability-month' data-availability-format="+format_date_month+'-'+date_year+"><div class='small-12 columns date-month'><p>"+date_month_full+'-'+date_year+"</p></div><div class='advert-availability-dates'></div></div>");
					}

					$(".advert-availability-month[data-availability-format='"+format_date_month+'-'+date_year+"'] .advert-availability-dates").append("<div class='small-6 columns availability-slot-container float-left'><div class='availability-slot'><div class='small-2 columns selected-date'><p>"+date_day+"</p><p>"+date_month_short+"</p><input type='date' name='advert-availability-date[]' value="+disabledDates[i]+" readonly></div><div class='small-4 columns'><input type='text' class='time-input' name='advert-availability-start-time[]' placeholder='Van' data-time-format='H:i'></div><div class='small-1 columns availability-slot-duration' data-icon='y'></div><div class='small-4 columns'><input type='text' class='time-input' name='advert-availability-end-time[]' placeholder='Tot' data-time-format='H:i'></div><div class='small-1 columns remove-availability-slot' data-icon='n'></div></div></div>");

					$('.time-input').timepicker({
						'step': 15,
						'forceRoundTime': true,
						'useSelect': false,
						'minTime': '12:00',
						'orientation': 'b'
					});
				}
			});
		</script>
	</body>
</html>