<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<select class="select2 infinity custom-select" id="filter-area">
				<?php echo select_option($area,'id','area', count($area) > 0 ? $area[0]['id'] : ''); ?>
			</select>
			<?php echo access_button('delete'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('settings/facility_management/data'),'tbl_m_facility_management');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('facility_management'),'','data-content="facility_management"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','','data-openCallback="openForm"');
	modal_body();
		form_open(base_url('settings/facility_management/save'),'post','form');
			col_init(4,8);
			input('hidden','id','id');
			input('hidden',lang('area'),'id_area','unique_group');
			input('text',lang('area'),'area','','','disabled');
			input('text',lang('facility_management'),'facility_management','required|max-length:255');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
?>
<script>

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
</script>