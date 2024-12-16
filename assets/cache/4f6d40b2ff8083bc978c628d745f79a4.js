

var myChart;
var myChart2;
var serialize_color = [
    '#007E33',
    '#0d47a1',
    '#ffbb33',
    '#9e9e9e',
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


var serialize_color2 = [
    '#7e57c2',
    '#f44336',
    '#3F729B',
    '#9e9e9e',
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
$(document).ready(function(){
    loadData();
});
$('#pagination').on('click','a',function(e){
    e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    loadData(pageNum);
});
function loadData(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax != null ) {
        xhr_ajax.abort();
        xhr_ajax = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'laporan/dashboard/data/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
				var konten 				= '';

				var data_bar 			= [];
				var color_bar 			= [];
				var data_line			= [];
				var label_chart2 		= [];
				var i = 0;
				var n = 0;
			
				$.each(res.sub_aktivitas,function(k,v){		
					label_chart2.push(v.sub_aktivitas);
					color_bar.push(serialize_color[i]);
						$.each(res.jumlah,function(r,z){
							if(v.id==r){
								data_bar.push(z);
							}
						});	

						$.each(res.progress,function(r,z){
							if(v.id==r){
								data_line.push(z);
							}
						});	
					i++;

				});	

	    		myChart2.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar,
			            backgroundColor: color_bar,
			        }, {
			            label: 'Progress (%)',
			            data: data_line,

			            // Changes this dataset to become a line
			            type: 'line',
			        }],
					labels: label_chart2,
				};

			myChart2.update();


            $('#result tbody').html(res.data);

        }
    });

    if( xhr_ajax2 != null ) {
        xhr_ajax2.abort();
        xhr_ajax2 = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'laporan/dashboard/data2/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
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
				
				$.each(res.grup,function(k,v){		
					label_chart.push(v.grup_alias);
					color_pie.push(serialize_color2[i]);
						$.each(res.progress,function(r,z){
							if(v.id==r){
								data_pie.push(z);
							}

						});	
					i++;

				});	


	    		myChart.data = {
				datasets: [{
					data: data_pie,
					backgroundColor: color_pie,
				}],
				labels: label_chart,
			};
			myChart.update();

            $('#result2 tbody').html(res.data);
        }
    });
}




$(document).ready(function(){
	var ctxPie = document.getElementById('chart').getContext('2d');
	myChart = new Chart(ctxPie, {
		type: 'pie',
		options: {

			title: {
                display: true,
                text: 'PROGRESS (%)',
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
		type: 'bar',
		options: {
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

});
