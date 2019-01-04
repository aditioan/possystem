<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('transaksi_model');
		$this->load->model('supplier_model');
		$this->load->model('kategori_model');
		$this->load->model('produk_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		if(isset($_GET['search'])){
			$filter = array();

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(purchase_transaction.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(purchase_transaction.created_at) <='] = $_GET['date_end'];
			}

			$data['transaksis'] = $this->transaksi_model->get_filter($filter);
		}else{
			$data['transaksis'] = $this->transaksi_model->get_all();
		}
		$this->load->view('transaksi/index',$data);
	}
	
	function create(){
		// destry cart
		$this->cart->destroy();

		$data['id_ptransaction'] = "IN".strtotime(date("Y-m-d H:i:s"));
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$data['onlines'] = $this->produk_model->get_id_online();
		$this->load->view('transaksi/form',$data);
	}
	
	public function detail($id){
		$details = $this->transaksi_model->get_detail($id);
		if($details){
			$data['details'] = $details;
			$this->load->view('transaksi/detail',$data);
		}else{
			redirect(site_url('transaksi'));
		}
	}
	public function edit($id){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();

		$transaksi = $this->transaksi_model->get_detail($id);
		if($transaksi){
			//print_r($transaksi); exit;
			$data['carts'] = $this->_process_cart($transaksi);
			$data['transaksi'] = $transaksi;
			$this->load->view('transaksi/form',$data);
		}else{
			redirect(site_url('transaksi'));
		}
	}

	private function _process_cart($transaksi = ''){
		if($transaksi & is_array($transaksi)){
			foreach($transaksi as $key => $item){
				$data = array(
					'id_product'      => $item->id_product,
					'qty'     => $item->quantity,
					'price'   => $item->price_item,
					//'id_category' => $item->id_category,
					//'category_name' => $item->category_name,
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
		$id = $this->input->post('id_ptransaction');
		$check_id = $this->transaksi_model->get_by_id($id);
		if(!$check_id){
			echo "available";
		}else{
			echo "unavailable";
		}
	}
	
	public function check_category_id($id_category){
		$products = $this->produk_model->get_by_category($id_category);
		echo json_encode($products);
	}
	public function check_product_id($id_product){
		$products = $this->produk_model->get_by_id($id_product);
		echo json_encode($products);
	}
	public function test($id = ''){
		$detail =  $this->produk_model->detail_by_id($id);
		echo "<pre>";
		print_r($detail);
	}
	public function add_item(){
		$id_product = $this->input->post('id_product');
		$data_qty = $this->input->post('data_qty');
		$sale_price = $this->input->post('sale_price');

		$get_product_detail =  $this->produk_model->detail_by_id($id_product);
		if($get_product_detail){
			$data = array(
				'id'      => $id_product,
				'qty'     => $data_qty,
				'price'   => $sale_price,
				'id_category' => $get_product_detail[0]['id_category'],
				'category_name' => $get_product_detail[0]['category_name'],
				'id_online' => $get_product_detail[0]['id_online'],
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
		$this->form_validation->set_rules('transaction_id', 'id_ptransaction', 'required');
		$this->form_validation->set_rules('supplier_id', 'id_supplier', 'required');

		$carts =  $this->cart->contents();
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id_ptransaction'] = escape($this->input->post('transaction_id'));
			$data['is_cash'] = escape($this->input->post('is_cash'));
			$data['id_supplier'] = escape($this->input->post('supplier_id'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();

			$this->transaksi_model->insert($data);

			if($data['id_ptransaction']){
				$this->_insert_purchase_data($data['id_ptransaction'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}
	private function _insert_purchase_data($id_ptransaction,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'id_ptransaction' => $id_ptransaction,
				'id_product' => $cart['id'],
				//'category_id' => $cart['category_id'],
				'data_qty' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$qty = (int)$this->transaksi_model->get_product($cart['id'])->product_qty;
			$hpp = (int)$this->transaksi_model->get_product($cart['id'])->hpp;
			$old_hpp = $qty*$hpp;
			$new_hpp = ($old_hpp+$cart['subtotal'])/($qty+$cart['qty']);

			$this->transaksi_model->insert_purchase_data($purchase_data);
			$this->produk_model->update_qty_add($cart['id'],array('product_qty' => $cart['qty']));
			$this->transaksi_model->update_hpp($cart['id'], array('hpp' => $new_hpp));
		}
		$this->cart->destroy();
	}
	public function delete($id_ptransaction){
		$transaksi = $this->transaksi_model->get_detail($id_ptransaction);
		foreach($transaksi as $trans){
			$qty = (int)$this->transaksi_model->get_purchase_data($id_ptransaction, $trans->id_product)->data_qty;
			$hpp = (int)$this->transaksi_model->get_purchase_data($id_ptransaction, $trans->id_product)->subtotal;
			$old_hpp = $trans->product_qty*$trans->hpp;
			$new_hpp = ($old_hpp-$hpp)/($trans->product_qty-$qty);

			$product = $this->produk_model->get_by_id($trans->id_product);
			$total = $product[0]['product_qty'] - $trans->data_qty;
			$this->produk_model->update_qty($product[0]['id_product'], array('product_qty' => $total));
			$this->transaksi_model->update_hpp($product[0]['id_product'], array('hpp' => $new_hpp));
		}
		$this->transaksi_model->delete_temp($id_ptransaction);
		$this->transaksi_model->delete_purchase_data_trx_temp($id_ptransaction);
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('transaksi'));
	}
	public function export_csv(){
		$filter = '';
		if(isset($_GET['search'])) {

			if (!empty($_GET['date_from']) && $_GET['date_from'] != '') {
				$filter['DATE(purchase_transaction.created_at) >='] = $_GET['date_from'];
			}

			if (!empty($_GET['date_end']) && $_GET['date_end'] != '') {
				$filter['DATE(purchase_transaction.created_at) <='] = $_GET['date_end'];
			}
		}
		$result = $this->transaksi_model->get_filter_csv($filter);
		for ($i=0; $i < count($result); $i++) { 
            if ($result[$i]['Metode Pembayaran'] == 0) {
                $result[$i]['Metode Pembayaran'] = 'Utang';
            } else {
                $result[$i]['Metode Pembayaran'] = 'Tunai';
            }
        }
		$this->csv_library->export('pembelian_'.date("d-m-Y").'.csv',$result);
	}

	private function _set_csv_format($datas){
		$result = false;
		if(is_array($datas)){
			$data_before = "";
			foreach($datas as $k => $data){
				$datas[$k]['created_at'] = date("Y-m-d H:i:s",strtotime($data['created_at']));
				if($data['id_ptransaction'] == $data_before) {
					$datas[$k]['id_ptransaction'] = "";
					$datas[$k]['total_price'] = "";
					$datas[$k]['total_item'] = "";

					$datas[$k]['created_at'] = "";
					$datas[$k]['id_supplier'] = "";
					$datas[$k]['supplier_name'] = "";
					$datas[$k]['supplier_phone'] = "";
					$datas[$k]['supplier_address'] = "";
					$datas[$k]['category_name'] = "";
				}
				$data_before = $data['id_ptransaction'];
			}
			$result = $datas;
		}
		return $result;
	}
}
