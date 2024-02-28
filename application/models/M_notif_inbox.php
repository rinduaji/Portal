<?php 
 
class M_notif_inbox extends CI_Model{	

    public $table1 = 'inbox';
    public $table2 = 'notifikasi_inbox';
    public $table3 = 'cc147_main_users';
    public $table4 = 'cc147_main_users_extended';

	public function totalNotif($username) {
        $this->db->from($this->table2);
        $this->db->join($this->table1, $this->table1.'.id_inbox = '.$this->table2.'.id_inbox');
        $this->db->join($this->table3, $this->table3.'.username = '.$this->table2.'.upd');
        $this->db->where($this->table2.'.status_aktif','1');
        $this->db->where($this->table2.'.send_upd',$username);
        // print_r($this->db->last_query());
		return $this->db->count_all_results();
    }

    public function dataNotif($username) {
        $this->db->from($this->table2);
        $this->db->join($this->table1, $this->table1.'.id_inbox = '.$this->table2.'.id_inbox');
        $this->db->join($this->table3, $this->table3.'.username = '.$this->table2.'.upd');
        $this->db->where($this->table2.'.status_aktif','1');
        $this->db->where($this->table2.'.send_upd',$username);
		return $this->db->get()->result();
    }

    public function updateNotif($username) {
		$data_id = array('send_upd' => $username);
		return $this->db->update($this->table2, array('status_aktif' => '0'), $data_id);
	}
}