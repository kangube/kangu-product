<?php
	setlocale(LC_ALL, 'nl_NL');

	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.booking.php");
	require_once("../php-assets/PHPMailerAutoload.php");

	$conn = Db::getInstance();

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$booking = new Booking();

	// Get all the creator details of this advert
	$advert_creator_details = $advert->GetAdvertCreatorDetails($_GET['id']);
	$creatorDetails = $advert_creator_details->fetch(PDO::FETCH_ASSOC);

	$creator_id = $creatorDetails['user_id'];
	$creator_first_name = $creatorDetails['user_firstname'];
	$creator_email = $creatorDetails['user_email'];

	// Get all services that belong to this advert
	$advert_services = $advert->GetServices($_GET['id']);
	$servicesArray = $advert_services->fetchAll(PDO::FETCH_COLUMN, 0);

	// Creating a new array to hold all available services with their corresponding descriptions and prices
	$advert_service_names = $advert->GetServiceNames();
	$serviceNamesArray = $advert_service_names->fetchAll(PDO::FETCH_COLUMN, 0);

	$advert_service_descriptions = $advert->GetServiceDescriptions();
	$serviceDescriptionsArray = $advert_service_descriptions->fetchAll(PDO::FETCH_COLUMN, 0);

	$advert_service_prices = $advert->GetServicePrices();
	$servicePricesArray = $advert_service_prices->fetchAll(PDO::FETCH_COLUMN, 0);

	$CombinedServicesArray = array_combine($serviceNamesArray, $servicePricesArray);

	if(isset($_POST['advert-create-request-button']))
	{
		try 
		{	
			// Gathering all corresponding data from the chosen advert
			$advert_user_id = $creatorDetails['user_id'];

			// Calculating the booking price based on the chosen services
			$services = $_POST['advert-book-services'];
			$booking_price = 0;
			foreach(array_unique($services) as $key => $service) {
				if (!isset($CombinedServicesArray[$service])) {
					continue;
				}
				$booking_price += $CombinedServicesArray[$service];
			}

			// Gathering the service id's based on the chosen services
			$service_ids = array();
			foreach($_POST['advert-book-services'] as $service) {
				$statement = $conn->prepare("SELECT service_price_id FROM tbl_service_price WHERE service_price_name = '$service'");
				$statement->execute();
				$service_id = $statement->fetch(PDO::FETCH_COLUMN, 0);
				$service_ids[] = $service_id;
			}

			// Counting the number of children that are booked
			$number_selected_children = count($_POST['advert-select-children']);

			// Passing data to the booking class for processing
			$booking->AdvertId = $_GET['id'];
			$booking->BookerUserId = $advert_user_id;
			$booking->RenterUserId = $userRow['user_id'];
			$booking->NumberSpots = $number_selected_children;
			$booking->Price = $booking_price;
			$booking->ExtraInformation = $_POST['advert-book-extra-information'];
			$booking->Date = $_POST['advert-book-date'];
			$booking->ChildId = $_POST['advert-select-children'];
			$booking->ServiceId = $service_ids;
			$booking->Save();
			$booking->UpdateAdvertNumberBookings();
			$booking->UpdateAvailabilitySpots();

			// Processing all of the required mail data

			// Determining string type based on type of user (male or female)
			$user_type = array();

			if($userRow['user_sex_type'] === 'Male') {
				$user_type[] = 'zijn';
				$user_type[] = 'hem';
			} else if($userRow['user_sex_type'] === 'Female') {
				$user_type[] = 'haar';
				$user_type[] = 'haar';
			}

			// Determining string type based on number of selected children
			$selected_children = '';

			if($number_selected_children == 1) {
				$number_selected_children = '';
				$selected_children = 'kind';
			} else if($number_selected_children >= 1) {
				$selected_children = 'kinderen';
			}

			// Retrieving the selected children's names
			$selected_children_names = array();
			foreach($_POST['advert-select-children'] as $childId) {
				$statement = $conn->prepare("SELECT child_first_name FROM tbl_child WHERE child_id = '$childId'");
				$statement->execute();
				$child_name = $statement->fetch(PDO::FETCH_COLUMN, 0);
				$selected_children_names[] = $child_name;
			}

			$iterator = new ArrayIterator($selected_children_names);
			$cachingiterator = new CachingIterator($iterator);

			$selected_child_name = '';

			foreach ($cachingiterator as $name)
		    {
		        $selected_child_name .= $cachingiterator->current();

		        if($cachingiterator->hasNext())
		        {
		            $selected_child_name .= ", ";
		        }
		    }

		    $selected_child_name = preg_replace('/(.*),/','$1 en',$selected_child_name);

		    // Processing the chosen date into a readable string
		    $chosen_date_day = ltrim(date('d', strtotime($_POST['advert-book-date'])), '0');
			$chosen_date_day_string = strftime("%A", strtotime($_POST['advert-book-date']));
			$chosen_date_month_string = strftime("%B", strtotime($_POST['advert-book-date']));

			// Sending a booking-request e-mail to the creator of the advert
			$mail = new PHPMailer;   
	        $mail->isSMTP();

	        $mail->SMTPDebug = 0;
	        $mail->Debugoutput = 'html';
	        $mail->Host = 'smtp.transip.email';
	        $mail->Port = 465;
	        $mail->SMTPSecure = 'ssl';
	        $mail->SMTPAuth = true;

	        $mail->Username = "info@kangu.be";
	        $mail->Password = "K4nguBelgium";
	        $mail->setFrom('info@kangu.be', 'Kangu support-team');
	        $mail->addReplyTo('info@kangu.be', 'Kangu support-team');
	        $mail->addAddress($creator_email);
	        $mail->IsHTML(true);
	        $mail->Subject = "Nieuwe opvang-aanvraag";

	        $mail->Body = '<!doctype html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title></title><style type="text/css"> #outlook a{padding: 0;}.ReadMsgBody{width: 100%;}.ExternalClass{width: 100%;}.ExternalClass *{line-height:100%;}body{margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}table, td{border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}p{display: block; margin: 13px 0;}</style><style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700); </style><style type="text/css"> @media only screen and (max-width:480px){@-ms-viewport{width:320px;}@viewport{width:320px;}}</style><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings></xml><![endif]--><style type="text/css"> @media only screen and (min-width:480px){.mj-column-per-100, * [aria-labelledby="mj-column-per-100"]{width:100%!important;}}</style><style type="text/css"> @media only screen and (max-width:480px){.mj-hero-content{width: 100% !important;}}</style></head><body> <div><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0 auto;max-width:600px;background:url(http://www.kangu.be/assets/index/pattern-tile-alt.png) top center / auto repeat;"><!--[if mso | IE]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;"> <v:fill origin="0.5, 0" position="0.5,0" type="tile" src="http://www.kangu.be/assets/index/pattern-tile-alt.png"/> <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:url(http://www.kangu.be/assets/index/pattern-tile-alt.png) top center / auto repeat;" align="center" border="0" background="http://www.kangu.be/assets/index/pattern-tile-alt.png"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:40px 0px 40px 0px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:undefined;width:300px;"><![endif]--><div style="margin:0 auto;max-width:600px;"><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:20px 0px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;"><![endif]--><div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;"><table cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-bottom:20px;" align="center"><table cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="center" border="0"><tbody><tr><td style="width:150px;"><img alt="" height="37.12px" src="http://www.kangu.be/assets/index/kangu-logotype.png" style="border:none;display:block;outline:none;text-decoration:none;width:100%;height:37.12px;" width="150"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td><td style="vertical-align:undefined;width:300px;"><![endif]--><div style="margin:0 auto;max-width:400px;background:#FFFFFF;"><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 20px 30px 20px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;"><![endif]--><div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;"><table cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Hallo '.$creator_first_name.'!</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Je hebt een nieuwe opvang-aanvraag ontvangen voor <b>'.$chosen_date_day_string.' '.$chosen_date_day.' '.$chosen_date_month_string.'</b> van <b>'.$userRow['user_firstname'].' '.$userRow['user_lastname'].'</b> voor '.$user_type[0].' '.$number_selected_children.' '.$selected_children.', <b>'.$selected_child_name.'</b>. Laat '.$user_type[1].' weten of je de opvang wil laten doorgaan door de status van de aanvraag te updaten via het platform.</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><table cellpadding="0" cellspacing="0" style="border:none;border-radius:3px;" align="left" border="0"><tbody><tr><td style="background:#F37A7D;border-radius:3px;color:#FFFFFF;cursor:auto;" align="center" valign="middle" bgcolor="#F37A7D"><a href="#" style="display:inline-block;text-decoration:none;background:#F37A7D;border:1px solid #F37A7D;border-radius:3px;color:#FFFFFF;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;padding:10px 25px;" target="_blank">Opvang-aanvraag bekijken</a></td></tr></tbody></table></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-bottom:0px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Met vriendelijke groeten,</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:0px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Het kangu support-team</div></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table><!--[if mso | IE]> </v:textbox> </v:rect><![endif]--></div><!--[if mso | IE]> </td></tr></table><![endif]--></div></body></html>';

	        $mail->AltBody = "<a href='http://localhost:8888/kangu-product/public/pages/password-reset.php'>Opvang-aanvraagen bekijken</a>";

			if ($mail->send()) {
	            $success_message = "Aanvraag werd verstuurd!";
	        }
		}
		catch(Exception $e)
		{
			$error_message = "Je aanvraag werd niet verstuurd.";
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

		<?php if (!empty($success_message)) { ?>
				<div class="full-width full-width-advert-book-confirmation">
        			<div class="half-height-gradient"></div>

            		<div class="row">
	                    <div class="large-4 medium-6 small-12 small-centered columns advert-book-input-panel">
	                        <div class="row">
	                            <div class="small-12 text-center columns">
	                                <span class="confirmation-icon" data-icon="B"></span>
	                                <h3><?php echo $success_message; ?></h3>
	                                <p class="success-message">Jouw aanvraag zal spoedig behandeld worden door de opvang-ouder. De status van de aanvraag kan je in de planning-pagina opvolgen.</p>
	                                <a class="confirmation-button" href="planning-overview.php">Status aanvraag bekijken</a>
	                            </div>
	                        </div>
	                    </div>
                	</div>
                </div>
                                    
        <?php } else { ?>
	        	<div class="full-width-advert-book">
					<div class="full-height-gradient"></div>

					<div class="advert-book-container">
						<div class="advert-book-introductory-header">
							<h1 class="advert-book-header">Opvang aanvragen</h1>
							<h2 class="advert-book-subheader">Verstuur een aanvraag naar de opvang-ouder om de opvang te plannen.</h2>
						</div>

						<div class="advert-book-form-container">
							<form class="advert-book-form" method="post" data-abide novalidate>
								<!--<div class="form-select-date-container">
						  			<h3 class="form-header">Opvangdatum</h3>
									<hr class="blue-horizontal-line"></hr>
									<p class="form-subheader">Selecteer de datum waarvoor u graag opvang zou willen aanvragen.</p>
									<div class="availability-spots-select"></div>
									<input type="hidden" class="advert-book-date" name="advert-book-date">
								</div>-->

								<div class="form-select-date-container">
						  			<h3 class="form-header">Selecteer de opvangdatum</h3>
									<hr class="blue-horizontal-line"></hr>
									<p class="form-subheader">Selecteer de datum waarvoor u graag opvang zou willen aanvragen.</p>
									<div class="advert-availability-slots"></div>
									<input type="hidden" class="advert-book-date" name="advert-book-date">
								</div>

								<div class='form-select-children-container'>
									<h3 class="form-header">Selecteer uw kinderen</h3>
									<hr class="blue-horizontal-line"></hr>

									<div class="callout select-children-callout">
										<p class="select-children-alert"></p>
									</div>

									<?php
										$check_user_has_provided_children = $auth_user->hasProvidedChildren($userRow['user_id']);
										if($check_user_has_provided_children) {

											echo '<p class="form-subheader">Selecteer welke van jouw kinderen moeten opgevangen worden zodat de opvang-ouder op de hoogte is van welke kinderen men dient op te vangen.</p>';

											echo '<div class="provided-children-container">';

											$statement = $conn->prepare("SELECT * FROM tbl_user_child LEFT JOIN tbl_child ON tbl_user_child.fk_child_id=tbl_child.child_id WHERE fk_user_id=".$userRow['user_id']."");
											$statement->execute();

											while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
										        echo '<div class="select-child-container">
														<ul>
															<li class="small-2 columns">
																<input type="checkbox" class="advert-select-children" id="select-child-'.$row['child_id'].'" name="advert-select-children[]" value="'.$row['child_id'].'"><label for="select-child-'.$row['child_id'].'"><span></span></label>
															</li>
														
															<li class="small-4 columns">'.$row['child_first_name'].' '.$row['child_last_name'].'</li>
															<li class="small-4 columns">'.$row['child_school'].'</li>
															<li class="small-2 columns">'.$row['child_class'].'</li>
														</ul>
													</div>';
										    }

											echo '</div>';
										}
										else {
											echo '<p class="form-subheader">We merken op dat er nog geen kinderen aan je profiel gelinkt zijn. Voeg jouw kinderen toe om de opvang-aanvraag verder te vervolledigen. </p>';

											echo '<div class="number-children-container">
													<input type="hidden" class="child-parent-id" value="'.$userRow['user_id'].'">

													<div class="child-container">
														<div class="child-container-input-field">
															<input type="text" class="child-name" name="advert-book-child-name[]" placeholder="Voor- en achternaam van jouw kind">
														</div>

														<div class="child-container-input-field">
															<select class="child-age" name="advert-book-child-age[]">
																<option value="">Leeftijd van jouw kind</option>
																<option value="3">3 jaar oud</option>
																<option value="4">4 jaar oud</option>
																<option value="5">5 jaar oud</option>
																<option value="6">6 jaar oud</option>
																<option value="7">7 jaar oud</option>
																<option value="8">8 jaar oud</option>
																<option value="9">9 jaar oud</option>
																<option value="10">10 jaar oud</option>
																<option value="11">11 jaar oud</option>
																<option value="12">12 jaar oud</option>
															</select>
														</div>

														<div class="child-container-input-field">
															<select class="advert-school-input child-school" name="advert-book-child-school[]"></select>
														</div>

														<div class="child-container-input-field">
															<input type="text" class="child-class" name="advert-book-child-class[]" placeholder="Klasnummer van jouw kind">
														</div>

														<div class="child-container-input-field">
															<a class="advert-book-save-child-button">Toevoegen</a>
														</div>

														<p class="child-container-error"></p>
													</div>
												</div>';

											echo '<a class="advert-book-add-child-button">Nieuw kind toevoegen</a>';
										}
									?>
								</div>

								<div class="form-select-services-container">
								<h3 class="form-header">Selecteer de opvangdiensten</h3>
									<hr class="blue-horizontal-line"></hr>
									<p class="form-subheader">Stel zelf je de opvang-ervaring voor jouw kinderen samen door een selectie te maken tussen de aangeboden diensten van de opvang-ouder. Zoals je merkt is het ophalen en opvangen van de kinderen al reeds standaard inbegrepen in de dienstverlening.</p>

									<div class="services-container">
										<ul>
											<?php
												$servicesCompleteArray = array_combine($serviceNamesArray, $serviceDescriptionsArray);

												foreach ($servicesCompleteArray as $key => $value) {
													if (in_array($key, $servicesArray)) {
														if ($key == 'opvang-thuisomgeving' || $key == 'ophalen-schoolpoort') {
															echo '<li><div class="checkbox"><input type="checkbox" id="'.$key.'" value="'.$key.'" disabled checked><label for="'.$key.'"><span></span>'.$value.'</label></div>';
												   			echo '<input type="hidden" name="advert-book-services[]" value="'.$key.'" checked></li>';
														} else {
															echo '<li><div class="checkbox"><input type="checkbox" name="advert-book-services[]" id="'.$key.'" value="'.$key.'"><label for="'.$key.'"><span></span>'.$value.'</label></div></li>';
														}
													} else {
													    echo '<li><label class="not-selected" data-icon="w">'.$value.'</label></li>';
													}
												}
											?>
										</ul>
									</div>
								</div>

								<div class="form-add-extra-information-container">
									<h3 class="form-header">Extra informatie</h3>
									<hr class='blue-horizontal-line'></hr>
									<p class="form-subheader">Indien je wenst kan je extra informatie meegeven waarvan de opvang-ouder dient op de hoogte gebracht te worden.</p>
									<textarea id="info" name="advert-book-extra-information" placeholder="Extra informatie kan allerlei zaken omvatten zoals: de ophaal-tijdstippen van de kinderen, allergieën van de kinderen, favoriete bezigheden van de kinderen, bepaalde regels die gevolgd moeten worden en dergelijke." rows="4"></textarea>
								</div>

								<div class="form-submit-request-container">
									<input id="advert-create-request-button" type="submit" name="advert-create-request-button" value="Opvang-aanvraag versturen"/>
								</div>
							</form>
						</div>
					</div>
				</div>
		<?php } ?>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
		<script src="https://use.typekit.net/vnw3zje.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<!--<script>
			$(document).ready(function() {
				var getUrlParameter = function getUrlParameter(sParam) {
				    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				        sURLVariables = sPageURL.split('&'),
				        sParameterName,
				        i;

				    for (i = 0; i < sURLVariables.length; i++) {
				        sParameterName = sURLVariables[i].split('=');

				        if (sParameterName[0] === sParam) {
				            return sParameterName[1] === undefined ? true : sParameterName[1];
				        }
				    }
				};

				var advert_id = getUrlParameter('id');

				if (typeof advert_id !== 'undefined') {
	                var Event = function(className) {
				    	this.className = className;
					};

					var events = [];
					$.getJSON('availability-dates.php?id="'+advert_id+'"', function(data) {
	                    $.each(data, function(key, val) {
	                        availability_date_item = val.availability_date.replace(/-/g, '/');
	                        events[new Date(availability_date_item)] = new Event("availability-date-item");
	                    });
	                });

	                $(document).ready(function() {
				    	checkSize();
					    $(window).resize(checkSize);

						function checkSize() {
							var currentSize = Foundation.MediaQuery.current;
							var numberOfMonths = $('.availability-spots-select').datepicker('option', 'numberOfMonths');
						    if (currentSize == 'small' || currentSize == 'medium') {
								$('.availability-spots-select').datepicker('option', 'numberOfMonths', 1);
							}
							else if (currentSize == 'large' || currentSize == 'xlarge' || currentSize == 'xxlarge') {
								$('.availability-spots-select').datepicker('option', 'numberOfMonths', [1,2]);
							}
						}
					});

					$('.availability-spots-select').datepicker({
				        inline: true,
					    dateFormat: 'yy-mm-dd',
					    firstDay: 1,
					    showOtherMonths: true,
					    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
					    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
					    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
					    altFormat: "yy-mm-dd",
        				altField: ".advert-book-date",
					    beforeShowDay: function(date) {
							var event = events[date];

					        if (event) {
					            return [true, event.className];
					        }
					        else {
					            return [false, ''];
					        }
					    },
					    onSelect: function(date) {
					    	var date_format = date.split("-");
							var date_day = date_format[2].replace(/^0+/, '');
							var date_month = date_format[1];

							function GetFullMonthName(date_month) {
								var months = ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"];
								return months[date_month-1];
							}

							date_month_full = GetFullMonthName(date_month);
							format_date_month = date_format[1].replace(/^0+/, '');

					    	$('.select-children-callout').css("display", "block");

					    	var available_spots = '';

							$.getJSON('availability-spots.php?id='+advert_id+'&date='+date+'', function(data) {
			                    $.each(data, function(key, val) {
			                    	available_spots = val.availability_spots;

			                    	if (val.availability_spots == 1) {
			                    		$('.select-children-alert').html('Deze opvang-ouder heeft nog plaats voor '+val.availability_spots+' kind op '+date_day+' '+date_month_full+'.');
			                    	}
			                    	else if (val.availability_spots >= 1) {
			                    		$('.select-children-alert').html('Deze opvang-ouder heeft nog plaats voor '+val.availability_spots+' kinderen op '+date_day+' '+date_month_full+'.');
			                    	}
			                    });
			                });

							$('input.advert-select-children').on('change', function(evt) {
								current_class = $(this).closest('.select-child-container').attr('class');
								$(this).closest('.select-child-container').css("background-color", "red");
								//alert(current_class);

								if($("input[name^='advert-select-children']:checked").length > available_spots) {
									this.checked = false;
								}
							});
						}
					});
				}
			});
		</script>-->

		<script>
			$(document).ready(function() {
				var getUrlParameter = function getUrlParameter(sParam) {
				    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				        sURLVariables = sPageURL.split('&'),
				        sParameterName,
				        i;

				    for (i = 0; i < sURLVariables.length; i++) {
				        sParameterName = sURLVariables[i].split('=');

				        if (sParameterName[0] === sParam) {
				            return sParameterName[1] === undefined ? true : sParameterName[1];
				        }
				    }
				};

				var advert_id = getUrlParameter('id');

				if (typeof advert_id !== 'undefined') {

					var AvailableDates = new Array();
					var AvailableTimesStart = new Array();
					var AvailableTimesEnd = new Array();

	                $.getJSON('availability-dates.php?id="'+advert_id+'"', function(data) {
	                    $.each(data, function(key, val) {
	                        AvailableDates.push(val.availability_date);
	                        AvailableTimesStart.push(val.availability_time_start);
	                        AvailableTimesEnd.push(val.availability_time_end);
	                    });
	                });

					var date_sort_asc = function (date1, date2) {
						if (date1 > date2) {
							return 1;
						}
						else if (date1 < date2) {
							return -1;
						}

						return 0;
					};

					AvailableDates.sort(date_sort_asc);

					for (var i = 0; i < AvailableDates.length; i++) {
						var date_format = AvailableDates[i].split("-");
						var date_day = date_format[2].replace(/^0+/, '');
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

						$(".advert-availability-month[data-availability-format='"+format_date_month+'-'+date_year+"'] .advert-availability-dates").append('<div class="small-6 columns availability-slot-container float-left"><div class="availability-slot"><div class="small-3 columns selected-date"><p>'+date_day+'</p><p>'+date_month_short+'</p><input type="hidden" class="selected-date-input" value="'+AvailableDates[i]+'"></div><div class="small-4 columns selected-time"><p>'+AvailableTimesStart[i].slice(0,-3)+'</p></div><div class="small-1 columns availability-slot-duration" data-icon="y"></div><div class="small-4 columns selected-time"><p>'+AvailableTimesEnd[i].slice(0,-3)+'</p></div></div></div>');
					}

					$('.availability-slot-container').on('click', function() {
						$(this).parent().parent().parent().find(".availability-slot").css("background-color", "#FFFFFF");
						$(this).find(".availability-slot").css("background-color", "#F6F6F6");

						var date = $(this).find('.selected-date-input').val();
						$('input.advert-book-date').val(date);

						var date_format = date.split("-");
						var date_day = date_format[2].replace(/^0+/, '');
						var date_month = date_format[1];

						function GetFullMonthName(date_month) {
							var months = ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"];
							return months[date_month-1];
						}

						date_month_full = GetFullMonthName(date_month);
						format_date_month = date_format[1].replace(/^0+/, '');

				    	$('.select-children-callout').css("display", "block");

				    	var available_spots = '';

						$.getJSON('availability-spots.php?id='+advert_id+'&date='+date+'', function(data) {
		                    $.each(data, function(key, val) {
		                    	available_spots = val.availability_spots;

		                    	if (val.availability_spots == 1) {
		                    		$('.select-children-alert').html('Deze opvang-ouder heeft nog plaats voor '+val.availability_spots+' kind op '+date_day+' '+date_month_full+'.');
		                    	}
		                    	else if (val.availability_spots >= 1) {
		                    		$('.select-children-alert').html('Deze opvang-ouder heeft nog plaats voor '+val.availability_spots+' kinderen op '+date_day+' '+date_month_full+'.');
		                    	}
		                    });
		                });

						$('input.advert-select-children').on('change', function(evt) {
							if($("input[name^='advert-select-children']:checked").length > available_spots) {
								this.checked = false;
							}
						});
					});
				}
			});
		</script>
	</body>
</html>