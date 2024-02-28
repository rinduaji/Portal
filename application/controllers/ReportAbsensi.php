<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportAbsensi extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_report_absensi');
        $this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['login_user'] = $this->session->userdata('username');
		$data['jabatan_user'] = $this->session->userdata('jabatan');
        if($this->input->post('cari')) {
			$data['cari'] = $this->input->post('cari');
			// $this->session->set_userdata('cari',$data['cari']);
		}
		else {
			$data['cari'] = null;
			// $data['cari'] = $this->session->userdata('cari');
		}

		if($this->input->post('date_awal')) {
			$data['date_awal'] = $this->input->post('date_awal');
		}
		else {
			$data['date_awal'] = null;
		}

		if($this->input->post('date_akhir')) {
			$data['date_akhir'] = $this->input->post('date_akhir');
		}
		else {
			$data['date_akhir'] = null;
		}
        
        // if($this->input->post('kategori')) {
        $data['data_report_absensi'] = $this->m_report_absensi->data_report_absensi($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan_user'],$data['login_user']);
        // }

        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/report_absensi_view',$data);
        $this->load->view('footer');
    }
}