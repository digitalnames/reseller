<?php 
session_start();
require 'config/constants.php';
require 'config/connect_db.php';
require 'services/db_functions.php';
require 'services/api_functions.php';

function construct_name_list($names, $featured = false){
	
	$names_to_show = '';
	$i = 0;
	foreach($names as $single_name){
		if($i < 25){
			$names_to_show .= '<div class="fix full pb_10 bb_1 border_bottom_dotted border_bottom_dark_ash">';
				$names_to_show .= '<div class="fix four_by_ten floatleft">';
					$names_to_show .= '<p class="fs_14 lh_36 font_bold text_dark_ash textleft">'.$single_name[0].'</p>';
					$names_to_show .= ($featured) ? '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="index.php?type=digitalnames&amp;cat='.$single_name[4].'&amp;mode=list&amp;seller='.$single_name[0].'">List names from this seller</a>' : '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="index.php?type=digitalnames&amp;cat='.$single_name[3].'&amp;mode=list&amp;seller='.$single_name[0].'">List names from this seller</a>';
					$names_to_show .= '';
				$names_to_show .= '</div>';
				$names_to_show .= '<div class="fix two_by_ten floatleft">';
					$names_to_show .= '<p class="fs_14 lh_36 text_dark_ash textcenter">'.$single_name[2].'</p>';
				$names_to_show .= '</div>';
				$names_to_show .= '<div class="fix four_by_ten floatleft">';
					$names_to_show .= '<p class="fs_14 lh_36 font_bold text_dark_ash textright">$'.$single_name[1].'</p>';
					$names_to_show .= '<a class="bg_very_light_ash2 fs_16 text_dark_ash font_bold pl_16 pr_16 pt_5 pb_5 display_inline_block border_none floatright" href="https://public.tnsapi.cloud/buy.cfm?digitalname='.$single_name[0].'">BUY</a>';
				$names_to_show .= '</div>';
			$names_to_show .= '</div>';

		}else{
			break;
		}
		$i++;
	}
	return $names_to_show;
}


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






$header_msg = 'FEATURED LISTINGS';
$categories = get_all_categories();

