<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterPola extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_master_pola');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

    public function index()
	{
		$this->load->library('pagination');

		if($this->input->post('cari')) {
			$data['cari'] = $this->input->post('cari');
			// $this->session->set_userdata('cari',$data['cari']);
		}
		else {
			$data['cari'] = null;
			// $data['cari'] = $this->session->userdata('cari');
		}

		$jumlah_data = $this->m_master_pola->jumlah_data($data['cari']);

		$config['base_url'] = base_url('index.php/MasterPola/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_master_pola'] = $this->m_master_pola->data_master_pola($config['per_page'],$data['start'],$data['cari']);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/master_pola_view',$data);
        $this->load->view('footer');
	}


    public function add()
	{
        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
        // print_r($data['data_notif']);
        $id_master_pola = $this->uri->segment(3);
        if(!empty($id_master_pola)) {
            $data['detail_data_master_pola'] = $this->m_master_pola->get_id($id_master_pola);
            $data['aksi'] = 'edit';
        }
        else{
            $data['aksi'] = 'add';
        }
        
        $this->load->view('header', $data);
        $this->load->view('admin/form_master_pola_view',$data);
        $this->load->view('footer');
    }

	public function addProses(){
		$master_pola = $this->m_master_pola;
        $id = $this->input->post('id_master_pola');
        $aksi = $this->input->post('aksi');
		$data = array(
            'id' => $this->input->post('id_master_pola'),
			'pola' => $this->input->post('pola'),
            'masuk' => $this->input->post('masuk'),
			'pulang' => $this->input->post('pulang'),
            'ist1' => $this->input->post('ist1'),
            'ist2' => $this->input->post('ist2'),
			'ist3' => $this->input->post('ist3'),
            'ist4' => $this->input->post('ist4'),
			'jabatan' => $_SESSION['jabatan'],
            'upd' => $_SESSION['username'],
            'lup' => date("Y-m-d H:i:s"),
		);

        $validation = $this->form_validation;
		$validation->set_rules($master_pola->rules());
        if($aksi == 'add') {
            if ($validation->run()) {
                $this->m_master_pola->insert($data);
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } 
        else if($aksi == 'edit' AND $id != '') {
            if ($validation->run()) {
                $this->m_master_pola->update($id,$data);
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal diubah');
            }
        }

        redirect(site_url('MasterPola/index'));
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_master_pola->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('MasterPola/index'));
	}
}