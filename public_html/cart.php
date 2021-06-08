<?php 
session_start();
require 'config/connect_db.php';
require 'services/db_functions.php';

$name_price = get_field_value_by_id('settings','name_price',1);
$company_name = get_field_value_by_id('settings','company_name',1);
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
			<div class="fix seven_by_ten floatleft h_400 border_box br_2 border_right_ash border_right_solid">
				<h1 class="fs_30 lh_40 font_bold textcenter text_dark_ash">Here's the cart</h2>
			</div>
			<div class="fix three_by_ten floatleft h_400 border_box">
				<span class="display_none" id="name_price"><?php echo $name_price; ?></span>
				<span class="display_none" id="package_price">49.95</span>
				<h1 class="fs_30 lh_40 font_bold textleft text_dark_ash pl_10 pr_10">Name List (Price: $<span id="total_price">0</span>)</h2>
				<div class="fix ninty_percent" id="cart_wrapper">
					
				</div>
				<div class="fix full ml_10 mt_10 border_box">
					<a href="index.php" class="fs_16 lh_40 display_block full textcenter h_40 bg_dark_paste text_white font_bold">Add More</a>
				</div>
				<div class="fix full ml_10 mt_10 border_box">
					<a href="checkout.php" class="fs_16 lh_40 display_block full textcenter h_40 bg_very_light_ash2 font_bold" id="checkout_button">Checkout</a>
				</div>
				
			</div>
			
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/cart_page.js"></script>
</body>
</html>