<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('penjualan_model');
		$this->load->model('pengiriman_model');
		$this->load->model('pelanggan_model');
		$this->load->model('kategori_model');
		$this->load->model('produk_model');
		$this->load->model('karyawan_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id_stransaction']) && $_GET['id_stransaction'] != ''){
				$filter['sales_transaction.id_stransaction LIKE'] = "%".$_GET['id_stransaction']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(sales_transaction.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(sales_transaction.created_at) <='] = $_GET['date_end'];
			}
			$data['penjualans'] = $this->penjualan_model->get_filter($filter);
		}else{
			$data['penjualans'] = $this->penjualan_model->get_all();
		}
		$this->load->view('penjualan/index',$data);
	}
	
	function create(){
		// destry carts
		$this->cart->destroy();
		$data['status'] = array(array('status' => '0', 'name' => 'Pelanggan Biasa'), array('status' => '1', 'name' => 'Reseller'), array('status' => '2', 'name' => 'Dropshipper'));
		$data['code_penjualan'] = "OUT".strtotime(date("Y-m-d H:i:s"));
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['resellers'] = $this->pelanggan_model->get_all_reseller();
		$data['pelanggans'] = $this->pelanggan_model->get_all_pelanggan();
		$data['dropshippers'] = $this->pelanggan_model->get_all_dropshipper();
		$data['kategoris'] = $this->kategori_model->get_all();
		$data['onlines'] = $this->produk_model->get_id_online();
		$this->load->view('penjualan/form',$data);
	}
	
	public function detail($id){
		$details = $this->penjualan_model->get_detail($id);
		$pengirimans = $this->pengiriman_model->get_by_id_transaction($id);
		// echo "<pre>";
		// print_r($pengiriman);
		// die();
		if($details){
			$data['details'] = $details;
			$data['pengirimans'] = $pengirimans;
			$this->load->view('penjualan/detail',$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}
	public function edit($id){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();

		$transaksi = $this->penjualan_model->get_detail($id);
		if($transaksi){
			//print_r($transaksi); exit;
			$data['carts'] = $this->_process_cart($transaksi);
			$data['pembelian'] = $transaksi;
			$this->load->view('penjualan/form',$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}

	private function _process_cart($transaksi = ''){
		if($transaksi & is_array($transaksi)){
			foreach($transaksi as $key => $item){
				$data = array(
					'id'      => $item->product_id,
					'qty'     => $item->quantity,
					'price'   => $item->price_item,
					'category_id' => $item->category_id,
					'category_name' => $item->category_name,
					'name'    => $item->product_name
				);
				$this->cart->insert($data);
			}
		}
		$response = array(
				'data' => $this->cart->contents() ,
				'total_item' => $this->cart->total_items(),
				'total_price' => $this->cart->total()
			);
		return $response;
	}

	public function check_id(){
		$id = $this->input->post('id');
		$check_id = $this->penjualan_model->get_by_id($id);
		if(!$check_id){
			echo "available";
		}else{
			echo "unavailable";
		}
	}

	public function get_pelanggan($status){
		$pelanggan = $this->pelanggan_model->get_by_status($status);
		echo json_encode($pelanggan);
	}
	
	public function check_category_id($category_id){
		$products = $this->produk_model->get_by_category($category_id);
		echo json_encode($products);
	}
	
	public function check_id_online($id_online){
		$products = $this->produk_model->get_by_online($id_online);
		echo json_encode($products);
	}
	public function check_product_id($product_id){
		$products = $this->produk_model->get_by_id($product_id);
		echo json_encode($products);
	}
	public function add_item(){
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$sale_price = $this->input->post('sale_price');

		$get_product_detail =  $this->produk_model->detail_by_id($product_id);
		if($get_product_detail){
			$data = array(
				'id'      => $product_id,
				'qty'     => $quantity,
				'price'   => $sale_price,
				'category_id' => $get_product_detail[0]['category_id'],
				'category_name' => $get_product_detail[0]['category_name'],
				'name'    => $get_product_detail[0]['product_name']
			);
			$this->cart->insert($data);
			echo json_encode(array('status' => 'ok',
							'data' => $this->cart->contents() ,
							'total_item' => $this->cart->total_items(),
							'total_price' => $this->cart->total()
						)
				);
		}else{
			echo json_encode(array('status' => 'error'));
		}

	}
	public function delete_item($rowid){
		if($this->cart->remove($rowid)) {
			echo number_format($this->cart->total());
		}else{
			echo "false";
		}
	}
	public function add_process(){
		$this->form_validation->set_rules('sales_id', 'sales_id', 'required');
		$this->form_validation->set_rules('customer_id', 'customer_id', 'required');
		$this->form_validation->set_rules('is_cash', 'is_cash', 'required');

		$carts =  $this->cart->contents();
		if($this->_check_qty($carts)){
			echo json_encode(array('status' => 'limit'));
			exit;
		}
		
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id_stransaction'] = escape($this->input->post('sales_id'));
			$data['id_customer'] = escape($this->input->post('customer_id'));
			$data['id_dropshipper'] = escape($this->input->post('id_dropshipper'));
			$data['via'] = escape($this->input->post('via'));
			$data['is_cash'] = escape($this->input->post('is_cash'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();

			if($data['is_cash'] == 0){
				$data['pay_deadline_date'] = date('Y-m-d', strtotime("+30 days"));
			}else{
				$data['pay_deadline_date'] = date('Y-m-d');
			}

			$this->penjualan_model->insert($data);

			if($data['id_stransaction']){
				$this->_insert_purchase_data($data['id_stransaction'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}
	
	private function _check_qty($carts){
		$status = false;
		foreach($carts as $key => $cart){
			$product = $this->produk_model->get_by_id($cart['id']);
			if($cart['qty'] > $product[0]['product_qty']){
				$status = true;
				break;
			}
		}
		return $status;
	}
	private function _insert_purchase_data($id_stransaction,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'id_stransaction' => $id_stransaction,
				'id_product' => $cart['id'],
				'data_qty' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->penjualan_model->insert_purchase_data($purchase_data);

			$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));

			$bonus_tambah = $this->produk_model->get_by_id($cart['id'])[0]['bonus']*$cart['qty'];
			$bonus_sekarang = $this->karyawan_model->get_by_id($this->session->userdata('id_karyawan'))[0]['bonus_karyawan'];
			$total_bonus = $bonus_sekarang+$bonus_tambah;
			$this->karyawan_model->update($this->session->userdata('id_karyawan'), array('bonus_karyawan' => $total_bonus));
		}
		$this->cart->destroy();
	}
	public function delete($id_stransaction){
		$transaksi = $this->penjualan_model->get_detail($id_stransaction);
		foreach($transaksi as $trans){
			$product = $this->produk_model->get_by_id($trans->id_product);
			$total = $product[0]['product_qty'] + $trans->data_qty;
			$this->produk_model->update_qty($product[0]['id_product'] ,array('product_qty' => $total));
		}
		$this->penjualan_model->delete_temp($id_stransaction);
		$this->penjualan_model->delete_purchase_data_trx_temp($id_stransaction);
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('penjualan'));
	}
	public function export_csv(){
		$filter = '';
		if(isset($_GET['search'])) {
			if (!empty($_GET['id_stransaction']) && $_GET['id_stransaction'] != '') {
				$filter['sales_transaction.id_stransaction LIKE'] = "%" . $_GET['id_stransaction'] . "%";
			}

			if (!empty($_GET['date_from']) && $_GET['date_from'] != '') {
				$filter['DATE(sales_transaction.created_at) >='] = $_GET['date_from'];
			}

			if (!empty($_GET['date_end']) && $_GET['date_end'] != '') {
				$filter['DATE(sales_transaction.created_at) <='] = $_GET['date_end'];
			}
		}
		$result = $this->penjualan_model->get_filter_csv($filter);
		for ($i=0; $i < count($result); $i++) { 
            if ($result[$i]['Metode Pembayaran'] == 0) {
                $result[$i]['Metode Pembayaran'] = 'Utang';
            } else {
                $result[$i]['Metode Pembayaran'] = 'Tunai';
                $result[$i]['Tanggal Batas Pembayaran'] = '';
            }
        }
		$this->csv_library->export('penjualan_'.date("d-m-Y").'.csv',$result);
	}
	public function print_now($id = ""){
		$details = $this->penjualan_model->get_detail($id);
		$ongkir = $this->pengiriman_model->get_by_id_transaction($id);
		if($details){
			$data['details'] = $details;
			$data['ongkir'] = $ongkir[0]['ongkir'];
			$this->load->view("penjualan/print",$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}
	
	private function _set_csv_format($datas){
		$result = false;
		if(is_array($datas)){
			$data_before = "";
			foreach($datas as $k => $data){
				$datas[$k]['is_cash'] = ($data['is_cash'] == 1) ? "Cash" : "Bayar Nanti";
				$datas[$k]['pay_deadline_date'] = ($data['is_cash'] == 1) ? "" : $data["pay_deadline_date"];
				$datas[$k]['date'] = date("Y-m-d H:i:s",strtotime($data['date']));
				if($data['id'] == $data_before) {
					$datas[$k]['id'] = "";
					$datas[$k]['customer_id'] = "";
					$datas[$k]['customer_name'] = "";
					$datas[$k]['customer_phone'] = "";
					$datas[$k]['customer_address'] = "";
					$datas[$k]['category_name'] = "";
					$datas[$k]['total_price'] = "";
					$datas[$k]['total_item'] = "";
					$datas[$k]['is_cash'] = "";
					$datas[$k]['pay_deadline_date'] = "";

					$datas[$k]['date'] = "";
				}
				$data_before = $data['id'];
			}
			$result = $datas;
		}
		return $result;
	}
}
