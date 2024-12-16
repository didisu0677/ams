<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_by_brand extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['brand']	= get_data('tbl_kontrak a',[
			'select' => 'distinct b.id_brand as id, b.brand',
			'join'	 => 'tbl_m_mitra b on a.id_mitra = b.id type LEFT',		
			'where' => [
				'a.is_active' => 1,
			],
		])->result_array();

		render($data);
	}

	function view() {
		$brand			= post('id_brand');

		$where 				= [
			'a.is_active ' 	=> 1,
		];

		if($brand != 'all') $where['d.id_brand']	= $brand;
		$kontrak 			= get_data('tbl_kontrak a',[
			'select'	=> 'a.id, b.id_kota, a.id_asset, c.nama_kota',
			'join'		=> ['tbl_asset b on a.id_asset = b.id type LEFT',
							'tbl_m_kota c on b.id_kota = c.id type LEFT',
							'tbl_m_mitra d on a.id_mitra = d.id type LEFT',
							'tbl_m_brand e on d.id_brand = e.id type LEFT' 
			],
			'sort_by' => 'c.nama_kota',
			'where'		=> $where

		])->result();
		$kota 		= [];
		foreach($kontrak as $d) {
			$kota[$d->id_kota]	= $d->nama_kota;
		}

		if($brand) {
			$jumlah = 0;

			$z = 0;
			$zid = '';
			$data['jumlah'][] = 0;
			foreach($kota as $k => $v) {	
				$zid = $v;	
				$where 				= [
					'a.is_active ' 	=> 1,
					'b.id_kota' => $k
				];

				if($brand != 'all') $where['d.id_brand']	= $brand;

				$data['result'][$v]	= get_data('tbl_kontrak a',[
					'select'	=> 'a.*, b.id_kota, c.nama_kota,d.brand,d.perusahaan,b.nama_gedung,b.alamat',
					'join'		=> ['tbl_asset b on a.id_asset = b.id type LEFT',
									'tbl_m_kota c on b.id_kota = c.id type LEFT',
									'tbl_m_mitra d on a.id_mitra = d.id type LEFT'
					],
					'where'		=> $where
				])->result_array();

				
				$z = 0;
				$data['jumlah'][$zid] = 0;
				foreach($data['result'][$v] as $n => $x) {
					if($x['id_kota'] == $k) {
						$z++;
						$data['jumlah'][$zid]	= $z;
					}
					$data['result'][$v][$n]['brand']	= $x['brand'];
					$data['result'][$v][$n]['perusahaan']	= $x['perusahaan'] ;
					$data['result'][$v][$n]['lokasi']	= $x['nama_gedung'];
					$data['result'][$v][$n]['alamat']	= $x['alamat'];
					$data['result'][$v][$n]['kota']	= $x['kota'];
					$data['result'][$v][$n]['tanggal_akhir']	= date_indo($x['tanggal_akhir_kontrak_mitra']);

				}
				

			}

			if(post('tipe') == 'pdf') {
				ini_set('memory_limit', '-1');
				$data['id_brand']		= $brand;
				$data['nm_brand'] = $nm_brand;

				render($data,'pdf:landscape');
			} elseif(post('tipe') == 'excel') {
				$overall 	= [];
				foreach($data['result'] as $k => $v) {
					$overall[] 	= [
						'Kota'	=> $k,
						'jumlah'			=> count($v)
					];
				}
				$config[]	= [
					'data'		=> $overall,
					'title'		=> 'Dashboard by Brand',
					'image'		=> 'assets/images/'.user('id').'_dashboard_by_brand.png'
				];
				foreach($data['result'] as $k => $v) {
					$config[]	= [
						'data'		=> $v,
						'title'		=> $k,
						'header'	=> [
							'brand'					=> 'Brand',
							'perusahaan'			=> 'Perusahaan',
							'nama_gedung'			=> 'Lokasi',
							'alamat'				=> 'Alamat',
							'kota'					=> 'Kota',
							'tanggal_akhir_kontrak_mitra'				=> 'Tanggal Akhir Kontrak',
						],
					];
				}
				$this->load->library('simpleexcel',$config);
				$this->simpleexcel->header([
					'brand'		=> $nm_brand,
				]);
				$this->simpleexcel->export();
			} else {
				render($data,'json');
			}
		} else {
			$response	= array(
	            'status'	=> 'failed',
	            'message'	=> 'Permission Denied',
	        );
			render($response,'json');
		}
	}

}