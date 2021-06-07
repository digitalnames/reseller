<?php 
session_start();
require '../config/constants.php';
require '../config/connect_db.php';
require '../services/db_functions.php';
require '../helpers/curl_helper.php';

if(isset($_SESSION['login_token']) && check_admin_login_token($_SESSION['login_token'])){
	$customer_number = get_customer_number();
	$name_number = get_name_number();
	$warning_credit = get_field_value_by_id('settings','warning_credit',1);
	$warning_credit = (is_null($warning_credit)) ? 0 : $warning_credit ;

	$name_price = get_field_value_by_id('settings','name_price',1);
	$name_price = (is_null($name_price)) ? 0 : $name_price ;

	$credits_remaining = get_admin_credit();

	$revenue = get_revenue();
	$total_income = get_total_income();

	$result = get_by_id('settings', 1);
	$settings = mysqli_fetch_assoc($result);
	$affiliate_program_type = ($result->num_rows > 0) ? $settings['affiliate_program_type'] : '' ;
	$sale_percentage = ($result->num_rows > 0) ? $settings['sale_percentage'] : '' ;
	$company_name = ($result->num_rows > 0) ? $settings['company_name'] : '' ;
	$total_affiliate_clicks = get_all_affiliate_click_number();
	$total_unknown_clicks = get_field_value_by_id('settings','unknown_click',1);
	$total_clicks = $total_affiliate_clicks + $total_unknown_clicks;
	$total_affiliate_signups = get_all_affiliate_signup_number();
	$total_signups_without_affiliate = get_all_signup_number_without_affiliate();
	$total_signups = $total_affiliate_signups + $total_signups_without_affiliate;

	$total_other_products_signups = get_total_other_products_signup();
	$total_other_products_revenue = get_total_other_products_revenue();
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
				<div class="fix full">
					<div class="fix full">
						<div class="fix half floatleft">
							<h1 class="fs_30 lh_40 font_bold text_dark_ash mb_10 pl_5 pr_5">Digital Name Sales</h1>
						</div>
						<div class="fix half floatright">
							<?php if($affiliate_program_type == 'tns') { ?>
							<p class="fs_14 font_bold text_dark_ash lh_22 textright">Internal Affiliate Program: <span class="text_error">ACTIVE</span></p>
							<?php } ?>
							<?php if($affiliate_program_type == 'everflow') { ?>
							<p class="fs_14 font_bold text_dark_ash lh_22 textright">EVERFLOW Affiliate Program: <span class="text_error">ACTIVE</span></p>
							<?php } ?>
						</div>
					</div>
					
					<div class="fix full">
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Customers</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $customer_number; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Digital Names Registered</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $name_number; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Credits Remaining</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $credits_remaining; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Warning Credit Amount</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $warning_credit; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Revenue</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $revenue; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Total Clicks</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $total_clicks; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Total Signups</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $total_signups; ?></p>
							</div>
						</div>
					</div>	
					<?php if($affiliate_program_type == "tns") { ?>
					<div class="fix full bb_3 border_bottom_solid border_bottom_ash mt_30 display_block clear_both"></div>

					<h1 class="fs_30 lh_40 font_bold text_dark_ash mt_30 mb_10 pl_5 pr_5">Affiliate Analytics</h1>
					<div class="fix full">
						
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Affiliate Signups</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $total_affiliate_signups; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Total Income</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash">$<?php echo $total_income; ?></p>
							</div>
						</div>
						
					</div>	
					<?php } ?>

					<div class="fix full bb_3 border_bottom_solid border_bottom_ash mt_30 display_block clear_both"></div>

					<h1 class="fs_30 lh_40 font_bold text_dark_ash mt_30 mb_10 pl_5 pr_5">Other Products</h1>
					<div class="fix full">
						
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Signups</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash"><?php echo $total_other_products_signups; ?></p>
							</div>
						</div>
						<div class="fix twenty_five_percent floatleft mt_10">
							<div class="fix ninty_five_percent div_mid pt_5 pr_5 pb_5 pl_5 border_box bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash round_10">
								<h4 class="fs_18 lh_30 font_bold text_dark_ash">Total Revenue</h4>
								<p class="fs_14 lh_22 font_bold text_dark_ash">$<?php echo $total_other_products_revenue; ?></p>
							</div>
						</div>
						
					</div>	
				</div>
			</div>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/pages/index_page.js"></script>
</body>
</html>