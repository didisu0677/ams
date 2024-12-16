<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_piutang extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {

		$data['area']	= get_data('tbl_area',[
			'where' => [
				'is_active' => 1,
			],
			'order_by' => 'area'
		])->result_array();

		$data['penanggung_jawab']	= get_data('tbl_penanggung_jawab_mitra',[
			'where' => [
				'is_active' => 1,
			],
			'order_by' => 'nama'
		])->result_array();

		$data['brand']	= get_data('tbl_m_finance',[
			'select' => 'distinct id_brand as id, brand',
			'where' => [
				'is_active' => 1,
				'piutang !=' => 0 
			],
			'order_by' => 'brand'
		])->result_array();

		$data['group_by']	= get_data('tbl_group_progress_report',[
			'order_by' => 'group_by'
		])->result_array();

		render($data);
	}

	function get_fm($type ='echo',$area='') {
		if(post('id_area') !=""){	
			$id_area = post('id_area');
	    }else{
	    	$id_area = $area;
	    }
	    $rs 			= get_data('tbl_m_facility_management a',[
	        'select'	=> 'a.*',
	        'where' 	=> [
	            'a.is_active' => 1,
	            'id_area' => $id_area
	        ]
	    ])->result();
	    $data 			= '<option value="all">Semua FM</option>';
	    foreach($rs as $e) {
	        $data 		.= '<option value="'.$e->id.'" data-id ="'.$e->id.'">'.$e->facility_management. '</opfmtion>';
	    }
	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}

	function get_namagedung($type ='echo',$id_fm='') {
		if(post('id_fm') !=0){	
			$id_fm= post('id_fm');
	    }else{
	    	$id_fm = $id_fm;
	    }

	    $rs 			= get_data('tbl_asset a',[
	        'select'	=> 'a.*',
	        'where' 	=> [
	            'a.is_active' => 1,
	            'a.id_fm' => $id_fm
	        ]
	    ])->result();
	    $data 			= '<option value=""></option>';
	    foreach($rs as $e) {
	        $data 		.= '<option value="'.$e->id.'" data-id ="'.$e->id.'">'.$e->nama_gedung. '</option>';
	    }

	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}

	function view() {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$status 		= post('status');
		$portfolio 		= post('portfolio');
		$brand			= post('brand');
		$area 			= post('id_area');
		$fm				= post('id_fm');
		$id_asset       = post('id_asset');
		$tanggal 		= post('::periode');

				$where 				= [
					'b.is_active ' 	=> 1,
					'a.status_bill !=' => 'Paid'
				];

				if($status != 'all') $where['a.status_bill'] = $status;
				if($portfolio != 'all' && $portfolio != 0) $where['b.portfolio'] = $portfolio;
				if($brand != 'all') $where['b.id_brand']= $brand;
				if($area != 'all') $where['b.id_area']	= $area;
				if($fm != 'all' && $fm != '') $where['b.id_fm']	= $fm;
				if($id_asset != 'all' && $id_asset != '') $where['b.id_asset']	= $id_asset;

				if($tanggal) {
					$where['a.tanggal_unbill >=']	= $tanggal[0];
					$where['a.tanggal_unbill <=']	= $tanggal[1];
				}
					
				$data['result']	= get_data('tbl_detail_finance a',[
			        'select' => 'CASE b.portfolio
		   								when 1 then "Ubis"
		   								when 2 then "Non Ubis"
		   								when 0 then "" 
										END as nama_portfolio,b.id_brand,b.brand, 
								c.nama_gedung,c.alamat,c.kota,c.facility_management,d.area,sum(a.piutang_bill+a.piutang_unbill) as piutang',
			        'join'   => ['tbl_m_finance b on a.id_m_finance = b.id type inner',
			        			 'tbl_asset c on b.id_asset = c.id',
			        			 'tbl_area d on c.id_area = d.id type LEFT'
			    	],
					'where'	=> $where,
					'group_by' => 'b.portfolio,b.id_brand,b.brand,c.nama_gedung',
				])->result();

			if(post('tipe') == 'pdf') {
				ini_set('memory_limit', '-1');
			//	$data['id_unit_daftar']		= $unit;
			//	$data['nm_kanwil'] = $nm_unit;

				render($data,'pdf:landscape');
			} elseif(post('tipe') == 'excel') {
				$overall 	= [];
				foreach($data['result'] as $k => $v) {
					$overall[] 	= [
						'Group by'	=> $k,
						'Jumlah'	=> 0,
						'Progress'	=> 0
					];
				}
				$config[]	= [
					'data'		=> $overall,
					'title'		=> 'Progress Report'
				];
				foreach($data['result'] as $k => $v) {
					$config[]	= [
						'data'		=> $v,
						'title'		=> $k,
						'header'	=> [
							'brand'					=> 'Group by',
							'jumlah'				=> 'jumlah',
							'kota'					=> 'Progress'
						],
					];
				}

				$this->load->library('simpleexcel',$config);
				$this->simpleexcel->header([
					'FM'		=> '',
				]);
				$this->simpleexcel->export();
			} else {
				render($data,'json');
			}
		
	}

}