<div class="card mb-2">
    <div class="card-header"><?php echo lang('informasi'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('nomor_aktivitas'); ?></th>
                    <td colspan="3"><?php echo $nomor_aktivitas; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('facility_management'); ?></th>
                    <td colspan="3"><?php echo $facility_management; ?></td>
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
                    <th><?php echo lang('brand'); ?></th>
                    <td colspan="3"><?php echo $brand; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('klasifikasi'); ?></th>
                    <td><?php echo $klasifikasi; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('perusahaan'); ?></th>
                    <td colspan="3"><?php echo $perusahaan ; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('penanggung_jawab_mitra'); ?></th>
                    <td colspan="3"><?php echo $penanggung_jawab_mitra  ; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('last_update'); ?></th>
                    <td colspan="3"><?php echo date_indo($update_at) . ($update_by !="" ? ' oleh : ' : "") . $update_by; ?></td>
                </tr>
       
            </table>
        </div>
    </div>
</div>
<div class="table-responsive mb-2">
    <table class="table table-bordered table-app table-detail table-normal">
        <thead> 
            <tr>
                <th style="background-color: #CC0000; color: white;" width ="400px"><font color="#fff"><?php echo lang('progress_telkom_property'); ?></th>
                <th style="background-color: #CC0000; color: white;" width ="150px" class="text-center"><font color="#fff"><?php echo lang('status'); ?></th>
                <th style="background-color: #CC0000; color: white;"><font color="#fff"><?php echo lang('keterangan'); ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th style="background-color: #9e9e9e; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('perencanaan'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($perencanaan1 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #ffbb33; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('proses'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($proses1 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #33b5e5; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('pelaksanaan'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($pelaksanaan1 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="table-responsive mb-2">
    <table class="table table-bordered table-app table-detail table-normal">
        <thead>
            <tr>
                <th style="background-color: #0d47a1; color: white;" width ="400px"><font color="#fff"><?php echo lang('telkom_indonesia'); ?></th>
                <th style="background-color: #0d47a1; color: white;" width ="150px" class="text-center"><font color="#fff"><?php echo lang('status'); ?></th>
                <th style="background-color: #0d47a1; color: white;"><font color="#fff"><?php echo lang('keterangan'); ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th style="background-color: #ffbb33; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('proses'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($proses2 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #33b5e5; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('pelaksanaan'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($pelaksanaan2 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<div class="table-responsive mb-2">
    <table class="table table-bordered table-app table-detail table-normal">
        <thead>
            <tr>
                <th style="background-color: #9933CC; color: white;" width ="400px"><font color="#fff"><?php echo lang('mitra'); ?></th>
                <th style="background-color: #9933CC; color: white;" width ="150px" class="text-center"><font color="#fff"><?php echo lang('status'); ?></th>
                <th style="background-color: #9933CC; color: white;"><font color="#fff"><?php echo lang('keterangan'); ?></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th style="background-color: #9e9e9e; color: white;"colspan="3" class="text-center"><font color="#fff"><?php echo lang('perencanaan'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($perencanaan3 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #ffbb33; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('proses'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($proses3 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #33b5e5; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('pelaksanaan'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($pelaksanaan3 as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #007E33; color: white;" colspan="3" class="text-center"><font color="#fff"><?php echo lang('komersial'); ?></th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach($komersial as $p) { ?>
            <tr>
                <td><?php echo $p->nama_aktivitas; ?></td>
                <td class="text-center"><FONT COLOR='<?php echo $p->warna ?>'><?php echo $p->status_aktivitas;?></td>
                <td><?php echo $p->keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>

<div class="card mb-2">
    <div class="card-header"><?php echo lang('summary_activity'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                        <?php foreach($status as $s) { ?>
                        <?php  
                            $st = 'st_' . $s->status ;

                            if($s->id == 1) {
                                $r1 = 'st_' . $s->status ;
                            }

                            if($s->id == 2) {
                                $r2 = 'st_' . $s->status ;
                            }

                            if($s->id == 3) {
                                $r3 = 'st_' . $s->status ;
                            }

                            if($s->id == 4) {
                                $r4 = 'st_' . $s->status ;
                            }
                        ?>
                        <tr>
                            <th><?php echo $s->status; ?></th>
                            <?php if(isset($$st)) { ?>
                            <td><?php echo $$st; ?></td>
                            <?php }else{ ?>

                                <td></td>

                            <?php } ?>
                        </tr>
                        <?php } 
                        $rumus  = round(((($$r2 * 1) + ( $$r3 * (50/100)) + ( $$r1 * 0)) / ($$r2+$$r3+$$r1)) * 100,2);


                        ?>
                        <tr>
                            <th><?php echo 'Prosentase'; ?></th>
                            <td><?php echo $rumus; ?> %</td>
                        </tr>

            </table>
        </div>
    </div>
</div>

<div class="card mb-2">
<div class="card-header"><?php echo lang('informasi_tambahan'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('status_terakhir'); ?></th>
                    <td colspan="3"><?php echo $status_terakhir; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('next_action'); ?></th>
                    <td colspan="3"><?php echo $next_action; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('support_needed'); ?></th>
                    <td colspan="3"><?php echo $support_needed; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>