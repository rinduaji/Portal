<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DokumenItem extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_dokumen_item');
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
		$jumlah_data = $this->m_dokumen_item->jumlah_data($data['cari']);

		$config['base_url'] = base_url('index.php/DokumenItem/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

		$data['data_dokumen_item'] = $this->m_dokumen_item->data_dokumen_item($config['per_page'],$data['start'],$data['cari']);
        $data['nama_dokumen_kategori'] = $this->m_dokumen_item->nama_dokumen_kategori();

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/dokumen_item_view',$data);
        $this->load->view('footer');
	}

	public function add(){
		$dokumen_item = $this->m_dokumen_item;
		$data = array(
            'id_kategori' => $this->input->post('id_kategori'),
			'nama_item' => $this->input->post('nama_item'),
			'status' => $this->input->post('status')
		);
		
        $validation = $this->form_validation;
		$validation->set_rules($dokumen_item->rules());

        if ($validation->run()) {
			$this->m_dokumen_item->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal disimpan');
		}
		redirect(site_url('DokumenItem'));
	}

	public function edit(){
		$dokumen_item = $this->m_dokumen_item;
		$id = $this->input->post('id');
		$data = array(
            'id_kategori' => $this->input->post('id_kategori'),
			'nama_item' => $this->input->post('nama_item'),
			'status' => $this->input->post('status')
		);
		
        $validation = $this->form_validation;
		$validation->set_rules($dokumen_item->rules());

        if ($validation->run()) {
			$this->m_dokumen_item->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('DokumenItem'));
	}

	public function get_by_id($id) {
		$data = $this->m_dokumen_item->get_id($id);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_dokumen_item->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('DokumenItem'));
	}
}