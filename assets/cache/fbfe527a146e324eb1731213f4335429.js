
var xhr = null;
var state_popover = false;

$(document).ready(function () {
	$.fn.popover.Constructor.Default.whiteList.table = [];
    $.fn.popover.Constructor.Default.whiteList.tr = [];
    $.fn.popover.Constructor.Default.whiteList.td = [];
    $.fn.popover.Constructor.Default.whiteList.th = [];
    $.fn.popover.Constructor.Default.whiteList.div = [];
    $.fn.popover.Constructor.Default.whiteList.tbody = [];
    $.fn.popover.Constructor.Default.whiteList.thead = [];

	var url = base_url + 'manajemen_aset/finance/data/' ;
		url 	+= '/'+$('#filter_tahun').val() 
	$('[data-serverside]').attr('data-serverside',url);
	refreshData();

    $(document).on('keyup', '.calculate', function (e) {
        calculate();
    });
});

$('#filter_tahun').change(function(){
	var url = base_url + 'manajemen_aset/finance/data/' ;
		url 	+= '/'+$('#filter_tahun').val() 
	$('[data-serverside]').attr('data-serverside',url);
	
	refreshData();
});

function formOpen() {
	var response = response_edit;
	$('.dwlfile1').html('');
	$('.dwlfile2').html('');
	$('.dwlfile3').html('');
	$('.dwlfile4').html('');
	$('#id_asset').html('').trigger('change');
	if(typeof response.id != 'undefined') {
		var i = 0;

			$('#id_asset').html('<option value="'+response.id_asset+'" data-alamat="'+response.alamat+'" data-kota="'+response.kota+'" data-nomor_kontrak="'+response.nomor_kontrak_mitra_gsd+'" data-fm = "'+response.facility_management+'" data-area = "'+response.area+'" data-tanggal_komersial="'+response.tanggal_komersial+'">'+response.lokasi+'</option>').trigger('change');	

		//	alert(response.tahun);

            $('#tahun').val(response.tahun).trigger('change');

		$.each(response.detail,function(k,v){
        	var dateVar1 = v.tanggal_unbill;
        	var dateVar2 = v.tanggal_bill;
        	var dateVar3 = v.tanggal_paid;
        	if(dateVar1 != '0000-00-00' && dateVar1 != '1970-01-01'){
				var d=new Date(dateVar1);
        	}
        	if(dateVar2 != '0000-00-00' && dateVar2 != '1970-01-01'){
				var e=new Date(dateVar2);
        	}
        	if(dateVar3 != '0000-00-00' && dateVar3 != '1970-01-01'){
				var f=new Date(dateVar3);
        	}
			$('#status_finance'+v.bulan).val(v.status_finance);

			$('#revenue'+v.bulan).val(v.revenue);
			$('#beban_cogs'+v.bulan).val(v.beban_cogs);
			$('#beban_operasional'+v.bulan).val(v.beban_operasional);
			$('#biaya_perbaikan'+v.bulan).val(v.biaya_perbaikan);
			$('#piutang'+v.bulan).val(v.piutang);
			$('#tanggal_unbill'+v.bulan).val(d);
			$('#tanggal_bill'+v.bulan).val(e);
			$('#tanggal_paid'+v.bulan).val(f);
			$('#d_keterangan'+v.bulan).val(v.keterangan);


			if(v.file_laporan_keuangan.length > 0) {
				$('#file_lap_keuangan_'+v.bulan).val('AVAILABLE');
				if(v.file_laporan_keuangan) {
					var konten1 = '<div class="input-group-append"><a href ="'+base_url+'assets/uploads/finance/'+v.file_laporan_keuangan+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a></div>';
					$('#file_lap_keuangan'+v.bulan).html(konten1);
					$('#old_file_lap_'+v.bulan).val(v.file_laporan_keuangan);
				} 

			}

			if(v.file_rab.length > 0) {
				$('#file_rab_perbaikan_'+v.bulan).val('AVAILABLE');
				if(v.file_rab) {
							var konten2 = '<div class="input-group-append"><a href ="'+base_url+'assets/uploads/finance/'+v.file_rab+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a></div>';
					$('#file_rab_perbaikan'+v.bulan).val(v.file_rab);
					$('#file_rab_perbaikan'+v.bulan).html(konten2);
					$('#old_file_rab_'+v.bulan).val(v.file_rab);
				}	
			}	

			if(v.file_tagihan.length > 0) {
				$('#file_tagihan_'+v.bulan).val('AVAILABLE');
				if(v.file_tagihan) {
							var konten2 = '<div class="input-group-append"><a href ="'+base_url+'assets/uploads/finance/'+v.file_tagihan+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a></div>';
					$('#file_tagihan'+v.bulan).val(v.file_tagihan);
					$('#file_tagihan'+v.bulan).html(konten2);
					$('#old_file_tagihan_'+v.bulan).val(v.file_tagihan);
				}	
			}	

			if(v.file_bukti_transfer.length > 0) {
				$('#file_bukti_transfer_'+v.bulan).val('AVAILABLE');
				if(v.file_bukti_transfer) {
							var konten2 = '<div class="input-group-append"><a href ="'+base_url+'assets/uploads/finance/'+v.file_bukti_transfer+'" target="_blank" class="btn btn-info btn-icon-only"><i class="fa-download"></i></a></div>';
					$('#file_bukti_transfer'+v.bulan).val(v.file_bukti_transfer);
					$('#file_bukti_transfer'+v.bulan).html(konten2);
					$('#old_file_transfer_'+v.bulan).val(v.file_bukti_transfer);
				}	
			}					

			i++;

		});
		calculate();
	} 
}

