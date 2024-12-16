<?php $no =0 ; ?>
<?php foreach($data_expire2 as $s) { ?>
<?php $no++ ; 
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->perusahaan; ?></td>
    <td><?php echo $s->brand; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td><?php echo $s->lokasi; ?></td>
    <td><?php echo $s->kota; ?></td>
    <td><?php echo date_indo($s->tanggal_akhir_kontrak_mitra); ?></td>
</tr>
<?php } ?>
