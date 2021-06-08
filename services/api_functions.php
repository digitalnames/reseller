<?php 

function get_all_categories(){
	$categories = file_get_contents('http://usa.tnsapi.cloud/call.cfm?apikey=public&command=sellcats&display=json');
	return json_decode($categories)->DATA;
}
function get_all_names(){
	$names = file_get_contents('http://usa.tnsapi.cloud/call.cfm?apikey=public&command=listforsale&display=json');
	return json_decode($names)->DATA;
}
function get_names_by_category($category){
	$names = file_get_contents('http://usa.tnsapi.cloud/call.cfm?apikey=public&command=listforsale&display=json&cat='.$category);
	return json_decode($names)->DATA;
}
function search_names_from_all_category($name){
	$names = file_get_contents('http://usa.tnsapi.cloud/call.cfm?apikey=public&command=listforsale&search='.$name.'&display=json'); 
	return json_decode(ltrim($names,'4'))->DATA;
}
function search_names_from_category($category_name, $name){
	$names = file_get_contents('http://usa.tnsapi.cloud/call.cfm?apikey=public&command=listforsale&display=json&cat='.$category_name.'&search='.$name);
	return json_decode(ltrim($names,'4'))->DATA;
}
function get_actual_name($categories, $category_name){
	$actual_category_name_found = '';
	foreach($categories as $category){
		if($category[0] == $category_name){
			$actual_category_name_found = $category[1];
		}
	}
	return $actual_category_name_found;
}
function get_featured_names(){
	$names = file_get_contents('https://public.tnsapi.cloud/call.cfm?apikey=public&command=listforsale&display=json&featured=yes');
	return json_decode($names)->DATA;	
}