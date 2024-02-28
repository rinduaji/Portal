<?php 
 
class M_dokumen_item extends CI_Model{	

    public $table = 'item_dokumen';
    public $table2 = 'kategori_dokumen';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'nama_item',
            'label' => 'Nama item',
            'rules' => 'required'],

            ['field' => 'id_kategori',
            'label' => 'Nama Kategori',
            'rules' => 'required'],

            ['field' => 'status',
            'label' => 'Status',
            'rules' => 'required'],
        ];
    }
    
    function nama_dokumen_kategori(){	
        
		return $this->db->get_where($this->table2, array('status'=>'AKTIF'))->result();
	}

	function data_dokumen_item($limit,$start,$cari = null){	
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->limit($limit, $start);
        if($cari) {
            $this->db->like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
            $this->db->or_like('item_dokumen.status',$cari);
        }
		return $this->db->get()->result();
	}

    function jumlah_data($cari = null){
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        if($cari) {
            $this->db->like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
            $this->db->or_like('item_dokumen.status',$cari);
        }
		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_item' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->where('id_item',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_item" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}