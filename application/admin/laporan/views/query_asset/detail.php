<?php include_lang('manajemen_aset'); ?>
<div class="card mb-2">
    <div class="card-header"><?php echo lang('informasi_asset'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('nomor_asset'); ?></th>
                    <td colspan="3"><?php echo $nomor; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nama_gedung'); ?></th>
                    <td colspan="3"><?php echo $nama_gedung; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('alamat'); ?></th>
                    <td colspan="3"><?php echo $alamat; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('kota'); ?></th>
                    <td colspan="3"><?php echo $kota; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('titik_koordinat'); ?></th>
                    <td colspan="3"><?php echo $titik_koordinat; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('pemilik'); ?></th>
                    <td colspan="3"><?php echo $pemilik_aset; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('status_asset'); ?></th>
                    <td><?php echo $status_asset; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('mitra'); ?></th>
                    <td colspan="3"><?php echo ($status_asset == 'Idle' ? "-" : $brand) ; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('skema_kerjasama'); ?></th>
                    <td colspan="3"><?php echo ($status_asset == 'Idle' ? "-" : $skema_kerjasama) ; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('status_tanah'); ?></th>
                    <td colspan="3"><?php echo $status_tanah; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('masa_berlaku_surat_tanah'); ?></th>
                    <td colspan="3"><?php echo date_indo($masa_berlaku_surat_tanah); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('luas_tanah'); ?></th>
                    <td colspan="3"><?php echo number_format($luas_tanah) . " M2"; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('lxp_tanah'); ?></th>
                    <td colspan="3"><?php echo $LXP_tanah . " M2"; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('bentuk_tanah'); ?></th>
                    <td colspan="3"><?php echo $bentuk_tanah; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('luas_bangunan'); ?></th>
                    <td colspan="3"><?php echo number_format($luas_bangunan) . " M2"; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('jumlah_ltbangunan'); ?></th>
                    <td colspan="3"><?php echo $jumlah_ltbangunan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('luas_area_idle'); ?></th>
                    <td colspan="3"><?php echo number_format($luas_area_idle) . " M2"; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('jenis_bangunan'); ?></th>
                    <td colspan="3"><?php echo $jenis_bangunan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tipe_asset'); ?></th>
                    <td colspan="3"><?php echo $tipe_asset; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('batasan_lahan'); ?></th>
                </tr>
                <tr>
                    <th class="sub-1"><?php echo lang('utara'); ?></th>
                    <td colspan="3"><?php echo $batas_utara; ?></td>
                </tr>
                <tr>
                    <th class="sub-1"><?php echo lang('selatan'); ?></th>
                    <td colspan="3"><?php echo $batas_selatan; ?></td>
                </tr>

                 <tr>
                    <th class="sub-1"><?php echo lang('timur'); ?></th>
                    <td colspan="3"><?php echo $batas_timur; ?></td>
                </tr>

                <tr>
                    <th class="sub-1"><?php echo lang('barat'); ?></th>
                    <td colspan="3"><?php echo $batas_barat; ?></td>
                </tr>

                <tr>
                    <th><?php echo lang('informasi_sekitar'); ?></th>
                    <td colspan="3"><?php echo $informasi_sekitar; ?></td>
                </tr>                
                <tr>
                    <th><?php echo lang('status_penggunaan'); ?></th>
                    <td colspan="3"><?php echo $status_penggunaan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('usulan_penggunaan'); ?></th>
                    <td colspan="3"><?php echo ($status_penggunaan == 'Leveraged' ? "-" : $usulan_penggunaan); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('usulan_mitra'); ?></th>
                    <td colspan="3"><?php echo ($status_penggunaan == 'Leveraged' ? "-" : $usulan_mitra); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('jarak_usulan_mitra_lokasi'); ?></th>
                    <td colspan="3"><?php echo ($status_penggunaan == 'Leveraged' ? "-" : $jarak_usulan_mitra_lokasi); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('catu_daya'); ?></th>
                    <td colspan="3"><?php echo $catu_daya; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('area'); ?></th>
                    <td colspan="3"><?php echo $area; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('facility_management'); ?></th>
                    <td colspan="3"><?php echo $facility_management; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('last_update'); ?></th>
                    <td colspan="3"><?php echo date_indo($update_at) . ($update_by !="" ? ' oleh : ' : "") . $update_by; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('support_data'); ?></th>
                    <td colspan="3">
                        <ul class="pl-3 mb-0">
                            <?php
                            foreach(json_decode($file,true) as $k => $v) {
                                echo '<li><a href="'.base_url('assets/uploads/aset/'.$v).'" target="_blank">'.$k.'</a></li>';
                            }
                            ?>
                        </ul>    
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('foto_gedung'); ?></th>
                    <td colspan="3">
                        <ul class="pl-3 mb-0">
                            <?php
                            foreach($file_foto as $k) {                            
                                echo '<tr>' ;
                                echo '<th class="sub-1">'.$k->nama_foto.'</th>';
                                echo '<td style="text-align:right">';    
                                echo '<div style="margin: 0 auto; width: 130px">';
                                echo '<a href="'.base_url('assets/uploads/foto_gedung/'.$id.'/'.$k->file_foto).'" target="_blank"><img src="'.base_url('assets/uploads/foto_gedung/'.$id.'/'.$k->file_foto).'" alt="" style="width: 130px" /></a>';
                                echo '</div>';                        
                                echo '</td>';
                                echo '</tr>';

                            }
                            ?>
                        </ul>    
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('keterangan'); ?></th>
                    <td colspan="3"><?php echo $keterangan; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
