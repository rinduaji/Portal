<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DokumenKategori extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_dokumen_kategori');
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

		$jumlah_data = $this->m_dokumen_kategori->jumlah_data($data['cari']);

		$config['base_url'] = base_url('index.php/DokumenKategori/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_dokumen_kategori'] = $this->m_dokumen_kategori->data_dokumen_kategori($config['per_page'],$data['start'],$data['cari']);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/dokumen_kategori_view',$data);
        $this->load->view('footer');
	}

	public function add(){
		$dokumen_kategori = $this->m_dokumen_kategori;
		$data = array(
			'nama_kategori' => $this->input->post('nama_kategori'),
			'tingkatan' => $this->input->post('tingkatan'),
			'status' => $this->input->post('status')
		);
		
        $validation = $this->form_validation;
		$validation->set_rules($dokumen_kategori->rules());

        if ($validation->run()) {
			$this->m_dokumen_kategori->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal disimpan');
		}
		redirect(site_url('DokumenKategori'));
	}

	public function edit(){
		$dokumen_kategori = $this->m_dokumen_kategori;
		$id = $this->input->post('id');
		$data = array(
			'nama_kategori' => $this->input->post('nama_kategori'),
			'tingkatan' => $this->input->post('tingkatan'),
			'status' => $this->input->post('status')
		);
		
        $validation = $this->form_validation;
		$validation->set_rules($dokumen_kategori->rules());

        if ($validation->run()) {
			$this->m_dokumen_kategori->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('DokumenKategori'));
	}

	public function get_by_id($id) {
		$where = array('id_kategori' => $id);
		$data = $this->m_dokumen_kategori->get_id($where);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_dokumen_kategori->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('DokumenKategori'));
	}
}