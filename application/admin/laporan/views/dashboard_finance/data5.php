<tr>
<td colspan="4" style="background-color: #eeeeee; color: black;">C. 4-6 Bulan</td>	
</tr>	
<?php $no =0 ; 
$piutang_bill_46 = 0;
$piutang_bill_712 = 0;
$piutang_bill_12 = 0;
?>
<?php foreach($data_bill as $s) { ?>
<?php if($s->status_current =='4-6') {?>
<?php $no++ ; 
$piutang_bill_46 = $s->piutang_bill;
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->brand; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td class="text-right"><?php echo custom_format($piutang_bill_46); ?></td>
</tr>
<?php }} ?>

<tr>
<td colspan="4" style="background-color: #eeeeee; color: black;">D. 7-12 Bulan</td>	
</tr>	
<?php $no =0 ; ?>
<?php foreach($data_bill as $s) { ?>
<?php if($s->status_current =='7-12') {?>
<?php $no++ ; 
$piutang_bill_712 = $s->piutang_bill;
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->brand; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td class="text-right"><?php echo custom_format($piutang_bill_712); ?></td>
</tr>
<?php }} ?>

<tr>
<td colspan="4" style="background-color: #eeeeee; color: black;">E. >1 Tahun</td>	
</tr>	
<?php $no =0 ; ?>
<?php foreach($data_bill as $s) { ?>
<?php if($s->status_current =='>1 Tahun') {?>
<?php $no++ ; 
$piutang_bill_12 = $s->piutang_bill;
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->brand; ?></td>
    <td><?php echo $s->nama_gedung; ?></td>
    <td class="text-right"><?php echo custom_format($piutang_bill_12); ?></td>
</tr>
?>
<?php
$piutang_bill_46 = 0;
$piutang_bill_712 = 0;
$piutang_bill_12 = 0;
}} ?>