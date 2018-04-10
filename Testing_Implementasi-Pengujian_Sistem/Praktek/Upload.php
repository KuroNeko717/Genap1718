<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
	
	var $data=array();
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url','captcha'));
		$this->load->library('form_validation');
		$this->load->model('Upload_m');
	}
	
	public function index()
	{
		$this->load->view('index');
	}

	public function kp()
	{
		$this->data['kp']=$this->Upload_m->getKp();
		$this->data['captcha']=$this->captcha();
		$this->load->view('up_kp',$this->data);
	}
	
	public function ta()
	{
		$this->data['ta']=$this->Upload_m->getTa();
		$this->data['captcha']=$this->captcha();
		$this->load->view('up_ta',$this->data);
	}
	
	public function prop()
	{
		$this->data['prop']=$this->Upload_m->getProp();
		$this->data['captcha']=$this->captcha();
		$this->load->view('up_prop',$this->data);
	}
	
	public function captcha()
	{
		$url=base_url()."captcha/";
		$vals = array(
				'img_path'      => './captcha/',
				'img_url'       => $url,
				'font_path'     => './path/to/fonts/texb.ttf',
		        'img_width'     => '150',
		        'img_height'    => '30',
		        'expiration'    => '7200',
		        'word_length'   => '4',
		        'font_size'     => '16',
		        'img_id'        => 'Imageid',
		        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		
		        // White background and border, black text and red grid
		        'colors'        => array(
				                'background' => array(255, 255, 255),
				                'border' => array(0, 0, 0),
				                'text' => array(0, 0, 0),
				                'grid' => array(255, 255, 255)
		        )
		);
		$cap = create_captcha($vals);
		$this->Upload_m->capt($cap);
		return $cap;
	}
	
	function check_validationKp()
	{
		$this->form_validation->set_rules('nim_kp', 'Nim', 'trim|required|min_length[13]');
		$this->form_validation->set_rules('nama_kp', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('telp_kp', 'Nomor Handphone', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('judul_kp', 'Judul Kerja Praktek', 'trim|required');
		$this->form_validation->set_rules('semester_kp', 'Semester', 'trim|required');
		$this->form_validation->set_rules('userfile', 'File ZIP', 'callback_file_check');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_captcha_check');
		//---------------------------
		$this->form_validation->set_message('required', 'Data {field} harus diisi.');
		$this->form_validation->set_message('min_length', 'Data {field} minimal memiliki {param} karakter.');
		$this->form_validation->set_error_delimiters('<div class="label label-danger">', '</div><br/>');
		
		if($this->form_validation->run()==true){
			$this->do_uploadKp();
		}else{
			$this->kp();
		}
	}
	
	function check_validationTa()
	{
		$this->form_validation->set_rules('nim_ta', 'Nim', 'trim|required|min_length[13]');
		$this->form_validation->set_rules('nama_ta', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('telp_ta', 'Nomor Handphone', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('judul_ta', 'Judul Tugas Akhir', 'trim|required');
		$this->form_validation->set_rules('semester_ta', 'Semester', 'trim|required');
		$this->form_validation->set_rules('status_ta', 'Status mahasiswa', 'trim|required');
		$this->form_validation->set_rules('userfile', 'File ZIP', 'callback_file_check');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_captcha_check');
		//---------------------------
		$this->form_validation->set_message('required', 'Data {field} harus diisi.');
		$this->form_validation->set_message('min_length', 'Data {field} minimal memiliki {param} karakter.');
		$this->form_validation->set_error_delimiters('<div class="label label-danger">', '</div><br/>');
	
		if($this->form_validation->run()==true){
			$this->do_uploadTa();
		}else{
			$this->ta();
		}
	}
	
	function check_validationProp()
	{
		$this->form_validation->set_rules('nim_prop', 'Nim', 'trim|required|min_length[13]');
		$this->form_validation->set_rules('nama_prop', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('telp_prop', 'Nomor Handphone', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('judul_prop', 'Judul Tugas Akhir', 'trim|required');
		$this->form_validation->set_rules('semester_prop', 'Semester', 'trim|required');
		$this->form_validation->set_rules('userfile', 'File ZIP', 'callback_file_check');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_captcha_check');
		//---------------------------
		$this->form_validation->set_message('required', 'Data {field} harus diisi.');
		$this->form_validation->set_message('min_length', 'Data {field} minimal memiliki {param} karakter.');
		$this->form_validation->set_error_delimiters('<div class="label label-danger">', '</div><br/>');
	
		if($this->form_validation->run()==true){
			$this->do_uploadProp();
		}else{
			$this->prop();
		}
	}
	
	public function captcha_check($str)
	{
		// First, delete old captchas
		$expiration = time() - 7200; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)->delete('captcha');
		
		// Then see if a captcha exists:
		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		
		if ($row->count == 0){
			$this->form_validation->set_message('captcha_check', 'Captcha tidak sesuai');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function file_check()
	{
		$this->form_validation->set_message('file_check', 'Silahkan pilih file yang sesuai ketentuan.');
		if (empty($_FILES['userfile']['name']) or $_FILES['userfile']['type']<>'application/zip' or $_FILES['userfile']['size'] >= 3000000 or $_FILES['userfile']['error']==1 ) {
			return false;
		}else{
			return true;
		}
	}
	
	public function do_uploadKp()
	{
		$data['nim_kp']		= $this->input->post('nim_kp',true);
		$data['nama_kp']	= $this->input->post('nama_kp',true);
		$data['telp_kp']	= $this->input->post('telp_kp',true);
		$data['judul_kp']	= $this->input->post('judul_kp',true);
		$data['semester_kp']	= $this->input->post('semester_kp',true);
		
		$data['file_kp']	= $this->upload_file("kp");
		
		if($this->Upload_m->insertKp($data)){
			$this->index();
		}else{
			echo "ada kesalahan";
		}
	}
	
	public function do_uploadTa()
	{
		$data['nim_ta']		= $this->input->post('nim_ta',true);
		$data['nama_ta']	= $this->input->post('nama_ta',true);
		$data['telp_ta']	= $this->input->post('telp_ta',true);
		$data['judul_ta']	= $this->input->post('judul_ta',true);
		$data['semester_ta']	= $this->input->post('semester_ta',true);
		$data['status_ta']	= $this->input->post('status_ta',true);
	
		$data['file_ta']	= $this->upload_file("ta");
	
		if($this->Upload_m->insertTa($data)){
			$this->index();
		}else{
			echo "ada kesalahan";
		}
	}
	
	public function do_uploadProp()
	{
		$data['nim_prop']		= $this->input->post('nim_prop',true);
		$data['nama_prop']	= $this->input->post('nama_prop',true);
		$data['telp_prop']	= $this->input->post('telp_prop',true);
		$data['judul_prop']	= $this->input->post('judul_prop',true);
		$data['semester_prop']	= $this->input->post('semester_prop',true);
	
		$data['file_prop']	= $this->upload_file("prop");
	
		if($this->Upload_m->insertProp($data)){
			$this->index();
		}else{
			echo "ada kesalahan";
		}
	}
	
	public function upload_file($opsi)
	{	
		if($opsi=="kp"){
			$fname="kp_".$this->input->post('nim_kp').".zip";
		}elseif($opsi=="ta"){
			$fname="ta_".$this->input->post('nim_ta').".zip";
		}else{
			$fname="prop_".$this->input->post('nim_prop').".zip";
		}
		$config = array(
				'upload_path' 	=> "./uploads/",
				'allowed_types' => 'zip',
				'file_name'		=> $fname,
				'overwrite' 	=> TRUE,
				'max_size' 		=> "3000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
		);
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload())
		{
			return $this->upload->data('file_name');
		}
		else
		{
			return FALSE;
		}
	}
}
?>