<?php
	$td1 = 0;
	$td2 = 0;
	$td3 = 0;
	$td4 = 0;
	$td5 = 0;
	$td0 = 0;
    $total_unbill =0;
    $current_unbill =0;
    $_13unbill =0;
    $_46unbill =0;
    $_712unbill =0;
    $_12unbill =0;
?>
<?php foreach($mitra_unbill as $u) { ?>
<?php 
    foreach ($data_unbill as $v) {
    	if($u->id_mitra == $v->id_mitra && $v->status_current == 'Current') {
    		$td1 = $v->piutang_unbill;
            $current_unbill += $v->piutang_unbill;
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '1-3') {
    		$td2 = $v->piutang_unbill;
            $_13unbill = $v->piutang_unbill;            
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '4-6') {
    		$td3 = $v->piutang_unbill;
            $_46unbill = $v->piutang_unbill;
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '7-12') {
    		$td4 = $v->piutang_unbill;
            $_712unbill = $v->piutang_unbill;
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '>1 Tahun') {
    		$td5 = $v->piutang_unbill;
            $_12unbill = $v->piutang_unbill;            
    	}

    	if($u->id_mitra == $v->id_mitra) {
    		$td0 += $v->piutang_unbill;
            $total_unbill += $v->piutang_unbill;
    	}
    }


?>
<tr>
    <td ><?php echo $u->brand ;?></td>
    <td class="text-right"><?php echo custom_format($td0) ;?></td>
    <td class="text-right"><?php echo custom_format($td1) ;?></td>
    <td class="text-right"><?php echo custom_format($td2) ;?></td>
    <td class="text-right"><?php echo custom_format($td3) ;?></td>
    <td class="text-right"><?php echo custom_format($td4) ;?></td>
    <td class="text-right"><?php echo custom_format($td5) ;?></td>
</tr>
<?php
	$td1 = 0;
	$td2 = 0;
	$td3 = 0;
	$td4 = 0;
	$td5 = 0;
	$td0 = 0;
?>

<?php } ?>
<tr>
    <th style="background-color: #4B515D; color: white;">GRAND TOTAL </th>        
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($total_unbill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($current_unbill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_13unbill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_46unbill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_712unbill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_12unbill) ; ?></td>
</tr>    