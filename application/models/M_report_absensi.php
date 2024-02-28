<?php 
 
class M_report_absensi extends CI_Model{	

    // public $this->table = 'item_absensi';
    private $table1 = 'app_absen';
    private $table2 = 'cc147_main_users_extended';
    private $table3 = 'app_roosterfix';
    private $table4 = 'app_master_pola';

    // function nama_absensi_kategori(){	
	// 	return $this->db->get_where($this->table2, array('status'=>'AKTIF'))->result();
	// }

    // function judul_nama_absensi_kategori($id_kategori){	
    //     $this->db->select('nama_kategori');
	// 	return $this->db->get_where($this->table2, array('id_kategori'=>$id_kategori))->row();
	// }

    function data_report_absensi($cari = null, $date_awal = null, $date_akhir = null, $jabatan = NULL, $username = NULL){	
        $this->db->select($this->table1.'.date_absen, '.$this->table2.'.user1, '.$this->table2.'.user2, '.$this->table2.'.user3, '.$this->table2.'.user5, '.$this->table1.'.keterangan, '.$this->table4.'.masuk, '.$this->table4.'.pulang, '.$this->table3.'.pola, '.$this->table3.'.tgl_masuk');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.username = '.$this->table2.'.user1');
        $this->db->join($this->table3, $this->table1.'.id_rooster = '.$this->table3.'.id');
        $this->db->join($this->table4, $this->table3.'.pola = '.$this->table4.'.pola');
        $this->db->order_by($this->table3.".tgl_masuk, ".$this->table2.".user5, ".$this->table2.".user3, ".$this->table2.".user2, ".$this->table2.".user1, ".$this->table1.".keterangan", "asc");
        if($cari) {
            $this->db->where($this->table1.'.username',$cari);
        }

        if($date_awal) {
            $this->db->where('DATE('.$this->table1.'.date_absen) >= ', $date_awal);
            if($date_akhir) {
                $this->db->where('DATE('.$this->table1.'.date_absen) >=', $date_awal);
                $this->db->where('DATE('.$this->table1.'.date_absen) <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('DATE('.$this->table1.'.date_absen) <=', $date_akhir);
        }

        if($jabatan != 'ADMIN' && $jabatan != 'DUKTEK') {
            // print_r($jabatan);
            $this->db->where($this->table2.'.user1', $username);
        }

		return $this->db->get()->result();
	}
}