<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExecuteCCM extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_execute_ccm');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$user_id = $this->session->userdata("user_id");
		// print_r($user_id);
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_agent = explode(" ",$jabatan_user);
		// print_r($jb_agent);

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

		if($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		}
		else {
			$data['status'] = null;
		}

		$jumlah_data = $this->m_execute_ccm->jumlah_data($user_id,$jb_agent[0],$data['cari'],$data['date_awal'],$data['date_akhir'],$data['status']);

		$config['base_url'] = base_url('index.php/ExecuteCCM/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_list_ccm'] = $this->m_execute_ccm->data_list_ccm($user_id,$jb_agent[0],$config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir'],$data['status']);
        // $data['nama_list_ccm_kategori'] = $this->m_execute_ccm->nama_list_ccm_kategori();
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
		
		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$data['cek_verifikasi'] = $this->m_execute_ccm->cek_verifikasi($user_id);
		// print_r($data['cek_verifikasi']->jabatan);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'TL') {
                $cekjabatan = ($jb_agent[0]);
                if($jb_agent[1] == 'QCO') {
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
		
        $this->load->view('header',$data);
		$this->load->view('admin/execute_ccm_view',$data);
        $this->load->view('footer');
	}

    public function ApproveAgent($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_execute_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_execute_ccm->cekJabatanIdCCM($id)->spv;
		// print_r($cekId);
        $jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                // if($jb_agent[2] == 'QCO') {
                //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                // }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_execute_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_agent'] = $this->m_execute_ccm->data_ccm_approve_agent($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_agent_view',$data);
        $this->load->view('footer');
    }

    public function ApproveTL($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_execute_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_execute_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
                $cekjabatan = ($jb_agent[0]);
                // if($jb_agent[2] == 'QCO') {
                //     $cekjabatan = ($jb_agent[0].' '.$jb_agent[1].' '.$jb_agent[2]); 
                // }
            }
            else {
                $cekjabatan = ($jb_agent[0]);
                
            }
        }
        else {
            $cekjabatan = ($jb_agent[0]);
        }
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_execute_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_tl'] = $this->m_execute_ccm->data_ccm_approve_tl($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_tl_view',$data);
        $this->load->view('footer');
    }

    public function ApproveSpv($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		// print_r($jb_user);
		$cekJabatanIdCCM = $this->m_execute_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_execute_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
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
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_execute_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_spv'] = $this->m_execute_ccm->data_ccm_approve_spv($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_spv_view',$data);
        $this->load->view('footer');
    }

	public function ApproveManager($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_execute_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_execute_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
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
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_execute_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_manager'] = $this->m_execute_ccm->data_ccm_approve_manager($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$this->load->view('header',$data);
		$this->load->view('admin/approve_manager_view',$data);
        $this->load->view('footer');
    }

    public function Verifikasi($id) {
		$jabatan_user = $this->session->userdata('jabatan');
        $jb_user = explode(" ",$jabatan_user);
		$cekJabatanIdCCM = $this->m_execute_ccm->cekJabatanIdCCM($id)->user3;
		$cekId = $this->m_execute_ccm->cekJabatanIdCCM($id)->spv;
		$jb_agent = explode(" ",$cekJabatanIdCCM);
        if(isset($jb_agent[0])) {
            if($jb_agent[0] == 'AGENT' || $jb_agent[0] == 'INPUTER') {
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
		$data['hasil_jabatan'] = $cekjabatan;
		$data['data_nama_groupmail'] = $this->m_execute_ccm->getNamaGroupmail($cekId,$jb_user[0]);
		$data['data_approve_verifikasi'] = $this->m_execute_ccm->data_ccm_approve_verifikasi($id);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/verifikasi_view',$data);
        $this->load->view('footer');
    }

	public function updateApproveAgent() {
		$id = $this->input->post('id');
		$komitmen = $this->input->post('komitmen');
		$lup_agn = $this->input->post('lup_agent');
		$id_tl = $this->input->post('id_tl');
		$data = array(
			'komitmen' => $komitmen,
			'lup_agn' => $lup_agn,
			'status' => '1',
		);
		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_tl,
			'status' => '1',
		);
        if ($komitmen != "" AND $lup_agn != "") {
			$this->m_execute_ccm->updateApprove($id,$data);
			$this->m_execute_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ExecuteCCM/index'));
	}

	public function updateApproveTl() {
		$id = $this->input->post('id');
		$lup_tl = $this->input->post('lup_tl');
		$id_spv = $this->input->post('id_spv');
		if($this->input->post('penyuluhan')) {
			$data = array(
				'lup_krd' => $lup_tl,
				'status' => '2',
				'penyuluhan' => $this->input->post('penyuluhan')
			);
		} 
		else {
			$data = array(
				'lup_krd' => $lup_tl,
				'status' => '2',
			);
		}
		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_spv,
			'status' => '2',
		);

        if ($lup_tl != "") {
			$this->m_execute_ccm->updateApprove($id,$data);
			$this->m_execute_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ExecuteCCM/index'));
	}

	public function updateApproveSpv() {
		$id = $this->input->post('id');
		$lup_spv = $this->input->post('lup_spv');
		$id_manager = $this->input->post('id_manager');
		if($this->input->post('penyuluhan')) {
			$data = array(
				'lup_spv' => $lup_spv,
				'status' => '3',
				'penyuluhan' => $this->input->post('penyuluhan')
			);
		}
		else {
			$data = array(
				'lup_spv' => $lup_spv,
				'status' => '3',
			);
		}

		$data_notif = array(
			'status_aktif' => '1',
			'send_upd' => $id_manager,
			'status' => '3',
		);

        if ($lup_spv != "") {
			$this->m_execute_ccm->updateApprove($id,$data);
			$this->m_execute_ccm->updateApproveNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ExecuteCCM/index'));
	}

	public function updateApproveManager() {
		$id = $this->input->post('id');
		$lup_mgr = $this->input->post('lup_mgr');
		$data = array(
			'lup_mgr' => $lup_mgr,
			'status' => '4',
		);

        if ($lup_mgr != "") {
			$this->m_execute_ccm->updateApproveManager($id,$data);
			// $this->m_execute_ccm->updateApproveManagerNotif($id,$data_notif);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ExecuteCCM/index'));
	}

	public function updateApproveVerifikasi() {
		$id = $this->input->post('id');
		$verifikasi = $this->input->post('verifikasi');
		$tgl_verifi = $this->input->post('tgl_verifi');
		$data = array(
			'verifikasi' => $verifikasi,
			'tgl_verifi' => $tgl_verifi,
			'status' => '5',
		);

        if($verifikasi != "" AND $tgl_verifi != "") {
			$this->m_execute_ccm->updateApprove($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ExecuteCCM/index'));
	}

	public function add(){
		$dokumen = $this->m_execute_ccm;
		$data = array(
            'id_item' => $this->input->post('id_item'),
			'judul_dokumen' => $this->input->post('judul_dokumen'),
            'deskripsi' => $this->input->post('deskripsi'),
			'kode_dokumen' => $this->input->post('kode_dokumen'),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku'),
			'tanggal_verifikasi' => $this->input->post('tanggal_verifikasi'),
		);

		$config['upload_path']          = FCPATH.'/uploads/dokumen/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf';
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
			$this->m_execute_ccm->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal disimpan');
		}

        redirect(site_url('Dokumen'));
	}

	public function edit(){
		$dokumen = $this->m_execute_ccm;
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
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf';
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
			$this->m_execute_ccm->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('Dokumen'));
	}

	public function get_by_id($id) {
		$data = $this->m_execute_ccm->get_id($id);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_execute_ccm->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('Dokumen'));
	}
}