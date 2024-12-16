<?php foreach($record as $u) { ?>
<tr>
    <td><?php echo $u['facility_management']; ?></td>
    <td><?php echo $u['nama_gedung'];?></td>
    <td><?php echo $u['alamat']; ?></td>
    <td><?php echo $u['kota']; ?></td>
    <td><?php echo $u['brand']; ?></td>
    <td><?php echo $u['klasifikasi']; ?></td>
    <td><?php echo $u['perusahaan']; ?></td>
    <td><?php echo $u['penanggung_jawab_mitra']; ?></td>
    <?php foreach($jenis_aktivitas as $x) { ?>
        <?php $field = $x->_key ; ?>

       <?php
            foreach ($status as $s) {
                if($u[$field] == $s->status){
                    $warna = $s->warna;
                    //debug($warna);die;
                }
            }
       ?> 

       <?php if($u[$field] == 'TDL') { ?>
        <td style="background-color: #2E2E2E; color: white;"><?php echo $u[$field]; ?></td>
        <?php }else{ ?>        
        <td class="text-center"><FONT COLOR="<?php echo $warna ?>"><?php echo $u[$field]; ?></td>

        <?php } ?>

    <?php } ?>
    <td><?php echo $u['progress']; ?> %</td>
    <td><?php echo $u['tahapan']; ?></td>
</tr>
<?php } ?>