<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deskripsi_aset extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		render();
	}

	function save() {
		$data = post();
		foreach($data as $k => $v) {
			$check = get_data('tbl_setting','_key',$k)->row();
			if(isset($check->id)) update_data('tbl_setting',['_value'=>$v],'id',$check->id);
			else insert_data('tbl_setting',['_key'=>$k,'_value'=>$v]);
		}
		render([
			'status'	=> 'success',
			'message'	=> lang('data_berhasil_disimpan')
		],'json');
	}

	function get_user() {
		$query 	= get('query');
		$user 	= get_data('tbl_user','is_active=1 AND nama LIKE "%'.$query.'%" AND id_vendor = 0')->result();
		$data['suggestions'] = [];
		foreach($user as $u) {
			$data['suggestions'][] = [
				'value'	=> $u->nama.' | '.$u->jabatan,
				'data'	=> $u->id
			];
		}
		render($data,'json');
	}

}