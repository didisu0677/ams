

$('#filter-area').change(function(){
	$('[data-serverside]').attr('data-serverside',base_url + 'settings/facility_management/data?id_area=' + $(this).val());
	refreshData();
});
$(document).ready(function(){
	$('#filter-area').trigger('change');
})
function openForm() {
	$('#id_area').val($('#filter-area').val());
	$('#area').val($('#filter-area').find(':selected').text());
	if(typeof response_edit.id != 'undefined') {
		$('#facility_management').val(response_edit.facility_management);
	}
}
