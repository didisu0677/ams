<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_aktivitas extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		render();
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_status_aktivitas','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		
		if(post('id') != 0) {
			$status = get_data('tbl_status_aktivitas','id',post('id'))->row();
		}

		$response = save_data('tbl_status_aktivitas',post(),post(':validation'));

		
		if($response['status'] == 'success'){
			if(isset($status->id)) { 

				$stdetail = get_data('tbl_detail_aktivitas ',[
					'where' => [
					'id_status_aktivitas' => $status->id,
				]

				])->result();

				if($stdetail) {
					foreach ($stdetail as $st) {
						update_data('tbl_detail_aktivitas',['status_aktivitas'=>post('status')],'id_status_aktivitas',$status->id);

						$j_aktivitas = get_data('tbl_m_jenis_aktivitas ',[
							'where' => [
							'is_active'=> 1
							],
						])->result();

						foreach ($j_aktivitas as $j) {
							$_key = $j->_key ;
							update_data('tbl_m_aktivitas',[$_key => post('status')],$_key,$status->status);
						}

					}
				}	
			}
		}
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_status_aktivitas','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['status' => 'status','keterangan' => 'keterangan','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_status_aktivitas',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['status','keterangan','is_active'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);
					$data['create_at'] = date('Y-m-d H:i:s');
					$data['create_by'] = user('nama');
					$save = insert_data('tbl_status_aktivitas',$data);
					if($save) $c++;
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
		$arr = ['status' => 'Status','keterangan' => 'Keterangan','is_active' => 'Aktif'];
		$data = get_data('tbl_status_aktivitas')->result_array();
		$config = [
			'title' => 'data_status_aktivitas',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}