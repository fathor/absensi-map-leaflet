<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
		$this->load->view('report');
		$this->load->view('template/footer');
	}

	function getEmp(){
		$q = $this->db->query('SELECT * FROM dt_emp ORDER BY id');
		$date = "<option value=''>All</option>";
		foreach ($q->result() as $key) {
			$date .= "<option value='".$key->id."'>".$key->name."</option>";
		}
		echo $date;
	}

	public function load_data(){
		$first_date = $this->input->post('filter_first_date');
		$last_date = $this->input->post('filter_last_date');
		$filter_emp = $this->input->post('filter_emp');

		$where ='';
		if ($filter_emp) {
			$where .= 'AND a.id_emp = "'.$filter_emp.'"';
		}
		$query = $this->db->query(" 
			SELECT a.*,b.`name`,nip,c.`name` nama_location,CONCAT(date_absen,' ',time_in) masuk,CONCAT(date_absen,' ',time_out) keluar
			FROM dt_absen a
			JOIN dt_emp b ON a.id_emp = b.id
			JOIN dt_location c ON b.location = c.id
			WHERE date_absen BETWEEN '$first_date' AND '$last_date' $where
			ORDER BY a.date_absen ASC")->result();
		
		$data = array();
		$no=1;
		foreach ($query as $hasil) {
			$in = strtotime(date($hasil->date_absen.'07:30'));
			$time_in = strtotime(date($hasil->masuk));
			$jam_in   = floor(($in - $time_in) / (60 * 60));

			$out = strtotime(date($hasil->date_absen.'16:30'));
			$time_out = strtotime(date($hasil->keluar));
			$jam_out   = floor(($out - $time_out) / (60 * 60));

			$row = array();
			$row [] = $no++;
			$row [] = ucwords($hasil->name);
			$row [] = $hasil->nip;
			$row [] = ucwords($hasil->nama_location);
			$row [] = strtoupper($hasil->kategori);
			$row [] = $this->getHari(date("N", strtotime($hasil->date_absen))).', '.date("Y-m-d", strtotime($hasil->date_absen));

			$row [] = $hasil->time_in;
			$row [] = number_format($hasil->jarak_in).' Km';
			$row [] = ($jam_in < 0) ? "<span class='label label-danger'>Telat</span>" : "<span class='label label-primary'>On Time</span>";

			$row [] = ($hasil->time_out) ? $hasil->time_out : "<span class='label label-warning'>Belum Absen</span>";
			$row [] = ($hasil->jarak_out) ? number_format($hasil->jarak_out).' Km' : "<span class='label label-warning'>Belum Absen</span>";
			if ($hasil->time_out) {
				$row [] = ($jam_out < 0) ?"<span class='label label-primary'>On Time</span>": "<span class='label label-danger'>Pulang Lebih Cepat</span>";
			}else{
				$row [] ="<span class='label label-warning'>Belum Absen</span>";
			}

			$row [] = 
			'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detil" onclick="detil('."'".$hasil->id."'".')"><i class="glyphicon glyphicon-search"></i></a>';


			$data[] = $row;
		}
		echo json_encode(array("data"=>$data));

	}

	public function getData($id = '') {
		$data ='';
		if($id) {
			$this->db->select('a.*');
			$this->db->from('dt_absen a');
			$this->db->where('a.id', $id);
			$data = $this->db->get()->row();
		}
		echo json_encode($data);
		// $html ='';

		// $html .='
		//     <div class="row">
  //             <div class="col-md-12">
  //               <div class="panel">
  //                 <div class="col-md-4">
  //                   <div class="panel-body">
  //                     <div class="profile-main">
  //                       <img src="'.base_url().'upload/absensi/'.$data->img_in.'"+ new Date().getTime(); class="img" alt="Trulli" width="400" height="270" id="myImg">
  //                     </div>
  //                   </div>
  //                 </div>
  //                 <div class="col-md-8">
  //                   <div class="panel-body">
  //                     <h4 class="heading" style="color: blue;"><b>Masuk</b></h4>
  //                     <p></p><b>Informasi Kegiatan / Pekerjaan Hari Ini : </b>'.$data->note_in.'<br><hr>
  //                     <h4 class="heading" style="color: red;"><b>Keluar</b></h4>
  //                     <p ><b>Informasi Kegiatan / Pekerjaan Hari Ini : </b>'.$data->note_out.'</p><hr>
  //                   </div>
  //                 </div>
  //               </div>
  //             </div>
  //           </div>';

		// echo $html;
	}

	function getHari($hari){
		switch ($hari){
			case 1: 
			return "Senin";
			break;
			case 2:
			return "Selasa";
			break;
			case 3:
			return "Rabu";
			break;
			case 4:
			return "Kamis";
			break;
			case 5:
			return "Jum'at";
			break;
			case 6:
			return "Sabtu";
			break;
			case 7:
			return "Minggu";
			break;
		}
	}
	
}
