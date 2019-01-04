<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('produk_model');
        $this->load->library('form_validation');
        $this->load->library('barcode_library');

        $this->load->model('kategori_model');
        
        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index($warning = ''){
        if(isset($_GET['search'])){
            $filter = array();
            if(!empty($_GET['id_category']) && $_GET['id_category'] != ''){
                $filter['product.id_category LIKE'] = "%".$_GET['id_category']."%";
            }
            $data['kategoris'] = $this->kategori_model->get_all();
            $data['persediaan'] = (int)$this->produk_model->get_persediaan($filter);
            $data['produks'] = $this->produk_model->get_filter($filter);
        }else{
            $data['kategoris'] = $this->kategori_model->get_all();
            $data['persediaan'] = (int)$this->produk_model->get_persediaan();
            $data['produks'] = $this->produk_model->get_all();
            // $data['persediaan_tambah'] = $this->produk_model->get_persediaan_tambah();
            // for ($i=0; $i < count($data['persediaan_tambah']); $i++) { 
            //     $data['persediaan_tambah'][$i]['data_qty']
            // }
        }
        // echo $this->db->last_query();
        // echo "<pre>";
        // echo print_r($data['persediaan_tambah']);
        // die();
        $this->load->view('produk/index',$data);
    }

    public function generate_barcode($id_product, $product_name)
    {
        //echo $id_product;
        $refl = new ReflectionClass($this->barcode_library);
        //echo $this->barcode_library->getBarcodeHTML($id_product, $refl->getConstants()['TYPE_CODE_128']);
        echo '<img src="data:image/png;base64,' . base64_encode($this->barcode_library->getBarcodePNG($id_product, $refl->getConstants()['TYPE_CODE_128'])) . '" alt="'.$product_name.'">';
        //base64_encode($this->barcode_library->getBarcodePNG($id_product, $product_name, $refl->getConstants()['TYPE_CODE_128']));
    }

    public function warning(){
        if(isset($_GET['search'])){
            $filter = array();
            if(!empty($_GET['value']) && $_GET['value'] != ''){
                $filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
            }
            $data['kategoris'] = $this->kategori_model->get_all();
            $data['persediaan'] = (int)$this->produk_model->get_persediaan($filter);
            $data['produks'] = $this->produk_model->get_filter($filter);
        }else{
            $data['kategoris'] = $this->kategori_model->get_all();
            $data['persediaan'] = (int)$this->produk_model->get_persediaan();
            $data['produks'] = $this->produk_model->get_all();
        }
        $data['warning'] = 'true';
        
        $this->load->view('produk/index',$data);
    }

    public function restock(){
        if(isset($_GET['search'])){
            $filter = array();

            if(!empty($_GET['value']) && $_GET['value'] != ''){
                $filter['product.'.$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
            }

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(product_restock.restock_date) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(product_restock.restock_date) <='] = $_GET['date_end'];
            }

            $data['restock'] = $this->produk_model->get_restock_filter($filter);
        }else{
            $data['restock'] = $this->produk_model->get_all_restock();
        }
        
        $this->load->view('produk/restock',$data);
    }

    public function create(){
        $data['category'] = $this->kategori_model->get_all();
        $data['unit'] = array('pcs','box','set','rim','dos','roll','pack');
        $this->load->view('produk/form',$data);
    }

    public function check_id(){
        $id = $this->input->post('id_product');
        $check_id = $this->produk_model->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->produk_model->get_by_id($id);
        if($check_id){
            $data['category'] = $this->kategori_model->get_all();
            $data['produk'] = $check_id[0];
            $data['unit'] = array('pcs','box','set','rim','dos','roll','pack');
            $this->load->view('produk/form',$data);
        }else{
            redirect(site_url('produk'));
        }
    }

    public function statistik($id = ''){
        $check_id = $this->produk_model->get_by_id($id);
        if($check_id){
            $data['penjualan'] = $this->produk_model->get_penjualan($id)->result();
            $data['total_penjualan'] = (int)$this->produk_model->get_total_penjualan($id)-(int)$this->produk_model->get_total_retur_penjualan($id);
            $data['pembelian'] = $this->produk_model->get_pembelian($id)->result();
            $data['hpp'] = (int)$this->produk_model->get_hpp($id)-(int)$this->produk_model->get_hpp_retur($id);
            $data['retur_penjualan'] = $this->produk_model->get_retur_penjualan($id)->result();
            $data['retur_pembelian'] = $this->produk_model->get_retur_pembelian($id)->result();
            $data['total_retur_penjualan'] = (int)$this->produk_model->get_total_retur_penjualan($id);
            $data['total_retur_pembelian'] = (int)$this->produk_model->get_total_retur_pembelian($id);
            $data['total_pembelian'] = (int)$this->produk_model->get_total_pembelian($id);
            $data['category'] = $this->kategori_model->get_all();
            $data['produk'] = $check_id[0];
            $data['unit'] = array('ea','box','set','rim','dos','roll','pack');
            // echo $this->db->last_query();
            // echo "<pre>";
            // echo print_r($data['retur_penjualan']);
            // die();
            $this->load->view('produk/statistik',$data);
        }else{
            redirect(site_url('produk'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('id_product', 'ID', 'required');
        $this->form_validation->set_rules('product_name', 'Nama', 'required');
        $this->form_validation->set_rules('id_category', 'Kategori', 'required');
        $this->form_validation->set_rules('sale_price', 'Harga', 'required');

        $data['id_product'] = escape($this->input->post('id_product'));
        $data['id_online'] = escape($this->input->post('id_online'));
        $data['product_name'] = escape($this->input->post('product_name'));
        $data['product_qty'] = escape($this->input->post('product_qty'));
        $data['minimum_qty'] = escape($this->input->post('minimum_qty'));
        $data['product_unit'] = escape($this->input->post('product_unit'));
        $data['id_category'] = escape($this->input->post('id_category'));
        $data['product_desc'] = escape($this->input->post('product_desc'));
        $data['hpp'] = escape($this->input->post('hpp'));
        $data['bonus'] = escape($this->input->post('bonus'));
        $data['sale_price'] = escape($this->input->post('sale_price'));
        $data['sale_price_type1'] = escape($this->input->post('sale_price_type1'));
        $data['sale_price_type2'] = escape($this->input->post('sale_price_type2'));
        $data['sale_price_type3'] = escape($this->input->post('sale_price_type3'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->produk_model->get_by_id($id);
            if($check_id){
                unset($data['id_product']);
                $this->produk_model->update($id,$data);
                $this->session->set_flashdata('message_success', 'Data berhasil diubah!');
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->produk_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('produk/create'));
        }
        redirect(site_url('produk'));
    }

    public function delete($id){
        $delete = $this->produk_model->delete_temp($id);
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('produk'));
    }

    public function delete_restock($id){
        $delete = $this->produk_model->delete_restock_temp($id);
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('produk/restock'));
    }

    public function restock_product($warning = '')
    {
        $edit = $this->produk_model->restock();
        $this->session->set_flashdata('message_success', 'Data restock berhasil dimasukkan!');
        if ($warning == 'warning') {
            redirect('produk/warning');
        }
        redirect('produk');
    }

    public function export_csv($slug = ''){
        $filter = false;
        $name = '';
        if ($slug == 'warning') {
            if(isset($_GET['search'])) {
                if(!empty($_GET['id_category']) && $_GET['id_category'] != ''){
                    $filter['product.id_category LIKE'] = "%".$_GET['id_category']."%";
                }
            }
            $data = $this->produk_model->get_all_warning_array($filter);
            $name = "produk_warning_".date("d-m-Y").".csv";
        } elseif ($slug == 'restock') {
            if(!empty($_GET['value']) && $_GET['value'] != ''){
                $filter['product.'.$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
            }
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(product_restock.restock_date) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(product_restock.restock_date) <='] = $_GET['date_end'];
            }
            $data = $this->produk_model->get_all_restock_array($filter);
        } else {
            if(isset($_GET['search'])) {
                if(!empty($_GET['id_category']) && $_GET['id_category'] != ''){
                    $filter['product.id_category LIKE'] = "%".$_GET['id_category']."%";
                }
            }
            $data = $this->produk_model->get_all_array($filter);
            $name = "produk_".date("d-m-Y").".csv";
        }
        
        $this->csv_library->export($name,$data);
    }

    public function export_penjualan($id)
    {
        $data = $this->produk_model->get_penjualan($id)->result_array();
        $this->csv_library->export('penjualan_produk_'.date("d-m-Y").'.csv',$data);
    }

    public function export_pembelian($id)
    {
        $data = $this->produk_model->get_pembelian($id)->result_array();
        $this->csv_library->export('pembelian_produk_'.date("d-m-Y").'.csv',$data);
    }

    public function export_retur_penjualan($id)
    {
        $data = $this->produk_model->get_retur_penjualan($id)->result_array();
        $this->csv_library->export('retur_penjualan_produk_'.date("d-m-Y").'.csv',$data);
    }

    public function export_retur_pembelian($id)
    {
        $data = $this->produk_model->get_retur_pembelian($id)->result_array();
        $this->csv_library->export('retur_pembelian_produk_'.date("d-m-Y").'.csv',$data);
    }
}
