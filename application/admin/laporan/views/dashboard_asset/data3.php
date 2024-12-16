<?php $no =0 ; ?>
<?php foreach($status_tanah as $s) { ?>

<tr>
	<td colspan="11"><?php echo $s->status_tanah ;?></td>
	<?php
	foreach($detail_status_tanah as $d) { 
		$d_now = date("Y-m-d");
		$time = strtotime($d_now);

		$final1 = date("Y-m-d", strtotime("+1 year", $time));
		$final2 = date("Y-m-d", strtotime("+2 year", $time));
		$final2 = date("Y-m-d", strtotime("+3 year", $time));

		if($d->status_tanah == $s->status_tanah) {
			if($d->masa_berlaku_surat_tanah <= $d_now) {
				?>
					<tr>
					<td colspan=""></td> 	
					<td colspan="">EXPIRE</td> 
					<td colspan=""><?php echo $d->nama_gedung ; ?></td> 
					<td colspan=""><?php echo $d->alamat ; ?></td>
					<td colspan=""><?php echo $d->kota ; ?></td>
					<td colspan=""><?php echo date_indo($d->masa_berlaku_surat_tanah) ; ?></td>  
					<td colspan="" class="text-right"><?php echo custom_format($d->luas_tanah) ; ?></td> 
					<td colspan=""><?php echo $d->bentuk_tanah ; ?></td> 
					<td colspan=""><?php echo $d->LXP_tanah ; ?></td>  
					<td colspan=""><?php echo $d->area ; ?></td>  
					<td colspan=""><?php echo $d->facility_management ; ?></td>    
					</tr>
				<?php	
			}elseif ($d->masa_berlaku_surat_tanah > $d_now and $d->masa_berlaku_surat_tanah <= $final1) {
				?>
					<tr>
					<td colspan=""></td> 	
					<td colspan="">AKTIF < 1 TAHUN</td> 
					<td colspan=""><?php echo $d->nama_gedung ; ?></td> 
					<td colspan=""><?php echo $d->alamat ; ?></td>
					<td colspan=""><?php echo $d->kota ; ?></td>
					<td colspan=""><?php echo date_indo($d->masa_berlaku_surat_tanah) ; ?></td>  
					<td colspan="" class="text-right"><?php echo custom_format($d->luas_tanah) ; ?></td> 
					<td colspan=""><?php echo $d->bentuk_tanah ; ?></td> 
					<td colspan=""><?php echo $d->LXP_tanah ; ?></td>  
					<td colspan=""><?php echo $d->area ; ?></td>  
					<td colspan=""><?php echo $d->facility_management ; ?></td>    
					</tr>
				<?php	
			}elseif ($d->masa_berlaku_surat_tanah > $final1 and $d->masa_berlaku_surat_tanah <= $final2) {
				?>
					<tr>
					<td colspan=""></td> 	
					<td colspan="">AKTIF < 2 TAHUN</td> 
					<td colspan=""><?php echo $d->nama_gedung ; ?></td> 
					<td colspan=""><?php echo $d->alamat ; ?></td>
					<td colspan=""><?php echo $d->kota ; ?></td>
					<td colspan=""><?php echo date_indo($d->masa_berlaku_surat_tanah) ; ?></td>  
					<td colspan="" class="text-right"><?php echo custom_format($d->luas_tanah) ; ?></td> 
					<td colspan=""><?php echo $d->bentuk_tanah ; ?></td> 
					<td colspan=""><?php echo $d->LXP_tanah ; ?></td>  
					<td colspan=""><?php echo $d->area ; ?></td>  
					<td colspan=""><?php echo $d->facility_management ; ?></td>    
					</tr>
				<?php	
			}elseif ($d->masa_berlaku_surat_tanah > $final2 and $d->masa_berlaku_surat_tanah <= $final3) {
					?>
					<tr>
					<td colspan=""></td> 	
					<td colspan="">AKTIF < 3 TAHUN</td> 
					<td colspan=""><?php echo $d->nama_gedung ; ?></td> 
					<td colspan=""><?php echo $d->alamat ; ?></td>
					<td colspan=""><?php echo $d->kota ; ?></td>
					<td colspan=""><?php echo date_indo($d->masa_berlaku_surat_tanah) ; ?></td>  
					<td colspan="" class="text-right"><?php echo custom_format($d->luas_tanah) ; ?></td> 
					<td colspan=""><?php echo $d->bentuk_tanah ; ?></td> 
					<td colspan=""><?php echo $d->LXP_tanah ; ?></td>  
					<td colspan=""><?php echo $d->area ; ?></td>  
					<td colspan=""><?php echo $d->facility_management ; ?></td>    
					</tr>
				<?php	
			}
		}
	}

	?>

</tr>

<?php } ?>
