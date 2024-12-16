<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View_aktivitas extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
	    $data['jenis_aktivitas'] = get_data('tbl_m_jenis_aktivitas','is_active',1)->result();
	    $data['grup_aktivitas'] = get_data('tbl_grup_aktivitas','is_active',1)->result();
	    render($data);
	}
	 
	function data($page = 1) {
	    $limit = 10;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.*,b.facility_management,c.sub_aktivitas as tahapan',
	        'join'   => ['tbl_m_facility_management b on a.id_fm = b.id',
	        			 'tbl_sub_aktivitas c on a.id_tahapan = c.id type LEFT'
	    	],
	        'where'  => [
	            'a.is_active' => 1,
	        ],
	        'limit' => $limit,
	        'offset' => $page
	    ];

	 	if(post('filter_nama_gedung')) {
    		$attr['like']['a.nama_gedung'] = post('filter_nama_gedung');
		}

	    $result = data_pagination('tbl_m_aktivitas a',$attr,base_url('manajemen_aset/view_aktivitas/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	    $data_view['jenis_aktivitas'] = get_data('tbl_m_jenis_aktivitas','is_active',1)->result();
	 	$data_view['status']  = get_data('tbl_status_aktivitas','is_active',1)->result();

	    $view   = $this->load->view('manajemen_aset/view_aktivitas/data',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'pagination'    => $result['pagination']
	    ];

	    render($data,'json');
	}


	function get_data() {
		$data = get_data('tbl_m_aktivitas','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_m_aktivitas',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_aktivitas','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['nomor_aktivitas' => 'nomor_aktivitas','id_fm' => 'id_fm','id_asset' => 'id_asset','nama_gedung' => 'nama_gedung','alamat' => 'alamat','kota' => 'kota','id_mitra' => 'id_mitra','brand' => 'brand','klasifikasi' => 'klasifikasi','perusahaan' => 'perusahaan','penanggung_jawab_mitra' => 'penanggung_jawab_mitra','pembuatan_propar' => 'pembuatan_propar','penawaran_mitra' => 'penawaran_mitra','approval_manajemen' => 'approval_manajemen','pembuatan_aki' => 'pembuatan_aki','kesepakatan_gsd_mitra' => 'kesepakatan_gsd_mitra','bak_gsd_mitra' => 'bak_gsd_mitra','pks_gsd_mitra' => 'pks_gsd_mitra','juskeb_konsultan' => 'juskeb_konsultan','pengadaan_konsultan' => 'pengadaan_konsultan','desain_dan_rab' => 'desain_dan_rab','perizinan' => 'perizinan','juskeb_kontraktor' => 'juskeb_kontraktor','pengadaan_kontraktor' => 'pengadaan_kontraktor','konstruksi_dan_fo' => 'konstruksi_dan_fo','bast_lahan_mitra' => 'bast_lahan_mitra','baso_gsd_telkom' => 'baso_gsd_telkom','sertifikat' => 'sertifikat','ba_acceptance' => 'ba_acceptance','relokasi' => 'relokasi','owner_estimate' => 'owner_estimate','kesepakatan_telkom_gsd' => 'kesepakatan_telkom_gsd','justifikasi_inisiatif_bisnis' => 'justifikasi_inisiatif_bisnis','bak_telkom_gsd' => 'bak_telkom_gsd','pks_telkom_gsd' => 'pks_telkom_gsd','approval_demolish' => 'approval_demolish','pelaksanaan_demolish' => 'pelaksanaan_demolish','surat_pernyataan_bersama' => 'surat_pernyataan_bersama','bast_lahan_gsd' => 'bast_lahan_gsd','assesment_lokasi' => 'assesment_lokasi','letter_of_interest' => 'letter_of_interest','business_plan_mitra' => 'business_plan_mitra','prelim_budget_est' => 'prelim_budget_est','approval_desain' => 'approval_desain','kontruksi_dan_fo' => 'kontruksi_dan_fo','perizinan_operasional' => 'perizinan_operasional','komersial' => 'komersial','status_terakhir' => 'status_terakhir','next_action' => 'next_action','support_needed' => 'support_needed','progress' => 'progress','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_view_aktivitas',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nomor_aktivitas','id_fm','id_asset','nama_gedung','alamat','kota','id_mitra','brand','klasifikasi','perusahaan','penanggung_jawab_mitra','pembuatan_propar','penawaran_mitra','approval_manajemen','pembuatan_aki','kesepakatan_gsd_mitra','bak_gsd_mitra','pks_gsd_mitra','juskeb_konsultan','pengadaan_konsultan','desain_dan_rab','perizinan','juskeb_kontraktor','pengadaan_kontraktor','konstruksi_dan_fo','bast_lahan_mitra','baso_gsd_telkom','sertifikat','ba_acceptance','relokasi','owner_estimate','kesepakatan_telkom_gsd','justifikasi_inisiatif_bisnis','bak_telkom_gsd','pks_telkom_gsd','approval_demolish','pelaksanaan_demolish','surat_pernyataan_bersama','bast_lahan_gsd','assesment_lokasi','letter_of_interest','business_plan_mitra','prelim_budget_est','approval_desain','kontruksi_dan_fo','perizinan_operasional','komersial','status_terakhir','next_action','support_needed','progress','is_active'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);
					$data['create_at'] = date('Y-m-d H:i:s');
					$data['create_by'] = user('nama');
					$save = insert_data('tbl_m_aktivitas',$data);
					if($save) $c++;
				}
			}
		}
		$response = [
			'status' => 'success',
			'message' => $c.' '.lang('data_berhasil_disimpan').'.'
		];
		@unlink($file);
		render($response,'json');
	}

	function export() {
		ini_set('memory_limit', '-1');
		$arr = ['nomor_aktivitas' => 'Nomor Aktivitas','id_fm' => 'Id Fm','id_asset' => 'Id Asset','nama_gedung' => 'Nama Gedung','alamat' => 'Alamat','kota' => 'Kota','id_mitra' => 'Id Mitra','brand' => 'Brand','klasifikasi' => 'Klasifikasi','perusahaan' => 'Perusahaan','penanggung_jawab_mitra' => 'Penanggung Jawab Mitra','pembuatan_propar' => 'Pembuatan Propar','penawaran_mitra' => 'Penawaran Mitra','approval_manajemen' => 'Approval Manajemen','pembuatan_aki' => 'Pembuatan Aki','kesepakatan_gsd_mitra' => 'Kesepakatan Gsd Mitra','bak_gsd_mitra' => 'Bak Gsd Mitra','pks_gsd_mitra' => 'Pks Gsd Mitra','juskeb_konsultan' => 'Juskeb Konsultan','pengadaan_konsultan' => 'Pengadaan Konsultan','desain_dan_rab' => 'Desain Dan Rab','perizinan' => 'Perizinan','juskeb_kontraktor' => 'Juskeb Kontraktor','pengadaan_kontraktor' => 'Pengadaan Kontraktor','konstruksi_dan_fo' => 'Konstruksi Dan Fo','bast_lahan_mitra' => 'Bast Lahan Mitra','baso_gsd_telkom' => 'Baso Gsd Telkom','sertifikat' => 'Sertifikat','ba_acceptance' => 'Ba Acceptance','relokasi' => 'Relokasi','owner_estimate' => 'Owner Estimate','kesepakatan_telkom_gsd' => 'Kesepakatan Telkom Gsd','justifikasi_inisiatif_bisnis' => 'Justifikasi Inisiatif Bisnis','bak_telkom_gsd' => 'Bak Telkom Gsd','pks_telkom_gsd' => 'Pks Telkom Gsd','approval_demolish' => 'Approval Demolish','pelaksanaan_demolish' => 'Pelaksanaan Demolish','surat_pernyataan_bersama' => 'Surat Pernyataan Bersama','bast_lahan_gsd' => 'Bast Lahan Gsd','assesment_lokasi' => 'Assesment Lokasi','letter_of_interest' => 'Letter Of Interest','business_plan_mitra' => 'Business Plan Mitra','prelim_budget_est' => 'Prelim Budget Est','approval_desain' => 'Approval Desain','kontruksi_dan_fo' => 'Kontruksi Dan Fo','perizinan_operasional' => 'Perizinan Operasional','komersial' => 'Komersial','status_terakhir' => 'Status Terakhir','next_action' => 'Next Action','support_needed' => 'Support Needed','progress' => 'Progress','is_active' => 'Aktif'];
		$data = get_data('tbl_m_aktivitas')->result_array();
		$config = [
			'title' => 'data_view_aktivitas',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}