<div class="content-header">
    <div class="main-container position-relative">
        <div class="header-info">
            <div class="content-title"><?php echo $title; ?></div>
            <?php echo breadcrumb(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="content-body">
    <div class="table-responsive">
    <table id="result" class="table table-bordered table-detail table-grid table mb-0">
            <thead>
                <tr>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">FACILITY MANAGEMENT</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">NAMA GEDUNG</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">ALAMAT</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">KOTA</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">BRAND</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">KLASIFIKASI</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">PERUSAHAAN</th>
                    <th style="background-color: #3F729B; color: white;" rowspan="3" class="text-center align-middle">PENANGGUNG JAWAB MITRA</th>
                    <?php foreach($grup_aktivitas as $g) { ?>
                        <?php
                            if ($g->id == 1){
                                $colspan = 16;
                            }elseif ($g->id ==2) {
                                $colspan = 12;
                            }else{
                                $colspan = 8;
                            }
                        ?>
                        <th style="text-align:center; background-color: #3F729B; color: white" colspan ="<?php echo $colspan ?>"><?php echo strtoupper($g->grup_aktivitas); ?></th>
                    <?php } ?>
                    <th style="text-align:center; background-color: #3F729B; color: white" rowspan="3" class="text-center align-middle">PROGRESS</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" rowspan="3" class="text-center align-middle">TAHAPAN</th>
                </tr>
                <tr>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="2">PERENCANAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="11">PROSES</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="3">PELAKSANAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="11">PROSES</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="1">PELAKSANAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="2">PERENCANAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="3">PROSES</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="2">PELAKSANAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white" colspan ="1">KOMERSIAL</th>
                </tr>  
                <tr>
                    <?php foreach($jenis_aktivitas as $p) { ?>
                        <th style="text-align:center; background-color: #3F729B; color: white" class="text-center align-middle"><?php echo strtoupper($p->nama_aktivitas); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody></tbody>

    </table>
            </div>
    <div id="pagination" class="p-2"></div>
</div>
     
<div class="filter-panel">
	<div class="filter-body">
		<?php
			form_open('','','form-filter');
				col_init(12,12);
				input('nama_gedung','NAMA GEDUNG','filter_nama_gedung');
            form_close();
       ?>
       </div>
</div>
    

<script type="text/javascript">
var xhr_ajax = null;
$(document).ready(function(){
    loadData();
});
$('#pagination').on('click','a',function(e){
    e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    loadData(pageNum);
});
function loadData(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax != null ) {
        xhr_ajax.abort();
        xhr_ajax = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'manajemen_aset/view_aktivitas/data/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
            if(res.pagination) {
                $('#pagination').html(res.pagination);
            } else {
                $('#pagination').html('');
            }
            $('#result tbody').html(res.data);
            gridTable();
        }
    });
}

$('#form-filter input').keyup(function(){
    loadData();
});


$('#form-filter select').change(function() {
    loadData();
});

</script>