<?php
session_start();
require_once("../php-assets/class.user.php");

$user = new USER();
$error_message = "";
$success_message = "";

if($user->is_loggedin()!="")
{
    $user->redirect('advert-overview.php');
}

// Getting the given e-mail and decoding it to a readable string
$user_email = strip_tags($_GET['mail']);
$email_decoded = base64_decode(strtr($user_email, '-_', '+/'));

// Gathering the user information based on the given e-mail
$stmt = $user->runQuery("SELECT * FROM tbl_user WHERE user_email=:user_email");
$stmt->execute(array(":user_email"=>$email_decoded));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

// Changing the password and updating the database
if(isset($_POST['password-reset-button'])) 
{
    $user_new_password = strip_tags($_POST['user-password']);
    $_SESSION['user_password'] = strip_tags($_POST['user-password']);

    if($user->resetPassword($email_decoded, $user_new_password))
    {
        $success_message = "Wachtwoord gewijzigd!";
    }
    else
    {
        $error_message = "Je wachtwoord is niet gewijzigd.";
    }
}

// Redirecting user after successful password change
if(isset($_POST['password-reset-login-button'])) 
{   
    if ($user->doLogin($email_decoded, $_SESSION['user_password'])) {
        $user->redirect('advert-overview.php');
    }
}
?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Wachtwoord wijzigen</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

    <body>
        <div class="full-width full-width-password-reset">
            <div class="half-height-gradient"></div>
                <div class="row">
                <?php if (!empty($success_message)) { ?>
                                <div class="large-4 medium-6 small-12 small-centered columns password-reset-input-panel">
                                    <div class="row">
                                        <div class="small-12 text-center columns">
                                            <form method="post" data-abide novalidate>
                                                <span class="confirmation-icon" data-icon="B"></span>
                                                <h3><?php echo $success_message; ?></h3>
                                                <p class="success-message">Jouw nieuw wachtwoord werd opgeslagen en kan vanaf nu gebruikt worden.</p>
                                                <input type="submit" class="password-reset-login-button" value="Opnieuw aanmelden" name="password-reset-login-button">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                                
                    <?php } else { ?>
                                <div class="large-4 medium-6 small-12 small-centered columns password-reset-input-panel">
                                    <form method="post" data-abide novalidate>
                                        <div class="row">
                                            <div class="small-12 text-center columns">
                                                <h1 class="password-reset-header">Wachtwoord wijzigen</h1>
                                                <hr class="blue-horizontal-line"></hr>
                                            </div>

                                            <div class="small-12 columns password-reset-instructions">
                                                <ul class="password-reset-profile-information">
                                                    <li><img src="<?php echo $userRow['user_image_path']; ?>"></li>
                                                    <li><?php echo $email_decoded; ?></li>
                                                </ul>
                                            </div>

                                            <div class="small-12 columns">
                                                <input type="password" id="password" placeholder="jouw nieuw wachtwoord" name="user-password" 
                                                       pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z]).*$" required>
                                                <div class="form-error">Dit is geen geldig wachtwoord.</div>
                                            </div>

                                            <div class="small-12 columns">
                                                <input type="password" placeholder="herhaling van jouw nieuw wachtwoord" name="user-password-repeat" 
                                                       data-equalto="password" required>
                                                <div class="form-error">Dit wachtwoord komt niet overeen met het ingegeven wachtwoord.</div>
                                            </div>

                                            <div class="small-12 columns">
                                                <?php 
                                                    if (!empty($error_message)) {
                                                        echo '<div class="error-message" style="display: block;">'.$error_message.'</div>';
                                                    } else if (!empty($success_message)) {
                                                        echo '<div class="sucess-message" style="display: block;">'.$success_message.'</div>';
                                                    }
                                                ?>
                                            </div>

                                            <div class="large-12 columns">
                                                <input type="submit" class="password-reset-button" value="Wachtwoord opslaan" name="password-reset-button">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script src="../js/minimum-viable-product.min.js"></script>
        <script src="https://use.typekit.net/vnw3zje.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>