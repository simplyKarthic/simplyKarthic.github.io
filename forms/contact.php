
<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$code = $_POST['code'];
$message = $_POST['message'];
 
$formcontent=" From: $name \n Email: $email \n Phone: $phone \n code: $code \n Message: $message";
$recipient = "karthicjayaraj@gmail.com";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";

$recaptcha = $_POST['g-recaptcha-response'];
$res = reCaptcha($recaptcha);
if(!$res['success']){
  // Error
}

function reCaptcha($recaptcha){
  $secret = "";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}

?>

  <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL); 
         
        function honeypot_validade ($req) {
           
            if (!empty($req)) {

                $honeypot_fields = [
                    "names",
                    "emails"
                ];

                foreach ($honeypot_fields as $field) {
                    if (isset($req[$field]) && !empty($req[$field])) {
                        return false;
                    }
                }
            }

            return true;
        }

        if (honeypot_validade($_REQUEST)) {
            $is_spammer = false;
            mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
            echo "We will get back to you soon, Thank You! ";
        } else {
            $is_spammer = true;
           echo "sorry try again";
          }
   ?>
