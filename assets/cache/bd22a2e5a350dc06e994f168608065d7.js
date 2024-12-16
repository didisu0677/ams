

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
				var total2 = 0 ;
				$.each(response.result,function(k,v){	
					i++;	
					if(v.revenue !=0 && v.beban_cogs !=0 ) {
						persen_cogs = (v.beban_cogs / v.revenue) * 100 ;
					}
					if(v.revenue !=0 && v.beban_operasional !=0 ) {
						persen_opr = (v.beban_operasional / v.revenue) * 100 ;
					}
					konten += '<tr>';
						konten += '<td class="">'+i+' </td>'
						konten += '<td class="">'+v.nama_portfolio+' </td>';
						konten += '<td class="">'+v.brand+' </td>';
						konten += '<td class="">'+v.nama_gedung+' </td>';
						konten += '<td class="text-center">'+v.alamat+' </td>';
						konten += '<td class="text-center">'+v.kota+'</td>';
						konten += '<td class="text-center">'+v.facility_management+'</td>';
						konten += '<td class="text-center">'+v.area+'</td>';
						konten += '<td class="text-right">'+numberFormat(v.piutang,0)+'</td>';					
						konten += '</tr>';
						total2 += parseInt(v.piutang);
				});
				konten += '<tr>';
				konten += '<td colspan = "8" style="background-color: #0d47a1; color: white;" class="text-center align-middle"><b>GRAND TOTAL </b></td>';
				konten += '<td class="text-center" style="background-color: #0d47a1; color: white;"><b>'+numberFormat(total2,0)+' </b></td>';
				konten += '</tr>';
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
			url : base_url + 'laporan/query_piutang/get_fm',
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
			url : base_url + 'laporan/query_piutang/get_namagedung',
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

