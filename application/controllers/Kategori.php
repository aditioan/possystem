<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('kategori_model');
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
            $data['kategoris'] = $this->kategori_model->get_filter($filter);
        }else{
            $data['kategoris'] = $this->kategori_model->get_all();
        }

        $this->load->view('kategori/index',$data);
    }

    public function create(){
        $code_category = $this->kategori_model->get_last_id();
        if($code_category){
            $id = $code_category[0]->id_category;
            $data['code_category'] = generate_code('CAT',$id);
        }else{
            $data['code_category'] = 'CAT001';
        }
        $this->load->view('kategori/form', $data);
    }

    public function check_id(){
        $id = $this->input->post('id_category');
        $check_id = $this->kategori_model->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->kategori_model->get_by_id($id);
        if($check_id){
            $data['kategori'] = $check_id[0];
            $this->load->view('kategori/form',$data);
        }else{
            redirect(site_url('kategori'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('id_category', 'ID', 'required');
        $this->form_validation->set_rules('category_name', 'Nama', 'required');

        $data['id_category'] = escape($this->input->post('id_category'));
        $data['category_name'] = escape($this->input->post('category_name'));
        $data['category_desc'] = escape($this->input->post('category_desc'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->kategori_model->get_by_id($id);
            if($check_id){
                unset($data['id_category']);
                $this->kategori_model->update($id,$data);
                $this->session->set_flashdata('message_success', 'Data berhasil diubah!');
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->kategori_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('kategori/create'));
        }
        redirect(site_url('kategori'));
    }
    public function delete($id){
        $check_id = $this->kategori_model->get_by_id($id);
        if($check_id){
            $this->kategori_model->delete_temp($id);
        }
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('kategori'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }
        }
        $data = $this->kategori_model->get_all_array($filter);
        $this->csv_library->export('kategori_'.date("d-m-Y").'.csv',$data);
    }
}
