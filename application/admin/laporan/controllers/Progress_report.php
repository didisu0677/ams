<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Progress_report extends BE_Controller {

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

		$data['brand']	= get_data('tbl_m_brand',[
			'where' => [
				'is_active' => 1,
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
	        $data 		.= '<option value="'.$e->id.'" data-id ="'.$e->id.'">'.$e->facility_management. '</option>';
	    }
	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}

	function get_sub($type ='echo',$id_group='') {
		if(post('id_group') !=0){	
			$id_group= post('id_group');
	    }else{
	    	$id_group = $id_group;
	    }

	    $rs 			= get_data('tbl_group_progress_report a',[
	        'select'	=> 'a.*',
	        'where' 	=> [
	            'a.is_active' => 1,
	            'a.id !=' => $id_group
	        ]
	    ])->result();
	    $data 			= '<option value=""></option>';
	    foreach($rs as $e) {
	        $data 		.= '<option value="'.$e->id.'" data-id ="'.$e->id.'">'.$e->group_by. '</option>';
	    }

	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}

	function view() {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$area 			= post('id_area');
		$fm				= post('id_fm');
		$brand			= post('brand');
		$penanggung_jawab = post('penanggung_jawab');
		$group_by       = post('group1');
		$sub_by       	= post('group2');

		$_key1 = get_data('tbl_group_progress_report','id',$group_by)->row();
		$_key2 = get_data('tbl_group_progress_report','id',$sub_by)->row();

		$where 				= [
			'a.is_active ' 	=> 1,
		];

		if($area != 'all') $where['c.id_area']	= $area;
		if($fm != 'all' && $fm !='') $where['a.id_fm']	= $fm;
		if($brand != 'all') $where['a.id_brand']	= $brand;
		if($penanggung_jawab != 'all') $where['a.penanggung_jawab_mitra']	= $penanggung_jawab;

		$status 			= get_data('tbl_m_aktivitas a',[
			'select'    => 'distinct a.'.$_key1->_key.' as id, b.'.$_key1->_nama.' as nama',
			'join'		=> [''.$_key1->master_tabel.' b on a.'.$_key1->_key.' = b.id type LEFT',
							'tbl_asset c on a.id_asset = c.id type LEFT'
		],
			'where'		=> $where,
		])->result();
	
		/*
		switch ($group_by) {
		  case 1:
		    $gr = 'a.kota';
		    break;
		  case 2:
		    $gr = 'a.brand';
		    break;
		} 
		*/

		$gr = $_key2->_nama;

		$status_survey 		= [];
		foreach($status as $d) {
			$status_survey[$d->id]	= $d->nama;
		}


		if(count($status_survey)){
	//	debug($status_survey);die;

			$jumlah = 0;

			$z = 0;
			$zid = '';
			$data['jumlah'][] = '';
			$tr1 = 0;
		   	$tr2 = 0;
		   	$tr3 = 0;
		   	$tr4 = 0;

			foreach($status_survey as $k => $v) {	
				$zid = $v;	

				$where 				= [
					'a.is_active ' 	=> 1,
					'a.'.$_key1->_key.'' => $k,
				];
				

				if($area != 'all') $where['b.id_area']	= $area;
				if($fm != 'all' && $fm !='') $where['a.id_fm']	= $fm;
				if($brand != 'all') $where['a.id_brand']	= $brand;
				if($penanggung_jawab != 'all') $where['a.penanggung_jawab_mitra']	= $penanggung_jawab;

				$data['result'][$v]	= get_data('tbl_m_aktivitas a',[
					'select' => 'a.id, a.'.$_key1->_key.', a.id_penanggung_jawab_mitra, c.'.$_key2->_nama.' as nama, count(a.id) as jumlah, 0 as total, 0 as total_progress',
					'join'   => ['tbl_asset b on a.id_asset = b.id type LEFT',
								''.$_key2->master_tabel.' c on a.'.$_key2->_key.' = c.id type LEFT'	
					],
					'where'	=> $where,
					'group_by' => 'a.'.$_key2->_key.''
				])->result_array();

				$z = 0;
				$data['jumlah'][$zid] = 0;		
				$data['progress'][$zid] = 0;

				$sum = get_data('tbl_detail_aktivitas a',[
		   		'select' => 'a.id_status_aktivitas,a.status_aktivitas, count(a.id_status_aktivitas) as jmlstatus',
		   		'join'	 => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
		   		'where'	=> [
		   			'b.'.$_key1->_key.'' => $k, 
		   			'b.is_active' => 1
		   		],	
		   		'group_by' => 'b.'.$_key1->_key.',a.id_status_aktivitas'
		   		])->result();

				foreach ($sum as $s) {
	                if($s->id_status_aktivitas == 1) {
	                    $r1 = $s->jmlstatus ;
	                   	$tr1 += $r1 ;
	                }

	                if($s->id_status_aktivitas == 2) {
	                    $r2 = $s->jmlstatus ;
	                    $tr2 += $r2 ;
	                }

	                if($s->id_status_aktivitas == 3) {
	                    $r3 = $s->jmlstatus ;
	                    $tr3 += $r3 ;
	                }

	                if($s->id_status_aktivitas == 4) {
	                    $r4 = $s->jmlstatus ;
	                    $tr4 += $r4 ;
	                }

			   	}


																
				foreach($data['result'][$v] as $n => $x) {			
				
						if($x[''.$_key1->_key.''] == $k) {
							$z++;
							$data['jumlah'][$zid]	+= $x['jumlah'];
							$sum = get_data('tbl_detail_aktivitas a',[
						   		'select' => 'a.id_status_aktivitas,a.status_aktivitas, count(a.status_aktivitas) as jmlstatus',
						   		'join'	 => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
						   		'where'	=> [
						   			'b.'.$_key1->_key.'' => $k, 
						   			'b.is_active' => 1
						   		],	
						   		'group_by' => 'a.id_status_aktivitas'
						   	])->result();

							$r1 = 0;
						   	$r2 = 0;
						   	$r3 = 0;
						   	$r4 = 0;
						   	foreach ($sum as $s) {
				                if($s->id_status_aktivitas == 1) {
				                    $r1 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 2) {
				                    $r2 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 3) {
				                    $r3 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 4) {
				                    $r4 = $s->jmlstatus ;
				                }
						   	}

						   	$rumus  = round(((($r2 * 1) + ( $r3 * (50/100)) + ( $r1 * 0)) / ($r2+$r3+$r1)) * 100,2);

						   	$data['progress'][$zid]	= $rumus;
						}
			
				
	
						$data['result'][$v][$n]['jenis']	= $x['nama'];					
							
							$sum = get_data('tbl_detail_aktivitas a',[
						   		'select' => 'c.'.$_key2->_nama.', a.id_status_aktivitas,a.status_aktivitas, count(a.status_aktivitas) as jmlstatus',
						   		'join'	 => ['tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
						   			''.$_key2->master_tabel.' c on b.'.$_key2->_key.' = c.id type LEFT'
						   		],
						   		'where'	=> [
						   			'c.'.$_key2->_nama.'' => $x['nama'], 
						   			'b.'.$_key1->_key.'' => $k, 
						   			'b.is_active' => 1
						   		],	
						   		'group_by' => 'c.'.$_key2->_nama.',a.id_status_aktivitas'
						   	])->result();
						   	$r1 = 0;
						   	$r2 = 0;
						   	$r3 = 0;
						   	$r4 = 0;
						   	$rumus = 0;
						   	foreach ($sum as $s) {	
				                if($s->id_status_aktivitas == 1) {
				                    $r1 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 2) {
				                    $r2 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 3) {
				                    $r3 = $s->jmlstatus ;
				                }

				                if($s->id_status_aktivitas == 4) {
				                    $r4 = $s->jmlstatus ;
				                }
						   	}

						   	$rumus  = round(((($r2 * 1) + ( $r3 * (50/100)) + ( $r1 * 0)) / ($r2+$r3+$r1)) * 100,2);

		
						   	$data['result'][$v][$n]['progress']	= $rumus;	

					$data['result'][$v][$n]['jumlah']	= $x['jumlah'];	
					$data['result'][$v][$n]['total']	+= $x['jumlah'];	
				}

			}
				$z2  = round(((($tr2 * 1) + ( $tr3 * (50/100)) + ( $tr1 * 0)) / ($tr2+$tr3+$tr1)) * 100,2);
				$data['total_progress'] = $z2;

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
		}else{
			$response	= array(
	            'status'	=> 'failed',
	            'message'	=> 'Tidak ada Data',
	        );
			render($response,'json');
		}	
	}

}