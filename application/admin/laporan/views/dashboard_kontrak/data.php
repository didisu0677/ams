<?php foreach($sisa_waktu as $s) { ?>
<?php $sk = 'par_' . $s->id 
?>

<tr>
    <td><?php echo $s->parameter_kadaluarsa; ?></td>
    <td class="text-center"><?php echo $$sk; ?></td>
</tr>
<?php } ?>
<tr>
   <td style="background-color: #0d47a1; color: white;"><b><?php echo "JUMLAH KONTRAK"; ?></b></td>
   <td class="text-center" style="background-color: #0d47a1; color: white;"><b><?php echo $total;?></b></td>
</tr>

