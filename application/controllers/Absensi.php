<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Absensi extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_absensi');
		$this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
        
	}

	public function index()
	{
        date_default_timezone_set('Asia/Jakarta');
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
        if(isset($jb_agent[1])) {
            if($jb_agent[1] == 'LEADER') {
                $cekjabatan = ($jb_agent[0].' '.$jb_agent[1]);
                if($jb_agent[2] == 'QCO') {
                    $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;

        $tanggal = date("Y-m-d");
        $data['login'] = $this->session->userdata('username');
        $data['nama'] = $this->session->userdata('nama');
        $data['jabatan'] = $this->session->userdata('jabatan');
        $data['area'] = $this->session->userdata('area');

        $data['data_absen'] = $this->m_absensi->get_rooster($data['login'],$tanggal);
        $data['cek_absen_masuk'] = $this->m_absensi->get_absen_masuk($data['login'],$tanggal);
        $data['cek_absen_pulang'] = $this->m_absensi->get_absen_pulang($data['login'],$tanggal);

        // print_r($data['data_absen']);

        $this->load->view('header',$data);
		$this->load->view('admin/absensi_view',$data);
        $this->load->view('footer');
	}

    public function addProses(){
        date_default_timezone_set('Asia/Jakarta');
		$absensi = $this->m_absensi;
        if($this->input->post('absen_masuk') !== NULL){
            $keterangan = "IN";
        }

        if($this->input->post('absen_pulang')  !== NULL){
            $keterangan = "OUT";
        }

		$data = array(
			'username' => $this->input->post('username'),
            'id_rooster' => $this->input->post('id_rooster'),
			'status' => '1',
            'date_absen' => date("Y-m-d H:i:s"),
            'keterangan' => $keterangan,
            'area' => $this->input->post('area'),
			'jabatan' => $_SESSION['jabatan'],
		);

        $validation = $this->form_validation;
		$validation->set_rules($absensi->rules());
        if ($validation->run()) {
            $this->m_absensi->insert($data);
            $this->session->set_flashdata('success', 'Anda Berhasil Absen');
        }
        else {
            $this->session->set_flashdata('gagal', 'Anda Gagal Absen');
        }

        redirect(site_url('Absensi/index'));
	}

}