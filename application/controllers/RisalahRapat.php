<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RisalahRapat extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_risalah_rapat');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

    public function index()
	{
		$this->load->library('pagination');

        $jabatan_user = $this->session->userdata('jabatan');
        $data['jb_user'] = explode(" ",$jabatan_user);

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

        if($this->input->post('area')) {
			$data['area'] = $this->input->post('area');
		}
		else {
			$data['area'] = null;
		}

		$jumlah_data = $this->m_risalah_rapat->jumlah_data($data['cari'],$data['date_awal'],$data['date_akhir'],$data['area']);

		$config['base_url'] = base_url('index.php/RisalahRapat/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_risalah_rapat'] = $this->m_risalah_rapat->data_risalah_rapat($config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir'],$data['area']);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/risalah_rapat_view',$data);
        $this->load->view('footer');
	}

    public function add()
	{
        $id_risalah_rapat = $this->uri->segment(3);
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        if(!empty($id_risalah_rapat)) {
            $data['detail_data_risalah_rapat'] = $this->m_risalah_rapat->get_id($id_risalah_rapat);
            $data['aksi'] = 'edit';
        }
        else{
            $data['aksi'] = 'add';
        }
        
        $this->load->view('header', $data);
        $this->load->view('admin/form_risalah_rapat_view',$data);
        $this->load->view('footer');
    }

	public function addProses(){
		$news = $this->m_risalah_rapat;
        $id = $this->input->post('id_risalah_rapat');
        $aksi = $this->input->post('aksi');
		$data = array(
            'id_risalah_rapat' => $this->input->post('id_risalah_rapat'),
			'tanggal_posting' => $this->input->post('tanggal_posting'),
            'judul_risalah_rapat' => $this->input->post('judul_risalah_rapat'),
			'area' => $this->input->post('area'),
            'upd' => $this->input->post('upd'),
		);

		$config['upload_path']          = FCPATH.'/uploads/file/risalah_rapat/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|jpeg|png';
		$config['file_name']            = $_FILES['file_risalah_rapat']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_risalah_rapat')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
            $data['file_risalah_rapat'] = '';
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_risalah_rapat'] = $uploaded_data['file_name'];
        }

        $validation = $this->form_validation;
		$validation->set_rules($news->rules());
        if($aksi == 'add') {
            if ($validation->run()) {
                $this->m_risalah_rapat->insert($data);
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } 
        else if($aksi == 'edit' AND $id != '') {
            if ($validation->run()) {
                $this->m_risalah_rapat->update($id,$data);
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal diubah');
            }
        }

        redirect(site_url('RisalahRapat/index'));
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_risalah_rapat->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('RisalahRapat/index'));
	}
}