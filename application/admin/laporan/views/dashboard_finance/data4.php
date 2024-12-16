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

    $total_td1 = 0;
    $total_td2 = 0;
    $total_td3 = 0;
    $total_td4 = 0;
    $total_td5 = 0;
    $total_td0 = 0;
?>
<?php 
    foreach ($bill as $v => $u) { ?>

        <?php
            if(isset($u['Current'])) {
                $td1 = $u['Current'];
                $current_bill += $u['Current'];
                $td0 += $u['Current'];
            }    
            if(isset($u['1-3'])) {
                $td2 = $u['1-3'];
                $_13bill = $u['1-3'];
                $td0 += $u['1-3'];
            }    
            if(isset($u['4-6'])) {
                $td3 = $u['4-6'];
                $_46bill = $u['4-6'];
                $td0 += $u['4-6'];
            }    
            if(isset($u['7-12'])) {
                $td4 = $u['7-12'];
                $_712bill = $u['7-12'];
                $td0 += $u['7-12'];
            }    
            if(isset($u['>1 Tahun'])) {
                $td5 = $u['>1 Tahun'];  
                $_12bill = $u['>1 Tahun'];
                $td0 += $u['>1 Tahun'];          
            } 

        ?>

        <tr>
            <td ><?php echo $v ;?></td>
            <td class="text-right"><?php echo custom_format($td0) ;?></td>
            <td class="text-right"><?php echo custom_format($td1) ;?></td>
            <td class="text-right"><?php echo custom_format($td2) ;?></td>
            <td class="text-right"><?php echo custom_format($td3) ;?></td>
            <td class="text-right"><?php echo custom_format($td4) ;?></td>
            <td class="text-right"><?php echo custom_format($td5) ;?></td>
        </tr>
   <?php 

    $total_td1 += $td1;
    $total_td2 += $td2;
    $total_td3 += $td3;
    $total_td4 += $td4;
    $total_td5 += $td5;
    $total_td0 += $td0;

    $td1 = 0;
    $td2 = 0;
    $td3 = 0;
    $td4 = 0;
    $td5 = 0;
    $td0 = 0;

    
   }


?>


<tr>
    <th style="background-color: #4B515D; color: white;">GRAND TOTAL </th>        
    <td style="background-color: #FF8800; color: white;" class="text-right"><?php echo custom_format($total_td0) ;?></td>
    <td style="background-color: #0d47a1; color: white;" class="text-right"><?php echo custom_format($total_td1) ;?></td>
    <td style="background-color: #00C851; color: white;" class="text-right"><?php echo custom_format($total_td2) ;?></td>
    <td style="background-color: #ffff00; color: black;" class="text-right"><?php echo custom_format($total_td3) ;?></td>
    <td style="background-color: #f44336; color: white;" class="text-right"><?php echo custom_format($total_td4) ;?></td>
    <td style="background-color: #b71c1c; color: white;" class="text-right"><?php echo custom_format($total_td5) ;?></td>
</tr>    