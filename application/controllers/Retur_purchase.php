<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_purchase extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('retur_purchase_model');
		$this->load->model('transaksi_model');
		$this->retur_purchase = $this->retur_purchase_model;

		$this->load->model('retur_penjualan_model');
		$this->penjualan = $this->retur_penjualan_model;
		$this->load->model('pelanggan_model');
		$this->load->model('penjualan_model');
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
			if(!empty($_GET['id_pretur']) && $_GET['id_pretur'] != ''){
				$filter['purchase_retur.id_pretur LIKE'] = "%".$_GET['id_pretur']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(purchase_retur.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(purchase_retur.created_at) <='] = $_GET['date_end'];
			}

			$data['penjualans'] = $this->retur_purchase->get_filter($filter);
		}else{
			$data['penjualans'] = $this->retur_purchase->get_all();
		}
		$this->load->view('retur_purchase/index',$data);
	}
	
	function create(){
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id_ptransaction']) && $_GET['id_ptransaction'] != ''){
				$filter['purchase_transaction.id_ptransaction LIKE'] = "%".$_GET['id_ptransaction']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(purchase_transaction.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(purchase_transaction.created_at) <='] = $_GET['date_end'];
			}

			$total_row = $this->transaksi_model->count_total_filter($filter);
			$data['penjualans'] = $this->transaksi_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->transaksi_model->count_total();
			$data['penjualans'] = $this->transaksi_model->get_all(url_param());
		}
		$data['retur'] = true;
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('retur_purchase/retur_index',$data);
	}

	function create_retur($id){
		// destry cart
		$this->cart->destroy();

		$details = $this->transaksi_model->get_detail($id);
		if(!$details){
			redirect(site_url());
		}
		$cart_data = $this->_process_cart($details);
		//print_r($cart_data); exit;
		$data['carts'] = $cart_data;
		$data['id_ptransaction'] = $id;
		$data['id_supplier'] = $details[0]->id_supplier;
		$data['id_pretur'] = "RETP".strtotime(date("Y-m-d H:i:s"));
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$data['details'] = $details;
		$this->load->view('retur_purchase/form',$data);
	}
	
	public function detail($id){
		$details = $this->retur_purchase->get_detail_by_id($id);
		if($details){
			$data['details'] = $details;
			$this->load->view('retur_purchase/detail',$data);
		}else{
			redirect(site_url('retur_purchase'));
		}
	}

	public function update_cart($rowid = ''){
		$qty = $this->input->post("qty");
		$data = array(
			'rowid' => $rowid,
			'qty'   => $qty
		);
		$this->cart->update($data);

		echo json_encode(
			array(
				'data' => $this->cart->contents(),
				'total' => $this->cart->total()
			)
		);
	}

	private function _process_cart($transaksi = ''){
		if(!empty($transaksi) & is_array($transaksi)){
			foreach($transaksi as $key => $item){
				$data = array(
					'id'      => $item->id_product,
					'qty'     => $item->data_qty,
					'price'   => $item->price_item,
					//'id_ptransaction' => $item->id_ptransaction,
					'id_category' => $item->id_category,
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
	
	public function check_category_id($category_id){
		$products = $this->produk_model->get_by_category($category_id);
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
		$this->form_validation->set_rules('retur_id', 'id_pretur', 'required');
		$this->form_validation->set_rules('retur_code', 'id_ptransaction', 'required');

		$carts =  $this->cart->contents();
		// echo "<pre>";
		// print_r($carts);
		// die();
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id_pretur'] = escape($this->input->post('retur_id'));
			$data['id_ptransaction'] = escape($this->input->post('retur_code'));
			$data['return_by'] = escape($this->input->post('return_by'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();
			$data['is_return'] = "1";
			$data['created_at'] = date('Y-m-d H:i:s');

			$retur = $this->retur_purchase->insert($data);
			// if ($data['return_by'] == 0) {
			// 	foreach($carts as $key => $cart){
			// 		$product = $this->produk_model->get_by_id($cart['id']);
			// 		$total = $product[0]['product_qty'] - $cart['qty'];
			// 		$this->produk_model->update_qty($product[0]['id_product'] ,array('product_qty' => $total));
			// 	}
			// 	$this->session->set_flashdata('message_error', $total);
			// 	die();
			// }
			if($data['id_pretur']){
				$this->_insert_purchase_data($data['id_pretur'], $data['return_by'], $carts);
			}
			echo json_encode(array('status' => 'ok'));
			//$this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
			//redirect(site_url('retur_purchase'));
		}else{
			echo json_encode(array('status' => 'error', 'carts' => $carts));
			//$this->session->set_flashdata('message_error', 'Data gagal dimasukkan!');
			//redirect(site_url('retur_purchase/retur_index'));
		}
	}

	public function edit($retur_id){
		// destry cart
		$this->cart->destroy();

		$details = $this->retur_purchase->get_detail_by_id($retur_id);
		$details_sales = $this->retur_purchase->get_detail_by_sales_id($retur_id);
		if((!$details || $details[0]->is_return == 1) && (!$details_sales || $details_sales[0]->is_return == 1)){
			redirect(site_url('retur_purchase'));
		}
		if(!$details){
			$details = $details_sales;
		}
		$cart_data = $this->_process_cart($details);
		//print_r($this->db); exit;
		$data['edit'] = true;
		$data['carts'] = $cart_data;
		$data['code_penjualan'] = $details[0]->sales_retur_id;
		$data['code_retur_penjualan'] = $details[0]->id;
		$data['date'] = $details[0]->date;
		$data['details'] = $details;
		$this->load->view('retur_purchase/form',$data);
	}

	public function update($retur_id = 0){
		$details = $this->retur_purchase->get_detail_by_id($retur_id);
		$details_sales = $this->retur_purchase->get_detail_by_sales_id($retur_id);
		if((!$details || $details[0]->is_return == 1) && (!$details_sales || $details_sales[0]->is_return == 1)){
			redirect(site_url('retur_purchase'));
		}
		if(!$details){
			$details = $details_sales;
		}

		$carts =  $this->cart->contents();
		$is_return = escape($this->input->post("is_return"));
		$return_by = escape($this->input->post("return_by"));
		$check_qty = $this->_check_qty($carts);
		if(!empty($carts) && is_array($carts) && $check_qty){
			// Delete Row on sales_data table
			foreach($details as $detail){
				if($details_sales){
					$this->retur_purchase->delete_data_sales($detail->sales_retur_id);
				}else{
					$this->retur_purchase->delete_data($detail->id);
				}
			}

			$data['id'] = $retur_id;
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();
			$data['is_return'] = ($is_return != "undefined") ? (int)$is_return : "0";
			$data['return_by'] = ($return_by != "undefined") ? (int)$return_by : "0";

			$is_return_old = $details[0]->is_return;
			if($is_return == 1 && $is_return_old != 1 && strpos($details[0]->sales_retur_id, "RETS") !== false && $return_by == 1){
				// Update product and retur purchase
				foreach($carts as $cart){
					$this->produk_model->update_qty_add($cart['id'],array('product_qty' => $cart['qty']));
				}
			}
			$this->retur_purchase->update($retur_id,$data);
			
			if($data['id']){

				$this->_insert_purchase_data($data['id'],$carts);
			}

			echo json_encode(array('status' => 'ok','is_return' => $is_return));
		}else if(!$check_qty){
			echo json_encode(array('status' => 'limit'));
		}else{
			echo json_encode(array('status' => 'error','is_return' => $is_return));
		}
	}

	private function _check_qty($carts){
		$result = true;
		foreach($carts as $cart) {
			// Check Quantity Product
			$product = $this->produk_model->get_by_id($cart['id']);
			$qty = $product[0]['product_qty'];
			if($cart['qty'] > $qty){
				$result = false;
				break;
			}
		}
		return $result;
	}
	private function _insert_purchase_data($id_pretur,$return_by,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'id_pretur' => $id_pretur,
				'id_product' => $cart['id'],
				//'category_id' => $cart['category_id'],
				'data_qty' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			if ($return_by == 0) {
				$trans = $this->transaksi_model->get_product($cart['id']);
				$qty = $cart['qty'];
				$hpp = $cart['subtotal'];
				$old_hpp = $trans->product_qty*$trans->hpp;
				$new_hpp = ($old_hpp-$hpp)/($trans->product_qty-$qty);
				$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
				$this->transaksi_model->update_hpp($cart['id'], array('hpp' => $new_hpp));
			}
			$this->retur_purchase->insert_retur_data($purchase_data);

			//$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
		}
		$this->cart->destroy();
	}
	public function delete($id_pretur){
		//$details = $this->retur_purchase->get_detail_by_id($id_pretur);
		//$details_data = $this->retur_purchase->get_detail_by_data_id($id_pretur);
		$transaksi = $this->retur_purchase->get_detail_by_id($id_pretur);
		// echo "<pre>";
		// echo print_r($transaksi);
		// die();
		$this->db->reset_query();
		if ($transaksi[0]->return_by == 0) {
			foreach($transaksi as $trans){
				$product = $this->transaksi_model->get_product($trans->id_product);
				$old_hpp = $product->product_qty*$product->hpp;
				$new_hpp = ($old_hpp+$trans->subtotal)/($product->product_qty+$trans->data_qty);

				$this->produk_model->update_qty_plus($trans->id_product,array('product_qty' => $trans->data_qty));
				$this->transaksi_model->update_hpp($trans->id_product, array('hpp' => $new_hpp));
			}
		}

		$this->retur_purchase->delete_temp($id_pretur);
		$this->retur_purchase->delete_data_temp($id_pretur);

		// if((!$details || $details[0]->is_return == 1) && (!$details_sales || $details_sales[0]->is_return == 1)){
		// 	redirect(site_url('retur_purchase'));
		// }
		// if(!$details){
		// 	$details = $details_sales;
		// }

		// Delete Row on sales_data table
		// foreach($details as $detail){
		// 	$this->retur_purchase->delete_data_temp($detail->id_pretur);
		// }
		// $this->retur_purchase->delete($id_pretur);
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('retur_purchase'));
	}
	public function export_csv(){
		$filter = '';
		if(isset($_GET['search'])) {
			if(!empty($_GET['id_pretur']) && $_GET['id_pretur'] != ''){
				$filter['purchase_retur.id_pretur LIKE'] = "%".$_GET['id_pretur']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(purchase_retur.created_at) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(purchase_retur.created_at) <='] = $_GET['date_end'];
			}
		}
		// var_dump($filter);
		// die();
		$data = $this->retur_purchase->get_filter_csv($filter);
		for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['Bentuk Retur'] == 0) {
                $data[$i]['Bentuk Retur'] = 'Uang';
            } else {
                $data[$i]['Bentuk Retur'] = 'Barang';
            }
        }
		$this->csv_library->export('retur_pembelian_'.date("d-m-Y").'.csv',$data);
	}
}
