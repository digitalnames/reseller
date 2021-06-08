<?php 
session_start();
require 'config/constants.php';
require 'config/connect_db.php';
require 'services/db_functions.php';
$company_name = get_field_value_by_id('settings','company_name',1);
$error_msg = "";
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	header("Location: index.php");
    exit();
}
if(isset($_POST['recover_password'])){
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		if(isEmailUserEmailExist($_POST['email'])){
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
	<title>Digital Name - Recover Password</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix w_400 div_mid mt_100">
			<h1 class="fs_20 lh_30 font_bold text_dark_ash">Recover Password</h1>
			<form method="post" id="digital_name_form">
				<div class="fix full h_30">
					<?php if($error_msg !=""){ ?>
						<p class="text_error font_bold lh_22 fs_14" id="error_message"><?php echo $error_msg; ?></p>
					<?php } ?>
				</div>
				<input type="hidden" name="recover_password" value="1">
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="email" 
				name="email" 
				id="email" 
				value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>"
				placeholder="Enter an email" />
				<button
				class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
				type="submit" 
				id="check_digital_name_button">Submit</button>
			</form>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
</body>
</html>