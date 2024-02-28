<?php 
 
class M_risalah_rapat extends CI_Model{	

    public $table = 'risalah_rapat';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'judul_risalah_rapat',
            'label' => 'Judul Risalah Rapat',
            'rules' => 'required'],

            ['field' => 'area',
            'label' => 'Area',
            'rules' => 'required'],

        ];
    }

	function data_risalah_rapat($limit ,$start ,$cari = null, $date_awal = null, $date_akhir = null, $area = null){	
        $this->db->from($this->table);
        $this->db->limit($limit, $start);
        $this->db->order_by("tanggal_posting, judul_risalah_rapat", "desc");
        if($cari) {
            $this->db->like('judul_risalah_rapat',$cari);
        }

        if($area) {
            $this->db->like('area',$area);
        }

        if($date_awal) {
            $this->db->where('tanggal_posting >=', $date_awal);
            if($date_akhir) {
                $this->db->where('tanggal_posting >=', $date_awal);
                $this->db->where('tanggal_posting <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('tanggal_posting <=', $date_akhir);
        }

		return $this->db->get()->result();
	}

    function jumlah_data($cari = null, $date_awal = null, $date_akhir = null, $area = null){	
        $this->db->from($this->table);
        $this->db->order_by("tanggal_posting, judul_risalah_rapat", "desc");
        if($cari) {
            $this->db->like('judul_risalah_rapat',$cari);
        }

        if($area) {
            $this->db->like('area',$area);
        }

        if($date_awal) {
            $this->db->where('tanggal_posting >=', $date_awal);
            if($date_akhir) {
                $this->db->where('tanggal_posting >=', $date_awal);
                $this->db->where('tanggal_posting <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('tanggal_posting <=', $date_akhir);
        }

		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_risalah_rapat' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->from($this->table);
        $this->db->where('id_risalah_rapat',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_risalah_rapat" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}