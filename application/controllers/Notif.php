<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_notif');
	}

	public function updateStatusNotif()
	{
        $user_id = $this->input->post('user_id');
		if($this->m_notif->updateNotif($user_id)){
            $status = "sukses";
        }
        else {
            $status = "gagal";
        }
        $hasil = array('status_update_notif' => $status);
        echo json_encode($hasil);
	}

    public function updateStatusNotifInbox()
	{
        $username = $this->input->post('username');
		if($this->m_notif->updateNotifInbox($username)){
            $status = "sukses";
        }
        else {
            $status = "gagal";
        }
        $hasil = array('status_update_notif' => $status);
        echo json_encode($hasil);
	}
}