<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormTkd extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_tkd');
        $this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
        $login = $this->session->userdata('username');
        $jabatan = $this->session->userdata('jabatan');
        $tanggal_now = date("Y-m-d");
        $data['tanggal_start'] = date("Y-m-d",strtotime ( '+1 day' , strtotime ( $tanggal_now ) ) );
        $data['tanggal_tkd'] = '';
        if($this->input->post('btnSearchTglTkd') != NULL) {
            // die();
            $tanggal_tkd = $this->input->post('date_tkd');
            $data['tampil_pola'] = $this->m_tkd->data_pola($tanggal_tkd,$login,$jabatan);
            $data['tampil_pola_tukar'] = $this->m_tkd->data_pola_tukar($tanggal_tkd,$login,$jabatan);
            // print_r( $data['tampil_pola']);
        }

        if($this->input->post('btnSearch') != NULL) {
            $tanggal_tkd = $this->input->post('date_cari');
            $pola_tukar = $this->input->post('pola_tukar');
            $data['id2'] = $this->input->post('id');
            $data['pola_anda'] = $this->input->post('pola_anda');
            $data['username'] = $login;
            $data['tanggal_tkd'] =  $tanggal_tkd;
            $data['tampil_rooster_tkd'] = $this->m_tkd->data_rooster_tkd($tanggal_tkd,$login,$jabatan,$pola_tukar);
            // print_r($login.' '.$tanggal_tkd);
            $data['tampil_data_libur'] = $this->m_tkd->get_tkd_libur($tanggal_tkd,$login);
            // print_r($data['tampil_data_libur']);
            $data['tanggal_tkd'] = $tanggal_tkd;

            $no = 0;
            $i = 0;
            $html = array();
            $tampil_html = array();
            foreach($data['tampil_rooster_tkd'] as $data_tampil) {
                $no = 0;
                $html[$data_tampil->id]['tanggal'] = '';
                
                $data['data_tanggal_libur'] = $this->m_tkd->get_tkd_libur($tanggal_tkd,$data_tampil->user1);
                $total_tanggal_libur = COUNT($data['data_tanggal_libur']);
                // print_r($total_tanggal_libur);
                foreach($data['data_tanggal_libur'] as $dtl) {
                    $html[$data_tampil->id]['tanggal'] .= '<option value="'.$dtl->tgl_masuk.'">'.$dtl->tgl_masuk.' || '.$data_tampil->user1.' || '.$data_tampil->user2.'</option>';
                }
                $tampil_html[$data_tampil->id] = $html[$data_tampil->id]['tanggal'];
            }
            $data['select_tanggal_option'] = $tampil_html;
            // print_r( $data['select_tanggal_option']);
        }

        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/form_tkd_view',$data);
        $this->load->view('footer');
    }

    // public function get_data_libur() {
    //     $tanggalTkd = $this->input->post('tanggal',TRUE);
    //     $loginPilih = $this->input->post('login',TRUE);
    //     $data = $this->m_tkd->get_tkd_libur($tanggalTkd,$loginPilih);
    //     echo json_encode($data);
    // }

    public function tkdLibur() {
        // $tanggalTkd = $this->input->post('tanggal',TRUE);
        // $loginPilih = $this->input->post('login',TRUE);
        
        $idLibur1= 0;
		$idLibur2= 0;
        
        $id_pemohon = $this->input->post('id_pemohon');
        $tgl_libur_pemohon = $this->input->post('tgl_libur_pemohon');
        $login_pemohon = $this->input->post('login_pemohon');
        
        $id_termohon = $this->input->post('id_termohon');
        $tgl_libur_termohon = $this->input->post('tgl_libur_termohon');
        $login_termohon = $this->input->post('login_termohon');

        $idLibur1 = $this->m_tkd->getIdLibur($tgl_libur_pemohon,$login_pemohon)->id;
        $idLibur2 = $this->m_tkd->getIdLibur($tgl_libur_pemohon,$login_termohon)->id;
        // print_r($idLibur1);
        // print_r($idLibur2);
        // die();

        if($this->m_tkd->updateTkdLibur($login_pemohon,$login_termohon,$tgl_libur_pemohon,$tgl_libur_termohon,$id_termohon,$id_pemohon,$idLibur1,$idLibur2)) {
            $this->session->set_flashdata('success', 'Berhasil TKD Libur, Approve Silahkan Ditunggu oleh Login Termohon');
        }
        else {
            $this->session->set_flashdata('gagal', 'Gagal TKD Libur');
        }
        redirect(site_url('FormTkd/index'));
    }

    public function tkdRooster() {
        $id_pemohon = $this->input->post('id_pemohon');
        $login_pemohon = $this->input->post('login_pemohon');
        
        $id_termohon = $this->input->post('id_termohon');
        $login_termohon = $this->input->post('login_termohon');

        if($this->m_tkd->updateTkd($login_pemohon,$login_termohon,$id_termohon,$id_pemohon)) {
            $this->session->set_flashdata('success', 'Berhasil TKD, Approve Silahkan Ditunggu oleh Login Termohon');
        }
        else {
            $this->session->set_flashdata('gagal', 'Gagal TKD');
        }
        redirect(site_url('FormTkd/index'));
    }
}