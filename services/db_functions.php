<?php

function insert($table_name, $key_value_array = []){
	global $conn;
	if(!empty($key_value_array)){
		$fields = "`" . implode ( "`, `", array_keys($key_value_array) ) . "`";
		$field_values = "'" . implode ( "', '", array_values($key_value_array) ) . "'";
	}
	$sql = "INSERT INTO `$table_name` ($fields) VALUES ($field_values)";
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}
function register_customer($name, $email, $password){
	global $conn;

	$affiliate_id = 0;
	$result = get_new_comer_by_mac_id(IP_ADD);
	if($result->num_rows > 0){
		$row = mysqli_fetch_assoc($result);
		$affiliate_id = $row['affiliate_id'];
	}

	$table_name = 'customers';
	$sql = 'INSERT INTO `'.$table_name.'` (`name`,`email`,`password`,`affiliate_id`,`registered_at`) VALUES ("'.$name.'","'.$email.'","'.$password.'",'.$affiliate_id.',"'.date('Y-m-d H:i:s').'")';
	if (mysqli_query($conn, $sql)) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	$last_id = mysqli_insert_id($conn);
	if($last_id && $last_id > 0){
		return true;
	} else {
		return false;
	}	
}
function check_user_by_email_password($table, $email, $password){
	global $conn;
	$sql = "SELECT * FROM `$table` WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
}
function check_customer_by_name_password($email, $password){
	return check_user_by_email_password('customers', $email, $password);
}
function check_admin_by_email_password($email, $password){
	return check_user_by_email_password('admins', $email, $password);	
}
function generate_login_token($table, $email, $password){
	global $conn;
	$random_string = bin2hex(random_bytes(70));
	$sql = "UPDATE `$table` SET `login_token` = '$random_string' WHERE email = '$email' AND password='$password'";
	mysqli_query($conn, $sql);

	return $random_string;	
}
function get_login_token($email, $password){
	return generate_login_token('customers',$email,$password);
}
function get_admin_login_token($email, $password){
	return generate_login_token('admins',$email,$password);
}

function store_names($names, $name_price, $login_token){
	global $conn;
	$error = 0;
	$sql = "SELECT * FROM customers WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);
	$customer_id = $row['id'];
	$customer_affiliate_id = $row['affiliate_id'];
	$names_array = ($names != 'null') ? explode(",",trim($names,",")) : [];

	$affiliate_result = get_by_id('affiliates', $customer_affiliate_id);
	$affiliate_row = mysqli_fetch_assoc($affiliate_result);

	$settings_result = get_by_id('settings', '1');
	$settings_row = mysqli_fetch_assoc($settings_result);
	$sale_percentage = (isset($affiliate_row['sale_percentage'])) ? $affiliate_row['sale_percentage'] : 0;
	$affiliate_program_type = $settings_row['affiliate_program_type'];
	$original_price = $settings_row['name_price'];

	if($affiliate_program_type == 'tns' && $customer_affiliate_id > 0 ){
		$admin_percentage = 100-$sale_percentage;
		$affiliate_person_name_price = ($name_price * $sale_percentage) / 100;
		$name_price = ($name_price * $admin_percentage) / 100;
	}

	foreach($names_array as $single_name){
		$sql = "INSERT INTO `names` (`name`,`name_price`,`customer_id`) VALUES ('$single_name','$name_price','$customer_id')";
		if (mysqli_query($conn, $sql)) {
			if($affiliate_program_type == 'tns' && $customer_affiliate_id > 0 ){
				$last_id = mysqli_insert_id($conn);
				$sql = "INSERT INTO `affiliate_name_portions` (`name_id`,`customer_id`,`affiliate_id`,`affiliate_portion_price`, `original_price`,`current_percentage`) VALUES ('$last_id','$customer_id','$customer_affiliate_id','$affiliate_person_name_price', '$original_price','$sale_percentage')";
				mysqli_query($conn, $sql);
			}
		} else {
			$error++;
		}
	}
	return $error;
}
function store_packages($packages, $package_price, $login_token){
	global $conn;
	$error = 0;
	$sql = "SELECT * FROM customers WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);
	$customer_id = $row['id'];
	$customer_affiliate_id = $row['affiliate_id'];
	$packages_array = $packages;


	foreach($packages_array as $single_package){
		$field_value_array = array( "name" => $single_package->product_name, "customer_id" => $customer_id);

		$result = get_by_table_multi_field_value('customer_packages', $field_value_array);
		if($result->num_rows == 0){
			$sql = "INSERT INTO `customer_packages` (`name`,`package_price`,`customer_id`) VALUES ('$single_package->product_name','$package_price','$customer_id')";
			if (mysqli_query($conn, $sql)) {
			} else {
				$error++;
			}
		}
	}
	return $error;
}
function get_names($login_token){
	global $conn;
	$sql = "SELECT * FROM customers WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);
	$customer_id = $row['id'];

	$sql = "SELECT * FROM names WHERE customer_id='$customer_id'";

	$result = mysqli_query($conn, $sql);
	return $result;
	
}
function get_customer_by_token($login_token){
	global $conn;
	$sql = "SELECT * FROM customers WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);
	return $row;
}
function get_admin_by_token($login_token){
	global $conn;
	$sql = "SELECT * FROM admins WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	return $result;
}
function get_customers($login_token){
	global $conn;
	if(check_admin_login_token($login_token)){
		
	}
	$sql = "SELECT * FROM customers WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);
	return $row;	
}
function check_login_token($table, $login_token){
	global $conn;
	$sql = "SELECT * FROM $table WHERE login_token='$login_token'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
}
function check_admin_login_token($login_token){
	return check_login_token('admins', $login_token);	
}
function check_customer_login_token($login_token){
	return check_login_token('customers', $login_token);
}

