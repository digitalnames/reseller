<?php 
session_start();
require 'config/constants.php';
require 'config/connect_db.php';
require 'services/db_functions.php';

$company_name = get_field_value_by_id('settings','company_name',1);
$affiliate_program_type = get_field_value_by_id('settings','affiliate_program_type',1);
$everflow_js_sdk_code = get_field_value_by_id('settings','everflow_js_sdk_code',1);
$unknown_click = get_field_value_by_id('settings','unknown_click',1);

if(isset($_GET['R'])){
	if(is_new_comer(IP_ADD)){
		if(!add_new_comer(IP_ADD,$_GET['R'])){
			$unknown_click++;
			update_settings('unknown_click',$unknown_click);
		}
	}else{
	    $unknown_click++;
		update_settings('unknown_click',$unknown_click);
	}
}else{
	$unknown_click++;
	update_settings('unknown_click',$unknown_click);
}


if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	$customer = get_customer_by_token($_SESSION['login_token']);

	$field_value_array = array("name" => "Developer Package","customer_id" => $customer['id']);
	$developer_result = get_by_table_multi_field_value('customer_packages', $field_value_array);
	$developer_row = mysqli_fetch_assoc($developer_result);

	$field_value_array = array("name" => "Speculator Package","customer_id" => $customer['id']);
	$speculator_result = get_by_table_multi_field_value('customer_packages', $field_value_array);
	$speculator_row = mysqli_fetch_assoc($speculator_result);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name</title>
	<link rel="stylesheet" href="./css/style.css">
	<?php 
	if($affiliate_program_type == 'everflow'){
		echo $everflow_js_sdk_code;	
	} 
	?>
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix w_400 div_mid mt_100">

			<form method="post" id="digital_name_form">
				<div class="fix full h_30">
					<p class="text_error font_bold lh_22 fs_14 display_none" id="error_message"></p>
				</div>
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
				type="text" 
				name="digital_name" 
				id="digital_name" 
				placeholder="Enter a name" />
				
				<button
				class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
				type="button" 
				id="check_digital_name_button">Check Name</button>
			</form>
			<div class="fix full p_10 border_box mt_10">
				<div class="fix w_50 h_50 div_mid">
					<img src="./images/searching.gif" alt="searching" class="w_50 vertical_align_middle div_mid display_none" id="searching_image"/>
				</div>
			</div>
			<div class="fix full p_10 border_box mt_50 h_100">
				<p 
				id="found_name"
				class="fs_20 text_green lh_40 floatleft display_none">You may take this name</p>
				<button 
				id="found_name_add_to_cart"
				class="cursor_pointer bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold floatright display_none">Add to Cart</button>
			</div>

		</div>
		<div class="fix w_1000 div_mid">
			<div class="fix half floatleft">
				<div class="fix ninty_percent div_mid">
					<h1 class="fs_22 lh_32 font_bold text_dark_ash">Speculator Package</h1>
					<h2 class="fs_22 lh_32 font_bold text_dark_ash">$49.95</h2>
					<p class="fs_14 lh_22 text_dark_ash">A new revenue stream that has reignited the DNS market explosion of the mid 90's.com boom.</p>
					
					<?php if(!isset($_SESSION['login_token']) || (isset($_SESSION['login_token']) && is_null($speculator_row))){ ?>				
					<button class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold lh_40 border_box" id="add_speculator_package_to_cart">Add to Cart</button>
					<p class="fs_14 lh_40 font_bold textcenter display_none text_error" id="speculator_added">Added to Cart</p>	
					<?php }else{ ?>
					<p class="fs_14 lh_40 font_bold textcenter text_error">It's already active</p>
					<?php } ?>
				</div>
			</div>
			<div class="fix half floatleft">
				<div class="fix ninty_percent div_mid">
					<h1 class="fs_22 lh_32 font_bold text_dark_ash">Developer Package</h1>
					<h2 class="fs_22 lh_32 font_bold text_dark_ash">$49.95</h2>
					<p class="fs_14 lh_22 text_dark_ash">Create a front-end that sells Digital Names, incorporate Digital Names into your own wallet, or build your own marketplace.</p>
					
					<?php if(!isset($_SESSION['login_token']) || (isset($_SESSION['login_token']) && is_null($developer_row))){ ?>
					<button class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold lh_40 border_box" id="add_developer_package_to_cart">Add to Cart</button>
					<p class="fs_14 lh_40 font_bold textcenter display_none text_error" id="developer_added">Added to Cart</p>
					<?php }else{ ?>
					<p class="fs_14 lh_40 font_bold textcenter text_error">It's already active</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/index_page.js"></script>
</body>
</html>