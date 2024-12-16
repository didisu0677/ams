<?php 
$i = 0;
$nomor_kontrak = '';
$tgl_kontrak = '';
$skema ='';
foreach($record as $u) { ?>
<?php if($u['nomor_kontrak_mitra_gsd'] !='') { ?>
    <?php $i++; 
    $nomor_kontrak = $u['nomor_kontrak_mitra_gsd']; 
    $tgl_kontrak = $u['tgl_kontrak_mitra_gsd']; 
    $skema = $u['skema_mitra'];
    if($i==1) {
    ?>
    <tr>
        <th colspan = "13" style="background-color: #4285F4; color: white;" class="text-center"><?php echo "TELPRO-MITRA"; ?></th>
    </tr> 

    <?php }?>

    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $u['klasifikasi']; ?></td>
        <td><?php echo $u['brand'];?></td>
        <td><?php echo $u['perusahaan']; ?></td>
        <td><?php echo $u['nama_gedung']; ?></td>
        <td><?php echo $u['alamat']; ?></td>
        <td><?php echo $u['kota']; ?></td>
        <td><a href="<?php echo base_url('laporan/data_kontrak/detail/?nomor_kontrak='. $nomor_kontrak.''); ?>" class="cInfo"><?php echo $nomor_kontrak; ?></a></td>
        <td><?php echo date_indo($tgl_kontrak); ?></td>
        <td><?php echo $u['durasi_kontrak']; ?> Tahun</td>
        <td><?php echo $u['sisa_waktu_kontrak']; ?></td>
        <td><?php echo $skema; ?></td>
        <td><?php echo $u['nilai_skema_kerjasama_mitra_gsd']; ?> %</td>
    </tr>    
<?php 
    if($i == $count_mitra){ ?>
    <tr>
        <th colspan = "7" style="background-color: #4285F4; color: white;" class="text-center"><?php echo "SUB TOTAL KONTRAK TELPRO-MITRA"; ?></th>
        <th colspan = "6" style="background-color: #4285F4; color: white;" class="text-center"><?php echo $i; ?> DATA</th>
    </tr> 
<?php
    }
}} ?>

<?php 
$judul ='TELPRO-MITRA';
$nomor_kontrak = '';
$k = 0;
foreach($record as $u) { ?>
<?php if($u['nomor_kontrak_telkom_gsd'] !='') { ?>
    <?php $k++; 
    $nomor_kontrak = $u['nomor_kontrak_telkom_gsd']; 
    $tgl_kontrak = $u['tgl_kontrak_telkom_gsd']; 
    $skema = $u['skema_telkom'];
    if($k==1) {
    ?>
    <tr>
        <th colspan = "13" style="background-color: #FF8800; color: white;" class="text-center"><?php echo "TELPRO-TELKOM"; ?></th>
    </tr> 

    <?php }?>

    <tr>
        <td><?php echo $k; ?></td>
        <td><?php echo $u['klasifikasi']; ?></td>
        <td><?php echo $u['brand'];?></td>
        <td><?php echo $u['perusahaan']; ?></td>
        <td><?php echo $u['nama_gedung']; ?></td>
        <td><?php echo $u['alamat']; ?></td>
        <td><?php echo $u['kota']; ?></td>
        <td><a href="<?php echo base_url('laporan/data_kontrak/detail/?nomor_kontrak='. $nomor_kontrak.''); ?>" class="cInfo"><?php echo $nomor_kontrak; ?></a></td>

        <td><?php echo date_indo($tgl_kontrak); ?></td>
        <td><?php echo $u['durasi_kontrak']; ?> Tahun</td>
        <td><?php echo $u['sisa_waktu_kontrak']; ?></td>
        <td><?php echo $skema; ?></td>
        <td ><?php echo $u['nilai_skema_kerjasama_telkom_gsd']; ?> %</td>
    </tr>
<?php 
    if($k == $count_telkom){ ?>
    <tr>
        <th colspan = "7" style="background-color: #FF8800; color: white;" class="text-center"><?php echo "SUB TOTAL KONTRAK TELPRO-TELKOM"; ?></th>
        <th colspan = "6" style="background-color: #FF8800; color: white;" class="text-center"><?php echo $k; ?> DATA</th>
    </tr> 
<?php
    }
}} ?>