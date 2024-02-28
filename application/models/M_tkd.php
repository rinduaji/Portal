<?php 
 
class M_tkd extends CI_Model{	

    // public $this->table = 'item_rooster';
    private $table1 = 'cc147_main_users_extended';
    private $table2 = 'app_roosterfix';
    private $table3 = 'app_master_pola';

    function data_pola($tanggal = null, $login = null, $jabatan = null) {	
        $this->db->from($this->table2);
        $this->db->where('tgl_masuk', $tanggal);
        $this->db->where('login', $login);
        $this->db->like('jabatan', $jabatan);
        $this->db->where('keterangan', NULL);
        return $this->db->get()->result();
    }

    function data_pola_tukar($tanggal = null, $login = null, $jabatan = null) {	
        $this->db->from($this->table2);
        $this->db->join($this->table3, $this->table2.'.pola = '.$this->table3.'.pola');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login <> ', $login);
        $this->db->like($this->table2.'.jabatan', $jabatan);
        $this->db->where($this->table2.'.keterangan', NULL);
        $this->db->group_by($this->table2.".pola");
        return $this->db->get()->result();
    }

    function data_rooster_tkd($tanggal = null, $login = null, $jabatan = null, $pola_tukar = null) {	
        $this->db->select($this->table2.'.id, '.$this->table2.'.tgl_masuk, '.$this->table1.'.user1, '.$this->table1.'.user2, '.$this->table1.'.user3, '.$this->table1.'.user5, '.$this->table2.'.pola');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login <> ', $login);
        $this->db->like($this->table1.'.user3', $jabatan);
        $this->db->where($this->table2.'.pola', $pola_tukar);
        
        $this->db->where($this->table2.'.keterangan', NULL);
        // $this->db->group_by($this->table2.".pola");
        return $this->db->get()->result();
    }

    function data_libur($tanggal = null, $login = null) {	
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk >= ', $tanggal);
        $this->db->where($this->table2.'.login', $login);
        return $this->db->get()->result();
    }

    function get_tkd_libur($tanggal, $login) {	
        $date_now = date("Y-m-d");
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk > ', $date_now);
        $this->db->where($this->table2.'.login', '770288');
        $this->db->where($this->table2.'.pola', 'X');
        
        $this->db->where($this->table2.'.keterangan', NULL);
        // $this->db->group_by($this->table2.".pola");
        // print_r($this->db->last_query());
        return $this->db->get()->result();
    }


    function data_report_rooster($cari = null, $date_awal = null, $date_akhir = null){	
        $this->db->select($this->table2.'.periode, '.$this->table1.'.user1, '.$this->table1.'.user2, '.$this->table1.'.user3, '.$this->table1.'.user5, '.$this->table2.'.keterangan, '.$this->table3.'.masuk, '.$this->table3.'.pulang, '.$this->table2.'.pola, '.$this->table2.'.tgl_masuk, '
        .$this->table3.'.ist1, '.$this->table3.'.ist2, '.$this->table3.'.ist3, '.$this->table3.'.ist4');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table2.'.login = '.$this->table1.'.user1');
        $this->db->join($this->table3, $this->table2.'.pola = '.$this->table3.'.pola');
        $this->db->order_by($this->table2.".tgl_masuk, ".$this->table1.".user5, ".$this->table1.".user3, ".$this->table1.".user2, ".$this->table1.".user1, ".$this->table2.".keterangan", "asc");
        if($cari) {
            $this->db->where($this->table1.'.user1',$cari);
        }

        if($date_awal) {
            $this->db->where('DATE('.$this->table1.'.tgl_masuk) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table1.'.tgl_masuk) >=', $date_awal);
                $this->db->where('DATE('.$this->table1.'.tgl_masuk) <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('DATE('.$this->table1.'.tgl_masuk) <=', $date_akhir);
        }

		return $this->db->get()->result();
	}

    public function getIdLibur($tgl,$login){
        $this->db->from($this->table2);
        $this->db->where('tgl_masuk', $tgl);
        $this->db->where('login', $login);
        return $this->db->get()->row();
    }

