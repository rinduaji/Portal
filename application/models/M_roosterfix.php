<?php 
 
class M_roosterfix extends CI_Model{	

    public $table1 = 'app_roosterfix';
    public $table2 = 'app_roosterfix_asli';
    public $table3 = 'cc147_main_users';
    public $table4 = 'cc147_main_users_extended';

    public function insertRoosterfixBatch($data) {
        $this->db->insert_batch($this->table1,$data);
        if($this->db->affected_rows() > 0 ) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function insertRoosterfixAsliBatch($data) {
        $this->db->insert_batch($this->table2,$data);
        if($this->db->affected_rows() > 0 ) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function cekDataUploadRooster($login,$tgl_masuk) {
        $this->db->from($this->table1);
        $this->db->where($this->table1.'.login', $login);
        $this->db->where($this->table1.'.tgl_masuk',$tgl_masuk);
		return $this->db->count_all_results();
    }

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
}