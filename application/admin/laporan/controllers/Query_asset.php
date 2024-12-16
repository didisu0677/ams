<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_asset extends BE_Controller {

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

		$data['status_tanah'] = explode(',', setting('status_tanah'));
		$data['opt_tipe_asset'] = get_data('tbl_m_tipe_asset',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'tipe_asset',
			'sort' => 'ASC'
		])->result_array();

		$data['jenis_bangunan'] = get_data('tbl_jenis_bangunan','is_active',1)->result_array();
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

		$lokasi 		= '%'.post('lokasi').'%';
		$id_area 		= post('id_area');
		$id_fm			= post('id_fm');
		$status_tanah 	= post('status_tanah');
		$id_tipe_asset  = post('id_tipe_asset');
		$id_jenis_bangunan = post('id_jenis_bangunan');
		$luas_bangunan  = post('luas_bangunan');
		$luas_tanah     = post('luas_tanah');
		$luas_area_idle = post('luas_area_idle');
 
		// memisahkan string menjadi array
	

		if($luas_bangunan) {
			$luas_bangunan = explode("-" , $luas_bangunan);
			if(count($luas_bangunan) > 1) {
				$b1 = intval($luas_bangunan[0]);
				$b2 = intval($luas_bangunan[1]);
			}else{
				$b1 = intval($luas_bangunan[0]);
			}
		}

		if($luas_tanah) {
			$luas_tanah = explode("-" , $luas_tanah);
			if(count($luas_tanah) > 1) {
				$t1 = intval($luas_tanah[0]);
				$t2 = intval($luas_tanah[1]);
			}else{
				$t1 = intval($luas_tanah[0]);
			}
		}

		if($luas_area_idle) {
			$luas_area_idle = explode("-" , $luas_area_idle);
			if(count($luas_area_idle) > 1) {
				$i1 = intval($luas_area_idle[0]);
				$i2 = intval($luas_area_idle[1]);
			}else{
				$i1 = intval($luas_area_idle[0]);
			}
		}

				$where 				= [
					'a.is_active ' 	=> 1,
				];


				if($lokasi) 
    			$where['concat(a.informasi_sekitar,a.batas_utara,a.batas_selatan,a.batas_timur,a.batas_barat) like'] = $lokasi;

				if($id_area && $id_area != 'all') $where['a.id_area'] = $id_area;
				if($id_fm && $id_fm !='all') $where['a.id_fm']= $id_fm;
				if($status_tanah && $status_tanah != 'all') $where['a.status_tanah']	= $status_tanah;
				if($id_tipe_asset && $id_tipe_asset != 'all' ) $where['a.id_tipe_asset']	= $id_tipe_asset;
				if($id_jenis_bangunan && $id_jenis_bangunan != 'all') $where['a.id_jenis_bangunan']	= $id_jenis_bangunan;
		//		if($luas_bangunan) $where['a.luas_bangunan'] = $luas_bangunan;
		//		if($luas_tanah) $where['a.luas_tanah']		= $luas_tanah;
		
				if($luas_bangunan) {
					if(count($luas_bangunan) > 1) {
						$where['a.luas_bangunan >='] = 	$b1;
						$where['a.luas_bangunan <='] = 	$b2;
					}else{
						$where['a.luas_bangunan'] = 	$b1;
					}
				}

				if($luas_tanah) {
					if(count($luas_tanah) > 1) {
						$where['a.luas_tanah >='] = 	$t1;
						$where['a.luas_tanah <='] = 	$t2;
					}else{
						$where['a.luas_tanah'] = 	$b1;
					}
				}

				if($luas_area_idle) {
					if(count($luas_area_idle) > 1) {
						$where['a.luas_area_idle >='] = 	$i1;
						$where['a.luas_area_idle <='] = 	$i2;
					}else{
						$where['a.luas_area_idle'] = 	$i1;
					}
				}

				$data['result']	= get_data('tbl_asset a',[
			        'select' => 'a.*,b.area,d.jenis_bangunan,e.tipe_asset, f.status_penggunaan',
			        'join'   => ['tbl_area b on a.id_area = b.id type LEFT',
			        			 'tbl_m_facility_management c on a.id_fm = c.id type LEFT',
			        			 'tbl_jenis_bangunan d on a.id_jenis_bangunan = d.id type LEFT',
			        			 'tbl_m_tipe_asset e on a.id_tipe_asset = e.id type LEFT',
			        			 'tbl_status_penggunaan f on a.id_status_penggunaan = f.id type LEFT'
			    	],
					'where'	=> $where,

				])->result();


				foreach ($data['result'] as $d) {
		    		$photo_gedung 		= [];
		    		$photo = get_data('tbl_upl_foto_gedung',[
		    			'select'  => '*',
		    			'where'	  => [
		    				'file_foto !=' => '',
		    				'id_asset' => $d->id
		    			],
		    			'sort_by' => 'id_foto_gedung',
		    			'sort' => 'ASC'	
		    		])->row();

					if(isset($photo->file_foto)) {
						$data['photo_gedung'][$d->id] = $photo->file_foto;
					}else{
						$data['photo_gedung'][$d->id] = '';
					} 
				}	

		//		debug($data['photo_gedung']);die;

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

	function detail($id='') {
		$nomor 	= get('nomor');
		$data				= get_data('tbl_asset a',[
			'select' => 'a.*,b.klasifikasi,c.skema_kerjasama, d.pemilik_aset,e.perusahaan,e.brand,f.area,g.jenis_bangunan,h.tipe_asset',
			'join'	 => ['tbl_m_klasifikasi_mitra b on a.id_usulan_penggunaan = b.id type LEFT',
						 'tbl_skema_kerjasama c on a.id_skema_kerjasama = c.id type LEFT',
						 'tbl_pemilik_aset d on a.id_pemilik = d.id type LEFT',
						 'tbl_m_mitra e on a.id_mitra = e.id type LEFT',
						 'tbl_area f on a.id_area = f.id type LEFT',
						 'tbl_jenis_bangunan g on a.id_jenis_bangunan = g.id type LEFT',
						 'tbl_m_tipe_asset h on a.id_tipe_asset = h.id type LEFT'
						],
			'where'  => [			
				'a.nomor' => $nomor,
			],
		])->row_array();

		$data['file_foto'] 		= get_data('tbl_upl_foto_gedung',[
			'where' => [
				'id_asset' => $data['id'],
				'file_foto !=' => '',	
			],
			'sort_by' => 'id_foto_gedung',
			'sort' => 'ASC'
		])->result();

	//	debug($data['file_foto']);die;
		render($data,'layout:false');
	}

}