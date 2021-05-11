<?php 
session_start();
require 'config/connect_db.php';
require 'services/db_functions.php';

$company_name = get_field_value_by_id('settings','company_name',1);
$affiliate_program_type = get_field_value_by_id('settings','affiliate_program_type',1);
$brand_id_conversion_code = get_field_value_by_id('settings','brand_id_conversion_code',1);
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	global $conn;
	$customer = get_customer_by_token($_SESSION['login_token']);
	$customer_api = $customer['api_key'];
	$customer_cc = $customer['cc'];
	$customer_email = $customer['email'];

	$name_result = get_names($_SESSION['login_token']);
	$all_name_to_show = '';
	while ($obj = mysqli_fetch_object($name_result)) {
		$all_name_to_show .= '<div class="fix full pl_10 pr_10 pt_5 pb_5 border_box bg_very_light_ash2"><p class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->name.'</p></div>';
	}
	mysqli_free_result($name_result);
}else{
	header("Location: checkout_login.php");
    exit();
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
	if($affiliate_program_type == 'everflow' && isset($_GET['from_checkout']) && $_GET['from_checkout'] == 'yes'){
		echo $brand_id_conversion_code;	
	} 
	?>
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix full div_mid mt_50">
			<div class="fix seven_by_ten floatleft h_400 border_box br_2 border_right_ash border_right_solid">
				<h1 class="fs_30 lh_40 font_bold textcenter text_dark_ash">Control Panel</h2>
				<a href="https://cp.tns.market/members/login_process.cfm?cc=<?php echo $customer_email; ?>" target="_blank" class="fs_16 lh_40 display_block w_300 textcenter h_40 bg_sky_blue font_bold" id="checkout_button">Manage Digital Name</a>
				<p class="fs_20 lh_30 font_bold mt_10 text_dark_ash">Names Bought:</p>
				<div class="fix full p_10">
					<?php echo $all_name_to_show; ?>
				</div>
			</div>
			<div class="fix three_by_ten floatleft h_400 border_box">
				
				
			</div>
			
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/checkout_page.js"></script>
</body>
</html>