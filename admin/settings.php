<?php 
session_start();
require '../config/connect_db.php';
require '../services/db_functions.php';

if(isset($_SESSION['login_token']) && check_admin_login_token($_SESSION['login_token'])){
	if(isset($_POST['operation_update_warning_credit'])){
		update_settings('warning_credit',$_POST['warning_credit']);
		update_settings('out_of_credits_message',$_POST['out_of_credits_message']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_name_price'])){
		update_settings('name_price',$_POST['name_price']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_paypal_client_id'])){
		update_settings('paypal_client_id',$_POST['paypal_client_id']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_api_settings'])){
		update_settings('api_key',$_POST['api_key']);
		update_settings('api_url',$_POST['api_url']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_affiliate_settings'])){
		update_settings('affiliate_program_type',$_POST['affiliate_program_type']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_everflow_code'])){
		update_settings('everflow_code',$_POST['everflow_code']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_sale_percentage'])){
		update_settings('sale_percentage',$_POST['sale_percentage']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_company_name'])){
		update_settings('company_name',$_POST['company_name']);
		header("Location: settings.php");
	}elseif(isset($_POST['operation_update_email'])){
		update_admin('email',$_POST['email'],$_SESSION['login_token']);
	}elseif(isset($_POST['operation_update_password'])){
		update_admin('password',$_POST['password'],$_SESSION['login_token']);
	}elseif(isset($_POST['operation_update_everflow_js_sdk_code_brand_id'])){
		update_settings('everflow_js_sdk_code',$_POST['everflow_js_sdk_code']);
		update_settings('brand_id_conversion_code',$_POST['brand_id_conversion_code']);
	}


	$result = get_by_id('settings', 1);
	$settings = mysqli_fetch_assoc($result);

	$admin_result = get_admin_by_token($_SESSION['login_token']);
	$admin = mysqli_fetch_assoc($admin_result);

	$email = ($admin_result->num_rows > 0) ? $admin['email'] : '' ;
	$password = ($admin_result->num_rows > 0) ? $admin['password'] : '' ;

	$warning_credit = ($result->num_rows > 0) ? $settings['warning_credit'] : 0 ;
	$name_price = ($result->num_rows > 0) ? $settings['name_price'] : 0 ;
	$paypal_client_id = ($result->num_rows > 0) ? $settings['paypal_client_id'] : '' ;
	$api_key = ($result->num_rows > 0) ? $settings['api_key'] : '' ;
	$api_url = ($result->num_rows > 0) ? $settings['api_url'] : '' ;
	$out_of_credits_message = ($result->num_rows > 0) ? $settings['out_of_credits_message'] : '' ;
	$affiliate_program_type = ($result->num_rows > 0) ? $settings['affiliate_program_type'] : '' ;
	$everflow_code = ($result->num_rows > 0) ? $settings['everflow_code'] : '' ;
	$sale_percentage = ($result->num_rows > 0) ? $settings['sale_percentage'] : '' ;
	$company_name = ($result->num_rows > 0) ? $settings['company_name'] : '' ;
	$everflow_js_sdk_code = ($result->num_rows > 0) ? $settings['everflow_js_sdk_code'] : '' ;
	$brand_id_conversion_code = ($result->num_rows > 0) ? $settings['brand_id_conversion_code'] : '' ;
	
}else{
	header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="fix full div_mid">
		<?php include('layouts/admin_panel_head.php'); ?>
		
		<div class="fix full">
			<?php include('layouts/admin_panel_left_menu.php'); ?>	
			
			<div class="fix floatleft eighty_percent pt_10 pr_10 pb_10 pl_10 border_box">
				<h1 class="fs_30 lh_40 font_bold text_dark_ash mb_10 pl_5 pr_5">Admin Settings</h1>
				<div class="fix full">
					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_warning_credit"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">Low Credit Warning</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="number" 
								name="warning_credit" 
								id="warning_credit" 
								placeholder="Enter a number" 
								value="<?php echo $warning_credit; ?>"
								min="0.00" 
								step="0.01"/>
								<textarea
								class="full h_100 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_10" 
								type="text" 
								name="out_of_credits_message" 
								id="out_of_credits_message" 
								placeholder="Enter a Message"><?php echo $out_of_credits_message; ?></textarea>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>
					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_name_price"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">Digital Name Price</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="number" 
								name="name_price" 
								id="name_price" 
								placeholder="Enter a number" 
								value="<?php echo $name_price; ?>"
								min="0.00" 
								step="0.01"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>
					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_paypal_client_id"/>
							<p class="fs_14 font_bold text_dark_ash lh_22">Paypal Client ID</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="paypal_client_id" 
								id="paypal_client_id" 
								placeholder="Enter a Paypal Client ID" 
								value="<?php echo $paypal_client_id; ?>"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>

					

					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_company_name"/>
							<p class="fs_14 font_bold text_dark_ash lh_22">Company Name</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="company_name" 
								id="company_name" 
								placeholder="Enter a Company Name" 
								value="<?php echo $company_name; ?>"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>

					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_email"/>
							<p class="fs_14 font_bold text_dark_ash lh_22">Email</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="email" 
								id="email" 
								placeholder="Enter an email" 
								value="<?php echo $email; ?>"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>

					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_password"/>
							<p class="fs_14 font_bold text_dark_ash lh_22">Password</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="password" 
								name="password" 
								id="password" 
								placeholder="Enter a password" 
								value="<?php echo $password; ?>"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>
					
				</div>
				
				<div class="fix full bb_3 border_bottom_solid border_bottom_ash mt_30 display_block clear_both"></div>

				<div class="fix full">
					<h1 class="fs_30 lh_40 font_bold text_dark_ash mt_30 mb_10 pl_5 pr_5">Affiliate Account Settings</h1>
					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_affiliate_settings"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">Affiliate Type</p>
								<select 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								name="affiliate_program_type" 
								id="affiliate_program_type" 
								>
									<option value="" <?php echo ($affiliate_program_type == '' || $affiliate_program_type == null) ? 'selected' : '' ; ?>>None</option>
									<option value="tns" <?php echo ($affiliate_program_type == 'tns') ? 'selected' : '' ; ?>>INTERNAL</option>
									<option value="everflow" <?php echo ($affiliate_program_type == 'everflow') ? 'selected' : '' ; ?>>EVERFLOW</option>
								</select>
								<button
								class="cursor_pointer display_block full mt_10 bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold pl_16 pr_16" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>
					<?php if($affiliate_program_type == 'everflow') { ?>
					<!-- <div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_everflow_code"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">EVERFLOW Code</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="everflow_code" 
								id="everflow_code" 
								placeholder="Enter your EVERFLOW Tracking Link" 
								value="<?php echo $everflow_code; ?>"/>

								<button
								class="cursor_pointer display_block full mt_10 bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold pl_16 pr_16" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div> -->

					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_everflow_js_sdk_code_brand_id"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">Everflow JS SDK Code</p>
								<textarea
								class="full h_100 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_10" 
								type="text" 
								name="everflow_js_sdk_code" 
								id="everflow_js_sdk_code" 
								placeholder="Enter a Everflow JS SDK Code"><?php echo $everflow_js_sdk_code; ?></textarea>
								<p class="fs_14 font_bold text_dark_ash lh_22">Brand ID Conversion Code</p>
								<textarea
								class="full h_100 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_10" 
								type="text" 
								name="brand_id_conversion_code" 
								id="brand_id_conversion_code" 
								placeholder="Enter a Message"><?php echo $brand_id_conversion_code; ?></textarea>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>

					
					<?php } ?>
					<?php if($affiliate_program_type == 'tns') { ?>
					<!-- <div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_sale_percentage"/>
							<p class="fs_14 font_bold text_dark_ash lh_22">Sale Percentage</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="sale_percentage" 
								id="sale_percentage" 
								placeholder="Enter sale_percentage" 
								value="<?php echo $sale_percentage; ?>"
								min="0.00" 
								step="0.01"/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div> -->
					<?php } ?>
				</div>

				<div class="fix full bb_3 border_bottom_solid border_bottom_ash mt_30 display_block clear_both"></div>

				<div class="fix full">
					<h1 class="fs_30 lh_40 font_bold text_dark_ash mt_30 mb_10 pl_5 pr_5">API Settings</h1>
					<div class="fix half floatleft">
						<div class="fix ninty_percent div_mid pt_10 pr_10 pb_10 pl_10 border_box">
							<form action="settings.php" method="post">
								<input type="hidden" name="operation_update_api_settings"/>
								<p class="fs_14 font_bold text_dark_ash lh_22">API Key</p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="api_key" 
								id="api_key" 
								placeholder="Enter API Key" 
								value="<?php echo $api_key; ?>"
								/>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_10" 
								type="text" 
								name="api_url" 
								id="api_url" 
								placeholder="Enter API URL" 
								value="<?php echo $api_url; ?>"
								/>
								<button
								class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
								type="submit" 
								id="check_digital_name_button">Update</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/pages/admin/setting_page.js"></script>
</body>
</html>