

var xhr_ajax = null;
var xhr_ajax2 = null;
var xhr_ajax3 = null;
var xhr_ajax4 = null;
var xhr_ajax5 = null;

var myChart;
var myChart6;
var myChart7;
var myChart8;
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
$(document).ready(function(){
	initchart();
	loadData();
	loadData2();
	loadData3();
	loadData4();
	loadData5();
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


    var page = base_url + 'laporan/dashboard_finance/data/'+pageNum;
    page += '/'+ $('#tahun').val();


    xhr_ajax = $.ajax({
        url: page,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;

            $('#result tbody').html(res.data);				

        		var data_bar 			= [];
				var label_chart 		= [];
				var color_bar 			= [];
				var i = 0;
				
				$.each(res.portfolio,function(k,v){		
					label_chart.push(v.portfolio);
					color_bar.push(serialize_color[i]);
					$.each(res.prsn_portfolio,function(r,z){
						if(v.portfolio==r){
							data_bar.push(z);
						}
					});	

					i++;


				});	

	    		myChart.data = {
			        datasets: [{
			            label: 'Jumlah',
			            data: data_bar,
			            backgroundColor: ['#0099CC','#FF8800'],
			        },
			        ],
					labels: label_chart,
				};

				myChart.update();

				var data_ubis = [];
				var data_non_ubis = [];
				var label_chart5 		= [];

				$.each(res.area,function(x,y){		
					label_chart5.push(y);
					$.each(res.ubis,function(x1,z1){
						if(x==x1){
							data_ubis.push(z1);
						}	
					});	
					$.each(res.non_ubis,function(x2,z2){
						if(x==x2){
							data_non_ubis.push(z2);
						}	
					});	
				
				});	

				myChart5.data = {
					datasets: [
			        {
			          label: "Ubis",
			          type: "bar",
					  backgroundColor: "#0288d1",
					  data: data_ubis,

			        }, 
			        {
			          label: "Non Ubis",
			          type: "bar",
					  backgroundColor: "#ef6c00",
					  data: data_non_ubis,
			        }, 
			      ],


			      labels: label_chart5,
				};
				

			myChart5.update();

				var data_ubis2 = [];
				var data_non_ubis2 = [];
				var label_chart6 		= [];
	
				$.each(res.area2,function(x,y){	
	
					label_chart6.push(y);
					$.each(res.ubis2,function(x1,z1){
						if(x==x1){
							data_ubis2.push(z1);
						}	
					});	
					$.each(res.non_ubis2,function(x2,z2){
						if(x==x2){
							data_non_ubis2.push(z2);
						}	
					});	
				
				});	

	

				myChart6.data = {
					datasets: [
			        {
			          label: "Ubis",
			          type: "bar",
					  backgroundColor: "#0288d1",
					  data: data_ubis2,

			        }, 
			        {
			          label: "Non Ubis",
			          type: "bar",
					  backgroundColor: "#ef6c00",
					  data: data_non_ubis2,
			        }, 
			      ],


			      labels: label_chart6,
				};
				

			myChart6.update();

				var data_ubis3 = [];
				var label_chart7 		= [];

				$.each(res.brand,function(x,y){		
					label_chart7.push(x);
					data_ubis3.push(y)
				
				});	

				myChart7.data = {
					datasets: [
			        {
			          label: "Revenue",
			          type: "bar",
					  backgroundColor: "#0288d1",
					  data: data_ubis3,

			        }, 
			      ],


			      labels: label_chart7,
				};
				

			myChart7.update();


				var data_x = [];
				var label_x = [];

				$.each(res.brand_rev,function(x,y){		
					label_x.push(x);
					data_x.push(y)
				
				});	

				myChart9.data = {
					datasets: [
			        {
			          label: "Brand",
			          type: "bar",
					  backgroundColor: "#0288d1",
					  data: data_x,

			        }, 
			      ],

			      labels: label_x,
				};
				

			myChart9.update();

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

    var page = base_url + 'laporan/dashboard_finance/data2/'+pageNum;
    page += '/'+ $('#tahun').val();
    page += '/'+ $('#portfolio').val();
  	xhr_ajax2 = $.ajax({
        url: page,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax2 = null;
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

    var page = base_url + 'laporan/dashboard_finance/data3/'+pageNum;
//    page += '/'+ $('#tahun').val();
    page += '/'+ $('#portfolio').val();
  	xhr_ajax3 = $.ajax({
        url: page,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax3 = null;
            $('#result3 tbody').html(res.data);				
        }
    });
}

function loadData4(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }

    if( xhr_ajax4 != null ) {
        xhr_ajax4.abort();
        xhr_ajax4 = null;
    }

    var page = base_url + 'laporan/dashboard_finance/data4/'+pageNum;
//    page += '/'+ $('#tahun').val();
    page += '/'+ $('#portfolio').val();
  	xhr_ajax4 = $.ajax({
        url: page,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax4 = null;
            $('#result4 tbody').html(res.data);				
        }
    });
}

function loadData5(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }

    if( xhr_ajax5 != null ) {
        xhr_ajax5.abort();
        xhr_ajax5 = null;
    }

    var page = base_url + 'laporan/dashboard_finance/data5/'+pageNum;
//    page += '/'+ $('#tahun').val();
    page += '/'+ $('#portfolio').val();
  	xhr_ajax5 = $.ajax({
        url: page,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax5 = null;
            $('#result5 tbody').html(res.data);			


            	var data_ubis = [];
				var data_non_ubis = [];
				var label_chart8 		= [];

				$.each(res.brand,function(m,n){		
					label_chart8.push(n);
					$.each(res.ubis,function(x5,z1){
						if(m==x5){
							data_ubis.push(z1);
						}	
					});	
					$.each(res.non_ubis,function(x6,z2){
						if(m==x6){
							data_non_ubis.push(z2);
						}	
					});	
				
				});	

				myChart8.data = {
					datasets: [
			        {
			          label: "Ubis",
			          type: "bar",
					  backgroundColor: "#0288d1",
					  data: data_ubis,

			        }, 
			        {
			          label: "Non Ubis",
			          type: "bar",
					  backgroundColor: "#ef6c00",
					  data: data_non_ubis,
			        }, 
			      ],


			      labels: label_chart8,
				};
				

			myChart8.update();
	
        }
    });
}

