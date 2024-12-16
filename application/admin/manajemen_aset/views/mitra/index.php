<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('manajemen_aset/mitra/data'),'tbl_m_mitra');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('klasifikasi'),'','data-content="klasifikasi" data-table="tbl_m_klasifikasi_mitra tbl_klasifikasi"');
				th(lang('brand'),'','data-content="brand"');
				th(lang('logo_brand'),'','data-content="logo_brand" data-type="image" width="100"');
				th(lang('perusahaan'),'','data-content="perusahaan"');
				th(lang('alamat_perusahaan'),'','data-content="alamat_perusahaan"');
				th(lang('pic_telepon'),'','data-content="pic_telepon"');
				th(lang('jumlah_kerjasama'),'','data-content="jumlah_kerjasama"');
				th(lang('skema_kerjasama'),'','data-content="skema_kerjasama" data-table ="tbl_skema_kerjasama"');
				th(lang('keterangan'),'','data-content="keterangan"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-lg');
	modal_body();
		form_open(base_url('manajemen_aset/mitra/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('id_perusahaan'),'nomor');
			select2(lang('klasifikasi'),'id_klasifikasi','required',$opt_id_klasifikasi,'id','klasifikasi');
			select2(lang('brand'),'id_brand','required',$opt_brand,'id','brand');
			imageupload(lang('logo_brand'),'logo_brand','200','200','force');
			input('text',lang('perusahaan'),'perusahaan');
			textarea(lang('alamat_perusahaan'),'alamat_perusahaan');
			textarea(lang('pic_telepon'),'pic_telepon');

			input('text',lang('jumlah_kerjasama'),'jumlah_kerjasama');
			select2(lang('penanggung_jawab_mitra'),'penanggung_jawab_mitra','required',$opt_penanggung_jawab,'id','nama');
			label(lang('mitra_requirement'));
			sub_open(1);
				select2(lang('luas_lahan'),'luas_lahan','required',$luas_lahan,'luas_lahan');
				select2(lang('luas_bangunan'),'luas_bangunan','required',$luas_bangunan,'luas_bangunan');
				select2(lang('tipe_asset'),'id_tipe_asset','required',$opt_tipe_asset,'id','tipe_asset');
				input('text',lang('special_request'),'special_request');
			sub_close();

			select2(lang('skema_kerjasama'),'id_skema_kerjasama','required',$opt_skema_kerjasama,'id','skema_kerjasama');
			textarea(lang('keterangan'),'keterangan');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('manajemen_aset/mitra/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>

<script type="text/javascript">
	function detail_callback(id){
		$.get(base_url+'manajemen_aset/mitra/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}
</script>	