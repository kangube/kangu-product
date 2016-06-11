<?php 
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.booking.php");

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
			while($advert = $advert_creator_details->fetch(PDO::FETCH_ASSOC)) {
				$advert_user_id = $advert['user_id'];
			}

			// Calculating the booking price based on the chosen services
			$services = $_POST['advert-book-services'];
			$booking_price = 0;
			foreach(array_unique($services) as $key => $service) {
				if (!isset($CombinedServicesArray[$service])) {
					continue;
				}
				$booking_price += $CombinedServicesArray[$service];
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
			$booking->Save();

			$booking->Date = $_POST['advert-book-date'];
			$booking->SaveBookedDate();

			$booking->ChildId = $_POST['advert-select-children'];
			$booking->SaveBookedChildren();

			$booking->UpdateAdvertNumberBookings();
			$booking->UpdateAvailabilitySpots();
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
			echo $error;
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
				  			<h3 class="form-header">Opvangdatum</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer de datum waarvoor u graag opvang zou willen aanvragen.</p>
							<div class="advert-availability-slots"></div>
							<input type="hidden" class="advert-book-date" name="advert-book-date">
						</div>

						<div class='form-select-children-container'>
							<h3 class="form-header">Aantal kinderen</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer welke van jouw kinderen moeten opgevangen worden zodat de opvang-ouder op de hoogte is van welke kinderen men dient op te vangen.</p>

							<div class="callout select-children-callout">
								<p class="select-children-alert"></p>
							</div>

							<?php
								$check_user_has_provided_children = $auth_user->hasProvidedChildren($userRow['user_id']);
								if($check_user_has_provided_children) {

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
													<select class="advert-school child-school" name="advert-book-child-school[]"></select>
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
						<h3 class="form-header">Dienstverlening</h3>
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
							<textarea id="info" name="advert-book-extra-information" placeholder="Geef hier eventuele extra informatie mee waarvan de opvang-ouder dient op de hoogte gebracht te worden." rows="5" cols="10"></textarea>
						</div>

						<div class="form-submit-request-container">
							<input id="advert-create-request-button" type="submit" name="advert-create-request-button" value="Opvang-aanvraag versturen"/>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
		<script src="https://use.typekit.net/vnw3zje.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>

		<script>
			$.getJSON('availability-schools.php', function(data) {
				$('.advert-school').append('<option value="" selected="selected">Basisschool van jouw kind</option>');

				$.each(data, function(key, val) {
					var school_name = "";
					school_name = val["school_name"].replace(/ /g, '&#32;');
				    $('.advert-school').append('<option value='+school_name+'>'+val["school_name"]+'</option>');
				});
			});
		</script>

		<script>
			$(document).ready(function() {
				$('.advert-book-add-child-button').on("click", function() {
					$('.form-select-children-container > .number-children-container').append('<div class="child-container"><div class="child-container-input-field"><input type="text" class="child-name" name="advert-book-child-name[]" placeholder="Voor- en achternaam van jouw kind" required></div><div class="child-container-input-field"><select class="child-age" name="advert-book-child-age[]" required><option value="">Leeftijd van jouw kind</option><option value="3">3 jaar oud</option><option value="4">4 jaar oud</option><option value="5">5 jaar oud</option><option value="6">6 jaar oud</option><option value="7">7 jaar oud</option><option value="8">8 jaar oud</option><option value="9">9 jaar oud</option><option value="10">10 jaar oud</option><option value="11">11 jaar oud</option><option value="12">12 jaar oud</option></select></div><div class="child-container-input-field"><select class="advert-school child-school" name="advert-book-child-school[]" required></select></div><div class="child-container-input-field"><input type="text" class="child-class" name="advert-book-child-class[]" placeholder="Klasnummer van jouw kind" required></div><div class="child-container-input-field"><a class="advert-book-save-child-button">Toevoegen</a></div></div>');
					var closest_advert_school_select = $(this).prev().children('.child-container').last().find('.advert-school');
					closest_advert_school_select.append('<option value="" selected="selected">Basisschool van jouw kind</option>');
					
					$.getJSON('availability-schools.php', function(data) {
						$.each(data, function(key, val) {
							var school_name = "";
							school_name = val["school_name"].replace(/ /g, '&#32;');
						    closest_advert_school_select.append('<option value='+school_name+'>'+val["school_name"]+'</option>');
						});
					});
				});

				$('.advert-book-save-child-button').on("click", function (e) {
					e.preventDefault();

					current_child_parent = $(this).parent().parent().parent().find('.child-parent-id').val();
					current_child_name = $(this).parent().parent().find('.child-name').val();
					current_child_age = $(this).parent().parent().find('.child-age').val();
					current_child_school = $(this).parent().parent().find('.child-school').val();
					current_child_class = $(this).parent().parent().find('.child-class').val();

					if (current_child_parent.length > 0 && current_child_name.length > 0 && current_child_age.length > 0 && current_child_school.length > 0 && current_child_class.length > 0) {

						alert(current_child_parent);
					
						$.ajax({
							type: 'post',
							dataType: 'html',
							url: '../php-assets/class.provide-child.php',
							data: {childParent:current_child_parent, childName:current_child_name, childAge:current_child_age, childSchool:current_child_school, childClass:current_child_class},
							cache: false,
							success: function(data) {
								alert(data);
								$(this).parent('.child-container-input-field').parent().hide();
								//$('.provided-children-container').append('select-child-container');
							},
							error: function(){
						       alert('something failed!');
						    }
						});
					}
					else {
						$(this).parent().parent().parent().find('.child-container-error').css('display', 'block');
						$(this).parent().parent().parent().find('.child-container-error').html('Alle velden dienen verplicht ingevuld te worden.');
					}
				});
			});
		</script>

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
	                /*var Event = function(className) {
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
					});*/


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
							//current_class = $(this).closest('.select-child-container').attr('class');
							//$(this).closest('.select-child-container').css("background-color", "red");

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