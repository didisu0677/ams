<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_asset'] = get_data('tbl_asset',[
			'where' => [
				'is_active'=> 1,
			]
		])->result_array();

		$data['opt_mitra'] = get_data('tbl_m_mitra a',[
			'select' => 'a.*,b.klasifikasi,c.nama as penanggung_jawab',
			'join'	 => ['tbl_m_klasifikasi_mitra b on a.id_klasifikasi = b.id type LEFT',
				'tbl_penanggung_jawab_mitra c on a.penanggung_jawab_mitra = c.id type LEFT'
			],
			'where' => [
				'a.is_active'=> 1,
			]
		])->result_array();

		$data['opt_fm'] = get_data('tbl_asset',[
			'select' => 'distinct id_fm as id, facility_management', 
			'where' => [
				'is_active'=> 1,
			]
		])->result_array();

		$data['opt_status'] = get_data('tbl_status_aktivitas',[
			'where' => [
				'is_active'=> 1,
			]
		])->result_array();
		foreach ($data['opt_status'] as $key => $v) {
			$st = 'st_' . $v['id'];
			$data[$st] = $v['status'];
		}
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
		$data = get_data('tbl_m_aktivitas','id',post('id'))->row_array();

		$data['detail'] = get_data('tbl_detail_aktivitas','id_m_aktivitas',post('id'))->result();

		render($data,'json');
	}

	function get_asset($type ='echo',$id_fm='') {
		if(post('id_fm') !=""){	
			$id_fm = post('id_fm');
	    }else{
	    	$id_fm = $id_fm;
	    }

	    $rs 			= get_data('tbl_asset a',[
	        'select'	=> 'a.*',
	        'where' 	=> [
	            'a.is_active' => 1,
	            'id_fm' => $id_fm
	        ]
	    ])->result();
	    $data 			= '<option value=""></option>';
	    foreach($rs as $e) {
	        $data 	.= '<option value="'.$e->id.'" data-alamat ="'.$e->alamat.'" data-id_kota="'.$e->id_kota.'" data-kota="'.$e->kota.'">'.$e->nama_gedung. '</option>'; 
	    }
	    
	    if($type == 'echo') echo $data;
	    else return $data;
	    
	}


	function save() {
		$data = post();

		$asset = get_data('tbl_asset','id',$data['id_asset'])->row();
		if(isset($asset->nama_gedung)){
			$data['nama_gedung'] = $asset->nama_gedung;
			$data['id_area'] = $asset->id_area;
			$data['id_kota'] = $asset->id_kota;
		}
		
		$mitra = get_data('tbl_m_mitra','id',$data['id_mitra'])->row();
		if(isset($mitra->brand)){
			$data['id_brand'] = $mitra->id_brand;
			$data['brand'] = $mitra->brand;
			$data['perusahaan'] = $mitra->perusahaan;
			$data['id_penanggung_jawab_mitra'] = $mitra->penanggung_jawab_mitra;
			$data['id_klasifikasi'] = $mitra->id_klasifikasi;
		}

		$response = save_data('tbl_m_aktivitas',$data,post(':validation'));
		
		if($response['status'] == 'success') {
			$m_aktivitas = get_data('tbl_m_aktivitas','id',$response['id'])->row();

			$j_aktivitas = get_data('tbl_m_jenis_aktivitas a',[
				'select' => 'a.*,b.grup_aktivitas,c.sub_aktivitas',
				'join'	 => ['tbl_grup_aktivitas b on a.id_grup_aktivitas = b.id type LEFT',
					'tbl_sub_aktivitas c on a.id_sub_aktivitas = c.id type LEFT'
				],	
				'where' => [
				'a.is_active'=> 1
				],
			])->result();

			delete_data('tbl_detail_aktivitas',['id_m_aktivitas'=>$response['id'],'nomor_aktivitas'=>$m_aktivitas->nomor_aktivitas]);
			foreach ($j_aktivitas as $j) {
				$_key = $j->_key ;

				$fields = get_field('tbl_m_aktivitas') ;

				$keterangan = 'k_' . $_key ;
				$keterangan = post($keterangan);

				foreach ($fields as $field) {
					if ($field->name == $_key){		

						$status = get_data('tbl_status_aktivitas','status',$data[$field->name])->row();
					//	debug($status);die;
						if(isset($status->id)){
							$data['id_status_aktivitas'] = $status->id;
						}

						$d = [		
							'id_m_aktivitas' => 		$response['id'],
							'nomor_aktivitas' => 		$m_aktivitas->nomor_aktivitas,
							'id_jenis_aktivitas' => $j->id,
							'nama_aktivitas' => $j->nama_aktivitas,
							'_key'	=> $j->_key,
							'grup_aktivitas' => $j->grup_aktivitas,
							'sub_aktivitas' => $j->sub_aktivitas,
							'id_status_aktivitas' => $data['id_status_aktivitas'],
							'status_aktivitas' => $data[$field->name],
							'keterangan' => $keterangan	
						];
						insert_data('tbl_detail_aktivitas',$d);
					}			        
				}
			}
			
			$progress = get_data('tbl_detail_aktivitas',[
				'select'  => 'id_status_aktivitas, status_aktivitas as status, count(id_status_aktivitas) as jumlah ',
				'where'   => [
					'id_m_aktivitas' => $response['id'],
					'nomor_aktivitas' => $m_aktivitas->nomor_aktivitas
				],
				'group_by' => 'id_status_aktivitas','status_aktivitas',
			])->result();
			$r1 = 0;
			$r2 = 0;
			$r3 = 0;
			$r4 = 0;

			foreach ($progress as $s) {

                if($s->id_status_aktivitas == 1) {
                    $r1 = $s->jumlah ;
                }

                if($s->id_status_aktivitas == 2) {
                    $r2 = $s->jumlah ;
                }

                if($s->id_status_aktivitas == 3) {
                    $r3 = $s->jumlah ;
                }

                if($s->id_status_aktivitas == 4) {
                    $r4 = $s->jumlah ;
                }
			}

			$rumus  = round(((($r2 * 1) + ( $r3 * (50/100)) + ( $r1 * 0)) / ($r2+$r3+$r1)) * 100,2);

			update_data('tbl_m_aktivitas',['progress'=>$rumus],['id'=>$response['id'],'nomor_aktivitas'=>$m_aktivitas->nomor_aktivitas]);

			$this->tahapan($response['id'],$m_aktivitas->nomor_aktivitas);

		}	


		render($response,'json');
	}

	function tahapan($id=0,$nomor_aktivitas='') {
		$aktivitas = get_data('tbl_detail_aktivitas a',[
 			'select' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'join'	=> 'tbl_sub_aktivitas b on a.sub_aktivitas = b.sub_aktivitas type LEFT',
 			'where' => [
 				'a.id_m_aktivitas' => $id,
 				'a.nomor_aktivitas' => $nomor_aktivitas
 			],
 			'group_by' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'sort_by'  => 'b.id,id_m_aktivitas',
 			'sort'	   => 'DESC',	
 		])->result(); 

	 	$si_b =[];
	 	$li_b =[];
	 	$ri_b =[];
	 	$ci_b =[]; 		
 		foreach ($aktivitas as $a) {
			$s[$a->sub_aktivitas][$a->status_aktivitas][] = $a->id_m_aktivitas ;	
 		}

 	 		
	 	foreach ($s as $si => $svalue) {
	 		if($si == 'KOMERSIAL') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					$si_b[] = $vivalue;					
	 					}
	 				}					 					
	 			}
	 				
	 		} 

	 		if($si == 'PELAKSANAAN') {
	 			foreach ($svalue as $vi => $vvalue) {

	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $si_b) == false) {
		 						$li_b[] = $vivalue;
		 					}						
	 					}
	 				}			
	 			}

	 		} 

	 		if($si == 'PROSES') {
	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (!in_array($vivalue, $li_b) && !in_array($vivalue, $si_b)) {
		 						$ri_b[] = $vivalue;
		 					}						
	 					}
	 				}							
	 			}


	 		} 

	 		if($si == 'PERENCANAAN') {

	 			foreach ($svalue as $vi => $vvalue) {
	 				if($vi == 'OK') {
	 					foreach ($vvalue as $vikey => $vivalue) {
		 					if (in_array($vivalue, $ri_b) == false && in_array($vivalue, $si_b) == false && in_array($vivalue, $li_b) == false) {
		 						$ci_b[] = $vivalue;
		 					}						
	 					}
	 				}							
	 			}

	 		} 

	 	}


		foreach ($si_b as $KOMERSIAL) {
			update_data('tbl_m_aktivitas',['id_tahapan' => 4],'id',$KOMERSIAL);
		}	

 		foreach ($li_b as $PELAKSANAAN) {
			update_data('tbl_m_aktivitas',['id_tahapan' => 3],'id',$PELAKSANAAN);
		}	

 		foreach ($ri_b as $PROSES) {
 			update_data('tbl_m_aktivitas',['id_tahapan' => 2],'id',$PROSES);
 		}	

 		foreach ($ci_b as $PERENCANAAN) {
 			update_data('tbl_m_aktivitas',['id_tahapan' => 1],'id',$PERENCANAAN);
 		}	
	
	}

	function delete() {
		$response = destroy_data('tbl_m_aktivitas','id',post('id'));
		$response = destroy_data('tbl_detail_aktivitas','id_m_aktivitas',post('id'));
		render($response,'json');
	}

	function detail($id='') {
		$data				= get_data('tbl_m_aktivitas a',[
			'select' => 'a.*,b.facility_management',
			'join'	 => ['tbl_m_facility_management b on a.id_fm = b.id type LEFT'
			],
			'where'  => [			
				'a.id' => $id,
			],
		])->row_array();

		$data['perencanaan1'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'PROGRESS TELKOM PROPERTY',
			'a.sub_aktivitas'  => 'PERENCANAAN',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['proses1'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'PROGRESS TELKOM PROPERTY',
			'a.sub_aktivitas'  => 'PROSES',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['pelaksanaan1'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'PROGRESS TELKOM PROPERTY',
			'a.sub_aktivitas'  => 'PELAKSANAAN',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['proses2'] 	= get_data('tbl_detail_aktivitas a',[		'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',			
			'where' => [
			'a.grup_aktivitas' => 'TELKOM INDONESIA',
			'a.sub_aktivitas'  => 'PROSES',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['pelaksanaan2'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'TELKOM INDONESIA',
			'a.sub_aktivitas'  => 'PELAKSANAAN',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['perencanaan3'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'MITRA',
			'a.sub_aktivitas'  => 'PERENCANAAN',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['proses3'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'MITRA',
			'a.sub_aktivitas'  => 'PROSES',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['pelaksanaan3'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'MITRA',
			'a.sub_aktivitas'  => 'PELAKSANAAN',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['komersial'] 	= get_data('tbl_detail_aktivitas a',[
			'select' => 'a.*, b.warna',
			'join'	 => 'tbl_status_aktivitas b on a.status_aktivitas = b.status type LEFT',
			'where' => [
			'a.grup_aktivitas' => 'MITRA',
			'a.sub_aktivitas'  => 'KOMERSIAL',
			'a.id_m_aktivitas' => $id
 			],
 			'sort_by' => 'a.id_jenis_aktivitas'
		])->result();

		$data['status'] = get_data('tbl_status_aktivitas','is_active',1)->result();

		$summary = get_data('tbl_detail_aktivitas',[
			'select' => 'status_aktivitas,count(status_aktivitas) as count',
			'where'	 => [
				'id_m_aktivitas' => $id,
			],
			'group_by' => 'status_aktivitas'	
		])->result();

		foreach ($data['status'] as $status) {
			$st = 'st_' . $status->status ;
			$data[$st] = 0;
		}

		foreach ($summary as $sum) {
			$st = 'st_' . $sum->status_aktivitas ;
			$data[$st] = $sum->count;
		}
		
		render($data,'layout:false');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['nomor_aktivitas' => 'nomor_aktivitas','id_fm' => 'id_fm','id_asset' => 'id_asset','nama_gedung' => 'nama_gedung','alamat' => 'alamat','kota' => 'kota','id_mitra' => 'id_mitra','brand' => 'brand','klasifikasi' => 'klasifikasi','perusahaan' => 'perusahaan','penanggung_jawab_mitra' => 'penanggung_jawab_mitra','pembuatan_propar' => 'pembuatan_propar','penawaran_mitra' => 'penawaran_mitra','approval_manajemen' => 'approval_manajemen','pembuatan_aki' => 'pembuatan_aki','kesepakatan_gsd_mitra' => 'kesepakatan_gsd_mitra','bak_gsd_mitra' => 'bak_gsd_mitra','pks_gsd_mitra' => 'pks_gsd_mitra','juskeb_konsultan' => 'juskeb_konsultan','pengadaan_konsultan' => 'pengadaan_konsultan','desain_dan_rab' => 'desain_dan_rab','perizinan' => 'perizinan','juskeb_kontraktor' => 'juskeb_kontraktor','pengadaan_kontraktor' => 'pengadaan_kontraktor','konstruksi_dan_fo' => 'konstruksi_dan_fo','bast_lahan_mitra' => 'bast_lahan_mitra','baso_gsd_telkom' => 'baso_gsd_telkom','sertifikat' => 'sertifikat','ba_acceptance' => 'ba_acceptance','relokasi' => 'relokasi','owner_estimate' => 'owner_estimate','kesepakatan_telkom_gsd' => 'kesepakatan_telkom_gsd','justifikasi_inisiatif_bisnis' => 'justifikasi_inisiatif_bisnis','bak_telkom_gsd' => 'bak_telkom_gsd','pks_telkom_gsd' => 'pks_telkom_gsd','approval_demolish' => 'approval_demolish','pelaksanaan_demolish' => 'pelaksanaan_demolish','surat_pernyataan_bersama' => 'surat_pernyataan_bersama','bast_lahan_gsd' => 'bast_lahan_gsd','assesment_lokasi' => 'assesment_lokasi','letter_of_interest' => 'letter_of_interest','business_plan_mitra' => 'business_plan_mitra','prelim_budget_est' => 'prelim_budget_est','approval_desain' => 'approval_desain','kontruksi_dan_fo' => 'kontruksi_dan_fo','perizinan_operasional' => 'perizinan_operasional','komersial' => 'komersial','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_aktivitas',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['nomor_aktivitas','id_fm','id_asset','nama_gedung','alamat','kota','id_mitra','brand','klasifikasi','perusahaan','penanggung_jawab_mitra','pembuatan_propar','penawaran_mitra','approval_manajemen','pembuatan_aki','kesepakatan_gsd_mitra','bak_gsd_mitra','pks_gsd_mitra','juskeb_konsultan','pengadaan_konsultan','desain_dan_rab','perizinan','juskeb_kontraktor','pengadaan_kontraktor','konstruksi_dan_fo','bast_lahan_mitra','baso_gsd_telkom','sertifikat','ba_acceptance','relokasi','owner_estimate','kesepakatan_telkom_gsd','justifikasi_inisiatif_bisnis','bak_telkom_gsd','pks_telkom_gsd','approval_demolish','pelaksanaan_demolish','surat_pernyataan_bersama','bast_lahan_gsd','assesment_lokasi','letter_of_interest','business_plan_mitra','prelim_budget_est','approval_desain','kontruksi_dan_fo','perizinan_operasional','komersial','is_active'];
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
					$save = insert_data('tbl_m_aktivitas',$data);
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
		$arr = ['nomor_aktivitas' => 'Nomor Aktivitas','facility_management' => 'Facility Management','nama_gedung' => 'Nama Gedung','alamat' => 'Alamat','kota' => 'Kota','brand' => 'Brand','klasifikasi' => 'Klasifikasi','perusahaan' => 'Perusahaan','penanggung_jawab_mitra' => 'Penanggung Jawab Mitra','status_terakhir'=>'Status Terakhir','next_action'=>'Next Action','support_needed'=>'Support Needed','update_terakhir'=>'Update terakhir','pembuatan_propar' => 'Pembuatan Propar','penawaran_mitra' => 'Penawaran Mitra','approval_manajemen' => 'Approval Manajemen','pembuatan_aki' => 'Pembuatan Aki','kesepakatan_gsd_mitra' => 'Kesepakatan Sharing Gsd Mitra','bak_gsd_mitra' => 'Bak Gsd Mitra','pks_gsd_mitra' => 'Pks Gsd Mitra','juskeb_konsultan' => 'Juskeb Konsultan','pengadaan_konsultan' => 'Pengadaan Konsultan','desain_dan_rab' => 'Desain Dan Rab','perizinan' => 'Perizinan','juskeb_kontraktor' => 'Juskeb Kontraktor','pengadaan_kontraktor' => 'Pengadaan Kontraktor','konstruksi_dan_fo' => 'Konstruksi Dan Fo','bast_lahan_mitra' => 'Bast Lahan Mitra','baso_gsd_telkom' => 'Baso Gsd Telkom','sertifikat' => 'Clear & Clean Lahan','ba_acceptance' => 'Ba Acceptance','relokasi' => 'Relokasi','owner_estimate' => 'Owner Estimate','kesepakatan_telkom_gsd' => 'Kesepakatan Sharing Telkom Gsd','justifikasi_inisiatif_bisnis' => 'Justifikasi Inisiatif Bisnis','bak_telkom_gsd' => 'Bak Telkom Gsd','pks_telkom_gsd' => 'Pks Telkom Gsd','approval_demolish' => 'Approval Demolish','pelaksanaan_demolish' => 'Pelaksanaan Demolish','surat_pernyataan_bersama' => 'Surat Pernyataan Bersama','bast_lahan_gsd' => 'Bast Lahan Gsd','assesment_lokasi' => 'Assesment Lokasi','letter_of_interest' => 'Letter Of Interest','business_plan_mitra' => 'Business Plan Mitra','prelim_budget_est' => 'Prelim Budget Est','approval_desain' => 'Approval Desain','kontruksi_dan_fo' => 'Kontruksi Dan Fo','perizinan_operasional' => 'Perizinan Operasional','komersial' => 'Komersial','progress' => 'Progress','sub_aktivitas' => 'Tahapan','is_active' => 'Aktif'];
		$data = get_data('tbl_m_aktivitas a', [
			'select' => 'a.*,b.sub_aktivitas,c.facility_management, CASE
				    WHEN a.update_at != "0000-00-00 00:00:00" and a.update_by != "" THEN CONCAT(a.update_at, " oleh : ", a.update_by)
				END as update_terakhir',
			'join'	 => ['tbl_sub_aktivitas b on a.id_tahapan = b.id type LEFT','tbl_m_facility_management c on a.id_fm = c.id type LEFT' 
			],
		])->result_array();
		$config = [
			'title' => 'data_aktivitas',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}