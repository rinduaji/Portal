<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanRooster extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_plan_rooster');
		$this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

    public function index()
	{
		$this->load->library('pagination');

        $jabatan_user = $this->session->userdata('jabatan');
        $data['jb_user'] = explode(" ",$jabatan_user);

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

		$jumlah_data = $this->m_plan_rooster->jumlah_data($data['cari'],$data['date_awal'],$data['date_akhir']);

		$config['base_url'] = base_url('index.php/PlanRooster/index');
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 7;
		$data['total_data'] = $jumlah_data;

		$data['start'] = $this->uri->segment(3);
		$this->pagination->initialize($config);	

        $data['data_plan_rooster'] = $this->m_plan_rooster->data_plan_rooster($config['per_page'],$data['start'],$data['cari'],$data['date_awal'],$data['date_akhir']);

		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        $this->load->view('header',$data);
		$this->load->view('admin/plan_rooster_view',$data);
        $this->load->view('footer');
	}

    public function detail()
	{
        $id_plan_rooster = $this->uri->segment(3);
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
        
		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

		$data['detail_data_plan_rooster'] = $this->m_plan_rooster->get_id($id_plan_rooster);
        
        $this->load->view('header', $data);
        $this->load->view('admin/detail_plan_rooster_view',$data);
        $this->load->view('footer');
    }


    public function add()
	{
        $id_plan_rooster = $this->uri->segment(3);
		$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
		$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));

		$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
		$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

        if(!empty($id_plan_rooster)) {
            $data['detail_data_plan_rooster'] = $this->m_plan_rooster->get_id($id_plan_rooster);
            $data['aksi'] = 'edit';
        }
        else{
            $data['aksi'] = 'add';
        }
        
        $this->load->view('header', $data);
        $this->load->view('admin/form_plan_rooster_view',$data);
        $this->load->view('footer');
    }

	public function addProses(){
		$news = $this->m_plan_rooster;
        $id = $this->input->post('id_plan_rooster');
        $aksi = $this->input->post('aksi');
		$data = array(
            'id_plan_rooster' => $this->input->post('id_plan_rooster'),
			'judul' => $this->input->post('judul'),
            'topik' => $this->input->post('topik'),
			'status' => $this->input->post('status'),
            'tanggal' => $this->input->post('tanggal'),
            'upd' => $this->input->post('upd'),
            'short_description' => $this->input->post('short_description'),
			'description' => $this->input->post('description'),
		);

		$config['upload_path']          = FCPATH.'/uploads/file/plan_rooster/';
		$config['allowed_types']        = 'xlsx|xls|doc|docx|pdf|jpg|jpeg|png';
		$config['file_name']            = $_FILES['file_plan_rooster']['name'];
		$config['overwrite']            = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file_plan_rooster')) {
			$error = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload File ('.$error.')');
            $data['file_plan_rooster'] = '';
		} else {
			$uploaded_data = $this->upload->data();
            $data['file_plan_rooster'] = $uploaded_data['file_name'];
        }

        $config1['upload_path']          = FCPATH.'/uploads/gambar/plan_rooster/';
		$config1['allowed_types']        = 'jpg|jpeg|png';
		$config1['file_name']            = $_FILES['image']['name'];
		$config1['overwrite']            = true;


		$this->load->library('upload', $config1);
        $this->upload->initialize($config1);

		if (!$this->upload->do_upload('image')) {
			$error_image = $this->upload->display_errors();
            $this->session->set_flashdata('gagal', 'Gagal Upload Gambar ('.$error_image.')');
            redirect(site_url('PlanRooster/index'));
		} else {
			$uploaded_data = $this->upload->data();
            $data['image'] = $uploaded_data['file_name'];
        }
        $validation = $this->form_validation;
		$validation->set_rules($news->rules());
        if($aksi == 'add') {
            if ($validation->run()) {
                $this->m_plan_rooster->insert($data);
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } 
        else if($aksi == 'edit' AND $id != '') {
            if ($validation->run()) {
                $this->m_plan_rooster->update($id,$data);
                $this->session->set_flashdata('success', 'Data Berhasil diubah');
            }
            else {
                $this->session->set_flashdata('gagal', 'Data Gagal diubah');
            }
        }

        redirect(site_url('PlanRooster/index'));
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_plan_rooster->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('PlanRooster/index'));
	}
}