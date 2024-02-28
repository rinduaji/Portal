<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Briefing extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_briefing');
		$this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
        
        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $data['username'] = $this->session->userdata('username');
        $data['list_agent'] = $this->m_briefing->getNamaAgent();
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
        // if(isset($jb_agent[1])) {
        //     if($jb_agent[1] == 'TL') {
        //         $cekjabatan = ($jb_agent[0].' '.$jb_agent[1]);
        //         // if($jb_agent[2] == 'QCO') {
        //         //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
        //         // }
        //     }
        //     else {
        //         $cekjabatan = ($jb_agent[0]);
                
        //     }
        // }
        // else {
        //     $cekjabatan = ($jb_agent[0]);
        // }

        $this->load->view('header',$data);
		$this->load->view('admin/briefing_view',$data);
        $this->load->view('footer');
	}

    public function addProses(){
		$briefing = $this->m_briefing;
        $date = date("Y-m-d");
        $lup = date("Y-m-d H:i:s");
		$data = array(
			'tanggal' => $date,
            'lup' => $lup,
			'tl' => $this->input->post('tl'),
            'agent' => $this->input->post('agent')
		);

        $validation = $this->form_validation;
		$validation->set_rules($briefing->rules());
            if ($validation->run()) {
                $this->m_briefing->insert($data);
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        

        redirect(site_url('Briefing/index'));
	}
}