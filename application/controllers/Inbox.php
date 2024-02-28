<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_inbox');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

    public function index()
	{
		$this->load->library('pagination');

		$username = $this->session->userdata('username');
        $jabatan_user = $this->session->userdata('jabatan');
        $data['jb_user'] = explode(" ",$jabatan_user);
        $cari_jb = explode(" ",$jabatan_user);

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

        if($this->input->post('filter')) {
			$filter = $this->input->post('filter');
		}
		else {
			$filter = null;
		}

		if($this->input->post('btnSearch')) {
			$data['btnSearch'] = $this->input->post('btnSearch');
			// print_r($data['btnSearch']);
		}
		else {
			$data['btnSearch'] = null;
		}

		if($this->input->post('btnSearch')) {
			$jumlah_data = $this->m_inbox->jumlah_data($data['cari'],$data['date_awal'],$data['date_akhir'],$cari_jb[0],$filter,$username);

			$config['base_url'] = base_url('index.php/Inbox/index');
			$config['total_rows'] = $jumlah_data;
			$config['per_page'] = 7;
			$data['total_data'] = $jumlah_data;

			$data['start'] = $this->uri->segment(3);
			$this->pagination->initialize($config);	

			$data['data_inbox'] = $this->m_inbox->data_inbox($config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir'],$cari_jb[0],$filter,$username);
		}
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/inbox_view',$data);
        $this->load->view('footer');
	}

    public function detail()
	{
        $id_inbox = $this->uri->segment(3);
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
        
		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));
		
		$data['detail_data_inbox'] = $this->m_inbox->get_id($id_inbox);
        
        $this->load->view('header', $data);
        $this->load->view('admin/detail_inbox_view',$data);
        $this->load->view('footer');
    }


    public function add()
	{
		$data['jabatan'] = $this->session->userdata("jabatan");
        $id_inbox = $this->uri->segment(3);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));


        if(!empty($id_inbox)) {
            $data['detail_data_inbox'] = $this->m_inbox->get_id($id_inbox);
			$data['list_agent'] = $this->m_inbox->listAgent();
            $data['aksi'] = 'edit';
        }
        else{
            $data['aksi'] = 'add';
			$data['list_agent'] = $this->m_inbox->listAgent();
			// print_r($data['list_agent']);
        }
        
        $this->load->view('header', $data);
        $this->load->view('admin/form_inbox_view',$data);
        $this->load->view('footer');
    }

	public function addProses(){
		$news = $this->m_inbox;
        $id = $this->input->post('id_inbox');
        $aksi = $this->input->post('aksi');

		$date_now = date("Y-m-d");
		$jb = explode(" ",$this->session->userdata('jabatan'));

		if(($jb[0]) == "TL") { 
            $status = 1;
        }
        elseif($jb[0] == "SUPERVISOR"){
            $status = 2;
        }
        elseif($jb[0] == "MANAGER"){
            $status = 3;
        }
        elseif($jb[0] == "AGENT"){
            $status = 0;
        }

        $setIdInbox = ($this->m_inbox->setIdInbox()->id) + 1;
		$pengawakan = $this->m_inbox->getPengawakan($this->input->post('login'), $jb[0]);

		$data = array(
            'id_inbox' => (($aksi == 'add') ? $setIdInbox : $this->input->post('id_inbox')),
			'judul' => $this->input->post('judul'),
            'topik' => $this->input->post('topik'),
			'status' => $this->input->post('status'),
            'tanggal' => $this->input->post('tanggal'),
            'upd' => $this->input->post('upd'),
            'login' => $this->input->post('login'),
            'short_description' => $this->input->post('short_description'),
			'description' => $this->input->post('description'),
			'jenis' => $this->input->post('jenis'),
			'login_private' => $this->input->post('login_private'),
		);

		$config['upload_path']          = FCPATH.'/uploads/file/inbox/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|png';
		$config['file_name']            = $_FILES['file_inbox']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_inbox')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
            $data['file_inbox'] = '';
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_inbox'] = $uploaded_data['file_name'];
        }

        // $config1['upload_path']          = FCPATH.'/uploads/gambar/inbox/';
		// $config1['allowed_types']        = 'jpg|jpeg|png';
		// $config1['file_name']            = $_FILES['image']['name'];
		// $config1['overwrite']            = true;


		// $this->load->library('upload', $config1);
        // $this->upload->initialize($config1);

		// if (!$this->upload->do_upload('image')) {
		// 	$error_image = $this->upload->display_errors();
        //     // $this->session->set_flashdata('gagal', 'Gagal Upload Gambar ('.$error_image.')');
        //     // redirect(site_url('Inbox/index'));
		// } else {
		// 	$uploaded_data = $this->upload->data();
        //     $data['image'] = $uploaded_data['file_name'];
        // }
        $validation = $this->form_validation;
		$validation->set_rules($news->rules());
        if($aksi == 'add') {
            if ($validation->run()) {
                $this->m_inbox->insert($data);

				if(($this->input->post('jenis') == "BLAST")){
					foreach($pengawakan as $p) {
						$data_notif = array(
							'id_inbox' => $setIdInbox,
							'status_aktif' => '1',
							'status' => $status,
							'upd' => $this->input->post('login'),
							'send_upd' => (($this->input->post('jenis') == "BLAST") ? $p->username : $this->input->post('login_private')),
							'date_notif' => $date_now
						);
						$this->m_inbox->insertNotif($data_notif);
					}
				}
				else {
					$data_notif = array(
						'id_inbox' => $setIdInbox,
						'status_aktif' => '1',
						'status' => $status,
						'upd' => $this->input->post('login'),
						'send_upd' => (($this->input->post('jenis') == "BLAST") ? $p->username : $this->input->post('login_private')),
						'date_notif' => $date_now
					);
					$this->m_inbox->insertNotif($data_notif);
				}

                $this->session->set_flashdata('success', 'Data Berhasil dikirim');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal dikirim');
            }
        } 
        else if($aksi == 'edit' AND $id != '') {
            if ($validation->run()) {
                $this->m_inbox->update($id,$data);
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal diubah');
            }
        }

        redirect(site_url('Inbox/index'));
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_inbox->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('Inbox/index'));
	}
}