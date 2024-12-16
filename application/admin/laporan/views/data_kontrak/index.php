<div class="content-header">
    <div class="main-container position-relative">
        <div class="header-info">
            <div class="content-title"><?php echo $title; ?></div>
            <?php echo breadcrumb(); ?>
        </div>
        <div class="float-right">
            <?php echo access_button(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="content-body">
    <div class="table-responsive">
    <table id="result" class="table table-bordered table-detail table-grid mb-0">
            <thead>
                <tr>
                    <th style="text-align:center; background-color: #3F729B; color: white;">NO.</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">KLASIFIKASI</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">BRAND</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">PERUSAHAAN</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">LOCATION</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">ALAMAT</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">KOTA</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">NOMOR KONTRAK</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">TANGGAL KONTRAK</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">DURASI KONTRAK</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">SISA WAKTU KONTRAK</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">SKEMA KERJASAMA</th>
                    <th style="text-align:center; background-color: #3F729B; color: white;">NILAI KERJASAMA</th>
                </tr>

            </thead>
            <tbody></tbody>
    </table>    
    </div>
</div>

<div class="filter-panel">
    <div class="filter-body">
        <?php
            form_open('','','form-filter');
                col_init(12,12);

                    select2('KLASIFIKASI','filter_klasifikasi','all',$opt_klasifikasi,'id','klasifikasi');

                    select2('BRAND','filter_brand','all',$opt_brand,'id','brand');
                    input('nomor_kontrak_mitra_gsd','NOMOR KONTRAK-MITRA','filter_nomor_kontrak');

                    select2('SKEMA KERJASAMA TELKOM','filter_skema_telkom','all',$opt_skema_kerjasama,'id','skema_kerjasama');

                    select2('SKEMA KERJASAMA MITRA','filter_skema_mitra','all',$opt_skema_kerjasama,'id','skema_kerjasama');

                    select2('SISA WAKTU KONTRAK','filter_sisa_waktu_kontrak','all',$opt_kadaluarsa,'id','parameter_kadaluarsa');
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
        url: base_url + 'laporan/data_kontrak/data/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
            $('#result tbody').html(res.data);
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