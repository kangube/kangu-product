<?php 
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-overzicht</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="full-width-advert-confirmation">
			<div class="advert-confirmation-gradient"></div>

			<div class="row">
				<div class="small-12 medium-8 large-6 small-centered columns advert-confirmation-container">
					<div class="advert-confirmation-header">
						<span class="confirmation-icon" data-icon="m"></span>
						<h3>Je persoonlijke advertentie is aangemaakt!</h3>
						<p>Binnenkort zal je gecontacteerd worden door één van onze medewerkers om samen jouw advertentie te evalueren.</p>
						<p>Met het uitvoeren van deze maatregel willen we het de veiligheid op het platform vrijwaren door mensen met slechte bedoelingen geen onmiddelijke toegang tot het platform te geven. Verder kunnen we op deze manier ook de identiteit iedere opvangbiedende ouder authenticeren.</p>
						<p>Tot je advertentie geëvalueerd is blijft deze nog in voorbehoud en zal deze nog niet op het platform geplaatst worden.</p>
						<a class="confirmation-button" href="">Ik begrijp het</a>
					</div>
				</div>
			</div>
		</div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>