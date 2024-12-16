<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('manajemen_aset/aktivitas/data'),'tbl_m_aktivitas');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('facility_management'),'','data-content="facility_management" data-table ="tbl_m_facility_management tbl_fm"');
				th(lang('nama_gedung'),'','data-content="nama_gedung"');
				th(lang('alamat'),'','data-content="alamat"');
				th(lang('kota'),'','data-content="kota"');
				th(lang('brand'),'','data-content="brand"');
				th(lang('klasifikasi'),'','data-content="klasifikasi"');
				th(lang('perusahaan'),'','data-content="perusahaan"');
				th(lang('penanggung_jawab_mitra'),'','data-content="penanggung_jawab_mitra"');
				th(lang('pembuatan_propar'),'','data-content="pembuatan_propar" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('penawaran_mitra'),'','data-content="penawaran_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('approval_manajemen'),'','data-content="approval_manajemen" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pembuatan_aki'),'','data-content="pembuatan_aki" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('kesepakatan_gsd_mitra'),'','data-content="kesepakatan_gsd_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('bak_gsd_mitra'),'','data-content="bak_gsd_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pks_gsd_mitra'),'','data-content="pks_gsd_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('juskeb_konsultan'),'','data-content="juskeb_konsultan" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pengadaan_konsultan'),'','data-content="pengadaan_konsultan" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('desain_dan_rab'),'','data-content="desain_dan_rab" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('perizinan'),'','data-content="perizinan" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('juskeb_kontraktor'),'','data-content="juskeb_kontraktor" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pengadaan_kontraktor'),'','data-content="pengadaan_kontraktor"data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('konstruksi_dan_fo'),'','data-content="konstruksi_dan_fo" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('bast_lahan_mitra'),'','data-content="bast_lahan_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('baso_gsd_telkom'),'','data-content="baso_gsd_telkom" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('sertifikat'),'','data-content="sertifikat" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('ba_acceptance'),'','data-content="ba_acceptance" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('relokasi'),'','data-content="relokasi" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('owner_estimate'),'','data-content="owner_estimate" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('kesepakatan_telkom_gsd'),'','data-content="kesepakatan_telkom_gsd" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('justifikasi_inisiatif_bisnis'),'','data-content="justifikasi_inisiatif_bisnis" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('bak_telkom_gsd'),'','data-content="bak_telkom_gsd" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pks_telkom_gsd'),'','data-content="pks_telkom_gsd" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('approval_demolish'),'','data-content="approval_demolish" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('pelaksanaan_demolish'),'','data-content="pelaksanaan_demolish" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('surat_pernyataan_bersama'),'','data-content="surat_pernyataan_bersama" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('bast_lahan_gsd'),'','data-content="bast_lahan_gsd" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('assesment_lokasi'),'','data-content="assesment_lokasi" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('letter_of_interest'),'','data-content="letter_of_interest" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('business_plan_mitra'),'','data-content="business_plan_mitra" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('prelim_budget_est'),'','data-content="prelim_budget_est" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('approval_desain'),'','data-content="approval_desain" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('kontruksi_dan_fo'),'','data-content="kontruksi_dan_fo" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('perizinan_operasional'),'','data-content="perizinan_operasional" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('komersial'),'','data-content="komersial" data-color="'.$st_1.':text-danger|'.$st_2.':text-success|'.$st_3.':text-warning|'.$st_4.':text-body"');
				th(lang('progress'),'','data-content="progress" data-type="percent"');
				th(lang('tahapan'),'','data-content="sub_aktivitas" data-table="tbl_sub_aktivitas tbl_tahapan"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-lg','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('manajemen_aset/aktivitas/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('nomor_aktivitas'),'nomor_aktivitas');
			select2(lang('facility_management'),'id_fm','required',$opt_fm,'id','facility_management');
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="nama_gedung"><?php echo lang('nama_gedung'); ?></label>
				<div class="col-sm-9">
					<select name="id_asset" id="id_asset" class="form-control select2" data-validation="required">
					</select>
				</div>
			</div>
			<?php
			input('text',lang('alamat'),'alamat','','','readonly');
			input('text',lang('kota'),'kota','','','readonly');
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3 required" for="perusahaan"><?php echo lang('perusahaan'); ?></label>
				<div class="col-sm-9">
					<select name="id_mitra" id="id_mitra" class="form-control select2" data-validation="required">
						<option value=""></option>
						<?php foreach ($opt_mitra as $ma){ ?>
							<option value="<?php echo $ma['id'] ?>" data-klasifikasi="<?php echo $ma['klasifikasi']; ?>" data-perusahaan="<?php echo $ma['perusahaan'] ?>" data-penanggung_jawab="<?php echo $ma['penanggung_jawab']; ?>" data-brand="<?php echo $ma['brand']; ?>" data-id_brand="<?php echo $ma['id_brand']; ?>"><?php echo $ma['perusahaan']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php

			input('text',lang('klasifikasi'),'klasifikasi','','','readonly');
			input('text',lang('brand'),'brand','','','readonly');
			input('text',lang('penanggung_jawab_mitra'),'penanggung_jawab_mitra','','','readonly');

			?>
			<div class="main-container">
				<div class="card mb-2">
					<div class="card-header"><?php echo lang('progress_telkom_property'); ?>
					</div>
					<div class="card-body">
			<?php
			col_init(3,6);
			label(strtoupper(lang('perencanaan')));
			sub_open(1);
				?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pembuatan_propar'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pembuatan_propar" class="form-control col-md-9 col-xs-9 select2" name="pembuatan_propar">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pembuatan_propar" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pembuatan_propar">
					</div>
				</div>		

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('penawaran_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="penawaran_mitra" class="form-control col-md-9 col-xs-9 select2" name="penawaran_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_penawaran_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_penawaran_mitra">
					</div>
				</div>	
                <?php
			sub_close();

			label(strtoupper(lang('proses')));
			sub_open(1);
				?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('approval_manajemen'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="approval_manajemen" class="form-control col-md-9 col-xs-9 select2" name="approval_manajemen">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_approval_manajemen" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_approval_manajemen">
					</div>
				</div>		

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pembuatan_aki'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pembuatan_aki" class="form-control col-md-9 col-xs-9 select2" name="pembuatan_aki">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pembuatan_aki" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pembuatan_aki">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('kesepakatan_gsd_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="kesepakatan_gsd_mitra" class="form-control col-md-9 col-xs-9 select2" name="kesepakatan_gsd_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_kesepakatan_gsd_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_kesepakatan_gsd_mitra">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('bak_gsd_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="bak_gsd_mitra" class="form-control col-md-9 col-xs-9 select2" name="bak_gsd_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_bak_gsd_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_bak_gsd_mitra">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pks_gsd_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pks_gsd_mitra" class="form-control col-md-9 col-xs-9 select2" name="pks_gsd_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pks_gsd_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pks_gsd_mitra">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('juskeb_konsultan'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="juskeb_konsultan" class="form-control col-md-9 col-xs-9 select2" name="juskeb_konsultan">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_juskeb_konsultan" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_juskeb_konsultan">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pengadaan_konsultan'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pengadaan_konsultan" class="form-control col-md-9 col-xs-9 select2" name="pengadaan_konsultan">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pengadaan_konsultan" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pengadaan_konsultan">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('desain_dan_rab'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="desain_dan_rab" class="form-control col-md-9 col-xs-9 select2" name="desain_dan_rab">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_desain_dan_rab" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_desain_dan_rab">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('perizinan'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="perizinan" class="form-control col-md-9 col-xs-9 select2" name="perizinan">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_perizinan" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_perizinan">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('juskeb_kontraktor'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="juskeb_kontraktor" class="form-control col-md-9 col-xs-9 select2" name="juskeb_kontraktor">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_juskeb_kontraktor" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_juskeb_kontraktor">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pengadaan_kontraktor'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pengadaan_kontraktor" class="form-control col-md-9 col-xs-9 select2" name="pengadaan_kontraktor">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pengadaan_kontraktor" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pengadaan_kontraktor">
					</div>
				</div>

				<?php
	

			sub_close();
			label(strtoupper(lang('pelaksanaan')));
			sub_open(1);
				?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('konstruksi_dan_fo'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="konstruksi_dan_fo" class="form-control col-md-9 col-xs-9 select2" name="konstruksi_dan_fo">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_konstruksi_dan_fo" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_konstruksi_dan_fo">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('bast_lahan_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="bast_lahan_mitra" class="form-control col-md-9 col-xs-9 select2" name="bast_lahan_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_bast_lahan_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_bast_lahan_mitra">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('baso_gsd_telkom'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="baso_gsd_telkom" class="form-control col-md-9 col-xs-9 select2" name="baso_gsd_telkom">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_baso_gsd_telkom" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_baso_gsd_telkom">
					</div>
				</div>

				<?php

			sub_close();	

			?>
				</div>
			</div>
			<div class="card mb-2">
				<div class="card-header"><?php echo lang('telkom_indonesia'); ?>
				</div>
				<div class="card-body">
			<?php
			label(strtoupper(lang('proses')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('sertifikat'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="sertifikat" class="form-control col-md-9 col-xs-9 select2" name="sertifikat">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_sertifikat" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_sertifikat">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('ba_acceptance'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="ba_acceptance" class="form-control col-md-9 col-xs-9 select2" name="ba_acceptance">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_ba_acceptance" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_ba_acceptance">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('relokasi'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="relokasi" class="form-control col-md-9 col-xs-9 select2" name="relokasi">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_relokasi" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_relokasi">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('owner_estimate'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="owner_estimate" class="form-control col-md-9 col-xs-9 select2" name="owner_estimate">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_owner_estimate" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_owner_estimate">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('kesepakatan_telkom_gsd'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="kesepakatan_telkom_gsd" class="form-control col-md-9 col-xs-9 select2" name="kesepakatan_telkom_gsd">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_kesepakatan_telkom_gsd" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_kesepakatan_telkom_gsd">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('justifikasi_inisiatif_bisnis'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="justifikasi_inisiatif_bisnis" class="form-control col-md-9 col-xs-9 select2" name="justifikasi_inisiatif_bisnis">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_justifikasi_inisiatif_bisnis" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_justifikasi_inisiatif_bisnis">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('bak_telkom_gsd'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="bak_telkom_gsd" class="form-control col-md-9 col-xs-9 select2" name="bak_telkom_gsd">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_bak_telkom_gsd" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_bak_telkom_gsd">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pks_telkom_gsd'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pks_telkom_gsd" class="form-control col-md-9 col-xs-9 select2" name="pks_telkom_gsd">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pks_telkom_gsd" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pks_telkom_gsd">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('approval_demolish'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="approval_demolish" class="form-control col-md-9 col-xs-9 select2" name="approval_demolish">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_approval_demolish" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_approval_demolish">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('pelaksanaan_demolish'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="pelaksanaan_demolish" class="form-control col-md-9 col-xs-9 select2" name="pelaksanaan_demolish">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_pelaksanaan_demolish" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_pelaksanaan_demolish">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('surat_pernyataan_bersama'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="surat_pernyataan_bersama" class="form-control col-md-9 col-xs-9 select2" name="surat_pernyataan_bersama">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_surat_pernyataan_bersama" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_surat_pernyataan_bersama">
					</div>
				</div>
				<?php
			sub_close();

			label(strtoupper(lang('pelaksanaan')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('bast_lahan_gsd'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="bast_lahan_gsd" class="form-control col-md-9 col-xs-9 select2" name="bast_lahan_gsd">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_bast_lahan_gsd" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_bast_lahan_gsd">
					</div>
				</div>
			<?php
			
			sub_close();
			?>
			</div>
				</div>
			
			<div class="card mb-2">
				<div class="card-header"><?php echo lang('mitra'); ?>
				</div>
				<div class="card-body">
			<?php

			label(strtoupper(lang('perencanaan')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('assesment_lokasi'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="assesment_lokasi" class="form-control col-md-9 col-xs-9 select2" name="assesment_lokasi">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_assesment_lokasi" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_assesment_lokasi">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('letter_of_interest'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="letter_of_interest" class="form-control col-md-9 col-xs-9 select2" name="letter_of_interest">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_letter_of_interest" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_letter_of_interest">
					</div>
				</div>

			<?php
			sub_close();	

			label(strtoupper(lang('proses')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('business_plan_mitra'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="business_plan_mitra" class="form-control col-md-9 col-xs-9 select2" name="business_plan_mitra">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_business_plan_mitra" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_business_plan_mitra">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('prelim_budget_est'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="prelim_budget_est" class="form-control col-md-9 col-xs-9 select2" name="prelim_budget_est">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_prelim_budget_est" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_prelim_budget_est">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('approval_desain'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="approval_desain" class="form-control col-md-9 col-xs-9 select2" name="approval_desain">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_approval_desain" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_approval_desain">
					</div>
				</div>
			<?php
			sub_close();

			label(strtoupper(lang('pelaksanaan')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('kontruksi_dan_fo'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="kontruksi_dan_fo" class="form-control col-md-9 col-xs-9 select2" name="kontruksi_dan_fo">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_konstruksi_dan_fo" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_konstruksi_dan_fo">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('perizinan_operasional'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="perizinan_operasional" class="form-control col-md-9 col-xs-9 select2" name="perizinan_operasional">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_perizinan_operasional" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_perizinan_operasional">
					</div>
				</div>
			<?php
			sub_close();

			label(strtoupper(lang('komersial')));
			sub_open(1);
			?>
				<div class="form-group row">
					<label class="col-form-label col-md-3 sub-1"><?php echo lang('komersial'); ?></label>
	                <div class="col-md-2 col-2 mb-1 mb-md-0">
	                    <select id="komersial" class="form-control col-md-9 col-xs-9 select2" name="komersial">
							<option value=""></option>
							<?php foreach($opt_status as $u) {
								echo '<option value="'.$u['status'].'">'.$u['status'].'</option>';
							} ?>
	                    </select>
	                </div>
	                <div class="col-md-7 col-7 mb-1 mb-md-0">
						<input type="text" name="k_komersial" autocomplete="off" class="form-control" data-validation="" placeholder="<?php echo lang('keterangan'); ?>" id="k_komersial">
					</div>
				</div>
			<?php
			sub_close();			
			?>
					</div>
				</div>
			</div>
			<?php
			col_init(3,9);
			input('text',lang('status_terakhir'),'status_terakhir');
			input('text',lang('next_action'),'next_action');
			input('text',lang('support_needed'),'support_needed');

			toggle(lang('aktif').'?','is_active');

			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('manajemen_aset/aktivitas/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>

<script type="text/javascript">
	function formOpen() {
		var is_edit = false;
		var response = response_edit;
		$('#id_asset').html('');
		if(typeof response.id != 'undefined') {
			$.each(response.detail,function(n,z){
				$('#k_'+z._key).val(z.keterangan);
			});	

			$('#id_asset').html('<option value="'+response.id_asset+'" data-alamat="'+response.alamat+'" data-kota="'+response.kota+'">'+response.nama_gedung+'</option>').trigger('change');	

		//	$('#id_fm').html('<option value="'+response.id_fm+'">'+response.facility_management+'</option>').trigger('change');	
		}else{
			$('.select2').val('BLM').attr('selected','selected').change();
		}

		is_edit= false;
	}

	function detail_callback(id){
		$.get(base_url+'manajemen_aset/aktivitas/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
		});
	}

	$('#id_asset').change(function(){
		$('#alamat').val($(this).find(':selected').attr('data-alamat'));
		$('#kota').val($(this).find(':selected').attr('data-kota'));
	});

	$('#id_mitra').change(function(){
		$('#klasifikasi').val($(this).find(':selected').attr('data-klasifikasi'));
		$('#brand').val($(this).find(':selected').attr('data-brand'));
		$('#penanggung_jawab_mitra').val($(this).find(':selected').attr('data-penanggung_jawab'));
	});

	$('#id_fm').change(function(){
    	$('#alamat').val('');
    	$('#kota').val('');
    	get_asset();
	});

	function get_asset() {
		if(proccess) {
			readonly_ajax = false;
			$.ajax({
				url : base_url + 'manajemen_aset/aktivitas/get_asset',
				data : {id_fm: $('#id_fm').val()},
				type : 'POST',
				success	: function(response) {
					rs = response;
					$('#id_asset').html(response);
				}
			});
		}
	}
</script>