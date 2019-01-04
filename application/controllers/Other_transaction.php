<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_transaction extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('other_transaction_model');
        $this->other_transaction = $this->other_transaction_model;
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index(){
       if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['id_otransaction']) && $_GET['id_otransaction'] != ''){
                $filter['other_transaction.id_otransaction LIKE'] = "%".$_GET['id_otransaction']."%";
            }

            if(!empty($_GET['type']) && $_GET['type'] != ''){
                $filter['other_transaction.type LIKE'] = "%".$_GET['type']."%";
            }

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(other_transaction.created_at) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(other_transaction.created_at) <='] = $_GET['date_end'];
            }

            $result = $this->other_transaction->get_filter($filter);
            $data['others'] = $result;
        }else{
            $result = $this->other_transaction->get_all();
            $data['others'] = $result;
        }

        $this->load->view('other/index',$data);
    }

    public function create(){
        $data['id_otransaction'] = "OTH".strtotime(date("Y-m-d H:i:s"));
        $this->load->view('other/form', $data);
    }

    public function check_id(){
        $id = $this->input->post('id_category');
        $check_id = $this->other_transaction->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->other_transaction->get_by_id($id);
        if($check_id){
            $data['other'] = $check_id[0];
            $this->load->view('other/form',$data);
        }else{
            redirect(site_url('other'));
        }
    }

    public function save($id = ''){
        
        $data['id_otransaction'] = escape($this->input->post('id_otransaction'));
        $data['type'] = escape($this->input->post('type'));
        $data['action'] = escape($this->input->post('action'));
        $data['cash_trx'] = escape(str_replace('.', '', str_replace('Rp ', '', $this->input->post('cash_trx'))));
        $data['description'] = escape($this->input->post('description'));
        if (!empty($id)) {
            // EDIT
            $check_id = $this->other_transaction->get_by_id($id);
            if($check_id){
                unset($data['id_otransaction']);
                $this->other_transaction->update($id,$data);
                $this->session->set_flashdata('message_success', 'Data berhasil diubah!');
            }
        }else{
            // INSERT NEW
            $this->other_transaction->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }

        redirect(site_url('other_transaction'));
    }
    public function delete($id){
        $check_id = $this->other_transaction->get_by_id($id);
        if($check_id){
            $this->other_transaction->delete_temp($id);
        }
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('other_transaction'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            $filter = '';
            if(!empty($_GET['id_otransaction']) && $_GET['id_otransaction'] != ''){
                $filter['other_transaction.id_otransaction LIKE'] = "%".$_GET['id_otransaction']."%";
            }

            if(!empty($_GET['type']) && $_GET['type'] != ''){
                $filter['other_transaction.type LIKE'] = "%".$_GET['type']."%";
            }

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(other_transaction.created_at) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(other_transaction.created_at) <='] = $_GET['date_end'];
            }
        }
        $data = $this->other_transaction->get_all_array($filter);
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['Aksi'] == 0) {
                $data[$i]['Aksi'] = 'Pengeluaran';
            } else {
                $data[$i]['Aksi'] = 'Pemasukan';
            }
        }
        $this->csv_library->export('other_transaction_'.date("d-m-Y").'.csv',$data);
    }
}
