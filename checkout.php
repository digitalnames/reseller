<?php 
session_start();
require 'config/connect_db.php';
require 'services/db_functions.php';

$company_name = get_field_value_by_id('settings','company_name',1);
if(isset($_SESSION['login_token']) && check_customer_login_token($_SESSION['login_token'])){
	$paypal_client_id = get_field_value_by_id('settings','paypal_client_id',1);	
	$name_price = get_field_value_by_id('settings','name_price',1);
	$out_of_credits_message = get_field_value_by_id('settings','out_of_credits_message',1);
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
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<?php include('layouts/head.php'); ?>
		<div class="fix full div_mid mt_50">
			<div class="fix seven_by_ten floatleft h_400 border_box br_2 border_right_ash border_right_solid">
				<h1 class="fs_30 lh_40 font_bold textcenter text_dark_ash">Checkout</h2>
				<p id="checkout_error" class="fs_20 lh_28 text_error font_bold textcenter mt_100"></p>
			</div>
			<div class="fix three_by_ten floatleft h_400 border_box">
				<span class="display_none" id="name_price"><?php echo $name_price; ?></span>
				<h1 class="fs_30 lh_40 font_bold textleft text_dark_ash pl_10 pr_10">Name List (Price: $<span id="total_price">0</span>)</h2>
				<div class="fix ninty_percent" id="cart_wrapper">
					
				</div>
				<div class="fix eighty_five_percent ml_10 mt_10 border_box">
					<div id="smart-button-container">
						<div style="text-align: center;">
							<div id="paypal-button-container"></div>
						</div>
					</div>
					<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypal_client_id; ?>&currency=USD" data-sdk-integration-source="button-factory"></script>
					<script>
						
						function initPayPalButton() {
							paypal.Buttons({
								style: {
									shape: 'rect',
									color: 'blue',
									layout: 'vertical',
									label: 'checkout',
								},
								// onClick is called when the button is clicked
								onClick: async function(data, actions) {

									let result = await Promise.all([
									  fetch("get_admin_credits.php"),
									  fetch("search_multiple_digital_name.php?digital_names="+localStorage.getItem('name_list')),
									  fetch("get_admin_credits.php"),
									  fetch("send_warning_credit_mail.php")
									]).then( ([task1, task2, task3, task4]) => {
									    return [task1.text(), task2.text(), task3.text(), task4.text()]
									})
									.catch((err) => {
									    console.log(err);
									});
									result = await Promise.all(result);
									
									if(result[0] == 0){
										$('#checkout_error').html('<?php echo $out_of_credits_message; ?>');
										return actions.reject();
									}
									if(result[1] > 0){
										$('#checkout_error').html('Names are no longer available');
										return actions.reject();
									}
									if(result[2] == 0){
										$('#checkout_error').html('<?php echo $out_of_credits_message; ?>');
										return actions.reject();
									}

									return actions.resolve();
								},
								createOrder: function(data, actions) {
									return actions.order.create({
										purchase_units: [
											{
												"description":"Digital Name",
												"amount":{
													"currency_code": "USD",
													"value": parseFloat(localStorage.getItem("name_list").replace(/(^,)|(,$)/g, "").split(",").length * $('#name_price').html()).toFixed(2)
												}
											}
										]
									});
								},

								onApprove: function(data, actions) {
									return actions.order.capture().then(function(details) {
										const formData = new FormData();
										formData.append('names', localStorage.getItem('name_list'));
										fetch('save_digital_name.php', {
											method: "POST",
											body: formData
										})
										.then(res => res.text())
										.then(data => {
											if(data == 'success'){
												localStorage.removeItem('name_list');
												window.location.href = "control_panel.php?from_checkout=yes";
											}
										})
										.catch(err => {
											console.log('Error -', err);
										});
										// alert('Transaction completed by ' + details.payer.name.given_name + '!');
									});
								},

								onError: function(err) {
									console.log(err);
								}
							}).render('#paypal-button-container');
						}
						initPayPalButton();
					</script>
				</div>
				
			</div>
			
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/checkout_page.js"></script>
</body>
</html>