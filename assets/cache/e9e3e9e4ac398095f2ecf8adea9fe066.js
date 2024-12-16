
	
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


