<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');		
	}
	
	function index(){
		redirect(site_url());
	}
	
	function login(){		
		// Check Session Login
		if(isset($_SESSION['logged_in'])){
			redirect(site_url());
		}
		
		// Check Remember Me
		if(isset($_COOKIE['remember_me'])){			
			$this->auth_model->set_session($_COOKIE['remember_me']);
			redirect(site_url());
		}
		$this->load->view('auth/login');
	}
	
	public function login_process($check_login = false){
		// Check Session Login
		if(isset($_SESSION['logged_in'])){
			redirect(site_url());
		}
		// Check Remember Me
		if(isset($_COOKIE['remember_me'])){			
			$this->auth_model->set_session($_COOKIE['remember_me']);
			redirect(site_url());
		}
		$username = escape($this->input->post("username"));		
		$password = sha1(escape($this->input->post("password")));
		$remember_me = escape($this->input->post("remember_me"));	
		if($username && $password){
			$check_login = $this->auth_model->check_login($username,$password);	
		}
		if($check_login){
			$id_user = $check_login[0]->id_user;
			$username = $check_login[0]->username;
			$email = $check_login[0]->email;
			$photo_profile = $check_login[0]->photo_profile;
			$newdata = array(
				'id_user'	=> $id_user,
				'username'  => $username,
				'email'  => $email,
				'id_karyawan' => $check_login[0]->id_karyawan,
				'photo_profile'  => $photo_profile,
				'logged_in' => TRUE
			);
			$menus = '';
			$mchilds = '';
			if ($check_login[0]->permission == 0) {
				$menus = $this->auth_model->get_all_menu();
				$mchilds = $this->auth_model->get_all_menu_child();
			} else {
				$menus = $this->auth_model->get_menu($id_user);
				$mchilds = $this->auth_model->get_menu_child($id_user);
			}
			
			$this->session->set_userdata($newdata);
			$this->session->set_userdata('menus', $menus);
			$this->session->set_userdata('mchilds', $mchilds);
			// echo "<pre>";
			// echo print_r($this->session->all_userdata());
			// die();
			//$this->auth_model->set_session($id,$username);
			if($remember_me){
				$this->auth_model->set_cookie_remember($username);
			}
			redirect(site_url());
		}else{
			$this->session->set_flashdata('login_false', 'Username atau Password salah.');
			redirect(site_url('auth/login'));
		}
	}
	
	function logout(){
		$this->auth_model->unset_session();
		$this->auth_model->unset_cookie_remember();
		redirect(site_url());
	}
}