$category_list_to_show = '';
$category_options_to_show = '';
$names_to_show = '';
foreach($categories as $single_category){
	$category_list_to_show .= '<li class="fs_14 lh_30 pl_5 pr_5 border_box bb_1 border_bottom_solid border_bottom_solid border_bottom_dark_ash">';
		$category_list_to_show .= '<a class="display_block" href="index.php?type=digitalnames&amp;cat='.$single_category[0].'&amp;mode=list">'.$single_category[1].'</a>';
	$category_list_to_show .= '</li>';

	$category_options_to_show .= '<option value="'.$single_category[0].'">'.$single_category[1].'</option>';
}
$names = get_featured_names();
$name_type = 'featured';
$names_to_show = construct_name_list($names,true);
if(isset($_GET['cat']) && isset($_GET['seller'])){
	$names = ($_GET['cat'] == 'all') ? get_all_names() : get_names_by_category($_GET['cat']);
	$actual_name = get_actual_name($categories,$_GET['cat']);
	$header_msg = 'ALL LISTINGS FOR '.strtoupper($_GET['seller']).' OWNER';
	$names_to_show = construct_name_list($names);
	$name_type = 'normal';
}elseif(isset($_GET['cat'])){
	$names = ($_GET['cat'] == 'all') ? get_all_names() : get_names_by_category($_GET['cat']);
	$actual_name = get_actual_name($categories,$_GET['cat']);
	$header_msg = ($_GET['cat'] == 'all') ? "ALL LISTINGS" : "ALL ".strtoupper($actual_name)." LISTINGS";
	$names_to_show = construct_name_list($names);
	$name_type = 'normal';
}
if(isset($_POST['search_by_category'])){
	$category_name = $_POST['category_search'];
	$name = $_POST['name_search'];
	if($category_name == "all") {
		$names = search_names_from_all_category($name);
	}else{
		$names = search_names_from_category($category_name, $name);
	}
	$header_msg = 'SEARCH RESULT FOR: '.strtoupper($name);
	$names_to_show = construct_name_list($names);
	$name_type = 'normal';
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
		<div class="fix w_1000 div_mid mt_30">
			<div class="fix seventy_percent div_mid">
				<div class="fix mt_10 div_mid ninty_percent">
					<form method="POST" action="index.php">
						<input type="hidden" name="search_by_category" value="1">
						<select name="category_search" id="category_search" class="h_30 text_dark_ash two_by_ten fs_14 font_bold floatleft">
							<option value="all">Categories</option>
							<?php echo $category_options_to_show; ?>
						</select>
						<input type="text" class="fs_14 six_by_ten h_30 border_box pl_5 pr_5 lh_30 bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash floatleft" name="name_search"/>
						<button type="submit" class="fs_14 lh_22 text_dark_ash font_bold bg_very_light_ash2 h_30 floatleft border_none two_by_ten">SEARCH</button>
					</form>
				</div>
			</div>
			<div class="fix ninty_percent div_mid header_section mt_20">
				<div class="fix floatleft twenty_percent">
					<h1 class="fs_16 bg_very_light_ash2 lh_30 font_bold text_dark_ash textcenter">ALL CATEGORIES</h1>
					<div class="fix full">
						<ul>
							<li class="fs_14 lh_30 pl_5 pr_5 border_box bb_1 border_bottom_solid border_bottom_solid border_bottom_dark_ash">
								<a class="display_block" href="index.php?type=digitalnames&amp;cat=all&amp;mode=list">All Names</a>
							</li>
							<?php echo $category_list_to_show; ?>
						</ul>
					</div>
				</div>
				<div class="fix floatleft eighty_percent">
					<div class="fix div_mid ninty_five_percent">

						<!-- <h1 class="fs_20 lh_40 textright text_blue font_bold">Buy & Sell Crypto Names</h1> -->
						<?php if($header_msg != ""){ ?>
						<h1 class="fs_20 lh_40 bg_very_light_ash2 textcenter text_dark_ash font_bold mb_10"><?php echo $header_msg; ?></h1>
						<?php } ?>
						<div class="fix full pl_10 pr_10 border_box bg_very_light_ash2">
							<div class="fix four_by_ten floatleft">
								<p class="fs_16 lh_36 font_bold text_dark_ash textleft">Crypto Name</p>
							</div>
							<div class="fix two_by_ten floatleft">
								<p class="fs_16 lh_36 font_bold text_dark_ash textcenter">Expire Date</p>
							</div>
							<div class="fix four_by_ten floatleft">
								<p class="fs_16 lh_36 font_bold text_dark_ash textright">Price</p>
							</div>
						</div>
						<div class="fix full pl_10 pr_10 bg_very_light_ash border_box">
							<div class="fix full" id="name_list">
								<?php echo $names_to_show; ?>
							</div>
							<div class="fix full">
								<!-- <div class="fix full floatleft">&nbsp;</div> -->
								<div class="fix full floatright">
									<div id="pagination_button_section" class="floatright pt_5 pb_5 border_box">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/index_page.js"></script>
	<script>
		$(document).on('click','.pagination_button',function(){
			
			let button_number = parseInt($(this).attr('id').substr(16));
			active_button = button_number;
			let name_from = (parseInt(button_number) * show_to_page) - show_to_page;
			let name_to = parseInt((parseInt(button_number) * show_to_page)) - 1;
			name_to = (name_to > total_names_found) ? (total_names_found - 1) : name_to;
			let i = name_from;
			let names_to_show = '';
			for(i ; i <= name_to; i++){
				let single_name = name_objects[i];
				names_to_show += '<div class="fix full pb_10 bb_1 border_bottom_dotted border_bottom_dark_ash">';
					names_to_show += '<div class="fix four_by_ten floatleft">';
						names_to_show += '<p class="fs_14 lh_36 font_bold text_dark_ash textleft">'+single_name[0]+'</p>';
						names_to_show += (name_type == 'featured') ? '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="index.php?type=digitalnames&amp;cat='+single_name[4]+'&amp;mode=list&amp;seller='+single_name[0]+'">List names from this seller</a>' : '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="index.php?type=digitalnames&amp;cat='+single_name[3]+'&amp;mode=list&amp;seller='+single_name[0]+'">List names from this seller</a>';
						names_to_show += '';
					names_to_show += '</div>';
					names_to_show += '<div class="fix two_by_ten floatleft">';
						names_to_show += '<p class="fs_14 lh_36 text_dark_ash textcenter">'+single_name[2]+'</p>';
					names_to_show += '</div>';
					names_to_show += '<div class="fix four_by_ten floatleft">';
						names_to_show += '<p class="fs_14 lh_36 font_bold text_dark_ash textright">$'+single_name[1]+'</p>';
					names_to_show += '</div>';
				names_to_show += '</div>';
			}
			$('#name_list').html(names_to_show);
			generate_pagination_buttons();
		});
		function generate_pagination_buttons(){
			let pagination_buttons = '';
			let i = 0;
			for(i = 1; i <= total_pages; i++){
				if(total_pages != 1){
					if(total_pages > 5){
						if(i == 1){
							pagination_buttons += '<button id="name_pagination_1" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash cursor_pointer">First</button>';
							if(active_button > 0 && active_button != 1){
								pagination_buttons += '<button id="name_pagination_'+(active_button - 1)+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash cursor_pointer">Previous</button>';
							}
						}
						if(i == active_button){
							pagination_buttons += '<button id="name_pagination_'+(active_button - 1)+'" class="floatleft border_none fs_14 bg_very_light_ash lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash">'+i+'</button>';
						}
						if(i > active_button  && i < (active_button + 3) && !(i > (total_pages - 2))){

							pagination_buttons += '<button id="name_pagination_'+i+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash w_50 text_dark_ash cursor_pointer">'+i+'</button>';
						}
						if(i == (active_button + 2) && (active_button < total_pages -2) && active_button < total_pages - 4){
							pagination_buttons += '<button id="name_pagination_'+i+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash w_50 text_dark_ash" disabled>....</button>';
						}


						if(i > (total_pages - 2) && i != active_button){
							pagination_buttons += '<button id="name_pagination_'+i+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash w_50 text_dark_ash cursor_pointer">'+i+'</button>';
						}
						
						if( i == total_pages){
							if(active_button != total_pages){
								pagination_buttons += '<button id="name_pagination_'+(active_button+1)+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash cursor_pointer">Next</button>';
							}
							pagination_buttons += '<button id="name_pagination_'+total_pages+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash cursor_pointer">Last</button>';
						}
						
					}else{
						if(i == active_button){
							pagination_buttons += '<button id="name_pagination_'+(active_button - 1)+'" class="floatleft border_none fs_14 bg_very_light_ash lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash pl_10 pr_10 text_dark_ash">'+i+'</button>';
						}else{

							pagination_buttons += '<button id="name_pagination_'+i+'" class="pagination_button floatleft border_none fs_14 bg_very_light_ash2 lh_26 br_1 border_right_solid border_right_dark_ash bl_1 border_left_solid border_left_dark_ash w_50 text_dark_ash cursor_pointer">'+i+'</button>';
						}
					}

				}
			}
			$('#pagination_button_section').html(pagination_buttons);
			console.log(total_names_found, show_to_page, total_pages);	
		}
		let active_button = 1;
		let name_type = '<?php echo $name_type; ?>';
		let name_objects = <?php echo json_encode($names); ?>;
		let show_to_page = 25;
		let total_names_found = name_objects.length;
		let total_pages = Math.ceil(total_names_found/show_to_page);
		generate_pagination_buttons();
	</script>
</body>
</html>