<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}
	public function index(){
		$kategori = '';
		$dt = $this->db->query("SELECT *FROM dt_absen WHERE date_absen='".date('Y-m-d')."' AND id_emp = '".$this->session->userdata('id_emp')."' ")->row();
		if (!$dt) {
			$type = 'in';
		}else{
			$kategori .= $dt->kategori;
			if ($dt->time_in != null && $dt->time_out != null) {
				$type = 'done';
			}else{
				$type = 'out';
			}
		}
		if ($type == 'done') {
			echo "Anda Telah Absen Hari Ini"; die();
		}
		$session['nip'] = $this->session->userdata('nip');
		$session['name'] = $this->session->userdata('name');
		$session['name_user'] = $this->session->userdata('name_user');
		$session['latLong'] = $this->session->userdata('latLong');
		$session['type'] = $type;
		$session['kategori'] = $kategori;

		$this->load->view('template/header');
		$this->load->view('absensi',$session);
		$this->load->view('template/footer');
	}

	function upload($type=''){
		$nip = $this->session->userdata('nip');
		$date = date('Y-m-d');
		$config['file_name'] 			= $nip.'-'.$date.'-'.$type;
		$config['upload_path']          = './upload/absensii';
		$config['allowed_types']        = 'jpg';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->upload->do_upload('webcam');

	}

	function simpan(){
		$nip = $this->session->userdata('nip');
		$type = $this->input->post('type');
		$date = date('Y-m-d');

		if ($type == 'in') {
			$data = array(
				'id_emp' => $this->session->userdata('id_emp'),
				'date_absen' => date('Y-m-d'),
				'kategori' => $this->input->post('kategori'),
				'time_in' => $this->input->post('time'),
				'time_out' => null,
				'img_in' => $nip.'-'.$date.'-'.$type.'.jpg',
				'img_out' => null,
				'note_in' => $this->input->post('note'),
				'note_out' => null,
				'jarak_in' => $this->input->post('jarak'),
				'jarak_out' =>null,
				'latLong_in' => $this->input->post('latLong'),
				'latLong_out' => null
			);
			$this->db->insert('dt_absen', $data);   
		}else{
			$dt = $this->db->query("SELECT *FROM dt_absen WHERE date_absen='".date('Y-m-d')."' AND id_emp = '".$this->session->userdata('id_emp')."' ")->row();
			$upd = array(
				"time_out" => $this->input->post('time'),
				"img_out" => null,
				"note_out" => $this->input->post('note'),
				"jarak_out" => $this->input->post('jarak'),
				"latLong_out" => $this->input->post('latLong')
			);
			$this->db->where('id',$dt->id);
			$this->db->update('dt_absen',$upd);
		}	

		if($this->db->affected_rows()){
			echo json_encode(array('status' => TRUE,'msg'=>'Absen Sukses !'));
		}else{
			echo json_encode(array("status" => FALSE,'msg'=>'Gagal Absen !'));
		}
	}
}
