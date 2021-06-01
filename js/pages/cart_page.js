$(document).ready(function(){
	update_cart_show();
	update_cart_list();
	$(document).on('click','.single_cart_row_delete_button',function(){
		let index = $(this).attr('id').substr(30);
		let name_list_array = cart_name_list_array();
		let productPackageList = getProductPackageList();

		let type_to_delete = $('#single_cart_row_'+index).attr('data-product-type');

		if(type_to_delete == 'name'){
			name_list_array.splice(index, 1);

			let names_string = '';
			name_list_array.map((single_name,index) => {
				names_string += single_name+',';
			});
			if(name_list_array.length == 0){
				localStorage.removeItem("name_list");
			}else{
				localStorage.setItem("name_list", names_string);
			}

		}else if(type_to_delete == 'package'){
			let package_name = $('#single_cart_row_'+index).children().children().html();
			let newProductPackageList = productPackageList.filter((productPackage,index) => productPackage.product_name !== package_name);
			localStorage.setItem("productPackage",JSON.stringify(newProductPackageList));

		}
		update_cart_show();
		update_cart_list();
	});
});
function update_cart_list() {
	let name_list_array = cart_name_list_array();
	let productPackageList = getProductPackageList();

	let single_name_row = '';
	let total_price = 0;
	let name_total_price = 0;
	let package_total_price = 0;
	$('#cart_wrapper').html('');
	
	if(name_list_array.length > 0 && name_list_array[0] != ""){
		name_list_array.map((single_name,index) => {
			single_name_row = '';
			single_name_row += '<div class="full fix pt_5 pb_5 pl_10 pr_10 border_box single_cart_row" data-product-type="name" id="single_cart_row_'+index+'">';
				single_name_row += '<div class="fix half floatleft border_box">'
					single_name_row += '<p class="fs_14 lh_22 font_bold text_dark_grey">'+single_name+'</p>';
				single_name_row += '</div>';
				single_name_row += '<div class="fix half floatright border_box">';
					single_name_row += '<button class="floatright single_cart_row_delete_button cursor_pointer bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_22 text_dark_grey bg_very_light_ash fs_14 lh_22 font_bold single_cart_row_delete_button" id="single_cart_row_delete_button_'+index+'">Delete</button>';
				single_name_row += '</div>';
			single_name_row += '</div>';
			$('#cart_wrapper').append(single_name_row);

		});
		
	}
	let productPackageRowStartFrom = name_list_array.length;
	if(productPackageList.length > 0){
		productPackageList.map((single_product_package,index) => {
			single_product_package_row = '';
			single_product_package_row += '<div class="full fix pt_5 pb_5 pl_10 pr_10 border_box single_cart_row" data-product-type="package" id="single_cart_row_'+productPackageRowStartFrom+'">';
				single_product_package_row += '<div class="fix half floatleft border_box">'
					single_product_package_row += '<p class="fs_14 lh_22 font_bold text_dark_grey">'+single_product_package.product_name+'</p>';
				single_product_package_row += '</div>';
				single_product_package_row += '<div class="fix half floatright border_box">';
					single_product_package_row += '<button class="floatright single_cart_row_delete_button cursor_pointer bt_1 br_1 bb_1 bl_1 border_solid border_dark_ash h_22 text_dark_grey bg_very_light_ash fs_14 lh_22 font_bold single_cart_row_delete_button" id="single_cart_row_delete_button_'+productPackageRowStartFrom+'">Delete</button>';
				single_product_package_row += '</div>';
			single_product_package_row += '</div>';
			$('#cart_wrapper').append(single_product_package_row);
			productPackageRowStartFrom++;
		});
	}

	name_total_price = parseFloat(name_list_array.length * $('#name_price').html()).toFixed(2);
	package_total_price = parseFloat(productPackageList.length * $('#package_price').html()).toFixed(2);
	total_price = (parseFloat(name_total_price) + parseFloat(package_total_price)).toFixed(2);
	if(name_list_array.length > 0 || productPackageList.length > 0){
		$('#checkout_button').removeClass('display_none').addClass('display_block');
	}else{
		$('#checkout_button').removeClass('display_block').addClass('display_none');
	}
	$('#total_price').html(total_price);

}
function update_cart_show() {
	let name_list_array = cart_name_list_array();
	let name_list_length = name_list_array.length;

	let productPackageList = getProductPackageList();
	let productPackageListLength = productPackageList.length;
	let total_cart_items = name_list_length+productPackageListLength;
	
	$('#name_in_cart').html(total_cart_items);
}
function getProductPackageList(){
	let productPackageList = localStorage.getItem("productPackage");
	
	productPackageList = (productPackageList === null) ? '[]' : productPackageList;
	productPackageList =  JSON.parse(productPackageList);

	return productPackageList;
}
function cart_name_list_array() {
	let name_list = localStorage.getItem("name_list");
	let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
	return name_list_array;
}
