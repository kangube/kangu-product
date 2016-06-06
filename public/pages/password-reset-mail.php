<?php
session_start();
require_once("../php-assets/class.user.php");
require '../php-assets/PHPMailerAutoload.php';

$user = new USER();
$error_message = "";
$success_message = "";

if($user->is_loggedin()!="")
{
    $user->redirect('advert-overview.php');
}

if(isset($_POST['password-reset-mail-button'])) {

    $user_email = strip_tags($_POST['user-email']);
    $encoded_user_email = rtrim(strtr(base64_encode($user_email), '+/', '-_'), '=');

    $check_email_exists = $user->emailExists($user_email);

    if ($check_email_exists === true) {
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
        $mail->addAddress($user_email);
        $mail->Subject = "Wachtwoord opnieuw instellen";
        $mail->Body = "<a href='http://localhost:8888/kangu-product/public/pages/password-reset.php?mail=".$encoded_user_email."'>verander wachtwoord</a>";
        $mail->AltBody = "<a href='http://localhost:8888/kangu-product/public/pages/password-reset.php?mail=".$encoded_user_email."'>verander wachtwoord</a>";

        if ($mail->send()) {
            $error_message = "Jouw e-mail is niet verzonden wegens problemen met de server. Probeer het later nogmaals.";
        } else {
            $success_message = "Jouw e-mail met verdere instructies is verzonden.";
        }
    } else if ($check_email_exists === false) {
        $error_message = "Dit e-mail adres kon niet aan een bestaande account worden gelinkt.";
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
                                        <p>Geef het e-mail adres van jouw account in en wij sturen je een link om je wachtwoord opnieuw in te stellen.</p>
                                    </div>

                                    <div class="small-12 columns">
                                        <input type="email" placeholder="jouw e-mail adres" name="user-email" required>
                                        <div class="form-error">Dit is geen geldig e-mail adres.</div>
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
                                        <input type="submit" class="password-reset-button" value="Verzenden" name="password-reset-mail-button">
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