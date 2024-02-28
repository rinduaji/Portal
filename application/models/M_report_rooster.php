<?php 
 
class M_report_rooster extends CI_Model{	

    // public $this->table = 'item_rooster';
    private $table1 = 'cc147_main_users_extended';
    private $table2 = 'app_roosterfix';
    private $table3 = 'app_master_pola';
    private $table4 = 'app_jabatan';
    private $table5 = 'cc147_main_users';
    private $table6 = 'app_master_pola';
    private $table7 = 'app_roosterfix_asli';

    public function rules()
    {
        return [
            ['field' => 'pola',
            'label' => 'Pola',
            'rules' => 'required']
        ];
    }

    // function nama_absensi_kategori(){	
	// 	return $this->db->get_where($this->table1, array('status'=>'AKTIF'))->result();
	// }

    // function judul_nama_absensi_kategori($id_kategori){	
    //     $this->db->select('nama_kategori');
	// 	return $this->db->get_where($this->table1, array('id_kategori'=>$id_kategori))->row();
	// }

    function data_report_rooster($cari = null, $date_awal = null, $date_akhir = null, $jabatan = null){	
        $this->db->select($this->table2.'.id, '.$this->table2.'.periode, '.$this->table1.'.user1, '.$this->table1.'.user2, '.$this->table1.'.user3, '.$this->table1.'.user5, '.$this->table2.'.keterangan, '.$this->table3.'.masuk, '.$this->table3.'.pulang, '.$this->table2.'.pola, '.$this->table2.'.tgl_masuk, '
        .$this->table3.'.ist1, '.$this->table3.'.ist2, '.$this->table3.'.ist3, '.$this->table3.'.ist4, '.$this->table5.'.name as nama_tkd');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table2.'.login = '.$this->table1.'.user1');
        $this->db->join($this->table5, $this->table2.'.kode_tkd_cuti = '.$this->table5.'.username','left');
        $this->db->join($this->table3, $this->table2.'.pola = '.$this->table3.'.pola');
        // $this->db->join($this->table5, $this->table2.'.keterangan = '.$this->table3.'.username', 'left');
        // $this->db->limit($limit, $start);
        $this->db->order_by($this->table2.".tgl_masuk, ".$this->table1.".user5, ".$this->table1.".user3, ".$this->table2.".pola, ".$this->table1.".user2, ".$this->table1.".user1, ".$this->table2.".keterangan", "asc");
        if($cari) {
            $this->db->like($this->table1.'.user2',$cari);
            $this->db->or_like($this->table1.'.user1',$cari);
        }

