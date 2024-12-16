<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_aktivitas extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_grup_aktivitas'] = get_data('tbl_grup_aktivitas','is_active',1)->result_array();
		$data['opt_sub_aktivitas'] = get_data('tbl_sub_aktivitas','is_active',1)->result_array();
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_jenis_aktivitas','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_m_jenis_aktivitas',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_jenis_aktivitas','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['nama_aktivitas' => 'nama_aktivitas','group_aktivitas' => 'group_aktivitas','sub_aktivitas' => 'sub_aktivitas','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_jenis_aktivitas',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nama_aktivitas','group_aktivitas','sub_aktivitas','is_active'];
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
					$save = insert_data('tbl_m_jenis_aktivitas',$data);
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
		$arr = ['nama_aktivitas' => 'Nama Aktivitas','group_aktivitas' => 'Group Aktivitas','sub_aktivitas' => 'Sub Aktivitas','is_active' => 'Aktif'];
		$data = get_data('tbl_m_jenis_aktivitas')->result_array();
		$config = [
			'title' => 'data_jenis_aktivitas',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}