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
		<?php
		form_open(base_url('settings/deskripsi_aset/save'),'post','form','data-submit="ajax" data-callback="reload"');
			card_open(lang('deskripsi_aset'),'mb-2');
				col_init(3,9);
				?>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="status_tanah"><?php echo lang('status_tanah'); ?></label>
					<div class="col-sm-9">
						<input type="text" name="status_tanah" id="status_tanah" class="form-control tags" autocomplete="off" value="<?php echo setting('status_tanah'); ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="luas_tanah"><?php echo lang('luas_tanah'); ?></label>
					<div class="col-sm-9">
						<input type="text" name="bentuk_tanah" id="luas_tanah" class="form-control tags" autocomplete="off" value="<?php echo setting('luas_tanah'); ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="luas_bangunan"><?php echo lang('luas_bangunan'); ?></label>
					<div class="col-sm-9">
						<input type="text" name="luas_bangunan" id="luas_bangunan" class="form-control tags" autocomplete="off" value="<?php echo setting('luas_bangunan'); ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="bentuk_tanah"><?php echo lang('bentuk_tanah'); ?></label>
					<div class="col-sm-9">
						<input type="text" name="bentuk_tanah" id="bentuk_tanah" class="form-control tags" autocomplete="off" value="<?php echo setting('bentuk_tanah'); ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label" for="catu_daya"><?php echo lang('catu_daya'); ?></label>
					<div class="col-sm-9">
						<input type="text" name="catu_daya" id="catu_daya" class="form-control tags" autocomplete="off" value="<?php echo setting('catu_daya'); ?>">
					</div>
				</div>
				<?php
			card_close();

				form_button(lang('simpan'),false);
		form_close();
		?>
	</div>
</div>
