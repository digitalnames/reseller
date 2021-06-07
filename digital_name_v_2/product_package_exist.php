<?php

session_start();
require 'config/connect_db.php';
require 'services/db_functions.php';
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	
	$customer = get_customer_by_token($_SESSION['login_token']);
	$customer_api = $customer['api_key'];
	$customer_cc = $customer['cc'];
	$customer_id = $customer['id'];
	$customer_email = $customer['email'];


	$product_packages = $_GET['product_packages'];
	$product_packages_array = json_decode($product_packages);

	$error = 0;


	foreach($product_packages_array as $singe_product_package){
		
		$field_value_array = array( "name" => $singe_product_package->product_name, "customer_id" => $customer_id);

		$result = get_by_table_multi_field_value('customer_packages', $field_value_array);
		if($result->num_rows > 0){
			$error++;
		}
	}
	echo $error;

}
?>

