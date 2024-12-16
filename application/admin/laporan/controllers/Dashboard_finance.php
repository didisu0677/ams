<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_finance extends BE_Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['aktivitas']  = get_data('tbl_m_aktivitas','is_active',1)->result_array();
        render($data);
    }

    function data($page = 1,$tahun="") {
        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
                'is_active' => 1,
                'portfolio !=' => 0
            ]
        ];

        $result = data_pagination('tbl_m_finance a',$attr,base_url('laporan/dashboard_finance/data/'),4);
     
        $data_view['record']    = $result['record'];

        $a = 0 ;
        foreach ($data_view['record'] as $r) {
            $a += $r['revenue'];
        }
   
        $where = [
            'b.is_active' => 1,
        ];

    //    if($tahun) {
    //        $where['a.tahun']   = $tahun;   
    //    }

        $data_view['data_revenue']  = get_data('tbl_detail_finance a',[
            'select' => 'a.bulan, sum(a.revenue) as revenue',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type LEFT',
            'where' => $where,
            'group_by' => 'a.bulan'
        ])->result();

        $where1 = [
            'a.is_active' => 1,
            'a.portfolio !=' => 0
        ];

        $revenue_ytd = 0;
        $revenue_current = 0;
        $transdate = date('Y-m-d');
        $month = date('m', strtotime('-1 month'));
        foreach ($data_view['data_revenue'] as $r) {
            $revenue_ytd += $r->revenue;
            if($r->bulan ==$month) $revenue_current += $r->revenue;;
        }
        $data_view['revenue_ytd'] = $revenue_ytd;
        $data_view['revenue_current'] = $revenue_current;

        if($tahun) {
            $where1['a.tahun']   = $tahun;   
        }

        $data_view['data_portfolio']  = get_data('tbl_m_finance a',[
            'select' => 'CASE
                            WHEN portfolio = 1 THEN "Ubis"
                            WHEN portfolio = 2 THEN "Non Ubis"
                        END as portfolio, sum(a.revenue) as jumlah',
            'where' => $where1,
            'group_by' => 'a.portfolio'
        ])->result();

        $prsn_portfolio = [];
        foreach ($data_view['data_portfolio'] as $p) {
            $prsn_portfolio[$p->portfolio] = round(($p->jumlah/$a) * 100,2);
        }

        $ubis = [];
        $non_ubis = [];

        $where2 = [
            'b.is_active' => 1,
            'b.revenue !=' => 0,
            'b.id_area !=' => 0
        ];

        if($tahun) $where2['b.tahun']   = $tahun;   

        $area = [];
        $data_view['revenue_area']  = get_data('tbl_m_finance b',[
            'select' => 'concat("AREA ",b.id_area) as id_area,b.id_area as arid, c.area,b.portfolio, sum(b.revenue) as jumlah',
            'join'  => ['tbl_area c on b.id_area = c.id type inner',
            ],
            'where' => $where2,
            'group_by' => 'b.id_area,c.area,b.portfolio',
        ])->result();


        foreach ($data_view['revenue_area'] as $a) {
            if($a->portfolio == 1) $ubis[$a->arid] = $a->jumlah;
            if($a->portfolio == 2) $non_ubis[$a->arid] = $a->jumlah;
            
            $area[$a->arid] = $a->id_area;
        }

        $bb ='';
        $aa ='';
        foreach ($data_view['revenue_area'] as $a) {
            switch ($a->portfolio) {
              case 1:
                    $aa = $a->jumlah;
                    $ubis[$a->arid] = $aa;
                break;
              case 2:
                    $bb = $a->jumlah;
                    $non_ubis[$a->arid] = $bb;
                break;
              default:
                    $non_ubis[$a->arid] = '';  
                    $ubis[$a->arid] = '';  
                break;
            }

            $area[$a->arid] = $a->id_area;
        }

      //  debug($ubis);die;

        $where3 = [
            'b.is_active' => 1,
            'b.id_area !=' => 0
        ];

        if($tahun) $where3['b.tahun']   = $tahun;   

        $area2 = [];
        $data_view['gerai_area']  = get_data('tbl_m_finance b',[
            'select' => 'concat("AREA ",b.id_area) as id_area,b.id_area as arid, c.area,b.portfolio, count(b.portfolio) as jumlah',
            'join'  => ['tbl_area c on b.id_area = c.id type inner',
            ],
            'where' => $where3,
            'group_by' => 'b.id_area,b.portfolio'
        ])->result();

     //   debug($data_view['gerai_area']);die;
        $bb ='';
        $aa ='';
        $ubis2 = [];
        $non_ubis2 = [];
        foreach ($data_view['gerai_area'] as $a) {
            switch ($a->portfolio) {
              case 1:
                    $aa = $a->jumlah;
                    $ubis2[$a->arid] = $aa;
                break;
              case 2:
                    $bb = $a->jumlah;
                    $non_ubis2[$a->arid] = $bb;
                break;
              default:
                $non_ubis2[$a->arid] = '';  
                $ubis2[$a->arid] = '';  
                break;
            }

            $area2[$a->arid] = $a->id_area;

        }

        $where4 = [
            'b.is_active' => 1,
        ];

        if($tahun) $where4['b.tahun']   = $tahun;  

        $brand = [];
        $data_view['brand_revenue']  = get_data('tbl_m_finance b',[
            'select' => 'b.id_brand, b.brand, sum(b.revenue) as jumlah',
            'where' => $where4,
            'group_by' => 'b.id_brand,b.brand'
        ])->result();

        foreach ($data_view['brand_revenue'] as $b) {
            $brand[$b->brand] = $b->jumlah ;
        }

        $brand_rev = [];
        $data_view['brand_jmlrevenue']  = get_data('tbl_m_finance b',[
            'select' => 'b.id_brand, b.brand, count(b.id_brand) as jumlah',
            'where' => $where4,
            'group_by' => 'b.id_brand,b.brand'
        ])->result();

        foreach ($data_view['brand_jmlrevenue'] as $b1) {
            $brand_rev[$b1->brand] = $b1->jumlah ;
        }

        $view   = $this->load->view('laporan/dashboard_finance/data',$data_view,true);
     
        $data = [
            'data'              => $view,     
            'portfolio'         => $data_view['data_portfolio'],
            'prsn_portfolio'    => $prsn_portfolio,
            'revenue_area'      => $data_view['revenue_area'],
            'ubis'              => $ubis,
            'non_ubis'          => $non_ubis,
            'area'              => $area,
            'ubis2'             => $ubis2,
            'non_ubis2'         => $non_ubis2,
            'area2'             => $area2,
            'brand'             => $brand,
            'brand_rev'         => $brand_rev
        ];

        render($data,'json');
    }

    function data2($page = 1,$tahun="", $portfolio="") {
        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
                'is_active' => 1
            ]
        ];

        $result = data_pagination('tbl_m_finance a',$attr,base_url('laporan/dashboard_finance/data2/'),4);
     
        $data_view['record']    = $result['record'];

        $a = 0 ;
        foreach ($data_view['record'] as $r) {
            $a++;
        }
   
        $where = [
            'b.is_active' => 1,
            'a.piutang !=' => 0, 
            'a.status_bill !=' => 'Paid'
        ];

    //    if($tahun) {
    //        $where['a.tahun']   = $tahun;   
    //    }

    //    if($tahun && $portfolio != 0) {

        if($portfolio != 0) {
            $where['b.portfolio']   = $portfolio;   
        }

        $data_view['data_piutang']  = get_data('tbl_detail_finance a',[
            'select' => 'a.status_current, a.status_bill, sum(a.piutang_bill+a.piutang_unbill) as piutang, sum(a.piutang_bill) as piutang_bill, sum(a.piutang_unbill) as piutang_unbill',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type LEFT',
            'where' => $where,
            'group_by' => 'a.status_current,a.status_bill,a.tanggal_unbill',
        ])->result();

        $total_piutang = 0;
        $total_bill = 0;
        $total_unbill = 0;
        $current_bill = 0;
        $_13bill = 0;
        $_46bill = 0;
        $_712bill = 0;
        $_12bill = 0;

        $current_unbill = 0;
        $_13unbill = 0;
        $_46unbill = 0;
        $_712unbill = 0;
        $_12unbill = 0;
        foreach ($data_view['data_piutang'] as $p) {
            $total_piutang += $p->piutang;
            $total_bill += $p->piutang_bill;
            $total_unbill += $p->piutang_unbill;

            if($p->status_current == 'Current') $current_bill += $p->piutang_bill ;
            if($p->status_current == '1-3') $_13bill += $p->piutang_bill ;
            if($p->status_current == '4-6') $_46bill += $p->piutang_bill ;
            if($p->status_current == '7-12') $_712bill += $p->piutang_bill ;
            if($p->status_current == '>1 Tahun') $_12bill += $p->piutang_bill ; 

            if($p->status_current == 'Current') $current_unbill += $p->piutang_unbill ;
            if($p->status_current == '1-3') $_13unbill += $p->piutang_unbill ;
            if($p->status_current == '4-6') $_46unbill += $p->piutang_unbill ;
            if($p->status_current == '7-12') $_712unbill += $p->piutang_unbill ;
            if($p->status_current == '>1 Tahun') $_12unbill += $p->piutang_unbill ; 
        }

        $data_view['piutang'] = $total_piutang;
        $data_view['total_bill'] = $total_bill;
        $data_view['total_unbill'] = $total_unbill;

        $data_view['current_bill'] = $current_bill;
        $data_view['_13bill'] = $_13bill;
        $data_view['_46bill'] = $_46bill;
        $data_view['_712bill'] = $_712bill;
        $data_view['_12bill'] = $_12bill;

        $data_view['current_unbill'] = $current_unbill;
        $data_view['_13unbill'] = $_13unbill;
        $data_view['_46unbill'] = $_46unbill;
        $data_view['_712unbill'] = $_712unbill;
        $data_view['_12unbill'] = $_12unbill;


     //   debug($data_view['data_piutang']);die;
        $view   = $this->load->view('laporan/dashboard_finance/data2',$data_view,true);
     
        $data = [
            'data'              => $view,     
            'piutang'         => $data_view['data_piutang'],
        ];

        render($data,'json');
    }

    function data3($page = 1,$tahun="", $portfolio="") {
        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
                'is_active' => 1
            ]
        ];

        $result = data_pagination('tbl_m_finance a',$attr,base_url('laporan/dashboard_finance/data3/'),4);
     
        $data_view['record']    = $result['record'];

        $a = 0 ;
        foreach ($data_view['record'] as $r) {
            $a++;
        }
   
        $where = [
            'b.is_active' => 1,
            'a.status_bill !=' => 'Paid',
   //         'a.revenue !=' => 0
        ];

   //     if($tahun) {
   //         $where['a.tahun']   = $tahun;   
   //     }

        if($portfolio != 0) {
            $where['b.portfolio']   = $portfolio;   
        }


        $data_view['mitra_unbill']  = get_data('tbl_detail_finance a',[
            'select' => 'distinct b.id_brand, b.brand',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type inner',
            'where' => $where,
        ])->result();


        $data_view['data_unbill']  = get_data('tbl_detail_finance a',[
            'select' => 'a.status_current, b.id_brand, b.brand, sum(a.piutang_unbill) as piutang_unbill',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type inner',
            'where' => $where,
            'group_by' => 'a.status_current,b.id_brand,b.brand',
            'sort_by'  => 'a.piutang_unbill',
            'sort'     => 'DESC'  
        ])->result();

        $unbill=[];
        foreach ($data_view['data_unbill'] as $a) {
            $unbill[$a->brand][$a->status_current] = $a->piutang_unbill;

        }

        $data_view['unbill1'] = $unbill ;



        $view   = $this->load->view('laporan/dashboard_finance/data3',$data_view,true);
     
        $data = [
            'data'              => $view,     
        ];


        render($data,'json');
    }

    function data4($page = 1,$tahun="", $portfolio="") {
        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
                'is_active' => 1
            ]
        ];

        $result = data_pagination('tbl_m_finance a',$attr,base_url('laporan/dashboard_finance/data4/'),4);
     
        $data_view['record']    = $result['record'];

        $a = 0 ;
        foreach ($data_view['record'] as $r) {
            $a++;
        }
   
        $where = [
            'b.is_active' => 1,
            'a.status_bill !=' => 'Paid',
   //         'a.revenue !=' => 0
        ];

   //     if($tahun) {
   //         $where['a.tahun']   = $tahun;   
   //     }

        if($portfolio != 0) {
            $where['b.portfolio']   = $portfolio;   
        }

        $data_view['mitra_bill']  = get_data('tbl_detail_finance a',[
            'select' => 'distinct b.id_mitra, b.brand',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type inner',
            'where' => $where,
        ])->result();

        $data_view['data_bill']  = get_data('tbl_detail_finance a',[
            'select' => 'a.status_current,b.id_brand,b.brand, sum(a.piutang_bill) as piutang_bill',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type inner',
            'where' => $where,
            'group_by' => 'a.status_current, b.id_brand, b.brand',
            'sort_by'  => 'a.piutang_bill',
            'sort'     => 'DESC'  
        ])->result();

        $bill=[];
        foreach ($data_view['data_bill'] as $a) {
            $bill[$a->brand][$a->status_current] = $a->piutang_bill;
        }


      //  debug($bill);die;
        $data_view['bill'] = $bill ;
        $view   = $this->load->view('laporan/dashboard_finance/data4',$data_view,true);
     
        $data = [
            'data'              => $view,     
        ];

        render($data,'json');
    }

    function data5($page = 1,$tahun="", $portfolio="") {
        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
                'a.is_active' => 1
            ]
        ];

        $result = data_pagination('tbl_m_finance a',$attr,base_url('laporan/dashboard_finance/data5/'),4);
     
        $data_view['record']    = $result['record'];

 
        $where = [
            'b.is_active' => 1,
            'a.status_bill !=' => 'Paid',
    //        'a.revenue !=' => 0,
    //        'b.nomor_kontrak_mitra_gsd' => '446/HK.810/GSD-000/2016'
        ];

    //    if($tahun) $where['a.tahun']  = $tahun;           
        if($portfolio != 0) {
            $where['b.portfolio']   = $portfolio;   
        }


        $data_view['data_bill']  = get_data('tbl_detail_finance a',[
            'select' => 'a.status_current,b.id_brand,b.brand,b.lokasi as nama_gedung, sum(a.piutang_bill) as piutang_bill',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type LEFT',
            'where' => $where,
            'group_by' => 'a.status_current,b.id_brand,b.brand,b.lokasi'
        ])->result();

  //      debug($data_view['data_bill']);die;
        
        $where2 = [
            'b.is_active' => 1,
            'a.status_bill !=' => 'Paid',
  //          'b.id_brand ' => 23
        ];

  //      if($tahun) $where2['a.tahun']   = $tahun;  
        if($portfolio != 0) {
            $where2['b.portfolio']   = $portfolio;   
        }

        $brand = [];
        $ubis = [];
        $non_ubis = [];
        $data_view['brand_piutang']  = get_data('tbl_detail_finance a',[
            'select' => 'CASE
                            WHEN b.portfolio = 1 THEN "Ubis"
                            WHEN b.portfolio = 2 THEN "Non Ubis"
                         END as portfolio, b.portfolio as port, b.id_brand, b.brand, sum(a.piutang_bill+a.piutang_unbill) as jumlah',
            'join'   => 'tbl_m_finance b on a.id_m_finance = b.id type inner',                            
            'where' => $where2,
            'group_by' => 'b.portfolio,b.id_brand,b.brand',
            'sort_by'  => 'a.piutang_bill,a.piutang_unbill',
            'sort'     => 'DESC' 
        ])->result();

   //     debug($data_view['brand_piutang']);die;
        $aa='';
        $bb='';
        $non_ubis=[];
        $ubis =[];
        foreach ($data_view['brand_piutang'] as $b) {
            $non_ubis[$b->id_brand] = '';  
            $ubis[$b->id_brand] = '';

            switch ($b->port) {
              case 1:
                    $aa = $b->jumlah;
                    $ubis[$b->id_brand] = $aa;
                    $brand[$b->id_brand] = $b->brand;
                break;
              case 2:
                    $bb = $b->jumlah;
                    $non_ubis[$b->id_brand] = $bb;
                    $brand[$b->id_brand] = $b->brand;
                break;
              default:
                $non_ubis[$b->id_brand] = '';  
                $ubis[$b->id_brand] = '';
                $brand[$b->id_brand] = $b->brand;
                break;
            }
        }

  
        $view   = $this->load->view('laporan/dashboard_finance/data5',$data_view,true);
     
        $data = [
            'data'      => $view,     
            'brand'     => $brand,
            'ubis'     => $ubis,
            'non_ubis'     => $non_ubis
        ];

        render($data,'json');
    }

    
}