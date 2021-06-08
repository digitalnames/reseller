<?php
$digital_names = $_GET['digital_names'];
$digital_names = rtrim($digital_names, ',');
$digital_names_array = explode(",",$digital_names);

$error = 0;

// create & initialize a curl session
$curl = curl_init();

foreach($digital_names_array as $single_name){
	// set our url with curl_setopt()
	if($single_name != 'null'){
		curl_setopt($curl, CURLOPT_URL, "http://usa.tnsapi.cloud/call.cfm?apikey=public&command=namelookup&digitalname=$single_name");

		// return the transfer as a string, also with setopt()
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// curl_exec() executes the started curl session
		// $output contains the output string
		$output = curl_exec($curl);
		if($output > 0){
			$error++;
		}
	}

}
echo $error;
// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);