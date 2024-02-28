<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VisiMisi extends CI_Controller {

	function __construct(){
		parent::__construct();		
		// $this->load->model('m_ccm147');
		$this->load->library('form_validation');
        $this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
	}

    public function index()
	{
        $jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
        
        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/visi_misi_view',$data);
        $this->load->view('footer');
	}
}