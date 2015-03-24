<?php

function died($error) {
    // your error code can go here
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br /><br />";
    echo $error."<br /><br />";
    echo "Please go back and fix these errors.<br /><br />";
    die();
}

if( !isset($_POST['email']) ||
    !isset($_POST['message'])) {
    died('We are sorry, but there appears to be a problem with the form you submitted.');      
}

$customer_email = $_POST['email'];
$request_message = $_POST['message'];

$error_message = "";
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

if(!preg_match($email_exp,$customer_email)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
}

if(strlen($request_message) < 2) {
    $error_message .= 'The message you entered do not appear to be valid.<br />';
}

if(strlen($error_message) > 0) {
    died($error_message);
}

function clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
}

$request_message = clean_string($request_message);

$company_email = "contact@doctorsforall.co.uk";
$subject = "Doctors For All";

// Request Email
$request_headers = "MIME-Version: 1.0" . "\r\n";
$request_headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
$request_headers .= 'From: <' . $customer_email . '>' . "\r\n";
$request_headers .= 'Reply-To: <' . $customer_email . '>' ."\r\n";

mail($company_email,$subject,$request_message,$request_headers);

// Response Email
$response_message = "Dear " . $customer_email . "<br /><br />";
$response_message .= "Thanks for contacting us. We will get back to you soon." . "<br /><br />";
$response_message .= "Best Regards," . "<br />";
$response_message .= "Doctors For All";

$response_headers = "MIME-Version: 1.0" . "\r\n";
$response_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$response_headers .= 'From: <' . $company_email . '>' . "\r\n";
$response_headers .= 'Reply-To: <' . $company_email . '>' ."\r\n";

mail($customer_email,$subject,$response_message,$response_headers);

?>