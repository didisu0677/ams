<h1 style="text-align: center">PROGRESS REPORT</h1>
<table style="margin-bottom: 20px;">
    <tr>
        <th>Periode</th>
        <th width="30" style="text-align: right; padding-right: 5px;">:</th>
        <td><?php echo $periode ;?></td>
    </tr>
    <tr>
        <th>Tahun</th>
        <th style="text-align: right; padding-right: 5px;">:</th>
        <td><?php echo $tahun;?></td>
    </tr>
    <tr>
        <th>Produk</th>
        <th style="text-align: right; padding-right: 5px;">:</th>
        <td><?php echo $produk;?></td>
    </tr>
</table>
<table width="100%" style="margin-bottom: 20px;">
    <tr>
        <td width="50%">
            <table class="table" width="100%" border="1">
                <thead>
                    <tr>
                        <th>Status Dokter</th>
                        <th width="30" style="text-align: center;">Jumlah</th>
                    </tr>
                </thead>
                <?php foreach($result as $k => $v) { ?>
                <tr>
                    <td><?php echo $k; ?></td>
                    <td style="text-align: center;"><?php echo count($v); ?></td>
                </tr>
                <?php } ?>
            </table>
        </td>
        <td width="50%" style="text-align: center;">
            <img src="assets/images/<?php echo user('id');?>_summary_sales_Dokter.png"/>
        </td>
    </tr>

</table>
<table class="table" width="100%" border="1">
    <thead>
        <tr>
            <th>Nama Dokter</th>
            <th>Spesialis</th>
            <th>Sales per cycle</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <?php foreach($result as $k => $v) { ?>
    <tr>
        <th colspan="11" style="background: #f9f9f9;"><?php echo $k; ?></th>
    </tr>
    <?php foreach($v as $vv) { ?>
    <tr>
        <td><?php echo $vv['nama_dokter']; ?></td>
        <td><?php echo $vv['nama_spesialis']; ?></td>
        <td><?php echo $vv['penyelesaian']; ?></td>
    	<td><?php echo $vv['status']; ?></td>    
        <td><?php echo $vv['keterangan']; ?></td>
    </tr>
    <?php } ?>
    <?php } ?>
</table>