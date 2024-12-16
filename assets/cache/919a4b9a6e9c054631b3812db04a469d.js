

$('#form-laporan').submit(function(e){
	e.preventDefault();
	if(validation('form-laporan')) {
		$.ajax({
			url 		: $(this).attr('action'),
			data 		: $(this).serialize(),
			type 		: 'post',
			dataType	: 'json',
			success 	: function(response) {
				var konten 				= '';
				var konten_overall 		= '';
				var i = 0;
				var n = 0;
				var persen_cogs = 0;
				var persen_opr = 0;

				$.each(response.result,function(k,v){	
					i++;	
					konten += '<tr>';
						konten += '<td style="background-color: #e0f2f1; color: black; class="">'+i+' </td>'
						konten += '<td style="background-color: #e0f2f1; color: black; class="">'+v.area+' </td>';
						konten += '<td style="background-color: #e0f2f1; color: black; class="">'+v.facility_management+' </td>';
						konten += '<td style="background-color: #e0f2f1; color: black; class="">'+v.nama_gedung+' </td>';
						konten += '<td style="background-color: #e0f2f1; color: black; class="text-center">'+v.alamat+' </td>';
						konten += '<td style="background-color: #e0f2f1; color: black; class="text-center">'+v.kota+'</td>';				
						konten += '</tr>';
						konten += '<tr>';
						konten += '<th>Keterangan: </th>';
						konten += '<td><a href="'+base_url+'laporan/query_asset/detail/?nomor='+v.nomor+'" class="cInfo">'+v.nomor+'</a></td>';
						konten += '</tr>';
						konten += '<tr>';
						$.each(response.photo_gedung,function(x,y){
							if(v.id == x) {
								konten += '<td rowspan="3">';    
                                konten += '<div style="margin: 0 auto; width: 130px">';
                                konten += '<a href="'+base_url+'assets/uploads/foto_gedung/'+v.id+'/'+y+'" target="_blank"><img src="'+base_url+'assets/uploads/foto_gedung/'+v.id+'/'+y+'" alt="" style="width: 130px" /></a>';
                                konten += '</div>';                        
                                konten += '</td>';
							}
						});
						konten += '<th>Jenis Asset </th>';
						konten += '<td colspan="2">'+v.jenis_bangunan+'</td>';
						konten += '<th>Penggunaan saat ini </th>';
						konten += '<td>'+v.status_penggunaan+'</td>';
						konten += '</tr>'
						konten += '<th>Luas Bangunan </th>';
						konten += '<td colspan="2">'+numberFormat(v.luas_bangunan,0)+' M2</td>';
						konten += '<th>Tipe Asset </th>';
						konten += '<td>'+v.tipe_asset+'</td>';
						konten += '<tr>'
						konten += '<th>Informasi Sekitar </th>';
						konten += '<td colspan="2">'+v.informasi_sekitar+'</td>';
						konten += '<th>Luas Tanah </th>';
						konten += '<td>'+numberFormat(v.luas_tanah,0)+' M2</td>';
						konten += '</tr>'
				});

				$('.result').html(konten);
			}
		});
	}
});

$('#id_area').change(function(){
	get_fm();
});

$('#id_fm').change(function(){
	get_namagedung();
});


function get_fm() {
	if(proccess) {
		readonly_ajax = false;
		$.ajax({
			url : base_url + 'laporan/query_asset/get_fm',
			data : {id_area: $('#id_area').val()},
			type : 'POST',
			success	: function(response) {
				rs = response;
				$('#id_fm').html(response)
			}
		});
	}
}

function get_namagedung() {
	if(proccess) {
		readonly_ajax = false;
		$.ajax({
			url : base_url + 'laporan/query_asset/get_namagedung',
			data : {id_fm: $('#id_fm').val()},
			type : 'POST',
			success	: function(response) {
				rs = response;
				$('#id_asset').html(response)
			}
		});
	}
}

$('#form-export').submit(function(e){
	e.preventDefault();
	if(validation('form-laporan')) {
		var params = {
			'csrf_token' 	: $('#token').val(),
			'tipe' 			: $('#export-to').val(),
			'status_name'	: $('#status option:selected').text()
		};
		var url = $(this).attr('action');
		$.redirect(url, params, "POST", "_blank"); 
	}
});

