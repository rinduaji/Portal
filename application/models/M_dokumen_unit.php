<?php 
 
class M_dokumen_unit extends CI_Model{	

    public $table = 'item_dokumen';
    public $table2 = 'kategori_dokumen';
    public $table3 = 'unit_dokumen';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'nama_unit',
            'label' => 'Nama item',
            'rules' => 'required'],

            ['field' => 'id_item',
            'label' => 'Nama Item',
            'rules' => 'required'],

            ['field' => 'status',
            'label' => 'Status',
            'rules' => 'required'],
        ];
    }
    
    function nama_dokumen_item(){	
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->where(array('item_dokumen.status'=>'AKTIF'));
		return $this->db->get()->result();
	}

	function data_dokumen_unit($limit,$start,$cari = null){	
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, unit_dokumen.id_unit, unit_dokumen.nama_unit, unit_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->join($this->table3, $this->table3.'.id_item = '.$this->table.'.id_item');
        $this->db->limit($limit, $start);
        if($cari) {
            $this->db->like('unit_dokumen.nama_unit',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('unit_dokumen.status',$cari);
        }
		return $this->db->get()->result();
	}

    function jumlah_data($cari = null){
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, unit_dokumen.id_unit, unit_dokumen.nama_unit, unit_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->join($this->table3, $this->table3.'.id_item = '.$this->table.'.id_item');
        if($cari) {
            $this->db->like('unit_dokumen.nama_unit',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('unit_dokumen.status',$cari);
        }
		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table3, $data);
	}

	function update($id, $data) {
		$data_id = array('id_unit' => $id);
		return $this->db->update($this->table3, $data, $data_id);
	}

	function get_id($id) {
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, unit_dokumen.id_unit, unit_dokumen.nama_unit, unit_dokumen.status');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_kategori = '.$this->table2.'.id_kategori');
        $this->db->join($this->table3, $this->table3.'.id_item = '.$this->table.'.id_item');
        $this->db->where('id_unit',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_unit" => $id);
		return $this->db->delete($this->table3, $hapus_id);
	}
}