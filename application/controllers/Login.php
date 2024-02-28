<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_login');
	}

	public function index()
	{
		$this->load->view('login/login_view');
	}

    public function cekLogin()
    {
		$username = $this->input->post('username');
		$pass = md5($this->input->post('password'));
		$tanggal = date("Y-m-d");

		$cek = $this->m_login->cek_login($username,$pass,$tanggal)->num_rows();
		$data_login = $this->m_login->data_login($username,$pass,$tanggal)->row();
		$cek_briefing = $this->m_login->cek_login_briefing($username,$pass,$tanggal)->num_rows();
		$data_login_briefing = $this->m_login->data_login_briefing($username,$pass,$tanggal)->row();
		// print_r($cek_briefing);
		// die();
		if($cek > 0){
			$data_session = array(
				'username' => $data_login->username,
				'user_id' => $data_login->user_id,
				'nama' => $data_login->name,
				'jabatan' => $data_login->user3,
				'area' =>	$data_login->user5,
				'status' => "login"
			);
			
			// print_r($data_session);
			$this->session->set_userdata($data_session);
			redirect(base_url('index.php/VisiMisi'));
		}

		if($cek_briefing > 0){
			$data_session = array(
				'username' => $data_login_briefing->username,
				'user_id' => $data_login_briefing->user_id,
				'nama' => $data_login_briefing->name,
				'jabatan' => $data_login_briefing->user3,
				'area' =>	$data_login_briefing->user5,
				'status' => "login"
			);
			
			// print_r($data_session);
			$this->session->set_userdata($data_session);
			redirect(base_url('index.php/VisiMisi'));
		}
		$this->session->set_flashdata('mesg', 'true');
		redirect(base_url('index.php/login'));
	}

    function logout(){
		$this->session->sess_destroy();
		redirect(site_url('login'));
	}

    public function cekDokumen()
    {
		$this->load->view('header');
        $this->load->view('admin/dokumen_view');
		$this->load->view('footer');
    }

    public function cekProfile()
    {
		$this->load->view('header');
        $this->load->view('admin/profile_view');
		$this->load->view('footer');
    }
}