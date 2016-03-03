<?php 
	
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$a1 = new Advert();

	if(!empty($_POST))
	{
		try 
		{	
			
			$a1->ID = $_POST['ID'];
			$a1->Name = $_POST['name'];
			$a1->Info = $_POST['info'];

			$a1->Save();

			$succes = "Thank you for creating an advert!";


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
							<textarea name="textarea" placeholder="Geef een korte beschrijving jezelf en waarom je deze advertentie aanmaakt" required></textarea>
							<div class="form-error">De beschrijving is te lang.</div>
						</div>

						<div class="form-number-children-container">
							<h3 class="form-header">Beschikbare plaatsen</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer het maximum aantal kinderen waarvoor je opvang wenst aan te bieden.</p>

							<div class="number-children-radio-buttons">
							<label class="badge radio-button"><input type="radio" name="number-children" value="1" required>1</label>
							<label class="badge radio-button"><input type="radio" name="number-children" value="2" required>2</label>
							<label class="badge radio-button"><input type="radio" name="number-children" value="3" required>3</label>
							<label class="badge radio-button"><input type="radio" name="number-children" value="4" required>4</label>
							<label class="badge radio-button"><input type="radio" name="number-children" value="5" required>5</label>
							<label class="badge radio-button"><input type="radio" name="number-children" value="6" required>6</label>
							</div>
						</div>

						<div class="form-contact-information-container">
							<h3 class="form-header">Contact informatie</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Voorzie jouw advertentie van de nodige contact-informatie zodat andere ouders je kunnen contacteren.</p>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="z"></span>
									<input class="form-input" type="tel" placeholder="jouw gsm-nummer">
								</div>
								<div class="form-error">Dit is geen geldig gsm-nummer.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="q"></span>
									<input class="form-input" type="tel" placeholder="jouw huistelefoonnummer">
								</div>
								<div class="form-error">Dit is geen telefoonnummer.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="x"></span>
									<input class="form-input" type="email" placeholder="jouw e-mail adres">
								</div>
								<div class="form-error">Dit is geen geldig e-mail adres.</div>
							</div>

							<div class="small-12 medium-6 large-6 columns form-icon-input-field">
								<div class="form-icon-input-container">
									<span class="form-icon" data-icon="v"></span>
									<input class="form-input" type="text" placeholder="jouw adres en gemeente">
								</div>
								<div class="form-error">voorbeel: bosstraat 2, Heist-op-den-Berg</div>
							</div>
						</div>

						<div class="form-transportation-container">
							<h3 class="form-header">Verplaatsingsmogelijkheden</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Geef aan op welke manier je de kinderen van en naar school voert. (Meerdere opties zijn mogelijk)</p>
							<div class="checkbox transportation-checkbox">
								<input type="checkbox" id="auto"/>
  								<label for="auto"><span></span>Met de auto</label>
							</div>

							<div class="checkbox transportation-checkbox">
								<input type="checkbox" id="openbaar-vervoer"/>
  								<label for="openbaar-vervoer"><span></span>Openbaar verv.</label>
							</div>

							<div class="checkbox transportation-checkbox">
								<input type="checkbox" id="fiets"/>
  								<label for="fiets"><span></span>Met de fiets</label>
							</div>

							<div class="checkbox transportation-checkbox">
								<input type="checkbox" id="wandelend"/>
  								<label for="wandelend"><span></span>Te voet</label>
							</div>
						</div>

						<div class="small-12 columns form-services-container">
							<h3 class="form-header">Aangeboden diensten</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Selecteer welke diensten je wenst aan te bieden aan andere ouders.</p>

							<div class="small-6 medium-4 columns services-checkbox">
								<div class="checkbox">
									<input type="checkbox" id="opvang"/>
	  								<label for="opvang"><span></span>Opvang in een thuisomgeving</label>
								</div>

								<div class="checkbox">
									<input type="checkbox" id="ophalen"/>
	  								<label for="ophalen"><span></span>Ophalen aan de schoolpoort</label>
								</div>
							</div>

							<div class="small-6 medium-4 columns services-checkbox">
								<div class="checkbox">
									<input type="checkbox" id="vervoer-thuis"/>
	  								<label for="vervoer-thuis"><span></span>Vervoer naar thuis na opvang</label>
								</div>

								<div class="checkbox">
									<input type="checkbox" id="vervoer-naschoolse-activiteiten"/>
	  								<label for="vervoer-naschoolse-activiteiten"><span></span>Vervoer naschoolse activiteiten</label>
								</div>
							</div>

							<div class="small-12 medium-4 columns services-checkbox">
								<div class="checkbox">
									<input type="checkbox" id="maaltijd"/>
	  								<label for="maaltijd"><span></span>Voorzien van een maaltijd</label>
								</div>

								<div class="checkbox">
									<input type="checkbox" id="hulp-huiswerktaken"/>
	  								<label for="hulp-huiswerktaken"><span></span>Hulp bij huiswerktaken</label>
								</div>
							</div>
						</div>

						<div class="small-12 columns">
							<p>Door deze advertentie aan te maken ga je akkoord met onze <a href="#">termen en condities</a></p>
							<input id="advert-create-button" type="submit" value="Advertentie aanmaken"/>
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