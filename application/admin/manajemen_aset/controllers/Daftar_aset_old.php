<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_aset extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_pemilik'] = get_data('tbl_pemilik_aset','is_active',1)->result_array();
		$data['opt_mitra'] = get_data('tbl_m_mitra',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'brand',
			'sort' => 'ASC',			
		])->result_array();
		$data['opt_skema_kerjasama'] = get_data('tbl_skema_kerjasama','is_active',1)->result_array();
		$data['status_asset'] = get_data('tbl_status_asset','is_active',1)->result_array();
		
		$data['status_tanah'] = explode(',', setting('status_tanah'));
		$data['bentuk_tanah'] = explode(',', setting('bentuk_tanah'));
		$data['catu_daya'] = explode(',', setting('catu_daya'));	
	
		$data['status_penggunaan'] = get_data('tbl_status_penggunaan',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'status_penggunaan',
			'sort' => 'ASC'
		])->result_array();


		$data['jenis_bangunan'] = get_data('tbl_jenis_bangunan','is_active',1)->result_array();
		$data['opt_id_klasifikasi'] = get_data('tbl_m_klasifikasi_mitra',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'klasifikasi',
			'sort' => 'ASC',
		])->result_array();
		
		$data['opt_area'] = get_data('tbl_area','is_active',1)->result_array();
		$data['opt_tipe_asset'] = get_data('tbl_m_tipe_asset',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'tipe_asset',
			'sort' => 'ASC'
		])->result_array();

		$data['dok']	= get_data('tbl_m_foto_gedung','is_active',1)->result();
		$uplfile 		= get_data('tbl_upl_foto_gedung','id_asset',2)->result();
		$data['file_foto']	= [];
		foreach($uplfile as $u) {
			$data['file_foto'][$u->id_foto_gedung] = $u->file_foto;
		}
		render($data);
	}

	function data() {
		$config=[];
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {		
		$data = get_data('tbl_asset','id',post('id'))->row_array();

		$data['file'] 			= json_decode($data['file'],true);
		$data['id_usulan_penggunaan']= json_decode($data['id_usulan_penggunaan'],true);
		$data['id_usulan_mitra']= json_decode($data['id_usulan_mitra'],true);
		$data['file_foto'] 		= get_data('tbl_upl_foto_gedung','id_asset',post('id'))->result();
		render($data,'json');
	}

	function save() {
		$data = post();
	
		if($data['id_status_asset'] == '3') {
			$data['id_mitra'] = 0;
			$data['id_skema_kerjasama'] = 0;
		}

		$status_asset = get_data('tbl_status_asset','id',$data['id_status_asset'])->row();
		if(isset($status_asset)) {
			$data['status_asset'] = $status_asset->status_asset;
		}

		if(is_array(post('id_usulan_penggunaan'))) {
            $data['id_usulan_penggunaan'] = json_encode(post('id_usulan_penggunaan'));
        }

        if(is_array(post('id_usulan_mitra'))) {
            $data['id_usulan_mitra'] = json_encode(post('id_usulan_mitra'));
        }

        $fm = get_data('tbl_m_facility_management','id',$data['id_fm'])->row();
        if(isset($fm->facility_management)) {
        	$data['facility_management'] = $fm->facility_management;
        }

        $brand = get_data('tbl_m_mitra','id',$data['id_usulan_mitra'])->row();
        if(isset($brand->brand)) {
        	$data['usulan_mitra'] = $brand->brand;
        }

		$last_file = [];
		if($data['id']) {
			$dt = get_data('tbl_asset','id',$data['id'])->row();
			if(isset($dt->id)) {
				if($dt->file != '') {
					$lf 	= json_decode($dt->file,true);
					foreach($lf as $l) {
						$last_file[$l] = $l;
					}
				}
			}
		}

		$file 						= post('file');
		$keterangan_file 			= post('keterangan_file');
		$filename 					= [];
		$dir 						= '';
		if(isset($file) && is_array($file)) {
			foreach($file as $k => $f) {
				if(strpos($f,'exist:') !== false) {
					$orig_file = str_replace('exist:','',$f);
					if(isset($last_file[$orig_file])) {
						unset($last_file[$orig_file]);
						$filename[$keterangan_file[$k]]	= $orig_file;
					}
				} else {
					if(file_exists($f)) {
						if(@copy($f, FCPATH . 'assets/uploads/aset/'.basename($f))) {
							$filename[$keterangan_file[$k]]	= basename($f);
							if(!$dir) $dir = str_replace(basename($f),'',$f);
						}
					}
				}
			}
		}
		if($dir) {
			delete_dir(FCPATH . $dir);
		}
		foreach($last_file as $lf) {
			@unlink(FCPATH . 'assets/uploads/aset/' . $lf);
		}
		$data['file']					= json_encode($filename);

		$status_penggunaan = get_data('tbl_status_penggunaan','id',$data['id_status_penggunaan'])->row();

		if(isset($status_penggunaan->status_penggunaan)){
			$data['status_penggunaan'] = $status_penggunaan->status_penggunaan;
		}

		if($data['status_penggunaan'] == 'Leveraged') {
			$data['id_usulan_penggunaan'] = '';
			$data['usulan_penggunaan'] = '-';
			$data['id_usulan_mitra'] = '';
			$data['usulan_mitra'] = '-';
			$data['jarak_usulan_mitra_lokasi'] = 0;
		}

        $batasan_lahan = 'Utara : ' . $data['batas_utara'] ;
        $batasan_lahan .= '<pre>' . ' , Selatan : ' . $data['batas_selatan'] . '</pre>';
        $batasan_lahan .= '<pre>' . ' , Timur : ' . $data['batas_timur'] . '</pre>';
        $batasan_lahan .= '<pre>' . ' , Barat : ' . $data['batas_barat'] . '</pre>';

		$data['batasan_lahan'] = nl2br($batasan_lahan) ;

		$id_usulan_penggunaan= json_decode($data['id_usulan_penggunaan'],true);
		if(count($id_usulan_penggunaan)){
		    $usulan_penggunaan	= [];
			foreach($id_usulan_penggunaan as $c) {
				$klasifikasi = get_data('tbl_m_klasifikasi_mitra','id',$c)->row();
				$usulan_penggunaan[] = $klasifikasi->klasifikasi;
			}	
			$data['usulan_penggunaan'] = implode(",",$usulan_penggunaan) ;
		}

		$id_usulan_mitra = json_decode($data['id_usulan_mitra'],true);
		if(count($id_usulan_mitra)){
		    $usulan_mitra	= [];
			foreach($id_usulan_mitra as $c) {
				$brand = get_data('tbl_m_mitra','id',$c)->row();
				$usulan_mitra[] = $brand->brand;
			}	
			$data['usulan_mitra'] = implode(",",$usulan_mitra) ;
		}



		$response = save_data('tbl_asset',$data,post(':validation'));

		if($response['status'] == 'success') {
			$id_foto 			= post('id_foto');
			$file_foto 			= post('file_foto');
			$old_file 			= post('old_file');

			$d 					= [];
			$dir 				= '';

			foreach($id_foto as $k => $v) {
				if(!is_dir(FCPATH . "assets/uploads/foto_gedung/".$response['id'].'/')){
					$oldmask = umask(0);
					mkdir(FCPATH . "assets/uploads/foto_gedung/".$response['id'].'/',0777);
					umask($oldmask);
				}
				$dok 			= get_data('tbl_m_foto_gedung','id',$id_foto[$k])->row();
				$d[$k] 			= [
					'id_asset'			=> $response['id'],
					'id_foto_gedung'	=> $dok->id,
					'nama_foto'	    	=> $dok->nama,
					'keterangan_foto'   => $dok->keterangan,
					'file_foto'			=> $old_file[$k],
				];
				if($file_foto[$k] && $file_foto[$k] != $old_file[$k]) {
					if(@copy($file_foto[$k], FCPATH . 'assets/uploads/foto_gedung/'.$response['id'].'/'.basename($file_foto[$k]))) {
						$d[$k]['file_foto']	= basename($file_foto[$k]);
						if(!$dir) $dir = str_replace(basename($file_foto[$k]),'',$file_foto[$k]);
					//	if($old_file[$k]) {
					//		@unlink(FCPATH . 'assets/uploads/foto_gedung/'.$response['id'].'/'.$old_file[$k]);
					//	}
					}
				}
			}
			delete_data('tbl_upl_foto_gedung','id_asset',$response['id']);
			if(count($d)) {
				$save 	= insert_batch('tbl_upl_foto_gedung',$d);
			}
			if($dir) {
				delete_dir(FCPATH . $dir);
			}
		}
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_asset','id',post('id'));
		render($response,'json');
	}


	function detail($id='') {
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
				'a.id' => $id,
			],
		])->row_array();

		$data['file_foto'] 		= get_data('tbl_upl_foto_gedung',[
			'where' => [
				'id_asset' => $id,
				'file_foto !=' => '',	
			],
			'sort_by' => 'id_foto_gedung',
			'sort' => 'ASC'
		])->result();

	//	debug($data['file_foto']);die;
		render($data,'layout:false');
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
	    $data 			= '<option value=""></option>';
	    foreach($rs as $e) {
	        $data 		.= '<option value="'.$e->id.'" data-id ="'.$e->id.'">'.$e->facility_management. '</option>';
	    }
	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}


	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['nomor' => 'nomor','nama_gedung' => 'nama_gedung','alamat' => 'alamat','kota' => 'kota','titik_koordinat' => 'titik_koordincat','pemilik' => 'pemilik','mitra' => 'mitra','facility_management' => 'facility_management','status_asset' => 'status_asset','skema_kerjasama' => 'skema_kerjasama','status_tanah' => 'status tanah','tahun_status_tanah' => 'tahun_status_tanah','luas_tanah' => 'luas_tanah','LXP_tanah' => 'lxp_tanah','bentuk_tanah' => 'bentuk_tanah','luas_bangunan' => 'luas_bangunan','jumlah_ltbangunan' => 'jumlah_ltbangunan','luas_area_idle' => 'luas_area_idle','jenis_bangunan' => 'jenis_bangunan','tipe_asset' => 'tipe_asset','batasan_lahan' => 'batasan_lahan','informasi_sekitar' => 'informasi_sekitar','status_penggunaan' => 'status_penggunaan','usulan_mitra' => 'usulan_mitra','catu_daya' => 'catu_daya','area' => 'area','keterangan' => 'keterangan'];
		$config[] = [
			'title' => 'template_import_daftar_aset',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nomor','nama_gedung','alamat','kota','titik_koordinat','pemilik','mitra','facility_management','status_asset','skema_kerjasama','status_tanah','tahun_status_tanah','luas_tanah','LXP_tanah','bentuk_tanah','luas_bangunan','jumlah_ltbangunan','luas_area_idle','jenis_bangunan','batasan_lahan','informasi_sekitar','status_penggunaan','usulan_mitra','catu_daya','area','keterangan'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);

				    $checkpemilik 	= get_data('tbl_pemilik_aset','pemilik_aset',$data['pemilik'])->row();
				    if(isset($checkpemilik->id)){
				        $data['id_pemilik'] = $checkpemilik -> id;
				    }
				    
				    unset($data['pemilik']);

				    $checkmitra 	= get_data('tbl_m_mitra','perusahaan',$data['mitra'])->row();
				    if(isset($checkmitra->id)){
				        $data['id_mitra'] = $checkmitra -> id;
				    }
				    unset($data['mitra']);

				    $checkfm 	= get_data('tbl_m_facility_management','facility_management',$data['facility_management'])->row();
				    if(isset($checkfm->id)){
				        $data['id_fm'] = $checkfm -> id;
				    }else{
				    	$data['facility_management'] = '';
				    }

				    $checkskema 	= get_data('tbl_skema_kerjasama','skema_kerjasama',$data['skema_kerjasama'])->row();
				    if(isset($checkskema->id)){
				        $data['id_skema_kerjasama'] = $checkskema -> id;
				    }

				    unset($data['skema_kerjasama']);

					$checkjb 	= get_data('tbl_jenis_bangunan','jenis_bangunan',$data['jenis_bangunan'])->row();
				    if(isset($checkjb->id)){
				        $data['id_jenis_bangunan'] = $checkjb -> id;
				    }

				    unset($data['jenis_bangunan']);

				    $checkta 	= get_data('tbl_m_tipe_asset','tipe_asset',$data['tipe_asset'])->row();
				    if(isset($checkta->id)){
				        $data['id_tipe_asset'] = $checkta -> id;
				    }

				    unset($data['tipe_asset']);

				    $checkarea 	= get_data('tbl_area','area',$data['area'])->row();
				    if(isset($checkarea->id)){
				        $data['id_area'] = $checkarea -> id;
				    }

				    unset($data['area']);

				    $checkst_asset 	= get_data('tbl_status_asset','status_asset',$data['status_asset'])->row();
				    if(isset($checkst_asset->id)){
				        $data['id_status_asset'] = $checkst_asset -> id;
				    }


				    $data['create_at'] 	= date('Y-m-d H:i:s');
				    $data['create_by'] 	= user('nama');
					
					$check 	= get_data('tbl_asset',[
					       'where' => [
					       'nomor' => $data['nomor'],
					    ]
					])->row();
					if(!isset($check->id)) {
					    $data['is_active']				= 1;
					    if(!$data['nomor']) {
					        $data['nomor']		= generate_code('tbl_asset','nomor');
					    }
					    
					    $save = insert_data('tbl_asset',$data);
					}else{
						$save = update_data('tbl_asset',$data,'nomor',$data['nomor']);
					}
					if(isset($save) && $save) $c++;
					
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
		$arr = ['nomor' => 'Nomor','nama_gedung' => 'Nama Gedung','alamat' => 'Alamat','kota' => 'Kota','titik_koordinat' => 'Titik Koordincat','pemilik' => 'Pemilik','status_asset' => 'Status Asset','skema_kerjasama' => 'Skema Kerjasama','status_tanah' => 'Status Tanah','tahun_status_tanah' => 'Tahun Status Tanah','luas_tanah' => 'Luas Tanah','LXP_tanah' => 'LXP Tanah','bentuk_tanah' => 'Bentuk Tanah','luas_bangunan' => 'Luas Bangunan','jumlah_ltbangunan' => 'Jumlah Ltbangunan','luas_area_idle' => 'Luas Area Idle','jenis_bangunan' => 'Jenis Bangunan','batasan_lahan' => 'Batasan Lahan','informasi_sekitar' => 'Informasi Sekitar','status_penggunaan' => 'Status Penggunaan','id_usulan_penggunaan' => 'Usulan Penggunaan','usulan_mitra' => 'Usulan Mitra','catu_daya' => 'Catu Daya','area' => 'Area','keterangan' => 'Keterangan'];
		$data = get_data('tbl_asset a',[
				'select' => 'a.*,b.pemilik_aset as pemilik, c.jenis_bangunan,d.skema_kerjasama,e.area',
				'join' 	 => ['tbl_pemilik_aset b on a.id_pemilik =b.id type LEFT',
							 'tbl_jenis_bangunan c on a.id_jenis_bangunan = c.id type LEFT',
							 'tbl_skema_kerjasama d on a.id_skema_kerjasama = d.id type LEFT',
							 'tbl_area e on a.id_area = e.id type LEFT'
				],
		])->result_array();
		$config = [
			'title' => 'data_daftar_aset',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function propar($id='') {
		$ids 	= decode_id($id);

		if(count($ids) == 2) {

		$propar 		= get_data('tbl_asset',[
			'where' => [
				'id' => $ids[0],
				'file !=' => '[]',	
			],
		])->row();                            
			if(isset($propar->file)) {
                $file = json_decode($propar->file,true);
                foreach($file as $k => $v) {
                	$file_url = base_url('assets/uploads/aset/'.$v);

					header('Content-Type: application/octet-stream');
					header("Content-Transfer-Encoding: Binary"); 
					header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
					readfile($file_url); 
                }
			} else {
				render('404');
			}
		} else {
			render('404');
		}
	}

}