<?php 
session_start();
require '../config/connect_db.php';
require '../services/db_functions.php';

if(isset($_SESSION['login_token']) && check_admin_login_token($_SESSION['login_token'])){
	$customers = get_all_customers_with_name_number();

	$show_all_customers = '';
	while ($obj = mysqli_fetch_object($customers)) {
		$show_all_customers .= '<tr>';
			$show_all_customers .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->customer_name.'</td>';
			$show_all_customers .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->name_number.'</td>';
		$show_all_customers .= '</tr>';
	}
	mysqli_free_result($customers);
	$result = get_by_id('settings', 1);
	$settings = mysqli_fetch_assoc($result);
	$affiliate_program_type = ($result->num_rows > 0) ? $settings['affiliate_program_type'] : '' ;
	$company_name = ($result->num_rows > 0) ? $settings['company_name'] : '' ;
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
					<h1 class="fs_30 lh_40 font_bold text_dark_ash mb_10 pl_5 pr_5">Customer Information</h1>
					<table class="full">
						<thead>
							<tr>
								<th>Customer Name</th>
								<th>Digital Names Created</th>
							</tr>							
						</thead>
						<tbody>
							<?php echo $show_all_customers; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/pages/index_page.js"></script>
</body>
</html>