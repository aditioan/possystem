<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('user_model');
		$this->load->model('supplier_model');
		$this->load->model('pelanggan_model');
		$this->load->model('produk_model');
		$this->load->model('kategori_model');
        $this->load->model('penjualan_model');
        $this->load->model('retur_penjualan_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		redirect(site_url('home/dashboard'));
	}

	function change_password(){
		$this->load->view('home/change_password');
	}

	function save_password(){
		$user = $this->user_model->get_by_id($this->session->userdata('id_user'));
		$old_password = escape(sha1($this->input->post('old_password')));
		if ($old_password == $user[0]['password']) {
			$data['password'] = escape(sha1($this->input->post('new_password')));
			$this->user_model->update($this->session->userdata('id_user'),$data);
            $this->session->set_flashdata('message_success', 'Password berhasil diubah!');
		} else {
			 $this->session->set_flashdata('message_error', 'Password lama salah!');
		}
		
		redirect(site_url('home/change_password'));
	}
	
	function dashboard(){
		$date = date('Y-m-d', strtotime("+30 days"));
		$filter['DATE(sales_transaction.pay_deadline_date) <='] = $date;
		$limit_offset['limit'] = 10;
		$limit_offset['offset'] = 0;
        $data['tunggakans'] = $this->penjualan_model->get_filter_tunggakan($filter,$limit_offset);
		
		$data['suppliers'] = $this->supplier_model->count_total();
		$data['customers'] = $this->pelanggan_model->count_total();
		$data['products'] = $this->produk_model->count_total();
		$data['categories'] = $this->kategori_model->count_total();
		$data['penjualan_harian'] = $this->penjualan_daily();
		$data['penjualan_bulanan'] = $this->penjualan_daily(true);
		$data['sales_retur'] = $this->retur_penjualan_model->count_total();
		// $data['menus'] = $this->auth_model->get_menu($this->session->userdata('id_user'));
		//$data['mchilds'] = $this->auth_model->get_menu_child($this->session->userdata('id_user'));
		// for ($i=0; $i < count($data['menus']); $i++) { 
		// 	$data['mchilds'][$i] = $this->auth_model->get_menu_child($data['menus'][$i]['id_menu']);
		// }
		// foreach ($data['menus'] as $menu) {
		// 	$data['mchilds'] = $this->auth_model->get_menu_child($menu['id_menu']);
		// }
		//echo $this->db->last_query()."<br>";
		// for ($i=0; $i < count($data['menus']); $i++) {
		// 	for ($j=0; $j < count($data['mchilds'][$i]); $j++) { 
		// 		if ($data['mchilds'][$i][$j]['id_menu'] == $data['menus'][$i]['id_menu']) {
		// 			echo $data['mchilds'][$i][$j]['mchild_name']."<br>";
		// 		}
		// 	}
		// }
		//echo "<pre>";
		//echo print_r($data['mchilds']);
		// foreach ($data['mchilds'] as $child) {
		// 	echo print_r($child->mchild_name);
		// }
		//die();
		$this->load->view('home/dashboard',$data);
	}
	
	private function penjualan_daily($bulanan = false){
		$today = date("Y-m-d",strtotime("today"));
		$yesterday = date("Y-m-d",strtotime("-1 day"));	
		if($bulanan){
			$yesterday = date("Y-m-d",strtotime("-30 day"));	
		}	

		$filter['DATE(sales_transaction.created_at) >='] = $yesterday;
		$filter['DATE(sales_transaction.created_at) <='] = $today;

		$penjualans = $this->penjualan_model->get_filter($filter,url_param());
		return $penjualans;
	}
}
