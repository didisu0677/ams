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

		<div class="col-sm-12 col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive tab-pane fade active show" id="result">
						<div class="row mr-0 ml-0">
							<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
							<table class="table table-bordered table-app table-hover">
							<thead>
	
							<tr>	
                    			<th style="background-color: #e64a19; color: white;" rowspan="2" class="text-center align-middle"><font color="#fff">DATA GEDUNG</th>
                    			<th style="background-color: #e64a19; color: white;" rowspan="2" class="text-center align-middle"><font color="#fff">TOTAL</th>
                    			<th style="background-color: #e64a19; color: white;" colspan="2" class="text-center align-middle"><font color="#fff">STATUS KOMERSIAL</th>
                    			<th style="background-color: #e64a19; color: white;" colspan="2" class="text-center align-middle"><font color="#fff">STATUS DITAWARKAN</th>
                    			<th style="background-color: #e64a19; color: white;" colspan="2" class="text-center align-middle"><font color="#fff">STATUS DALAM PROSES</th>
                    			<th style="background-color: #e64a19; color: white;" colspan="2" class="text-center align-middle"><font color="#fff">STATUS IDLE</th>
                    		</tr>	
                    		<tr>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telkom</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telpro</th>
                  			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telkom</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telpro</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telkom</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telpro</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telkom</th>
                   			<th style="background-color: #e64a19; color: white;" colspan="" class="text-center align-middle"><font color="#fff">Asset Telpro</th>
                    		</tr>	
                    	</thead>
                  			
                    	<tbody>
                    	</tbody>	
                  			</table>					
							</div>

						</div>
					</div>
				</div>

				<div class="card">
				<div class="card-body">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for=""><?php echo lang('tampilkan_berdasarkan'); ?></label>
					<div class="col-sm-3">
						<select class="select2 infinity custom-select" id="option_chart">
							<option value=1><?php echo 'Prosentase'; ?></option>
							<option value=2><?php echo 'Jumlah'; ?></option>
						</select>
					</div>
				</div>
						
					<div class="col-sm-12">
						<div class="form-group row">	
							<div class="col-sm-6">
								<canvas id="chart"></canvas>
							</div>

							<div class="col-sm-6">
								<canvas id="chart2"></canvas>
							</div>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group row">	
							<div class="col-sm-6">
								<canvas id="chart3"></canvas>
							</div>

							<div class="col-sm-6">
								<canvas id="chart4"></canvas>
							</div>
						</div>
					</div>

				</div>


				<div class="card">
				<!--	
				<div class="card-body">
					<div class="col-sm-12">
						<div class="form-group row">	
							<div class="col-sm-12">
								<canvas id="chartbar"></canvas>
							</div>

						</div>
					</div>
				</div>
				-->
				</div>

				<div class="card">
				<div class="card-body">
					<div class="table-responsive tab-pane fade active show" id="result2">
						<div class="row mr-0 ml-0">
							<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
							<?php
								table_open('table table-bordered table-app table-hover');
									tbody('result-overall');
										tr();
											td('Tidak ada data','text-left','colspan="7"');
								table_close();
							?>							
							</div>
						</div>	
							
		

						<div class="table-responsive tab-pane fade active show" id="result2">
						<div class="row mr-0 ml-0">
							<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
							<?php
								table_open('table table-bordered table-app table-hover');
									thead();
										tr();
										


								table_close();
							?>							
							</div>

						</div>
					</div>
				</div>
				</div>

				<div class="card">
				<div class="card-header" style=" background-color: #e64a19; color: white" ;><?php echo lang('status_tanah'); ?></div>
				<div class="card-body">
					<div class="table-responsive tab-pane fade active show" id="result3">
						<div class="row mr-0 ml-0">
							<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
							<?php
								table_open('table table-bordered table-app table-hover');
									thead();
										tr();
											th('Status Tanah');
											th('Status Masa Berlaku');
											th('Nama gedung');
											th('Alamat');
											th('Kota');
											th('Mas Berlaku Surat tanah');
											th('Luas Tanah');
											th('Bentuk Tanah');
											th('P X L Tanah');
											th('Area');
											th('FM');
									tbody();
										tr();
											td('Tidak ada data','text-left','colspan="7"');
								table_close();
							?>							
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/Chart.bundle.min.js'); ?>"></script>
<script type="text/javascript">

var myChart2;
var serialize_color = [
    '#404E67',
    '#22C2DC',
    '#ff6384',
    '#ff9f40',
    '#ffcd56',
    '#4bc0c0',
    '#9966ff',
    '#36a2eb',
    '#848484',
    '#e8b892',
    '#bcefa0',
    '#4dc9f6',
    '#a0e4ef',
    '#c9cbcf',
    '#00A5A8',
    '#10C888',
    '#7d3cff',
    '#f2d53c',
    '#c80e13',
    '#e1b382',
    '#c89666',
    '#2d545e',
    '#12343b',
    '#9bc400',
    '#8076a3',
    '#f9c5bd',
    '#7c677f'
];

