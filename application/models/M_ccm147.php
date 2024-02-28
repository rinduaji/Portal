<?php 
 
class M_ccm147 extends CI_Model{	

    public $table1 = 'app_ccm_147';
    public $table2 = 'app_ccm_kat_147';
    public $table3 = 'app_ccm_proses_147';
    public $table4 = 'cc147_main_users';
    public $table5 = 'cc147_main_users_extended';
    public $table6 = 'notifikasi';
    public $table7 = 'app_ccm_kat_tl';
    public $table8 = 'app_ccm_kat_qc';
    public $table9 = 'app_ccm_kat_spv';
    public $table10 = 'app_ccm_kat_support';

	public function rules()
    {
        return [
            ['field' => 'upd',
            'label' => 'UPD',
            'rules' => 'required'],

            ['field' => 'pilih_jabatan',
            'label' => 'Pilih Jabatan',
            'rules' => 'required'],

            ['field' => 'pilih_kategori',
            'label' => 'Pilih Kategori',
            'rules' => 'required'],

            ['field' => 'pilih_agent',
            'label' => 'Pilih Agent',
            'rules' => 'required'],

            ['field' => 'alasan',
            'label' => 'Alasan',
            'rules' => 'required'],

            ['field' => 'detail_kategori',
            'label' => 'Detail Kategori',
            'rules' => 'required'],
        ];
    }
    
    public function setIdCCM() {
        $this->db->select('MAX(id) as id');
        $this->db->from($this->table1);
		return $this->db->get()->row();
    }

    public function list_jabatan_agent($jabatan) {
        $this->db->select('DISTINCT(user3)');
        $this->db->from($this->table5);
        if($jabatan == 'INPUTER' || $jabatan == "SUPPORT" || $jabatan == "SOO") {
            $this->db->where('user3', $jabatan);
        }
        else {
            $this->db->like('user3', $jabatan);
        }

        if($jabatan == 'SUPERVISOR') {
            $this->db->or_like('user3', 'QA');
        }
		return $this->db->get()->result();
    }

    public function list_jabatan_support($jabatan1,$jabatan2,$jabatan3,$jabatan4,$jabatan5,$jabatan6) {
        $this->db->select('DISTINCT(user3)');
        $this->db->from($this->table5);
        // if($jabatan == 'INPUTER') {
        $this->db->where('user3', $jabatan1);
        $this->db->or_where('user3', $jabatan2);
        $this->db->or_where('user3', $jabatan3);
        $this->db->or_where('user3', $jabatan4);
        $this->db->or_where('user3', $jabatan5);
        $this->db->or_where('user3', $jabatan6);

        // }
        // else {
        //     $this->db->like('user3', $jabatan);
        // }

        // if($jabatan == 'SUPERVISOR') {
        //     $this->db->or_like('user3', 'QA');
        // }
		return $this->db->get()->result();
    }

    public function list_kategori() {
        $this->db->select('DISTINCT(kategori), id_kat');
        $this->db->from($this->table2);
        $this->db->order_by('kategori','ASC');
		return $this->db->get()->result();
    }

    public function list_detail_kategori($id_kat) {
        $this->db->from($this->table2);
        $this->db->where('id_kat',$id_kat);
        $this->db->order_by('detail','ASC');
		return $this->db->get()->result();
    }

    public function list_kategori_tl() {
        $this->db->select('DISTINCT(kategori), id_kat');
        $this->db->from($this->table7);
        $this->db->order_by('kategori','ASC');
		return $this->db->get()->result();
    }

    public function list_detail_kategori_tl($id_kat) {
        $this->db->from($this->table7);
        $this->db->where('id_kat',$id_kat);
        $this->db->order_by('detail','ASC');
		return $this->db->get()->result();
    }

    public function list_kategori_qc() {
        $this->db->select('DISTINCT(kategori), id_kat');
        $this->db->from($this->table8);
        $this->db->order_by('kategori','ASC');
		return $this->db->get()->result();
    }

    public function list_detail_kategori_qc($id_kat) {
        $this->db->from($this->table8);
        $this->db->where('id_kat',$id_kat);
        $this->db->order_by('detail','ASC');
		return $this->db->get()->result();
    }

    public function list_kategori_spv() {
        $this->db->select('DISTINCT(kategori), id_kat');
        $this->db->from($this->table9);
        $this->db->order_by('kategori','ASC');
		return $this->db->get()->result();
    }

    public function list_detail_kategori_spv($id_kat) {
        $this->db->from($this->table9);
        $this->db->where('id_kat',$id_kat);
        $this->db->order_by('detail','ASC');
		return $this->db->get()->result();
    }

    public function list_kategori_support() {
        $this->db->select('DISTINCT(kategori), id_kat');
        $this->db->from($this->table10);
        $this->db->order_by('kategori','ASC');
		return $this->db->get()->result();
    }

    public function list_detail_kategori_support($id_kat) {
        $this->db->from($this->table10);
        $this->db->where('id_kat',$id_kat);
        $this->db->order_by('detail','ASC');
		return $this->db->get()->result();
    }

