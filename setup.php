<?php 
require 'config/constants.php';
$filepath = './config/config.ini';

//update ini file, call function
function update_ini_file($data, $filepath) {
	$content = "";
	//parse the ini file to get the sections
	//parse the ini file using default parse_ini_file() PHP function
	$parsed_ini = parse_ini_file($filepath, true);
	foreach($data as $section => $values){
		if($section === "submit"){
			continue;
		}
		$content .= $section ."=". $values . "\n";
	}
	//write it into file
	if (!$handle = fopen($filepath, 'w')) {
		return false;
	}
	$success = fwrite($handle, $content);
	fclose($handle);
}

if(isset($_POST['setup_config'])){
	$data = @parse_ini_file("config.ini");
	$data['dbhost'] = $_POST['server_name'];
	$data['dbname'] = $_POST['dbname'];
	$data['dbuname'] = $_POST['dbuname'];
	$data['dbpass'] = $_POST['dbpass'];
	update_ini_file($data, $filepath);
	header("Location: ".BASE_URL."index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Digital Name - Setup</title>
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="fix full border_box pr_10 pl_10 pt_10 pb_10 div_mid">
		<div class="fix w_400 div_mid mt_100">

			<form method="post" id="digital_name_form">
				<div class="fix full h_30">
					<p class="text_error font_bold lh_22 fs_14 display_none" id="error_message"></p>
				</div>
				<input type="hidden" name="setup_config" value="1">
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="text" 
				name="server_name" 
				id="server_name" 
				placeholder="Ex: localhost" />
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="text" 
				name="dbname" 
				id="dbname" 
				placeholder="Enter the database name" />
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="text" 
				name="dbuname" 
				id="dbuname" 
				placeholder="Enter the database username" />
				<input 
				class="full h_40 w_250 bt_1 br_1 bb_1 bl_1 border_solid border_ash pl_5 pr_5 border_box mt_5" 
				type="password" 
				name="dbpass" 
				id="dbpass" 
				placeholder="Enter a database password" />
				<button
				class="cursor_pointer display_block mt_10 full bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_40 text_dark_grey bg_very_light_ash textcenter fs_14 font_bold" 
				type="submit" 
				id="check_digital_name_button">Submit</button>
			</form>
		</div>
	</div>
	<script src="./js/jquery.min.js"></script>
</body>
</html>