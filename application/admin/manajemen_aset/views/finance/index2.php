	<?php
			col_init(3,9);
			input('hidden','id','id');
			input('hidden',lang('nomor'),'nomor');
			input('text',lang('perusahaan'),'id_mitra');
			input('text',lang('brand'),'brand');
			input('text',lang('klasifikasi'),'klasifikasi');
			input('text',lang('lokasi'),'id_asset');
			input('text',lang('alamat'),'alamat');
			input('text',lang('kota'),'kota');
			input('text',lang('nomor_kontrak_gsd_mitra'),'nomor_kontrak_gsd_mitra');
			input('date',lang('tanggal_komersial'),'tanggal_komersial');
			input('text',lang('tahun'),'tahun');
			col_init(0,12);
			?>

			<div class="table-responsive mb-2">
				<table class="table table-bordered table-detail table-app">
					<thead>
						<tr>
							<th><?php echo lang('bulan'); ?></th>
							<th width="80"><?php echo lang('revenue') . str_repeat('&nbsp;', 20) ; ?></th>
							<th width="80"><?php echo lang('beban_cogs') . str_repeat('&nbsp;', 20); ?></th>
							<th width="40"><?php echo lang('beban_operasional'); ?></th>
							<th width="40"><?php echo lang('biaya_perbaikan') . str_repeat('&nbsp;', 10); ?></th>
							<th width="40"><?php echo lang('piutang') . str_repeat('&nbsp;', 20); ?></th>
							<th width="40"><?php echo lang('tanggal_unbill'); ?></th>
							<th width="40"><?php echo lang('tanggal_bill') . str_repeat('&nbsp;', 5); ?></th>
							<th width="40"><?php echo lang('tanggal_paid') . str_repeat('&nbsp;', 5); ?></th>
							<th width="40"><?php echo lang('laporan_keuangan'); ?></th>
							<th width="40"><?php echo lang('rab_perbaikan'); ?></th>
							<th width="40"><?php echo lang('tagihan'); ?></th>
							<th width="40"><?php echo lang('bukti_transfer'); ?></th>
							<th><?php echo lang('keterangan') . str_repeat('&nbsp;', 50); ?></th>
						</tr>
					</thead>
					<tbody id="d2">
						<?php 	for ($i = 1; $i <= 12; $i++) { ?>
						<tr>
							<td><?php echo month_lang($i); ?></td>
							<td width="80">
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
							<td width="80">
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
							<td>
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
							<td><?php input('date','','tanggal_verifikasi');?></td>
							<td><?php input('date','','tanggal_verifikasi');?></td>
							<td><?php input('date','','tanggal_verifikasi');?></td>
							<td>
								<div class="input-group">
									<input type="text" name="file_foto[<?php echo $i; ?>]" id="dok_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="jpg|jpeg|png">

									<div class="input-group-append">
										<div id="<?php echo 'file_foto'. $i; ?>" class ="text-center dwlfile"></div>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input type="text" name="file_foto[<?php echo $i; ?>]" id="dok_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="jpg|jpeg|png">

									<div class="input-group-append">
										<div id="<?php echo 'file_foto'. $i; ?>" class ="text-center dwlfile"></div>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input type="text" name="file_foto[<?php echo $i; ?>]" id="dok_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="jpg|jpeg|png">

									<div class="input-group-append">
										<div id="<?php echo 'file_foto'. $i; ?>" class ="text-center dwlfile"></div>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input type="text" name="file_foto[<?php echo $i; ?>]" id="dok_<?php echo $i; ?>" data-validation="" data-action="<?php echo base_url('upload/file/datetime'); ?>" data-token="<?php echo encode_id([user('id'),(time() + 900)]); ?>" autocomplete="off" class="form-control input-file" value="" placeholder="<?php echo lang('maksimal'); ?> 5MB" data-accept="jpg|jpeg|png">

									<div class="input-group-append">
										<div id="<?php echo 'file_foto'. $i; ?>" class ="text-center dwlfile"></div>
									</div>
								</div>
							</td>
							<td>
								<input type="text" class="form-control" autocomplete="off" id="<?php echo 'keterangan'. $i; ?>" name="keterangan[<?php echo $i; ?>]" value="" />
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>