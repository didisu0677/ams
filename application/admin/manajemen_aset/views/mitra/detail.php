<div class="card mb-2">
    <div class="card-header"><?php echo lang('informasi_umum'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th><?php echo lang('id_perusahaan'); ?></th>
                    <td colspan="3"><?php echo $nomor; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('klasifikasi'); ?></th>
                    <td colspan="3"><?php echo $klasifikasi; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('brand'); ?></th>
                    <td colspan="3"><?php echo $brand; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('logo_brand'); ?></th>
                    <td style="text-align:right">    
                        <div style="margin: 0 auto; width: 130px">
                            <img src="<?php echo base_url(dir_upload('mitra').$logo_brand); ?>" alt="" style="width: 130px" />
                        </div>                        
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('perusahaan'); ?></th>
                    <td colspan="3"><?php echo $perusahaan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('alamat_perusahaan'); ?></th>
                    <td colspan="3"><?php echo $alamat_perusahaan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('pic_telepon'); ?></th>
                    <td><?php echo nl2br($pic_telepon); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('jumlah_kerjasama'); ?></th>
                    <td colspan="3"><?php echo $jumlah_kerjasama; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('penanggung_jawab_mitra'); ?></th>
                    <td colspan="3"><?php echo $penanggung_jawab; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="card mb-2">
    <div class="card-header"><?php echo lang('mitra_requirement'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('luas_lahan'); ?></th>
                    <td colspan="3"><?php echo $luas_lahan; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('luas_bangunan'); ?></th>
                    <td colspan="3"><?php echo $luas_bangunan; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('tipe_asset'); ?></th>
                    <td colspan="3"><?php echo $tipe_asset; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('special_request'); ?></th>
                    <td colspan="3"><?php echo $special_request; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('skema_kerjasama'); ?></th>
                    <td colspan="3"><?php echo $skema_kerjasama; ?></td>
                </tr>
                <tr>
                    <th width="200"><?php echo lang('keterangan'); ?></th>
                    <td colspan="3"><?php echo $keterangan; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
