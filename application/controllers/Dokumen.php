<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_dokumen');
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

		$jumlah_data = $this->m_dokumen->jumlah_data($data['cari'],$data['date_awal'],$data['date_akhir']);

		$config['base_url'] = base_url('index.php/Dokumen/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_dokumen'] = $this->m_dokumen->data_dokumen($config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir']);
        $data['nama_dokumen_kategori'] = $this->m_dokumen->nama_dokumen_kategori();
		$data['nama_dokumen_item'] = $this->m_dokumen->nama_dokumen_item();

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/dokumen_view',$data);
        $this->load->view('footer');
	}

	public function add(){
		$dokumen = $this->m_dokumen;
		$data = array(
            'id_item' => (($this->input->post('id_item') != NULL) ? $this->input->post('id_item') : $this->input->post('id_unit')),
			'judul_dokumen' => $this->input->post('judul_dokumen'),
            'deskripsi' => $this->input->post('deskripsi'),
			'kode_dokumen' => $this->input->post('kode_dokumen'),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku'),
			'tanggal_verifikasi' => $this->input->post('tanggal_verifikasi'),
		);

		$config['upload_path']          = FCPATH.'/uploads/dokumen/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|png|ppt|pptx';
		$config['file_name']            = $_FILES['file_dokumen']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_dokumen')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_dokumen'] = $uploaded_data['file_name'];
        }

        $validation = $this->form_validation;
		$validation->set_rules($dokumen->rules());

        if ($validation->run()) {
			// print_r($data);
			$this->m_dokumen->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal disimpan');
		}

        redirect(site_url('Dokumen'));
	}

	public function edit(){
		$dokumen = $this->m_dokumen;
		$id = $this->input->post('id');
		$data = array(
            'id_item' => $this->input->post('id_item'),
			'judul_dokumen' => $this->input->post('judul_dokumen'),
            'deskripsi' => $this->input->post('deskripsi'),
			'kode_dokumen' => $this->input->post('kode_dokumen'),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku'),
			'tanggal_verifikasi' => $this->input->post('tanggal_verifikasi'),
		);
        
        $config['upload_path']          = FCPATH.'/uploads/dokumen/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|png|ppt|pptx';
		$config['file_name']            = $_FILES['file_dokumen']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_dokumen')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_dokumen'] = $uploaded_data['file_name'];
        }
		
        $validation = $this->form_validation;
		$validation->set_rules($dokumen->rules());

        if ($validation->run()) {
			$this->m_dokumen->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('Dokumen'));
	}

	public function get_by_id($id) {
		$data = $this->m_dokumen->get_id($id);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_dokumen->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('Dokumen'));
	}
}