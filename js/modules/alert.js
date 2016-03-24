/**
 * @author bramb
 */

function showAlert(type,message){
	$alert = "<div class='warning "+type+"'>"+message+"</div>";
	$('.alert-container').html($alert);
	return;
}
