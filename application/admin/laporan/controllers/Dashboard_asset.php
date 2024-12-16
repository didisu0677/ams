<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_asset extends BE_Controller {

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


	    $result = data_pagination('tbl_asset a',$attr,base_url('laporan/dashboard_asset/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	    $a = 0 ;
	    foreach ($data_view['record'] as $r) {
	    	$a++;
	    }

	 	$data_view['skema']  = get_data('tbl_asset a',[
	 		'select' => 'a.id_skema_kerjasama,c.skema_kerjasama, count(a.id_skema_kerjasama) as jumlah',
	 		'join'	 => ['tbl_skema_kerjasama c on a.id_skema_kerjasama = c.id type INNER',
	 				],  
	 		'where' => [
	 			'a.is_active' => 1,	 
	 		],
	 		'group_by' => 'a.id_skema_kerjasama'
	 	])->result();


	 	$prsn_skema = [];
	 	foreach ($data_view['skema'] as $skm) {
	 		$prsn_skema[$skm->id_skema_kerjasama] = round(($skm->jumlah/$a) * 100,2);
	 	}

	 	$data_view['status_surat']  = get_data('tbl_asset a',[
	 		'select' => 'a.status_tanah, count(a.status_tanah) as jumlah',
	 		'where' => [
	 			'a.is_active' => 1,	
	 		],
	 		'group_by' => 'a.status_tanah'
	 	])->result();

	 	$prsn_ssurat = [];
	 	foreach ($data_view['status_surat'] as $status) {
	 		$prsn_ssurat[$status->status_tanah] = round(($status->jumlah/$a) * 100,2);
	 	}

	 	$data_view['tipe_asset']  = get_data('tbl_asset a',[
	 		'select' => 'a.id_tipe_asset, b.tipe_asset, count(a.id_tipe_asset) as jumlah',
	 		'join' => 'tbl_m_tipe_asset b on a.id_tipe_asset = b.id type LEFT',
	 		'where' => [
	 			'a.is_active' => 1,	
	 		],
	 		'group_by' => 'b.tipe_asset'
	 	])->result();

	 	$prsn_tipe = [];
	 	foreach ($data_view['tipe_asset'] as $tipe) {
	 		$prsn_tipe[$tipe->id_tipe_asset] = round(($tipe->jumlah/$a) * 100,2);
	 	}

	 	$data_view['jenis_asset']  = get_data('tbl_asset a',[
	 		'select' => 'a.id_jenis_bangunan, b.jenis_bangunan, count(a.id_jenis_bangunan) as jumlah',
	 		'join' => 'tbl_jenis_bangunan b on a.id_jenis_bangunan = b.id type LEFT',
	 		'where' => [
	 			'a.is_active' => 1,	
	 		],
	 		'group_by' => 'b.jenis_bangunan'
	 	])->result();

	 	$prsn_jenis = [];
	 	foreach ($data_view['jenis_asset'] as $jenis) {
	 		$prsn_jenis[$jenis->id_jenis_bangunan] = round(($jenis->jumlah/$a) * 100,2);
	 	}

	    $attr_1 = [
	        'select' => 'count(a.id) as jumlah',
	        'where' => [
	        	'a.is_active' => 1
	        ],
	    ];

 		$data_view['data_gedung']  = get_data('tbl_asset a',[
	 		'select' => 'a.id_pemilik,b.pemilik_aset,a.id_status_asset, c.status_asset,sum(a.luas_tanah) as luas_tanah,sum(a.luas_bangunan) as luas_bangunan',
	 		'join'  => ['tbl_pemilik_aset b on a.id_pemilik = b.id type LEFT',
	 					'tbl_status_asset c on id_status_asset = c.id type LEFT'
	 		],
	 		'where' => [
	 			'a.is_active' => 1,
	 		],
	 		'group_by' => 'a.id_status_asset,a.id_pemilik'
	 	])->result();

 		$data_view['telkom_komersial1'] = 0;
 		$data_view['telpro_komersial1'] = 0;
 		$data_view['telkom_ditawarkan1'] = 0;
 		$data_view['telpro_ditawarkan1'] = 0;
 		$data_view['telkom_proses1'] = 0;
 		$data_view['telpro_proses1'] = 0;
 		$data_view['telkom_idle1'] = 0;
 		$data_view['telpro_idle1'] = 0;
 		$data_view['telkom_komersial2'] = 0;
 		$data_view['telpro_komersial2'] = 0;
 		$data_view['telkom_ditawarkan2'] = 0;
 		$data_view['telpro_ditawarkan2'] = 0;
 		$data_view['telkom_proses2'] = 0;
 		$data_view['telpro_proses2'] = 0;
 		$data_view['telkom_idle2'] = 0;
 		$data_view['telpro_idle2'] = 0;
 		$data_view['total_ltanah'] = 0;
 		$data_view['total_lbangunan'] = 0;
	 	foreach ($data_view['data_gedung'] as $g) {
	 		$data_view['total_ltanah'] += $g->luas_tanah;
 			$data_view['total_lbangunan'] += $g->luas_bangunan;
			switch ($g->id_status_asset) {
				  case 4:
				    if($g->id_pemilik == 1){
				    	$data_view['telkom_komersial1'] = $g->luas_tanah;
				    	$data_view['telkom_komersial2'] = $g->luas_bangunan;
				    }else{
				    	$data_view['telpro_komersial1'] = $g->luas_tanah;
				    	$data_view['telpro_komersial2'] = $g->luas_bangunan;
				    }
				    break;
				  case 2:
				    if($g->id_pemilik == 1){
				    	$data_view['telkom_ditawarkan1'] = $g->luas_tanah;
				    	$data_view['telkom_ditawarkan2'] = $g->luas_bangunan;
				    }else{
				    	$data_view['telpro_ditawarkan1'] = $g->luas_tanah;
				    	$data_view['telpro_ditawarkan2'] = $g->luas_bangunan;
				    }
				    break;
				  case 1:
				    if($g->id_pemilik == 1){
				    	$data_view['telkom_proses1'] = $g->luas_tanah;
				    	$data_view['telkom_proses2'] = $g->luas_bangunan;
				    }else{
				    	$data_view['telpro_proses1'] = $g->luas_tanah;
				    	$data_view['telpro_proses2'] = $g->luas_bangunan;
				    }
				    break;
				  case 3:
				    if($g->id_pemilik == 1){
				    	$data_view['telkom_idle1'] = $g->luas_tanah;
				    	$data_view['telkom_idle2'] = $g->luas_bangunan;
				    }else{
				    	$data_view['telpro_idle1'] = $g->luas_tanah;
				    	$data_view['telpro_idle2'] = $g->luas_bangunan;
				    }
				    break;
				} 

		} 

 	 	$data_view['data_jumlah_bangunan']  = get_data('tbl_asset a',[
	 		'select' => 'a.id,a.id_pemilik,b.pemilik_aset,a.id_status_asset, c.status_asset,count(a.id) as jumlah',
	 		'join'  => ['tbl_pemilik_aset b on a.id_pemilik = b.id type LEFT',
	 					'tbl_status_asset c on id_status_asset = c.id type LEFT'
	 		],
	 		'where' => [
	 			'a.is_active' => 1,
	 		],
	 		'group_by' => 'a.id,a.id_status_asset,a.id_pemilik'
	 	])->result();

 		$data_view['jtelkom_komersial'] = 0;
 		$data_view['jtelpro_komersial'] = 0;
 		$data_view['jtelkom_ditawarkan'] = 0;
 		$data_view['jtelpro_ditawarkan'] = 0;
 		$data_view['jtelkom_proses'] = 0;
 		$data_view['jtelpro_proses'] = 0;
 		$data_view['jtelkom_idle'] = 0;
 		$data_view['jtelpro_idle'] = 0;
 		$data_view['jtotal'] = 0;

	 	foreach ($data_view['data_jumlah_bangunan'] as $g) {
	 		$data_view['jtotal'] += $g->jumlah;
			switch ($g->id_status_asset) {
				  case 4:
				    if($g->id_pemilik == 1){
				    	$data_view['jtelkom_komersial'] += $g->jumlah;
				    }else{
				    	$data_view['jtelpro_komersial'] += $g->jumlah;
				    }
				    break;
				  case 2:
				    if($g->id_pemilik == 1){
				    	$data_view['jtelkom_ditawarkan'] += $g->jumlah;
				    }else{
				    	$data_view['jtelpro_ditawarkan'] += $g->jumlah;
				    }
				    break;
				  case 1:
				    if($g->id_pemilik == 1){
				    	$data_view['jtelkom_proses'] += $g->jumlah;
				    }else{
				    	$data_view['jtelpro_proses'] += $g->jumlah;
				    }
				    break;
				  case 3:
				    if($g->id_pemilik == 1){
				    	$data_view['jtelkom_idle'] += $g->jumlah;
				    }else{
				    	$data_view['jtelpro_idle'] += $g->jumlah;
				    }
				    break;
				} 

		} 

		$komtel = [];
		$kompro = [];
		$idletel = [];
		$idlepro = [];

		$area = [];
 	 	$data_view['data_idlekom']  = get_data('tbl_asset a',[
	 		'select' => 'concat("AREA ",a.id_area) as id_area,a.id_area as arid, b.area,a.id_pemilik,c.pemilik_aset,a.id_status_asset, d.status_asset, count(a.id_pemilik) as pemilik',
	 		'join'  => ['tbl_area b on a.id_area = b.id type LEFT',
	 					'tbl_pemilik_aset c on id_pemilik = c.id type LEFT',
	 					'tbl_status_asset d on a.id_status_asset = d.id type LEFT'
	 		],
	 		'where' => [
	 			'a.is_active' => 1,
	 			'a.id_pemilik' => ['1','2'],
	 			'a.id_status_asset' => ['3','4']
	 		],
	 		'group_by' => 'a.id_area,a.id_pemilik,a.id_status_asset'
	 	])->result();

 	// 	debug($data_view['data_idlekom']);die;
 	 	foreach ($data_view['data_idlekom'] as $a) {
 	 		if($a->id_pemilik == 1 && $a->id_status_asset == 4) $komtel[$a->arid] = $a->pemilik ;
 	 		if($a->id_pemilik == 2 && $a->id_status_asset == 4) $kompro[$a->arid] = $a->pemilik ;
 	 		if($a->id_pemilik == 1 && $a->id_status_asset == 3) $idletel[$a->arid] = $a->pemilik ;
 	 		if($a->id_pemilik == 2 && $a->id_status_asset == 3) $idlepro[$a->arid] = $a->pemilik ;
 	 		
 	 		$area[$a->arid] = $a->id_area;
 	 	}

	    $view   = $this->load->view('laporan/dashboard_asset/data',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'skema_kerjasama'	=> $data_view['skema'],
	        'status_surat'	=> $data_view['status_surat'],
	        'tipe_asset'	=> $data_view['tipe_asset'],
	        'jenis_asset'	=> $data_view['jenis_asset'],
	        'prsn_skema'	=> $prsn_skema,
	        'prsn_ssurat'	=> $prsn_ssurat,
	        'prsn_tipe'		=> $prsn_tipe,
	        'prsn_jenis'	=> $prsn_jenis,
	        'idlekom'		=> $data_view['data_idlekom'],
	        'komtel'		=> $komtel,
	        'kompro'		=> $kompro,
	        'idletel'		=> $idletel,
	        'idlepro'		=> $idlepro,
	        'area'			=> $area
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


	    $result = data_pagination('tbl_asset a',$attr,base_url('laporan/dashboard_asset/data2/'),4);
	 
	    $data_view['record']    = $result['record'];
	

 		$data_view['status_idle']  = get_data('tbl_asset a',[
 			'select' => 'a.*,b.jenis_bangunan as jenis_asset,c.area',
 			'join'	 => ['tbl_jenis_bangunan b on a.id_jenis_bangunan = b.id type LEFT',
 				'tbl_area c on a.id_area = c.id type LEFT'
 			], 
	 		'where' => [
	 			'a.is_active' => 1,
	 		//	'a.id_status_asset' => 3,
	 			'__m' => '(a.luas_area_idle > 1500)'
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->result();

	    $view   = $this->load->view('laporan/dashboard_asset/data2',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
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


	    $result = data_pagination('tbl_asset a',$attr,base_url('laporan/dashboard_asset/data3/'),4);
	 
	    $data_view['record']    = $result['record'];
	

 		$data_view['status_tanah']   = get_data('tbl_asset a',[
 			'select' => 'distinct a.status_tanah as status_tanah',
	 		'where' => [
	 			'a.is_active' => 1,
	 			'a.status_tanah !=' => 'Tidak Btanah HGU'
	 		],
	 		'sort_by' => 'status_tanah',
	 		'sort' => 'ASC'
	 	])->result();

 		$data_view['detail_status_tanah']  = get_data('tbl_asset a',[
 			'select' => 'a.*,b.area',
 			'join'	 => 'tbl_area b on a.id_area = b.id type LEFT',	
	 		'where' => [
	 			'a.is_active' => 1,
	 			'a.masa_berlaku_surat_tanah !=' => '0000-00-00',
	 			'a.status_tanah !=' => 'Tidak Btanah HGU'
	 		],
	 		'sort_by' => 'a.masa_berlaku_surat_tanah',
	 		'sort' => 'ASC'
	 	])->result();

		$d_now = date("Y-m-d");
		$time = strtotime($d_now);
 		$final2 = date("Y-m-d", strtotime("+4 year", $time));

	    $view   = $this->load->view('laporan/dashboard_asset/data3',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	    ];
	    render($data,'json');
	}

}