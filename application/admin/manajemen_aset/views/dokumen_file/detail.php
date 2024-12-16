<div class="card-body table-responsive">
    <table class="table table-bordered table-app table-detail table-normal">
        <tr>
            <th width="200"><?php echo lang('nomor_dokumen'); ?></th>
            <td colspan="3"><?php echo $nomor_dokumen; ?></td>
        </tr>
        <tr>
            <th><?php echo lang('nama_dokumen'); ?></th>
            <td colspan="3"><?php echo $nama_dokumen; ?></td>
        </tr>
        <tr>
            <th><?php echo lang('last_update'); ?></th>
            <td colspan="3"><?php echo date_indo($update_at) . ($update_by !="" ? ' oleh : ' : "") . $update_by; ?></td>
        </tr>
        <tr>
            <th><?php echo lang('file'); ?></th>
            <td colspan="3">
                <ul class="pl-3 mb-0">
                    <?php
                    foreach(json_decode($file,true) as $k => $v) {
                        echo '<li><a href="'.base_url('assets/uploads/dokumen_file/'.$v).'" target="_blank">'.$k.'</a></li>';
                    }
                    ?>
                </ul>    
            </td>
        </tr>
    </table>
</div>
