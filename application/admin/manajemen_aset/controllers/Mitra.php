<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mitra extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_id_klasifikasi'] = get_data('tbl_m_klasifikasi_mitra',[
			'where' => [
				'is_active'=>1
			],
			'sort_by' => 'klasifikasi',
			'sort' => 'ASC'
			
		])->result_array();
		$data['opt_skema_kerjasama'] = get_data('tbl_skema_kerjasama',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'skema_kerjasama',
			'sort' => 'ASC'
		])->result_array();
		$data['opt_penanggung_jawab'] = get_data('tbl_penanggung_jawab_mitra',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'nama',
			'sort' => 'ASC'
		])->result_array();

		$data['opt_tipe_asset'] = get_data('tbl_m_tipe_asset',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'tipe_asset',
			'sort' => 'ASC'
		])->result_array();

		$data['opt_brand'] = get_data('tbl_m_brand',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'brand',
			'sort' => 'ASC'
		])->result_array();

		$data['luas_lahan'] = explode(',', setting('luas_tanah'));
		$data['luas_bangunan'] = explode(',', setting('luas_bangunan'));
		$data['jenis_bangunan'] = explode(',', setting('jenis_bangunan'));
		render($data);
	}

	function data() {
		$config	= [
			'access_view'	=> true,
		];

		$data = data_serverside($config);
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_mitra','id',post('id'))->row_array();
		$data['dir_upload'] = base_url(dir_upload('mitra'));
		render($data,'json');
	}

	function save() {
		$data = post();
		$brand = get_data('tbl_m_brand','id',$data['id_brand'])->row();
		if(isset($brand->brand)) $data['brand'] = $brand->brand;
		
		debug($data);die;
		$response = save_data('tbl_m_mitra',$data,post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_mitra','id',post('id'));
		render($response,'json');
	}

	function detail($id='') {
		$data				= get_data('tbl_m_mitra a',[
			'select' => 'a.*,b.klasifikasi,c.skema_kerjasama,d.nama as penanggung_jawab,e.tipe_asset',
			'join'	 => ['tbl_m_klasifikasi_mitra b on a.id_klasifikasi = b.id type LEFT',	
						 'tbl_skema_kerjasama c on a.id_skema_kerjasama = c.id type LEFT',
						 'tbl_penanggung_jawab_mitra d on a.penanggung_jawab_mitra = d.id type LEFT',
						 'tbl_m_tipe_asset e on a.id_tipe_asset = e.id type LEFT',
						],
			'where'  => [			
				'a.id' => $id,
			],
		])->row_array();
		render($data,'layout:false');
	}

	function template() {
		ini_set('memory_limit', '-1');
	
		$arr = ['nomor' => 'nomor','klasifikasi' => 'klasifikasi','brand' => 'brand','logo_brand' => 'logo_brand','perusahaan' => 'perusahaan','alamat_perusahaan' => 'alamat_perusahaan','pic_telepon' => 'pic_telepon','jumlah_kerjasama' => 'jumlah_kerjasama','skema_kerjasama' => 'skema_kerjasama','luas_lahan' => 'luas_lahan','luas_bangunan' => 'luas_bangunan','jenis_bangunan' => 'jenis_bangunan','special_request' => 'special_request','keterangan' => 'keterangan','penanggung_jawab_mitra' => 'penanggung_jawab_mitra'];
		$config[] = [
			'title' => 'template_import_mitra',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nomor','klasifikasi','brand','logo_brand','perusahaan','alamat_perusahaan','pic_telepon','jumlah_kerjasama','skema_kerjasama','luas_lahan','luas_bangunan','jenis_bangunan','special_request','keterangan','penanggung_jawab_mitra'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);
					
					$check 	= get_data('tbl_m_mitra',[
					       'where' => [
					       'nomor' => $data['nomor'],
					    ]
					])->row();
					if(!isset($check->id)) {
					    $data['is_active']				= 1;
					    if(!$data['nomor']) {
					        $data['nomor']		= generate_code('tbl_m_mitra','nomor');
					    }
					    
					    $checkklas 	= get_data('tbl_m_klasifikasi_mitra','klasifikasi',$data['klasifikasi'])->row();
					    if(isset($checkklas->id)){
					        $data['id_klasifikasi'] = $checkklas -> id;
					    }
					    
					    unset($data['klasifikasi']);

					    $checkskema 	= get_data('tbl_skema_kerjasama','skema_kerjasama',$data['skema_kerjasama'])->row();
					    if(isset($checkskema->id)){
					        $data['id_skema_kerjasama'] = $checkskema -> id;
					    }

					    unset($data['skema_kerjasama']);

					    $checkpjawab 	= get_data('tbl_penanggung_jawab_mitra','nama',$data['penanggung_jawab_mitra'])->row();
					    if(isset($checkpjawab->id)){
					        $data['penanggung_jawab_mitra'] = $checkpjawab -> id;
					    }else{
					    	$data['penanggung_jawab_mitra'] = 0;
					    }


					    $data['create_at'] 	= date('Y-m-d H:i:s');
					    $data['create_by'] 	= user('nama');
					    $save = insert_data('tbl_m_mitra',$data);
					}else{
						$save = update_data('tbl_m_mitra',$data,'nomor',$data['nomor']);
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
		$arr = ['nomor'=>'ID Perusahaan','klasifikasi' => 'Klasifikasi','brand' => 'Brand','logo_brand' => 'Logo Brand','perusahaan' => 'Perusahaan','alamat_perusahaan' => 'Alamat Perusahaan','pic_telepon' => 'Pic dan No. telepon','jumlah_kerjasama' => 'Jml Kerjasama dengan GSD','penanggung_jawab'=>'Penanggung Jawab Mitra','luas_lahan'=>'Luas Lahan','luas_bangunan'=>'Luas Bangunan','tipe_asset'=>'Tipe Asset','special_request'=>'Special Request','skema_kerjasama' => 'Skema Kerjasama','keterangan' => 'Keterangan'];
		$data = get_data('tbl_m_mitra a', [
			'select' =>  'a.*,b.klasifikasi,c.skema_kerjasama,d.nama as penanggung_jawab,e.tipe_asset',
			'join'	 =>  ['tbl_m_klasifikasi_mitra b on a.id_klasifikasi = b.id type LEFT',
			    'tbl_skema_kerjasama c on a.id_skema_kerjasama = c.id type LEFT','tbl_penanggung_jawab_mitra d on a.penanggung_jawab_mitra = d.id type LEFT',
			    'tbl_m_tipe_asset e on a.id_tipe_asset = e.id type LEFT', 
			],			
		])->result_array();
		$config = [
			'title' => 'data_mitra',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}