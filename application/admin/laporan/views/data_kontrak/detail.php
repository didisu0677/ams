<?php include_lang('manajemen_aset')?>
<div class="card mb-2">
    <div class="card-header"><?php echo lang('informasi_mitra'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('nama_perusahaan'); ?></th>
                    <td colspan="3"><?php echo $perusahaan; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('klasifikasi'); ?></th>
                    <td colspan="3"><?php echo $klasifikasi; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('lokasi_gedung'); ?></th>
                    <td colspan="3"><?php echo $nama_gedung; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('alamat'); ?></th>
                    <td colspan="3"><?php echo $lokasi; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('kota'); ?></th>
                    <td colspan="3"><?php echo $kota; ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>
<div class="card mb-2">
    <div class="card-header"><?php echo lang('informasi_kontrak'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('tgl_bak_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo date_indo($tgl_bak_telkom_gsd); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tgl_kontrak_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo date_indo($tgl_kontrak_telkom_gsd); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nomor_kontrak_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo $nomor_kontrak_telkom_gsd; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tgl_baso_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo date_indo($tgl_baso_telkom_gsd); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tgl_bak_mitra_gsd'); ?></th>
                    <td colspan="3"><?php echo date_indo($tgl_bak_mitra_gsd); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tgl_kontrak_mitra_gsd'); ?></th>
                    <td><?php echo date_indo($tgl_kontrak_mitra_gsd); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nomor_kontrak_mitra_gsd'); ?></th>
                    <td colspan="3"><?php echo $nomor_kontrak_mitra_gsd; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tgl_komersial'); ?></th>
                    <td colspan="3"><?php echo date_indo($tgl_komersial); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('durasi_kontrak'); ?></th>
                    <td colspan="3"><?php echo $durasi_kontrak . ' Tahun' ; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('skema_kerjasama_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo $skema_kerjasama_telkom_gsd; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nilai_skema_kerjasama_telkom_gsd'); ?></th>
                    <td colspan="3"><?php echo $nilai_skema_kerjasama_telkom_gsd; ?></td>
                </tr>
                <tr> 
                    <th><?php echo lang('skema_kerjasama_mitra_gsd'); ?></th>
                    <td colspan="3"><?php echo $skema_kerjasama_mitra_gsd; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nilai_skema_kerjasama_mitra_gsd'); ?></th>
                    <td colspan="3"><?php echo $nilai_skema_kerjasama_mitra_gsd; ?></td>
                </tr>

                <tr>
                    <th><?php echo lang('investasi'); ?></th>
                    <td colspan="3"><?php echo $investasi; ?></td>
                </tr>

                <tr>
                    <th><?php echo lang('tanggal_akhir_kontrak_mitra'); ?></th>
                    <td colspan="3"><?php echo date_indo($tanggal_akhir_kontrak_mitra); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('sisa_waktu_kontrak'); ?></th>
                    <td colspan="3"><?php echo $sisa_waktu_kontrak; ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>

<?php 
if(count($detail)) { ?>
<div class="card mb-2">
    <div class="card-header"><?php echo lang('perpanjang_kontrak'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
               <?php foreach($detail as $k) { ?>

                <tr>
                    <th width="200"><?php echo lang('tanggal'); ?></th>
                    <td colspan="3"><?php echo c_date($k->tanggal_perpanjang); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<?php } ?>