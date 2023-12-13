<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		
	}
	public function index()
	{
		if($this->session->userdata('status') == "login"){
			redirect(base_url("home"));
		}else{
			$this->load->view('login');
			$this->load->view('template/footer');
		}
	}

	function cek_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => ($password)
		);
		$sql = $this->db->query('
			SELECT b.*,name_user,c.latLong
			FROM mst_user a
			JOIN dt_emp b ON a.id_emp = b.id
			JOIN dt_location c ON b.location = c.id
			WHERE username="'.$username.'" AND password ="'.$password.'" ')->row();
		if($sql){
			$data_session = array(
				'nip' => $sql->nip,
				'id_emp' => $sql->id,
				'name' => $sql->name,
				'name_user' => $sql->name_user,
				'latLong' => $sql->latLong,
				'status' => "login"
			);
			$this->session->set_userdata($data_session);
			$this->db->where('id', $sql->id)->set('loginTime', date("Y-m-d G:i:s"))->update('mst_user');
            echo json_encode(array("status" => TRUE));
		}else{
            echo json_encode(array("status" => FALSE,"msg"=> "Username / Password Salah !")); die();
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
