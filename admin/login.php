<?php 
session_start();
require '../config/connect_db.php';
require '../services/db_functions.php';
$company_name = get_field_value_by_id('settings','company_name',1);
if(isset($_SESSION['login_token']) && check_admin_login_token($_SESSION['login_token'])){
	header("Location: index.php");
    exit();
}else{
	
}
$msg = '';
if(isset($_POST['operation_name'])){
	$found = check_admin_by_email_password($_POST['email'], $_POST['password']);
	if($found){
		$_SESSION['login_token'] = get_admin_login_token($_POST['email'], $_POST['password']);
		header("Location: index.php");
    	exit();
	}else{
		$msg = "Wrong Email or Password has been entered!!";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name - Admin</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix full div_mid mt_50">
			<?php include('layouts/login_form.php'); ?>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/pages/login_page.js"></script>
</body>
</html>