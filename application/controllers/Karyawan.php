<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('karyawan_model');
        $this->load->model('other_transaction_model');
        $this->other_transaction = $this->other_transaction_model;
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
				if ($_GET['search_by'] == "karyawan_name") {
					$filter['nama_karyawan LIKE'] = "%".$_GET['value']."%";
				}else{
					$filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
				}
			}

			$data['karyawans'] = $this->karyawan_model->get_filter($filter);
		}else{
			$data['karyawans'] = $this->karyawan_model->get_all();
		}

		$this->load->view('karyawan/index',$data);
	}
	
	public function create(){
		$this->load->view('karyawan/form');
	}

    public function bayar($id){
        $data['id_otransaction'] = "OTH".strtotime(date("Y-m-d H:i:s"));
        $data['type'] = 'gaji';
        $data['action'] = '0';
        $data['cash_trx'] = $this->karyawan_model->get_by_id($id)[0]['gaji_karyawan']+$this->karyawan_model->get_by_id($id)[0]['bonus_karyawan'];
        $data['description'] = 'Pembayaran gaji beserta bonus karyawan '.$this->karyawan_model->get_by_id($id)[0]['nama_karyawan'].' tanggal '.date("Y-m-d H:i:s");
        $this->other_transaction->insert($data);
        $this->karyawan_model->update($id, array('bonus_karyawan' => 0));
        $this->session->set_flashdata('message_success', 'Gaji beserta bonus karyawan telah dibayarkan!');
        redirect(site_url('karyawan'));
    }

	public function edit($id = ''){
		$check_id = $this->karyawan_model->get_by_id($id);
		if($check_id){
			$data['karyawan'] = $check_id[0];
			$this->load->view('karyawan/form',$data);
		}else{
			redirect(site_url('karyawan'));
		}
	}

    public function statistik($id){
    	echo "Badala";
    	die();
        $check_id = $this->karyawan_model->get_by_id($id);
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
	        if($check_id){
	            $data['id_karyawan'] = $id;
	            $data['transaksis'] = $this->karyawan_model->get_pembelian($id, $filter)->result();
	            $data['data_retur'] = $this->karyawan_model->get_retur_pembelian($id, $filter)->result();
	            $data['pembelian'] = (int)$this->karyawan_model->get_total_pembelian($id, $filter);
	            $data['retur'] = (int)$this->karyawan_model->get_total_retur_pembelian($id, $filter);
	            $data['utang'] = (int)$this->karyawan_model->get_total_utang($id, $filter);
	            $this->load->view('karyawan/statistik',$data);
	        }else{
	            redirect(site_url('karyawan'));
	        }
        }else{
	        if($check_id){
	            $data['id_karyawan'] = $id;
	            $data['transaksis'] = $this->karyawan_model->get_pembelian($id)->result();
	            $data['data_retur'] = $this->karyawan_model->get_retur_pembelian($id)->result();
	            $data['pembelian'] = (int)$this->karyawan_model->get_total_pembelian($id);
	            $data['retur'] = (int)$this->karyawan_model->get_total_retur_pembelian($id);
	            $data['utang'] = (int)$this->karyawan_model->get_total_utang($id);
	            $this->load->view('karyawan/statistik',$data);
	        }else{
	            redirect(site_url('karyawan'));
	        }
        }
    }

	public function save($id = ''){
		$this->form_validation->set_rules('nama_karyawan', 'Nama', 'required');

		$data['id_karyawan'] = escape($this->input->post('id_karyawan'));
		$data['nama_karyawan'] = escape($this->input->post('nama_karyawan'));
		$data['alamat_karyawan'] = escape($this->input->post('alamat_karyawan'));
		$data['email_karyawan'] = escape($this->input->post('email_karyawan'));
		$data['phone_karyawan'] = escape($this->input->post('phone_karyawan'));
		$data['wa_karyawan'] = escape($this->input->post('wa_karyawan'));
		$data['line_karyawan'] = escape($this->input->post('line_karyawan'));
		$data['posisi_karyawan'] = escape($this->input->post('posisi_karyawan'));
		$data['gaji_karyawan'] = escape($this->input->post('gaji_karyawan'));

		if ($this->form_validation->run() != FALSE) {
			$check_id = $this->karyawan_model->get_by_id($id);
			if($check_id){
				unset($data['id_karyawan']);
				$this->karyawan_model->update($id,$data);
            	$this->session->set_flashdata('message_success', 'Data berhasil diubah!');
			}else{
				$this->karyawan_model->insert($data);
	            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
			}
		}else{
			$this->session->set_flashdata('form_false', 'Harap periksa form anda.');
			redirect(site_url('karyawan/create'));
		}
		redirect(site_url('karyawan'));
	}
	public function delete($id){
		$check_id = $this->karyawan_model->get_by_id($id);
		if($check_id){
			$this->karyawan_model->delete_temp($id);
		}
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('karyawan'));
	}
	public function export_csv(){
		$filter = false;
		if(isset($_GET['search'])) {
			$filter = array();
			if (!empty($_GET['value']) && $_GET['value'] != '') {
				$filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
			}
		}
		$data = $this->karyawan_model->get_all_array($filter);
		$this->csv_library->export('karyawan_'.date("d-m-Y").'.csv',$data);
	}
}