    public function updateTkdLibur($login_pemohon,$login_termohon,$tgl_libur_pemohon,$tgl_libur_termohon,$id_termohon,$id_pemohon,$idLibur1,$idLibur2) {
        $data_update1 = array(
                'keterangan' => 'ReqTKDLibur ('.$login_pemohon.') {'.$tgl_libur_pemohon.'}',
                'tkd_cuti' => 'TKD TERMOHON',
                'status_tkd_cuti' => 'PENDING',
                'key_tkd_cuti' => 'TKD LIBUR',
                'kode_tkd_cuti' =>$login_pemohon
            );
        $data_id1 = array(
                'id' => $id_termohon
            );

        $this->db->update($this->table2, $data_update1, $data_id1);

        $data_update2 = array(
                'keterangan' => 'ReqTKDLibur ('.$login_termohon.') {'.$tgl_libur_pemohon.'}',
                'tkd_cuti' => 'TKD PEMOHON',
                'status_tkd_cuti' => 'PENDING',
                'key_tkd_cuti' => 'TKD LIBUR',
                'kode_tkd_cuti' =>$login_termohon
            );
        $data_id2 = array(
                'id' => $id_pemohon
            );
            
        $this->db->update($this->table2, $data_update2, $data_id2);

        $data_update3 = array(
                'keterangan' => 'ReqTKDLibur ('.$login_termohon.') {'.$tgl_libur_termohon.'}',
                'tkd_cuti' => 'TKD PEMOHON',
                'status_tkd_cuti' => 'PENDING',
                'key_tkd_cuti' => 'TKD LIBUR',
                'kode_tkd_cuti' =>$login_termohon
            );
        $data_id3 = array(
                'id' => $idLibur1
            );
            
        $this->db->update($this->table2, $data_update3, $data_id3);

        $data_update4 = array(
                'keterangan' => 'ReqTKDLibur ('.$login_pemohon.') {'.$tgl_libur_termohon.'}',
                'tkd_cuti' => 'TKD TERMOHON',
                'status_tkd_cuti' => 'PENDING',
                'key_tkd_cuti' => 'TKD LIBUR',
                'kode_tkd_cuti' =>$login_pemohon
            );
        $data_id4 = array(
                'id' => $idLibur2
            );
            
        return $this->db->update($this->table2, $data_update4, $data_id4);
    }

    public function updateTkd($login_pemohon,$login_termohon,$id_termohon,$id_pemohon) {
        $data_update1 = array(
            'keterangan' => 'ReqTKD ('.$login_pemohon.')',
            'tkd_cuti' => 'TKD TERMOHON',
            'status_tkd_cuti' => 'PENDING',
            'key_tkd_cuti' => 'TKD',
            'kode_tkd_cuti' =>$login_pemohon
        );
        $data_id1 = array(
                'id' => $id_termohon
            );
            
        $this->db->update($this->table2, $data_update1, $data_id1);

        $data_update2 = array(
                'keterangan' => 'ReqTKD ('.$login_termohon.')',
                'tkd_cuti' => 'TKD PEMOHON',
                'status_tkd_cuti' => 'PENDING',
                'key_tkd_cuti' => 'TKD',
                'kode_tkd_cuti' =>$login_termohon
            );
        $data_id2 = array(
                'id' => $id_pemohon
            );
            
        return $this->db->update($this->table2, $data_update2, $data_id2);
    }

    function get_data_approve_tkd($tanggal, $login) {	
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login', $login);
        $this->db->where($this->table2.'.keterangan <> ', '');
        // $this->db->group_by($this->table2.".pola");
        return $this->db->get()->result();
    }

    function total_data_approve_tkd($tanggal, $login) {	
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login', $login);
        $this->db->where($this->table2.'.keterangan <> ', '');
        // $this->db->group_by($this->table2.".pola");
        return $this->db->count_all_results();
    }

    function get_data_approve_tkd_cek_termohon($tanggal, $login) {	
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login', $login);
        $this->db->where($this->table2.'.keterangan <> ', '');
        $this->db->where($this->table2.'.tkd_cuti', 'TKD TERMOHON');
        // $this->db->group_by($this->table2.".pola");
        return $this->db->get()->result();
    }

    function total_data_approve_tkd_cek_termohon($tanggal, $login) {	
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.user1 = '.$this->table2.'.login');
        $this->db->where($this->table2.'.tgl_masuk', $tanggal);
        $this->db->where($this->table2.'.login', $login);
        $this->db->where($this->table2.'.keterangan <> ', '');
        $this->db->where($this->table2.'.tkd_cuti', 'TKD TERMOHON');
        // $this->db->group_by($this->table2.".pola");
        return $this->db->count_all_results();
    }

