<?php 
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'].'/';
$base_url .= "upwork_projects/digital_name_project/digital_name_v_2/";
$admin_url = $base_url . "admin/";
// $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
define("BASE_URL", $base_url);
define("ADMIN_URL", $admin_url);


$ip_address = $_SERVER["REMOTE_ADDR"];


define("IP_ADD", $ip_address);