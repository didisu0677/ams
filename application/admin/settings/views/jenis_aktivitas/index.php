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
	table_open('',true,base_url('settings/jenis_aktivitas/data'),'tbl_m_jenis_aktivitas');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('nama_aktivitas'),'','data-content="nama_aktivitas"');
				th(lang('group_aktivitas'),'','data-content="grup_aktivitas" data-table="tbl_grup_aktivitas"');
				th(lang('sub_aktivitas'),'','data-content="sub_aktivitas" data-table="tbl_sub_aktivitas"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/jenis_aktivitas/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('nama_aktivitas'),'nama_aktivitas');
			select2(lang('group_aktivitas'),'id_grup_aktivitas','required',$opt_grup_aktivitas,'id','grup_aktivitas');
			select2(lang('sub_aktivitas'),'id_sub_aktivitas','required',$opt_sub_aktivitas,'id','sub_aktivitas');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/jenis_aktivitas/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
