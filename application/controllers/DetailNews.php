<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailNews extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_detail_news');
        $this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
        $id_news = $this->uri->segment(3);
        $data['ddn'] = $this->m_detail_news->detail_data_news($id_news);

        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));
        
        // if($this->input->post('kategori')) {
        //     $data['data_report_dokumen'] = $this->m_report_dokumen->data_report_dokumen($this->input->post('kategori'));
        //     $data['nama_kategori'] = $this->m_report_dokumen->judul_nama_dokumen_kategori($this->input->post('kategori'));
        // }
        // else {
        //     $data['nama_kategori'] =null;
        // }
        $this->load->view('header',$data);
		$this->load->view('admin/detail_news_view',$data);
        $this->load->view('footer');
    }
}