

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
				var data_pie 			= [];
				var color_pie 			= [];
				var label_chart 		= [];
				var i = 0;
				var n = 0;
				var jumlah = 0;
				var nmjumlah = '';
				var nmjumlah1 = '';
				var total = 0 ;
				var total_progress = response.total_progress;
					$.each(response.result,function(k,v){		
						jumlah = 0;
						nmjumlah1 = 'jumlah' + i ;
						$.each(response.jumlah,function(r,z){
							if(k==r){
								nmjumlah1 = z;
							}
						n++;	
						});	

						$.each(response.progress,function(r,z){
							if(k==r){
								nprogress1 = z;
							}
						n++;	
						});	

					konten += '<tr>';
					konten += '<th colspan="11" style="background: #f9f9f9; color: #484848;">'+k+'</th>';
					konten += '</tr>';
					konten_overall += '<tr>';
					konten_overall += '<td>'+k+'</td>';
					konten_overall += '<td class="text-center">'+nmjumlah1+'</td>';
					konten_overall += '<td class="text-center">'+nprogress1+' %</td>';
					konten_overall += '</tr>';
					$.each(v,function(x,y){
						konten += '<tr>';
						konten += '<td class="sub-1">'+y.jenis+' </td>';
						konten += '<td class="text-center">'+y.jumlah+' </td>';
						konten += '<td class="text-center">'+y.progress+' %</td>';
						konten += '</tr>';
						total += y.total;
						total_progress = total_progress;
					});

					i++;
				});
					konten_overall += '<tr>';
					konten_overall += '<td style="background-color: #0d47a1; color: white;"><b>GRAND TOTAL </b></td>';
					konten_overall += '<td class="text-center" style="background-color: #0d47a1; color: white;"><b>'+total+' </b></td>';
					konten_overall += '<td class="text-center" style="background-color: #0d47a1; color: white;"><b>'+total_progress+' %</b></td>';
					konten_overall += '</tr>';

					konten += '<tr>';
					konten += '<td style="background-color: #0d47a1; color: white;"><b>GRAND TOTAL </b></td>';
					konten += '<td class="text-center" style="background-color: #0d47a1; color: white;"><b>'+total+' </b></td>';
					konten += '<td class="text-center" style="background-color: #0d47a1; color: white;"><b>'+total_progress+' %</b></td>';
					konten += '</tr>';
				$('.result-overall').html(konten_overall);
				$('.result').html(konten);
			}
		});
	}
});

$('#id_area').change(function(){
	get_fm();
});

$('#group1').change(function(){
	get_sub();
});


function get_fm() {
	if(proccess) {
		readonly_ajax = false;
		$.ajax({
			url : base_url + 'laporan/progress_report/get_fm',
			data : {id_area: $('#id_area').val()},
			type : 'POST',
			success	: function(response) {
				rs = response;
				$('#id_fm').html(response)
			}
		});
	}
}

function get_sub() {
	if(proccess) {
		readonly_ajax = false;
		$.ajax({
			url : base_url + 'laporan/progress_report/get_sub',
			data : {id_group: $('#group1').val()},
			type : 'POST',
			success	: function(response) {
				rs = response;
				$('#group2').html(response)
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
$(document).ready(function(){
	var ctxPie = document.getElementById('chart').getContext('2d');
	myChart = new Chart(ctxPie, {
		type: 'pie',
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				position: 'right',
				labels: {
					boxWidth: 15,
					generateLabels: function(chart) {
						var data = chart.data;
						if (data.labels.length && data.datasets.length) {
							return data.labels.map(function(label, i) {
								var meta = chart.getDatasetMeta(0);
								var ds = data.datasets[0];
								var arc = meta.data[i];
								var custom = arc && arc.custom || {};
								var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
								var arcOpts = chart.options.elements.arc;
								var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
								var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
								var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

								var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

								return {
									text: label + " : " + value,
									fillStyle: fill,
									strokeStyle: stroke,
									lineWidth: bw,
									hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
									index: i
								};
							});
						} else {
							return [];
						}
					}
				}
			}
		}
	});
});