$('#id_mitra').change(function(){
	$('#alamat').val('');
	$('#kota').val('');
	$('#nomor_kontrak_mitra_gsd').val('');
	$('#tanggal_komersial').val('');
	get_asset();
});

function get_asset() {
	if(proccess) {
		readonly_ajax = false;
		$.ajax({
			url : base_url + 'manajemen_aset/finance/get_asset',
			data : {id_mitra: $('#id_mitra').val()},
			type : 'POST',
			success	: function(response) {
				rs = response;
				$('#id_asset').html(response);
			}
		});
	}
}

function calculate() {
	var total_revenue = 0;
	var total_operasional = 0;
	var total_beban_cogs = 0;
	var total_biaya_perbaikan = 0;
	var total_piutang = 0;

	$('#result tbody tr').each(function(){
		if($(this).find('.revenue').length == 1) {
			var subtotal_revenue = moneyToNumber($(this).find('.revenue').val());
			total_revenue += subtotal_revenue;
		}

		if($(this).find('.beban_operasional').length == 1) {
			var subtotal_operasional = moneyToNumber($(this).find('.beban_operasional').val());
			total_operasional += subtotal_operasional;
		}

		if($(this).find('.beban_cogs').length == 1) {
			var subtotal_beban_cogs = moneyToNumber($(this).find('.beban_cogs').val());
			total_beban_cogs += subtotal_beban_cogs;
		}

		if($(this).find('.biaya_perbaikan').length == 1) {
			var subtotal_biaya_perbaikan = moneyToNumber($(this).find('.biaya_perbaikan').val());
			total_biaya_perbaikan += subtotal_biaya_perbaikan;
		}

		if($(this).find('.piutang').length == 1) {
			var subtotal_piutang = moneyToNumber($(this).find('.piutang').val());
			total_piutang += subtotal_piutang;
		}

	});


	$('#total_revenue').val(total_revenue);
	$('#total_beban_operasional').val(total_operasional);
	$('#total_beban_cogs').val(total_beban_cogs);
	$('#total_biaya_perbaikan').val(total_biaya_perbaikan);
	$('#total_piutang').val(total_piutang);


}

$('#id_mitra').change(function(){
	$('#brand').val($(this).find(':selected').attr('data-brand'));
	$('#klasifikasi').val($(this).find(':selected').attr('data-klasifikasi'));
});