$('#tahun').change(function(){
	initchart();
	loadData();
	loadData2();
	loadData3();
	loadData4();
	loadData5();
});

function initchart(){

	var ctxPie = document.getElementById('chart').getContext('2d');
	myChart = new Chart(ctxPie, {
		type: 'pie',
		options: {
			title: {
                display: true,
		        text: 'REVENUE PORTFOLIO (%)',
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

	var ctxBar = document.getElementById('chartbar').getContext('2d');
	myChart5 = new Chart(ctxBar, {
		type: 'bar',
		options: {
		"hover": {
            "animationDuration": 0
        },
          "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {

                    	if(dataset.data[index] != 0){
                        	var data = numberFormat(dataset.data[index]/1e6,0); 
                    	}else{
                    		var data = '';
                    	}                              
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false
        },

			title: {
                display: true,
                text: 'SEBARAN REVENUE AREA - JUTA (Rp)',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
		    scales: {
		      xAxes: [{
			      beginAtZero: true,
			      ticks: {
			         autoSkip: false
			      }
			  }],
	            yAxes: [{
	                    display: true,
	                    scaleLabel: {
	                        display: true,
	                        labelString: 'Juta (Rp)'
	                    },
	                    ticks: {
                    	// Abbreviate the millions
                    		callback: function(value, index, values) {
                        	return numberFormat(value / 1e6,0);
                    		}
                		}
	                }],
	        },
			legend: {
				display: true,
				position: 'bottom',
					labels: {
					boxWidth: 15,
				}
			}
		}
	});


	var ctxBar2 = document.getElementById('chartbar2').getContext('2d');
	myChart6 = new Chart(ctxBar2, {
		type: 'bar',
		options: {
        "hover": {
            "animationDuration": 0
        },
          "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index];                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false
        },

			title: {
                display: true,
                text: 'SEBARAN JUMLAH GERAI AREA',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
		    scales: {
		      xAxes: [{
			      beginAtZero: true,
			      ticks: {
			         autoSkip: false
			      }
			  }],
	            yAxes: [{
	                    display: true,
	                    scaleLabel: {
	                        display: true,
	                        labelString: 'Jumlah'
	                    },
	                   	ticks: {
	                   	autoSkip: false,	
			            min: 0,
			            stepSize: 5
			        },
	                }],
	        },
			legend: {
				display: true,
				position: 'bottom',
					labels: {
					boxWidth: 15,
				}
			}
		}
	});

	var ctxBar3 = document.getElementById('chartbar3').getContext('2d');
	myChart7 = new Chart(ctxBar3, {
		type: 'bar',
		options: {
        "hover": {
            "animationDuration": 0
        },
          "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = numberFormat(dataset.data[index]/1e6,0);                           
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false
        },
			title: {
                display: true,
                text: 'SEBARAN REVENUE BRAND - JUTA (Rp)',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
		    scales: {
			  xAxes: [{
			      beginAtZero: true,
			      ticks: {
			         autoSkip: false
			      }
			  }],
	            yAxes: [{
	                    display: true,
	                    scaleLabel: {
	                        display: true,
	                        labelString: 'Juta (Rp)'
	                    },
	                   	ticks: {
                    	// Abbreviate the millions
                    		autoSkip: false,
                    		callback: function(value, index, values) {
                        	return numberFormat(value / 1e6,0);
                    		}
                		}
	                }],
	        },
			legend: {
				display: true,
				position: 'bottom',
					labels: {
					boxWidth: 15,
				}
			}
		}
	});
	

	var ctxBar5 = document.getElementById('chartbar5').getContext('2d');
	myChart9 = new Chart(ctxBar5, {
		type: 'bar',
		options: {
        "hover": {
            "animationDuration": 0
        },
          "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = numberFormat(dataset.data[index],0);                           
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false
        },
			title: {
                display: true,
                text: 'SEBARAN JUMLAH GERAI BRAND',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
		    scales: {
			  xAxes: [{
			      beginAtZero: true,
			      ticks: {
			         autoSkip: false
			      }
			  }],
	            yAxes: [{
	                    display: true,
	                    scaleLabel: {
	                        display: true,
	                        labelString: 'Jumlah'
	                    },
	                   	ticks: {
                    	// Abbreviate the millions
                    		autoSkip: false,
                		}
	                }],
	        },
			legend: {
				display: true,
				position: 'bottom',
					labels: {
					boxWidth: 15,
				}
			}
		}
	});

	var ctxBar4 = document.getElementById('chartbar4').getContext('2d');
	myChart8 = new Chart(ctxBar4, {
		type: 'bar',
		options: {
        "hover": {
            "animationDuration": 0
        },
          "hover": {
            "animationDuration": 0
        },
        "animation": {
            "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                    	if(dataset.data[index] !=0){
                        	var data = numberFormat(dataset.data[index]/1e6,0);                           
                        }else{
                        	var data = '';
                        }
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        },
        legend: {
            "display": false
        },
        tooltips: {
            "enabled": false,
              callbacks: {
                label: function(tooltipItem, chart){
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + numberFormat(tooltipItem.yLabel, 2);
                }
            }
        },

			title: {
                display: true,
                text: 'PIUTANG RETAIL- JUTA (Rp)',
                fontSize: 14,
                padding: 10
            },
			maintainAspectRatio: false,
			responsive: true,
		    scales: {
			  xAxes: [{
			      beginAtZero: true,
			      ticks: {
			         autoSkip: false
			      }
			  }],
	            yAxes: [{
	                    display: true,
	                    scaleLabel: {
	                        display: true,
	                        labelString: 'Juta (Rp)'
	                    },
	                   	ticks: {
                    	// Abbreviate the millions
                    		autoSkip: false,
                    		callback: function(value, index, values) {
                        	return numberFormat(value / 1e6,0);
                    		}
                		}
	                }],
	        },
			legend: {
				display: true,
				position: 'bottom',
					labels: {
					boxWidth: 15,
				}
			}
		},
	});
};

$('#portfolio').change(function(){
	loadData2();
	loadData3();
	loadData4();
	loadData5();
});
