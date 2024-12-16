

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
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax != null ) {
        xhr_ajax.abort();
        xhr_ajax = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'laporan/dashboard_kontrak/data/'+pageNum,
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
			
				$.each(res.skema_kerjasama,function(k,v){		
					label_chart2.push(v.skema_kerjasama);
					color_bar.push(serialize_color[i]);
					data_bar.push(v.jumlah);
					i++;

				});	

	    		myChart2.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar,
			            backgroundColor: color_bar,
			        },
			        ],
					labels: label_chart2,
				};

			myChart2.update();


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
        url: base_url + 'laporan/dashboard_kontrak/data2/'+pageNum,
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
        url: base_url + 'laporan/dashboard_kontrak/data3/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax3 = null;
				var konten 				= '';

            $('#result3 tbody').html(res.data);

        }
    });
}


$(document).ready(function(){

	var ctxPie2 = document.getElementById('chart2').getContext('2d');
	myChart2 = new Chart(ctxPie2, {
		type: 'horizontalBar',
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
