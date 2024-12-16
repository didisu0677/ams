<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends BE_Controller {

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
	        'select' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
	        'join'	 => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	        'where' => [
	        	'b.is_active' => 1,
	        ],
	        'group_by' => 'a.id_m_aktivitas, a.sub_aktivitas',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	    $result = data_pagination('tbl_detail_aktivitas a',$attr,base_url('laporan/dashboard/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	 	$data_view['sub_aktivitas']  = get_data('tbl_sub_aktivitas',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'DESC'
	 	])->result();

 	 	$aktivitas = get_data('tbl_detail_aktivitas a',[
 			'select' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'join'	=> ['tbl_sub_aktivitas b on a.sub_aktivitas = b.sub_aktivitas type LEFT',
 				'tbl_m_aktivitas c on a.id_m_aktivitas = c.id type LEFT'
 			],	
 			'where' => [
 				'c.is_active' => 1
 			],
 			'group_by' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'sort_by'  => 'b.id,id_m_aktivitas',
 			'sort'	   => 'DESC',	
 		])->result(); 

		 	 		
 		foreach ($aktivitas as $a) {
			$s[$a->sub_aktivitas][$a->status_aktivitas][] = $a->id_m_aktivitas ;	
 		}

 	 		
		$li_a = [''];
		$li_b = [''];
		$li_c = [''];

		$si_a = [''];
		$si_b = [''];
		$si_c = [''];
		
		$ri_a = [''];
		$ri_b = [''];
		$ri_c = [''];
		
		$ci_a = [''];
		$ci_b = [''];
		$ci_c = [''];
		
		$jk_blm = 0;
		$jk_ok = 0;
		$jk_ps = 0;

		$jl_blm = 0;
		$jl_ok = 0;
		$jl_ps = 0;

		$jr_blm = 0;
		$jr_ok = 0;
		$jr_ps = 0;

		$jc_blm = 0;
		$jc_ok = 0;
		$jc_ps = 0;

	 	foreach ($s as $si => $svalue) {
	 		if($si == 'KOMERSIAL') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_a[] = $vivalue;					
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_b[] = $vivalue;					
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_c[] = $vivalue;					
	 					}   
	 				}				 					
	 			}

	 				$sum = get_data('tbl_detail_aktivitas a',[
	 					'select' => 'a.status_aktivitas, count(a.status_aktivitas) as jumlah',
	 					'join' => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	 					'where'	 => [
	 						'a.id_m_aktivitas' => $si_b,
	 						'b.is_active' => 1
	 					], 	
	 					'group_by' => 'a.status_aktivitas'
	 					])->result();

	 				if(count($sum)){
		 				foreach ($sum as $s) {
		 					 if($s->status_aktivitas == 'OK') $jk_ok = $s->jumlah;
		 					 if($s->status_aktivitas == 'BLM') $jk_blm = $s->jumlah;
		 					 if($s->status_aktivitas == 'PS') $jk_ps = $s->jumlah	;
		 				}
					}	 				
	 		} 

	 		if($si == 'PELAKSANAAN') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $si_a) == false) {
		 						$li_a[] = $vivalue;					
		 					}
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $si_b) == false) {
		 						$li_b[] = $vivalue;
		 					}						
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $si_c) == false) {
		 						$li_c[] = $vivalue;
		 					}						
	 					}
	 				}					
	 			}

	 				$sum = get_data('tbl_detail_aktivitas a',[
	 					'select' => 'a.status_aktivitas, count(a.status_aktivitas) as jumlah',
	 					 	'join' => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	 					'where'	 => [
	 						'a.id_m_aktivitas' => $li_b,
	 						'b.is_active' => 1
	 					], 	
	 					'group_by' => 'a.status_aktivitas'
	 					])->result();

					if(count($sum)){	 				
		 				foreach ($sum as $s) {
		 					 if($s->status_aktivitas == 'OK') $jl_ok = $s->jumlah;
		 					 if($s->status_aktivitas == 'BLM') $jl_blm = $s->jumlah;
		 					 if($s->status_aktivitas == 'PS') $jl_ps = $s->jumlah	;
		 				}
		 			}	
	 		} 

	 		if($si == 'PROSES') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $li_a) == false && in_array($vivalue, $si_a) == false) {
		 						$ri_a[] = $vivalue;					
		 					}
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (!in_array($vivalue, $li_b) && !in_array($vivalue, $si_b)) {
		 						$ri_b[] = $vivalue;
		 					}						
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $li_c) == false && in_array($vivalue, $si_c) == false) {
		 						$ri_c[] = $vivalue;
		 					}						
	 					}
	 				}					
	 			}
	 				$sum = get_data('tbl_detail_aktivitas a',[
	 					'select' => 'a.status_aktivitas, count(a.status_aktivitas) as jumlah',
	 					'join' => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	 					'where'	 => [
	 						'a.id_m_aktivitas' => $ri_b,
	 						'b.is_active' => 1
	 					], 	
	 					'group_by' => 'a.status_aktivitas'
	 					])->result();

	 				if(count($sum)){
		 				foreach ($sum as $s) {
		 					 if($s->status_aktivitas == 'OK') $jr_ok = $s->jumlah;
		 					 if($s->status_aktivitas == 'BLM') $jr_blm = $s->jumlah;
		 					 if($s->status_aktivitas == 'PS') $jr_ps = $s->jumlah	;
		 				}
		 			}	
	 		} 

	 		if($si == 'PERENCANAAN') {

	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $ri_a) == false && in_array($vivalue, $si_a) == false && in_array($vivalue, $li_a) == false) {
		 						$ci_a[] = $vivalue;					
		 					}
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $ri_b) == false && in_array($vivalue, $si_b) == false && in_array($vivalue, $li_b) == false) {
		 						$ci_b[] = $vivalue;
		 					}						
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $ri_c) == false && in_array($vivalue, $si_c) == false && in_array($vivalue, $li_c) == false) {
		 						$ci_c[] = $vivalue;
		 					}						
	 					}
	 				}					
	 			}

	 				$sum = get_data('tbl_detail_aktivitas a',[
	 					'select' => 'a.status_aktivitas, count(a.status_aktivitas) as jumlah',
	 					'join' => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	 					'where'	 => [
	 						'a.id_m_aktivitas' => $ci_b,
	 						'b.is_active' => 1
	 					], 	
	 					'group_by' => 'a.status_aktivitas'
	 					])->result();

	 				if(count($sum)){
	 					foreach ($sum as $s) {
		 					 if($s->status_aktivitas == 'OK') $jc_ok = $s->jumlah;
		 					 if($s->status_aktivitas == 'BLM') $jc_blm = $s->jumlah;
		 					 if($s->status_aktivitas == 'PS') $jc_ps = $s->jumlah	;
	 					}
	 				}
	 		} 

	 	}

		$var_r1 = count($si_b) -1;
		$var_r2 = count($li_b) -1;
		$var_r3 = count($ri_b) -1;
		$var_r4 = count($ci_b) -1;
 
 		$data_view['KOMERSIAL'] = $var_r1 ;
 		$data_view['PELAKSANAAN'] = $var_r2 ;
 		$data_view['PROSES'] = $var_r3 ;
 		$data_view['PERENCANAAN'] = $var_r4 ;
 		$data_view['TOTAL'] = $var_r1 + $var_r2 + $var_r3 + $var_r4 ;

 		$t_ok = $jk_ok + $jl_ok + $jr_ok + $jc_ok;
 		$t_ps = $jk_ps + $jl_ps + $jr_ps + $jc_ps;
 		$t_blm = $jk_blm + $jl_blm + $jr_blm + $jc_blm;


 		if($jk_ok+$jk_ps+$jk_blm !=0) { 
 			$rumus1  = round(((($jk_ok * 1) + ( $jk_ps * (50/100)) + ( $jk_blm * 0)) / ($jk_ok+$jk_ps+$jk_blm)) * 100,2);
 		}else{
 			$rumus1 =0;
 		}

 		if($jl_ok+$jl_ps+$jl_blm !=0) { 
 			$rumus2  = round(((($jl_ok * 1) + ( $jl_ps * (50/100)) + ( $jl_blm * 0)) / ($jl_ok+$jl_ps+$jl_blm)) * 100,2);
 		}else{
 			$rumus2 =0;
 		}

 		if($jr_ok+$jr_ps+$jr_blm !=0) { 
 			$rumus3  = round(((($jr_ok * 1) + ( $jr_ps * (50/100)) + ( $jr_blm * 0)) / ($jr_ok+$jr_ps+$jr_blm)) * 100,2);
 		}else{
 			$rumus3 = 0;
 		}

 		if($jc_ok+$jc_ps+$jc_blm !=0) { 
 			$rumus4  = round(((($jc_ok * 1) + ( $jc_ps * (50/100)) + ( $jc_blm * 0)) / ($jc_ok+$jc_ps+$jc_blm)) * 100,2);
	 	}else{
	 		$rumus4 = 0;
	 	}	

		if($t_ok+$t_ps+$t_blm !=0) { 
 			$rumus5  = round(((($t_ok * 1) + ( $t_ps * (50/100)) + ( $t_blm * 0)) / ($t_ok+$t_ps+$t_blm)) * 100,2);
 		}else{
 			$rumus5 = 0;
 		}


 		$data_view['progress_KOMERSIAL'] = $rumus1 ;  
		$data_view['progress_PELAKSANAAN'] = $rumus2 ;
		$data_view['progress_PROSES'] = $rumus3 ;
		$data_view['progress_PERENCANAAN'] = $rumus4 ;
		$data_view['progress_TOTAL'] = $rumus5 ;

 //		debug('x');die;

		$jumlah = [];
		$progress = [];
		foreach ($data_view['sub_aktivitas'] as $s) {
			if($s->id == 4) $jumlah[$s->id] = $var_r1 ;
				if($s->id == 3) $jumlah[$s->id] = $var_r2;
					if($s->id == 2) $jumlah[$s->id] = $var_r3;
						if($s->id == 1) $jumlah[$s->id] = $var_r4;

			if($s->id == 4) $progress[$s->id] = $rumus1 ;
				if($s->id == 3) $progress[$s->id] = $rumus2;
					if($s->id == 2) $progress[$s->id] = $rumus3;
						if($s->id == 1) $progress[$s->id] = $rumus4;			
		}

	 	$batal  = get_data('tbl_m_aktivitas a',[
	 		'select' => 'count(a.id) as jumlah',
	 		'where' => [
	 			'is_active' => 0,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'ASC'
	 	])->row();

	 	$data_view['batal'] = $batal->jumlah;

	    $view  = $this->load->view('laporan/dashboard/data',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'sub_aktivitas'	=> $data_view['sub_aktivitas'],
	        'jumlah'		=> $jumlah,
	        'progress'		=> $progress
	    ];

	    render($data,'json');
	}

	function data2($page = 1) {
	    $limit = 0;
	    if($page) {
	        $page = ($page - 1) * $limit;
	    }
	 
	    $attr = [
	        'select' => 'a.id_m_aktivitas,a.sub_aktivitas,status_aktivitas',
	        'join'	 => 'tbl_m_aktivitas b on a.id_m_aktivitas = b.id type LEFT',
	        'where'  => [
	        	'b.is_active' => 1
	        ],		
	        'group_by' => 'a.id_m_aktivitas, a.sub_aktivitas',
	        'limit' => $limit,
	        'offset' => $page
	    ];


	    $result = data_pagination('tbl_detail_aktivitas a',$attr,base_url('laporan/dashboard/data/'),4);
	 
	    $data_view['record']    = $result['record'];
	    $data_view['jenis_aktivitas'] = get_data('tbl_m_jenis_aktivitas','is_active',1)->result();
	 	$data_view['status']  = get_data('tbl_status_aktivitas','is_active',1)->result();
	 	$data_view['sub_aktivitas']  = get_data('tbl_sub_aktivitas',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'DESC'
	 	])->result();

	 	 $aktivitas = get_data('tbl_detail_aktivitas a',[
 			'select' => 'a.id_m_aktivitas,a.grup_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'join'	=> ['tbl_sub_aktivitas b on a.sub_aktivitas = b.sub_aktivitas type LEFT',
 			'tbl_m_aktivitas c on a.id_m_aktivitas = c.id type LEFT'
 			],
 			'where' => [
 				'c.is_active' => 1,
 			],
 			'group_by' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'sort_by'  => 'b.id,id_m_aktivitas',
 			'sort'	   => 'DESC',	
 		])->result(); 

	 	 		
 		foreach ($aktivitas as $a) {
			$s[$a->grup_aktivitas][$a->status_aktivitas][] = $a->id_m_aktivitas ;	
 		}

 	 		
		$li_a = [];
		$li_b = [];
		$li_c = [];
		$li_d = [];

		$si_a = [];
		$si_b = [];
		$si_c = [];
		$si_d = [];

		$ri_a = [];
		$ri_b = [];
		$ri_c = [];
		$ri_d = [];

		$ci_a = [];
		$ci_b = [];
		$ci_c = [];
		$ci_d = [];

		$jk_blm = 0;
		$jk_ok = 0;
		$jk_ps = 0;

		$jl_blm = 0;
		$jl_ok = 0;
		$jl_ps = 0;

		$jr_blm = 0;
		$jr_ok = 0;
		$jr_ps = 0;

		$jc_blm = 0;
		$jc_ok = 0;
		$jc_ps = 0;

	 	foreach ($s as $si => $svalue) {
	 		if($si == 'PROGRESS TELKOM PROPERTY') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_a[] = $vivalue;					
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_b[] = $vivalue;					
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 				//	debug($vivalue);die;
		 					$si_c[] = $vivalue;					
	 					}   
	 				}

	 				if($vi == 'TDL') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 				//	debug($vivalue);die;
		 					$si_d[] = $vivalue;					
	 					}   
	 				}					 					
	 			}
	 				
	 		} 

	 		if($si == 'TELKOM INDONESIA') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$li_a[] = $vivalue;					
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$li_b[] = $vivalue;				
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$li_c[] = $vivalue;					
	 					}
	 				}

	 				if($vi == 'TDL') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$li_d[] = $vivalue;					
	 					}
	 				}						
	 			}

	 		} 

	 		if($si == 'MITRA') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'BLM') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$ri_a[] = $vivalue;					
	 					}
	 				}	

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$ri_b[] = $vivalue;					
	 					}
	 				}			

	 				if($vi == 'PS') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$ri_c[] = $vivalue;
	 					}
	 				}	

	 				if($vi == 'TDL') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$ri_d[] = $vivalue;
	 					}
	 				}					
	 			}

	 		} 

	 	}		

	 	$var_b1 = count($si_a);
		$var_b2 = count($li_a);
		$var_b3 = count($ri_a);

		$var_o1 = count($si_b);
		$var_o2 = count($li_b);
		$var_o3 = count($ri_b);

		$var_p1 = count($si_c);
		$var_p2 = count($li_c);
		$var_p3 = count($ri_c);

		$var_t1 = count($si_d);
		$var_t2 = count($li_d);
		$var_t3 = count($ri_d);

 
 		$data_view['PROPERTY_OK'] = $var_o1 ;
 		$data_view['TELKOM_OK'] = $var_o2 ;
 		$data_view['MITRA_OK'] = $var_o3 ;

 		$data_view['PROPERTY_BLM'] = $var_b1 ;
 		$data_view['TELKOM_BLM'] = $var_b2 ;
 		$data_view['MITRA_BLM'] = $var_b3 ;

 		$data_view['PROPERTY_PS'] = $var_p1 ;
 		$data_view['TELKOM_PS'] = $var_p2 ;
 		$data_view['MITRA_PS'] = $var_p3 ;

 		$data_view['PROPERTY_TDL'] = $var_t1 ;
 		$data_view['TELKOM_TDL'] = $var_t2 ;
 		$data_view['MITRA_TDL'] = $var_t3 ;

 		

 		$rumus1  = round(((($var_o1 * 1) + ( $var_p1 * (50/100)) + ( $var_b1 * 0)) / ($var_o1+$var_p1+$var_b1)) * 100,2);

 		$rumus2  = round(((($var_o2 * 1) + ( $var_p2 * (50/100)) + ( $var_b2 * 0)) / ($var_o2+$var_p2+$var_b2)) * 100,2);

 		$rumus3  = round(((($var_o3 * 1) + ( $var_p3 * (50/100)) + ( $var_b3 * 0)) / ($var_o3+$var_p3+$var_b3)) * 100,2);


 		$data_view['progress_PROPERTY'] = $rumus1 ;  
		$data_view['progress_TELKOM'] = $rumus2 ;
		$data_view['progress_MITRA'] = $rumus3 ;


	 	$data_view['grup_aktivitas']  = get_data('tbl_grup_aktivitas',[
	 		'where' => [
	 			'is_active' => 1,
	 		],
	 		'sort_by' => 'id',
	 		'sort' => 'DESC'
	 	])->result();

		$progress = [];
		foreach ($data_view['grup_aktivitas'] as $s) {
			if($s->id == 1) $progress[$s->id] = $rumus1 ;
				if($s->id == 2) $progress[$s->id] = $rumus2;
					if($s->id == 3) $progress[$s->id] = $rumus3;
		}

	    $view   = $this->load->view('laporan/dashboard/data2',$data_view,true);
	 
	    $data = [
	        'data'          => $view,
	        'grup'			=> $data_view['grup_aktivitas'],
	        'progress'		=> $progress,
	    ];


	    render($data,'json');
	}

}