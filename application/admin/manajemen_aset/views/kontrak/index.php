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
	table_open('',true,base_url('manajemen_aset/kontrak/data'),'tbl_kontrak');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('nama_perusahaan'),'','data-content="perusahaan" data-table="tbl_m_mitra tbl_mitra"');
				th(lang('klasifikasi'),'','data-content="klasifikasi"');
				th(lang('lokasi_gedung'),'','data-content="nama_gedung" data-table="tbl_asset"');
				th(lang('alamat'),'','data-content="lokasi"');
				th(lang('kota'),'','data-content="kota"');
				th(lang('tgl_bak_mitra'),'','data-content="tgl_bak_mitra_gsd" data-type="daterange"');
				th(lang('tgl_kontrak_mitra'),'','data-content="tgl_kontrak_mitra_gsd" data-type="daterange"');
				th(lang('nomor_kontrak_mitra_gsd'),'','data-content="nomor_kontrak_mitra_gsd"');
				th(lang('durasi_kontrak'),'','data-content="str_durasi_kontrak"');
				th(lang('skema_kerjasama'),'','data-content="skema_kerjasama" data-table ="tbl_skema_kerjasama tbl_skema_mitra_gsd"');
				th(lang('nilai_skema_kerjasama'),'','data-content="nilai_skema_kerjasama_mitra_gsd"');
				th(lang('tanggal_akhir_kontrak'),'','data-content="tanggal_akhir_kontrak_mitra" data-type="daterange"');
				th(lang('sisa_waktu_kontrak'),'','data-content="sisa_waktu_kontrak"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-lg','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('manajemen_aset/kontrak/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('nomor_kontrak'),'nomor_kontrak');
		
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="perusahaan"><?php echo lang('perusahaan'); ?></label>
				<div class="col-sm-9">
					<select name="id_mitra" id="id_mitra" class="form-control select2" data-validation="required">
						<option value=""></option>
						<?php foreach ($opt_mitra as $ma){ ?>
							<option value="<?php echo $ma['id'] ?>" data-klasifikasi="<?php echo $ma['klasifikasi'] ?>"><?php echo $ma['perusahaan']; ?></option>
						<?php } ?>

					</select>
				</div>
			</div>
				
            <div class="form-group row">
				<label class="col-form-label col-sm-3" for="klasifikasi"><?php echo lang('klasifikasi'); ?></label>
				<div class="col-sm-9">
					<input type="text" name="klasifikasi" value="" id="klasifikasi" class="form-control" readonly data-readonly="true">
				</div>
			</div>


			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="lokasi_gedung"><?php echo lang('lokasi_gedung'); ?></label>
				<div class="col-sm-9">
					<select name="id_asset" id="id_asset" class="form-control select2" data-validation="required">
						<option value=""></option>
						<?php foreach ($opt_asset as $ma){ ?>
							<option value="<?php echo $ma['id'] ?>" data-lokasi="<?php echo $ma['alamat']; ?>" data-kota="<?php echo $ma['kota']; ?>"><?php echo $ma['nama_gedung']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
				
            <div class="form-group row">
				<label class="col-form-label col-sm-3" for="alamat"><?php echo lang('alamat'); ?></label>
				<div class="col-sm-9">
					<textarea name="lokasi" value="" id="lokasi" class="form-control" readonly data-readonly="true"></textarea>
				</div>
			</div>

			<?php
			
			input('text',lang('kota'),'kota','','','readonly');
			input('date',lang('tgl_bak_telkom_gsd'),'tgl_bak_telkom_gsd');
			input('date',lang('tgl_kontrak_telkom_gsd'),'tgl_kontrak_telkom_gsd');
			input('text',lang('nomor_kontrak_telkom_gsd'),'nomor_kontrak_telkom_gsd');
			
			input('date',lang('tgl_baso_telkom_gsd'),'tgl_baso_telkom_gsd');
			input('date',lang('tgl_bak_mitra_gsd'),'tgl_bak_mitra_gsd');
			input('date',lang('tgl_kontrak_mitra_gsd'),'tgl_kontrak_mitra_gsd');
			input('text',lang('nomor_kontrak_mitra_gsd'),'nomor_kontrak_mitra_gsd');

			input('date',lang('tgl_komersial'),'tgl_komersial');
			input('money',lang('durasi_kontrak'),'durasi_kontrak','required','','','Tahun');
			select2(lang('skema_kerjasama_telkom_gsd'),'id_skema_telkom_gsd','',$opt_skema_kerjasama,'id','skema_kerjasama');
			textarea(lang('nilai_skema_kerjasama_telkom_gsd'),'nilai_skema_kerjasama_telkom_gsd');
			select2(lang('skema_kerjasama_mitra_gsd'),'id_skema_mitra_gsd','',$opt_skema_kerjasama,'id','skema_kerjasama');
			textarea(lang('nilai_skema_kerjasama_mitra_gsd'),'nilai_skema_kerjasama_mitra_gsd');
			input('text',lang('investasi'),'investasi');
			input('date',lang('tanggal_akhir_kontrak'),'tanggal_akhir_kontrak_mitra');

			
			input('text',lang('sisa_waktu_kontrak'),'sisa_waktu_kontrak','','','readonly placeholder="Otomatis saat disimpan"');
			
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="perpanjang_kontrak"><?php echo lang('perpanjang_kontrak'); ?></label>
				<div class="col-sm-2 col-3">
					<button type="button" class="btn btn-block btn-success btn-icon-only btn-add-anggota"><i class="fa-plus"></i></button>
				</div>
			</div>
			<div id="additional-anggota" class="mb-2"></div>
			<?php

			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('manajemen_aset/kontrak/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>

<script type="text/javascript">
	
	function formOpen() {
		var response = response_edit;
		$('#additional-anggota').html('');

		$('label[for="perpanjang_kontrak"]').hide()
		$('.btn-add-anggota').hide();

		if(typeof response.id != 'undefined' && parseInt(response.id) > 0) {
			var n = response.detail.length;
			for(var x=1; x<=n; x++) {
				add_row_anggota();
			}

			if(response.sisa_waktu_kontrak == 'Kadaluarsa'){
				$('label[for="perpanjang_kontrak"]').show()
				$('.btn-add-anggota').show();
			}

			$('.tanggal').each(function(k,v){
				if(typeof response.detail[k] != 'undefined') {
					$(this).val(response.detail[k].tanggal_perpanjang);
				}
			});
		}
	}

	function detail_callback(id){
		$.get(base_url+'manajemen_aset/kontrak/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}

	$('#id_mitra').change(function(){
		$('#klasifikasi').val($(this).find(':selected').attr('data-klasifikasi'));
	});

	$('#id_asset').change(function(){
		$('#lokasi').val($(this).find(':selected').attr('data-lokasi'));
		$('#kota').val($(this).find(':selected').attr('data-kota'));
	});

	function add_row_anggota() {
		konten = '<div class="form-group row">'
				+ '<div class="offset-sm-3 col-sm-7 col-9">'
				+ '<input type="date" name="tanggal[]" autocomplete="off" class="form-control dtp tanggal" placeholder="tanggal">'
				+ '</div>'
				+ '<div class="col-sm-2 col-3">'
				+ '<button type="button" class="btn btn-block btn-danger btn-icon-only btn-remove-anggota"><i class="fa-times"></i></button>'
				+ '</div>'
				+ '</div>';
		$('#additional-anggota').append(konten);
	}
	$('.btn-add-anggota').click(function(){
		add_row_anggota();
	});
	$(document).on('click','.btn-remove-anggota',function(){
		$(this).closest('.form-group').remove();
	});


</script>