    public function updateApproveTkd($login_pemohon1,$login_termohon1,$polaPemohon1,$polaTermohon1,$tanggal_app1,$login_pemohon2,$login_termohon2,$polaPemohon2,$polaTermohon2,$tanggal_app2) {
        $data_update1 = array(
            'keterangan' => $login_termohon1,
            'pola' => $polaPemohon1,
            'status_tkd_cuti' => 'DONE',
            'kode_tkd_cuti' => $login_termohon1
        );
        $data_id1 = array(
                'login' => $login_pemohon1,
                'tgl_masuk' => $tanggal_app1
            );
            
        $this->db->update($this->table2, $data_update1, $data_id1);

        $data_update2 = array(
            'keterangan' => $login_pemohon1,
            'pola' => $polaTermohon1,
            'status_tkd_cuti' => 'DONE',
            'kode_tkd_cuti' => $login_pemohon1
        );
        $data_id2 = array(
                'login' => $login_termohon1,
                'tgl_masuk' => $tanggal_app1
            );
            
        $this->db->update($this->table2, $data_update2, $data_id2);
        
        if($login_pemohon2 != NULL) {
            $data_update3 = array(
                'keterangan' => $login_termohon2,
                'pola' => $polaPemohon2,
                'status_tkd_cuti' => 'DONE',
                'kode_tkd_cuti' => $login_termohon1
            );
            $data_id3 = array(
                    'login' => $login_pemohon2,
                    'tgl_masuk' => $tanggal_app2
                );
                
            $this->db->update($this->table2, $data_update3, $data_id3);

            $data_update4 = array(
                'keterangan' => $login_pemohon2,
                'pola' => $polaTermohon2,
                'status_tkd_cuti' => 'DONE',
                'kode_tkd_cuti' => $login_pemohon2
            );
            $data_id4 = array(
                    'login' => $login_termohon2,
                    'tgl_masuk' => $tanggal_app2
                );
                
            $this->db->update($this->table2, $data_update4, $data_id4);
        }
        return true;
    }

    public function updateRejectTkd($login_pemohon1,$login_termohon1,$polaPemohon1,$polaTermohon1,$tanggal_app1,$login_pemohon2,$login_termohon2,$polaPemohon2,$polaTermohon2,$tanggal_app2) {
        $data_update1 = array(
            'keterangan' => NULL,
            'status_tkd_cuti' => NULL,
            'kode_tkd_cuti' => NULL,
            'tkd_cuti' => NULL,
            'key_tkd_cuti' => NULL
        );
        $data_id1 = array(
                'login' => $login_pemohon1,
                'tgl_masuk' => $tanggal_app1
            );
            
        $this->db->update($this->table2, $data_update1, $data_id1);

        $data_update2 = array(
            'keterangan' => NULL,
            'status_tkd_cuti' => NULL,
            'kode_tkd_cuti' => NULL,
            'tkd_cuti' => NULL,
            'key_tkd_cuti' => NULL
        );
        $data_id2 = array(
                'login' => $login_termohon1,
                'tgl_masuk' => $tanggal_app1
            );
            
        $this->db->update($this->table2, $data_update2, $data_id2);
        
        if($login_pemohon2 != NULL) {
            $data_update3 = array(
                'keterangan' => NULL,
                'status_tkd_cuti' => NULL,
                'kode_tkd_cuti' => NULL,
                'tkd_cuti' => NULL,
                'key_tkd_cuti' => NULL
            );
            $data_id3 = array(
                    'login' => $login_pemohon2,
                    'tgl_masuk' => $tanggal_app2
                );
                
            $this->db->update($this->table2, $data_update3, $data_id3);

            $data_update4 = array(
                'keterangan' => NULL,
                'status_tkd_cuti' => NULL,
                'kode_tkd_cuti' => NULL,
                'tkd_cuti' => NULL,
                'key_tkd_cuti' => NULL
            );
            $data_id4 = array(
                    'login' => $login_termohon2,
                    'tgl_masuk' => $tanggal_app2
                );
                
            $this->db->update($this->table2, $data_update4, $data_id4);
        }
        return true;
    }
}