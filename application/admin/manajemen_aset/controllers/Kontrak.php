<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kontrak extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_mitra'] = get_data('tbl_m_mitra a',[
			'select' => 'a.*,b.klasifikasi',
			'join'	 => 'tbl_m_klasifikasi_mitra b on a.id_klasifikasi = b.id type LEFT',
			'where'  => [
				'a.is_active' => 1,
			],
		])->result_array();
		$data['opt_asset'] = get_data('tbl_asset',[
			'where' => [
				'is_active'=> 1,
				'status_asset' => 'Komersial'	
			]
		])->result_array();

		$data['opt_skema_kerjasama'] = get_data('tbl_skema_kerjasama',[
			'where' => [
				'is_active' => 1
			],
			'sort_by' => 'skema_kerjasama',
			'sort' => 'ASC'
		])->result_array();
		render($data);
	}

	function data() {
		$config				= [
			'access_view' 	=> true,
		];

		$data = data_serverside($config);
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_kontrak','id',post('id'))->row_array();
		
		$endDate = strtotime($data['tanggal_akhir_kontrak_mitra']);
		$now = strtotime(date("Y-m-d"));

		$data['sisa_waktu_kontrak'] = floor(($endDate-$now) /(60*60*24)) ;

		$data['sisa_waktu_kontrak']	= $this->parse_waktu($data['sisa_waktu_kontrak']);

		$data['detail']	= get_data('tbl_perpanjang_kontrak a',[
			'select'	=> 'a.*',
			'where'		=> 'id_kontrak = '.post('id'),
		])->result_array();

		render($data,'json');
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

	function save() {

		$data = post();
		$tanggal = [];
		if(post('tanggal') != '') {
			$tanggal = post('tanggal');
		}

		$data['str_durasi_kontrak'] = strval($data['durasi_kontrak']) . ' Tahun';

		$endDate = strtotime($data['tanggal_akhir_kontrak_mitra']);
		$now = strtotime(date("Y-m-d"));

		$data['sisa_waktu_kontrak'] = floor(($endDate-$now) /(60*60*24)) ;

		$data['sisa_waktu_kontrak']	= $this->parse_waktu($data['sisa_waktu_kontrak']);

		$response = save_data('tbl_kontrak',$data,post(':validation'));

		if($response['status'] == 'success') {
			delete_data('tbl_perpanjang_kontrak','id_kontrak',$response['id']);
			if(count($tanggal)) {
				foreach($tanggal as $i) {
					insert_data('tbl_perpanjang_kontrak',[
						'tanggal_perpanjang'	=> $i,
						'id_kontrak'	=> $response['id']
					]);
				}
			}
		}
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_kontrak','id',post('id'));
		render($response,'json');
	}

	function detail($id='') {
		$data				= get_data('tbl_kontrak a',[
			'select' => 'a.*,c.perusahaan,c.alamat_perusahaan,d.nama_gedung,e.skema_kerjasama as skema_kerjasama_telkom_gsd,f.skema_kerjasama as skema_kerjasama_mitra_gsd ',
				
			'join'	 => ['tbl_m_mitra c on a.id_mitra = c.id type LEFT',
					     'tbl_asset d on a.id_asset = d.id type LEFT',
					     'tbl_skema_kerjasama e on a.id_skema_telkom_gsd = e.id type LEFT',
					     'tbl_skema_kerjasama f on a.id_skema_mitra_gsd = f.id type LEFT',
						],
			'where'  => [			
				'a.id' => $id,
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

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['nomor' => 'nomor','nama_perusahaan' => 'nama_perusahaan','klasifikasi' => 'klasifikasi','lokasi_gedung' => 'lokasi_gedung','alamat' => 'alamat','kota' => 'kota','tgl_bak_telkom_gsd' => 'tgl_bak_telkom_gsd','tgl_kontrak_telkom_gsd' => 'tgl_kontrak_telkom_gsd','nomor_kontrak_telkom_gsd' => 'nomor_kontrak_telkom_gsd','tgl_baso_telkom_gsd' => 'tgl_baso_telkom_gsd','tgl_bak_mitra_gsd' => 'tgl_bak_mitra_gsd', 'tgl_kontrak_mitra_gsd' => 'tgl_kontrak_mitra_gsd','nomor_kontrak_mitra_gsd' => 'nomor_kontrak_mitra_gsd','tgl_komersial' => 'tgl_komersial', 'durasi_kontrak' => 'durasi kontrak','skema_kerjasama_telkom_gsd' => 'skema_kerjasama_telkom_gsd','nilai_skema_kerjasama_telkom_gsd' => 'nilai_skema_kerjasama_telkom_gsd','skema_kerjasama_mitra_gsd' => 'skema_kerja_sama_mitra_gsd','nilai_skema_kerjasama_mitra_gsd' => 'nilai_skema_kerja_sama_mitra_gsd','investasi' => 'investasi','tanggal_akhir_kontrak_mitra' => 'tanggal_akhir_kontrak_mitra','sisa_waktu_kontrak' => 'sisa_waktu_kontrak'];
		$config[] = [
			'title' => 'template_import_kontrak',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nomor','nama_perusahaan','klasifikasi','lokasi_gedung','alamat','kota','tgl_bak_telkom_gsd','tgl_kontrak_telkom_gsd','nomor_kontrak_telkom_gsd','tgl_baso_telkom_gsd','tgl_bak_mitra_gsd','tgl_kontrak_mitra_gsd','nomor_kontrak_mitra_gsd','tgl_komersial','durasi_kontrak','skema_kerjasama_telkom_gsd','nilai_skema_kerjasama_telkom_gsd','skema_kerjasama_mitra_gsd','nilai_skema_kerjasama_mitra_gsd','investasi','tanggal_akhir_kontrak_mitra','sisa_waktu_kontrak'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);
					
					$check 	= get_data('tbl_kontrak',[
					       'where' => [
					       'nomor_kontrak' => $data['nomor'],
					    ]
					])->row();
					if(!isset($check->id)) {
					    $data['is_active']				= 1;
					    if(!$data['nomor']) {
					    	$data['nomor_kontrak'] = $data['nomor'];
					        $data['nomor_kontrak']		= generate_code('tbl_kontrak','nomor_kontrak');
					    }
					    
					    unset($data['nomor']);

					    $checkmitra 	= get_data('tbl_m_mitra','perusahaan',$data['nama_perusahaan'])->row();
					    if(isset($checkmitra->id)){
					        $data['id_mitra'] = $checkmitra -> id;
					    }

					    unset($data['nama_perusahaan']);
					    
					    $checkasset 	= get_data('tbl_asset','nama_gedung',$data['lokasi_gedung'])->row();
					    if(isset($checkasset->id)){	
					    	$data['id_asset'] =  $checkasset -> id;
					        $data['lokasi'] = $checkasset -> alamat;
					        $data['kota'] = $checkasset -> kota;
					    }    	

					    unset($data['lokasi_gedung']);	
					    unset($data['alamat']);

					    $checkskema 	= get_data('tbl_skema_kerjasama','skema_kerjasama',$data['skema_kerjasama_telkom_gsd'])->row();
					    if(isset($checkskema->id)){
					        $data['id_skema_telkom_gsd'] = $checkskema -> id;
					    }

					    unset($data['skema_kerjasama_telkom_gsd']);


					    $checkskema 	= get_data('tbl_skema_kerjasama','skema_kerjasama',$data['skema_kerjasama_mitra_gsd'])->row();
					    if(isset($checkskema->id)){
					        $data['id_skema_mitra_gsd'] = $checkskema -> id;
					    }

					    unset($data['skema_kerjasama_mitra_gsd']);

						$endDate = strtotime($data['tanggal_akhir_kontrak_mitra']);
						$now = strtotime(date("Y-m-d"));

						$data['sisa_waktu_kontrak'] = floor(($endDate-$now) /(60*60*24)) ;

						$data['sisa_waktu_kontrak']	= $this->parse_waktu($data['sisa_waktu_kontrak']);

					    $data['create_at'] 	= date('Y-m-d H:i:s');
					    $data['create_by'] 	= user('nama');
					    $save = insert_data('tbl_kontrak',$data);
					}else{
						$data['nomor_kontrak'] = $data['nomor'];			
					    $data['lokasi'] = $data['alamat'];

					    $endDate = strtotime($data['tanggal_akhir_kontrak_mitra']);
						$now = strtotime(date("Y-m-d"));

						$data['sisa_waktu_kontrak'] = floor(($endDate-$now) /(60*60*24)) ;

						$data['sisa_waktu_kontrak']	= $this->parse_waktu($data['sisa_waktu_kontrak']);


						unset($data['alamat']) ;
						unset($data['nomor']) ;
						unset($data['nama_perusahaan']);
						unset($data['lokasi_gedung']);
					    unset($data['skema_kerjasama_telkom_gsd']);
					    unset($data['skema_kerjasama_mitra_gsd']);
						$save = update_data('tbl_kontrak',$data,'nomor_kontrak',$data['nomor_kontrak']);
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
		$arr = ['nama_perusahaan' => 'Nama Perusahaan','klasifikasi' => 'Klasifikasi','lokasi_gedung' => 'Lokasi Gedung','alamat' => 'alamat','kota' => 'kota','tgl_bak_telkom_gsd'=>'Tgl BAK Telkom-GSD','tgl_kontrak_telkom_gsd'=>'Tgl Kontrak Telkom-GSD','nomor_kontrak_telkom_gsd'=>'No Kontrak Telkom-GSD','tgl_baso_telkom_gsd'=>'Tgl BASO Telkom-GSD','tgl_bak_mitra_gsd' => 'Tgl bak mitra-GSD','tgl_kontrak_mitra_gsd'=>'Tgl Kontrak Mitra-GSD', 'nomor_kontrak_mitra_gsd' => 'Nomor Kontrak Mitra-GSD','tgl_komersial'=>'Tgl Komersial','durasi_kontrak' => 'Durasi Kontrak','skema_kerjasama_telkom_gsd'=>'Skema Kerjasama Telkom-GSD','nilai_skema_kerjasama_telkom_gsd'=>'Nilai Skema Kerjasama Telkom-GSD','skema_kerjasama_mitra_gsd' => 'Skema Kerja Sama Mitra-GSD','nilai_skema_kerjasama_mitra_gsd' => 'Nilai Skema Kerja Sama Mitra-GSD','investasi'=>'investasi','tanggal_akhir_kontrak_mitra' => 'Tanggal Akhir Kontrak Mitra','sisa_waktu_kontrak' => 'Sisa Waktu Kontrak'];
		$data = get_data('tbl_kontrak a', [
			  'select' => 'a.*,b.perusahaan as nama_perusahaan,c.nama_gedung as lokasi_gedung,c.alamat,c.kota,d.skema_kerjasama as skema_kerjasama_mitra_gsd, e.skema_kerjasama as skema_kerjasama_telkom_gsd',
			  'join'   => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
			  			  'tbl_asset c on a.id_asset = c.id type LEFT',
			  			  'tbl_skema_kerjasama d on a.id_skema_mitra_gsd = d.id type LEFT',
			  			  'tbl_skema_kerjasama e on a.id_skema_telkom_gsd = e.id type LEFT'
			  			],
		])->result_array();
		$config = [
			'title' => 'data_kontrak',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}