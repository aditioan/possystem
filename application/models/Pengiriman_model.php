<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("pengiriman");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("pengiriman");
		return $query->num_rows();
	}
	public function get_all_array($filter = false){
		$this->db->select('pengiriman.id_stransaction AS "Kode Transaksi Penjualan", pengiriman.service AS "Pengiriman Via", pengiriman.no_resi AS "Nomor Resi", pengiriman.ongkir AS "Ongkos Kirim", pengiriman.ongkir_terpakai AS "Ongkir Terpakai", pengiriman.created_at AS "Tanggal Pengiriman"');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if($filter){
			$query = $this->db->get_where("pengiriman",$filter);
		}else{
			$query = $this->db->get("pengiriman");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("pengiriman",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('pengiriman', $data);
	}
	public function update($id,$data){
		$this->db->where('id_pengiriman', $id);
		$this->db->update('pengiriman', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('pengiriman',array('id_pengiriman' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function get_by_id_transaction($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('pengiriman',array('id_stransaction' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_pengiriman', $id);
		$this->db->update('pengiriman', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('pengiriman', array('id_pengiriman' => $id));
	}
	public function get_filter($filter = ''){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("pengiriman",$filter);
		}else{
			$query = $this->db->get("pengiriman");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("pengiriman",$filter);
		}else{
			$query = $this->db->get("pengiriman");
		}
		return $query->num_rows();
	}
}