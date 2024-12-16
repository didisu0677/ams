<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facility_management extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {

		$data['area']	= get_data('tbl_area','is_active = 1')->result_array();
		render($data);
	}

	function data() {
		$config['access_view'] = false;
		if(get('id_area')) $config['where']['id_area'] = get('id_area');
		$data = data_serverside($config);
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_facility_management','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
	    $data = post();
	    $data['is_active']	= 1;
	    
		$response = save_data('tbl_m_facility_management',$data,post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_facility_management','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['facility_management' => 'facility_management','id_area' => 'id_area'];
		$config[] = [
			'title' => 'template_import_facility_management',
			'header' => $arr,
		];
		$id_area = get_data('tbl_area',[
			'select' => 'id,area',
			'where' => 'is_active = 1'
		])->result_array();
		$config[] = [
			'title' => 'data_area',
			'data' => $id_area,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['facility_management','id_area'];
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
					$save = insert_data('tbl_m_facility_management',$data);
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
		$arr = ['facility_management' => 'Facility Management','id_area' => 'Id Area'];
		$data = get_data('tbl_m_facility_management')->result_array();
		$config = [
			'title' => 'data_facility_management',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}