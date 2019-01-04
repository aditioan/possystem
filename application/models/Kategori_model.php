<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("category");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("category");
		return $query->num_rows();
	}
	public function get_all_array($filter = false){
		$this->db->select('category.id_category AS "Kode Kategori", category.category_name AS "Nama Kategori", category.category_desc AS "Deskripsi", category.created_at AS "Tanggal Pembuatan"');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if($filter){
			$query = $this->db->get_where("category",$filter);
		}else{
			$query = $this->db->get("category");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("category",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('category', $data);
	}
	public function update($id,$data){
		$this->db->where('id_category', $id);
		$this->db->update('category', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('category',array('id_category' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_category', $id);
		$this->db->update('category', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('category', array('id_category' => $id));
	}
	public function get_filter($filter = ''){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("category",$filter);
		}else{
			$query = $this->db->get("category");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("category",$filter);
		}else{
			$query = $this->db->get("category");
		}
		return $query->num_rows();
	}
}