$('#id_asset').change(function(){
	$('#alamat').val($(this).find(':selected').attr('data-alamat'));
	$('#kota').val($(this).find(':selected').attr('data-kota'));
	$('#area').val($(this).find(':selected').attr('data-area'));
	$('#facility_management').val($(this).find(':selected').attr('data-fm'));
	$('#nomor_kontrak_mitra_gsd').val($(this).find(':selected').attr('data-nomor_kontrak'));
	$('#tanggal_komersial').val($(this).find(':selected').attr('data-tanggal_komersial'));
});

function detail_callback(id){
	$.get(base_url+'manajemen_aset/finance/detail/'+id,function(result){
	cInfo.open(lang.detil,result);
	});
}


$(document).on('click','.export_detail',function(){


  var month = new Array();
  month[1] = "January";
  month[2] = "February";
  month[3] = "March";
  month[4] = "April";
  month[5] = "May";
  month[6] = "June";
  month[7] = "July";
  month[8] = "August";
  month[9] = "September";
  month[10] = "October";
  month[11] = "November";
  month[12] = "December";

		var page = base_url + 'manajemen_aset/finance/export_detail/' + $(this).attr('data-id');

		$.ajax({
			url 	: page,
            data        : {},
            type        : 'POST',
            dataType    : 'json',
			success	: function(response) {
				var tanggal_komersial = '';
				if(response.tanggal_komersial != '1970-01-01' && response.tanggal_komersial != '0000-00-00') {
	                tanggal_komersial = formatDate(response.tanggal_komersial);
	            }
				var table ='';
				table += '<div class="card mb-2">';
    			table += '<div class="card-header">Data Perusahaan</div>';
    			table += '<div class="card-body p-1">';
        		table += '<div class="card-body table-responsive">';
				table += '<table border="1">';
             	table += '<tr>';
                table += '<th align="left">Perusahaan</th>';
                table += '<td colspan="3">'+response.perusahaan+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Lokasi_gedung</th>';
                table += '<td colspan="3">'+response.nama_gedung+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Alamat</th>';
                table += '<td colspan="3">'+response.alamat+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Kota</th>';
                table += '<td colspan="3">'+response.kota+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Klasifikasi</th>';
                table += '<td colspan="3">'+response.klasifikasi+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Nomor Kontrak Mmitra-GSD</th>';
                table += '<td colspan="3">'+response.nomor_kontrak_mitra_gsd+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Tanggal Komersial</th>';
                table += '<td align="left" colspan="3">'+tanggal_komersial+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Keterangan</th>';
                table += '<td colspan="3">'+response.keterangan+'</td>';
                table += '</tr>';
                table += '<tr>';
                table += '<th align="left">Tahun</th>';
                table += '<td align ="left" colspan="3">'+response.tahun+'</td>';
                table += '</tr>';
				table += '</table>';
				table += '</div>';
    			table += '</div>';
				table += '</div>';
				table += '<table border="1">';
        		table += '<thead>'; 
            	table += '<tr>';
                table += '<th>BULAN</th>';
                table += '<th>REVENUE</th>';
                table += '<th>BEBAN COGS</th>';
                table += '<th>BEBAN OPERASIONAL</th>';
                table += '<th>BIAYA PERBAIKAN</th>';
                table += '<th>PIUTANG</th>';
                table += '<th>TANGGAL UNBILL</th>';
                table += '<th>TANGGAL BILL</th>';
                table += '<th>TANGGAL PAID</th>';
                table += '<th>STATUS TERAKHIR</th>';
                table += '<th>STATUS FINANCE</th>';
            	table += '</tr>';
        		table += '</thead>';

            	var trevenue =0;
                var tcogs = 0;
                var toperasional = 0;
                var tperbaikan = 0;
                var tpiutang = 0;
                var tpunbill = 0;
                var tpbill = 0;
                var tppaid = 0;

        		$.each(response.detail,function(k,v){
        		var tanggal_unbill = '';
            	var tanggal_bill = '';
            	var tanggal_paid = '';
            	var status_finance ='';
            	var last_status ='';

            	
	            if(v.tanggal_unbill != '1970-01-01' && v.tanggal_unbill != '0000-00-00') {
	                tanggal_unbill = formatDate(v.tanggal_unbill);
	            } 
	            if(v.tanggal_bill != '1970-01-01' && v.tanggal_bill != '0000-00-00') {
	                tanggal_bill = formatDate(v.tanggal_bill);
	            }
	            if(v.tanggal_paid != '1970-01-01' && v.tanggal_paid != '0000-00-00') {
	                tanggal_paid = formatDate(v.tanggal_paid);
	            }

            	trevenue = v.trevenue;
                tcogs = v.tcogs;
                toperasional = v.toperasional;
                tperbaikan = v.tperbaikan;
                tpiutang = v.tpiutang;
                tpunbill = v.punbill;
                tpbill = v.pbill
                tppaid = v.ppaid

	            	if(v.revenue > 0 || v.piutang > 0) {
		                if(v.status_finance == 1) {
		                    status_finance = 'Real';
		                }else{
		                    status_finance = 'Accrue';
		                }
	                	last_status = v.status_bill; 
			        }else{
			            status_finance = '';
			            last_status = '';                 
			        }

        			table += '<tr>';
	                table += '<th align="left">'+month[v.bulan]+'</th>';
	                table += '<td>'+v.revenue+'</td>';
	                table += '<td>'+v.beban_cogs+'</td>';
	                table += '<td>'+v.beban_operasional+'</td>';
	                table += '<td>'+v.biaya_perbaikan+'</td>';
	                table += '<td>'+v.piutang+'</td>';
	                table += '<td>'+tanggal_unbill+'</td>';
	                table += '<td>'+tanggal_bill+'</td>';
	                table += '<td>'+tanggal_paid+'</td>';
	                table += '<td>'+last_status+'</td>';
	                table += '<td>'+status_finance+'</td>';
            		table += '</tr>';
				});




               	table += '<tr>';
               	table += '<th>TOTAL</th>';
               	table += '<td>'+trevenue+'</td>';
                table += '<td>'+tcogs+'</td>';
                table += '<td>'+toperasional+'</td>';
                table += '<td>'+tperbaikan+'</td>';
                table += '<td>'+tpiutang+'</td>';
                table += '<td>'+tpunbill+'</td>';
                table += '<td>'+tpbill+'</td>';
                table += '<td>'+tppaid+'</td>';
               	table += '<td></td>';
            	table += '</tr>';  
				var target = table;
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(target));
			}
		});
	});

function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [day, month, year].join('-');
 }


$(document).on('click','[data-serverside] tbody tr .pointer',function(){
	var e = $(this);
	var id = $(this).closest('tr').children('[data-rowid]').attr('data-rowid');
	$('.have-popover').popover('hide');
	if(e.hasClass('have-popover')) {
		setTimeout(function(){
			e.popover('show');
		},50);
	} else {
		if(xhr != null) xhr.abort();
		xhr = $.get(base_url + 'manajemen_aset/finance/revenue/' + id, function(r){
			xhr = null;
			e.addClass('have-popover');
			e.popover({
				title: lang.revenue,
				html: true,
				content: r,
				placement: 'left'
			}).popover('show');
		});
	}
});
$(document).on('mouseleave','[data-serverside] tbody tr .pointer',function(){
	var e = $(this);
	setTimeout(function(){
		if(!state_popover) {
			e.popover('hide');
		}
	},50);
});
$(document).on('mouseenter','.popover',function(){
	state_popover = true;
});
$(document).on('mouseleave','.popover',function(){
	state_popover = false;
	$('.have-popover').popover('hide');
});
$('.modal').on('shown.bs.modal', function() {
	$('.have-popover').popover('hide');
});

