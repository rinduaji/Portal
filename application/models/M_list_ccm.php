<?php 
 
class M_list_ccm extends CI_Model{	

    public $table = 'cc147_main_users';
    public $table2 = 'cc147_main_users_extended';
    public $table3 = 'app_ccm_147';
    public $table4 = 'app_ccm_kat_147';
    public $table5 = 'groupmail';
    public $table6 = 'notifikasi';


	function cekJabatanIdCCM($id){	
        $this->db->from($this->table3);
        $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.user_id');
        $this->db->where($this->table3.'.id',$id);	
		return $this->db->get()->row();
	}

    function getNamaGroupmail($user_id, $jabatan) {
        if($jabatan == "TL") {
            $this->db->select('b.user_id as id_anak, b.`name` as nama_anak, f.user_id as id_tl, f.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
            $this->db->from($this->table3.' AS a');
            $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
            $this->db->join($this->table2.' AS c', 'a.no_karywn = c.user_id');
            $this->db->join($this->table2.' AS d', 'b.spv = d.user1', 'left');
            $this->db->join($this->table2.' AS e', 'b.manager = e.user1', 'left');
            $this->db->join($this->table2.' AS f', 'a.spv = f.user_id','left');
            $this->db->where('a.spv',$user_id);
        }
        elseif($jabatan == "SUPERVISOR") {
            $this->db->select('b.user_id as id_anak, b.`name` as nama_anak, f.user_id as id_tl, f.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
            $this->db->from($this->table3.' AS a');
            $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
            $this->db->join($this->table2.' AS c', 'a.no_karywn = c.user_id');
            $this->db->join($this->table2.' AS d', 'b.spv = d.user1', 'left');
            $this->db->join($this->table2.' AS e', 'b.manager = e.user1', 'left');
            $this->db->join($this->table2.' AS f', 'a.spv = f.user_id','left');
            $this->db->where('a.spv',$user_id);
        }
        elseif($jabatan == "MANAGER") {
            $this->db->select('b.user_id as id_anak, b.`name` as nama_anak, f.user_id as id_tl, f.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
            $this->db->from($this->table3.' AS a');
            $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
            $this->db->join($this->table2.' AS c', 'a.no_karywn = c.user_id');
            $this->db->join($this->table2.' AS d', 'b.spv = d.user1', 'left');
            $this->db->join($this->table2.' AS e', 'b.manager = e.user1', 'left');
            $this->db->join($this->table2.' AS f', 'a.spv = f.user_id','left');
            $this->db->where('a.spv',$user_id);
        }
        elseif($jabatan == "AGENT" || $jabatan == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
            $this->db->select('b.user_id as id_anak, b.`name` as nama_anak, f.user_id as id_tl, f.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
            $this->db->from($this->table3.' AS a');
            $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
            $this->db->join($this->table2.' AS c', 'a.no_karywn = c.user_id');
            $this->db->join($this->table2.' AS d', 'b.spv = d.user1', 'left');
            $this->db->join($this->table2.' AS e', 'b.manager = e.user1', 'left');
            $this->db->join($this->table2.' AS f', 'a.spv = f.user_id','left');
            $this->db->where('a.spv',$user_id);
            // print_r($this->db->last_query());
            // print_r($user_id);
        }
        $this->db->limit(1);
        // print_r($this->db->last_query());
        return $this->db->get()->row();
    }

	function data_list_ccm($user_id,$jabatan,$limit,$start,$cari = null, $date_awal = null, $date_akhir = null, $status = null){	
        $this->db->select($this->table3.'.id, '.$this->table.'.username, '.$this->table.'.`name`, '.$this->table2.'.user3, a.user2, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.kode, '.$this->table3.'.`status`, '.$this->table3.'.`level`, '.$this->table3.'.`spv`');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.user_id = '.$this->table2.'.id');
        $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.id');
        // if($jabatan != "MANAGER") {
            $this->db->where($this->table3.'.spv',$user_id);
        // }
        if($status != '' OR $status != NULL) {
            if($status == 'TIDAK AKTIF') {
                $this->db->where($this->table3.'.status','5');
            }
            else {
                $this->db->where($this->table3.'.status <= ','4');
            }
        }

        $this->db->limit($limit, $start);
        $this->db->order_by($this->table3.".tgl_mulai", "desc");
        if($cari) {
            $this->db->like($this->table.'.name',$cari);
        }

        if($date_awal) {
            $this->db->where($this->table3.'.tgl_mulai >=', $date_awal);
            if($date_akhir) {
                $this->db->where($this->table3.'.tgl_akhir <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where($this->table3.'.tgl_akhir <=', $date_akhir);
        }

		return $this->db->get()->result();
	}

    function jumlah_data($user_id,$jabatan,$cari = null, $date_awal = null, $date_akhir = null, $status = null){	
        $this->db->select($this->table3.'.id, '.$this->table.'.username, '.$this->table.'.`user2`, '.$this->table2.'.user3, a.name, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.kode, '.$this->table3.'.`status`, '.$this->table3.'.`level`');
        $this->db->from($this->table);
        $this->db->join($this->table2, $this->table.'.user_id = '.$this->table2.'.id');
        $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.id');
        // if($jabatan != "MANAGER") {
            $this->db->where($this->table3.'.spv',$user_id);
        // }
        if($status != '' OR $status != NULL) {
            if($status == 'TIDAK AKTIF') {
                $this->db->where($this->table3.'.status','5');
            }
            else {
                $this->db->where($this->table3.'.status <= ','4');
            }
        }

        // $this->db->limit($limit, $start);
        $this->db->order_by($this->table3.".tgl_mulai", "desc");
        if($cari) {
            $this->db->like($this->table.'.name',$cari);
        }

        if($date_awal) {
            $this->db->where($this->table3.'.tgl_mulai >=', $date_awal);
            if($date_akhir) {
                $this->db->where($this->table3.'.tgl_akhir <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where($this->table3.'.tgl_akhir <=', $date_akhir);
        }

		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table3, $data);
	}

    function data_ccm_detail($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        return $this->db->get()->row();
    }

    function cek_verifikasi($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.spv',$id);
        return $this->db->get()->row();
    }

    function data_ccm_approve_agent($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        $this->db->where($this->table3.'.status','0');
        return $this->db->get()->row();
    }
    
    function data_ccm_approve_tl($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        $this->db->where($this->table3.'.status','1');
        return $this->db->get()->row();
    }

    function data_ccm_approve_spv($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        $this->db->where($this->table3.'.status','2');
        return $this->db->get()->row();
    }

    function data_ccm_approve_manager($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        $this->db->where($this->table3.'.status','3');
        return $this->db->get()->row();
    }

    function data_ccm_approve_verifikasi($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        $this->db->where($this->table3.'.status','4');
        return $this->db->get()->row();
    }

	function updateApprove($id, $data) {
		$data_id = array('id' => $id);
		return $this->db->update($this->table3, $data, $data_id);
	}

    function updateApproveManager($id, $data) {
		$data_id = array('id' => $id);
		return $this->db->update($this->table3, $data, $data_id);
	}

    function updateApproveNotif($id, $data) {
		$data_id = array('id_ccm' => $id);
		return $this->db->update($this->table6, $data, $data_id);
	}

    function updateApproveManagerNotif($id, $data) {
		$data_id = array('id_ccm' => $id);
		return $this->db->update($this->table6, $data, $data_id);
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