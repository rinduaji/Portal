<?php 
 
class M_notif extends CI_Model{	

    public $table1 = 'app_ccm_147';
    public $table2 = 'notifikasi';
    public $table3 = 'cc147_main_users';
    public $table4 = 'cc147_main_users_extended';
    public $table5 = 'notifikasi_inbox';

	public function totalNotif($user_id) {
        $this->db->from($this->table2);
        $this->db->join($this->table1, $this->table1.'.id = '.$this->table2.'.id_ccm');
        $this->db->join($this->table3, $this->table3.'.user_id = '.$this->table2.'.upd');
        $this->db->where($this->table2.'.status_aktif','1');
        $this->db->where($this->table2.'.send_upd',$user_id);
		  return $this->db->count_all_results();
    }

    public function dataNotif($user_id) {
        $this->db->from($this->table2);
        $this->db->join($this->table1, $this->table1.'.id = '.$this->table2.'.id_ccm');
        $this->db->join($this->table3, $this->table3.'.user_id = '.$this->table2.'.upd');
        $this->db->where($this->table2.'.status_aktif','1');
        $this->db->where($this->table2.'.send_upd',$user_id);
		return $this->db->get()->result();
    }

    public function updateNotif($user_id) {
      $data_id = array('send_upd' => $user_id);
      return $this->db->update($this->table2, array('status_aktif' => '0'), $data_id);
	  }

    public function updateNotifInbox($username) {
      $data_id = array('send_upd' => $username);
      return $this->db->update($this->table5, array('status_aktif' => '0'), $data_id);
	  }
}