    public function getDetail($id) {
        $this->db->from($this->table2);
        $this->db->where('id',$id);
        // $this->db->order_by('detail','ASC');
		return $this->db->get()->row();
    }

    public function getDetailInputer($id) {
        $this->db->from($this->table10);
        $this->db->where('id',$id);
        // $this->db->order_by('detail','ASC');
		return $this->db->get()->row();
    }

    public function getDetailTl($id) {
        $this->db->from($this->table7);
        $this->db->where('id',$id);
        // $this->db->order_by('detail','ASC');
		return $this->db->get()->row();
    }

    public function getDetailSpv($id) {
        $this->db->from($this->table9);
        $this->db->where('id',$id);
        // $this->db->order_by('detail','ASC');
		return $this->db->get()->row();
    }

    public function getIdSpvTl($username) {
        $this->db->from($this->table4);
        $this->db->where('username',$username);
        // $this->db->order_by('detail','ASC');
		return $this->db->get()->row();
    }

    public function nama_jabatan_agent($username) {
        $this->db->from($this->table4);
        $this->db->join($this->table5, $this->table4.'.username = '.$this->table5.'.user1');
		$this->db->where('username',$username);
        $this->db->order_by('name','ASC');
		return $this->db->get()->row();
    }

    public function list_nama_jabatan_agent($jabatan) {
        $this->db->from($this->table4);
        $this->db->join($this->table5, $this->table4.'.username = '.$this->table5.'.user1');
		$this->db->where('user3',$jabatan);
        $this->db->where('user1 <> ',''); 
        $this->db->where('user1 <> ','RESIGN'); 
        $this->db->where('user1 <> ','resign'); 
        $this->db->order_by('name','ASC');
		return $this->db->get()->result();
    }

    public function getUserId($username) {
        $this->db->select($this->table4.'.user_id');
        $this->db->from($this->table4);
        $this->db->join($this->table5, $this->table4.'.username = '.$this->table5.'.user1');
		$this->db->where($this->table4.'.username',$username);
        return $this->db->get()->row();
    }

    public function getKodeDetailKategori($id_detail_kategori,$jb) {
        if($jb == "TL") { 
            $this->db->select($this->table7.'.kode, '.$this->table7.'.id_kat, '.$this->table7.'.level');
            $this->db->from($this->table7);
            $this->db->where($this->table7.'.id',$id_detail_kategori);
        }
        elseif($jb == "SUPERVISOR"){
            $this->db->select($this->table9.'.kode, '.$this->table9.'.id_kat, '.$this->table9.'.level');
            $this->db->from($this->table9);
            $this->db->where($this->table9.'.id',$id_detail_kategori);
        }
        elseif($jb == "AGENT"){
            $this->db->select($this->table2.'.kode, '.$this->table2.'.id_kat, '.$this->table2.'.level');
            $this->db->from($this->table2);
            $this->db->where($this->table2.'.id',$id_detail_kategori);
        }
        elseif($jb == "INPUTER" || $jb == "SUPPORT" || $jb == "SOO"){
            $this->db->select($this->table10.'.kode, '.$this->table10.'.id_kat, '.$this->table10.'.level');
            $this->db->from($this->table10);
            $this->db->where($this->table10.'.id',$id_detail_kategori);
        }
        
        return $this->db->get()->row();
    }

    public function totalKategori($jb) {
        if($jb == "TL") { 
            $this->db->distinct();
            $this->db->select($this->table7.'.id_kat');
            $this->db->from($this->table7);
        }
        elseif($jb == "SUPERVISOR"){
            $this->db->distinct();
            $this->db->select($this->table9.'.id_kat');
            $this->db->from($this->table9);
        }
        elseif($jb == "AGENT"){
            $this->db->distinct();
            $this->db->select($this->table2.'.id_kat');
            $this->db->from($this->table2);
        }
        elseif($jb == "INPUTER" || $jb == "SUPPORT" || $jb == "SOO"){
            $this->db->distinct();
            $this->db->select($this->table10.'.id_kat');
            $this->db->from($this->table10);
        }
        
        return $this->db->get()->result();
    }

    public function total_data_sp_aktif($no_karyawan, $tgl_sekarang) {
        $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.jenis = '.$this->table2.'.id');
        $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
		$this->db->where($this->table1.'.kode','sp');
        $this->db->where($this->table1.'.tgl_mulai <= ', $tgl_sekarang);
        $this->db->where($this->table1.'.tgl_akhir >= ', $tgl_sekarang);
        $this->db->order_by($this->table1.'.level','DESC');
		return $this->db->get()->row();
    }

    public function total_data_sp_tidak_aktif($no_karyawan, $tgl_sekarang) {
        $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
        $this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.jenis = '.$this->table2.'.id');
        $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
		$this->db->where($this->table1.'.kode','sp');
        $this->db->where($this->table1.'.tgl_akhir <= ', $tgl_sekarang);
        $this->db->order_by($this->table1.'.level','DESC');
		return $this->db->get()->row();
    }

