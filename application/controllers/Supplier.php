<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('supplier_model');
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
				$filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
			}

			$data['suppliers'] = $this->supplier_model->get_filter($filter);
		}else{
			$data['suppliers'] = $this->supplier_model->get_all();
		}

		$this->load->view('supplier/index',$data);
	}
	
	public function create(){
		$code_supplier = $this->supplier_model->get_last_id();
		if($code_supplier){
			$id = $code_supplier[0]->id_supplier;
			$data['code_supplier'] = generate_code('SUP',$id,8);
		}else{
			$data['code_supplier'] = 'SUP00000001';
		}
		
		$this->load->view('supplier/form',$data);
	}

	public function edit($id = ''){
		$check_id = $this->supplier_model->get_by_id($id);
		if($check_id){
			$data['supplier'] = $check_id[0];
			$this->load->view('supplier/form',$data);
		}else{
			redirect(site_url('supplier'));
		}
	}

    public function statistik($id){
        $check_id = $this->supplier_model->get_by_id($id);
        if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
	        if($check_id){
	            $data['id_supplier'] = $id;
	            $data['transaksis'] = $this->supplier_model->get_pembelian($id, $filter)->result();
	            $data['data_retur'] = $this->supplier_model->get_retur_pembelian($id, $filter)->result();
	            $data['pembelian'] = (int)$this->supplier_model->get_total_pembelian($id, $filter);
	            $data['retur'] = (int)$this->supplier_model->get_total_retur_pembelian($id, $filter);
	            $data['utang'] = (int)$this->supplier_model->get_total_utang($id, $filter);
	            $this->load->view('supplier/statistik',$data);
	        }else{
	            redirect(site_url('supplier'));
	        }
        }else{
	        if($check_id){
	            $data['id_supplier'] = $id;
	            $data['transaksis'] = $this->supplier_model->get_pembelian($id)->result();
	            $data['data_retur'] = $this->supplier_model->get_retur_pembelian($id)->result();
	            $data['pembelian'] = (int)$this->supplier_model->get_total_pembelian($id);
	            $data['retur'] = (int)$this->supplier_model->get_total_retur_pembelian($id);
	            $data['utang'] = (int)$this->supplier_model->get_total_utang($id);
	            $this->load->view('supplier/statistik',$data);
	        }else{
	            redirect(site_url('supplier'));
	        }
        }
    }

	public function save($id = ''){
		$this->form_validation->set_rules('id_supplier', 'ID', 'required');
		$this->form_validation->set_rules('supplier_name', 'Nama', 'required');

		$data['id_supplier'] = escape($this->input->post('id_supplier'));
		$data['supplier_name'] = escape($this->input->post('supplier_name'));
		$data['company_name'] = escape($this->input->post('company_name'));
		$data['supplier_email'] = escape($this->input->post('supplier_email'));
		$data['supplier_phone'] = escape($this->input->post('supplier_phone'));
		$data['supplier_wa'] = escape($this->input->post('supplier_wa'));
		$data['supplier_line'] = escape($this->input->post('supplier_line'));
		$data['supplier_address'] = escape($this->input->post('supplier_address'));

		if ($this->form_validation->run() != FALSE && !empty($id)) {
			// EDIT
			$check_id = $this->supplier_model->get_by_id($id);
			if($check_id){
				unset($data['id_supplier']);
				$this->supplier_model->update($id,$data);
            	$this->session->set_flashdata('message_success', 'Data berhasil diubah!');
			}
		}elseif($this->form_validation->run() != FALSE && empty($id)){
			// INSERT NEW
			$this->supplier_model->insert($data);
            $this->session->set_flashdata('message_success', 'Data berhasil dimasukkan!');
		}else{
			$this->session->set_flashdata('form_false', 'Harap periksa form anda.');
			redirect(site_url('supplier/create'));
		}
		redirect(site_url('supplier'));
	}
	public function delete($id){
		$check_id = $this->supplier_model->get_by_id($id);
		if($check_id){
			$this->supplier_model->delete_temp($id);
		}
		$this->session->set_flashdata('message_success', 'Data berhasil dihapus!');
		redirect(site_url('supplier'));
	}
	public function export_csv(){
		$filter = false;
		if(isset($_GET['search'])) {
			$filter = array();
			if (!empty($_GET['value']) && $_GET['value'] != '') {
				$filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
			}
		}
		$data = $this->supplier_model->get_all_array($filter);
		$this->csv_library->export('supplier_'.date("d-m-Y").'.csv',$data);
	}

    public function export_pembelian($id)
    {
    	if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
	        $data = $this->supplier_model->export_pembelian($id, $filter)->result_array();
	        $this->csv_library->export('pembelian_supplier_'.$data[0]['Nama Supplier'].'_'.date("d-m-Y").'.csv',$data);
        }else{
	        $data = $this->supplier_model->export_pembelian($id)->result_array();
	        $this->csv_library->export('pembelian_supplier_'.$data[0]['Nama Supplier'].'_'.date("d-m-Y").'.csv',$data);
        }
    }

    public function export_retur($id)
    {
    	if(isset($_GET['search'])){
            $filter = '';
            if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) >='] = $_GET['date_from'];
            }
            if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
                $filter['DATE('.$_GET['data'].'.created_at) <='] = $_GET['date_end'];
            }
	        $data = $this->supplier_model->export_retur_pembelian($id, $filter)->result_array();
	        $this->csv_library->export('retur_pembelian_supplier_'.$data[0]['Nama Supplier'].'_'.date("d-m-Y").'.csv',$data);
        }else{
	        $data = $this->supplier_model->export_retur_pembelian($id)->result_array();
	        $this->csv_library->export('retur_pembelian_supplier_'.$data[0]['Nama Supplier'].'_'.date("d-m-Y").'.csv',$data);
        }
    }
}
