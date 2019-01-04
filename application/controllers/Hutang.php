<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hutang extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('produk_model');
        $this->load->library('form_validation');
        $this->load->model('kategori_model');

        // Check Session Login
        if (!isset($_SESSION['logged_in'])) {
            redirect(site_url('auth/login'));
        }
    }

    public function index()
    {
        $filter = '';
        // if(!empty($_GET['id_stransaction']) && $_GET['id_stransaction'] != ''){
        //     $filter['sales_transaction.id_stransaction LIKE'] = "%".$_GET['id_stransaction']."%";
        // }

        if(!empty($_GET['date_range']) && $_GET['date_range'] != ''){
            $date = date('Y-m-d', strtotime("+".$_GET['date_range']." days"));
            $filter['DATE(purchase_transaction.pay_deadline_date) <='] = $date;
        }

        if(!empty($_GET['date_trx']) && $_GET['date_trx'] != ''){
            $filter['DATE(purchase_transaction.created_at)'] = $_GET['date_trx'];
        }
        $data['hutangs'] = $this->transaksi_model->get_filter_hutang($filter);
        $this->load->view('hutang/index',$data);
    }
    public function detail($id){
        $data['details'] = $this->transaksi_model->get_detail($id);
        $this->load->view('hutang/detail',$data);
    }
    public function update_lunas($id){
        $details = $this->transaksi_model->get_detail($id);
        if($details){
            $data['is_cash'] = 1;
            $this->transaksi_model->update($id,$data);
        }
        $this->session->set_flashdata('message_success', 'Data sudah dilunasi!');

        redirect(site_url('hutang'));
    }
    public function delete($id){
        $transaksi = $this->transaksi_model->get_detail($id);
        foreach($transaksi as $trans){
            $product = $this->produk_model->get_by_id($trans->id_product);
            $total = $product[0]['product_qty'] - $trans->data_qty;
            $this->produk_model->update_qty($product[0]['id_product'], array('product_qty' => $total));
        }
        $this->transaksi_model->delete_temp($id);
        $this->transaksi_model->delete_purchase_data_trx_temp($id);
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');

        redirect(site_url('hutang'));
    }
    public function export_csv(){
        $filter = false;
        // if(!empty($_GET['id_stransaction']) && $_GET['id_stransaction'] != ''){
        //     $filter['sales_transaction.id_stransaction LIKE'] = "%".$_GET['id_stransaction']."%";
        // }

        if(!empty($_GET['date_range']) && $_GET['date_range'] != ''){
            $date = date('Y-m-d', strtotime("+".$_GET['date_range']." days"));
            $filter['DATE(purchase_transaction.pay_deadline_date) <='] = $date;
        }

        if(!empty($_GET['date_trx']) && $_GET['date_trx'] != ''){
            $filter['DATE(purchase_transaction.created_at)'] = $_GET['date_trx'];
        }
        
        $data = $this->transaksi_model->get_filter_array($filter);
        $this->csv_library->export('utang_'.date("d-m-Y").'.csv',$data);
    }
}