function get_all_rows_number($table, $single_field_name='id'){
	global $conn;
	$sql = "SELECT $single_field_name FROM `$table`";
	$result = mysqli_query($conn, $sql);
	return mysqli_num_rows($result);
}
function get_customer_number(){
	return get_all_rows_number('customers');
}
function get_name_number(){
	return get_all_rows_number('names');
}

function get_all($table){
	global $conn;
	$sql = "SELECT * FROM `$table`";
	$result = mysqli_query($conn, $sql);
	
	return $result;	
}
function get_all_affiliates(){
	global $conn;
	// $sql = "SELECT a.*,COUNT(DISTINCT c.id) as affiliate_customer_number,COUNT(DISTINCT ac.id) as affiliate_comers_number,COALESCE(SUM(anp.affiliate_portion_price),0) as affiliate_revenue FROM `affiliates` a 
	// LEFT JOIN affiliate_comers ac ON a.id=ac.affiliate_id 
	// LEFT JOIN customers c ON a.id = c.affiliate_id 
	// LEFT JOIN affiliate_name_portions anp on a.id = anp.affiliate_id GROUP BY a.id";
	
	$sql = "SELECT a.*,MAX(COALESCE(c.affiliate_customer_number,0)) as affiliate_customer_number,MAX(COALESCE(ac.affiliate_comers_number,0)) as affiliate_comers_number,MAX(COALESCE(anp.affiliate_revenue,0)) as affiliate_revenue FROM `affiliates` a 
	LEFT JOIN (
		SELECT COUNT(id) as affiliate_comers_number,affiliate_id
		FROM affiliate_comers
		GROUP BY affiliate_id
	) ac ON a.id=ac.affiliate_id 
	LEFT JOIN (
		SELECT COUNT(id) as affiliate_customer_number,affiliate_id
		FROM customers
		GROUP BY affiliate_id
	) c ON a.id = c.affiliate_id 
	LEFT JOIN (
		SELECT COALESCE(SUM(affiliate_portion_price),0) as affiliate_revenue,affiliate_id
		FROM affiliate_name_portions
		GROUP BY affiliate_id
	) anp on a.id = anp.affiliate_id 
	GROUP BY a.id";
	

	$result = mysqli_query($conn, $sql);
	
	return $result;	
}
function get_all_customers_with_name_number(){
	global $conn;
	$sql = "SELECT c.name as customer_name, COUNT(n.id) as name_number FROM `customers` c LEFT JOIN names n ON c.id = n.customer_id GROUP BY c.id";
	$result = mysqli_query($conn, $sql);

	
	return $result;		
}
function get_name_number_by_customer_id($customer_id){
	global $conn;
	$sql = "SELECT COUNT(id) as name_number  FROM `names` WHERE customer_id='$customer_id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['name_number'];
}
function get_by_id($table, $id){
	global $conn;
	$sql = "SELECT * FROM `$table` WHERE id='$id'";
	$result = mysqli_query($conn, $sql);
	// $row = mysqli_fetch_object($result);	
	return $result;
}
function get_by_table_single_field_value($table, $field, $value){
	global $conn;
	$sql = 'SELECT * FROM `'.$table.'` WHERE '.$field.'="'.$value.'"';
	$result = mysqli_query($conn, $sql);
	return $result;
}
function get_by_table_multi_field_value($table, $field_value_array){
	global $conn;
	$where_string = '';
	
	$i = 0;
	$length = count($field_value_array);
	foreach($field_value_array as $key=>$value){
		if ($i == $length - 1) {
	    	$where_string .= (is_numeric($value)) ? $key.'='.$value : $key.'="'.$value.'"';
	    }else{
	    	$where_string .= (is_numeric($value)) ? $key.'='.$value.' AND ' : $key.'="'.$value.'" AND ' ;
	    }
	    $i++;
	}
	$sql = 'SELECT * FROM `'.$table.'` WHERE '.$where_string;
	$result = mysqli_query($conn, $sql);
	return $result;
}
function get_total_other_products_signup(){
	global $conn;
	$sql = 'SELECT COUNT(DISTINCT customer_id) AS total_customer FROM customer_packages';
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_customer'];
}
function get_total_other_products_revenue(){
	global $conn;
	$sql = 'SELECT SUM(package_price) AS total_revenue FROM customer_packages';
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_revenue'];
}
function isDefaultAdmin(){
	global $conn;
	$field_value_array = array('email' => 'admin@email.com', 'password' => 'password');
	$result = get_by_table_multi_field_value('admins', $field_value_array);
	if($result->num_rows > 0){
		return true;
	}
	return false;
}
function update_settings($field, $value, $id = 1){
	global $conn;
	if(get_all_rows_number('settings') > 0){
		$sql = "UPDATE `settings` SET `".$field."`='".mysqli_real_escape_string($conn,$value)."' WHERE id ='".$id."'";
	}else{
		$sql = "INSERT INTO `settings` (`".$field."`) VALUES ('".mysqli_real_escape_string($conn,$value)."')";		
	}
	mysqli_query($conn, $sql);
}
function update_admin($field, $value, $login_token){
	global $conn;
	$sql = 'UPDATE `admins` SET `'.$field.'`="'.$value.'" WHERE login_token ="'.$login_token.'"';
	mysqli_query($conn, $sql);
}
function get_field_value_by_id($table,$field,$id){
	global $conn;
	$sql = "SELECT $field FROM `$table` WHERE id='$id'";
	$result = mysqli_query($conn, $sql);
	// $row = mysqli_fetch_object($result);	
	if($result->num_rows > 0){
		$row = mysqli_fetch_assoc($result);
		return $row[$field];
	}
	return null;
	// return $result;	
}
function get_revenue(){
	global $conn;
	$sql = "SELECT SUM(name_price) as revenue  FROM `names`";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['revenue'];
}
function get_total_income(){
	global $conn;
	$sql = "SELECT SUM(affiliate_portion_price) as total_income  FROM `affiliate_name_portions`";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_income'];	
}
function add_affiliate($title, $link, $affiliate_string, $sale_percentage = 0){
	global $conn;
	$table_name = 'affiliates';
	$fields = "`title`,`affiliate_string`,`domain`,`sale_percentage`";
	$field_values = "'$title','$affiliate_string','$link',$sale_percentage";
	$sql = "INSERT INTO `$table_name` ($fields) VALUES ($field_values)";
	mysqli_query($conn, $sql);
	$last_id = mysqli_insert_id($conn);
	if($last_id && $last_id > 0){
		return true;
	} else {
		return false;
	}	
}
function delete_affiliate($id){

	global $conn;
	$table_name = 'affiliates';
	$sql = "DELETE FROM $table_name WHERE id=$id";

	if(mysqli_query($conn, $sql)){
		return true;
	} else {
		return false;
	}
}
function is_new_comer($mac_id){
	global $conn;
	$table_name = 'affiliate_comers';

	$sql = "SELECT * FROM $table_name WHERE mac_id='$mac_id'";
	$result = mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		return false;
	} else {
		return true;
	}	
}
function get_new_comer_by_mac_id($mac_id){
	global $conn;
	$table_name = 'affiliate_comers';

	$sql = "SELECT * FROM $table_name WHERE mac_id='$mac_id'";
	$result = mysqli_query($conn, $sql);

	return $result;
}
function add_new_comer($mac_id,$affiliate_string){
	
	global $conn;
	$table_name = 'affiliates';

	$sql = 'SELECT * FROM '.$table_name.' WHERE affiliate_string="'.$affiliate_string.'"';
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$table_name = 'affiliate_comers';
	$sql = 'INSERT INTO '.$table_name.' (`mac_id`,`affiliate_id`) VALUES ("'.$mac_id.'","'.$row['id'].'")';		
	if(mysqli_query($conn, $sql)){
		return true;
	}else{
		return false;
	}
}
function get_all_affiliate_click_number(){
	global $conn;
	$table_name = 'affiliate_comers';

	$sql = 'SELECT COUNT(id) as total_affiliate_clicks FROM '.$table_name;
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_affiliate_clicks'];
}
function get_all_affiliate_signup_number(){
	global $conn;
	$table_name = 'customers';

	$sql = 'SELECT COUNT(id) as total_affiliate_signups FROM '.$table_name.' WHERE affiliate_id > 0';
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_affiliate_signups'];
}
function get_all_signup_number_without_affiliate(){
	global $conn;
	$table_name = 'customers';

	$sql = 'SELECT COUNT(id) as total_affiliate_signups FROM '.$table_name.' WHERE affiliate_id = 0';
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);	
	return $row['total_affiliate_signups'];
}
function update_admin_default_credentials($name, $email, $password){
	global $conn;
	$sql = "UPDATE `admins` SET `name`='".mysqli_real_escape_string($conn,$name)."', `email`='".mysqli_real_escape_string($conn,$email)."', `password`='".mysqli_real_escape_string($conn,$password)."' WHERE email='admin@email.com' AND password='password'";
	mysqli_query($conn, $sql);
}
function isEmailAdminEmailExist($email){
	global $conn;
	$table_name = 'admins';

	$sql = "SELECT * FROM `".$table_name."` WHERE email='".mysqli_real_escape_string($conn,$email)."'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		return true;
	} else {
		return false;
	}	
}