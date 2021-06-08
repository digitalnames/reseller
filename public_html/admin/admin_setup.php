<?php 
require '../config/constants.php';
require '../config/connect_db.php';
require '../services/db_functions.php';

$error = 0;
$msg = '';
$company_name = get_field_value_by_id('settings','company_name',1);
if(isset($_POST['setup_admin'])){
	if($_POST['name']==''){
		$error++;
		$msg .= '- Name is required</br>';
	}
	if($_POST['email']==''){
		$error++;
		$msg .= '- Email is required</br>';
	}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$error++;
		$msg .= '- Email is not valid</br>';
	}
	if($_POST['password']==''){
		$error++;
		$msg .= '- Password is required</br>';
	}
	if($error == 0){
		update_admin_default_credentials($_POST['name'], $_POST['email'], $_POST['password']);
		header("Location: index.php");
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name - Admin Setup</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix w_400 div_mid mt_100">
			
			<form method="post" id="digital_name_form">
				<?php if($msg!=''){?>
				<div class="fix full">
					<p class="fs_14 lh_22 font_bold text_error pl_5 pr_5 pt_10 pb_10"><?php echo $msg; ?></p>
				</div>
				<?php } ?>
				<input type="hidden" name="setup_admin" value="1">
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="text" 
				name="name" 
				id="name" 
				placeholder="Enter a name" 
				value="<?php echo (isset($_POST['name']) ? $_POST['name'] : ''); ?>"/>
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="email" 
				name="email" 
				id="email" 
				placeholder="Enter an email" 
				value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>"/>
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="password" 
				name="password" 
				id="password" 
				placeholder="Enter a password" 
				value="<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); ?>"/>
				<button
				class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
				type="submit" 
				id="check_digital_name_button">Submit</button>
			</form>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
</body>
</html>