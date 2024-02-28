<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApproveTkd extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_tkd');
        $this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
        $data_tampil = array();
        $data_tampil2= array();
        $totalCekPemohon = 0;
        $totalCekPemohon2 = 0;
        $login = $this->session->userdata('username');
        $data_tampil2= array();

        if($this->input->post('search')  != NULL) {
            $date = $this->input->post('date');
            $jabatan = $this->session->userdata('jabatan');
            if($date != "") {
                // $query="SELECT a.id,a.tgl,a.login,b.user2,b.user5,a.fastel,a.nama_dm,a.tlp,a.jenis,a.`status`,a.valid,a.upd_qco,a.prof_hoby,a.kategori,a.reason,a.ket,a.tapping_decline FROM
                // app_tam_data2 AS a INNER JOIN cc147_main_users_extended AS b ON a.login = b.user1 INNER JOIN cc147_main_users AS c ON a.login=c.username WHERE a.tgl BETWEEN '$tgl 00:00:00' AND '$tgl 23:59:59' AND a.kategori='Not Agree' AND a.`status`='Contacted' $area AND c.qco='$login' GROUP BY a.login ORDER BY a.login, a.tgl ASC";
                $hari =date("d",strtotime($date));
                $bulan =date("m",strtotime($date));
                $tahun =date("Y",strtotime($date));
                $data_approve_tkd = $this->m_tkd->get_data_approve_tkd($date,$login);
                // print_r($data_approve_tkd);
                foreach($data_approve_tkd as $data) {
                    
                    if(strpos($data->keterangan, 'Libur') !== false){
                        if(strpos($data->keterangan,'(') != '' || strpos($data->keterangan,'(') != NULL) {
                            $dataKeterangan1 = strpos($data->keterangan,'(') + 1;
                            $dataKeterangan2 = strpos($data->keterangan,')');
                            $len = $dataKeterangan2 - $dataKeterangan1;
                            $idTkd = substr($data->keterangan, $dataKeterangan1, $len);

                            $data_approve_tkd1 = $this->m_tkd->get_data_approve_tkd($date,$idTkd);
                            $totalCekPemohon = $this->m_tkd->total_data_approve_tkd_cek_termohon($date,$idTkd);

                            foreach($data_approve_tkd1 as $data1) {
                                if($totalCekPemohon == "1") {
                                    $data_tampil = array(
                                        array(
                                            'tgl' => $date ,
                                            'pemohon' => $data->user2,
                                            'pola_pemohon' => $data->pola,
                                            'termohon' => $data1->user2,
                                            'pola_termohon' => $data1->pola,
                                            'status' =>  $data->status_tkd_cuti,
                                            'loginPemohon' => $data->login,
                                            'loginTermohon' => $data1->login
                                            )
                                        );
                                }
                                else {
                                    $data_tampil = array(
                                        array(
                                            'tgl' => $date ,
                                            'termohon' => $data->user2,
                                            'pola_termohon' => $data->pola,
                                            'pemohon' => $data1->user2,
                                            'pola_pemohon' => $data1->pola,
                                            'status' =>  $data->status_tkd_cuti,
                                            'loginTermohon' => $data->login,
                                            'loginPemohon' => $data1->login
                                            )
                                        );
                                }
                            }

                            $tanggalKeterangan1 = strpos($data->keterangan,'{') + 1;
                            $tanggalKeterangan2 = strpos($data->keterangan,'}');
                            $len1 = $tanggalKeterangan2 - $tanggalKeterangan1;
                            $tanggalLiburTkd = substr($data->keterangan, $tanggalKeterangan1, $len1);
            
                            if(strpos($data->keterangan,'{') != '' OR strpos($data->keterangan,'{') != NULL) {
                                $data_approve_tkd4 = $this->m_tkd->get_data_approve_tkd($tanggalLiburTkd,$login);
                                foreach($data_approve_tkd4 as $data4) {
                                    $data_approve_tkd2 = $this->m_tkd->get_data_approve_tkd($tanggalLiburTkd,$idTkd);
                                    $totalCekPemohon2 = $this->m_tkd->total_data_approve_tkd_cek_termohon($tanggalLiburTkd,$idTkd);
                                    foreach($data_approve_tkd2 as $data2) {
                                        if($totalCekPemohon2 == "1"){
                                            $data_tampil2 = array(
                                                array(
                                                    'tgl' => $tanggalLiburTkd ,
                                                    'termohon' => $data4->user2,
                                                    'pola_termohon' => $data4->pola,
                                                    'pemohon' => $data2->user2,
                                                    'pola_pemohon' => $data2->pola,
                                                    'status' =>  $data2->status_tkd_cuti,
                                                    'loginTermohon' => $data4->login,
                                                    'loginPemohon' => $data2->login
                                                )
                                            );
                                        }
                                        else{
                                            $data_tampil2 = array(
                                                array(
                                                    'tgl' => $tanggalLiburTkd ,
                                                    'pemohon' => $data4->user2,
                                                    'pola_pemohon' => $data4->pola,
                                                    'termohon' => $data2->user2,
                                                    'pola_termohon' => $data2->pola,
                                                    'status' =>  $data2->status_tkd_cuti,
                                                    'loginPemohon' => $data4->login,
                                                    'loginTermohon' => $data2->login
                                                )
                                            );
                                        }                                
                                    }
                                }
                            }
                        }
                    }
                    else {
                        if(strpos($data->keterangan,'(') != '' OR strpos($data->keterangan,'(') != NULL) {
                            $dataKeterangan1 = strpos($data->keterangan,'(') + 1;
                            $dataKeterangan2 = strpos($data->keterangan,')');
                            $len = $dataKeterangan2 - $dataKeterangan1;
                            $idTkd = substr($data->keterangan, $dataKeterangan1, $len);

                            $data_approve_tkd1 = $this->m_tkd->get_data_approve_tkd($date,$idTkd);
                            $totalCekPemohon = $this->m_tkd->total_data_approve_tkd_cek_termohon($date,$idTkd);
                            foreach($data_approve_tkd1 as $data1) {
                                if($totalCekPemohon == "1") {
                                    $data_tampil = array(
                                        array(
                                            'tgl' => $date ,
                                            'pemohon' => $data->user2,
                                            'pola_pemohon' => $data->pola,
                                            'termohon' => $data1->user2,
                                            'pola_termohon' => $data1->pola,
                                            'status' => $data->status_tkd_cuti,
                                            'loginPemohon' => $data->login,
                                            'loginTermohon' => $data1->login
                                            )
                                        );
                                }
                                else {
                                    $data_tampil = array(
                                        array(
                                            'tgl' => $date ,
                                            'termohon' => $data->user2,
                                            'pola_termohon' => $data->pola,
                                            'pemohon' => $data1->user2,
                                            'pola_pemohon' => $data1->pola,
                                            'status' => $data->status_tkd_cuti,
                                            'loginTermohon' => $data->login,
                                            'loginPemohon' => $data1->login
                                            )
                                        );
                                }
                            }
                        }
                    }
                }
            }
        }

        // print_r( $data_tampil);
        $tanggal_now = date("Y-m-d");
        $data_approve['tanggal_start'] = date("Y-m-d",strtotime ( '+1 day' , strtotime ( $tanggal_now ) ) );
        $data_approve['data_tampil'] = $data_tampil;
        $data_approve['data_tampil2'] = $data_tampil2;
        $data_approve['totalCekPemohon'] = $totalCekPemohon;
        $data_approve['totalCekPemohon2'] = $totalCekPemohon2;
        $data_approve['login'] = $login;

        $data_approve['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data_approve['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data_approve['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data_approve['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data_approve);
		$this->load->view('admin/approve_tkd_view',$data_approve);
        $this->load->view('footer');
    }

    public function approvalTkd() {
        $login_pemohon1 = $this->input->post('login_pemohon1');
        $login_termohon1 = $this->input->post('login_termohon1');
        $polaPemohon1 = $this->input->post('polaPemohon1');
        $polaTermohon1 = $this->input->post('polaTermohon1');
        $tanggal_app1 = $this->input->post('tanggal_app1');
        
        $login_pemohon2 = $this->input->post('login_pemohon2');
        $login_termohon2 = $this->input->post('login_termohon2');
        $polaPemohon2 = $this->input->post('polaPemohon2');
        $polaTermohon2 = $this->input->post('polaTermohon2');
        $tanggal_app2 = $this->input->post('tanggal_app2');

        if($this->m_tkd->updateApproveTkd($login_pemohon1,$login_termohon1,$polaPemohon1,$polaTermohon1,$tanggal_app1,
                                            $login_pemohon2,$login_termohon2,$polaPemohon2,$polaTermohon2,$tanggal_app2)
        ) {
            $this->session->set_flashdata('success', 'TKD Berhasil Approve');
        }
        else {
            $this->session->set_flashdata('gagal', 'Approve TKD Gagal');
        }
        redirect(site_url('ApproveTkd/index'));
    }

    public function rejectedTkd() {
        $login_pemohon1 = $this->input->post('login_pemohon1');
        $login_termohon1 = $this->input->post('login_termohon1');
        $polaPemohon1 = $this->input->post('polaPemohon1');
        $polaTermohon1 = $this->input->post('polaTermohon1');
        $tanggal_app1 = $this->input->post('tanggal_app1');
        
        $login_pemohon2 = $this->input->post('login_pemohon2');
        $login_termohon2 = $this->input->post('login_termohon2');
        $polaPemohon2 = $this->input->post('polaPemohon2');
        $polaTermohon2 = $this->input->post('polaTermohon2');
        $tanggal_app2 = $this->input->post('tanggal_app2');

        if($this->m_tkd->updateRejectTkd($login_pemohon1,$login_termohon1,$polaPemohon1,$polaTermohon1,$tanggal_app1,
        $login_pemohon2,$login_termohon2,$polaPemohon2,$polaTermohon2,$tanggal_app2))
        {
            $this->session->set_flashdata('success', 'TKD Berhasil di Reject');
        }
        else {
            $this->session->set_flashdata('gagal', 'Reject TKD Gagal');
        }
        redirect(site_url('ApproveTkd/index'));
    }
}