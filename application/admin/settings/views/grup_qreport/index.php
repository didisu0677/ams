<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete,active,inactive,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('settings/grup_qreport/data'),'tbl_group_progress_report');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('group_by'),'','data-content="group_by"');
				th(lang('_key'),'','data-content="_key"');
				th(lang('_nama'),'','data-content="_nama"');
				th(lang('master_tabel'),'','data-content="master_tabel"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/grup_qreport/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('group_by'),'group_by');
			input('text',lang('_key'),'_key');
			input('text',lang('_nama'),'_nama');
			input('text',lang('master_tabel'),'master_tabel');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/grup_qreport/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
