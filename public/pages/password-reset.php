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

// Changing the password and updating the database
if(isset($_POST['password-reset-button'])) 
{
    $user_new_password = strip_tags($_POST['user-password']);

    if($user->resetPassword($email_decoded, $user_new_password))
    {
        $success_message = "Je wachtwoord is gewijzigd.";
    }
    else
    {
        $error_message = "Je wachtwoord is niet gewijzigd.";
    }
}
?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Wachtwoord wijzigen</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
    </head>

    <body>
        <div class="full-width full-width-password-reset">
            <div class="half-height-gradient"></div>
                <div class="row">
                    <div class="large-4 medium-6 small-12 small-centered columns password-reset-input-panel">
                        <form method="post" data-abide novalidate>
                            <div class="row">
                                <div class="small-12 text-center columns">
                                    <h1 class="password-reset-header">Wachtwoord wijzigen</h1>
                                    <hr class="blue-horizontal-line"></hr>

                                    <div class="small-12 columns password-reset-instructions">
                                        <p><?php echo 'Wachtwoord wijzigen: '.$email_decoded.' random text to fill all of this massive whitespace.'; ?></p>
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
                                        <input type="submit" class="password-reset-button" value="Verzenden" name="password-reset-button">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/minimum-viable-product.min.js"></script>
        <script src="https://use.typekit.net/vnw3zje.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>