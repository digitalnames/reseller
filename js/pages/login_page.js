$(document).ready(function(){
	update_cart_show();
	update_cart_list();
});
function update_cart_list() {
	let name_list_array = cart_name_list_array();
	let single_name_row = '';
	let total_price = 0;
	$('#cart_wrapper').html('');
	
	if(name_list_array.length > 0 && name_list_array[0] != ""){
		name_list_array.map((single_name,index) => {
			single_name_row = '';
			single_name_row += '<div class="full fix pt_5 pb_5 pl_10 pr_10 border_box single_cart_row" id="single_cart_row_'+index+'">';
				single_name_row += '<div class="fix half floatleft border_box">'
					single_name_row += '<p class="fs_14 lh_22 font_bold text_dark_grey">'+single_name+'</p>';
				single_name_row += '</div>';
				single_name_row += '<div class="fix half floatright border_box">';
					single_name_row += '&nbsp;';
				single_name_row += '</div>';
			single_name_row += '</div>';
			$('#cart_wrapper').append(single_name_row);
		});
		
	}
	total_price = name_list_array.length * 2;
	$('#total_price').html(total_price);

}
function update_cart_show() {
	let name_list_array = cart_name_list_array();
	$('#name_in_cart').html(name_list_array.length);
}
function cart_name_list_array() {
	let name_list = localStorage.getItem("name_list");
	let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
	return name_list_array;
}
