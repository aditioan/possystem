<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model('produk_model');
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function supplier(){
        $data['suppliers'] = $this->log_model->get_all('supplier');
        $this->load->view('log/supplier',$data);
    }

    public function pengiriman(){
        $data['pengirimans'] = $this->log_model->get_all('pengiriman');
        $this->load->view('log/pengiriman',$data);
    }

    public function karyawan(){
        $data['karyawans'] = $this->log_model->get_all('karyawan');
        $this->load->view('log/karyawan',$data);
    }

    public function user(){
        $data['users'] = $this->log_model->get_all('user');
        $this->load->view('log/user',$data);
    }

    public function kategori(){
        $data['kategoris'] = $this->log_model->get_all('category');
        $this->load->view('log/kategori',$data);
    }

    public function pelanggan(){
        $data['pelanggans'] = $this->log_model->get_all('customer');
        $this->load->view('log/pelanggan',$data);
    }

    public function produk(){
        $data['produks'] = $this->log_model->get_all('product');
        $this->load->view('log/produk',$data);
    }

    public function other(){
        $data['others'] = $this->log_model->get_all('other_transaction');
        $this->load->view('log/other',$data);
    }

    public function tunggakan(){
        $data['tunggakans'] = $this->log_model->get_all('sales_transaction', 'tunggakan');
        $this->load->view('log/tunggakan',$data);
    }

    public function tunggakan_detail($id_stransaction){
        $data['details'] = $this->log_model->get_detail('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->load->view('log/tunggakan_detail',$data);
    }

    public function penjualan(){
        $data['penjualans'] = $this->log_model->get_all('sales_transaction', 'penjualan');
        $this->load->view('log/penjualan',$data);
    }

    public function penjualan_detail($id_stransaction){
        $data['details'] = $this->log_model->get_detail('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->load->view('log/penjualan_detail',$data);
    }

    public function retur_penjualan(){
        $data['retur_penjualans'] = $this->log_model->get_all('sales_retur', 'retur_penjualan');
        $this->load->view('log/retur_penjualan',$data);
    }

    public function retur_penjualan_detail($id_sretur){
        $data['details'] = $this->log_model->get_detail('sales_retur', 'id_sretur', $id_sretur);
        $this->load->view('log/retur_penjualan_detail',$data);
    }

    public function utang(){
        $data['utangs'] = $this->log_model->get_all('purchase_transaction', 'utang');
        $this->load->view('log/utang',$data);
    }

    public function utang_detail($id_ptransaction){
        $data['details'] = $this->log_model->get_detail('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->load->view('log/utang_detail',$data);
    }

    public function pembelian(){
        $data['pembelians'] = $this->log_model->get_all('purchase_transaction', 'pembelian');
        $this->load->view('log/pembelian',$data);
    }

    public function pembelian_detail($id_ptransaction){
        $data['details'] = $this->log_model->get_detail('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->load->view('log/pembelian_detail',$data);
    }

    public function retur_pembelian(){
        $data['retur_pembelians'] = $this->log_model->get_all('purchase_retur', 'retur_pembelian');
        $this->load->view('log/retur_pembelian',$data);
    }

    public function retur_pembelian_detail($id_pretur){
        $data['details'] = $this->log_model->get_detail('purchase_retur', 'id_pretur', $id_pretur);
        $this->load->view('log/retur_pembelian_detail',$data);
    }

    public function supplier_return($id_supplier){
        $this->log_model->return_data('supplier', 'id_supplier', $id_supplier);
        $this->session->set_flashdata('message_success', 'Data supplier berhasil dipulihkan!');
        redirect(site_url('log/supplier'));
    }

    public function karyawan_return($id_karyawan){
        $this->log_model->return_data('karyawan', 'id_karyawan', $id_karyawan);
        $this->session->set_flashdata('message_success', 'Data karyawan berhasil dipulihkan!');
        redirect(site_url('log/karyawan'));
    }

    public function pengiriman_return($id_pengiriman){
        $this->log_model->return_data('pengiriman', 'id_pengiriman', $id_pengiriman);
        $this->session->set_flashdata('message_success', 'Data pengiriman berhasil dipulihkan!');
        redirect(site_url('log/pengiriman'));
    }

    public function supplier_delete($id_supplier){
        $this->log_model->delete_data('supplier', 'id_supplier', $id_supplier);
        $this->session->set_flashdata('message_success', 'Data supplier berhasil dihapus secara permanen!');
        redirect(site_url('log/supplier'));
    }

    public function karyawan_delete($id_karyawan){
        $this->log_model->delete_data('karyawan', 'id_karyawan', $id_karyawan);
        $this->session->set_flashdata('message_success', 'Data karyawan berhasil dihapus secara permanen!');
        redirect(site_url('log/karyawan'));
    }

    public function pengiriman_delete($id_pengiriman){
        $this->log_model->delete_data('pengiriman', 'id_pengiriman', $id_pengiriman);
        $this->session->set_flashdata('message_success', 'Data pengiriman berhasil dihapus secara permanen!');
        redirect(site_url('log/pengiriman'));
    }

    public function kategori_return($id_category){
        $this->log_model->return_data('category', 'id_category', $id_category);
        $this->session->set_flashdata('message_success', 'Data kategori berhasil dipulihkan!');
        redirect(site_url('log/kategori'));
    }

    public function kategori_delete($id_category){
        $this->log_model->delete_data('category', 'id_category', $id_category);
        $this->session->set_flashdata('message_success', 'Data kategori berhasil dihapus secara permanen!');
        redirect(site_url('log/kategori'));
    }

    public function pelanggan_return($id_customer){
        $this->log_model->return_data('customer', 'id_customer', $id_customer);
        $this->session->set_flashdata('message_success', 'Data pelanggan berhasil dipulihkan!');
        redirect(site_url('log/pelanggan'));
    }

    public function pelanggan_delete($id_customer){
        $this->log_model->delete_data('customer', 'id_customer', $id_customer);
        $this->session->set_flashdata('message_success', 'Data pelanggan berhasil dihapus secara permanen!');
        redirect(site_url('log/pelanggan'));
    }

    public function produk_return($id_product){
        $this->log_model->return_data('product', 'id_product', $id_product);
        $this->session->set_flashdata('message_success', 'Data produk berhasil dipulihkan!');
        redirect(site_url('log/produk'));
    }

    public function produk_delete($id_product){
        $this->log_model->delete_data('product', 'id_product', $id_product);
        $this->session->set_flashdata('message_success', 'Data produk berhasil dihapus secara permanen!');
        redirect(site_url('log/produk'));
    }

    public function other_return($id_otransaction){
        $this->log_model->return_data('other_transaction', 'id_otransaction', $id_otransaction);
        $this->session->set_flashdata('message_success', 'Data transaksi berhasil dipulihkan!');
        redirect(site_url('log/other'));
    }

    public function other_delete($id_otransaction){
        $this->log_model->delete_data('other_transaction', 'id_otransaction', $id_otransaction);
        $this->session->set_flashdata('message_success', 'Data transaksi berhasil dihapus secara permanen!');
        redirect(site_url('log/other'));
    }

    public function user_return($id_user){
        $this->log_model->return_data('user', 'id_user', $id_user);
        $this->session->set_flashdata('message_success', 'Data user berhasil dipulihkan!');
        redirect(site_url('log/user'));
    }

    public function user_delete($id_user){
        $this->log_model->delete_data('user', 'id_user', $id_user);
        $this->session->set_flashdata('message_success', 'Data user berhasil dihapus secara permanen!');
        redirect(site_url('log/user'));
    }

    public function tunggakan_return($id_stransaction){
        $transaksi = $this->log_model->get_detail('sales_transaction', 'id_stransaction', $id_stransaction);
        foreach($transaksi as $trans){
            $product = $this->produk_model->get_by_id($trans->id_product);
            $total = $product[0]['product_qty'] - $trans->data_qty;
            $this->produk_model->update_qty($product[0]['id_product'] ,array('product_qty' => $total));
        }
        $this->log_model->return_data('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->session->set_flashdata('message_success', 'Data tunggakan berhasil dipulihkan!');
        redirect(site_url('log/tunggakan'));
    }

    public function tunggakan_delete($id_stransaction){
        $this->log_model->delete_data('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->session->set_flashdata('message_success', 'Data tunggakan berhasil dihapus secara permanen!');
        redirect(site_url('log/tunggakan'));
    }

    public function penjualan_return($id_stransaction){
        $transaksi = $this->log_model->get_detail('sales_transaction', 'id_stransaction', $id_stransaction);
        foreach($transaksi as $trans){
            $product = $this->produk_model->get_by_id($trans->id_product);
            $total = $product[0]['product_qty'] - $trans->data_qty;
            $this->produk_model->update_qty($product[0]['id_product'] ,array('product_qty' => $total));
        }
        $this->log_model->return_data('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->session->set_flashdata('message_success', 'Data penjualan berhasil dipulihkan!');
        redirect(site_url('log/penjualan'));
    }

    public function penjualan_delete($id_stransaction){
        $this->log_model->delete_data('sales_transaction', 'id_stransaction', $id_stransaction);
        $this->session->set_flashdata('message_success', 'Data penjualan berhasil dihapus secara permanen!');
        redirect(site_url('log/penjualan'));
    }

    public function retur_penjualan_return($id_sretur, $return_by){
        if ($return_by == 0) {
            $transaksi = $this->log_model->get_detail('sales_retur', 'id_sretur', $id_sretur);
            foreach($transaksi as $trans){
                $product = $this->produk_model->get_by_id($trans->id_product);
                $total = $product[0]['product_qty'] + $trans->data_qty;
                $this->produk_model->update_qty($product[0]['id_product'], array('product_qty' => $total));
            }
        }
        $this->log_model->return_data('sales_retur', 'id_sretur', $id_sretur);
        $this->session->set_flashdata('message_success', 'Data retur penjualan berhasil dipulihkan!');
        redirect(site_url('log/retur_penjualan'));
    }

    public function retur_penjualan_delete($id_sretur){
        $this->log_model->delete_data('sales_retur', 'id_sretur', $id_sretur);
        $this->session->set_flashdata('message_success', 'Data retur penjualan berhasil dihapus secara permanen!');
        redirect(site_url('log/retur_penjualan'));
    }

    public function utang_return($id_ptransaction){
        $transaksi = $this->log_model->get_detail('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        foreach($transaksi as $trans){
            $product = $this->produk_model->get_by_id($trans->id_product);
            $total = $product[0]['product_qty'] + $trans->data_qty;
            $this->produk_model->update_qty($product[0]['id_product'], array('product_qty' => $total));
        }
        $this->log_model->return_data('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->session->set_flashdata('message_success', 'Data utang berhasil dipulihkan!');
        redirect(site_url('log/utang'));
    }

    public function utang_delete($id_ptransaction){
        $this->log_model->delete_data('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->session->set_flashdata('message_success', 'Data utang berhasil dihapus secara permanen!');
        redirect(site_url('log/utang'));
    }

    public function pembelian_return($id_ptransaction){
        $transaksi = $this->log_model->get_detail('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        foreach($transaksi as $trans){
            $old_hpp = (int)$trans->product_qty*(int)$trans->hpp;
            $total = (int)$trans->product_qty + (int)$trans->data_qty;
            $new_hpp = ($old_hpp+$trans->subtotal)/($total);
            $this->produk_model->update_qty($trans->id_product, array('product_qty' => $total));
            $this->log_model->update_hpp($trans->id_product, array('hpp' => $new_hpp));
        }
        $this->log_model->return_data('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->session->set_flashdata('message_success', 'Data pembelian berhasil dipulihkan!');
        redirect(site_url('log/pembelian'));
    }

    public function pembelian_delete($id_ptransaction){
        $this->log_model->delete_data('purchase_transaction', 'id_ptransaction', $id_ptransaction);
        $this->session->set_flashdata('message_success', 'Data pembelian berhasil dihapus secara permanen!');
        redirect(site_url('log/pembelian'));
    }

    public function retur_pembelian_return($id_pretur, $return_by){
        if ($return_by == 0) {
            $transaksi = $this->log_model->get_detail('purchase_retur', 'id_pretur', $id_pretur);
            foreach($transaksi as $trans){
                $old_hpp = (int)$trans->product_qty*(int)$trans->hpp;
                $total = (int)$trans->product_qty - (int)$trans->data_qty;
                $new_hpp = ($old_hpp-$trans->subtotal)/($total);
                $this->produk_model->update_qty($trans->id_product, array('product_qty' => $total));
                $this->log_model->update_hpp($trans->id_product, array('hpp' => $new_hpp));
            }
        }
        $this->log_model->return_data('purchase_retur', 'id_pretur', $id_pretur);
        $this->session->set_flashdata('message_success', 'Data retur pembelian berhasil dipulihkan!');
        redirect(site_url('log/retur_pembelian'));
    }

    public function retur_pembelian_delete($id_pretur){
        $this->log_model->delete_data('purchase_retur', 'id_pretur', $id_pretur);
        $this->session->set_flashdata('message_success', 'Data retur pembelian berhasil dihapus secara permanen!');
        redirect(site_url('log/retur_pembelian'));
    }

    public function export_csv($table){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }

            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE(deleted_at) >='] = $_GET['date_from'];
            }

            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE(deleted_at) <='] = $_GET['date_end'];
            }
        }
        $data = $this->log_model->get_all_array($table, $filter);
        $this->csv_library->export('log_'.$table.'.csv',$data);
    }
}