    public function total_data_kat_aktif($no_karyawan, $tgl_sekarang, $id_kat, $kode, $jb) {
        if($jb == "TL") { 
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table7, $this->table1.'.jenis = '.$this->table7.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table7.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_mulai <= ', $tgl_sekarang);
            $this->db->where($this->table1.'.tgl_akhir >= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "SUPERVISOR"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table9, $this->table1.'.jenis = '.$this->table9.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table9.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_mulai <= ', $tgl_sekarang);
            $this->db->where($this->table1.'.tgl_akhir >= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "AGENT"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table2, $this->table1.'.jenis = '.$this->table2.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table2.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_mulai <= ', $tgl_sekarang);
            $this->db->where($this->table1.'.tgl_akhir >= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "INPUTER" || $jb == "SUPPORT" || $jb == "SOO"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table10, $this->table1.'.jenis = '.$this->table10.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table10.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_mulai <= ', $tgl_sekarang);
            $this->db->where($this->table1.'.tgl_akhir >= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
		return $this->db->get()->row();
    }

    public function total_data_kat_tidak_aktif($no_karyawan, $tgl_sekarang, $id_kat, $kode, $jb) {
        if($jb == "TL") { 
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table7, $this->table1.'.jenis = '.$this->table7.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table7.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_akhir <= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "SUPERVISOR"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table9, $this->table1.'.jenis = '.$this->table9.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table9.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_akhir <= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "AGENT"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table2, $this->table1.'.jenis = '.$this->table2.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table2.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_akhir <= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        elseif($jb == "INPUTER" || $jb == "SUPPORT" || $jb == "SOO"){
            $this->db->select($this->table1.'.kode, MAX('.$this->table1.'.level) as max_level');
            $this->db->from($this->table1);
            $this->db->join($this->table10, $this->table1.'.jenis = '.$this->table10.'.id');
            $this->db->where($this->table1.'.no_karywn ', $no_karyawan);
            $this->db->where($this->table1.'.kode ', $kode);
            $this->db->where($this->table10.'.id_kat', $id_kat);
            $this->db->where($this->table1.'.tgl_akhir <= ', $tgl_sekarang);
            $this->db->order_by($this->table1.'.level','DESC');
        }
        
		return $this->db->get()->row();
    }

    function insert($data) {
		return $this->db->insert($this->table1, $data);
	}

    function insertNotif($data) {
		return $this->db->insert($this->table6, $data);
	}
	// public function rules()
    // {
    //     return [
    //         ['field' => 'judul',
    //         'label' => 'Judul Berita',
    //         'rules' => 'required'],

    //         ['field' => 'topik',
    //         'label' => 'Topik Berita',
    //         'rules' => 'required'],

    //         ['field' => 'status',
    //         'label' => 'Status',
    //         'rules' => 'required'],

    //         ['field' => 'short_description',
    //         'label' => 'Short Description',
    //         'rules' => 'required'],

    //     ];
    // }

	// function data_cmm147($limit ,$start ,$cari = null, $date_awal = null, $date_akhir = null){	
    //     $this->db->from($this->table);
    //     $this->db->limit($limit, $start);
    //     $this->db->order_by("tanggal, judul", "desc");
    //     if($cari) {
    //         $this->db->like('judul',$cari);
    //     }

    //     if($date_awal) {
    //         $this->db->where('tanggal >=', $date_awal);
    //         if($date_akhir) {
    //             $this->db->where('tanggal >=', $date_awal);
    //             $this->db->where('tanggal <=', $date_akhir);
    //         }
    //     }

    //     if($date_akhir) {
    //         $this->db->where('tanggal <=', $date_akhir);
    //     }

	// 	return $this->db->get()->result();
	// }

    // function jumlah_data($cari = null, $date_awal = null, $date_akhir = null){	
    //     $this->db->from($this->table);
    //     $this->db->order_by("tanggal, judul", "desc");
    //     if($cari) {
    //         $this->db->like('judul',$cari);
    //     }

    //     if($date_awal) {
    //         $this->db->where('tanggal >=', $date_awal);
    //         if($date_akhir) {
    //             $this->db->where('tanggal >=', $date_awal);
    //             $this->db->where('tanggal <=', $date_akhir);
    //         }
    //     }

    //     if($date_akhir) {
    //         $this->db->where('tanggal <=', $date_akhir);
    //     }

	// 	return $this->db->count_all_results();
	// }

	// function insert($data) {
	// 	return $this->db->insert($this->table, $data);
	// }

	// function update($id, $data) {
	// 	$data_id = array('id_cmm147' => $id);
	// 	return $this->db->update($this->table, $data, $data_id);
	// }

	// function get_id($id) {
    //     $this->db->from($this->table);
    //     $this->db->where('id_cmm147',$id);
	// 	return $this->db->get()->row();
	// }

	// function delete($id) {
	// 	$hapus_id = array("id_cmm147" => $id);
	// 	return $this->db->delete($this->table, $hapus_id);
	// }
}