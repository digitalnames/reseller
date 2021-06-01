$(document).ready(function(){
	update_cart_show();
	update_product_package_section();
	$("#digital_name_form").on('submit', function(e){
		e.preventDefault();
		searchName();
	});
	$("#check_digital_name_button").on('click', function(e){
		e.preventDefault();
		searchName();
	});

	$("#found_name_add_to_cart").on('click', function(e){
		e.preventDefault();
		let digitalName = $('#digital_name').val().trim();
		
		let name_list = localStorage.getItem("name_list");
		let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
		digitalName = (digitalName.charAt(0) != '$') ? '$'+digitalName : digitalName;
		name_list = (name_list === null) ? digitalName + ',' : name_list + digitalName + ',';
		
		if(!name_list_array.includes(digitalName))
			localStorage.setItem("name_list", name_list);
			hideErrorMessage('#found_name');
			$('#found_name_add_to_cart').removeClass('display_block');
			$('#found_name_add_to_cart').addClass('display_none');

		update_cart_show();
	});
	$("#add_speculator_package_to_cart").on('click',function(e){
		e.preventDefault();
		add_product_package_to_cart('Speculator Package');
	});
	$("#add_developer_package_to_cart").on('click',function(e){
		e.preventDefault();
		add_product_package_to_cart('Developer Package');
	});
});
function add_product_package_to_cart(packageName){
	let foundProduct = false;
	let productPackageList = getProductPackageList();
	
	let packageObject = {
		product_name : packageName
	}

	foundProduct = isProductAlreadyAdded(productPackageList,packageName)
	
	if(!foundProduct) productPackageList.push(packageObject);

	localStorage.setItem("productPackage",JSON.stringify(productPackageList));

	update_cart_show();

	update_product_package_section();
}
function update_product_package_section(){
	let productPackageList = getProductPackageList();

	productPackageList.map((singleProductPackage, index) => {
		if(singleProductPackage.product_name == 'Speculator Package'){
			$('#add_speculator_package_to_cart').removeClass('display_block').addClass('display_none');
			$('#speculator_added').removeClass('display_none').addClass('display_block');
		}else if(singleProductPackage.product_name == 'Developer Package'){
			$('#add_developer_package_to_cart').removeClass('display_block').addClass('display_none');
			$('#developer_added').removeClass('display_none').addClass('display_block');
		}
	});

}
function getProductPackageList(){
	let productPackageList = localStorage.getItem("productPackage");
	
	productPackageList = (productPackageList === null) ? '[]' : productPackageList;
	productPackageList =  JSON.parse(productPackageList);

	return productPackageList;
}
function isProductAlreadyAdded(productPackageList,packageName){
	let foundProduct = false;
	productPackageList.map((productPackage, index) => {
		if(productPackage.product_name == packageName){
			foundProduct = true;
		}
	});
	return foundProduct;
}
function update_cart_show() {
	let name_list = localStorage.getItem("name_list");
	let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
	let name_list_length = name_list_array.length;

	let productPackageList = getProductPackageList();
	let productPackageListLength = productPackageList.length;
	let total_cart_items = name_list_length+productPackageListLength;
	
	$('#name_in_cart').html(total_cart_items);
}
function searchName(){
	let digitalName = $('#digital_name').val().trim();
	if(digitalName != "" && digitalName.length>2 && digitalName.charAt(0)=='$' && !/[^a-zA-Z0-9$]/.test(digitalName)){
		hideErrorMessage('#error_message');
		hideErrorMessage('#showMessage');
		hideErrorMessage('#found_name');
		$('#found_name_add_to_cart').removeClass('display_block').addClass('display_none');
		$('#searching_image').removeClass('display_none').addClass('display_block');
		fetch('search_digital_name.php?digital_name='+digitalName)
		.then(data => data.json())
		.then(data => {
			if(data == 1){
				showMessage("#error_message",digitalName+" is not available!");
			}else if(data == 0){

				let digitalName = $('#digital_name').val().trim();
		
				let name_list = localStorage.getItem("name_list");
				let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
				name_list = (name_list === null) ? digitalName + ',' : name_list + digitalName + ','

				if(!name_list_array.includes(digitalName) && !name_list_array.includes('$'+digitalName)){
					showMessage("#found_name", digitalName+" is Available.");
					$('#found_name_add_to_cart').removeClass('display_none');
					$('#found_name_add_to_cart').addClass('display_block');
				}else{
					showMessage("#error_message",digitalName+" already in cart!");
				}
			}
			$('#searching_image').removeClass('display_block').addClass('display_none');
		})
		.catch(err=>console.log(err))
	}else{
		showMessage("#error_message","Enter Valid Name!");
	}
}
function showMessage(element, message) {
	$(element).html(message);
	$(element).removeClass('display_none');
	$(element).addClass('display_block');

}
function hideErrorMessage(element) {
	$(element).removeClass('display_block');
	$(element).addClass('display_none');	
}