<?php 
 
class M_absensi extends CI_Model{	

    public $table = 'app_absen';
    public $table1 = 'cc147_main_users_extended';
    public $table2 = 'app_roosterfix';
    public $table3 = 'app_master_pola';
	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
    public function rules()
    {
        return [
            ['field' => 'username',
            'label' => 'Username',
            'rules' => 'required'],

            ['field' => 'id_rooster',
            'label' => 'ID Rooster',
            'rules' => 'required'],

        ];
    }
 
	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

    function get_rooster($login, $tanggal) {
        $this->db->select($this->table2.'.id, '.$this->table2.'.pola, '.$this->table3.'.masuk, '.$this->table3.'.pulang, '.$this->table3.'.ist1, '.$this->table3.'.ist2, '.$this->table3.'.ist3, '.$this->table3.'.ist4');
        $this->db->from($this->table2);
        $this->db->join($this->table3, $this->table2.'.pola = '.$this->table3.'.pola');
        $this->db->where($this->table2.'.login',$login);
        $this->db->where($this->table2.'.tgl_masuk',$tanggal);
		return $this->db->get()->row();
	}

    function get_absen_masuk($login, $tanggal) {
        $this->db->from($this->table);
        $this->db->where('username',$login);
        $this->db->like('date_absen',$tanggal);
        $this->db->where('keterangan','IN');
		return $this->db->count_all_results();
	}

    function get_absen_pulang($login, $tanggal) {
        $this->db->from($this->table);
        $this->db->where('username',$login);
        $this->db->like('date_absen',$tanggal);
        $this->db->where('keterangan','OUT');
		return $this->db->count_all_results();
	}


}