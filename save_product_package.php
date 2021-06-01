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
	// var_dump($_POST['product_packages']);
	
	
	$package_object_array = json_decode($_POST['product_packages']);
	// $package_price = get_field_value_by_id('settings','name_price',1);
	$package_price = 49.95;
	foreach($package_object_array as $single_package){
		// create & initialize a curl session
		$curl = curl_init();
		

		$field_value_array = array( "name" => $single_package->product_name, "customer_id" => $customer_id);

		$result = get_by_table_multi_field_value('customer_packages', $field_value_array);
		if($result->num_rows == 0){
			// set our url with curl_setopt()
			if($single_package->product_name == "Developer Package"){
				curl_setopt($curl, CURLOPT_URL, "https://usa.tnsapi.cloud/call.cfm?apikey=k4b1a7f2&command=PRODUCTS&type=developer&cc=$customer_email");
			}elseif($single_package->product_name == "Speculator Package"){
				curl_setopt($curl, CURLOPT_URL, "https://usa.tnsapi.cloud/call.cfm?apikey=k4b1a7f2&command=PRODUCTS&type=speculator&cc=$customer_email");
			}
		}
		
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

	$error = store_packages($package_object_array,$package_price,$_SESSION['login_token']);
	if($error == 0){
		echo "success";
	}else{
		echo "failure";
	}
}