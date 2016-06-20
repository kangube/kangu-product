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

    $stmt = $user->runQuery("SELECT user_firstname FROM tbl_user WHERE user_email=:user_email");
    $stmt->execute(array(":user_email"=>$user_email));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $user_first_name = $userRow['user_firstname'];

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
        $mail->IsHTML(true);
        $mail->Subject = "Wachtwoord opnieuw instellen";

        $mail->Body = '<!doctype html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title></title><style type="text/css"> #outlook a{padding: 0;}.ReadMsgBody{width: 100%;}.ExternalClass{width: 100%;}.ExternalClass *{line-height:100%;}body{margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}table, td{border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}p{display: block; margin: 13px 0;}</style><style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700); </style><style type="text/css"> @media only screen and (max-width:480px){@-ms-viewport{width:320px;}@viewport{width:320px;}}</style><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><!--[if mso]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings></xml><![endif]--><style type="text/css"> @media only screen and (min-width:480px){.mj-column-per-100, * [aria-labelledby="mj-column-per-100"]{width:100%!important;}}</style><style type="text/css"> @media only screen and (max-width:480px){.mj-hero-content{width: 100% !important;}}</style></head><body> <div><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;"> <tr> <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="margin:0 auto;max-width:700px;background:url(http://www.kangu.be/assets/index/pattern-tile-alt.png) top center / auto repeat;"><!--[if mso | IE]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;"> <v:fill origin="0.5, 0" position="0.5,0" type="tile" src="http://www.kangu.be/assets/index/pattern-tile-alt.png"/> <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0"><![endif]--><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:url(http://www.kangu.be/assets/index/pattern-tile-alt.png) top center / auto repeat;" align="center" border="0" background="http://www.kangu.be/assets/index/pattern-tile-alt.png"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:40px 0px 40px 0px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:undefined;width:300px;"><![endif]--><div style="margin:0 auto;max-width:300px;"><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:20px 0px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;"><![endif]--><div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;"><table cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-bottom:20px;" align="center"><table cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="center" border="0"><tbody><tr><td style="width:150px;"><img alt="" height="37.12px" src="http://www.kangu.be/assets/index/kangu-logotype.png" style="border:none;display:block;outline:none;text-decoration:none;width:100%;height:37.12px;" width="150"></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td><td style="vertical-align:undefined;width:300px;"><![endif]--><div style="margin:0 auto;max-width:400px;background:#FFFFFF;"><table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF;" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 20px 30px 20px;"><!--[if mso | IE]> <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;"><![endif]--><div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;"><table cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Hallo '.$user_first_name.'!</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Je ontvangt deze e-mail omdat je graag het wachtwoord van jouw account wil wijzigen. Gebruik de onderstaande button om terug naar het platform geleid te worden en een nieuw wachtwoord in te stellen.</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;" align="left"><table cellpadding="0" cellspacing="0" style="border:none;border-radius:3px;" align="left" border="0"><tbody><tr><td style="background:#F37A7D;border-radius:3px;color:#FFFFFF;cursor:auto;" align="center" valign="middle" bgcolor="#F37A7D"><a href="http://localhost:8888/kangu-product/public/pages/password-reset.php?mail='.$encoded_user_email.'" style="display:inline-block;text-decoration:none;background:#F37A7D;border:1px solid #F37A7D;border-radius:3px;color:#FFFFFF;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;padding:10px 25px;" target="_blank">Wachtwoord veranderen</a></td></tr></tbody></table></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-bottom:0px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Met vriendelijke groeten,</div></td></tr><tr><td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:0px;" align="left"><div style="cursor:auto;color:#6a6a75;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;">Het kangu support-team</div></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]> </td></tr></table><![endif]--></td></tr></tbody></table><!--[if mso | IE]> </v:textbox> </v:rect><![endif]--></div><!--[if mso | IE]> </td></tr></table><![endif]--></div></body></html>';

        $mail->AltBody = "<a href='http://localhost:8888/kangu-product/public/pages/password-reset.php?mail=".$encoded_user_email."'>verander wachtwoord</a>";

        if ($mail->send()) {
            $success_message = "Een e-mail werd verzonden!";
        } else {
            $error_message = "Jouw e-mail is niet verzonden wegens problemen met de server. Probeer het later nogmaals.";
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
                                            <span class="confirmation-icon" data-icon="B"></span>
                                            <h3><?php echo $success_message; ?></h3>
                                            <p class="success-message">Volg de instructies in de e-mail met bijbehorende link om je wachtwoord opnieuw in te stellen.</p>
                                            <a class="confirmation-button" href="login.php">Terug naar login</a>
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
                                                <p>Geef het e-mail adres van jouw account in en wij sturen je een link om je wachtwoord opnieuw in te stellen.</p>
                                            </div>

                                            <div class="small-12 columns">
                                                <input type="email" class="user-email" placeholder="jouw e-mail adres" name="user-email" required>
                                                <div class="form-error">Dit is geen geldig e-mail adres.</div>
                                            </div>

                                            <?php 
                                                if (!empty($error_message)) {
                                                    echo '<div class="small-12 columns"><div class="form-error" style="display: block;">'.$error_message.'</div></div>';
                                                }
                                            ?>

                                            <div class="large-12 columns">
                                                <input type="submit" class="password-reset-button" value="Verzenden" name="password-reset-mail-button">
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