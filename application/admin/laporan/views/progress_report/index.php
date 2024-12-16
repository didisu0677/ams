<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<div class="main-container">
	<div class="row">
		<div class="col-sm-3 col-12 mb-2">
			<div class="sticky-top">
				<?php
					card_open('Filter','mb-2');
						form_open(base_url('laporan/progress_report/view'),'post','form-laporan');
							col_init(12,12);
							select2('Area','id_area','required|all',$area,'id','area');
							select2('Facility Management','id_fm','infinity|all');
							select2('Brand','brand','required|infinity|all',$brand,'id','brand');
							select2('Penanggung Jawab','penanggung_jawab','all',$penanggung_jawab,'nama','nama');
							select2('Group by','group1','required|infinity|',$group_by,'id','group_by');
							select2('Group by','group2','required|infinity|');
							form_button('Filter',false);
						form_close();
					card_close();
					//card_open('Export Laporan');
					//	form_open(base_url('laporan/progress_report/view'),'post','form-export');
						?>
						<!--
							<div class="form-group row">
								<div class="col-6">
									<input type="hidden" id="token" value="<?php csrf_token(false); ?>">
									<select class="custom-select select2 infinity" id="export-to">
										<option value="excel">Excel</option>
										<option value="pdf">PDF</option>
									</select>
								</div>
								<div class="col-6">
									<button type="submit" class="btn btn-sm btn-info btn-block"><i class="fa-upload"></i>Export</button>
								</div>
							</div> 
						-->
						<?php //form_close();
					//card_close();
				?>
			</div>
		</div>
			<div class="col-sm-9 col-12">
			<div class="card">
				<div class="card-header pl-3 pr-3">
					<ul class="nav nav-pills card-header-pills">
						<li class="nav-item">
							<a class="nav-link active" href="#overall" data-toggle="pill" role="tab" aria-controls="pills-overall" aria-selected="true">Total</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#detail" data-toggle="pill" role="tab" aria-controls="pills-detail" aria-selected="true">Detil</a>
						</li>
					</ul>
				</div>
				<div class="card-body tab-content">
					<div class="table-responsive tab-pane fade active show" id="overall">
						<div class="row mr-0 ml-0">
							<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
							<?php
								table_open('table table-bordered table-app table-hover');
									thead();
										tr();
											th('Group by');
											th('Jumlah','text-center','width="150"');
											th('progress','text-center','width="150"');
									tbody('result-overall');
										tr();
											td('Silahkan filter laporan terlebih dahulu','text-left','colspan="3"');
								table_close();
							?>							
							</div>
						</div>
					</div>
					<div class="table-responsive tab-pane fade" id="detail">
					<?php
						table_open('table table-bordered table-app table-hover');
							thead();
								tr();
									th('Group by');
									th('Jumlah','text-center','width="150"');
									th('progress','text-center','width="150"');
							tbody('result');
								tr();
									td('Silahkan filter laporan terlebih dahulu','text-left','colspan="11"');
						table_close();
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/Chart.bundle.min.js'); ?>"></script>

<script type="text/javascript">

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
</script>