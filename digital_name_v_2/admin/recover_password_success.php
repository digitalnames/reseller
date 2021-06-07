<?php 
require '../config/constants.php';
require '../config/connect_db.php';
require '../services/db_functions.php';
$company_name = get_field_value_by_id('settings','company_name',1);
$error_msg = "";
if(isset($_POST['recover_password'])){
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		if(isEmailAdminEmailExist($_POST['email'])){
			$to = $_POST['email'];
			$subject = 'Recover Password';
		    
		    $from='digitalnamesaffiliate@info.com';
		    $headers ='';
		    $headers .= 'From: '.$from.' '. "\r\n";
		    $message = "The password for your admin access is ".$password;

			$retval = mail($to, $subject, $message, $headers);
			header("Location: recover_password_success.php");
    		exit();
		}else{
			$error_msg = "Email is not exist!!";
		}
	}else{
		$error_msg = "Enter valid email!!";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name - Recover Password Success</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix w_400 div_mid mt_100">
			<h1 class="fs_20 lh_30 font_bold text_dark_ash textcenter text_green">Password recovery mail has been sent to your give mail. <a href="login.php">Log In</a></h1>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
</body>
</html>