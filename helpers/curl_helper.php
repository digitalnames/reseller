<?php
// create & initialize a curl session
$curl = curl_init();

function get_admin_credit(){
	global $curl;
	// set our url with curl_setopt()
	curl_setopt($curl, CURLOPT_URL, "http://usa.tnsapi.cloud/call.cfm?apikey=k4b1a7f2&command=checkcredits");

	// return the transfer as a string, also with setopt()
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	// curl_exec() executes the started curl session
	// $output contains the output string
	$output = curl_exec($curl);

	// close curl resource to free up system resources
	// (deletes the variable made by curl_init)
	curl_close($curl);

	return $output;

}