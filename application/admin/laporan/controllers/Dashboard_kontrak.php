<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_kontrak extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['aktivitas']	= get_data('tbl_m_aktivitas','is_active',1)->result_array();

		render($data);
	}

	function data($page = 1) {
	    $limit = 0;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.*',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	    $result = data_pagination('tbl_kontrak a',$attr,base_url('laporan/dashboard_kontrak/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	 	$data_view['sisa_waktu']  = get_data('tbl_par_kadaluarsa',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	 	$data_view['skema']  = get_data('tbl_kontrak a',[
	 		'select' => 'a.id_skema_mitra_gsd,b.skema_kerjasama, count(a.id_skema_mitra_gsd) as jumlah',
	 		'join'	 => 'tbl_skema_kerjasama b on a.id_skema_mitra_gsd = b.id type LEFT',  
	 		'where' => [
	 			'a.is_active' => 1,
	 			'a.nomor_kontrak_mitra_gsd !=' => '',	 			 
	 		],
	 		'group_by' => 'a.id_skema_mitra_gsd'
	 	])->result();

	    $attr_1 = [
	        'select' => 'count(a.id) as jumlah',
	        'where' => [
	        	'a.is_active' => 1
	        ],
	    ];

	    $jumlah = [];
	    $data_view['total'] = 0;
 		foreach ($data_view['sisa_waktu'] as $s) {
 			$jumlah[$s->id] = 0 ;

 			$data_view['par_' . $s->id] = 0;
 			switch ($s->id) {
			case 1:
	    			$attr_1['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra <   DATE_ADD(now(), INTERVAL 0 MONTH))';
	    			$result_sw = get_data('tbl_kontrak a',$attr_1)->row();
	    			$jumlah[$s->id] = $result_sw->jumlah ;
	    			$data_view['par_' . $s->id] = $result_sw->jumlah;
				 break;
			  case 2:
	    			$attr_1['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 0 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 3 MONTH))';
	    			$result_sw = get_data('tbl_kontrak a',$attr_1)->row();
	    			$jumlah[$s->id] = $result_sw->jumlah ;
	    			$data_view['par_' . $s->id] = $result_sw->jumlah;
				 break;
			  case 3:
			    	$attr_1['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 3 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 6 MONTH))';
			    	$result_sw = get_data('tbl_kontrak a',$attr_1)->row();
			    	$jumlah[$s->id] = $result_sw->jumlah ;
	    			$data_view['par_' . $s->id] = $result_sw->jumlah;
			    break;
			  case 4:
			    	$attr_1['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 6 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 12 MONTH))';
			    	$result_sw = get_data('tbl_kontrak a',$attr_1)->row();
			    	$jumlah[$s->id] = $result_sw->jumlah ;
	    			$data_view['par_' . $s->id] = $result_sw->jumlah;
			    break;
			  case 5:
			    	$attr_1['where']['__m'] = '(a.tanggal_akhir_kontrak_mitra > DATE_ADD(now(), INTERVAL 12 MONTH))';
			    	$result_sw = get_data('tbl_kontrak a',$attr_1)->row();
			    	$jumlah[$s->id] = $result_sw->jumlah ;
	    			$data_view['par_' . $s->id] = $result_sw->jumlah;
			} 
			$data_view['total'] += $data_view['par_' . $s->id] ;
 		}

 		$data_view['data_expire']  = get_data('tbl_kontrak a',[
	 		'where' => [
	 			'is_active' => 1,
	 			'__m' 		=> '(a.tanggal_akhir_kontrak_mitra <   DATE_ADD(now(), INTERVAL 0 MONTH))',
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	    $view   = $this->load->view('laporan/dashboard_kontrak/data',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'sisa_waktu'	=> $data_view['sisa_waktu'],
	        'skema_kerjasama'	=> $data_view['skema'],
	        'jumlah'		=> $jumlah,
	        'expire'		=> $data_view['data_expire'],
	    ];

	    render($data,'json');
	}

	function data2($page = 1) {
	    $limit = 0;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.*',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	    $result = data_pagination('tbl_kontrak a',$attr,base_url('laporan/dashboard_kontrak/data2/'),4);
	 
	    $data_view['record']    = $result['record'];
	 	$data_view['sisa_waktu']  = get_data('tbl_par_kadaluarsa',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	

 		$data_view['data_expire2']  = get_data('tbl_kontrak a',[
 			'select' => 'a.*,b.perusahaan,b.brand,c.nama_gedung',
 			'join'	 => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
 						'tbl_asset c on a.id_asset = c.id type LEFT'
 			], 
	 		'where' => [
	 			'a.is_active' => 1,
	 			'__m' 		=> '(a.tanggal_akhir_kontrak_mitra <   DATE_ADD(now(), INTERVAL 0 MONTH))',
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	    $view   = $this->load->view('laporan/dashboard_kontrak/data2',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'expire2'		=> $data_view['data_expire2'],
	    ];

	    render($data,'json');
	}

	function data3($page = 1) {
	    $limit = 0;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.*',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	    $result = data_pagination('tbl_kontrak a',$attr,base_url('laporan/dashboard_kontrak/data3/'),4);
	 
	    $data_view['record']    = $result['record'];
	 	$data_view['sisa_waktu']  = get_data('tbl_par_kadaluarsa',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	

 		$data_view['data_expire3']  = get_data('tbl_kontrak a',[
 			'select' => 'a.*,b.perusahaan,b.brand,c.nama_gedung',
 			'join'	 => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
 						'tbl_asset c on a.id_asset = c.id type LEFT'
 			], 
	 		'where' => [
	 			'a.is_active' => 1,
	 			'__m' 		=> '(a.tanggal_akhir_kontrak_mitra >=  DATE_ADD(now(), INTERVAL 0 MONTH) and a.tanggal_akhir_kontrak_mitra <= DATE_ADD(now(), INTERVAL 3 MONTH))',
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	    $view   = $this->load->view('laporan/dashboard_kontrak/data3',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'expire3'		=> $data_view['data_expire3'],
	    ];

	    render($data,'json');
	}

}