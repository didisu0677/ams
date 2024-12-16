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
	table_open('',true,base_url('manajemen_aset/daftar_aset/data'),'tbl_asset');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('id_asset'),'','data-content="nomor"');
				th(lang('nama_gedung'),'','data-content="nama_gedung"');
				th(lang('alamat'),'','data-content="alamat"');
				th(lang('kota'),'','data-content="kota"');
				th(lang('titik_koordinat'),'','data-content="titik_koordinat"');
				th(lang('pemilik'),'','data-content="pemilik_aset" data-table ="tbl_pemilik_aset"');
				th(lang('status_asset'),'','data-content="status_asset" data-table="tbl_status_asset"');
				th(lang('status_tanah'),'','data-content="status_tanah"');
				th(lang('masa_berlaku_surat_tanah'),'','data-content="masa_berlaku_surat_tanah" data-type="daterange"');
				th(lang('luas_tanah') . " (M2)",'text-right','data-content="luas_tanah" data-type="currency"');
				th(lang('lxp_tanah') . " (M)",'','data-content="LXP_tanah"');
				th(lang('bentuk_tanah'),'','data-content="bentuk_tanah"');
				th(lang('luas_bangunan'). " (M2)",'text-right','data-content="luas_bangunan" data-type="currency"');
				th(lang('jumlah_ltbangunan'),'','data-content="jumlah_ltbangunan"');
				th(lang('luas_area_idle') . " (M2)",'text-right','data-content="luas_area_idle" data-type="currency"');
				th(lang('jenis_bangunan'),'','data-content="jenis_bangunan" data-table="tbl_jenis_bangunan"');
				th(lang('tipe_asset'),'','data-content="tipe_asset" data-table="tbl_m_tipe_asset tbl_tipe_asset"');
				th(lang('status_penggunaan'),'','data-content="status_penggunaan"');
				th(lang('usulan_penggunaan'),'','data-content="usulan_penggunaan"');
				th(lang('usulan_mitra'),'','data-content="usulan_mitra"');
				th(lang('jarak_usulan_mitra_lokasi'),'','data-content="jarak_usulan_mitra_lokasi" data-default="-"');
				th(lang('area'),'','data-content="area" data-table ="tbl_area"');
				th(lang('facility_management'),'','data-content="facility_management"');
				th(lang('propar'),'','data-content="propar" data-replace="1:AVAILABLE|0:" " data-link="manajemen_aset/daftar_aset/propar/"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-lg','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('manajemen_aset/daftar_aset/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('nomor_asset'),'nomor');
			input('text',lang('nama_gedung'),'nama_gedung');
			textarea(lang('alamat'),'alamat');
			select2(lang('kota'),'id_kota','required',$opt_kota,'id','nama_kota');
			input('text',lang('titik_koordinat'),'titik_koordinat');
			select2(lang('pemilik'),'id_pemilik','required',$opt_pemilik,'id','pemilik_aset');
			select2(lang('status_asset'),'id_status_asset','',$status_asset,'id','status_asset');
	//		select2(lang('mitra'),'id_mitra','',$opt_mitra,'id','perusahaan');

			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="id_mitra"><?php echo lang('mitra'); ?></label>
				<div class="col-sm-9">
					<select name="id_mitra" id="id_mitra" class="form-control select2">
						<option value=""></option>
						<?php foreach ($opt_mitra as $ma){ ?>
							<option value="<?php echo $ma['id'] ?>"><?php echo $ma['brand'] .' - '.$ma['perusahaan']; ?></option>
						<?php } ?>

					</select>
				</div>
			</div>
			<?php
			select2(lang('skema_kerjasama'),'id_skema_kerjasama','',$opt_skema_kerjasama,'id','skema_kerjasama');
			select2(lang('status_tanah'),'status_tanah','required',$status_tanah,'status_tanah');
			input('date',lang('masa_berlaku_surat_tanah'),'masa_berlaku_surat_tanah');
	
			input('money',lang('luas_tanah'),'luas_tanah','required','','','M2');
			input('text',lang('lxp_tanah'),'LXP_tanah','required');
			select2(lang('bentuk_tanah'),'bentuk_tanah','required',$bentuk_tanah,'bentuk_tanah');
			input('money',lang('luas_bangunan'),'luas_bangunan','','','','M2');
			input('text',lang('jumlah_ltbangunan'),'jumlah_ltbangunan');
			input('money',lang('luas_area_idle'),'luas_area_idle','','','','M2');
			select2(lang('jenis_bangunan'),'id_jenis_bangunan','',$jenis_bangunan,'id','jenis_bangunan');
			select2(lang('tipe_asset'),'id_tipe_asset','',$opt_tipe_asset,'id','tipe_asset');
			label(lang('batasan_lahan'));
			sub_open(1);
				input('text',lang('utara'),'batas_utara');
				input('text',lang('selatan'),'batas_selatan');
				input('text',lang('timur'),'batas_timur');
				input('text',lang('barat'),'batas_barat');
			sub_close();

			textarea(lang('informasi_sekitar'),'informasi_sekitar');
			select2(lang('status_penggunaan'),'id_status_penggunaan','required',$status_penggunaan,'id','status_penggunaan');
			select2(lang('usulan_penggunaan'),'id_usulan_penggunaan[]','',$opt_id_klasifikasi,'id','klasifikasi','','multiple');
			select2(lang('usulan_mitra'),'id_usulan_mitra[]','',$opt_mitra,'id','brand','','multiple');
			input('text',lang('jarak_usulan_mitra_lokasi'),'jarak_usulan_mitra_lokasi','','','','M');
			select2(lang('catu_daya'),'catu_daya','',$catu_daya,'luas_bangunan');
			select2(lang('area'),'id_area','',$opt_area,'id','area');
			select2(lang('facility_management'),'id_fm');

			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3"><?php echo lang('support_data') ?><small><?php echo lang('maksimal'); ?> 5MB</small></label>
				<div class="col-sm-9">
					<button type="button" class="btn btn-info" id="add-file" title="<?php echo lang('tambah_dokumen'); ?>"><?php echo lang('tambah_dokumen'); ?></button>
				</div>
			</div>
			<div id="additional-file" class="mb-2"></div>

			<?php
			label(lang('foto_gedung'));		
			?>
			<?php foreach($dok as $d) { ?>
			<input type="hidden" name="id_foto[<?php echo $d->id; ?>]" value="<?php echo $d->id; ?>">
			<input type="hidden" name="old_file_foto[<?php echo $d->id; ?>]" id = "old_file_foto_<?php echo $d->id; ?>" value="">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label sub-1"><?php echo $d->nama; ?></label>						
				<div class="col-sm-6">
					<div class="input-group">
						<input type="text" name="file_foto[<?php echo $d->id; ?>]" id="dok_<?php echo $d->id; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="jpg|jpeg|png">

						<div class="input-group-append">
							<div id="<?php echo 'file_foto'. $d->id; ?>" class ="text-center dwlfile"></div>
						</div>
					</div>
				</div>
			</div>
			<?php }	?>
			<?php
			input('text',lang('keterangan'),'keterangan');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('manajemen_aset/daftar_aset/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>

<form action="<?php echo base_url('upload/file/datetime'); ?>" class="hidden">
	<input type="hidden" name="name" value="field_document">
	<input type="hidden" name="token" value="<?php echo encode_id([user('id'),(time() + 900)]); ?>">
	<input type="file" name="document" id="upl-file">
</form>

<script type="text/javascript">
	var file_foto = {};
	var is_edit = false;
	var idx = 999;
	function formOpen() {
		var response = response_edit;
		$('#additional-file').html('');
		$('#id_fm').html('');
		$('.dwlfile').html('');
		if(typeof response.id != 'undefined') {

			$.each(response.id_usulan_penggunaan, function(k,v){
				$('#id_usulan_penggunaan').find('[value="'+v+'"]').prop('selected',true);
			});
			$('#id_usulan_penggunaan').trigger('change');

			$.each(response.id_usulan_mitra, function(k,v){
				$('#id_usulan_mitra').find('[value="'+v+'"]').prop('selected',true);
			});
			$('#id_usulan_mitra').trigger('change');

			$('#status_asset').trigger('change');
			$('#id_status_penggunaan').trigger('change');

			$('#id_fm').html('<option value="'+response.id_fm+'">'+response.facility_management+'</option>').trigger('change');	

			$.each(response.file,function(n,z){
				var konten = '<div class="form-group row">'
					+ '<div class="col-sm-3 col-4 offset-sm-3">'
					+ '<input type="text" class="form-control" autocomplete="off" value="'+n+'" name="keterangan_file[]" placeholder="'+lang.keterangan+'" data-validation="required" aria-label="'+lang.keterangan+'">'
					+ '</div>'
					+ '<div class="col-sm-4 col-5">'
					+ '<input type="hidden" class="form-control" name="file[]" autocomplete="off" value="exist:'+z+'">'
					+ '<div class="input-group">'
					+ '<input type="text" class="form-control" autocomplete="off" disabled value="'+z+'">'
					+ '<div class="input-group-append">'
					+ '<a href="'+base_url+'assets/uploads/aset/'+z+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a>'
					+ '</div>'
					+ '</div>'
					+ '</div>'
					+ '<div class="col-sm-2 col-3">'
					+ '<button type="button" class="btn btn-danger btn-remove btn-block btn-icon-only"><i class="fa-times"></i></button>'
					+ '</div>'
					+ '</div>';
				$('#additional-file').append(konten);
			});


			if(response.file_foto.length > 0) {
					$.each(response.file_foto,function(k,v){
						$('#dok_'+v.id_foto_gedung).val(v.file_foto);
						if(v.file_foto) {
							var konten = '<div class="input-group-append"><a href ="'+base_url+'assets/uploads/foto_gedung/'+response.id+'/'+v.file_foto+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i> Unduh</a></div>';
							$('#file_foto'+v.id_foto_gedung).html(konten);
							$('#old_file_foto_'+v.id_foto_gedung).val(v.file_foto);
						} 
					});

				}
		}
		is_edit= false;
	}

	function detail_callback(id){
		$.get(base_url+'manajemen_aset/daftar_aset/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}

	$(document).on('click','.btn-remove',function(){
		$(this).closest('.form-group').remove();
	});
	$('#add-file').click(function(){
		$('#upl-file').click();
	});
	var accept 	= Base64.decode(upl_alw);
	var regex 	= "(\.|\/)("+accept+")$";
	var re 		= accept == '*' ? '*' : new RegExp(regex,"i");
	$('#upl-file').fileupload({
		maxFileSize: upl_flsz,
		autoUpload: false,
		dataType: 'text',
		acceptFileTypes: re
	}).on('fileuploadadd', function(e, data) {
		$('#add-file').attr('disabled',true);
		data.process();
		is_autocomplete = true;
	}).on('fileuploadprocessalways', function (e, data) {
		if (data.files.error) {
			var explode = accept.split('|');
			var acc 	= '';
			$.each(explode,function(i){
				if(i == 0) {
					acc += '*.' + explode[i];
				} else if (i == explode.length - 1) {
					acc += ', ' + lang.atau + ' *.' + explode[i];
				} else {
					acc += ', *.' + explode[i];
				}
			});
			cAlert.open(lang.file_yang_diizinkan + ' ' + acc + '. ' + lang.ukuran_file_maks + ' : ' + (upl_flsz / 1024 / 1024) + 'MB');
			$('#add-file').text($('#add-file').attr('title')).removeAttr('disabled');
		} else {
			data.submit();
		}
		is_autocomplete = false;
	}).on('fileuploadprogressall', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#add-file').text(progress + '%');
	}).on('fileuploaddone', function (e, data) {
		if(data.result == 'invalid' || data.result == '') {
			cAlert.open(lang.gagal_menunggah_file,'error');
		} else {
			var spl_result = data.result.split('/');
			if(spl_result.length == 1) spl_result = data.result.split('\\');
			if(spl_result.length > 1) {
				var spl_last_str = spl_result[spl_result.length - 1].split('.');
				if(spl_last_str.length == 2) {
					var filename = data.result;
					var f = filename.split('/');
					var fl = filename.split('temp');
					var fl_link = base_url + 'assets/uploads/temp' + fl[1];
					var konten = '<div class="form-group row">'
								+ '<div class="col-sm-3 col-4 offset-sm-3">'
								+ '<input type="text" class="form-control" autocomplete="off" value="" name="keterangan_file[]" placeholder="'+lang.keterangan+'" data-validation="required" aria-label="'+lang.keterangan+'">'
								+ '</div>'
								+ '<div class="col-sm-4 col-5">'
								+ '<input type="hidden" class="form-control" name="file[]" autocomplete="off" value="'+data.result+'">'
								+ '<div class="input-group">'
								+ '<input type="text" class="form-control" autocomplete="off" disabled value="'+f[f.length - 1]+'">'
								+ '<div class="input-group-append">'
								+ '<a href="'+fl_link+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a>'
								+ '</div>'
								+ '</div>'
								+ '</div>'
								+ '<div class="col-sm-2 col-3">'
								+ '<button type="button" class="btn btn-danger btn-remove btn-block btn-icon-only"><i class="fa-times"></i></button>'
								+ '</div>'
								+ '</div>';
					$('#additional-file').append(konten);
				} else {
					cAlert.open(lang.file_gagal_diunggah,'error');
				}
			} else {
				cAlert.open(lang.file_gagal_diunggah,'error');						
			}
		}
		$('#add-file').text($('#add-file').attr('title')).removeAttr('disabled');
		is_autocomplete = false;
	}).on('fileuploadfail', function (e, data) {
		cAlert.open(lang.gagal_menunggah_file,'error');
		$('#add-file').text($('#add-file').attr('title')).removeAttr('disabled');
		is_autocomplete = false;
	}).on('fileuploadalways', function() {
	});


	$('#id_area').change(function(){
    	get_fm();
	});


	$(function () {
	  $("#id_status_asset").change(function() {
	    var val = $(this).val();
	    if(val == 3) {
			$('label[for="id_mitra"]').hide()
			$('label[for="id_skema_kerjasama"]').hide()
			$('#id_mitra').parent().hide();
			$('#id_skema_kerjasama').parent().hide();
	    }
	    else { 
	    	$('label[for="id_mitra"]').show()
			$('label[for="id_skema_kerjasama"]').show()
	    	$('#id_mitra').parent().show();
	    	$('#id_skema_kerjasama').parent().show();
	    }
	  });
	});

	$(function () {
	  $("#id_status_penggunaan").change(function() {
	    var val = $(this).val();
	    if(val == 12) {
			$('label[for="id_usulan_penggunaan"]').hide()
			$('label[for="id_usulan_mitra"]').hide();
			$('label[for="jarak_usulan_mitra_lokasi"]').hide();
			$('#id_usulan_penggunaan').parent().hide()
			$('#id_usulan_mitra').parent().hide();
			$('#jarak_usulan_mitra_lokasi').parent().hide();
	    }
	    else { 
	    	$('label[for="id_usulan_penggunaan"]').show()
			$('label[for="id_usulan_mitra"]').show()
			$('label[for="jarak_usulan_mitra_lokasi"]').show();
	    	$('#id_usulan_penggunaan').parent().show();
	    	$('#id_usulan_mitra').parent().show();
	    	$('#jarak_usulan_mitra_lokasi').parent().show();
	    }
	  });
	});
	
	function get_fm() {
		if(proccess) {
			readonly_ajax = false;
			$.ajax({
				url : base_url + 'manajemen_aset/daftar_aset/get_fm',
				data : {id_area: $('#id_area').val()},
				type : 'POST',
				success	: function(response) {
					rs = response;
					$('#id_fm').html(response)
				}
			});
		}
	}

</script>	