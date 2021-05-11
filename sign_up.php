<?php 
session_start();
require 'config/constants.php';
require 'config/connect_db.php';
require 'services/db_functions.php';

$company_name = get_field_value_by_id('settings','company_name',1);
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	header("Location: index.php");
    exit();
}else{
	
}
$error = 0;
$msg = '';
if(isset($_POST['operation_name'])){
	if($_POST['name']==''){
		$error++;
		$msg .= '- Name is required</br>';
	}
	if($_POST['email']==''){
		$error++;
		$msg .= '- Email is required</br>';
	}
	if($_POST['phone']==''){
		$error++;
		$msg .= '- Phone is required</br>';
	}
	if($_POST['password']==''){
		$error++;
		$msg .= '- Password is required</br>';
	}
	if($error == 0){
		$found = register_customer($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password']);
		if($found){
			header("Location: login.php");
	    	exit();
		}else{
			$msg = 'Couldn\'t create customer!!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix full div_mid mt_50">
			<?php include('layouts/sign_up_form.php'); ?>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/login_page.js"></script>
</body>
</html>