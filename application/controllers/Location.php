<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');

		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}
	public function index(){

		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view('location');
		$this->load->view('template/footer');
	}


	public function load_data(){
		$query = $this->db->query(" SELECT a.* FROM dt_location a")->result();
		
		$data = array();
		foreach ($query as $hasil) {
			$row = array();
			$row [] = $hasil->id;
			$row [] = $hasil->name;
			$row [] = $hasil->latLong;
			$row [] = 
			'<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="edit" onclick="getData('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>';
			$data[] = $row;
		}
		echo json_encode(array("data"=>$data));

	}

	function add_data(){
		$data = array(
			'name' => $this->input->post('name'), 
			'latLong' => $this->input->post('latLong')
		);
		$this->db->insert('dt_location',$data);

		if($this->db->affected_rows()){
    		echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array("status" => false));
    	}
	}

	public function getData($id = '') {
		$data = '';
		if($this->input->is_ajax_request()) {
			if($id) {
				$this->db->select('a.*');
				$this->db->from('dt_location a');
				$this->db->where('a.id', $id);
				$data = $this->db->get()->row_array();
			}
		}

		echo json_encode($data);
	}
	public function updateData() {

		$data = array(
			'name' => $this->input->post('name'), 
			'latLong' => $this->input->post('latLong')
		);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('dt_location',$data);

		if($this->db->affected_rows()){
            echo json_encode(array("status"=>TRUE));
		}else{
            echo json_encode(array("status"=>TRUE));
		}
	}
	public function delete($id){
		$query = $this->db->query("DELETE from dt_location where id='$id'");
		echo json_encode(array('status' => true));
	}
}
