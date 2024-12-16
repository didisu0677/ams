<?php 
$jumlah_ok = 0;
$jumlah_blm = 0;
$jumlah_ps = 0;
$jumlah_tdl = 0;
$progress = 0;
foreach($grup_aktivitas as $g) { ?>
<tr>
    <td><?php echo $g->grup_alias; ?></td>
    <?php 
    	if($g->grup_alias == 'TELKOM PROPERTY') $jumlah_ok = $PROPERTY_OK;  
    	if($g->grup_alias == 'TELKOM') $jumlah_ok = $TELKOM_OK ;
    	if($g->grup_alias == 'MITRA') $jumlah_ok = $MITRA_OK ;  
    ?>
	<td class="text-center"><?php echo $jumlah_ok; ?></td>  
	<?php 
    	if($g->grup_alias == 'TELKOM PROPERTY') $jumlah_blm = $PROPERTY_BLM;  
    	if($g->grup_alias == 'TELKOM') $jumlah_blm = $TELKOM_BLM ;
    	if($g->grup_alias == 'MITRA') $jumlah_blm = $MITRA_BLM ;  
    ?>

   	<td class="text-center"><?php echo $jumlah_blm; ?></td>
   	<?php 
    	if($g->grup_alias == 'TELKOM PROPERTY') $jumlah_ps = $PROPERTY_PS;  
    	if($g->grup_alias == 'TELKOM') $jumlah_ps = $TELKOM_PS ;
    	if($g->grup_alias == 'MITRA') $jumlah_ps = $MITRA_PS ;  
    ?>
   	<td class="text-center"><?php echo $jumlah_ps; ?></td>
   	<?php 
    	if($g->grup_alias == 'TELKOM PROPERTY') $jumlah_tdl = $PROPERTY_TDL;  
    	if($g->grup_alias == 'TELKOM') $jumlah_tdl = $TELKOM_TDL ;
    	if($g->grup_alias == 'MITRA') $jumlah_tdl = $MITRA_TDL ;  
    ?>
   	<td class="text-center"><?php echo $jumlah_tdl; ?></td>

   	<?php 
    	if($g->grup_alias == 'TELKOM PROPERTY') $progress = $progress_PROPERTY;  
    	if($g->grup_alias == 'TELKOM') $progress = $progress_TELKOM ;
    	if($g->grup_alias == 'MITRA') $progress = $progress_MITRA ;  
    ?>
   	<td class="text-center"><?php echo $progress; ?> %</td>
</tr>
<?php } ?>


