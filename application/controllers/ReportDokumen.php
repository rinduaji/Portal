<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportDokumen extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_report_dokumen');
        $this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
        $data['nama_dokumen_kategori'] = $this->m_report_dokumen->nama_dokumen_kategori();
        
        if($this->input->post('kategori')) {
            $where = array('id_kategori' => $this->input->post('kategori'));
		    $data['data_tingkat'] = $this->m_report_dokumen->get_id($where)->tingkatan;
            $data['item'] = $this->m_report_dokumen->get_id_item($where);
            

            $data['data_report_dokumen'] = $this->m_report_dokumen->data_report_dokumen($this->input->post('kategori'));
            $data['nama_kategori'] = $this->m_report_dokumen->judul_nama_dokumen_kategori($this->input->post('kategori'));

            $data['data_report_dokumen_t3'] = $this->m_report_dokumen->data_report_dokumen_t3($this->input->post('kategori'));
            // $data['nama_item'] = $this->m_report_dokumen->judul_nama_dokumen_item($id_item);
        }
        else {
            $data['nama_kategori'] =null;
            $data['nama_item'] =null;
        }

        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/report_dokumen_view',$data);
        $this->load->view('footer');
    }
}