<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kongsinyasi extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('kongsinyasi_model');
		$this->load->model('produk_model');
		$this->load->model('kategori_model');
		$this->load->model('supplier_model');
		$this->load->model('transaksi_model');
        $this->load->library('form_validation');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	public function index(){
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
        $data['produks'] = $this->kongsinyasi_model->get_all();
		$data['onlines'] = $this->produk_model->get_id_online();
		$this->load->view('kongsinyasi/index',$data);
	}
	
	public function create(){
		$id_product = $this->input->post('id_product');
		$kongsinyasi_add = $this->input->post('kongsinyasi');

		$check_id = $this->produk_model->get_by_id($id_product);

		$data['kongsinyasi'] = $check_id[0]['kongsinyasi']+$kongsinyasi_add;
		$data['product_qty'] = $check_id[0]['product_qty']+$kongsinyasi_add;
		$this->produk_model->update($id_product,$data);
        $this->session->set_flashdata('message_success', 'Data kongsinyasi berhasil ditambah!');
        redirect(site_url('kongsinyasi'));
	}
	
	public function finish(){
		// echo "<pre>";
		// print_r($this->input->post());
		// die();
		$id_product = $this->input->post('id_product');
		$check_id = $this->produk_model->get_by_id($id_product);
		$transaksi['id_ptransaction'] = "IN".strtotime(date("Y-m-d H:i:s"));
		$transaksi['is_cash'] = "1";
		$transaksi['total_price'] = $check_id[0]['hpp']*($check_id[0]['kongsinyasi']-$check_id[0]['product_qty']);
		$transaksi['total_item'] = $check_id[0]['kongsinyasi']-$check_id[0]['product_qty'];
		$transaksi['id_supplier'] = $this->input->post('id_supplier');

		$transaksi_data = array(
				'id_ptransaction' => "IN".strtotime(date("Y-m-d H:i:s")),
				'id_product' => $id_product,
				'data_qty' => $check_id[0]['kongsinyasi']-$check_id[0]['product_qty'],
				'price_item' => $check_id[0]['hpp'],
				'subtotal' => $check_id[0]['hpp']*($check_id[0]['kongsinyasi']-$check_id[0]['product_qty'])
			);
		
		$data['kongsinyasi'] = '0';
		$data['product_qty'] = '0';

		$this->transaksi_model->insert($transaksi);
		$this->transaksi_model->insert_purchase_data($transaksi_data);
		$this->produk_model->update($id_product,$data);
        $this->session->set_flashdata('message_success', 'Kongsinyasi selesai!');
        redirect(site_url('kongsinyasi'));
	}

	public function edit(){
		$id_product = $this->input->post('id_product');
		$data['kongsinyasi'] = $this->input->post('kongsinyasi_new');
		$data['product_qty'] = $this->input->post('product_qty')+($this->input->post('kongsinyasi_new')-$this->input->post('kongsinyasi_old'));
		//echo $check_id[0]['product_qty'];
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->produk_model->update($id_product,$data);
        $this->session->set_flashdata('message_success', 'Data kongsinyasi berhasil diubah!');
        redirect(site_url('kongsinyasi'));
	}

	public function delete($id){
		$check_id = $this->produk_model->get_by_id($id);
		if($check_id){
			$this->kongsinyasi_model->delete($id);
		}
		$this->session->set_flashdata('message_success', 'Data kongsinyasi berhasil dihapus!');
		redirect(site_url('kongsinyasi'));
	}

    public function export_csv($id)
    {
        $data = $this->supplier_model->get_pembelian($id)->result_array();
        $this->csv_library->export('pembelian_supplier_'.$data[0]['supplier_name'].'_'.date("d-m-Y").'.csv',$data);
    }
	
	public function check_id_online($id_online){
		$products = $this->produk_model->get_by_online($id_online);
		echo json_encode($products);
	}
}
