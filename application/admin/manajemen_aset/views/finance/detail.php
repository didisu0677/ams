<div class="card mb-2">
    <div class="card-header"><?php echo lang('data_perusahaan'); ?></div>
    <div class="card-body p-1">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-app table-detail table-normal">
                <tr>
                    <th width="200"><?php echo lang('perusahaan'); ?></th>
                    <td colspan="3"><?php echo $perusahaan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('lokasi_gedung'); ?></th>
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
                    <th><?php echo lang('klasifikasi'); ?></th>
                    <td colspan="3"><?php echo $klasifikasi; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('nomor_kontrak_mitra_gsd'); ?></th>
                    <td colspan="3"><?php echo $nomor_kontrak_mitra_gsd; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tanggal_komersial'); ?></th>
                    <td><?php echo date_indo($tanggal_komersial); ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('portfolio'); ?></th>
                    <td><?php echo $port; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('fm'); ?></th>
                    <td><?php echo $facility_management; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('area'); ?></th>
                    <td><?php echo $area; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('keterangan'); ?></th>
                    <td><?php echo $keterangan; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('last_update'); ?></th>
                    <td colspan="3"><?php echo date_indo($update_at) . ($update_by !="" ? ' oleh : ' : "") . $update_by; ?></td>
                </tr>
                <tr>
                    <th><?php echo lang('tahun'); ?></th>
                    <td><?php echo $tahun; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="table-responsive mb-2">
    <table class="table table-bordered table-app table-detail table-normal">
        <thead> 
            <tr>
                <th><?php echo lang('bulan'); ?></th>
                <th><?php echo lang('revenue'); ?></th>
                <th><?php echo lang('beban_cogs'); ?></th>
                <th><?php echo lang('beban_operasional'); ?></th>
                <th><?php echo lang('biaya_perbaikan'); ?></th>
                <th><?php echo lang('piutang'); ?></th>
                <th><?php echo lang('tanggal_unbill') ; ?></th>
                <th><?php echo lang('tanggal_bill'); ?></th>
                <th><?php echo lang('tanggal_paid'); ?></th>
                <th><?php echo lang('status_terakhir'); ?></th>
                <th><?php echo lang('status_finance'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php

            $trevenue = 0;
            $tcogs = 0;
            $toperasional = 0;
            $tperbaikan = 0;
            $tpiutang = 0;
            $status_finance = '';
            $tpiutang_bill = 0;
            $tpiutang_unbill = 0;
            $tpiutang_paid = 0;
            foreach ($detail as $d) {
            if($d->revenue > 0 || $d->piutang > 0) {
                if($d->status_finance == 1) {
                    $status_finance = 'Real';
                }else{
                    $status_finance = 'Accrue';
                }
            }else{
                $status_finance = '';             
            }
            
            $tanggal_unbill = '0000-00-00';
            $tanggal_bill = '0000-00-00';
            $tanggal_paid = '0000-00-00';

            if($d->tanggal_unbill != '1970-01-01' && $d->tanggal_unbill != '1970-01-01') {
                $tanggal_unbill = $d->tanggal_unbill;
            } 
            if($d->tanggal_bill != '1970-01-01' && $d->tanggal_bill != '1970-01-01') {
                $tanggal_bill = $d->tanggal_bill;
            }
            if($d->tanggal_paid != '1970-01-01' && $d->tanggal_paid != '1970-01-01') {
                $tanggal_paid = $d->tanggal_paid;
            }
            
            $tpiutang_bill += $d->piutang_bill;
            $tpiutang_unbill += $d->piutang_unbill;
            $tpiutang_paid += $d->piutang_paid;

            ?>
            <tr>
                <th><?php echo month_lang($d->bulan); ?></th>
                <td class="text-right"><?php echo custom_format($d->revenue); ?></td>
                <td class="text-right"><?php echo custom_format($d->beban_cogs); ?></td>
                <td class="text-right"><?php echo custom_format($d->beban_operasional); ?></td>
                <td class="text-right"><?php echo custom_format($d->biaya_perbaikan); ?></td>
                <td class="text-right"><?php echo custom_format($d->piutang); ?></td>
                <td><?php echo date_indo($tanggal_unbill); ?></td>
                <td><?php echo date_indo($tanggal_bill); ?></td>
                <td><?php echo date_indo($tanggal_paid); ?></td>
                <td><?php echo $d->status_bill; ?></td>
                <td><?php echo $status_finance ; ?></td>
            </tr>
            <?php 
                $trevenue += $d->revenue;
                $tcogs += $d->beban_cogs;
                $toperasional += $d->beban_operasional;
                $tperbaikan += $d->biaya_perbaikan;
                $tpiutang += $d->piutang;  
            } ?>    
            <tr>
                <th style="background-color: #33b5e5; color: white;">TOTAL</th>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($trevenue); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tcogs); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($toperasional); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tperbaikan); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tpiutang); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tpiutang_unbill); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tpiutang_bill); ?></td>
                <td style="background-color: #33b5e5; color: white;" class="text-right"><?php echo custom_format($tpiutang_paid); ?></td>
                <td style="background-color: #33b5e5; color: white;"></td>
            </tr>    
        </tbody>
    </table>
</div>

