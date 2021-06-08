<?php 
session_start();
require 'config/constants.php';
require 'config/connect_db.php';
require 'services/db_functions.php';
require 'services/api_functions.php';

function construct_name_list($names, $featured = false){
	
	$names_to_show = '';
	foreach($names as $single_name){
		$names_to_show .= '<div class="fix full pb_10 bb_1 border_bottom_dotted border_bottom_dark_ash">';
			$names_to_show .= '<div class="fix four_by_ten floatleft">';
				$names_to_show .= '<p class="fs_14 lh_36 font_bold text_dark_ash textleft">'.$single_name[0].'</p>';
				$names_to_show .= ($featured) ? '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="marketplace.php?type=digitalnames&amp;cat='.$single_name[4].'&amp;mode=list&amp;seller='.$single_name[0].'">List names from this seller</a>' : '<a class="fs_12 text_dark_ash bg_very_light_ash2 pr_16 pl_16 pt_5 pb_5 border_none display_inline_block" href="marketplace.php?type=digitalnames&amp;cat='.$single_name[3].'&amp;mode=list&amp;seller='.$single_name[0].'">List names from this seller</a>';
				$names_to_show .= '';
			$names_to_show .= '</div>';
			$names_to_show .= '<div class="fix two_by_ten floatleft">';
				$names_to_show .= '<p class="fs_14 lh_36 text_dark_ash textcenter">'.$single_name[2].'</p>';
			$names_to_show .= '</div>';
			$names_to_show .= '<div class="fix four_by_ten floatleft">';
				$names_to_show .= '<p class="fs_14 lh_36 font_bold text_dark_ash textright">$'.$single_name[1].'</p>';
				// $names_to_show .= '<a class="bg_very_light_ash2 fs_16 text_dark_ash font_bold pl_16 pr_16 pt_5 pb_5 display_inline_block border_none floatright" href="https://public.tnsapi.cloud/buy.cfm?digitalname='.$single_name[0].'">BUY</a>';
			$names_to_show .= '</div>';
		$names_to_show .= '</div>';
	}
	return $names_to_show;
}

$header_msg = 'FEATURED LISTINGS';
$categories = get_all_categories();

$category_list_to_show = '';
$category_options_to_show = '';
$names_to_show = '';
foreach($categories as $single_category){
	$category_list_to_show .= '<li class="fs_14 lh_30 pl_5 pr_5 border_box bb_1 border_bottom_solid border_bottom_solid border_bottom_dark_ash">';
		$category_list_to_show .= '<a class="display_block" href="marketplace.php?type=digitalnames&amp;cat='.$single_category[0].'&amp;mode=list">'.$single_category[1].'</a>';
	$category_list_to_show .= '</li>';

	$category_options_to_show .= '<option value="'.$single_category[0].'">'.$single_category[1].'</option>';
}
$names = get_featured_names();

$names_to_show = construct_name_list($names,true);
if(isset($_GET['cat']) && isset($_GET['seller'])){
	$names = ($_GET['cat'] == 'all') ? get_all_names() : get_names_by_category($_GET['cat']);
	$actual_name = get_actual_name($categories,$_GET['cat']);
	$header_msg = 'ALL LISTINGS FOR '.strtoupper($_GET['seller']).' OWNER';
	$names_to_show = construct_name_list($names);

}elseif(isset($_GET['cat'])){
	$names = ($_GET['cat'] == 'all') ? get_all_names() : get_names_by_category($_GET['cat']);
	$actual_name = get_actual_name($categories,$_GET['cat']);
	$header_msg = ($_GET['cat'] == 'all') ? "ALL LISTINGS" : "ALL ".strtoupper($actual_name)." LISTINGS";
	$names_to_show = construct_name_list($names);
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
		<div class="fix ninty_percent div_mid header_section">
			<div class="fix floatleft twenty_percent">
				<h1 class="fs_30 lh_42 font_bold text_dark_ash">Market</h1>
				<!-- <img src="./images/logo.jpg" alt="Logo"/> -->
			</div>
			<div class="fix floatleft seventy_percent">
				<div class="fix mt_10 div_mid ninty_percent">
					<form method="POST" action="marketplace.php">
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
			<div class="fix floatleft ten_percent"></div>
		</div>
		<div class="fix ninty_percent div_mid pt_20 pb_20 border_box">
			<div class="fix floatleft full">
				<div class="fix full h_30">
					<p class="text_error font_bold lh_22 fs_14 display_none" id="error_message"></p>
				</div>
				<form method="post" id="digital_name_form" class="floatleft">
					<div class="fix full">
						<input 
						class="h_40 w_300 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box floatleft" 
						type="text" 
						name="digital_name" 
						id="digital_name" 
						placeholder="Enter a name" />
						
						<button
						class="cursor_pointer display_block ml_10 w_300 bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold floatleft" 
						type="button" 
						id="check_digital_name_button">Check Name</button>

						
					</div>
				</form>
				<div class="fix w_40 h_40 div_mid floatleft ml_20">
					<img src="./images/searching.gif" alt="searching" class="w_40 vertical_align_middle div_mid display_none" id="searching_image"/>
				</div>
				<p 
				id="found_name"
				class="fs_20 text_green lh_40 floatleft display_none ml_20">You may take this name</p>
				
			</div>
			<div class="fix floatleft full mt_10">
				<a class="fs_14 bg_very_light_ash2 text_dark_ash font_bold pr_20 pl_20 lh_30 floatleft border_none mr_10" href="index.php">BUY DIGITAL NAMES</a>
			</div>
		</div>
		<div class="fix ninty_percent div_mid header_section">
			<div class="fix floatleft twenty_percent">
				<h1 class="fs_16 bg_very_light_ash2 lh_30 font_bold text_dark_ash textcenter">ALL CATEGORIES</h1>
				<div class="fix full">
					<ul>
						<li class="fs_14 lh_30 pl_5 pr_5 border_box bb_1 border_bottom_solid border_bottom_solid border_bottom_dark_ash">
							<a class="display_block" href="marketplace.php?type=digitalnames&amp;cat=all&amp;mode=list">All Names</a>
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
						<?php echo $names_to_show; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/pages/index_page.js"></script>
</body>
</html>