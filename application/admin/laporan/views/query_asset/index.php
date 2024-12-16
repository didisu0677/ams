<?php include_lang('manajemen_aset'); ?>
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
						form_open(base_url('laporan/query_asset/view'),'post','form-laporan');
							col_init(12,12);
							input('text','Location','lokasi','');					
							select2('Area','id_area','required|all',$area,'id','area');
							select2('FM','id_fm','infinity|all');
							select2('Status Surat Tanah','status_tanah','infinity|all',$status_tanah,'status_tanah');
							select2(lang('tipe_asset'),'id_tipe_asset','infinity|all',$opt_tipe_asset,'id','tipe_asset');
							select2(lang('jenis_asset'),'id_jenis_bangunan','',$jenis_bangunan,'id','jenis_bangunan');

							?>
							<div class="form-group row">
								<label class="col-form-label col-sm-12"><?php echo lang('luas_bangunan'); ?></label>
							<div class="col-md-12 col-12">
								<input type="text" id="luas_bangunan" name="luas_bangunan" autocomplete="off" class="form-control" placeholder="<?php echo 'Pakai tanda (-) untuk range pencarian'; ?>" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
							</div>
							</div>

							<div class="form-group row">
								<label class="col-form-label col-sm-12"><?php echo lang('luas_tanah'); ?></label>
							<div class="col-md-12 col-12">
								<input type="text" id="luas_tanah" name="luas_tanah" autocomplete="off" class="form-control" placeholder="<?php echo 'Pakai tanda (-) untuk range pencarian'; ?>" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
							</div>
							</div> 

							<div class="form-group row">
								<label class="col-form-label col-sm-12"><?php echo lang('luas_area_idle'); ?></label>
							<div class="col-md-12 col-12">
								<input type="text" id="luas_area_idle" name="luas_area_idle" autocomplete="off" class="form-control" placeholder="<?php echo 'Pakai tanda (-) untuk range pencarian'; ?>" onkeypress='return event.charCode >= 45 && event.charCode <= 57'>
							</div>
							</div> 
							<?php
						//	input('text','Luasan Bangunan','luas_bangunan','');	
						//	input('text','Luasan Tanah','luas_tanah','');	
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
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Area</font>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">FM</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Nama gedung</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Alamat</font></th>
									<th style="background-color: #e64a19; color: white;"><font color="#fff">Kota</font></th>
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

</script>