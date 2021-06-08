<?php 
session_start();
require 'config/connect_db.php';
require 'services/db_functions.php';
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	
	$customer = get_customer_by_token($_SESSION['login_token']);
	// $digital_name = $_GET['digital_name'];
	$customer_api = $customer['api_key'];
	$customer_cc = $customer['cc'];
	$customer_id = $customer['id'];
	$customer_email = $customer['email'];
	$names_array = explode(",",trim($_POST['names'],","));
	$name_price = get_field_value_by_id('settings','name_price',1);
	foreach($names_array as $single_name){
		// create & initialize a curl session
		$curl = curl_init();

		// set our url with curl_setopt()
		curl_setopt($curl, CURLOPT_URL, "http://usa.tnsapi.cloud/call.cfm?apikey=k4b1a7f2&command=addnamekey&DigitalName=$single_name&cc=$customer_email");

		// return the transfer as a string, also with setopt()
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// curl_exec() executes the started curl session
		// $output contains the output string
		$output = curl_exec($curl);

		// echo $output;
		// close curl resource to free up system resources
		// (deletes the variable made by curl_init)
		curl_close($curl);

	}

	$error = store_names($_POST['names'],$name_price,$_SESSION['login_token']);
	if($error == 0){
		echo "success";
	}else{
		echo "failure";
	}
}