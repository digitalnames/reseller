<?php 
session_start();
require '../config/connect_db.php';
require '../config/constants.php';
require '../services/db_functions.php';
require '../helpers/curl_helper.php';
require '../helpers/string_helper.php';

if(isset($_SESSION['login_token']) && check_admin_login_token($_SESSION['login_token'])){
	$title_error = '';
	$domain_name_error = '';
	$sale_percentage_error = '';
	$error_number = 0;
	if(isset($_POST['operation_add_affiliate'])){
		if($_POST['title'] == ''){
			$title_error = 'Title is required';
			$error_number++;
		}
		if($_POST['domain_name'] == ''){
			$domain_name_error = 'Domain name is required';
			$error_number++;
		}
		if (filter_var($_POST['domain_name'], FILTER_VALIDATE_URL) === FALSE){
			$domain_name_error = 'Enter a valid url';
			$error_number++;
		}
		if($_POST['sale_percentage'] == ''){
			$sale_percentage_error = 'Sale percentage is required';
			$error_number++;
		}
		if($error_number == 0){
			$domain_name = $_POST['domain_name'];
			if($domain_name[strlen($domain_name) - 1] != '/'){
				$domain_name = $domain_name .'/';
			}
			$random_string = generate_random_strings(6);

			add_affiliate($_POST['title'],$domain_name,$random_string,$_POST['sale_percentage']);
			$_POST['title'] = $_POST['domain_name'] = $_POST['sale_percentage'] = '';
			header("Location: affiliates.php");
		}
	}
	if(isset($_POST['operation_delete_affiliate'])){
		$affiliate_id = $_POST['affiliate_id'];
		delete_affiliate($affiliate_id);
		header("Location: affiliates.php");
	}
	$affiliates = get_all_affiliates();
	
	$show_all_affiliates = '';
	while ($obj = mysqli_fetch_object($affiliates)) {
		$show_all_affiliates .= '<tr>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->title.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->domain.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.BASE_URL.'?R='.$obj->affiliate_string.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->affiliate_comers_number.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->affiliate_customer_number.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->sale_percentage.'</td>';
			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">'.$obj->affiliate_revenue.'</td>';

			$show_all_affiliates .= '<td class="fs_14 lh_22 font_bold text_dark_ash">';
				$show_all_affiliates .= '<form action="affiliates.php" method="post">';
					$show_all_affiliates .= '<input type="hidden" name="operation_delete_affiliate"/>';
					$show_all_affiliates .= '<input type="hidden" name="affiliate_id" value="'.$obj->id.'"/>';
					$show_all_affiliates .= '<button
											class="cursor_pointer display_block bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_30 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold pl_16 pr_16 div_mid" 
											type="submit" 
											id="check_digital_name_button">Delete</button>';
				$show_all_affiliates .= '</form>';
			$show_all_affiliates .='</td>';
		$show_all_affiliates .= '</tr>';
	}
	mysqli_free_result($affiliates);
	$result = get_by_id('settings', 1);
	$settings = mysqli_fetch_assoc($result);
	$affiliate_program_type = ($result->num_rows > 0) ? $settings['affiliate_program_type'] : '' ;
	$company_name = ($result->num_rows > 0) ? $settings['company_name'] : '' ;
	if($affiliate_program_type != 'tns') header("Location: settings.php");
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
					<h1 class="fs_30 lh_40 font_bold text_dark_ash mb_10 pl_5 pr_5">Affiliate Links</h1>
					<p class="fs_14 lh_22 text_dark_ash mt_10 mb_10">Add Additional Affiliate Links</p>

					<div class="fix full">
						<div class="fix half floatleft">
							<form action="affiliates.php" method="post">
								<p class="fs_14 lh_22 text_dark_ash mt_10 mb_10 font_bold">Enter A Title <span class="fs_12 lh_18 text_error"><?php echo $title_error; ?></span></p>
								<input type="hidden" name="operation_add_affiliate"/>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="title" 
								id="title" 
								placeholder="Enter a title" 
								value="<?php echo (isset($_POST['title']) ? $_POST['title'] : '') ?>"
								/>
								<p class="fs_14 lh_22 text_dark_ash mt_10 mb_10 font_bold">Enter Domain Name <span class="fs_12 lh_18 text_error"><?php echo $domain_name_error; ?></span></p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="domain_name" 
								id="domain_name" 
								placeholder="Enter a domain name" 
								value="<?php echo (isset($_POST['domain_name']) ? $_POST['domain_name'] : '') ?>"
								/>
								<p class="fs_14 lh_22 text_dark_ash mt_10 mb_10 font_bold">Sale Percentage <span class="fs_12 lh_18 text_error"><?php echo $sale_percentage_error; ?></span></p>
								<input 
								class="full h_30 full bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box" 
								type="text" 
								name="sale_percentage" 
								id="sale_percentage" 
								placeholder="Enter sale_percentage" 
								value="<?php echo (isset($_POST['sale_percentage']) ? $_POST['sale_percentage'] : '') ?>"
								min="0.00" 
								step="0.01"/>
								<button
								class="cursor_pointer display_block bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_30 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold pl_16 pr_16 mt_10" 
								type="submit" 
								id="check_digital_name_button">Add Link</button>
							</form>
						</div>
					</div>

					<div class="fix full mt_30 h_300" style="overflow-y: auto;">
						<table class="full">
							<thead>
								<tr>
									<th>Title</th>
									<th>Domain</th>
									<th>Affiliate Link</th>
									<th>Clicks</th>
									<th>Signups</th>
									<th>Sale Percentage</th>
									<th>Revenue</th>
									<th>Actions</th>
								</tr>							
							</thead>
							<tbody>
								<?php echo $show_all_affiliates; ?>
								
							</tbody>
						</table>
					</div>
						
				</div>

			</div>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
</body>
</html>