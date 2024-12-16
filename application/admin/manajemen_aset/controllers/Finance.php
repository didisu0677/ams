<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_mitra'] = get_data('tbl_kontrak a',[
			'select' => 'distinct a.id_mitra as id,b.brand,b.perusahaan,b.id_klasifikasi,c.klasifikasi',
			'join'	 => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
						'tbl_m_klasifikasi_mitra c on b.id_klasifikasi = c.id type LEFT',
						
			],
			'where'  => [
				'a.is_active' => 1,
			],
		])->result_array();

		render($data);
	}

	function data($tahun="") {

		$config =[

	    ];
	    
	   	$config['button'][]		= button_serverside('btn-success','export_detail',['fa-download',lang('export_detail'),true],'export');

	    if($tahun) {
	    	$config['where']['tahun'] 	= $tahun;	
	    }

		$config['sort_by'] = 'tahun';

		$data = data_serverside($config);
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_finance','id',post('id'))->row_array();

		$data['tanggal_komersial'] = date_indo($data['tanggal_komersial']);

		$data['detail'] = get_data('tbl_detail_finance',[
			'where' => [
			'id_m_finance' => post('id')
		],	
		'sort_by' => 'bulan'
		])->result();
		render($data,'json');
	}


	function get_asset($type ='echo',$id_mitra='') {
		if(post('id_mitra') !=""){	
			$id_mitra = post('id_mitra');
	    }else{
	    	$id_mitra = $id_mitra;
	    }


		$rs = get_data('tbl_kontrak a',[
			'select' => 'distinct a.id_asset as id, a.nomor_kontrak_mitra_gsd, b.facility_management, d.area, a.tgl_komersial as tanggal_komersial,b.nama_gedung, b.alamat, b.kota',
			'join'	=> ['tbl_asset b on a.id_asset = b.id type inner',
						'tbl_area d on b.id_area = d.id type inner'
					],
			'where' => [
				'a.is_active'=> 1,	
				'a.id_mitra' => $id_mitra
			]
		])->result();

	    $data 			= '<option value=""></option>';
	    foreach($rs as $e) {
	        $data 	.= '<option value="'.$e->id.'" data-alamat ="'.$e->alamat.'" data-kota="'.$e->kota.'" data-nomor_kontrak ="'.$e->nomor_kontrak_mitra_gsd.'" data-area="'.$e->area.'" data-fm= "'.$e->facility_management.'" data-tanggal_komersial="'.date_indo($e->tanggal_komersial).'">'.$e->nama_gedung. '</option>'; 
	    }

	   	if($type == 'echo') echo $data;
	    else return $data;
	}

	function revenue($id=0) {

		$data['data']	= get_data('tbl_detail_finance',[
			'where'		=> 'id_m_finance = "'.$id.'"',
			'select'	=> 'bulan, revenue',
			'sort_by'	=> 'bulan'
		])->result();

		render($data,'layout:false');
	}
	    
	function save() {

		$data = post();
		$kontrak = get_data('tbl_kontrak',[
			'where' => [				
				'id_asset' => post('id_asset'),
				'id_mitra' => post('id_mitra'),
			],
		])->row();

		if(isset($kontrak->id)) {
			$data['tanggal_komersial'] = $kontrak->tgl_komersial;
		}

		$data['revenue'] = str_replace(['.',','],'',post('total_revenue'));
		$data['beban_cogs'] = str_replace(['.',','],'',post('total_beban_cogs'));
		$data['beban_operasional'] = str_replace(['.',','],'',post('total_beban_operasional'));
		$data['biaya_perbaikan'] = str_replace(['.',','],'',post('total_biaya_perbaikan'));
		$data['piutang'] = str_replace(['.',','],'',post('total_piutang'));

		$mitra = get_data('tbl_m_mitra','id',post('id_mitra'))->row();
		if(isset($mitra->id)) $data['id_klasifikasi'] = $mitra->id_klasifikasi;
		if(isset($mitra->id_brand)) $data['id_brand'] = $mitra->id_brand;


		$asset = get_data('tbl_asset','id',$data['id_asset'])->row();

		if(isset($asset->id)){
			$data['lokasi'] = $asset->nama_gedung;
			$data['id_fm'] = $asset->id_fm;
			$data['id_area'] = $asset->id_area;
		}


		$response = save_data('tbl_m_finance',$data,post(':validation'));

		if($response['status'] == 'success') {
			$finance = get_data('tbl_m_finance','id',$response['id'])->row();			
			$revenue 			= post('revenue');
			$cogs 				= post('beban_cogs');
			$operasional 		= post('beban_operasional');
			$perbaikan 			= post('biaya_perbaikan');
			$piutang            = post('piutang');   
			$tgl_unbill			= post('tanggal_unbill');
			$tgl_bill			= post('tanggal_bill');
			$tgl_paid			= post('tanggal_paid');
			$d_keterangan		= post('d_keterangan');
			$status_finance		= post('status_finance');

			$x =[];
			$i = 0;
			foreach ($tgl_unbill as $t) {
				$i++;
				$x[$i] = $t;
			}

			$y =[];
			$i = 0;
			foreach ($tgl_bill as $t) {
				$i++;
				$y[$i] = $t;
			}

			$z =[];
			$i = 0;
			foreach ($tgl_paid as $t) {
				$i++;
				$z[$i] = $t;
			}

			$id_lap 				= post('id_lap');
			$file_lap_keuangan		= post('file_lap_keuangan');
			$old_file_lap 			= post('old_file_lap');

			$id_rab 				= post('id_rab');
			$file_rab_perbaikan		= post('file_rab_perbaikan');
			$old_file_rab 			= post('old_file_rab');

			$id_tagihan 			= post('id_tagihan');
			$file_tagihan			= post('file_tagihan');
			$old_file_tagihan 		= post('old_file_tagihan');

			$id_transfer 			= post('id_transfer');
			$file_bukti_transfer	= post('file_bukti_transfer');
			$old_file_transfer 		= post('old_file_transfer');

			$d 	= [];
			$dir 				= '';
			for ($i = 1; $i <= 12; $i++) {

				if(!is_dir(FCPATH . "assets/uploads/finance/")){
					$oldmask = umask(0);
					mkdir(FCPATH . "assets/uploads/finance/",0777);
					umask($oldmask);
				}
				$dok 			= get_data('tbl_detail_finance','bulan',$id_lap[$i])->row();

				$d[$i] 			= [
					'id_m_finance' => $response['id'],
					'nomor'		=> $finance->nomor,
					'tahun'		=> $finance->tahun,
					'bulan'		=> $i,
					'revenue'	=> str_replace(['.',','],'',$revenue[$i]), 
					'beban_cogs' => str_replace(['.',','],'',$cogs[$i]), 
					'beban_operasional' => str_replace(['.',','],'',$operasional[$i]), 
					'biaya_perbaikan' => str_replace(['.',','],'',$perbaikan[$i]), 
					'piutang'	=> str_replace(['.',','],'',$piutang[$i]), 
					'tanggal_unbill'	=> date('Y-m-d',strtotime(str_replace('/', '-', $x[$i]))),
					'tanggal_bill'	=> date('Y-m-d',strtotime(str_replace('/', '-', $y[$i]))), 
					'tanggal_paid'	=> date('Y-m-d',strtotime(str_replace('/', '-', $z[$i]))), 
					'file_laporan_keuangan'			=> $old_file_lap[$i],
					'file_rab'	=> 	$old_file_rab[$i],
					'file_tagihan' => $old_file_tagihan[$i],
					'file_bukti_transfer' => $old_file_transfer[$i],
					'keterangan' => $d_keterangan[$i],
					'status_finance' => $status_finance[$i]
				];


				if($file_lap_keuangan[$i] && $file_lap_keuangan[$i] != $old_file_lap[$i]) {
					if(@copy($file_lap_keuangan[$i], FCPATH . 'assets/uploads/finance/'.basename($file_lap_keuangan[$i]))) {
						$d[$i]['file_laporan_keuangan']	= basename($file_lap_keuangan[$i]);
						
						if(!$dir) $dir = str_replace(basename($file_lap_keuangan[$i]),'',$file_lap_keuangan[$i]);
						if($old_file_lap[$i]) {
							@unlink(FCPATH . 'assets/uploads/finance/'.$old_file_lap[$i]);
						}
					}
				}elseif(!$file_lap_keuangan[$i]) {
				    $d[$i]['file_laporan_keuangan'] = '';
				    if($old_file_lap[$i]) {
				        @unlink(FCPATH . 'assets/uploads/finance/'.$old_file_lap[$i]);
				    }
				}  

				if($file_rab_perbaikan[$i] && $file_rab_perbaikan[$i] != $old_file_rab[$i]) {
					if(@copy($file_rab_perbaikan[$i], FCPATH . 'assets/uploads/finance/'.basename($file_rab_perbaikan[$i]))) {
						$d[$i]['file_rab']	= basename($file_rab_perbaikan[$i]);
						
						if(!$dir) $dir = str_replace(basename($file_rab_perbaikan[$i]),'',$file_rab_perbaikan[$i]);
						if($old_file_rab[$i]) {
							@unlink(FCPATH . 'assets/uploads/finance/'.$old_file_rab[$i]);
						}
					}
				}elseif(!$file_rab_perbaikan[$i]) {
				    $d[$i]['file_rab'] = '';
				    if($old_file_rab[$i]) {
				        @unlink(FCPATH . 'assets/uploads/finance/'.$old_file_rab[$i]);
				    }
				}  

				if($file_tagihan[$i] && $file_tagihan[$i] != $old_file_tagihan[$i]) {
					if(@copy($file_tagihan[$i], FCPATH . 'assets/uploads/finance/'.basename($file_tagihan[$i]))) {
						$d[$i]['file_tagihan']	= basename($file_tagihan[$i]);
						
						if(!$dir) $dir = str_replace(basename($file_tagihan[$i]),'',$file_tagihan[$i]);
						if($old_file_tagihan[$i]) {
							@unlink(FCPATH . 'assets/uploads/finance/'.$old_file_tagihan[$i]);
						}
					}
				}elseif(!$file_tagihan[$i]) {
				    $d[$i]['file_tagihan'] = '';
				    if($old_file_tagihan[$i]) {
				        @unlink(FCPATH . 'assets/uploads/finance/'.$old_file_tagihan[$i]);
				    }
				}  

				if($file_bukti_transfer[$i] && $file_bukti_transfer[$i] != $old_file_transfer[$i]) {
					if(@copy($file_bukti_transfer[$i], FCPATH . 'assets/uploads/finance/'.basename($file_bukti_transfer[$i]))) {
						$d[$i]['file_bukti_transfer']	= basename($file_bukti_transfer[$i]);
						
						if(!$dir) $dir = str_replace(basename($file_bukti_transfer[$i]),'',$file_bukti_transfer[$i]);
						if($old_file_transfer[$i]) {
							@unlink(FCPATH . 'assets/uploads/finance/'.$old_file_transfer[$i]);
						}
					}
				}elseif(!$file_bukti_transfer[$i]) {
				    $d[$i]['file_bukti_transfer'] = '';
				    if($old_file_transfer[$i]) {
				        @unlink(FCPATH . 'assets/uploads/finance/'.$old_file_transfer[$i]);
				    }
				}  
			}	

			delete_data('tbl_detail_finance','id_m_finance',$response['id']);
			if(count($d)) {
				$save 	= insert_batch('tbl_detail_finance',$d);
			}

			$piutang = get_data('tbl_detail_finance',[
				'where' => [
					'id_m_finance'=> $response['id']
				],
				'sort_by' => 'bulan',
				'sort'	=>'ASC'
			])->result();
			
			$piutang_unbill = 0;
			$piutang_bill = 0;
			$piutang_paid = 0;
			$status = 0;
			$last_status = '';
			$last_statusm = '';
			$age ='';
			foreach ($piutang as $p) {
				if($p->tanggal_unbill !='0000-00-00' && $p->tanggal_unbill != '1970-01-01'){
					$piutang_unbill += $p->piutang;
					$last_status = 'Unbill';
					$last_statusm = 'Unbill';

					$today     = new DateTime();
					$selectDay = new DateTime($p->tanggal_unbill);
					$interval  = date_diff( $selectDay, $today);

					$age1 = $interval->format("%y");
				//	$age2 = $interval->format("%m");
				//	$age = $age1.$age2;
					$age2 = $interval->format("%a");

					if ($age2 >= 0 && $age2 <= 31) {
					  $age = '01';
					} elseif ($age2 >= 32 && $age2 <= 122) {
					  $age = '03';
					} elseif ($age2 >= 123 && $age2 <= 213) { 
					  $age = '06';
					} elseif ($age2 >= 214 && $age2 <= 365) { 
					  $age = '12';  
					} else {
					  $age = '99';
					}

				}

				if($p->tanggal_bill !='0000-00-00' && $p->tanggal_bill != '1970-01-01'){
					$piutang_bill += $p->piutang;
					$piutang_unbill = 0;
					$last_status = 'Bill';	
					$last_statusm = 'Bill';	

					$today     = new DateTime();
					$selectDay = new DateTime($p->tanggal_bill);
					$interval  = date_diff( $selectDay, $today);

					$age1 = $interval->format("%y");
					$age2 = $interval->format("%m");
				//	$age2 = $interval->format("%m");
				//	$age = $age1.$age2;
					$age2 = $interval->format("%a");

					if ($age2 >= 0 && $age2 <= 31) {
					  $age = '01';
					} elseif ($age2 >= 32 && $age2 <= 122) {
					  $age = '03';
					} elseif ($age2 >= 123 && $age2 <= 213) { 
					  $age = '06';
					} elseif ($age2 >= 214 && $age2 <= 365) { 
					  $age = '12';  
					} else {
					  $age = '99';
					}

				}

				if($p->tanggal_paid !='0000-00-00' && $p->tanggal_paid != '1970-01-01'){
					$piutang_paid += $p->piutang;
					$last_status = 'Paid';
					$last_statusm = 'Paid';		
					$piutang_bill = 0;
					$piutang_unbill = 0;	
				}
				
				$st_age ='';
				$st_current = get_data('tbl_m_status_aging','status',$age)->row();
				if(isset($st_current)) {
					$st_age = $st_current->status_age; 
				}else{
					if($age != '') {
						$st_age = '>1 Tahun'; 
					}
				}	

				if($p->revenue > 0 || $p->piutang > 0) $status=$p->status_finance;
				if($p->revenue > 0 || $p->piutang > 0) $last_status=$last_status;
				if($p->revenue > 0 || $p->piutang > 0) $age=$age;
			
				update_data('tbl_detail_finance',['status_bill'=>$last_status,'piutang_unbill'=>$piutang_unbill,'piutang_bill'=>$piutang_bill,'piutang_paid'=>$piutang_paid, 'umur_piutang'=>$age,'status_current'=>$st_age],['id'=>$p->id, 'bulan'=>$p->bulan,'id_m_finance'=>$p->id_m_finance]);


				$last_status ='';
				$piutang_unbill = 0;
				$piutang_bill = 0;
				$piutang_paid = 0;
				$age ='';
			}

			$stpiutang = get_data('tbl_detail_finance',[
				'select' => 'sum(piutang) as piutang, sum(piutang_unbill) as piutang_unbill,sum(piutang_bill) as piutang_bill,sum(piutang_paid) as piutang_paid',
				'where'  => [
					'id_m_finance' => $p->id_m_finance,
				]
			])->row();

			update_data('tbl_m_finance',['piutang' => $stpiutang->piutang, 'piutang_unbill'=>$stpiutang->piutang_unbill,'piutang_bill'=>$stpiutang->piutang_bill,'piutang_paid'=>$stpiutang->piutang_paid, 'status_accrue'=>$status,'status_bill'=>$last_statusm],'id',$response['id']);
		}


		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_finance','id',post('id'));
		if($response['status'] == 'success') {
			destroy_data('tbl_detail_finance','id_m_finance',post('id'));
		}	
		render($response,'json');
	}

	function detail($id='') {
		$data				= get_data('tbl_m_finance a',[
			'select' => 'a.*,CASE portfolio
				when 1 then "Ubis"
				when 2 then "Non Ubis"
				END as port,
				b.perusahaan,c.nama_gedung,e.klasifikasi,c.alamat,c.kota',
				
			'join'	 => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
					     'tbl_asset c on a.id_asset = c.id type LEFT',
					     'tbl_m_klasifikasi_mitra e on b.id_klasifikasi = e.id type LEFT'
						],
			'where'  => [			
				'a.id' => $id,
			],
		])->row_array();

		$data['detail'] = get_data('tbl_detail_finance a',[
			'select'  => 'a.*',
			'join'	=> 'tbl_m_finance b on a.id_m_finance = b.id type LEFT',
			'where' => [
			'a.id_m_finance' => $id
		],	
		'sort_by' => 'a.bulan'
		])->result();

		render($data,'layout:false');
	}


	function export() {
		ini_set('memory_limit', '-1');
		$arr = ['perusahaan' => 'Perusahaan','lokasi' => 'Lokasi Gedung','alamat' => 'Alamat', 'kota' => 'Kota','klasifikasi' => 'Klasifikasi','nomor_kontrak_mitra_gsd' => 'Nomor Kontrak Mitra GSD','tanggal_komersial' => 'Tanggal Komersial','portfolio' => 'Portfolio','facility_management' => 'FM', 'area'=>'area', 'keterangan'=>'Keterangan','update_terakhir'=>'Update Terakhir','tahun'=>'Tahun','revenue' => 'Revenue','beban_cogs' => 'Beban Cogs','beban_operasional' => 'Beban Operasional','biaya_perbaikan' => 'Biaya Perbaikan','piutang' => 'Piutang','piutang_unbill'=>'Piutang Unbill','piutang_bill'=>'Piutang Bill','piutang_paid'=>'Piutang Paid','status_bill'=>'Status Terakhir','status_accrue'=>'Status Finance'];
			
			$data = get_data('tbl_m_finance a',[
			'select' => 'a.tahun,b.perusahaan,a.brand,CASE
                            WHEN a.portfolio = 1 THEN "Ubis"
                            WHEN a.portfolio = 2 THEN "Non Ubis"
                        END as portfolio,a.klasifikasi,a.lokasi,a.alamat,a.kota,a.nomor_kontrak_mitra_gsd,a.tanggal_komersial,a.facility_management,a.area,a.keterangan,a.status_bill,a.revenue,a.beban_cogs,a.beban_operasional,a.biaya_perbaikan,a.piutang,a.piutang_bill,a.piutang_unbill,a.piutang_paid,CASE
				    WHEN a.update_at != "0000-00-00 00:00:00" and a.update_by != "" THEN CONCAT(a.update_at, " oleh : ", a.update_by)
				END as update_terakhir,CASE
                            WHEN a.status_accrue = 1 THEN "Real"
                            WHEN a.portfolio = 2 THEN "Accrue"
                        END as status_accrue',
			'join' => 'tbl_m_mitra b on a.id_mitra = b.id type LEFT',
		])->result_array();

		$config = [
			'title' => 'data_finance',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function export_detail($id='') {
		ini_set('memory_limit', '-1');

		$data				= get_data('tbl_m_finance a',[
			'select' => 'a.*,b.perusahaan,c.nama_gedung,e.klasifikasi,c.alamat,c.kota',
				
			'join'	 => ['tbl_m_mitra b on a.id_mitra = b.id type LEFT',
					     'tbl_asset c on a.id_asset = c.id type LEFT',
					     'tbl_m_klasifikasi_mitra e on b.id_klasifikasi = e.id type LEFT'
						],
			'where'  => [			
				'a.id' => $id,
			],
		])->row_array();


		$data['detail'] = get_data('tbl_detail_finance a',[
			'select'  => 'a.*,b.status_bill,b.revenue as trevenue,b.beban_cogs as tcogs,b.beban_operasional as toperasional, b.biaya_perbaikan as tperbaikan,b.piutang as tpiutang, b.piutang_unbill as punbill,b.piutang_bill as pbill, b.piutang_paid as ppaid',
			'join'	=> 'tbl_m_finance b on a.id_m_finance = b.id type LEFT',
			'where' => [
			'a.id_m_finance' => $id
		],	
		'sort_by' => 'a.bulan'
		])->result();


		render($data,'json');

	}

}