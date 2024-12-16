<?php
	$td1 = 0;
	$td2 = 0;
	$td3 = 0;
	$td4 = 0;
	$td5 = 0;
	$td0 = 0;
    $total_bill =0;
    $current_bill =0;
    $_13bill =0;
    $_46bill =0;
    $_712bill =0;
    $_12bill =0;
?>
<?php foreach($mitra_bill as $u) { ?>
<?php 
    foreach ($data_bill as $v) {
    	if($u->id_mitra == $v->id_mitra && $v->status_current == 'Current') {
    		$td1 = $v->piutang_bill;
            $current_bill += $v->piutang_bill;   
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '1-3') {
    		$td2 = $v->piutang_bill;
            $_13bill += $v->piutang_bill;
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '4-6') {
    		$td3 = $v->piutang_bill;
            $_46bill += $v->piutang_bill;
    	}
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '7-12') {
    		$td4 = $v->piutang_bill;
    	    $_712bill += $v->piutang_bill;
        }
    	if($u->id_mitra == $v->id_mitra && $v->status_current == '>1 Tahun') {
    		$td5 = $v->piutang_bill;
            $_12bill += $v->piutang_bill;
    	}

    	if($u->id_mitra == $v->id_mitra) {
    		$td0 += $v->piutang_bill;
            $total_bill += $v->piutang_bill;
    	}
    }


?>
<tr>
    <td class="text-right"><?php echo $u->brand ;?></td>
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
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($total_bill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($current_bill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_13bill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_46bill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_712bill) ; ?></td>
    <td style="background-color: #4B515D; color: white;" class="text-right"><?php echo custom_format($_12bill) ; ?></td>
</tr>    