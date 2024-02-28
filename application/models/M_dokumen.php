<?php 
 
class M_dokumen extends CI_Model{	

    public $table = 'dokumen';
    public $table2 = 'item_dokumen';
    public $table3 = 'kategori_dokumen';
    public $table4 = 'unit_dokumen';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'judul_dokumen',
            'label' => 'Judul Dokumen',
            'rules' => 'required'],

            ['field' => 'deskripsi',
            'label' => 'Deskripsi',
            'rules' => 'required'],

            ['field' => 'kode_dokumen',
            'label' => 'Kode Dokumen',
            'rules' => 'required'],

            ['field' => 'tanggal_berlaku',
            'label' => 'Tanggal Berlaku',
            'rules' => 'required'],

            ['field' => 'tanggal_verifikasi',
            'label' => 'Tanggal Verifikasi',
            'rules' => 'required'],
        ];
    }
    
    function nama_dokumen_kategori(){	
        $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table2);
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('item_dokumen.status','AKTIF');
		return $this->db->get()->result();
	}

    function nama_dokumen_item(){	
        // $this->db->select('item_dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, kategori_dokumen.nama_kategori, item_dokumen.status');
        $this->db->from($this->table2);
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->join($this->table4, $this->table2.'.id_item = '.$this->table4.'.id_item');
        $this->db->where(array('unit_dokumen.status'=>'AKTIF'));
		return $this->db->get()->result();
	}

	function data_dokumen($limit,$start,$cari = null, $date_awal = null, $date_akhir = null){	
        $this->db->select('dokumen.id_dokumen, dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, 
            kategori_dokumen.nama_kategori, dokumen.judul_dokumen, dokumen.deskripsi, dokumen.kode_dokumen, dokumen.tanggal_berlaku,
            dokumen.tanggal_verifikasi, dokumen.file_dokumen, dokumen.id_item as id_unit, item_dokumen.nama_item as nama_unit,kategori_dokumen.tingkatan');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_item = '.$this->table2.'.id_item');
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('item_dokumen.status','AKTIF');
        $this->db->limit($limit, $start);
        $this->db->order_by("dokumen.tanggal_berlaku,
        dokumen.tanggal_verifikasi", "desc");
        if($cari) {
            $this->db->like('dokumen.judul_dokumen',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
        }

        if($date_awal) {
            $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
            if($date_akhir) {
                $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
                $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
        }

        $query1 = $this->db->get_compiled_select();

        $this->db->select('dokumen.id_dokumen, dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, 
            kategori_dokumen.nama_kategori, dokumen.judul_dokumen, dokumen.deskripsi, dokumen.kode_dokumen, dokumen.tanggal_berlaku,
            dokumen.tanggal_verifikasi, dokumen.file_dokumen, unit_dokumen.id_unit,
            unit_dokumen.nama_unit,kategori_dokumen.tingkatan');
        $this->db->from($this->table);
        $this->db->join($this->table4, $this->table.'.id_item = '.$this->table4.'.id_unit');
        $this->db->join($this->table2, $this->table4.'.id_item = '.$this->table2.'.id_item');
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('unit_dokumen.status','AKTIF');
        $this->db->limit($limit, $start);
        $this->db->order_by("dokumen.tanggal_berlaku,
        dokumen.tanggal_verifikasi", "desc");
        if($cari) {
            $this->db->like('dokumen.judul_dokumen',$cari);
            $this->db->or_like('unit_dokumen.nama_unit',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
        }

        if($date_awal) {
            $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
            if($date_akhir) {
                $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
                $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
        }

        $query2 = $this->db->get_compiled_select();

		return $this->db->query('('.$query1 . ') UNION (' . $query2.')')->result();
	}

    function jumlah_data($cari = null, $date_awal = null, $date_akhir = null){	
        $this->db->select('dokumen.id_dokumen, dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, 
            kategori_dokumen.nama_kategori, dokumen.judul_dokumen, dokumen.deskripsi, dokumen.kode_dokumen, dokumen.tanggal_berlaku,
            dokumen.tanggal_verifikasi, dokumen.file_dokumen, dokumen.id_item as id_unit, item_dokumen.nama_item as nama_unit,kategori_dokumen.tingkatan');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_item = '.$this->table2.'.id_item');
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('item_dokumen.status','AKTIF');
        // $this->db->limit($limit, $start);
        $this->db->order_by("dokumen.tanggal_berlaku,
        dokumen.tanggal_verifikasi", "desc");
        if($cari) {
            $this->db->like('dokumen.judul_dokumen',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
        }

        if($date_awal) {
            $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
            if($date_akhir) {
                $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
                $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
        }

        $query1 = $this->db->get_compiled_select();

        $this->db->select('dokumen.id_dokumen, dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, 
            kategori_dokumen.nama_kategori, dokumen.judul_dokumen, dokumen.deskripsi, dokumen.kode_dokumen, dokumen.tanggal_berlaku,
            dokumen.tanggal_verifikasi, dokumen.file_dokumen, unit_dokumen.id_unit,
            unit_dokumen.nama_unit,kategori_dokumen.tingkatan');
        $this->db->from($this->table);
        $this->db->join($this->table4, $this->table.'.id_item = '.$this->table4.'.id_unit');
        $this->db->join($this->table2, $this->table4.'.id_item = '.$this->table2.'.id_item');
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('unit_dokumen.status','AKTIF');
        // $this->db->limit($limit, $start);
        $this->db->order_by("dokumen.tanggal_berlaku,
        dokumen.tanggal_verifikasi", "desc");
        if($cari) {
            $this->db->like('dokumen.judul_dokumen',$cari);
            $this->db->or_like('unit_dokumen.nama_unit',$cari);
            $this->db->or_like('item_dokumen.nama_item',$cari);
            $this->db->or_like('kategori_dokumen.nama_kategori',$cari);
        }

        if($date_awal) {
            $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
            if($date_akhir) {
                $this->db->where('dokumen.tanggal_berlaku >=', $date_awal);
                $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('dokumen.tanggal_berlaku <=', $date_akhir);
        }

        $query2 = $this->db->get_compiled_select();
        $query3 = $this->db->query('('.$query1 . ') UNION (' . $query2.')');
		return $query3->num_rows();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_dokumen' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->select('dokumen.id_dokumen, dokumen.id_item, item_dokumen.nama_item, item_dokumen.id_kategori, 
            kategori_dokumen.nama_kategori, dokumen.judul_dokumen, dokumen.deskripsi, dokumen.kode_dokumen, dokumen.tanggal_berlaku,
            dokumen.tanggal_verifikasi, dokumen.file_dokumen');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.id_item = '.$this->table2.'.id_item');
        $this->db->join($this->table3, $this->table2.'.id_kategori = '.$this->table3.'.id_kategori');
        $this->db->where('id_dokumen',$id);
        $this->db->where('item_dokumen.status','AKTIF');
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_dokumen" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}