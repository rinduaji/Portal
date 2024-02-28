<?php 
 
class M_master_pola extends CI_Model{	

    public $table = 'app_master_pola';
    public $table1 = 'cc147_main_users_extended';
	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'pola',
            'label' => 'Pola',
            'rules' => 'required'],

            ['field' => 'masuk',
            'label' => 'Masuk',
            'rules' => 'required'],

            ['field' => 'pulang',
            'label' => 'Pulang',
            'rules' => 'required'],

            ['field' => 'ist1',
            'label' => 'Istirahat 1',
            'rules' => 'required'],

        ];
    }

	function data_master_pola($limit ,$start ,$cari = null){	
        $this->db->from($this->table);
        $this->db->limit($limit, $start);
        $this->db->order_by("pola", "asc");
        if($cari) {
            $this->db->like('pola',$cari);
        }

		return $this->db->get()->result();
	}

    function jumlah_data($cari = null){	
        $this->db->from($this->table);
        $this->db->order_by("pola", "desc");
        if($cari) {
            $this->db->like('pola',$cari);
        }

		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->from($this->table);
        $this->db->where('id',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}