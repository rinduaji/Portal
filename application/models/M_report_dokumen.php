<?php 
 
class M_report_dokumen extends CI_Model{	

    public $table = 'item_dokumen';
    public $table2 = 'kategori_dokumen';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
    function nama_dokumen_kategori(){	
		return $this->db->get_where($this->table2, array('status'=>'AKTIF'))->result();
	}

    function get_id($where) {
		return $this->db->get_where($this->table2, $where)->row();
	}

    function get_id_item($where) {
		return $this->db->get_where($this->table, $where);
	}

    function judul_nama_dokumen_kategori($id_kategori){	
        $this->db->select('nama_kategori');
		return $this->db->get_where($this->table2, array('id_kategori'=>$id_kategori))->row();
	}

    function data_report_dokumen($id_kategori){	
        $query = $this->db->query("
        SELECT 
            h.id_dokumen, h.judul_dokumen, h.file_dokumen, h.id_item, 
            i.nama_item, h.deskripsi, h.kode_dokumen, MAX(h.tanggal_berlaku) as tanggal_berlaku, 
            MAX(h.tanggal_verifikasi) as tanggal_verifikasi, j.id_kategori, j.nama_kategori, 
            (COUNT(h.judul_dokumen)-1) as used_version, 
            (COUNT(h.judul_dokumen)-2) as old_version 
        FROM 
        (
            SELECT * FROM dokumen ORDER BY tanggal_berlaku ASC
        )
        as h INNER JOIN item_dokumen as i ON h.id_item = i.id_item 
        INNER JOIN kategori_dokumen as j ON i.id_kategori = j.id_kategori 
        WHERE i.`status` = 'AKTIF' AND j.`status` = 'AKTIF' AND j.id_kategori = '$id_kategori' GROUP BY j.id_kategori, i.id_item, h.judul_dokumen ORDER BY j.nama_kategori, i.nama_item, h.kode_dokumen ASC, h.tanggal_berlaku DESC
        
        ");
		return $query->result();
	}

    // function judul_nama_dokumen_item($id_item){	
    //     $this->db->select('nama_item');
	// 	return $this->db->where($this->table, array('id_item'=>$id_item))->row();
	// }

    function data_report_dokumen_t3($id_kategori){	
        $query = $this->db->query("
        SELECT 
            h.id_dokumen, h.judul_dokumen, h.file_dokumen, h.id_item, 
            i.nama_item, h.deskripsi, h.kode_dokumen, h.tanggal_berlaku, 
            h.tanggal_verifikasi, j.id_kategori, j.nama_kategori,
						k.id_unit, k.nama_unit, 
            (COUNT(h.judul_dokumen)-1) as used_version, 
            (COUNT(h.judul_dokumen)-2) as old_version 
        FROM 
        dokumen as h 
				INNER JOIN unit_dokumen as k ON h.id_item = k.id_unit 
				INNER JOIN item_dokumen as i ON k.id_item = i.id_item 
        INNER JOIN kategori_dokumen as j ON i.id_kategori = j.id_kategori 
				
        WHERE i.`status` = 'AKTIF' AND j.`status` = 'AKTIF' AND j.id_kategori = '12'  GROUP BY j.id_kategori, i.id_item, k.id_unit, h.judul_dokumen ORDER BY j.nama_kategori, i.nama_item, k.nama_unit, h.kode_dokumen ASC, tanggal_berlaku DESC
        ");
		return $query->result();
	}
}