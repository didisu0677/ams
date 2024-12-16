<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">

			<label class=""><?php echo lang('tahun_transaksi'); ?>  &nbsp</label>
			<select class="select2 infinity custom-select" id="filter_tahun">
				<option value="">Tampilkan semua</option>
				<?php for($i = date('Y') - 3 ; $i <= date('Y')+5; $i++){ ?>
                <option value="<?php echo $i .str_repeat('&nbsp;', 25); ?>"<?php if($i == date('Y')) echo ' selected'; ?>><?php echo $i .str_repeat('&nbsp;', 25); ?></option>
                <?php } ?>
			</select>

			<?php echo access_button('delete,export'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('manajemen_aset/finance/data'),'tbl_m_finance');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('tahun'),'','data-content="tahun"');
				th(lang('perusahaan'),'','data-content="perusahaan" data-table="tbl_m_mitra tbl_perusahaan" ');
				th(lang('brand'),'','data-content="brand"');
				th(lang('lokasi_gedung'),'','data-content="nama_gedung" data-table="tbl_asset"');
				th(lang('nomor_kontrak_mitra_gsd'),'','data-content="nomor_kontrak_mitra_gsd"');
				th(lang('tanggal_komersial'),'','data-content="tanggal_komersial" data-type="daterange"');
				th(lang('revenue'),'text-right','data-content="revenue" data-type="currency"');
				th(lang('biaya_perbaikan'),'text-right','data-content="biaya_perbaikan" data-type="currency"');
				th(lang('piutang'),'text-right','data-content="piutang" data-type="currency"');
				th(lang('piutang_unbill'),'text-right','data-content="piutang_unbill" data-type="currency"');
				th(lang('piutang_bill'),'text-right','data-content="piutang_bill" data-type="currency"');
				th(lang('piutang_paid'),'text-right','data-content="piutang_paid" data-type="currency"');
				//th(lang('portfolio'),'','data-content="portfolio" data-replace="1:Ubis|2:Non Ubis"');
				th(lang('status'),'','data-content="status_accrue" data-replace="1:Real|2:Accrue|0:""');
				th(lang('keterangan'),'','data-content="keterangan"');			
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-xl','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('manajemen_aset/finance/save'),'post','form'); ?>
			<ul class="nav nav-tabs" id="tab-wizard" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true"><?php echo lang('informasi_finance'); ?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="off"><?php echo lang('upload_file'); ?></a>
				</li>

			</ul>
		<div class="tab-content" id="tab-wizardContent">
			<div class="tab-pane show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
			<br>	
			<?php

			col_init(3,9);
			input('hidden','id','id');
			input('hidden',lang('nomor'),'nomor');
			?>
			
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="perusahaan"><?php echo lang('perusahaan'); ?></label>
				<div class="col-sm-9">
					<select name="id_mitra" id="id_mitra" class="form-control select2" data-validation="required">
						<option value=""></option>
						<?php foreach ($opt_mitra as $ma){ ?>
							<option value="<?php echo $ma['id'] ?>" data-brand="<?php echo $ma['brand'] ?>" data-klasifikasi="<?php echo $ma['klasifikasi'] ?>"><?php echo $ma['perusahaan']; ?></option>
						<?php } ?>

					</select>
				</div>
			</div>

			<?php
			input('text',lang('brand'),'brand','','','readonly');
			input('text',lang('klasifikasi'),'klasifikasi','','','readonly');
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="lokasi"><?php echo lang('lokasi'); ?></label>
				<div class="col-sm-9">
					<select name="id_asset" id="id_asset" class="form-control select2" data-validation="required">
					</select>
				</div>
			</div>
			<?php
			input('text',lang('alamat'),'alamat','','','readonly');
			input('text',lang('kota'),'kota','','','readonly');
			input('text',lang('nomor_kontrak_mitra_gsd'),'nomor_kontrak_mitra_gsd','','','readonly');
			input('text',lang('tanggal_komersial'),'tanggal_komersial','','','readonly');
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="portfolio"><?php echo lang('portfolio'); ?></label>
				<div class="col-sm-9">
					<select class="select2 infinity custom-select" id="portfolio" name="portfolio">
						<option value="0"></option>
						<option value="1">Ubis</option>
						<option value="2">Non Ubis</option>
					</select>
				</div>
			</div>	
			<?php
			input('area',lang('area'),'area','','','readonly');
			input('fm',lang('fm'),'facility_management','','','readonly');
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="tahun"><?php echo lang('tahun'); ?></label>
				<div class="col-sm-9">
					<select name ="tahun" id="tahun" class="form-control select2">
						<option value=""></option>
						<?php for($i = date('Y') - 1; $i <= date('Y')+5; $i++){ ?>
		                 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		                <?php } ?>
					</select>
				</div>	
			</div>

			<?php
			col_init(0,12);
			?>

			<div id="result" class="card-body table-responsive mb-2">
				<table class="table table-bordered table-app table-detail table-normal">
					<thead>
						<tr>
							<th><?php echo lang('bulan'); ?></th>
							<th><?php echo lang('revenue') . str_repeat('&nbsp;', 20) ; ?></th>
							<th><?php echo lang('beban_cogs') . str_repeat('&nbsp;', 20); ?></th>
							<th><?php echo lang('beban_operasional'); ?></th>
							<th><?php echo lang('biaya_perbaikan') . str_repeat('&nbsp;', 10); ?></th>
							<th><?php echo lang('status_finance') . str_repeat('&nbsp;', 10); ?></th>
							<th><?php echo lang('piutang') . str_repeat('&nbsp;', 20); ?></th>
							<th><?php echo lang('tanggal_unbill'); ?></th>
							<th><?php echo lang('tanggal_bill') . str_repeat('&nbsp;', 5); ?></th>
							<th><?php echo lang('tanggal_paid') . str_repeat('&nbsp;', 5); ?></th>
		
						</tr>
					</thead>
					<tbody id="d2">
						<?php 	for ($i = 1; $i <= 12; $i++) { ?>
						<tr>
							<th><?php echo month_lang($i); ?></th>
							<td>
								<input type="money" class="form-control text-right money revenue calculate" autocomplete="off" id="<?php echo 'revenue'. $i; ?>" name="revenue[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="money" class="form-control text-right money beban_cogs calculate" autocomplete="off" id="<?php echo 'beban_cogs'. $i; ?>" name="beban_cogs[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="money" class="form-control text-right money beban_operasional calculate" autocomplete="off" id="<?php echo 'beban_operasional'. $i; ?>" name="beban_operasional[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="money" class="form-control text-right money biaya_perbaikan calculate" autocomplete="off" id="<?php echo 'biaya_perbaikan'. $i; ?>" name="biaya_perbaikan[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<select class="select infinity custom-select" id="<?php echo 'status_finance'. $i; ?>" name="status_finance[<?php echo $i; ?>]">
									<option value="1">Real</option>
									<option value="2">Accrue</option>
								</select>
							</td>	
							<td>
								<input type="money" class="form-control text-right money piutang calculate" autocomplete="off" id="<?php echo 'piutang'. $i; ?>" name="piutang[<?php echo $i; ?>]" value="" />
							</td>
							
							<td><input type="text" class="form-control dp" autocomplete="off" id="<?php echo 'tanggal_unbill'. $i; ?>" name="tanggal_unbill[<?php echo $i; ?>]" value="" /></td>
							
							<td><input type="text" class="form-control dp" autocomplete="off" id="<?php echo 'tanggal_bill'. $i; ?>" name="tanggal_bill[<?php echo $i; ?>]" value="" /></td>
							
							<td><input type="text" class="form-control dp" autocomplete="off" id="<?php echo 'tanggal_paid'. $i; ?>" name="tanggal_paid[<?php echo $i; ?>]" value="" /></td>


						</tr>
						<?php } ?>
						<tr>
							<th>TOTAL</th>
							<td>
								<input type="money" class="form-control text-right money" autocomplete="off" id="total_revenue" name="total_revenue" value="" data-readonly="true"/>
							</td>
							<td>
								<input type="money" class="form-control text-right money" autocomplete="off" id="total_beban_cogs" name="total_beban_cogs" value="" data-readonly="true"/>
							</td>
							<td>
								<input type="money" class="form-control text-right money" autocomplete="off" id="total_beban_operasional" name="total_beban_operasional" value="" data-readonly="true"/>
							</td>
							<td>
								<input type="money" class="form-control text-right money" autocomplete="off" id="total_biaya_perbaikan" name="total_biaya_perbaikan" value="" data-readonly="true"/>
							</td>
							<td>
							</td>	
							<td>
								<input type="money" class="form-control text-right money" autocomplete="off" id="total_piutang" name="total_piutang" value="" data-readonly="true"/>
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<br>
				<?php

				col_init(3,9);
				input('text',lang('keterangan'),'keterangan');
				toggle(lang('aktif').'?','is_active');
				?>
				<!--
				<div class="form-group row">
					<div class="col-sm-9 offset-sm-3">
						<button type="reset" class="btn btn-secondary"><?php //echo lang('batal'); ?></button>
						<button type="button" class="btn btn-success btn-next" data-target="step2"><?php //echo lang('selanjutnya'); ?></button>
					</div>
				</div>
			-->
			</div>

		<div class="tab-pane" id="step2" role="tabpanel" aria-labelledby="step2-tab">

			<div class="table-responsive mb-2">
							<br>	
				<table class="table table-bordered table-app table-detail">
					<thead>
						<tr>
							<th><?php echo lang('bulan'); ?></th>
							<th><?php echo lang('upload_laporan_keuangan'); ?></th>
							<th><?php echo lang('upload_rab_perbaikan'); ?></th>
							<th><?php echo lang('upload_tagihan') . str_repeat('&nbsp;', 5) ; ?></th>
							<th><?php echo lang('upload_bukti_transfer'); ?></th>
							<th><?php echo lang('keterangan') . str_repeat('&nbsp;', 50); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 1; $i <= 12; $i++) { ?>
						<tr>
						<th><?php echo month_lang($i); ?></th>
						<td>
							
							<input type="hidden" name="id_lap[<?php echo $i; ?>]" value="<?php echo $i; ?>">
							<input type="hidden" name="old_file_lap[<?php echo $i; ?>]" id = "old_file_lap_<?php echo $i; ?>" value="">

							<div class="input-group">
								<input type="text" name="file_lap_keuangan[<?php echo $i; ?>]" id="file_lap_keuangan_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="xlsx|docx|xls|doc|pdf|jpg|jpeg|png|bmp">

								<div class="input-group-append">
									<div id="<?php echo 'file_lap_keuangan'. $i; ?>" class ="text-center dwlfile1"></div>
								</div>
							</div>
						</td>
						<td>
							<input type="hidden" name="id_rab[<?php echo $i; ?>]" value="<?php echo $i; ?>">
							<input type="hidden" name="old_file_rab[<?php echo $i; ?>]" id = "old_file_rab_<?php echo $i; ?>" value="">

							<div class="input-group">
								<input type="text" name="file_rab_perbaikan[<?php echo $i; ?>]" id="file_rab_perbaikan_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="xlsx|docx|xls|doc|pdf|jpg|jpeg|png|bmp">

								<div class="input-group-append">
									<div id="<?php echo 'file_rab_perbaikan'. $i; ?>" class ="text-center dwlfile2"></div>
									</div>
								</div>
							</td>
							<td>
								<input type="hidden" name="id_tagihan[<?php echo $i; ?>]" value="<?php echo $i; ?>">
								<input type="hidden" name="old_file_tagihan[<?php echo $i; ?>]" id = "old_file_tagihan_<?php echo $i; ?>" value="">

								<div class="input-group">
									<input type="text" name="file_tagihan[<?php echo $i; ?>]" id="file_tagihan_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="xlsx|docx|xls|doc|pdf|jpg|jpeg|png|bmp">

									<div class="input-group-append">
										<div id="<?php echo 'file_tagihan'. $i; ?>" class ="text-center dwlfile3"></div>
									</div>
								</div>
							</td>
							<td>
								<input type="hidden" name="id_transfer[<?php echo $i; ?>]" value="<?php echo $i; ?>">
								<input type="hidden" name="old_file_transfer[<?php echo $i; ?>]" id = "old_file_transfer_<?php echo $i; ?>" value="">

								<div class="input-group">
									<input type="text" name="file_bukti_transfer[<?php echo $i; ?>]" id="file_bukti_transfer_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="xlsx|docx|xls|doc|pdf|jpg|jpeg|png|bmp">

									<div class="input-group-append">
										<div id="<?php echo 'file_bukti_transfer'. $i; ?>" class ="text-center dwlfile4"></div>
									</div>
								</div>
							</td>
							<td>
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'd_keterangan'. $i; ?>" name="d_keterangan[<?php echo $i; ?>]" value="" />
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>


		</div>

	</div>		
	<br>

	<!--
				<div class="form-group row">
					<div class="col-sm-9 offset-sm-3">

						<button type="button" class="btn btn-danger btn-prev" data-target="step1"><?php //echo lang('sebelumnya'); ?></button>

						<button type="reset" class="btn btn-secondary"><?php //echo lang('batal'); ?></button>
						<button type="submit" class="btn btn-success"><?php //echo lang('simpan'); ?></button>
					</div>
				</div>
	-->
	<?php

				form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close(); ?>

<form action="<?php echo base_url('upload/file/datetime'); ?>" class="hidden">
	<input type="hidden" name="name" value="field_document">
	<input type="hidden" name="token" value="<?php echo encode_id([user('id'),(time() + 900)]); ?>">
	<input type="file" name="document" id="upl-file">
</form>

<script type="text/javascript">
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

</script>
