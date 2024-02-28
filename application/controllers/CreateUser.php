<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateUser extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_create_user');
		$this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

    public function index()
	{

        $create_user = $this->m_create_user;
        $data['username_max'] = $create_user->showUsernameMax();
        $data['data_jabatan'] = $create_user->dataJabatan();
        $data['data_tl'] = $create_user->showTL();
        $data['data_spv'] = $create_user->showSPV();
        $data['data_manager'] = $create_user->showManager();
        // print_r($create_user->showSPV());
		
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/create_user_view',$data);
        $this->load->view('footer');
	}

	public function addProses(){
		$create_user = $this->m_create_user;

        $data1 = array(
            'user1' => $this->input->post('user1'),
			'user2' => $this->input->post('user2'),
            'user3' => $this->input->post('user3'),
			'user5' => $this->input->post('user5'),
            'user6' => $this->input->post('user6'),
		);
        $tl = $this->input->post('tl');
        $spv = $this->input->post('spv');
        $manager = $this->input->post('manager');

        $validation = $this->form_validation;
		$validation->set_rules($create_user->rules());
        if ($validation->run()) {
            
                    if((strpos($this->input->post('user3'),'AGENT')) !== FALSE) { 
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Agent Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        // print_r((strpos($this->input->post('user3'),'DUKTEK')) == '');
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'TL')) !== FALSE) {
                        if($spv !== '' && $manager !== '') {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User TL Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'SUPERVISOR')) !== FALSE) {
                        if($manager !== '') {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Supervisor Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'MANAGER')) ) {
                        if($this->m_create_user->insert($data1, $tl, $spv, $manager)) {
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'INPUTER')) !== FALSE) {
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'SOO')) !== FALSE) {
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'SUPPORT HC')) !== FALSE) {
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                    }
                    else if((strpos($this->input->post('user3'),'RANGER')) !== FALSE) {
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'SUPPORT CAPS')) !== FALSE) {
                        if($tl !== '' && $spv !== '' && $manager !== '' ) {
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else if((strpos($this->input->post('user3'),'SUPPORT SALES')) !== FALSE) { 
                        if($tl !== '' && $spv !== '' && $manager !== '' ){
                            $this->m_create_user->insert($data1, $tl, $spv, $manager);
                            $this->session->set_flashdata('success', 'Data User Manager Layanan 147 Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data Gagal disimpan, wajib diisi TL, SPV dan Manager');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
                    else {
                        // print_r((strpos($this->input->post('user3'),'DUKTEK')));
                        if($this->m_create_user->insert($data1)) {
                            $this->session->set_flashdata('success', 'Data User Back Office Berhasil disimpan');
                        }
                        else {
                            $this->session->set_flashdata('gagal', 'Data User Layanan 147 Gagal disimpan');
                        }
                        redirect(site_url('CreateUser/index'));
                    }
        }
        else {
            $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            redirect(site_url('CreateUser/index'));
        }

        // redirect(site_url('CreateUser/index'));
	}
}