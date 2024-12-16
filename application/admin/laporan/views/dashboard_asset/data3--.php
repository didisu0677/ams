<?php $no =0 ; ?>
<?php foreach($status_tanah as $s) { ?>

<tr>
	<td colspan="11"><?php echo $s->status_tanah ;?></td>
</tr>
<tr>
	<td></td>
	<td colspan="">EXPIRE</td>
		<?php foreach($detail_status_tanah as $d) { ?>
<?php if ($s->status_tanah == $d->status_tanah && $d->masa_berlaku_surat_tanah <= date("Y-m-d"))  { ?>
	<?php $no++ ; 
?>
		<td colspan=""><?php echo$d->nama_gedung ; ?></td> 
		<td colspan=""><?php echo$d->alamat ; ?></td>
		<td colspan=""><?php echo$d->kota ; ?></td>
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td>  
		<td colspan=""><?php echo$d->luas_tanah ; ?></td> 
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td> 
		<td colspan=""><?php echo$d->LXP_tanah ; ?></td>  
		<td colspan=""><?php echo$d->area ; ?></td>  
		<td colspan=""><?php echo$d->facility_management ; ?></td>      
<?php }}?>	
</tr>	
<tr>
	<td></td>
	<td colspan="">AKTIF < 1 TAHUN</td>	
	<?php
		$d_now = date("Y-m-d");
		$time = strtotime($d_now);

		$final1 = date("Y-m-d", strtotime("+1 year", $time));

	?>
		<?php foreach($detail_status_tanah as $d) { ?>
		<?php if ($s->status_tanah == $d->status_tanah && $d->masa_berlaku_surat_tanah > date("Y-m-d") && $d->masa_berlaku_surat_tanah <= $final1)  { ?>
			<?php $no++ ; 
		?>

		<td colspan=""><?php echo$d->nama_gedung ; ?></td> 
		<td colspan=""><?php echo$d->alamat ; ?></td>
		<td colspan=""><?php echo$d->kota ; ?></td>
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td>  
		<td colspan=""><?php echo$d->luas_tanah ; ?></td> 
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td> 
		<td colspan=""><?php echo$d->LXP_tanah ; ?></td>  
		<td colspan=""><?php echo$d->area ; ?></td>  
		<td colspan=""><?php echo$d->facility_management ; ?></td>      
		<?php 
		//
		}

	}?>	
</tr>	
<tr>
	<td></td>
	<td colspan="">AKTIF < 2 TAHUN</td>	
		<?php
		$d_now = date("Y-m-d");
		$time = strtotime($d_now);

		$final1 = date("Y-m-d", strtotime("+1 year", $time));
		$final2 = date("Y-m-d", strtotime("+2 year", $time));

	?>
		<?php foreach($detail_status_tanah as $d) { ?>
		<?php if ($s->status_tanah == $d->status_tanah && $d->masa_berlaku_surat_tanah > $final1 && $d->masa_berlaku_surat_tanah <= $final2)  { ?>
			<?php $no++ ; 
		?>

		<td colspan=""><?php echo$d->nama_gedung ; ?></td> 
		<td colspan=""><?php echo$d->alamat ; ?></td>
		<td colspan=""><?php echo$d->kota ; ?></td>
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td>  
		<td colspan=""><?php echo$d->luas_tanah ; ?></td> 
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td> 
		<td colspan=""><?php echo$d->LXP_tanah ; ?></td>  
		<td colspan=""><?php echo$d->area ; ?></td>  
		<td colspan=""><?php echo$d->facility_management ; ?></td>      
		<?php 
		//
		}
		//

	}?>	
</tr>	
<tr>
	<td></td>
	<td colspan="">AKTIF < 3 TAHUN</td>	
		<?php
		$d_now = date("Y-m-d");
		$time = strtotime($d_now);

		$final1 = date("Y-m-d", strtotime("+2 year", $time));
		$final2 = date("Y-m-d", strtotime("+5 year", $time));

	?>
		<?php foreach($detail_status_tanah as $d) { ?>
		<?php if ($s->status_tanah == $d->status_tanah && $d->masa_berlaku_surat_tanah > $final1 && $d->masa_berlaku_surat_tanah <= $final2)  { ?>
			<?php $no++ ; 
		?>

		<td colspan=""><?php echo$d->nama_gedung ; ?></td> 
		<td colspan=""><?php echo$d->alamat ; ?></td>
		<td colspan=""><?php echo$d->kota ; ?></td>
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td>  
		<td colspan=""><?php echo$d->luas_tanah ; ?></td> 
		<td colspan=""><?php echo$d->masa_berlaku_surat_tanah ; ?></td> 
		<td colspan=""><?php echo$d->LXP_tanah ; ?></td>  
		<td colspan=""><?php echo$d->area ; ?></td>  
		<td colspan=""><?php echo$d->facility_management ; ?></td>      
		<?php 
		//
		}

	}?>	
</tr>	
<?php } ?>
