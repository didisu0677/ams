<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_kontrak extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {

		$data['opt_klasifikasi'] = get_data('tbl_kontrak a',[
			'select'	=> 'distinct c.id as id, a.klasifikasi',
			'join'		=> ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
							'tbl_m_klasifikasi_mitra c on b.id_klasifikasi = c.id type LEFT'
			],
			'where' => [
				'a.is_active' => 1
			],
			'sort_by' => 'c.klasifikasi',
			'sort' => 'ASC'
		])->result_array();

		$data['opt_brand'] = get_data('tbl_kontrak a',[
			'select' => 'distinct b.id_brand as id, b.brand',
			'join'	 => 'tbl_m_mitra b on a.id_mitra = b.id type LEFT',
			'where' => [
				'a.is_active' => 1
			],
			'sort_by' => 'brand',
			'sort' => 'ASC'
		])->result_array();

		  
		$data['opt_skema_kerjasama'] = get_data('tbl_skema_kerjasama',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'skema_kerjasama',
			'sort' => 'ASC'
		])->result_array();

		$data['opt_kadaluarsa'] = get_data('tbl_par_kadaluarsa',[
			'where' => [
				'is_active' => 1
			],
		])->result_array();
	    render($data);
	}
	 
	function data($page = 1) {
	    $limit = 0;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.*,b.perusahaan,b.brand,c.nama_gedung,c.alamat,c.kota,d.skema_kerjasama as skema_telkom, e.skema_kerjasama as skema_mitra, a.nilai_skema_kerjasama_telkom_gsd',
	        'join'   => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
	        			'tbl_asset c on a.id_asset = c.id type LEFT',
	        			'tbl_skema_kerjasama d on a.id_skema_telkom_gsd = d.id type LEFT',
	        			'tbl_skema_kerjasama e on a.id_skema_mitra_gsd = e.id type LEFT',
	    	],
	        'where'  => [
	            'a.is_active' => 1,
	        ],
	        'order_by' => 'a.nomor_kontrak_mitra_gsd','a.nomor_kontrak_telkom_gsd',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	 	if(post('filter_klasifikasi')) {
	 		if(post('filter_klasifikasi') != 'all') {
    			$attr['where']['b.id_klasifikasi'] = post('filter_klasifikasi');
			}
		}

		if(post('filter_brand')) {
    		if(post('filter_brand') != 'all') {
    			$attr['where']['b.id_brand'] = post('filter_brand');
			}
		}

	 	if(post('filter_nomor_kontrak')) {
    		$attr['like']['a.nomor_kontrak_mitra_gsd'] = post('filter_nomor_kontrak');
		}

		if(post('filter_skema_telkom')) {
    		if(post('filter_skema_telkom') != 'all') {
    			$attr['where']['a.id_skema_telkom_gsd'] = post('filter_skema_telkom');
			}
		}

		if(post('filter_skema_mitra')) {
			if(post('filter_skema_mitra') != 'all') {
    			$attr['where']['a.id_skema_mitra_gsd'] = post('filter_skema_mitra');
			}
		}

		if(post('filter_sisa_waktu_kontrak')) {
			if(post('filter_sisa_waktu_kontrak') != 'all') {
				$d_now = date("Y-m-d");
				$time = strtotime($d_now);

				switch (post('filter_sisa_waktu_kontrak')) {
				case 1:

				  		$final1 = date("Y-m-d", strtotime("+0 month", $time));
				  		$final2 = date("Y-m-d", strtotime("-3 month", $time));
		    			$attr['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra <   DATE_ADD(now(), INTERVAL 0 MONTH))';
    				 break;
				  case 2:

				  		$final1 = date("Y-m-d", strtotime("+0 month", $time));
				  		$final2 = date("Y-m-d", strtotime("-3 month", $time));
		    			$attr['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 0 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 3 MONTH))';
    				 break;
				  case 3:
				  		$final1 = date("Y-m-d", strtotime("+3 month", $time));
				  		$final2 = date("Y-m-d", strtotime("+6 month", $time));
				    	$attr['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 3 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 6 MONTH))';
				    break;
				  case 4:
				  		$final1 = date("Y-m-d", strtotime("-6 month", $time));
				  		$final2 = date("Y-m-d", strtotime("-12 month", $time));
				    	$attr['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 6 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 12 MONTH))';

				    break;
				  case 5:
				  		$final1 = date("Y-m-d", strtotime("+12 month", $time));
				  		$final2 = date("Y-m-d", strtotime("+12 month", $time));
				    	$attr['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >"'.$final2.'")';

				} 

			}
		}



		/*
		if(post('filter_skema')) {
			if(post('filter_skema') != 'all') {
    			$attr['where']['__m'] = '( a.id_skema_telkom_gsd = "'.post('filter_skema').'" OR a.id_skema_mitra_gsd = "'.post('filter_skema').'" )';
			}
		}
		*/

	    $result = data_pagination('tbl_kontrak a',$attr,base_url('laporan/data_kontrak/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	    $data_view['jenis_aktivitas'] = get_data('tbl_m_jenis_aktivitas','is_active',1)->result();
	 	$data_view['status']  = get_data('tbl_status_aktivitas','is_active',1)->result();

	 	$cnt_mitra = 0;
	 	$cnt_telkom = 0;
	 	foreach ($result['record'] as $r => $v) {
	 		if($v['nomor_kontrak_mitra_gsd'] !='') $cnt_mitra++ ;
	 		if($v['nomor_kontrak_telkom_gsd'] !='') $cnt_telkom++ ;
	 	}

	 	$data_view['count_mitra'] = $cnt_mitra;
	 	$data_view['count_telkom'] = $cnt_telkom;

	 //	debug($data_view);die;

	    $view   = $this->load->view('laporan/data_kontrak/data',$data_view,true);
	 
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

	function detail($id='') {
		$nomor_kontrak 	= get('nomor_kontrak');

		$data				= get_data('tbl_kontrak a',[
			'select' => 'a.*,c.perusahaan,c.alamat_perusahaan,d.nama_gedung,e.skema_kerjasama as skema_kerjasama_telkom_gsd,f.skema_kerjasama as skema_kerjasama_mitra_gsd ',
				
			'join'	 => ['tbl_m_mitra c on a.id_mitra = c.id type LEFT',
					     'tbl_asset d on a.id_asset = d.id type LEFT',
					     'tbl_skema_kerjasama e on a.id_skema_telkom_gsd = e.id type LEFT',
					     'tbl_skema_kerjasama f on a.id_skema_mitra_gsd = f.id type LEFT',
						],
			'where'  => [			
				'a.nomor_kontrak_mitra_gsd' => $nomor_kontrak,
				'or a.nomor_kontrak_telkom_gsd' => $nomor_kontrak,
			],
		])->row_array();


		
		$endDate = strtotime($data['tanggal_akhir_kontrak_mitra']);
		$now = strtotime(date("Y-m-d"));

		$data['sisa_waktu_kontrak'] = floor(($endDate-$now) /(60*60*24)) ;
		$data['sisa_waktu_kontrak']	= $this->parse_waktu($data['sisa_waktu_kontrak']);

		$data['detail']	= get_data('tbl_perpanjang_kontrak a',[
			'select'	=> 'a.*',
			'where'		=> [
				'id_kontrak' => $id
				],
		])->result();

		render($data,'layout:false');
	}

	function parse_waktu($hari = 0) {
		$xx = $hari ;
		$tahun 	= floor($hari / 360);
		$hari -= ($tahun * 360);
		$bulan 	= floor($hari / 30);
		$hari -= ($bulan * 30);

		$result = [];

		if ($xx > 0) {  
			if($tahun) $result[] = $tahun.' Tahun';
			if($bulan) $result[] = $bulan.' Bulan';
			if($hari) $result[] = $hari.' Hari';
		}else{
			$result[] = "Kadaluarsa";
		}

		return implode(', ',$result);
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