<?php foreach($sub_aktivitas as $s) { ?>
<?php $sk = $s->sub_aktivitas ?>
<?php $pr = 'progress_' .$s->sub_aktivitas ?>
<tr>

    <td><?php echo $s->sub_aktivitas; ?></td>
    <td class="text-center"><?php echo $$sk; ?></td>
   	<td class="text-center"><?php echo $$pr; ?> %</td>
</tr>
<?php } ?>
<tr>
   <td style="background-color: #0d47a1; color: white;"><b><?php echo "GRAND TOTAL"; ?></b></td>
   <td class="text-center" style="background-color: #0d47a1; color: white;"><b><?php echo $TOTAL; ?></b></td>
   <td class="text-center" style="background-color: #0d47a1; color: white;"><b><?php echo $progress_TOTAL; ?> %</b></td>
</tr>
<tr>
	<td style="background-color: #ffbb33; color: white;"><b><?php echo "BATAL"; ?></b></td>
   <td class="text-center" style="background-color: #ffbb33; color: white;"><b><?php echo $batal; ?></b></td>
   <td class="text-center" style="background-color: #ffbb33; color: white;"></b></td>
</tr>	