var xhr_ajax = null;
var xhr_ajax2 = null;
var xhr_ajax3 = null;
$(document).ready(function(){
	initchart($('#option_chart').val());
    loadData();
    loadData2();
    loadData3();
});
$('#pagination').on('click','a',function(e){
    e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    loadData(pageNum);
});
function loadData(pageNum){
	var optchart = '';
	if($('#option_chart').val()==1) {
		optchart = 'PROSENTASE %';
	}else{
		optchart = 'JUMLAH';
	}

	initchart($('#option_chart').val());
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax != null ) {
        xhr_ajax.abort();
        xhr_ajax = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'laporan/dashboard_asset/data/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
				var konten 				= '';

				var data_bar 			= [];
				var data_bar2 			= [];
				var data_bar3 			= [];
				var data_bar4 			= [];
				var data_bar5 			= [];
				var color_bar 			= [];
				var data_line			= [];
				var label_chart 		= [];
				var label_chart2 		= [];
				var label_chart3 		= [];
				var label_chart4 		= [];
				var label_chart5 		= [];
				var i = 0;
				var n = 0;
			
				$.each(res.skema_kerjasama,function(k,v){		
					label_chart.push(v.skema_kerjasama);
					color_bar.push(serialize_color[i]);

					if($('#option_chart').val() == 1) {
						$.each(res.prsn_skema,function(r,z){
							if(v.id_skema_kerjasama==r){
								data_bar.push(z);
							}
						});	
					}else {
						data_bar.push(v.jumlah);
					}
					i++;

				});	


	    		myChart.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar,
			            backgroundColor: color_bar,
			        },
			        ],
					labels: label_chart,
				};

				myChart.update();

				$.each(res.status_surat,function(x,y){		
					label_chart2.push(y.status_tanah);
					color_bar.push(serialize_color[i]);


					if($('#option_chart').val() == 1) {
						$.each(res.prsn_ssurat,function(x1,z1){
							if(y.status_tanah==x1){
								data_bar2.push(z1);
							}
						});	
					} else {
						data_bar2.push(y.jumlah);
					}
					i++;

				});	

	    		myChart2.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar2,
			            backgroundColor: color_bar,
			        },
			        ],
					labels: label_chart2,
				};

				myChart2.update();


				$.each(res.tipe_asset,function(x,y){		
					label_chart3.push(y.tipe_asset);
					color_bar.push(serialize_color[i]);
					if($('#option_chart').val() == 1) {
						$.each(res.prsn_tipe,function(x1,z1){
							if(y.id_tipe_asset==x1){
								data_bar3.push(z1);
							}
						});	
					}else {
						data_bar3.push(y.jumlah);
					}
					i++;
				});	

				myChart3.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar3,
			            backgroundColor: color_bar,
			        },
			        ],
					labels: label_chart3,
				};


				myChart3.update();

				$.each(res.jenis_asset,function(x,y){		
					label_chart4.push(y.jenis_bangunan);
					color_bar.push(serialize_color[i]);
					if($('#option_chart').val() == 1) {
						$.each(res.prsn_jenis,function(x1,z1){
							if(y.id_jenis_bangunan==x1){
								data_bar4.push(z1);
							}
						});	
					} else {
						data_bar4.push(y.jumlah);
					}
					i++;
				});	

				myChart4.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar4,
			            backgroundColor: color_bar,
			        },
			        ],
					labels: label_chart4,
				};

				myChart4.update();



            $('#result tbody').html(res.data);

        }
    });
}


function loadData2(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax2 != null ) {
        xhr_ajax2.abort();
        xhr_ajax2 = null;
    }
    xhr_ajax2 = $.ajax({
        url: base_url + 'laporan/dashboard_asset/data2/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax2 = null;
				var konten 				= '';

            $('#result2 tbody').html(res.data);

        }
    });
}

function loadData3(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax3 != null ) {
        xhr_ajax3.abort();
        xhr_ajax3 = null;
    }
    xhr_ajax2 = $.ajax({
        url: base_url + 'laporan/dashboard_asset/data3/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax2 = null;
				var konten 				= '';

            $('#result3 tbody').html(res.data);

        }
    });
}


function initchart(optchart){
	if(optchart==1) {
		optchart = 'PROSENTASE %';
	}else{
		optchart = 'JUMLAH';
	}

	var ctxPie = document.getElementById('chart').getContext('2d');
	myChart = new Chart(ctxPie, {
		type: 'pie',
		options: {
			
			title: {
                display: true,
		        text: 'SKEMA KERJA SAMA ('+optchart+')',
                fontSize: 14,
                padding: 10
            },

			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				position: 'bottom',
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

	var ctxPie2 = document.getElementById('chart2').getContext('2d');
	myChart2 = new Chart(ctxPie2, {
		type: 'pie',
		options: {
			title: {
                display: true,
                text: 'STATUS SURAT TANAH ('+optchart+')',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				position: 'bottom',
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

	var ctxPie3 = document.getElementById('chart3').getContext('2d');
	myChart3 = new Chart(ctxPie3, {
		type: 'pie',
		options: {
			title: {
                display: true,
                text: 'TIPE ASSET ('+optchart+')',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				position: 'bottom',
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

	var ctxPie4 = document.getElementById('chart4').getContext('2d');
	myChart4 = new Chart(ctxPie4, {
		type: 'pie',
		options: {
			title: {
                display: true,
                text: 'JENIS ASET ('+optchart+')',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				position: 'bottom',
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

	

	
};

$('#option_chart').change(function(){
	loadData();
});
</script>