<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

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
		$this->load->view('employee');
		$this->load->view('template/footer');
	}

	function getLocation(){
		$q = $this->db->query('SELECT * FROM dt_location ORDER BY id');
		$date = "<option value=''>All</option>";
		foreach ($q->result() as $key) {
			$date .= "<option value='".$key->id."'>".$key->name."</option>";
		}
		echo $date;
	}

	public function load_data(){
		$query = $this->db->query(" SELECT a.*, b.name name_location FROM dt_emp a JOIN dt_location b ON a.location = b.id")->result();
		
		$data = array();
		foreach ($query as $hasil) {
			$row = array();
			$row [] = $hasil->id;
			$row [] = $hasil->name;
			$row [] = $hasil->nip;
			$row [] = $hasil->address;
			$row [] = $hasil->number_tlp;
			$row [] = $hasil->email;
			$row [] = $hasil->name_location;
			if ($hasil->status == 'Aktif') {
				$row[] = "<span class='label label-info'>".$hasil->status."</span>";
			}else{
				$row[] = "<span class='label label-danger'>".$hasil->status."</span>";

			}
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
			'nip' => $this->input->post('nip'), 
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'number_tlp' => $this->input->post('number_tlp'),
			'location' => $this->input->post('location'),
			'status' =>'Aktif',
			'createBy' => null,
			'createTime' => date("Y-m-d G:i:s")
		);
		$this->db->insert('dt_emp',$data);

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
				$this->db->from('dt_emp a');
				$this->db->join('dt_location b', 'a.location = b.id');
				$this->db->where('a.id', $id);
				$data = $this->db->get()->row_array();
			}
		}

		echo json_encode($data);
	}
	public function updateData() {

		$data = array(
			'name' => $this->input->post('name'), 
			'nip' => $this->input->post('nip'), 
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'number_tlp' => $this->input->post('number_tlp'),
			'location' => $this->input->post('location')
		);

		$this->db->where('id', $this->input->post('id'));
		$this->db->update('dt_emp',$data);

		if($this->db->affected_rows()){
            echo json_encode(array("status"=>TRUE));
		}else{
            echo json_encode(array("status"=>TRUE));
		}
	}
	public function delete($id){
		$query = $this->db->query("DELETE from dt_emp where id='$id'");
		echo json_encode(array('status' => true));
	}
}