        if($date_awal) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) >=', $date_awal);
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
        }

        if($jabatan != NULL) {
            $this->db->where($this->table1.'.user3', $jabatan);
        }

		return $this->db->get()->result();
	}

    function jumlah_data_rooster($cari = null, $date_awal = null, $date_akhir = null, $jabatan = null){	
        $this->db->select($this->table2.'.id, '.$this->table2.'.periode, '.$this->table1.'.user1, '.$this->table1.'.user2, '.$this->table1.'.user3, '.$this->table1.'.user5, '.$this->table2.'.keterangan, '.$this->table3.'.masuk, '.$this->table3.'.pulang, '.$this->table2.'.pola, '.$this->table2.'.tgl_masuk, '
        .$this->table3.'.ist1, '.$this->table3.'.ist2, '.$this->table3.'.ist3, '.$this->table3.'.ist4, '.$this->table5.'.name as nama_tkd');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table2.'.login = '.$this->table1.'.user1');
        $this->db->join($this->table5, $this->table2.'.kode_tkd_cuti = '.$this->table5.'.username','left');
        $this->db->join($this->table3, $this->table2.'.pola = '.$this->table3.'.pola');
        // $this->db->join($this->table5, $this->table2.'.keterangan = '.$this->table3.'.username', 'left');
        // $this->db->limit($limit, $start);
        $this->db->order_by($this->table2.".tgl_masuk, ".$this->table1.".user5, ".$this->table1.".user3, ".$this->table2.".pola, ".$this->table1.".user2, ".$this->table1.".user1, ".$this->table2.".keterangan", "asc");
        if($cari) {
            $this->db->like($this->table1.'.user2',$cari);
            $this->db->or_like($this->table1.'.user1',$cari);
        }

        if($date_awal) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) >=', $date_awal);
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
        }

        if($jabatan != NULL) {
            $this->db->where($this->table1.'.user3', $jabatan);
        }

		return $this->db->count_all_results();
	}

    function data_ccm_detail($id) {
        $this->db->select($this->table.'.username, '.$this->table.'.name, '.$this->table3.'.jabatan, '.$this->table3.'.tgl_mulai, '.$this->table3.'.tgl_akhir, '.$this->table3.'.pelanggaran, '.$this->table3.'.alasan, '.$this->table3.'.komitmen, '.$this->table3.'.verifikasi,'.$this->table3.'.penyuluhan,'.$this->table3.'.kronologis,'.$this->table3.'.kode,'.$this->table3.'.level');
        $this->db->from($this->table3);
        $this->db->join($this->table, $this->table.'.user_id = '.$this->table3.'.no_karywn');
        $this->db->join($this->table4, $this->table3.'.jenis = '.$this->table4.'.id');
        $this->db->where($this->table3.'.id',$id);
        return $this->db->get()->row();
    }

    function insert($data) {
		return $this->db->insert($this->table2, $data);
	}

	function update($id, $data) {
		$data_id = array('id' => $id);
		return $this->db->update($this->table2, $data, $data_id);
	}

	function get_id($where) {
		return $this->db->get_where($this->table2, $where)->row();
	}

	function delete($id) {
		$hapus_id = array("id" => $id);
		return $this->db->delete($this->table2, $hapus_id);
	}
    
    function getPola() {
        $this->db->distinct();
        $this->db->select('pola');
        $this->db->from($this->table6);
        $this->db->order_by($this->table6.".pola", "asc");
        return $this->db->get()->result();
    }
    
    function data_export_rooster($cari = null, $date_awal = null, $date_akhir = null, $jabatan = null){	
        $this->db->select(
            $this->table2.".id, ".
            $this->table2.".login, ".
            $this->table2.".nama, ".
            $this->table2.".area, ".
            $this->table2.".jabatan, 
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '01' THEN ".$this->table2.".pola END) AS 'tgl_01',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '02' THEN ".$this->table2.".pola END) AS 'tgl_02',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '03' THEN ".$this->table2.".pola END) AS 'tgl_03', 
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '04' THEN ".$this->table2.".pola END) AS 'tgl_04',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '05' THEN ".$this->table2.".pola END) AS 'tgl_05',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '06' THEN ".$this->table2.".pola END) AS 'tgl_06',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '07' THEN ".$this->table2.".pola END) AS 'tgl_07',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '08' THEN ".$this->table2.".pola END) AS 'tgl_08',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '09' THEN ".$this->table2.".pola END) AS 'tgl_09',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '10' THEN ".$this->table2.".pola END) AS 'tgl_10',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '11' THEN ".$this->table2.".pola END) AS 'tgl_11',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '12' THEN ".$this->table2.".pola END) AS 'tgl_12',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '13' THEN ".$this->table2.".pola END) AS 'tgl_13',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '14' THEN ".$this->table2.".pola END) AS 'tgl_14',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '15' THEN ".$this->table2.".pola END) AS 'tgl_15',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '16' THEN ".$this->table2.".pola END) AS 'tgl_16',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '17' THEN ".$this->table2.".pola END) AS 'tgl_17',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '18' THEN ".$this->table2.".pola END) AS 'tgl_18',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '19' THEN ".$this->table2.".pola END) AS 'tgl_19',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '20' THEN ".$this->table2.".pola END) AS 'tgl_20', 
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '21' THEN ".$this->table2.".pola END) AS 'tgl_21',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '22' THEN ".$this->table2.".pola END) AS 'tgl_22',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '23' THEN ".$this->table2.".pola END) AS 'tgl_23',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '24' THEN ".$this->table2.".pola END) AS 'tgl_24',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '25' THEN ".$this->table2.".pola END) AS 'tgl_25',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '26' THEN ".$this->table2.".pola END) AS 'tgl_26',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '27' THEN ".$this->table2.".pola END) AS 'tgl_27',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '28' THEN ".$this->table2.".pola END) AS 'tgl_28',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '29' THEN ".$this->table2.".pola END) AS 'tgl_29',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '30' THEN ".$this->table2.".pola END) AS 'tgl_30',
            MAX(CASE WHEN DAY(".$this->table2.".tgl_masuk) = '31' THEN ".$this->table2.".pola END) AS 'tgl_31'
        ");
        $this->db->from($this->table2);
        $this->db->group_by($this->table2.'.login'); 
        $this->db->order_by($this->table2.".tgl_masuk, ".$this->table2.".nama, ".$this->table2.".area", "asc");
        if($cari !== NULL) {
            $this->db->like($this->table2.'.user2',$cari);
            $this->db->or_like($this->table2.'.user1',$cari);
        }

        if($date_awal !== NULL) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) >=', $date_awal);
                $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
            }
        }

        if($date_akhir !== NULL) {
            $this->db->where('DATE('.$this->table2.'.tgl_masuk) <=', $date_akhir);
        }

        if($jabatan !== NULL) {
            $this->db->where($this->table2.'.jabatan', $jabatan);
        }

		return $this->db->get()->result();
	}

    function data_export_rooster_asli($cari = null, $date_awal = null, $date_akhir = null, $jabatan = null){	
        $this->db->select(
            $this->table7.".id, ".
            $this->table7.".login, ".
            $this->table7.".nama, ".
            $this->table7.".area, ".
            $this->table7.".jabatan, 
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '01' THEN ".$this->table7.".pola END) AS 'tgl_01',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '02' THEN ".$this->table7.".pola END) AS 'tgl_02',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '03' THEN ".$this->table7.".pola END) AS 'tgl_03', 
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '04' THEN ".$this->table7.".pola END) AS 'tgl_04',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '05' THEN ".$this->table7.".pola END) AS 'tgl_05',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '06' THEN ".$this->table7.".pola END) AS 'tgl_06',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '07' THEN ".$this->table7.".pola END) AS 'tgl_07',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '08' THEN ".$this->table7.".pola END) AS 'tgl_08',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '09' THEN ".$this->table7.".pola END) AS 'tgl_09',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '10' THEN ".$this->table7.".pola END) AS 'tgl_10',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '11' THEN ".$this->table7.".pola END) AS 'tgl_11',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '12' THEN ".$this->table7.".pola END) AS 'tgl_12',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '13' THEN ".$this->table7.".pola END) AS 'tgl_13',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '14' THEN ".$this->table7.".pola END) AS 'tgl_14',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '15' THEN ".$this->table7.".pola END) AS 'tgl_15',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '16' THEN ".$this->table7.".pola END) AS 'tgl_16',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '17' THEN ".$this->table7.".pola END) AS 'tgl_17',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '18' THEN ".$this->table7.".pola END) AS 'tgl_18',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '19' THEN ".$this->table7.".pola END) AS 'tgl_19',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '20' THEN ".$this->table7.".pola END) AS 'tgl_20', 
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '21' THEN ".$this->table7.".pola END) AS 'tgl_21',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '22' THEN ".$this->table7.".pola END) AS 'tgl_22',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '23' THEN ".$this->table7.".pola END) AS 'tgl_23',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '24' THEN ".$this->table7.".pola END) AS 'tgl_24',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '25' THEN ".$this->table7.".pola END) AS 'tgl_25',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '26' THEN ".$this->table7.".pola END) AS 'tgl_26',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '27' THEN ".$this->table7.".pola END) AS 'tgl_27',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '28' THEN ".$this->table7.".pola END) AS 'tgl_28',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '29' THEN ".$this->table7.".pola END) AS 'tgl_29',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '30' THEN ".$this->table7.".pola END) AS 'tgl_30',
            MAX(CASE WHEN DAY(".$this->table7.".tgl_masuk) = '31' THEN ".$this->table7.".pola END) AS 'tgl_31'
        ");
        $this->db->from($this->table7);
        $this->db->group_by($this->table7.'.login'); 
        $this->db->order_by($this->table7.".tgl_masuk, ".$this->table7.".nama, ".$this->table7.".area", "asc");
        if($cari !== NULL) {
            $this->db->like($this->table7.'.user2',$cari);
            $this->db->or_like($this->table7.'.user1',$cari);
        }

        if($date_awal !== NULL) {
            $this->db->where('DATE('.$this->table7.'.tgl_masuk) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table7.'.tgl_masuk) >=', $date_awal);
                $this->db->where('DATE('.$this->table7.'.tgl_masuk) <=', $date_akhir);
            }
        }

        if($date_akhir !== NULL) {
            $this->db->where('DATE('.$this->table7.'.tgl_masuk) <=', $date_akhir);
        }

        if($jabatan !== NULL) {
            $this->db->where($this->table7.'.jabatan', $jabatan);
        }

		return $this->db->get()->result();
	}

    function getJabatan(){	
        $this->db->distinct();
        $this->db->select($this->table1.'.user3');
        $this->db->from($this->table1);
        $this->db->order_by($this->table1.".user3");
		return $this->db->get()->result();
	}

    function getPolaJam(){	
        // $this->db->distinct();
        // $this->db->select($this->table3.'.pola');
        $this->db->from($this->table3);
        $this->db->group_by($this->table3.'.pola');
        $this->db->order_by($this->table3.".pola");
		return $this->db->get()->result();
	}
}