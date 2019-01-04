<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('form_validation');
        $this->load->model('kasir_model');
        $this->load->model('penjualan_model');
        $this->load->model('pelanggan_model');
        $this->load->model('kategori_model');
        $this->load->model('produk_model');
        
        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }
    
    function index(){
        $this->load->view('kasir/index');
    }

    public function get_stock($id_barang){
        echo json_encode($this->produk_model->get_by_id2($id_barang));
    }

    public function add_process(){

        $data['id_stransaction'] = "OUT".strtotime(date("Y-m-d H:i:s"));
        $data['id_customer'] = escape($this->input->post('customer_id'));
        $data['id_dropshipper'] = NULL;
        $data['status'] = 0;
        $data['is_cash'] = escape($this->input->post('is_cash'));
        $data['total_price'] = escape($this->input->post('total_price'));
        $pay = escape($this->input->post('total_pay'));
        $data['total_item'] = escape($this->input->post('total_item'));
        $data['pay_deadline_date'] = date('Y-m-d');
        $carts = escape($this->input->post('kasir'));

        // echo "<pre>";
        // print_r($carts);
        // die();

        $this->penjualan_model->insert($data);
            
        $this->_insert_purchase_data($data['id_stransaction'],$carts);
        //$this->_print_struk($data, $carts, $pay);

        echo("<script>location.href = '".site_url('kasir')."';</script>");
    }

    private function _insert_purchase_data($id_stransaction,$carts){
        foreach($carts as $key => $cart){
            $purchase_data = array(
                'id_stransaction' => $id_stransaction,
                'id_product' => $cart['product_id'],
                //'category_id' => $cart['category_id'],
                'data_qty' => $cart['product_qty'],
                'price_item' => $cart['price_item'],
                'subtotal' => $cart['subtotal']
            );
            $this->penjualan_model->insert_purchase_data($purchase_data);

            $this->produk_model->update_qty_min($cart['product_id'],array('product_qty' => $cart['product_qty']));
        }
    }

    private function _print_struk($data, $carts, $pay){
        $refund = $pay-$data['total_price'];
        $printFile = fopen(FCPATH."python/print.txt", "w") or die("Unable to open file!");
        $txt =      "        Kantin Fakultas Ekonomi\n";
        $txt = $txt."     Universitas Negeri Yogyakarta\n\n";
        $txt = $txt."========================================\n";
        $txt = $txt."ID: ".$data['id_stransaction']."             Kasir: Dwi\n";
        $txt = $txt."----------------------------------------\n";
        $txt = $txt."Item           Jml  Harga   Total\n";
        $txt = $txt."----------------------------------------\n";
        foreach($carts as $key => $cart){
            $name = $cart['product_name'];
            $lim = (14-strlen($name));
            if(strlen($name) > 14){
                $name = substr($name, 0, 14);
            }else{
                for ($i=0; $i < $lim; $i++) { 
                    $name = $name." ";
                }
            }

            $qty = $cart['product_qty'];
            $lim = (4-strlen($qty));
            if(strlen($qty) > 4){
                $qty = substr($qty, 0, 4);
            }else{
                for ($i=0; $i < $lim; $i++) { 
                    $qty = $qty." ";
                }
            }

            $price = $cart['price_item'];
            $lim = (7-strlen($price));
            if(strlen($price) > 7){
                $price = substr($price, 0, 7);
            }else{
                for ($i=0; $i < $lim; $i++) { 
                    $price = $price." ";
                }
            }

            $subtotal = $cart['subtotal'];
            $lim = (7-strlen($subtotal));
            if(strlen($subtotal) > 7){
                $subtotal = substr($subtotal, 0, 7);
            }else{
                for ($i=0; $i < $lim; $i++) { 
                    $subtotal = " ".$subtotal;
                }
            }
        $txt = $txt.$name." ".$qty." ".$price." Rp ".$subtotal.",-\n";
        }
        $txt = $txt."-------------------------------------(+)\n";
        $total_item = $data['total_item'];
        $lim = (12-strlen($total_item));
        if(strlen($total_item) > 12){
            $total_item = substr($total_item, 0, 12);
        }else{
            for ($i=0; $i < $lim; $i++) { 
                $total_item = $total_item." ";
            }
        }
        $total_price = $data['total_price'];
        $lim = (7-strlen($total_price));
        if(strlen($total_price) > 7){
            $total_price = substr($total_price, 0, 7);
        }else{
            for ($i=0; $i < $lim; $i++) { 
                $total_price = " ".$total_price;
            }
        }
        $total_pay = $pay;
        $lim = (7-strlen($total_pay));
        if(strlen($total_pay) > 7){
            $total_pay = substr($total_pay, 0, 7);
        }else{
            for ($i=0; $i < $lim; $i++) { 
                $total_pay = " ".$total_pay;
            }
        }
        $lim = (7-strlen($refund));
        if(strlen($refund) > 7){
            $refund = substr($refund, 0, 7);
        }else{
            for ($i=0; $i < $lim; $i++) { 
                $refund = " ".$refund;
            }
        }
        $txt = $txt."Total Item     ".$total_item." Rp ".$total_price.",-\n";
        $txt = $txt."Tunai                       Rp ".$total_pay.",-\n";
        $txt = $txt."-------------------------------------(-)\n";
        $txt = $txt."Kembalian                   Rp ".$refund.",-\n";
        $txt = $txt."Tgl ".date("d-m-Y")."        Jam ".date("h:i:sa")." WIB\n";
        $txt = $txt."========================================\n";
        $txt = $txt."       Terimakasih Sudah Berbelanja\n\n\n\n\n\n";
        $txt = $txt."========================================\n";
        fwrite($printFile, $txt);
        fclose($printFile);

        $command = "python ".FCPATH."/python/print.py 2>&1";
        $pid = popen( $command,"r");
        while( !feof( $pid ) )
        {
         echo fread($pid, 256);
         flush();
         ob_flush();
         usleep(100000);
        }
        pclose($pid);
    }
}
