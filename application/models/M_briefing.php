<?php 
 
class M_briefing extends CI_Model{	

    public $table = 'app_briefing';
    public $table2 = 'cc147_main_users_extended';
    public $table3 = 'app_roosterfix';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'agent',
            'label' => 'Login Agent',
            'rules' => 'required'],

        ];
    }

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

    public function getNamaAgent() {
        $date = date("Y-m-d");
        // $this->db->select('user1,user2, user3');
        // $this->db->from($this->table2);
        // $this->db->join($this->table, $this->table2.'.user1 = '.$this->table.'.agent','left');
        // $this->db->like($this->table2.'.user3', "AGENT");
        // $this->db->where($this->table.'.tanggal', $date);
        // $this->db->order_by($this->table2.".user2", "asc");
        $query = $this->db->query("
        select * from cc147_main_users_extended as a INNER JOIN app_roosterfix as c 
        ON a.user1 = c.login
        WHERE 
            c.tgl_masuk='$date' AND
            a.user3 LIKE '%AGENT%' AND 
            NOT EXISTS (
                SELECT agent FROM app_briefing as b WHERE a.user1 = b.agent AND b.tanggal='$date'
            )
        ORDER BY a.user2 ASC");

		return $query->result();
    }
}