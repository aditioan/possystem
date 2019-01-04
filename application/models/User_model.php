<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('user.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('permission !=', '0');
		$this->db->join('karyawan', 'karyawan.id_karyawan = user.id_karyawan');
		$query = $this->db->get("user");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("user");
		return $query->num_rows();
	}
	public function get_all_array($filter = false){
		$this->db->select('user.id_user AS "Kode User", user.full_name AS "Nama Lengkap", user.username AS "Username", user.email AS "Alamat Email", user.created_at AS "Tanggal Pembuatan"');
		$this->db->where('permission !=', '0');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)) {
			$query = $this->db->get_where("user", $filter);
		}else{
			$query = $this->db->get("user");
		}
		return $query->result_array();
	}
	public function get_all_menu(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("menu");
		return $query->result();
	}
	public function get_all_submenu(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("menu_child");
		return $query->result();
	}
	public function get_last_id(){
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("user",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('user', $data);
	}
	public function insert_menu($data){
		$this->db->insert('user_menu', $data);
	}
	public function insert_submenu($data){
		$this->db->insert('user_mchild', $data);
	}
	public function update($id,$data){
		$this->db->where('id_user', $id);
		$this->db->update('user', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('user',array('id_user' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_user', $id);
		$this->db->update('user', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('user', array('id_user' => $id));
	}
	public function delete_menu($id_umenu){
		$this->db->delete('user_menu', array('id_umenu' => $id_umenu));
	}
	public function delete_submenu($id_umchild){
		$this->db->delete('user_mchild', array('id_umchild' => $id_umchild));
	}
	public function get_filter($filter = ''){
		$this->db->where('permission !=', '0');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("user",$filter);
		}else{
			$query = $this->db->get("user");
		}
		return $query->result();
	}
	public function reset_password($id, $username){
		$this->db->where('id_user', $id);
		$this->db->update('user', array('password' => sha1($username)));
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("user",$filter);
		}else{
			$query = $this->db->get("user");
		}
		return $query->num_rows();
	}
}