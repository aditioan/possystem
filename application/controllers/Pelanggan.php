<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('pelanggan_model');
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index(){
        if(isset($_GET['search'])){
            $filter = array();
            if(!empty($_GET['value']) && $_GET['value'] != ''){
                $filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
            }
            if(!empty($_GET['value']) && $_GET['value'] == 'zero'){
                $filter[$_GET['search_by'].' LIKE'] = "%0%";
            }
            $data['pelanggans'] = $this->pelanggan_model->get_filter($filter);
        }else{
            $data['pelanggans'] = $this->pelanggan_model->get_all();
        }

        $this->load->view('pelanggan/index',$data);
    }

    public function create(){
        $data['status'] = array(array('status' => '0', 'name' => 'Pelanggan Biasa'), array('status' => '1', 'name' => 'Reseller'), array('status' => '2', 'name' => 'Dropshipper'));
        $code_supplier = $this->pelanggan_model->get_last_id();
        if($code_supplier){
            $id = $code_supplier[0]->id_customer;
            $data['code_pelanggan'] = generate_code('CUST',$id,8);
        }else{
            $data['code_pelanggan'] = 'CUST00000001';
        }

        $this->load->view('pelanggan/form',$data);
    }

    public function edit($id = ''){
        $data['status'] = array(array('status' => '0', 'name' => 'Pelanggan Biasa'), array('status' => '1', 'name' => 'Reseller'), array('status' => '2', 'name' => 'Dropshipper'));
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $data['pelanggan'] = $check_id[0];
            $this->load->view('pelanggan/form',$data);
        }else{
            redirect(site_url('pelanggan'));
        }
    }

    public function statistik($id){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data['id_customer'] = $id;
                    $data['customer_name'] = $check_id[0]['customer_name'];
                    $data['status'] = "Dropshipper";
                    $data['transaksis'] = $this->pelanggan_model->get_penjualan_dropshipper($id, $filter)->result();
                    $data['data_retur'] = $this->pelanggan_model->get_retur_penjualan_dropshipper($id, $filter)->result();
                    $data['penjualan'] = (int)$this->pelanggan_model->get_total_penjualan_dropshipper($id, $filter);
                    $data['retur'] = (int)$this->pelanggan_model->get_total_retur_penjualan_dropshipper($id, $filter);
                    $data['tunggakan'] = (int)$this->pelanggan_model->get_total_tunggakan_dropshipper($id, $filter);
                    $this->load->view('pelanggan/statistik',$data);
                } else {
                    $data['id_customer'] = $id;
                    $data['customer_name'] = $check_id[0]['customer_name'];
                    $data['status'] = ($check_id[0]['status']==0)?"Pelanggan":"Reseller";
                    $data['transaksis'] = $this->pelanggan_model->get_penjualan($id, $filter)->result();
                    $data['data_retur'] = $this->pelanggan_model->get_retur_penjualan($id, $filter)->result();
                    $data['penjualan'] = (int)$this->pelanggan_model->get_total_penjualan($id, $filter);
                    $data['retur'] = (int)$this->pelanggan_model->get_total_retur_penjualan($id, $filter);
                    $data['tunggakan'] = (int)$this->pelanggan_model->get_total_tunggakan($id, $filter);
                    $this->load->view('pelanggan/statistik',$data);
                }
            }else{
                redirect(site_url('pelanggan'));
            }
        }else{
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data['id_customer'] = $id;
                    $data['customer_name'] = $check_id[0]['customer_name'];
                    $data['status'] = "Dropshipper";
                    $data['transaksis'] = $this->pelanggan_model->get_penjualan_dropshipper($id)->result();
                    $data['data_retur'] = $this->pelanggan_model->get_retur_penjualan_dropshipper($id)->result();
                    $data['penjualan'] = (int)$this->pelanggan_model->get_total_penjualan_dropshipper($id);
                    $data['retur'] = (int)$this->pelanggan_model->get_total_retur_penjualan_dropshipper($id);
                    $data['tunggakan'] = (int)$this->pelanggan_model->get_total_tunggakan_dropshipper($id);
                    $this->load->view('pelanggan/statistik',$data);
                } else {
                    $data['id_customer'] = $id;
                    $data['customer_name'] = $check_id[0]['customer_name'];
                    $data['status'] = ($check_id[0]['status']==0)?"Pelanggan":"Reseller";
                    $data['transaksis'] = $this->pelanggan_model->get_penjualan($id)->result();
                    $data['data_retur'] = $this->pelanggan_model->get_retur_penjualan($id)->result();
                    $data['penjualan'] = (int)$this->pelanggan_model->get_total_penjualan($id);
                    $data['retur'] = (int)$this->pelanggan_model->get_total_retur_penjualan($id);
                    $data['tunggakan'] = (int)$this->pelanggan_model->get_total_tunggakan($id);
                    $this->load->view('pelanggan/statistik',$data);
                }
            }else{
                redirect(site_url('pelanggan'));
            }
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('id_customer', 'ID', 'required');
        $this->form_validation->set_rules('customer_name', 'Nama', 'required');

        $data['id_customer'] = escape($this->input->post('id_customer'));
        $data['customer_name'] = escape($this->input->post('customer_name'));
        $data['customer_category'] = escape($this->input->post('customer_category'));
        $data['calling'] = escape($this->input->post('calling'));
        $data['customer_phone'] = escape($this->input->post('customer_phone'));
        $data['customer_address'] = escape($this->input->post('customer_address'));
        $data['status'] = escape($this->input->post('status'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->pelanggan_model->get_by_id($id);
            if($check_id){
                unset($data['id_customer']);
                $this->pelanggan_model->update($id,$data);
                $this->session->set_flashdata('message_success', 'Data berhasil diubah!');
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->pelanggan_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('pelanggan/create'));
        }
        redirect(site_url('pelanggan'));
    }
    public function delete($id){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $this->pelanggan_model->delete_temp($id);
        }
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('pelanggan'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }
        }
        $data = $this->pelanggan_model->get_all_array($filter);
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['Jenis Pelanggan'] == 0) {
                $data[$i]['Jenis Pelanggan'] = 'Pelanggan Biasa';
            } elseif ($data[$i]['Jenis Pelanggan'] == 1) {
                $data[$i]['Jenis Pelanggan'] = 'Reseller';
            } else {
                $data[$i]['Jenis Pelanggan'] = 'Dropshipper';
            }
        }
        $this->csv_library->export('pelanggan_'.date("d-m-Y").'.csv',$data);
    }
    public function export_penjualan($id)
    {
        $check_id = $this->pelanggan_model->get_by_id($id);
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data = $this->pelanggan_model->export_penjualan_dropshipper($id, $filter)->result_array();
                    $this->csv_library->export('penjualan_dropshipper_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                } else {
                    $data = $this->pelanggan_model->export_penjualan($id, $filter)->result_array();
                    $this->csv_library->export('penjualan_pelanggan_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                }
            }else{
                $this->session->set_flashdata('message_error', 'Terjadi kesalahan!');
                redirect(site_url('pelanggan/statistik/'.$id));
            }
        }else{
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data = $this->pelanggan_model->export_penjualan_dropshipper($id)->result_array();
                    $this->csv_library->export('penjualan_dropshipper_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                } else {
                    $data = $this->pelanggan_model->export_penjualan($id)->result_array();
                    $this->csv_library->export('penjualan_pelanggan_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                }
            }else{
                $this->session->set_flashdata('message_error', 'Terjadi kesalahan!');
                redirect(site_url('pelanggan/statistik/'.$id));
            }
        }
    }
    public function export_retur($id)
    {
        $check_id = $this->pelanggan_model->get_by_id($id);
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data = $this->pelanggan_model->export_retur_penjualan_dropshipper($id, $filter)->result_array();
                    $this->csv_library->export('penjualan_dropshipper_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                } else {
                    $data = $this->pelanggan_model->export_retur_penjualan($id, $filter)->result_array();
                    $this->csv_library->export('retur_penjualan_pelanggan_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                }
            }else{
                $this->session->set_flashdata('message_error', 'Terjadi kesalahan!');
                redirect(site_url('pelanggan/statistik/'.$id));
            }
        }else{
            if($check_id){
                if ($check_id[0]['status'] == 2) {
                    $data = $this->pelanggan_model->export_retur_penjualan_dropshipper($id)->result_array();
                    $this->csv_library->export('penjualan_dropshipper_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                } else {
                    $data = $this->pelanggan_model->export_retur_penjualan($id)->result_array();
                    $this->csv_library->export('retur_penjualan_pelanggan_'.$check_id[0]['customer_name'].'_'.date("d-m-Y").'.csv',$data);
                }
            }else{
                $this->session->set_flashdata('message_error', 'Terjadi kesalahan!');
                redirect(site_url('pelanggan/statistik/'.$id));
            }
        }
    }
}
