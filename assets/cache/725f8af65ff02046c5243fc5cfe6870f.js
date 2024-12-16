
	function formOpen() {
		var is_edit = false;
		var response = response_edit;
		$('#id_asset').html('');
		if(typeof response.id != 'undefined') {
			$.each(response.detail,function(n,z){
				$('#k_'+z._key).val(z.keterangan);
			});	

			$('#id_asset').html('<option value="'+response.id_asset+'" data-alamat="'+response.alamat+'" data-kota="'+response.kota+'">'+response.nama_gedung+'</option>').trigger('change');	

		//	$('#id_fm').html('<option value="'+response.id_fm+'">'+response.facility_management+'</option>').trigger('change');	
		}else{
			$('.select2').val('BLM').attr('selected','selected').change();
		}

		is_edit= false;
	}

	function detail_callback(id){
		$.get(base_url+'manajemen_aset/aktivitas/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}

	$('#id_asset').change(function(){
		$('#alamat').val($(this).find(':selected').attr('data-alamat'));
		$('#kota').val($(this).find(':selected').attr('data-kota'));
	});

	$('#id_mitra').change(function(){
		$('#klasifikasi').val($(this).find(':selected').attr('data-klasifikasi'));
		$('#brand').val($(this).find(':selected').attr('data-brand'));
		$('#penanggung_jawab_mitra').val($(this).find(':selected').attr('data-penanggung_jawab'));
	});

	$('#id_fm').change(function(){
    	$('#alamat').val('');
    	$('#kota').val('');
    	get_asset();
	});

	function get_asset() {
		if(proccess) {
			readonly_ajax = false;
			$.ajax({
				url : base_url + 'manajemen_aset/aktivitas/get_asset',
				data : {id_fm: $('#id_fm').val()},
				type : 'POST',
				success	: function(response) {
					rs = response;
					$('#id_asset').html(response);
				}
			});
		}
	}
