<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_ams extends MY_Controller {
	function __construct(){
		parent::__construct();
	}
	

	function index(){	
	}
	
	function sisakontrak() {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$kontrak = get_data('tbl_kontrak a', [
			'select' => 'a.*',
			'where' => [
				'a.is_active' => 1,
			],
		])->result();

		foreach($kontrak as $m){
			$endDate = strtotime($m->tanggal_akhir_kontrak_mitra);
			$now = strtotime(date("Y-m-d"));

			$sisa_waktu_kontrak = floor(($endDate-$now) /(60*60*24)) ;
			$sisa_waktu_kontrak	= $this->parse_waktu($sisa_waktu_kontrak);

        	update_data('tbl_kontrak',['sisa_waktu_kontrak' => $sisa_waktu_kontrak],'id',$m->id);
		}

		echo 'Success' ;		 
	}	

	function progress_aktivitas() {

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$aktivitas = get_data('tbl_m_aktivitas','is_active',1)->result();
		foreach ($aktivitas as $a) {

			$progress = get_data('tbl_detail_aktivitas',[
			'select'  => 'id_status_aktivitas, status_aktivitas as status, count(id_status_aktivitas) as jumlah ',
			'where'   => [
				'id_m_aktivitas' => $a->id,
				'nomor_aktivitas' => $a->nomor_aktivitas
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

			update_data('tbl_m_aktivitas',['progress'=>$rumus],['id'=>$a->id,'nomor_aktivitas'=>$a->nomor_aktivitas]);
		}	
		echo 'Success' ;	
	}

	function atribut_aktivitas() {

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$aktivitas = get_data('tbl_m_aktivitas','is_active',1)->result();
		$id_area = 0;
		$id_klasifikasi = 0;
		$id_kota = 0;
		foreach ($aktivitas as $a) {

			$asset = get_data('tbl_asset','id',$a->id_asset)->row();
			if(isset($asset->id)) {
				$id_area = $asset->id_area;
				$kota = $asset->kota;
				$id_kota = $asset->id_kota;
			}

			$mitra = get_data('tbl_m_mitra','id',$a->id_mitra)->row();
			if(isset($mitra->id)) {
				$id_brand = $mitra->id_brand;
				$id_klasifikasi = $mitra->id_klasifikasi;
			}


			update_data('tbl_m_aktivitas',['id_brand'=>$id_brand],['id'=>$a->id,'nomor_aktivitas'=>$a->nomor_aktivitas]);

		//	update_data('tbl_m_aktivitas',['id_area'=>$id_area,'id_klasifikasi'=>$id_klasifikasi, 'kota' => $kota,'id_kota'=>$id_kota],['id'=>$a->id,'nomor_aktivitas'=>$a->nomor_aktivitas]);
		}	
		echo 'Success' ;	
	}

	function kota() {

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$asset = get_data('tbl_asset','is_active',1)->result();
		$id_kota = 0;
		foreach ($asset as $a) {

			$kota = get_data('tbl_m_kota','nama_kota',$a->kota)->row();
			if(isset($kota->id)) {
				$id_kota = $kota->id;
			}

			update_data('tbl_asset',['id_kota'=>$id_kota],['id'=>$a->id,'kota'=>$a->kota]);
		}	
		echo 'Success' ;	
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

	function tahapan() {
		$aktivitas = get_data('tbl_detail_aktivitas a',[
 			'select' => 'a.id_m_aktivitas,a.sub_aktivitas,a.status_aktivitas',
 			'join'	=> 'tbl_sub_aktivitas b on a.sub_aktivitas = b.sub_aktivitas type LEFT',
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

	 		
		echo 'Success' ;	
	}

	function status_finance() {

			$piutang = get_data('tbl_detail_finance',[
				'sort_by' => 'bulan','id_m_finance',
				'sort'	=>'ASC'
			])->result();
			
			$piutang_unbill = 0;
			$piutang_bill = 0;
			$piutang_paid = 0;
			$status = 0;
			$last_status = '';
			$last_statusm ='';			
			$age ='';
			foreach ($piutang as $p) {
	
				if($p->tanggal_unbill !='0000-00-00' && $p->tanggal_unbill != '1970-01-01'){
					$piutang_unbill = $p->piutang;

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
					$piutang_bill = $p->piutang;
					$piutang_unbill = 0;
					$last_status = 'Bill';		
					$last_statusm = 'Bill';		

					$today     = new DateTime();
					$selectDay = new DateTime($p->tanggal_bill);
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

				if($p->tanggal_paid != '0000-00-00' && $p->tanggal_paid != '1970-01-01'){
					$piutang_paid = $p->piutang;
					$last_status = 'Paid';
					$last_statusm = 'Paid';
					$piutang_bill = 0;
					$piutang_unbill = 0;		
				}

				$st_age ='';
				$st_current = get_data('tbl_m_status_aging','status',$age)->row();
				if(isset($st_current)) {
					$st_age = $st_current->status_age; 
			//	}else{
			//		if($age != '') {
			//			$st_age = '>1 Tahun'; 
			//		}
				}	

				if($p->revenue > 0 || $p->piutang > 0) $status=$p->status_finance;
				if($p->revenue > 0 || $p->piutang > 0) $last_status=$last_status;
				if($p->revenue > 0 || $p->piutang > 0) $age=$age;

				update_data('tbl_detail_finance',['status_bill'=>$last_status,'piutang_unbill'=>$piutang_unbill,'piutang_bill'=>$piutang_bill,'piutang_paid'=>$piutang_paid,'umur_piutang'=>$age,'status_current'=>$st_age],['id'=>$p->id,'bulan'=>$p->bulan,'id_m_finance'=>$p->id_m_finance]);

				$stpiutang = get_data('tbl_detail_finance',[
					'select' => 'sum(piutang_unbill) as piutang_unbill,sum(piutang_bill) as piutang_bill,sum(piutang_paid) as piutang_paid',
					'where'  => [
						'id_m_finance' => $p->id_m_finance,
					]
				])->row();

				update_data('tbl_m_finance',['status_accrue'=>$status,'status_bill'=>$last_statusm,'piutang_unbill'=>$stpiutang->piutang_unbill,'piutang_bill'=>$stpiutang->piutang_bill,'piutang_paid'=>$stpiutang->piutang_paid],'id',$p->id_m_finance);

				$last_status ='';
				$piutang_unbill = 0;
				$piutang_bill = 0;
				$piutang_paid = 0;
				$age ='';
			}

		echo 'Success' ;	
	}	

	function area_finasset() {

		$m_finance = get_data('tbl_m_finance')->result();
		$id_fm = '';				
		$facility_management = '';
		$id_area = '';
		$area = '';
		foreach ($m_finance as $p) {
			$aset= get_data('tbl_asset a',[
				'select' => 'a.*,b.area',
				'join'	 => 'tbl_area b on a.id_area = b.id type LEFT',
				'where'  => [
					'a.id' => $p->id_asset
				],
			])->row();

			if(isset($aset->id)) {
				$id_fm = $aset->id_fm;				
				$facility_management = $aset->facility_management;
				$id_area = $aset->id_area;
				$area = $aset->area;

				update_data('tbl_m_finance',['id_fm'=>$id_fm,'facility_management'=>$facility_management,'id_area'=>$id_area,'area'=>$area],'id',$p->id);
			}
		} 	

		echo 'Success' ;	
	}	

	function brand() {

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$mitra = get_data('tbl_m_mitra','is_active',1)->result();
		$id_brand = 0;
		foreach ($mitra as $a) {

			$brand = get_data('tbl_m_brand','brand',$a->brand)->row();
			if(isset($brand->id)) {
				$id_brand = $brand->id;
			}

			update_data('tbl_m_mitra',['id_brand'=>$id_brand],['id'=>$a->id,'brand'=>$a->brand]);
		}	
		echo 'Success' ;	
	}

	function brand_finance() {

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$user_id   = '06041977';
		$date = date('Y-m-d H:i:s');

		$finance = get_data('tbl_m_finance')->result();
		$id_brand = 0;
		foreach ($finance as $a) {

			$brand = get_data('tbl_m_brand','brand',$a->brand)->row();
			if(isset($brand->id)) {
				$id_brand = $brand->id;
			}

			update_data('tbl_m_finance',['id_brand'=>$id_brand],['id'=>$a->id,'brand'=>$a->brand]);
		}	
		echo 'Success' ;	
	}
}