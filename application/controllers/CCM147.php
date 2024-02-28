<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CCM147 extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_ccm147');
		$this->load->library('form_validation');
        $this->load->model('m_notif');
        $this->load->model('m_notif_inbox');
	}

    public function index()
	{
		$this->load->library('pagination');

        $jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
        if(isset($jb_agent[1])) {
            if($jb_agent[1] == 'TL') {
                $cekjabatan = ($jb_agent[0]);
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
        // print_r($cekjabatan);

        // die();
        // print_r($cekjabatan);
        if($cekjabatan == "TL") { 
            if($jabatan_user == "TL INPUTER"){
                $jabatan_agent = "INPUTER";
                // print_r($jabatan_agent);
                $data['list_kategori'] = $this->m_ccm147->list_kategori_support();
            }
            else {
                $jabatan_agent = "AGENT";
                $data['list_kategori'] = $this->m_ccm147->list_kategori();
            }
        }
        elseif($cekjabatan == "SUPERVISOR"){
            $jabatan_agent = "TL";
            $data['list_kategori'] = $this->m_ccm147->list_kategori_tl();
        }
        elseif($cekjabatan == "MANAGER"){
            $jabatan_agent = "SUPERVISOR";
            $data['list_kategori'] = $this->m_ccm147->list_kategori_spv();
        }
        elseif($cekjabatan == "QA"){
            $jabatan_agent = "TL QCO";
            $data['list_kategori'] = $this->m_ccm147->list_kategori_tl();
        }
        elseif($cekjabatan == "TL QCO"){
            $jabatan_agent = "QCO";
            $data['list_kategori'] = $this->m_ccm147->list_kategori_qc();
        }
        else{
            $jabatan_agent = $cekjabatan;
        }
        if($jabatan_user == "TL INPUTER"){
            $jb1 = "SOO";
            $jb2 = "SUPPORT HC";
            $jb3 = "RANGER";
            $jb4 = "SUPPORT SALES";
            $jb5 = "SUPPORT CAPS";
            $jb6 = "INPUTER";

            $data['list_jabatan_agent'] = $this->m_ccm147->list_jabatan_support($jb1,$jb2,$jb3,$jb4,$jb5,$jb6);
        }
        else {
            $data['list_jabatan_agent'] = $this->m_ccm147->list_jabatan_agent($jabatan_agent);
        }
        $data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

        $data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/ccm147_view',$data);
        $this->load->view('footer');
	}

    public function save() {
        $date_now = date("Y-m-d");
        $data_kat_aktif_temp = array();
        $data_kat_tidak_aktif_temp = array();

        $data_kode = array('coaching','konseling','batl','sp');

        $upd = $this->input->post('upd');
        $pilih_jabatan = $this->input->post('pilih_jabatan');
        $jb = explode(" ",$pilih_jabatan);
        $pilih_kategori = $this->input->post('pilih_kategori');
        $alasan = $this->input->post('alasan');
        $username = $this->input->post('pilih_agent');
        $id_detail_kategori = $this->input->post('detail_kategori');

        $status_ccm_akhir = $this->input->post('status_ccm_akhir');
        $pecah_status_ccm = explode(" ",$status_ccm_akhir);
        $kode=$pecah_status_ccm[0];
        $level=$pecah_status_ccm[1];

        $data_user_id = $this->m_ccm147->getUserId($username)->user_id;
        $pilih_detail_kat_kode = $this->m_ccm147->getKodeDetailKategori($id_detail_kategori,$jb[0])->kode;
        $pilih_detail_kat_id_kat = $this->m_ccm147->getKodeDetailKategori($id_detail_kategori,$jb[0])->id_kat;
        $lup = date("Y-m-d h:i:s");

        if(($jb) == "TL 147") { 
            $status = 1;
            $namaDetailKategori = $this->m_ccm147->getDetail($id_detail_kategori)->detail;
        }
        if(($jb) == "TL INPUTER") { 
            $status = 1;
            $namaDetailKategori = $this->m_ccm147->getDetailInputer($id_detail_kategori)->detail;
        }
        elseif($jb[0] == "SUPERVISOR"){
            $status = 2;
            $namaDetailKategori = $this->m_ccm147->getDetailTl($id_detail_kategori)->detail;
        }
        elseif($jb[0] == "MANAGER"){
            $status = 3;
            $namaDetailKategori = $this->m_ccm147->getDetailSpv($id_detail_kategori)->detail;
        }
        elseif($jb[0] == "AGENT") {
            $status = 0;
            $namaDetailKategori = $this->m_ccm147->getDetail($id_detail_kategori)->detail;
        }
        elseif($jb[0] == "INPUTER" || $jb[0] == "SUPPORT" || $jb[0] == "SOO"){
            $status = 0;
            $namaDetailKategori = $this->m_ccm147->getDetailInputer($id_detail_kategori)->detail;
        }

        if($kode == 'coaching') {
            $date_akhir = date("Y-m-d", strtotime("+7 days",strtotime($date_now)));
        }
        else if($kode == 'konseling' OR $kode == 'batl' OR $kode == 'sp'){
            $date_akhir = date("Y-m-d", strtotime("+6 months",strtotime($date_now)));
        }

        $idSpv = $this->m_ccm147->getIdSpvTl($upd)->user_id;
        $setIdCCM = ($this->m_ccm147->setIdCCM()->id) + 1;

        $data_notif = array(
            'id_ccm' => $setIdCCM,
            'status_aktif' => '1',
            'status' => $status,
            'upd' => $idSpv,
            'send_upd' => $data_user_id,
            'date_notif' => $date_now
        );

        $data = array(
            'id' => $setIdCCM,
            'kode' => $kode,
            'no_karywn' => $data_user_id,
            'tgl_mulai' => $date_now,
            'tgl_akhir' => $date_akhir,
            'jenis' => $id_detail_kategori,
            'alasan' => $alasan,
            'status' => $status,
            'lup' => $lup,
            'level' => $level,
            'kategori' => $pilih_kategori,
            'spv' => $idSpv,
            'pelanggaran' => $namaDetailKategori,
            'jabatan' => $pilih_jabatan
        );
        // print_r($date_akhir);
        // $ccm147 = $this->m_ccm147;
        // $validation = $this->form_validation;
		// $validation->set_rules($ccm147->rules());
        // if ($validation->run()) {
            $this->m_ccm147->insert($data);
            $this->m_ccm147->insertNotif($data_notif);
            $this->session->set_flashdata('success', 'Data Berhasil disimpan');
        // }
        // else {
        //     $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
        // }
        // redirect(site_url('CCM147/index'));
    }

    function statusCCM() {
        $hasil = array();
        $date_now = date("Y-m-d");
        $data_kat_aktif_temp = array();
        $data_kat_tidak_aktif_temp = array();

        $data_kode = array('coaching','konseling','batl','sp');

        $username = $this->input->post('pilih_agent');
        $id_detail_kategori = $this->input->post('detail_kategori');
        $pilih_jabatan = $this->input->post('pilih_jabatan');
        $jb = explode(" ",$pilih_jabatan);
        
        $data_user_id = $this->m_ccm147->getUserId($username)->user_id;
        $pilih_detail_kat_kode = $this->m_ccm147->getKodeDetailKategori($id_detail_kategori,$jb[0])->kode;
        $pilih_detail_kat_id_kat = $this->m_ccm147->getKodeDetailKategori($id_detail_kategori,$jb[0])->id_kat;
        $pilih_detail_kat_level = $this->m_ccm147->getKodeDetailKategori($id_detail_kategori,$jb[0])->level;

        $total_kategori = $this->m_ccm147->totalKategori($jb[0]); 

        for ($i=0; $i < count($data_kode); $i++) { 
            for ($j=1; $j <= count($total_kategori); $j++) {
                $data_kat_aktif_temp[$data_kode[$i]][$j] = $this->m_ccm147->total_data_kat_aktif($data_user_id, $date_now, $j, $data_kode[$i],$jb[0]);
            }
        }

        for ($i=0; $i < count($data_kode); $i++) { 
            for ($j=1; $j <= count($total_kategori); $j++) {
                $data_kat_tidak_aktif_temp[$data_kode[$i]][$j] = $this->m_ccm147->total_data_kat_tidak_aktif($data_user_id, $date_now, $j, $data_kode[$i],$jb[0]);
            }
        }

        // print_r($data_kat_aktif_temp);
        // print_r($data_kat_aktif_temp);
        $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat] = $this->m_ccm147->total_data_sp_aktif($data_user_id, $date_now);
        $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat] = $this->m_ccm147->total_data_sp_tidak_aktif($data_user_id, $date_now);
        
        $kode_now = "TIDAK ADA";
        $level_now = "";

        if($pilih_detail_kat_kode == "Pengembalian") {
            $kode = "Pengembalian";
            $level = 0;
        }
        else if($pilih_detail_kat_kode == "sp") {
            if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level != "") {
                if($pilih_detail_kat_level == 3){
                    if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        $kode = "Pengembalian";
                        $level = 0;

                        $kode_now = "sp";
                        $level_now = "3";
                    }
                    else{
                        $kode = "sp";
                        $level = 3;
                    }
                    // if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    //     $kode = "sp";
                    //     $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                    // }
                    // else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                    //     $kode = "Pengembalian";
                    //     $level = 0;
                    // }
                    // else{
                    //     $kode = "sp";
                    //     $level = 3;
                    // }
                }
                else {
                    if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        $kode = "sp";
                        $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                    
                        $kode_now = "sp";
                        $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                    }
                    else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        $kode = "Pengembalian";
                        $level = 0;

                        $kode_now = "sp";
                        $level_now = 3;
                    }
                    else{
                        $kode = "sp";
                        $level = 1;
                    }
                }
            }
            else {
                if($pilih_detail_kat_level != 3) {
                    if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level <= 3) {
                            $kode = "sp";
                            // $level = $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                            $level = 1;
                        }
                        else{
                            $kode = "sp";
                            $level = 1;
                        }
                    }
                    else {
                        $kode = "sp";
                        $level = 1;   
                    }
                }
                else {
                    $kode = "sp";
                    $level = 3; 
                }
            }
        }
        else if($pilih_detail_kat_kode == "batl") {
            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    $kode = "sp";
                    $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                
                    $kode_now = "sp";
                    $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                }
                else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                    $kode = "Pengembalian";
                    $level = 0;

                    $kode_now = "sp";
                    $level_now = 3;
                }
                else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                    elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                    else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    } 
                    else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    } 
                    elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        }
                    }
                    else {
                        if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "konseling";
                            // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            // $kode = "konseling";
                            // $level = 3;
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                }
                else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                    if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;

                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                    else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;
                                
                                $kode_now = "batl";
                                $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    } 
                    elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                    }
                    else {
                        if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "konseling";
                            // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            // $kode = "konseling";
                            // $level = 3;
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                }
                else{
                    if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            $level = 1; 
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "batl";
                            // $level = 3;
                            $level = 1; 
                        }
                        else {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "batl";
                                    $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "batl";
                                    $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "sp";
                                    $level = 1;

                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else{
                                    $kode = "batl";
                                    $level = 1;
                                }
                            }
                            else {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "batl";
                                    // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                    $level = 1; 

                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    // $level = 3;
                                    $level = 1; 

                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else{
                                    $kode = "batl";
                                    $level = 1;
                                }
                            }
                        }
                    }
                    else {
                        $kode = "batl";
                        $level = 1;
                    }
                }
            }
            else {
                if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                    if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        // $kode = "sp";
                        // $level = $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                        $kode = "batl";
                        $level = 1;
                    }
                    else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        // $kode = "sp";
                        // $level = 3;
                        $kode = "batl";
                        $level = 1;
                    }
                    else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        // $kode = "sp";
                        // $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                        $kode = "batl";
                        $level = 1;
                    }
                    else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        // $kode = "Pengembalian";
                        // $level = 0;
                        $kode = "batl";
                        $level = 1;
                    }
                    else {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "batl";
                            // $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            $kode = "batl";
                            $level = 1;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            // $kode = "sp";
                            // $level = 1;
                            $kode = "batl";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "batl";
                            // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            $kode = "batl";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            // $kode = "batl";
                            // $level = 3;
                            $kode = "batl";
                            $level = 1;
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != '') {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "batl";
                                    // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "batl";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "batl";
                                    // $level = 3;
                                    $kode = "batl";
                                    $level = 1;
                                }
                                else{
                                    $kode = "batl";
                                    $level = 1;
                                }
                            }
                            else {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "batl";
                                    $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "batl";
                                    $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "sp";
                                    $level = 1;

                                    $kode_now = "batl";
                                    $level_now = 3;
                                }
                                else{
                                    $kode = "batl";
                                    $level = 1;
                                }
                            }
                        }
                    }
                }
                else {
                    $kode = 'batl';
                    $level = 1;
                }
            }
        }
        else if($pilih_detail_kat_kode == "konseling") {
            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    $kode = "sp";
                    $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                
                    $kode_now = "sp";
                    $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                }
                else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                    $kode = "Pengembalian";
                    $level = 0;

                    $kode_now = "sp";
                    $level_now = 3;
                }
                else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    $level = 1;
        
                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                    }
                    elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    $level = 1;
        
                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                    }
                    // else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                    //     if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    //         $kode = "batl";
                    //         $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;

                    //         $kode_now = "batl";
                    //         $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                    //     }
                    //     else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                    //         $kode = "sp";
                    //         $level = 1;

                    //         $kode_now = "batl";
                    //         $level_now = 3;
                    //     }
                    //     else {
                    //         $kode = "batl";
                    //         $level = 1;
                    //     }
                    // } 
                    // elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                    //     if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    //         $kode = "konseling";
                    //         $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                    //         $kode_now = "konseling";
                    //         $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                    //     }
                    //     else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                    //         $kode = "batl";
                    //         $level = 1;

                    //         $kode_now = "konseling";
                    //         $level_now = 3;
                    //     }
                    //     else {
                    //         $kode = "konseling";
                    //         $level = 1;
                    //     }
                    // }
                    // else {
                    //     if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    //         // $kode = "konseling";
                    //         // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                    //         $kode = "konseling";
                    //         $level = 1;
                    //     }
                    //     else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                    //         // $kode = "konseling";
                    //         // $level = 3;
                    //         $kode = "konseling";
                    //         $level = 1;
                    //     }
                    //     else {
                    //         $kode = "konseling";
                    //         $level = 1;
                    //     }
                    // }
                }
                else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                    if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                    else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    } 
                    elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "konseling";
                            $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "konseling";
                            $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                        else {
                            $kode = "konseling";
                            $level = 1;
                        }
                    }
                    else {
                        if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "konseling";
                            // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            $kode = "konseling";
                            $level = 1;
                        }
                        else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                            // $kode = "konseling";
                            // $level = 3;
                            $kode = "konseling";
                            $level = 1;
                        }
                        else {
                            $kode = "konseling";
                            $level = 1;
                        }
                    }
                }
                else{
                    if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    }
                    else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            $kode = "sp";
                            $level = 1;

                            $kode_now = "batl";
                            $level_now = 3;
                        }
                        else {
                            $kode = "batl";
                            $level = 1;
                        }
                    } 
                    else {
                        if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "konseling";
                                $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "konseling";
                                $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;

                                $kode_now = "konseling";
                                $level_now = 3;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "konseling";
                                // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "konseling";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                    }
                }
            }
            else {
            // print_r($pilih_detail_kat_id_kat);
                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                    if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        $kode = "sp";
                        $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                        $kode_now = "sp";
                        $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                    }
                    else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        $kode = "Pengembalian";
                        $level = 0;

                        $kode_now = "sp";
                        $level_now = 3;
                    }
                    else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        } 
                        elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "konseling";
                                $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "konseling";
                                $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;

                                $kode_now = "konseling";
                                $level_now = 3;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "konseling";
                                // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "konseling";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                    }
                    else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        } 
                        elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "konseling";
                                $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "konseling";
                                $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;

                                $kode_now = "konseling";
                                $level_now = 3;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "konseling";
                                // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "konseling";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                    }
                    else{
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "batl";
                                // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "batl";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                // $kode = "batl";
                                // $level = 1;
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    $level = 1;

                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                        }   
                    }
                }
                else {
                    if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        $kode = "sp";
                        $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                    
                        $kode_now = "sp";
                        $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                    }
                    else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        $kode = "Pengembalian";
                        $level = 0;

                        $kode_now = "sp";
                        $level_now = 3;
                    }
                    else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    $level = 1;

                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            elseif($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            elseif($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else {
                                // if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                //     $kode = "batl";
                                //     $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                                // }
                                // else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                //     $kode = "sp";
                                //     $level = 1;
                                // }
                                // else {
                                //     $kode = "batl";
                                //     $level = 1;
                                // }
                                $kode="konseling";
                                $level=1;
                            }
                        }
                        elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                    }
                    else if($data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_tidak_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        elseif($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        } 
                        elseif($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "konseling";
                                $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "konseling";
                                $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "batl";
                                $level = 1;

                                $kode_now = "konseling";
                                $level_now = 3;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "konseling";
                                // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "konseling";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                    }
                    else{
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                // $kode = "batl";
                                // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                // $kode = "batl";
                                // $level = 3;
                                $kode = "konseling";
                                $level = 1;
                            }
                            else {
                                // $kode = "batl";
                                // $level = 1;
                                $kode = "konseling";
                                $level = 1;
                            }
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level != "") {
                            if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                $kode = "batl";
                                $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                            
                                $kode_now = "batl";
                                $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            }
                            else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                            else {
                                $kode = "batl";
                                $level = 1;
                            }
                        }
                        else {
                            if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    // $kode = "konseling";
                                    // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    // $kode = "konseling";
                                    // $level = 3;
                                    $kode = "konseling";
                                    $level = 1;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                            else {
                                if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "konseling";
                                    $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "konseling";
                                    $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "batl";
                                    $level = 1;

                                    $kode_now = "konseling";
                                    $level_now = 3;
                                }
                                else {
                                    $kode = "konseling";
                                    $level = 1;
                                }
                            }
                        }   
                    }
                }
            }
        }
        else if($pilih_detail_kat_kode == "coaching") {
            // print_r($pilih_detail_kat_id_kat);
            if($data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level != "") {
                if($data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->kode == "coaching" AND $data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    $kode = "coaching";
                    // $level = $data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level + 1;
                    $level = 0;
                    $kode_now = "coaching";
                    $level_now = 0;
                    // $level_now = $data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level;
                }
                else if($data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->kode == "coaching" AND $data_kat_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level == 3){
                    if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        $kode = "konseling";
                        $level = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level + 1;
                    
                        $kode_now = "konseling";
                        $level_now = $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                    }
                    else if($data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                        if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            $kode = "batl";
                            $level = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level + 1;
                        
                            $kode_now = "batl";
                            $level_now = $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                        }
                        else if($data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "sp";
                                    $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level + 1;
                                
                                    $kode_now = "sp";
                                    $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "Pengembalian";
                                    $level = 0;

                                    $kode_now = "sp";
                                    $level_now = 3;
                                }
                                else{
                                    $kode = "sp";
                                    $level = 1;

                                    $kode_now = "batl";
                                    $level_now = 3;
                                }
                            }
                            else {
                                $kode = "sp";
                                $level = 1;

                                $kode_now = "batl";
                                $level_now = 3;
                            }
                        }
                        else{
                            $kode = "batl";
                            $level = 1;

                            $kode_now = "konseling";
                            $level_now = 3;
                        }
                    }
                    else {
                        $kode = "konseling";
                        $level = 1;

                        $kode_now = "coaching";
                        $level_now = 3;
                    }
                }
                else {
                    $kode = "coaching";
                    // $level = 1;
                    $level = 0;
                }
            }
            else {
                if($data_kat_tidak_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->kode == "coaching" AND $data_kat_tidak_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level < 3) {
                    // $kode = "coaching";
                    // $level = $data_kat_tidak_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level;
                    $kode = "coaching";
                    $level = 0;
                }
                else if($data_kat_tidak_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->kode == "coaching" AND $data_kat_tidak_aktif_temp['coaching'][$pilih_detail_kat_id_kat]->max_level == 3){
                    if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level < 3) {
                        // $kode = "konseling";
                        // $level = $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level;
                        $kode = "coaching";
                        $level = 0;
                    }
                    else if($data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->kode == "konseling" AND $data_kat_tidak_aktif_temp['konseling'][$pilih_detail_kat_id_kat]->max_level == 3){
                        if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level < 3) {
                            // $kode = "batl";
                            // $level = $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level;
                            $kode = "coaching";
                            $level = 0;
                        }
                        else if($data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->kode == "batl" AND $data_kat_tidak_aktif_temp['batl'][$pilih_detail_kat_id_kat]->max_level == 3){
                            if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode != "" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level != "") {
                                if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level < 3) {
                                    $kode = "sp";
                                    $level = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                                
                                    $kode_now = "sp";
                                    $level_now = $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level;
                                }
                                else if($data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->kode == "sp" AND $data_kat_aktif_temp['sp'][$pilih_detail_kat_id_kat]->max_level == 3){
                                    $kode = "Pengembalian";
                                    $level = 0;

                                    $kode_now = "sp";
                                    $level_now = 3;
                                }
                                else{
                                    $kode = "sp";
                                    $level = 1;

                                    $kode_now = "batl";
                                    $level_now = 3;
                                }
                            }
                            else {
                                $kode = "batl";
                                $level = 3;
                            }
                        }
                        else{
                            // $kode = "batl";
                            // $level = 1;
                            $kode = "coaching";
                            $level = 0;
                        }
                    }
                    else {
                        // $kode = "konseling";
                        // $level = 1;
                        $kode = "coaching";
                        $level = 0;
                    }
                }
                else {
                    $kode = "coaching";
                    // $level = 1;
                    $level = 0;
                }
            }
        }
        $hasil = array('kode' => $kode, 'level' => $level, 'kode_now' => $kode_now, 'level_now' => $level_now);
        
        // $hasil = array('kode' => $kode, 'level' => $level);
        echo json_encode($hasil);
    }

    public function getNamaAgent() {
        $pilih_jabatan = $this->input->post('pilih_jabatan');
        $listNamaAgent = $this->m_ccm147->list_nama_jabatan_agent($pilih_jabatan);
        echo json_encode($listNamaAgent);
    }

    public function getJabatanAgent() {
        $username = $this->input->post('pilih_agent');
        $nama_jabatan_agent = $this->m_ccm147->nama_jabatan_agent($username);
        echo json_encode($nama_jabatan_agent);
    }

    public function getDetailKategori() {
        $id_kat = $this->input->post('id_kat');
        $list_detail_kategori = $this->m_ccm147->list_detail_kategori($id_kat);
        echo json_encode($list_detail_kategori);
    }

    public function getDetailKategoriTl() {
        $id_kat = $this->input->post('id_kat');
        $list_detail_kategori = $this->m_ccm147->list_detail_kategori_tl($id_kat);
        echo json_encode($list_detail_kategori);
    }

    public function getDetailKategoriQc() {
        $id_kat = $this->input->post('id_kat');
        $list_detail_kategori = $this->m_ccm147->list_detail_kategori_qc($id_kat);
        echo json_encode($list_detail_kategori);
    }

    public function getDetailKategoriSpv() {
        $id_kat = $this->input->post('id_kat');
        $list_detail_kategori = $this->m_ccm147->list_detail_kategori_spv($id_kat);
        echo json_encode($list_detail_kategori);
    }

    public function getDetailKategoriSupport() {
        $id_kat = $this->input->post('id_kat');
        $list_detail_kategori = $this->m_ccm147->list_detail_kategori_support($id_kat);
        echo json_encode($list_detail_kategori);
    }

    public function add()
	{
        $id_news = $this->uri->segment(3);
        if(!empty($id_news)) {
            $data['detail_data_news'] = $this->m_list_news->get_id($id_news);
            $data['aksi'] = 'edit';
        }
        else{
            $data['aksi'] = 'add';
        }
        
        $this->load->view('header');
        $this->load->view('admin/form_news_view',$data);
        $this->load->view('footer');
    }

	public function addProses(){
		$news = $this->m_list_news;
        $id = $this->input->post('id_news');
        $aksi = $this->input->post('aksi');
		$data = array(
            'id_news' => $this->input->post('id_news'),
			'judul' => $this->input->post('judul'),
            'topik' => $this->input->post('topik'),
			'status' => $this->input->post('status'),
            'tanggal' => $this->input->post('tanggal'),
            'upd' => $this->input->post('upd'),
            'short_description' => $this->input->post('short_description'),
			'description' => $this->input->post('description'),
		);

		$config['upload_path']          = FCPATH.'/uploads/file/news/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|jpeg|png';
		$config['file_name']            = $_FILES['file_news']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_news')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
            $data['file_news'] = '';
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_news'] = $uploaded_data['file_name'];
        }

        $config1['upload_path']          = FCPATH.'/uploads/gambar/news/';
		$config1['allowed_types']        = 'jpg|jpeg|png';
		$config1['file_name']            = $_FILES['image']['name'];
		$config1['overwrite']            = true;


		$this->load->library('upload', $config1);
        $this->upload->initialize($config1);

		if (!$this->upload->do_upload('image')) {
			$error_image = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload Gambar ('.$error_image.')');
            redirect(site_url('ListNews/index'));
		} else {
			$uploaded_data = $this->upload->data();
            $data['image'] = $uploaded_data['file_name'];
        }
        $validation = $this->form_validation;
		$validation->set_rules($news->rules());
        if($aksi == 'add') {
            if ($validation->run()) {
                $this->m_list_news->insert($data);
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } 
        else if($aksi == 'edit' AND $id != '') {
            if ($validation->run()) {
                $this->m_list_news->update($id,$data);
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal diubah');
            }
        }

        redirect(site_url('ListNews/index'));
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_list_news->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('ListNews/index'));
	}
}