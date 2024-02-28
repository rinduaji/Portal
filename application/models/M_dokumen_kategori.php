<?php 
 
class M_dokumen_kategori extends CI_Model{	

    public $table = 'kategori_dokumen';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
{
    return [
        ['field' => 'nama_kategori',
        'label' => 'Nama Kategori',
        'rules' => 'required'],

		['field' => 'tingkatan',
        'label' => 'Tingkatan',
        'rules' => 'required'],

        ['field' => 'status',
        'label' => 'Status',
        'rules' => 'required'],
    ];
}	

	function data_dokumen_kategori($limit,$start,$cari = null){	
		$this->db->limit($limit, $start);
        if($cari) {
            $this->db->like('kategori_dokumen.nama_kategori',$cari);
            $this->db->or_like('kategori_dokumen.status',$cari);
        }	
		return $this->db->get($this->table)->result();
	}

	function jumlah_data($cari = null){
		$this->db->from($this->table);	
        if($cari) {
            $this->db->like('kategori_dokumen.nama_kategori',$cari);
            $this->db->or_like('kategori_dokumen.status',$cari);
        }	
		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_kategori' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($where) {
		return $this->db->get_where($this->table, $where)->row();
	}

	function delete($id) {
		$hapus_id = array("id_kategori" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}