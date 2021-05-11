$(document).ready(function(){
	update_cart_show();
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
});

function update_cart_show() {
	let name_list = localStorage.getItem("name_list");
	let name_list_array = (name_list === null) ? [] : name_list.replace(/(^,)|(,$)/g, "").split(",");
	$('#name_in_cart').html(name_list_array.length);
}
function searchName(){
	let digitalName = $('#digital_name').val().trim();
	if(digitalName != "" && digitalName.length>2 && digitalName.charAt(0)=='$'){
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