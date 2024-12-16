
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

