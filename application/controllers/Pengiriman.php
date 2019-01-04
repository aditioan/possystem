<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('pengiriman_model');
		$this->load->model('pelanggan_model');
		$this->load->model('kategori_model');
		$this->load->model('produk_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id_pengiriman']) && $_GET['id_pengiriman'] != ''){
				$filter['pengiriman.id_pengiriman LIKE'] = "%".$_GET['id_pengiriman']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(pengiriman.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(pengiriman.created_at) <='] = $_GET['date_end'];
			}
			$data['pengirimans'] = $this->pengiriman_model->get_filter($filter);
		}else{
			$data['pengirimans'] = $this->pengiriman_model->get_all();
		}
		$this->load->view('pengiriman/index',$data);
	}
	
	function create($id){
		$data['code_penjualan'] = $id;
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$this->load->view('pengiriman/form',$data);
	}
	
	public function detail($id){
		$details = $this->pengiriman_model->get_detail($id);
		// echo "<pre>";
		// print_r($details);
		// die();
		if($details){
			$data['details'] = $details;
			$this->load->view('pengiriman/detail',$data);
		}else{
			redirect(site_url('pengiriman'));
		}
	}
	public function edit($id){
		$pengiriman = $this->pengiriman_model->get_by_id($id);
		if($pengiriman){
			$data['code_penjualan'] = $pengiriman[0]['id_stransaction'];
			$data['pengiriman'] = $pengiriman[0];
			$this->load->view('pengiriman/form',$data);
		}else{
			redirect(site_url('pengiriman'));
		}
	}

	public function save($id = ''){

		$data['id_stransaction'] = escape($this->input->post('id_stransaction'));
		$data['service'] = escape($this->input->post('service'));
		$data['no_resi'] = escape($this->input->post('no_resi'));
		$data['ongkir'] = escape($this->input->post('ongkir'));
		$data['ongkir_terpakai'] = escape($this->input->post('ongkir_terpakai'));

		if (!empty($id)) {
			$this->pengiriman_model->update($id,$data);
        	$this->session->set_flashdata('message_success', 'Data berhasil diubah!');
		}else{
			// INSERT NEW
			$this->pengiriman_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
		}
		redirect(site_url('pengiriman'));
	}
	public function delete($id){
		$check_id = $this->pengiriman_model->get_by_id($id);
		if($check_id){
			$this->pengiriman_model->delete_temp($id);
		}
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('pengiriman'));
	}
	public function export_csv(){
		$filter = false;
		if(isset($_GET['search'])) {
			$filter = '';
			if(!empty($_GET['id_pengiriman']) && $_GET['id_pengiriman'] != ''){
				$filter['pengiriman.id_pengiriman LIKE'] = "%".$_GET['id_pengiriman']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(pengiriman.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(pengiriman.created_at) <='] = $_GET['date_end'];
			}
		}
		$data = $this->pengiriman_model->get_all_array($filter);
		$this->csv_library->export('pengiriman_'.date("d-m-Y").'.csv',$data);
	}
}
