<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('karyawan_model');
        $this->load->model('user_model');
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

            $data['karyawan'] = $this->karyawan_model->get_all();
            $data['users'] = $this->user_model->get_filter($filter);
        }else{

            $data['karyawan'] = $this->karyawan_model->get_all();
            $data['users'] = $this->user_model->get_all();
        }
        $this->load->view('user/index',$data);
    }

    public function create(){
        $this->load->view('user/form');
    }

    public function get_karyawan($id){
        echo json_encode($this->karyawan_model->get_by_id($id));
    }

    public function permission($id){
    	$data['list_menus'] = $this->user_model->get_all_menu();
    	$data['list_submenus'] = $this->user_model->get_all_submenu();
    	$data['user_menus'] = $this->auth_model->get_menu($id);
    	$data['user_submenus'] = $this->auth_model->get_menu_child($id);
    	$data['user'] = $this->user_model->get_by_id($id);

        $this->load->view('user/permission', $data);
    }

    public function edit($id = ''){
        $check_id = $this->user_model->get_by_id($id);
        if($check_id){
            $data['user'] = $check_id[0];
            $this->load->view('user/edit',$data);
        }else{
            redirect(site_url('user'));
        }
    }

    public function add_menu(){
        if ($this->input->post('id_menu') == '*') {
            $data['id_user'] = $this->input->post('id_user');
            $menus = $this->user_model->get_all_menu();
            foreach ($menus as $menu) {
                $data['id_menu'] = $menu->id_menu;
                $this->user_model->insert_menu($data);
            }
            $this->session->set_flashdata('message_success', 'Hak akses semua menu berhasil ditambahkan!');
        } else {
            $data['id_menu'] = $this->input->post('id_menu');
            $data['id_user'] = $this->input->post('id_user');
            $this->user_model->insert_menu($data);
            $this->session->set_flashdata('message_success', 'Hak akses menu berhasil ditambahkan!');
        }
        redirect('user/permission/'.$data['id_user']);
    }

    public function add_submenu(){
        if ($this->input->post('id_mchild') == '*') {
            $data['id_user'] = $this->input->post('id_user');
            $submenus = $this->user_model->get_all_submenu();
            foreach ($submenus as $submenu) {
                $data['id_mchild'] = $submenu->id_mchild;
                $this->user_model->insert_submenu($data);
            }
            $this->session->set_flashdata('message_success', 'Hak akses semua submenu berhasil ditambahkan!');
        } else {
            $data['id_mchild'] = $this->input->post('id_mchild');
            $data['id_user'] = $this->input->post('id_user');
            $this->user_model->insert_submenu($data);
            $this->session->set_flashdata('message_success', 'Hak akses submenu berhasil ditambahkan!');
        }
        redirect(site_url('user/permission/'.$data['id_user']));
    }

    public function save($id = ''){
    	// echo "<pre>";
    	// echo print_r($this->input->post());
    	// die();

        $data['full_name'] = escape($this->input->post('full_name'));
        $data['username'] = escape($this->input->post('email'));
        $data['email'] = escape($this->input->post('email'));
        $data['id_karyawan'] = escape($this->input->post('id_karyawan'));
        if ($id == '') {
	        $data['photo_profile'] = 'avatar3.png';
	        $data['password'] = escape(sha1($this->input->post('email')));
	        $data['permission'] = '1';
        }

  		// $config['upload_path'] = FCPATH.'public/uploads/';
  		// $config['allowed_types'] = 'jpg|png|jpeg';
		// $config['remove_spaces'] = FALSE;
		// $this->load->library('upload', $config);
		// $field_name = "photo_profil";

		// if ( ! $this->upload->do_upload($field_name))
		// {
		// 	$this->session->set_flashdata('message_error', 'An error occured! '.$this->upload->display_errors());
		// }
		// else
		// {
		// 	$data['photo_profil'] = $this->upload->data()['file_name'];
		// 	$this->user_model->insert($data);
		// 	$this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
		// }
		if (!empty($id)) {
            // EDIT
            $check_id = $this->user_model->get_by_id($id);
            if($check_id){
                $this->user_model->update($id,$data);
                $this->session->set_flashdata('message_success', 'Data berhasil diubah!');
            }
        }else{
            // INSERT NEW
            $this->user_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
        }
        redirect(site_url('user'));
    }
    public function delete($id){
        $check_id = $this->user_model->get_by_id($id);
        if($check_id){
            $this->user_model->delete_temp($id);
        }
        $this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
        redirect(site_url('user'));
    }
    public function delete_menu($id_umenu, $id_user){
        $this->user_model->delete_menu($id_umenu);
        $this->session->set_flashdata('message_success', 'Hak akses menu berhasil dihapus!');
        redirect(site_url('user/permission/'.$id_user));
    }
    public function delete_submenu($id_umchild, $id_user){
        $this->user_model->delete_submenu($id_umchild);
        $this->session->set_flashdata('message_success', 'Hak akses submenu berhasil dihapus!');
        redirect(site_url('user/permission/'.$id_user));
    }
    public function reset_password($id){
        $check_id = $this->user_model->get_by_id($id);
        if($check_id){
            $this->user_model->reset_password($id, $check_id[0]['username']);
        }
        $this->session->set_flashdata('message_success', 'Password telah direset!');
        redirect(site_url('user'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }
        }
        $data = $this->user_model->get_all_array($filter);
        $this->csv_library->export('user_'.date("d-m-Y").'.csv',$data);
    }
}
