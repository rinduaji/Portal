<?php 
 
class M_plan_rooster extends CI_Model{	

    public $table = 'plan_rooster';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'judul',
            'label' => 'Judul Plan Rooster',
            'rules' => 'required'],

            ['field' => 'topik',
            'label' => 'Topik Plan Rooster',
            'rules' => 'required'],

            ['field' => 'status',
            'label' => 'Status',
            'rules' => 'required'],

            ['field' => 'short_description',
            'label' => 'Short Description',
            'rules' => 'required'],

        ];
    }

	function data_plan_rooster($limit ,$start ,$cari = null, $date_awal = null, $date_akhir = null){	
        $this->db->from($this->table);
        $this->db->limit($limit, $start);
        $this->db->order_by("tanggal, judul", "desc");
        if($cari) {
            $this->db->like('judul',$cari);
        }

        if($date_awal) {
            $this->db->where('tanggal >=', $date_awal);
            if($date_akhir) {
                $this->db->where('tanggal >=', $date_awal);
                $this->db->where('tanggal <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('tanggal <=', $date_akhir);
        }

		return $this->db->get()->result();
	}

    function jumlah_data($cari = null, $date_awal = null, $date_akhir = null){	
        $this->db->from($this->table);
        $this->db->order_by("tanggal, judul", "desc");
        if($cari) {
            $this->db->like('judul',$cari);
        }

        if($date_awal) {
            $this->db->where('tanggal >=', $date_awal);
            if($date_akhir) {
                $this->db->where('tanggal >=', $date_awal);
                $this->db->where('tanggal <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('tanggal <=', $date_akhir);
        }

		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_plan_rooster' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->from($this->table);
        $this->db->where('id_plan_rooster',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_plan_rooster" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}