<?php 
require 'config/connect_db.php';
require 'services/db_functions.php';
require 'helpers/curl_helper.php';

//error_reporting(-1);
//ini_set('display_errors', 'On');
//set_error_handler("var_dump");


$warning_credit = get_field_value_by_id('settings','warning_credit',1);
$warning_credit = (is_null($warning_credit)) ? 0 : $warning_credit ;

$credits_remaining = get_admin_credit();
$result = get_by_id("admins", 1);
$admin = mysqli_fetch_assoc($result);
if($warning_credit >= $credits_remaining){
    $to = $admin['email'];
	$subject = 'Warning : Credit level low';
    
    $from='digitalnamesaffiliate@info.com';
    
    // $headers ='';
    // $headers .= 'MIME-Version: 1.0' . "\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$from.' '. "\r\n";
    
    // $message = '<html><body>';
    // $message .= '<h1>You only have '.$credits_remaining.' left. Please replenish your credits before you run out.</h1>';
    // $message .= '</body></html>';
    
    $message = "You only have ".$credits_remaining." left. Please replenish your credits before you run out.";


	$retval = mail($to, $subject, $message, $headers);

	if( $retval == true ) {
		echo "Message sent successfully...";
	}else {
		echo "Message could not be sent...";
	}
}