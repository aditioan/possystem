<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('laporan_model');
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index(){
        if(isset($_GET['search'])){
            $filter = '';

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(created_at) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(created_at) <='] = $_GET['date_end'];
            }

            $data['modal'] = $this->laporan_model->get_modal_tambah()-$this->laporan_model->get_modal_kurang();
            $data['purchase'] = $this->laporan_model->get_purchase($filter);
            $data['perawatan'] = $this->laporan_model->get_perawatan($filter);
            $data['sales_retur'] = $this->laporan_model->get_sales_retur($filter);
            $data['other_outcome'] = $this->laporan_model->get_other_outcome($filter);
            $data['total_outcome'] = $data['purchase']+$data['perawatan']+$data['other_outcome'];
            $data['sales'] = $this->laporan_model->get_sales($filter);
            $data['purchase_retur'] = $this->laporan_model->get_purchase_retur($filter);
            $data['other_income'] = $this->laporan_model->get_other_income($filter);
            $data['total_income'] = $data['sales']+$data['other_income'];
            $data['balance'] = $data['modal']+$data['total_income']-$data['total_outcome'];

            $total_row = $this->laporan_model->count_total($filter);
        }else{
            $data['modal'] = $this->laporan_model->get_modal_tambah()-$this->laporan_model->get_modal_kurang();
            $data['purchase'] = $this->laporan_model->get_purchase();
            $data['perawatan'] = $this->laporan_model->get_perawatan();
            $data['sales_retur'] = $this->laporan_model->get_sales_retur();
            $data['other_outcome'] = $this->laporan_model->get_other_outcome();
            $data['total_outcome'] = $data['purchase']+$data['perawatan']+$data['other_outcome'];
            $data['sales'] = $this->laporan_model->get_sales();
            $data['purchase_retur'] = $this->laporan_model->get_purchase_retur();
            $data['other_income'] = $this->laporan_model->get_other_income();
            $data['total_income'] = $data['sales']+$data['other_income'];
            $data['balance'] = $data['modal']+$data['total_income']-$data['total_outcome'];

            $total_row = $this->laporan_model->count_total();
        }
        // echo $this->db->last_query();
        // echo $data['january_income'];
        // die();
        $data['paggination'] = get_paggination($total_row,get_search());
        $this->load->view('laporan/index',$data);
    }

    public function laba_rugi(){
        $tanggal_awal = '';
        $tanggal_akhir = '';
        if(isset($_GET['search'])){
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $tanggal_awal = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $tanggal_akhir = $_GET['date_end'];
            }
        }else{
           $tanggal_awal = $this->laporan_model->get_period()->start_date;
           $tanggal_akhir = date('Y-m-d');
        }

        $data['income'] = $this->_income($tanggal_awal, $tanggal_akhir);
        $data['outcome'] = $this->_outcome($tanggal_awal, $tanggal_akhir);
        // echo "<pre>";
        // echo print_r($data);
        // die();
        $data['laba_kotor'] = $data['income']['sales_all_bersih']-$data['outcome']['hpp'];
        $data['laba_bersih'] = $data['laba_kotor']+$data['income']['sewa_tambah']-$data['outcome']['total_beban'];
        $data['kas'] = ($data['income']['kas_awal']+$data['income']['sales_bersih']+$data['income']['modal_total']+$data['income']['sewa_tambah']+$data['income']['other_income'])-($data['outcome']['total_outcome']+$data['outcome']['purchase_bersih']);
        
        $this->load->view('laporan/laba_rugi',$data);
    }

    public function neraca(){
        $tanggal_awal = '';
        $tanggal_akhir = '';
        if(isset($_GET['search'])){
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $tanggal_awal = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $tanggal_akhir = $_GET['date_end'];
            }
        }else{
           $tanggal_awal = $this->laporan_model->get_period()->start_date;
           $tanggal_akhir = date('Y-m-d');
        }

        $data['income'] = $this->_income($tanggal_awal, $tanggal_akhir);
        $data['outcome'] = $this->_outcome($tanggal_awal, $tanggal_akhir);
        
        $data['laba_kotor'] = $data['income']['sales_all_bersih']-$data['outcome']['hpp'];
        $data['laba_bersih'] = $data['laba_kotor']+$data['income']['sewa_tambah']-$data['outcome']['total_beban'];
        $data['kas'] = ($data['income']['kas_awal']+$data['income']['sales_bersih']+$data['income']['modal_total']+$data['income']['sewa_tambah']+$data['income']['other_income'])-($data['outcome']['total_outcome']+$data['outcome']['purchase_bersih']);
        $data['total_aset'] = $data['kas']+$data['income']['piutang']+$data['income']['all_peralatan']+$data['income']['persediaan'];
        $data['ekuitas_akhir'] = $data['laba_bersih']+$data['income']['modal_total']+$data['income']['aset'];
        $data['total_hutang_ekuitas'] = $data['ekuitas_akhir']+$data['outcome']['hutang_usaha']+$data['outcome']['hutang_pembelian'];

        $this->load->view('laporan/neraca',$data);
    }

    public function aliran_kas(){
        $tanggal_awal = '';
        $tanggal_akhir = '';
        if(isset($_GET['search'])){
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $tanggal_awal = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $tanggal_akhir = $_GET['date_end'];
            }
        }else{
           $tanggal_awal = $this->laporan_model->get_period()->start_date;
           $tanggal_akhir = date('Y-m-d');
        }

        $data['income'] = $this->_income($tanggal_awal, $tanggal_akhir);
        $data['outcome'] = $this->_outcome($tanggal_awal, $tanggal_akhir);
        // echo "<pre>";
        // echo print_r($data['income']);
        // die();
        $data['kas'] = ($data['income']['kas_awal']+$data['income']['sales_bersih']+$data['income']['modal_total']+$data['income']['sewa_tambah']+$data['income']['other_income'])-($data['outcome']['total_outcome']+$data['outcome']['purchase_bersih']);

        $this->load->view('laporan/aliran_kas',$data);
    }

    public function ekuitas(){
        $tanggal_awal = '';
        $tanggal_akhir = '';
        if(isset($_GET['search'])){
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $tanggal_awal = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $tanggal_akhir = $_GET['date_end'];
            }
        }else{
           $tanggal_awal = $this->laporan_model->get_period()->start_date;
           $tanggal_akhir = date('Y-m-d');
        }

        $data['income'] = $this->_income($tanggal_awal, $tanggal_akhir);
        $data['outcome'] = $this->_outcome($tanggal_awal, $tanggal_akhir);
        $data['laba_kotor'] = $data['income']['sales_all_bersih']-$data['outcome']['hpp'];
        $data['laba_bersih'] = $data['laba_kotor']+$data['income']['sewa_tambah']-$data['outcome']['total_beban'];
        $data['kas'] = ($data['income']['kas_awal']+$data['income']['sales_bersih']+$data['income']['modal_total']+$data['income']['sewa_tambah']+$data['income']['other_income'])-($data['outcome']['total_outcome']+$data['outcome']['purchase_bersih']);

        $this->load->view('laporan/ekuitas',$data);
    }

    public function chart()
    {
        $data['income'] = $this->_income(date('Y').'-01-01', date('Y').'-12-31');
        $data['outcome'] = $this->_outcome(date('Y').'-01-01', date('Y').'-12-31');
        $data['january_income'] = (int)$this->_income(date('Y').'-01-01', date('Y').'-01-31')['chart_income'];
        $data['february_income'] = (int)$this->_income(date('Y').'-02-01', date('Y').'-02-31')['chart_income'];
        $data['march_income'] = (int)$this->_income(date('Y').'-03-01', date('Y').'-03-31')['chart_income'];
        $data['april_income'] = (int)$this->_income(date('Y').'-04-01', date('Y').'-04-31')['chart_income'];
        $data['may_income'] = (int)$this->_income(date('Y').'-05-01', date('Y').'-05-31')['chart_income'];
        $data['june_income'] = (int)$this->_income(date('Y').'-06-01', date('Y').'-06-31')['chart_income'];
        $data['july_income'] = (int)$this->_income(date('Y').'-07-01', date('Y').'-07-31')['chart_income'];
        $data['august_income'] = (int)$this->_income(date('Y').'-08-01', date('Y').'-08-31')['chart_income'];
        $data['september_income'] = (int)$this->_income(date('Y').'-09-01', date('Y').'-09-31')['chart_income'];
        $data['october_income'] = (int)$this->_income(date('Y').'-10-01', date('Y').'-10-31')['chart_income'];
        $data['november_income'] = (int)$this->_income(date('Y').'-11-01', date('Y').'-11-31')['chart_income'];
        $data['december_income'] = (int)$this->_income(date('Y').'-12-01', date('Y').'-12-31')['chart_income'];

        $data['january_outcome'] = (int)$this->_outcome(date('Y').'-01-01', date('Y').'-01-31')['chart_outcome'];
        $data['january_outcome'] = (int)$this->_outcome(date('Y').'-01-01', date('Y').'-01-31')['chart_outcome'];
        $data['february_outcome'] = (int)$this->_outcome(date('Y').'-02-01', date('Y').'-02-31')['chart_outcome'];
        $data['march_outcome'] = (int)$this->_outcome(date('Y').'-03-01', date('Y').'-03-31')['chart_outcome'];
        $data['april_outcome'] = (int)$this->_outcome(date('Y').'-04-01', date('Y').'-04-31')['chart_outcome'];
        $data['may_outcome'] = (int)$this->_outcome(date('Y').'-05-01', date('Y').'-05-31')['chart_outcome'];
        $data['june_outcome'] = (int)$this->_outcome(date('Y').'-06-01', date('Y').'-06-31')['chart_outcome'];
        $data['july_outcome'] = (int)$this->_outcome(date('Y').'-07-01', date('Y').'-07-31')['chart_outcome'];
        $data['august_outcome'] = (int)$this->_outcome(date('Y').'-08-01', date('Y').'-08-31')['chart_outcome'];
        $data['september_outcome'] = (int)$this->_outcome(date('Y').'-09-01', date('Y').'-09-31')['chart_outcome'];
        $data['october_outcome'] = (int)$this->_outcome(date('Y').'-10-01', date('Y').'-10-31')['chart_outcome'];
        $data['november_outcome'] = (int)$this->_outcome(date('Y').'-11-01', date('Y').'-11-31')['chart_outcome'];
        $data['december_outcome'] = (int)$this->_outcome(date('Y').'-12-01', date('Y').'-12-31')['chart_outcome'];

        $data['kas'] = ($data['income']['kas_awal']+$data['income']['sales_bersih']+$data['income']['modal_total']+$data['income']['sewa_tambah']+$data['income']['other_income'])-($data['outcome']['total_outcome']+$data['outcome']['purchase_bersih']);

        $this->load->view('laporan/chart',$data);
    }

    function _income($tanggal_awal, $tanggal_akhir)
    {
        $filter['DATE(created_at) >='] = $tanggal_awal;
        $filter['DATE(created_at) <='] = $tanggal_akhir;

        if ($tanggal_awal != '' || $tanggal_akhir != '') {
            $data['first_modal'] = $this->laporan_model->get_first_modal($filter);
            $data['modal_kurang'] = (int)$this->laporan_model->get_modal_kurang($filter);
            $data['modal_tambah'] = (int)$this->laporan_model->get_modal_tambah($filter);
            $data['modal_total'] = $data['modal_tambah']-$data['modal_kurang'];
            $data['sales_retur'] = (int)$this->laporan_model->get_sales_retur($filter);
            $data['sales'] = (int)$this->laporan_model->get_sales($filter);
            $data['all_sales'] = (int)$this->laporan_model->get_all_sales($filter);
            $data['kas_awal'] = (int)$this->laporan_model->get_kas($filter);
            $data['all_peralatan'] = (int)$this->laporan_model->get_all_peralatan($filter);
            $data['sewa_tambah'] = (int)$this->laporan_model->get_sewa_tambah($filter);
            $data['sales_bersih'] = $data['sales']-$data['sales_retur'];
            $data['sales_all_bersih'] = $data['all_sales']-$data['sales_retur'];
            $data['other_income'] = (int)$this->laporan_model->get_other_income($filter);
            //$data['total_income'] = $data['sales']+$data['other_income']-$data['sales_retur'];
            $data['piutang'] = (int)$this->laporan_model->get_piutang($filter);
            $data['purchase_retur'] = (int)$this->laporan_model->get_purchase_retur($filter);
            $data['persediaan_awal'] = (int)$this->laporan_model->get_persediaan_awal($filter);
            $data['peralatan_awal'] = (int)$this->laporan_model->get_peralatan_awal($filter);
            $data['persediaan'] = (int)$this->laporan_model->get_persediaan();
            $data['aset'] = $data['kas_awal']+$data['persediaan_awal']+$data['peralatan_awal'];
             $data['chart_income'] = $data['kas_awal']+$data['modal_total']+$data['sales_bersih']+$data['sewa_tambah']+$data['other_income'];

            return $data;
        } else {
            $data['first_modal'] = $this->laporan_model->get_first_modal();
            $data['modal_tambah'] = (int)$this->laporan_model->get_modal_tambah();
            $data['modal_kurang'] = (int)$this->laporan_model->get_modal_kurang();
            $data['modal_total'] = $data['modal_tambah']-$data['modal_kurang'];
            $data['sales_retur'] = (int)$this->laporan_model->get_sales_retur();
            $data['sales'] = (int)$this->laporan_model->get_sales();
            $data['all_sales'] = (int)$this->laporan_model->get_all_sales();
            $data['kas_awal'] = (int)$this->laporan_model->get_kas();
            $data['all_peralatan'] = (int)$this->laporan_model->get_all_peralatan();
            $data['sewa_tambah'] = (int)$this->laporan_model->get_sewa_tambah();
            $data['sales_bersih'] = $data['sales']-$data['sales_retur'];
            $data['sales_all_bersih'] = $data['all_sales']-$data['sales_retur'];
            $data['other_income'] = (int)$this->laporan_model->get_other_income();
            //$data['total_income'] = $data['sales_bersih']+$data['other_income'];
            $data['piutang'] = (int)$this->laporan_model->get_piutang();
            $data['purchase_retur'] = (int)$this->laporan_model->get_purchase_retur();
            $data['persediaan_awal'] = (int)$this->laporan_model->get_persediaan_awal();
            $data['persediaan'] = (int)$this->laporan_model->get_persediaan();
            $data['peralatan_awal'] = (int)$this->laporan_model->get_peralatan_awal();
            $data['aset'] = $data['kas_awal']+$data['persediaan_awal']+$data['peralatan_awal'];
            $data['chart_income'] = $data['kas_awal']+$data['modal_total']+$data['sales_bersih']+$data['sewa_tambah']+$data['other_income'];

            return $data;
        }
    }

    function _outcome($tanggal_awal, $tanggal_akhir)
    {
        $filter['DATE(created_at) >='] = $tanggal_awal;
        $filter['DATE(created_at) <='] = $tanggal_akhir;

        if ($tanggal_awal != '' || $tanggal_akhir != '') {
            $data['gaji'] = (int)$this->laporan_model->get_gaji($filter);
            $data['peralatan'] = (int)$this->laporan_model->get_peralatan($filter);
            $data['perlengkapan'] = (int)$this->laporan_model->get_perlengkapan($filter);
            $data['sewa_kurang'] = (int)$this->laporan_model->get_sewa_kurang($filter);
            $data['perawatan'] = (int)$this->laporan_model->get_perawatan($filter);
            $data['sales_retur'] = (int)$this->laporan_model->get_sales_retur($filter);
            $data['purchase'] = (int)$this->laporan_model->get_purchase($filter);
            $data['purchase_retur'] = (int)$this->laporan_model->get_purchase_retur($filter);
            $data['purchase_bersih'] = $data['purchase']-$data['purchase_retur'];
            $data['persediaan_awal'] = (int)$this->laporan_model->get_persediaan_awal($filter);
            $data['pembelian'] = (int)$this->laporan_model->get_pembelian_total($filter);
            // $data['hpp'] = 0;
            // for ($j=0; $j < count($data['penjualan']); $j++) {
            //     $data['penjualan'][$j]['hpp'] = (int)$this->laporan_model->get_hpp($data['penjualan'][$j]['id_product']);
            //     $data['penjualan'][$j]['subtotal_hpp'] = $data['penjualan'][$j]['data_qty']*$data['penjualan'][$j]['hpp'];
            //     $data['hpp'] = $data['hpp'] + $data['penjualan'][$j]['subtotal_hpp'];
            // }
            $data['purchase'] = (int)$this->laporan_model->get_purchase($filter);
            $data['hutang_usaha'] = (int)$this->laporan_model->get_hutang_usaha($filter);
            $data['hutang_pembelian'] = (int)$this->laporan_model->get_hutang_pembelian($filter);
            //$data['hpp'] = $data['persediaan_awal']+$data['purchase']+$data['hutang_pembelian']-$data['purchase_retur']-$data['persediaan_akhir'];
            $data['other_outcome'] = (int)$this->laporan_model->get_other_outcome($filter);
            $data['total_outcome'] = $data['perawatan']+$data['other_outcome']+$data['gaji']+$data['peralatan']+$data['perlengkapan']+$data['sewa_kurang'];
            $data['total_beban'] = $data['perawatan']+$data['other_outcome']+$data['gaji']+$data['perlengkapan']+$data['sewa_kurang'];
            $data['hutang_usaha'] = (int)$this->laporan_model->get_hutang_usaha($filter);
            $data['hutang_pembelian'] = (int)$this->laporan_model->get_hutang_pembelian($filter);
            $filter = array();
            $filter['DATE(sales_data.created_at) >='] = $tanggal_awal;
            $filter['DATE(sales_data.created_at) <='] = $tanggal_akhir;
            $data['hpp_sales'] = (int)$this->laporan_model->get_hpp($filter);
            $filter = array();
            $filter['DATE(sales_retur_data.created_at) >='] = $tanggal_awal;
            $filter['DATE(sales_retur_data.created_at) <='] = $tanggal_akhir;
            $data['hpp_retur'] = (int)$this->laporan_model->get_hpp_retur($filter);
            $data['hpp'] = $data['hpp_sales']-$data['hpp_retur'];
            $data['chart_outcome'] = $data['purchase_bersih'] + $data['total_outcome'];
            return $data;
        } else {

            $data['gaji'] = (int)$this->laporan_model->get_gaji();
            $data['peralatan'] = (int)$this->laporan_model->get_peralatan();
            $data['perlengkapan'] = (int)$this->laporan_model->get_perlengkapan();
            $data['sewa_kurang'] = (int)$this->laporan_model->get_sewa_kurang();
            $data['perawatan'] = (int)$this->laporan_model->get_perawatan();
            $data['sales_retur'] = (int)$this->laporan_model->get_sales_retur();
            $data['purchase'] = (int)$this->laporan_model->get_purchase();
            $data['purchase_retur'] = (int)$this->laporan_model->get_purchase_retur();
            $data['purchase_bersih'] = $data['purchase']-$data['purchase_retur'];
            $data['persediaan_awal'] = (int)$this->laporan_model->get_persediaan_awal();
            $data['pembelian'] = (int)$this->laporan_model->get_pembelian_total();
            //$data['penjualan'] = $this->laporan_model->get_penjualan();
            $data['hpp_sales'] = (int)$this->laporan_model->get_hpp();
            $data['hpp_retur'] = (int)$this->laporan_model->get_hpp_retur();
            $data['hpp'] = $data['hpp_sales']-$data['hpp_retur'];
            // for ($j=0; $j < count($data['penjualan']); $j++) {
            //     $data['penjualan'][$j]['hpp'] = (int)$this->laporan_model->get_hpp($data['penjualan'][$j]['id_product']);
            //     $data['penjualan'][$j]['subtotal_hpp'] = $data['penjualan'][$j]['data_qty']*$data['penjualan'][$j]['hpp'];
            //     $data['hpp'] = $data['hpp'] + $data['penjualan'][$j]['subtotal_hpp'];
            // }
            // for ($i=0; $i < count($data['persediaan']); $i++) { 
            //     for ($j=0; $j < count($data['penjualan']); $j++) { 
            //         if ($data['penjualan'][$j]['id_product'] == $data['persediaan'][$i]['id_product']) {
            //             $data['persediaan'][$i]['data_qty'] = $data['persediaan'][$i]['data_qty'] - $data['penjualan'][$j]['data_qty'];
            //         }
            //     }
            // }
            // $data['persediaan_tambah'] = 0;
            // foreach ($data['persediaan'] as $persediaan) {
            //     $data['persediaan_tambah'] = $data['persediaan_tambah']+($persediaan['data_qty']*$persediaan['price_item']);
            // }
            $data['hutang_usaha'] = (int)$this->laporan_model->get_hutang_usaha();
            $data['hutang_pembelian'] = (int)$this->laporan_model->get_hutang_pembelian();
            // $data['hpp'] = $data['persediaan_awal']+$data['purchase']+$data['hutang_pembelian']-$data['purchase_retur']-$data['persediaan_akhir'];
            $data['other_outcome'] = (int)$this->laporan_model->get_other_outcome();
            $data['total_outcome'] = $data['perawatan']+$data['other_outcome']+$data['gaji']+$data['peralatan']+$data['perlengkapan']+$data['sewa_kurang'];
            $data['total_beban'] = $data['perawatan']+$data['other_outcome']+$data['gaji']+$data['perlengkapan']+$data['sewa_kurang'];
            $data['chart_outcome'] = $data['purchase_bersih'] + $data['total_outcome'];
            return $data;
        }
        
    }

    public function record(){
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['id_transaction']) && $_GET['id_transaction'] != ''){
                $filter['balance.id_transaction LIKE'] = "%".$_GET['id_transaction']."%";
            }

            if(!empty($_GET['type']) && $_GET['type'] != ''){
                $filter['balance.type LIKE'] = "%".$_GET['type']."%";
            }

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(balance.created_at) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(balance.created_at) <='] = $_GET['date_end'];
            }
            $result = $this->laporan_model->get_filter($filter);
            $data['laporans'] = $result;
        }else{
            $total_row = $this->laporan_model->count_total();
            $result = $this->laporan_model->get_all();
            $data['laporans'] = $result;
        }
        // echo "<pre>";
        // print_r($data['laporans']);
        // die();
        $data['paggination'] = get_paggination($total_row,get_search());

        $this->load->view('laporan/record',$data);
    }

    public function create(){
        $data['id_transaction'] = "BAL".strtotime(date("Y-m-d H:i:s"));
        $this->load->view('laporan/form', $data);
    }

    public function check_id(){
        $id = $this->input->post('id_category');
        $check_id = $this->laporan_model->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->laporan_model->get_by_id($id);
        if($check_id){
            $data['laporan'] = $check_id[0];
            $this->load->view('laporan/form',$data);
        }else{
            redirect(site_url('laporan'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('id_transaction', 'ID', 'required');
        $this->form_validation->set_rules('cash', 'Uang', 'required');

        $data['id_transaction'] = escape($this->input->post('id_transaction'));
        $data['cash_trx'] = escape(str_replace('.', '', str_replace('Rp ', '', $this->input->post('cash'))));
        $data['type'] = escape($this->input->post('type'));
        $data['action'] = escape($this->input->post('aksi'));
        $data['description'] = escape($this->input->post('description'));

        $kas = $this->laporan_model->get_last_trx();
        if ($kas->num_rows() == 0 && $data['action'] == 0) {
            $this->session->set_flashdata('message_error', 'Data masih kosong, tidak bisa dikurangi!');
            redirect(site_url('laporan/create'));
        }
        //print_r($kas->row());
        // print_r($this->input->post());
        // die();

        if ($this->form_validation->run() != FALSE){
            // INSERT NEW
            if ($kas->num_rows() == 0 && $data['action'] == 1) {
                $data['cash_total'] = $data['cash_trx'];
                $this->laporan_model->insert($data);
            } elseif ($kas->num_rows() != 0 && $data['action'] == 1) {
                $cash = $kas->row()->cash_total;
                $data['cash_total'] = $cash + $data['cash_trx'];
                $this->laporan_model->insert($data);
            } else {
                $cash = $kas->row()->cash_total;
                $data['cash_total'] = $cash - $data['cash_trx'];
                $this->laporan_model->insert($data);
            }
            
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }else{
            $this->session->set_flashdata('message_error', 'Harap periksa form anda.');
            redirect(site_url('laporan/create'));
        }
        redirect(site_url('laporan'));
    }
    public function delete($id){
        $check_id = $this->laporan_model->get_by_id($id);
        if($check_id){
            $this->laporan_model->delete_temp($id);
        }
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('laporan'));
    }
    public function tutup_tahun(){
        //$time = date('Y-m-d H:i:s');
        $this->laporan_model->set_new_period();
        $this->session->set_flashdata('message_success', 'Periode saat ini sudah ditutup, periode baru di set!');
        redirect(site_url('laporan/neraca'));
    }
    public function tutup_tahun2(){
        $this->laporan_model->clean_stransaction();
        $this->laporan_model->clean_ptransaction();
        $this->laporan_model->clean_otransaction();
        $this->session->set_flashdata('message_success', 'Seluruh data transaksi telah dibersihkan, tutup tahun selesai!');
        redirect(site_url('laporan/neraca'));
    }
    public function reset_modal(){
        $this->laporan_model->reset_modal();
        $this->session->set_flashdata('message_success', 'Ekuiditas telah direset!');
        redirect(site_url('laporan/ekuitas'));
    }
    // public function export_csv(){
    //     $filter = false;
    //     if(isset($_GET['search'])) {
    //         if (!empty($_GET['value']) && $_GET['value'] != '') {
    //             $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
    //         }
    //     }
    //     $data = $this->laporan_model->get_all_array($filter);
    //     $this->csv_library->export('laporan_transaksi.csv',$data);
    // }
    public function export_csv($name){
        $data['0'] = $this->input->post();
        //$data = $this->laporan_model->get_all_array();
        // echo "<pre>";
        // print_r($data);
        // die();
        $this->csv_library->export('laporan_'.$name.'.csv',$data);
    }
}
