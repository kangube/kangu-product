<?php
session_start();
require_once("../php-assets/class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
{
    $login->redirect('home.php');
}

if(isset($_POST['login-button']))
{
    $user_email = strip_tags($_POST['user-email']);
    $user_password = strip_tags($_POST['user-password']);
        
    if($login->doLogin($user_email, $user_password))
    {
        $login->redirect('home.php');
    }
    else
    {
        $error = "Je inloggegevens zijn niet correct.";
    }   
}
?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aanmelden</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
    </head>

    <body>
        <div class="full-width full-width-login">
            <div class="half-height-gradient"></div>
                <div class="row">
                    <div class="large-4 medium-6 small-12 small-centered columns login-input-panel">
                        <form method="post">
                            <div class="row">
                                <div class="large-12 text-center columns">
                                    <h1 class="login-header">Aanmelden</h1>
                                    <hr class="blue-horizontal-line text-center"></hr>
                                    <input type="email" placeholder="jouw e-mail adres" name="user-email" required>
                                    <input type="password" placeholder="jouw wachtwoord" name="user-password" required>

                                    <?php if(isset($error)) { ?>
                                            <div class="large-12 columns error-callout">
                                                <?php echo $error; ?>
                                            </div>
                                    <?php } ?>

                                    <input type="submit" class="login-account-button" value="Aanmelden" name="login-button">
                                    <a href="#" class="forgot-password-link">Wachtwoord vergeten?</a>
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