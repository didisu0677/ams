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
						form_open(base_url('laporan/query_piutang/view'),'post','form-laporan');
							col_init(12,12);
														?>
							<div class="form-group row">
								<label class="col-sm-12 col-form-label" for=""><?php echo lang('status'); ?></label>
								<div class="col-sm-12">
									<select class="select2 infinity custom-select" id="status" name="status">
										<option value="all">All</option>
										<option value="Bill">Billed</option>
										<option value="Unbill">Unbill</option>
									</select>
								</div>
							</div>
							<?php
							input('daterange','Periode Tanggal Piutang','periode','');
							?>
							<div class="form-group row">
								<label class="col-sm-12 col-form-label" for=""><?php echo lang('portfolio'); ?></label>
								<div class="col-sm-12">
									<select class="select2 infinity custom-select" id="portfolio" name="portfolio">
										<option value="0">All</option>
										<option value="1">Ubis</option>
										<option value="2">Non Ubis</option>
									</select>
								</div>
							</div>
							<?php
							select2('Brand','brand','required|infinity|all',$brand,'id','brand');
							select2('Area','id_area','required|all',$area,'id','area');
							select2('FM','id_fm','infinity|all');
							select2('Nama Gedung','id_asset','infinity');
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
				<div class="card-body ">
					<div class="table-responsive" id="detail">
					<?php
						table_open('table table-bordered table-detail table-grid table mb-0');
							thead();
								tr();
							?>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">No</font>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Portfolio</font>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Brand</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Nama gedung</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Alamat</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Kota</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">FM</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Area</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Nilai Piutang</font></th>
							<?php				
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

</script>