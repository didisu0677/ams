<?php $no =0 ; ?>
<?php foreach($status_idle as $s) { ?>
<?php if($s->id_jenis_bangunan != 6 && $s->luas_bangunan > 1500) { 
$no++ ; 
if($no==1){
?>
<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
<tr>
	<th colspan="6" style="background-color: #e64a19; color: white;">LUAS AREA IDLE BANGUNAN > 1500 M2</th>		
</tr>	
<tr>
	<th style="background-color: #e64a19; color: white;">NO</th>
	<th style="background-color: #e64a19; color: white;">AREA</th>
	<th style="background-color: #e64a19; color: white;">NAMA GEDUNG</th>
	<th style="background-color: #e64a19; color: white;">KOTA</th>
	<th style="background-color: #e64a19; color: white;">ALAMAT</th>
	<th width ="150" style="background-color: #e64a19; color: white;">LUAS IDLE BANGUNAN</th>
</tr>	
</div>
<?php }?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->area; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td><?php echo $s->kota; ?></td>
    <td><?php echo $s->alamat; ?></td>
    <td class="text-right"><?php echo custom_format($s->luas_area_idle); ?></td>
</tr>
<?php }} ?>

<?php $no2 =0 ; ?>
<?php foreach($status_idle as $s) { ?>
<?php if($s->id_jenis_bangunan == 6 && $s->luas_tanah > 1500) { 
$no2++ ; 
if($no2==1){
?>
<div class="col-sm-12 pl-0 pr-0 pr-sm-2">
<tr>
	<th colspan="6" style="background-color: #e64a19; color: white;">LUAS AREA IDLE LAHAN KOSONG > 1500 M2 (YG JENIS IDLE NYA TANAH KOSONG)</th>		
</tr>	
<tr>
	<th style="background-color: #e64a19; color: white;">NO</th>
	<th style="background-color: #e64a19; color: white;">AREA</th>
	<th style="background-color: #e64a19; color: white;">NAMA GEDUNG</th>
	<th style="background-color: #e64a19; color: white;">KOTA</th>
	<th style="background-color: #e64a19; color: white;">ALAMAT</th>
	<th width ="150" style="background-color: #e64a19; color: white;">LUAS LAHAN</th>
</tr>	
</div>
<?php }?>
<tr>
    <td><?php echo $no2; ?></td>
    <td><?php echo $s->area; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td><?php echo $s->kota; ?></td>
    <td><?php echo $s->alamat; ?></td>
    <td class="text-right"><?php echo custom_format($s->luas_area_idle ); ?></td>
</tr>
<?php }} ?>