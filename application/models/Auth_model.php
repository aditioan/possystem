<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function check_login($username,$password){
		$this->db->where('user.deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get_where("user",array("username" => $username, "password" => $password) );
		return $query->result();
	}
	public function get_menu($id){
		$this->db->select("*, user_menu.id_menu AS id_menu, user_menu.created_at AS created_at, user_menu.updated_at AS updated_at, user_menu.deleted_at AS deleted_at", FALSE);
		$this->db->where('user_menu.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('menu.deleted_at', '0000-00-00 00:00:00');
		//$this->db->where('menu_child.deleted_at', '0000-00-00 00:00:00');
		//$this->db->or_where('menu_child.deleted_at', NULL);
		$this->db->join("menu", "menu.id_menu = user_menu.id_menu");
		//$this->db->join("menu_child", "menu_child.id_menu = menu.id_menu");
		$query = $this->db->get_where("user_menu",array("user_menu.id_user" => $id) );
		return $query->result();
	}
	public function get_all_menu(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("menu");
		return $query->result();
	}
	public function get_menu_child($id){
		$this->db->select("*, user_mchild.id_mchild AS id_mchild, user_mchild.created_at AS created_at, user_mchild.updated_at AS updated_at, user_mchild.deleted_at AS deleted_at", FALSE);
		$this->db->where('user_mchild.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('menu_child.deleted_at', '0000-00-00 00:00:00');
		//$this->db->or_where('menu_child.deleted_at', NULL);
		$this->db->join("menu_child", "menu_child.id_mchild = user_mchild.id_mchild");
		$query = $this->db->get_where("user_mchild",array("user_mchild.id_user" => $id) );
		return $query->result();

	}
	public function get_all_menu_child(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("menu_child");
		return $query->result();
	}
	public function get_profile($user_id){
		$query = $this->db->get_where("user",array("id_user" => $user_id) );
		return $query->result();
	}
	public function set_session($id,$username){
		$newdata = array(
			'id_user'		=> $id,
			'username'  => $username,
			'logged_in' => TRUE
		);
		$this->session->set_userdata($newdata);
	}
	public function unset_session(){
		session_destroy();
	}
	public function set_cookie_remember($username){
		setcookie('remember_me',$username, time() + (86400 * 30), "/");
	}	
	public function unset_cookie_remember(){
		setcookie('remember_me','',0,'/');
	}
}