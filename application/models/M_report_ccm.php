<?php 
 
class M_report_ccm extends CI_Model{	

    public $table = 'cc147_main_users';
    public $table2 = 'cc147_main_users_extended';
    public $table3 = 'app_ccm_147';
    public $table4 = 'app_ccm_kat_147';
    public $table5 = 'groupmail';
    public $table6 = 'app_ccm_kat_tl';
    public $table7 = 'app_ccm_kat_spv';
    public $table8 = 'app_ccm_kat_support';

    public function rules()
    {
        return [
            ['field' => 'tgl_mulai',
            'label' => 'Tanggal Mulai',
            'rules' => 'required'],
    
            ['field' => 'tgl_akhir',
            'label' => 'Tanggal Akhir',
            'rules' => 'required'],

            ['field' => 'kode',
            'label' => 'Kode',
            'rules' => 'required'],
    
            ['field' => 'level',
            'label' => 'Level',
            'rules' => 'required'],
        ];
    }	

	function cekJabatanIdCCM($id){	
        $this->db->from($this->table3);
        $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.user_id');
        $this->db->where($this->table3.'.id',$id);	
		return $this->db->get()->row();
	}

    function cekJabatanIdKaryawan($id){	
        $this->db->from($this->table3);
        $this->db->join($this->table2.' AS a', $this->table3.'.no_karywn = a.user_id');
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

	function data_list_ccm($user_id,$jb,$start,$cari = null, $date_awal = null, $date_akhir = null,$username = NULL, $jabatan = NULL, $approve_ver = NULL){	
        $this->db->select('a.tgl_verifi,a.id, b.username, b.name, f.user3, d.user2, f.user5, a.tgl_mulai, a.tgl_akhir, a.kode, a.status, a.level, a.spv, b.user_id as id_anak, b.`name` as nama_anak, c.user_id as id_tl, c.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
        $this->db->from($this->table3.' AS a');
        $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
        $this->db->join($this->table2.' AS c', 'a.spv = c.user_id');
        $this->db->join($this->table2.' AS f', 'a.no_karywn = f.user_id ');
        $this->db->join($this->table2.' AS d', 'b.spv = d.user_id', 'left');
        $this->db->join($this->table2.' AS e', 'b.manager = e.user_id', 'left');
        // $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.id');
          if($jb == "AGENT" || $jb == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
                $this->db->where('b.user_id',$user_id);
                // $this->db->where('a.status','0');
                // $this->db->join($this->table5, $this->table3.'.no_karywn = '.$this->table5.'.id_anak');
                    // $this->db->where($this->table5.'.id_anak',$user_id);
            }
            else if($jb == "TL") {
                // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.spv');
                // $this->db->where('b.tl',$username);
                if($jabatan == NULL) {
                    $this->db->like('f.user3','AGENT');
                    $this->db->or_like('f.user3','INPUTER');
                    $this->db->or_like('f.user3','SUPPORT');
                    $this->db->or_like('f.user3','SOO');
                }
                // $this->db->join($this->table5, $this->table.'.tl = '.$this->table5.'.id_tl');
                // $this->db->where($this->table5.'.id_tl',$user_id);
            //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
            //     // $this->db->where($this->table5.'.id_sp',$user_id);
            }
            else if($jb == "SUPERVISOR") {
                // print_r($user_id);
                // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
                // $this->db->where('b.spv',$username);
                if($jabatan == NULL) {
                $this->db->like('f.user3','TL');
                $this->db->or_like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
                }
                // $this->db->or_where('a.no_karywn',$user_id);
                // $this->db->where('a.status','2');
                // $this->db->or_where('a.status','4');
                    // $this->db->join($this->table5, $this->table.'.spv = '.$this->table5.'.id_spv');
                    // $this->db->where($this->table5.'.id_spv',$user_id);
                //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
                //     // $this->db->where($this->table5.'.id_spv',$user_id);
            }
            else if($jb == "MANAGER") {
                // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
                // $this->db->where('b.manager',$username);
                if($jabatan == NULL) {
                    $this->db->like('f.user3','SUPERVISOR');
                    $this->db->or_like('f.user3','TL');
                    $this->db->or_like('f.user3','AGENT');
                    $this->db->or_like('f.user3','INPUTER');
                    $this->db->or_like('f.user3','SUPPORT');
                    $this->db->or_like('f.user3','SOO');
                }
                // $this->db->where('a.status','3');
                // $this->db->or_where('a.status','4');
                    // $this->db->join($this->table5, $this->table.'.manager = '.$this->table5.'.id_manager');
                    // $this->db->where($this->table5.'.id_'.strtolower($jb),$user_id);
            }
        // $this->db->where($this->table3.'.spv',$user_id);
        // $this->db->or_where($this->table3.'.no_karywn',$user_id);

        // $this->db->limit($limit, $start);
        $this->db->group_by('a.id');
        $this->db->order_by("f.user3 DESC, b.name ASC, a.tgl_mulai DESC");
        if($cari) {
            $this->db->like('b.name',$cari);
            $this->db->or_like('b.username',$cari);
        }

        if($date_awal) {
            $this->db->where('a.tgl_mulai >=', $date_awal);
            if($date_akhir) {
                $this->db->where('a.tgl_akhir <=', $date_akhir);
                $date = $date_akhir;
            }
            else {
                $date = date("Y-m-d");
            }
        }

        if($date_akhir) {
            $this->db->where('a.tgl_akhir <=', $date_akhir);
            $date = $date_akhir;
        }
        else {
            $date = date("Y-m-d");
        }

        if($jabatan != NULL || $jabatan != '') {
            $this->db->where('f.user3',$jabatan);
        }
        
        $array_approve = array();
        
        if($jb == 'AGENT' || $jb == 'INPUTER' || $jb == 'SUPPORT' || $jb == 'SOO'){
            $array_approve = array('0');
        }
        elseif($jb == 'TL') {
            $array_approve = array('1');
        }
        elseif($jb == 'SUPERVISOR') {
            $array_approve = array('2');
        }
        elseif($jb == 'MANAGER') {
            $array_approve = array('3');
        }

        if($approve_ver == 'APPROVE') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where_in('a.status', $array_approve);
        }
        elseif($approve_ver == 'VERIFIKASI') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status', '4');
        }
        elseif($approve_ver == 'TIDAK AKTIF') {
            $this->db->where('a.tgl_akhir <=', $date);
            // $this->db->where('a.status','5');
        }
        elseif($approve_ver == 'AKTIF') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status <= ','4');
        }
        // print_r($this->db->last_query());
		return $this->db->get()->result();
	}

    function jumlah_data($user_id,$jb,$cari = null, $date_awal = null, $date_akhir = null,$username = NULL, $jabatan = NULL, $approve_ver = NULL){	
        $this->db->select('a.tgl_verifi,a.id, b.username, b.name, f.user3, f.user2, a.tgl_mulai, a.tgl_akhir, a.kode, a.status, a.level, a.spv, b.user_id as id_anak, b.`name` as nama_anak, c.user_id as id_tl, c.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
        $this->db->from($this->table3.' AS a');
        $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
        $this->db->join($this->table2.' AS c', 'a.spv = c.user_id');
        $this->db->join($this->table2.' AS f', 'a.no_karywn = f.user_id ');
        $this->db->join($this->table2.' AS d', 'b.spv = d.user_id', 'left');
        $this->db->join($this->table2.' AS e', 'b.manager = e.user_id', 'left');
        // $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.id');
        if($jb == "AGENT" || $jb == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
            $this->db->where('b.user_id',$user_id);
            // $this->db->where('a.status','0');
            // $this->db->join($this->table5, $this->table3.'.no_karywn = '.$this->table5.'.id_anak');
                // $this->db->where($this->table5.'.id_anak',$user_id);
        }
        else if($jb == "TL") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.spv');
            // $this->db->where('b.tl',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->join($this->table5, $this->table.'.tl = '.$this->table5.'.id_tl');
            // $this->db->where($this->table5.'.id_tl',$user_id);
        //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
        //     // $this->db->where($this->table5.'.id_sp',$user_id);
        }
        else if($jb == "SUPERVISOR") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
            // $this->db->where('b.spv',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','TL');
                $this->db->or_like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->or_where('a.no_karywn',$user_id);
            // $this->db->where('a.status','2');
            // $this->db->or_where('a.status','4');
                // $this->db->join($this->table5, $this->table.'.spv = '.$this->table5.'.id_spv');
                // $this->db->where($this->table5.'.id_spv',$user_id);
            //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
            //     // $this->db->where($this->table5.'.id_spv',$user_id);
        }
        else if($jb == "MANAGER") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
            // $this->db->where('b.manager',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','SUPERVISOR');
                $this->db->or_like('f.user3','TL');
                $this->db->or_like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->where('a.status','3');
            // $this->db->or_where('a.status','4');
                // $this->db->join($this->table5, $this->table.'.manager = '.$this->table5.'.id_manager');
                // $this->db->where($this->table5.'.id_'.strtolower($jb),$user_id);
        }

        
        // $this->db->where($this->table3.'.spv',$user_id);
        // $this->db->or_where($this->table3.'.no_karywn',$user_id);
        $this->db->group_by('a.id');
        $this->db->order_by("f.user3 DESC, b.name ASC, a.tgl_mulai DESC");
        if($cari) {
            $this->db->like('b.name',$cari);
            $this->db->or_like('b.username',$cari);
        }

        if($date_awal) {
            $this->db->where('a.tgl_mulai >=', $date_awal);
            if($date_akhir) {
                $this->db->where('a.tgl_akhir <=', $date_akhir);
                $date = $date_akhir;
            }
            else {
                $date = date("Y-m-d");
            }
        }

        if($date_akhir) {
            $this->db->where('a.tgl_akhir <=', $date_akhir);
            $date = $date_akhir;
        }
        else {
            $date = date("Y-m-d");
        }

        if($jabatan != NULL || $jabatan != '') {
            $this->db->where('f.user3',$jabatan);
        }

        $array_approve = array();
        
        if($jb == 'AGENT' || $jb == 'INPUTER' || $jb == 'SUPPORT' || $jb == 'SOO'){
            $array_approve = array('0');
        }
        elseif($jb == 'TL') {
            $array_approve = array('1');
        }
        elseif($jb == 'SUPERVISOR') {
            $array_approve = array('2');
        }
        elseif($jb == 'MANAGER') {
            $array_approve = array('3');
        }

        if($approve_ver == 'APPROVE') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where_in('a.status', $array_approve);
        }
        elseif($approve_ver == 'VERIFIKASI') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status', '4');
        }
        elseif($approve_ver == 'TIDAK AKTIF') {
            $this->db->where('a.tgl_akhir <=', $date);
            // $this->db->where('a.status','5');
        }
        elseif($approve_ver == 'AKTIF') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status <= ','4');
        }

		return $this->db->count_all_results();
	}

    function export_data_list_ccm($user_id,$jb,$cari = null, $date_awal = null, $date_akhir = null, $username = NULL, $jabatan = NULL, $approve_ver = NULL){	
        $this->db->select('a.tgl_verifi,a.id, b.username, b.name, f.user3, d.user2, f.user5, a.tgl_mulai, a.tgl_akhir, a.kode, a.status, a.level, a.spv, b.user_id as id_anak, b.`name` as nama_anak, c.user_id as id_tl, c.user2 as nama_tl, d.user_id as id_spv, d.user2 as nama_spv, e.user_id as id_manager, e.user2 as nama_manager');
        $this->db->from($this->table3.' AS a');
        $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
        $this->db->join($this->table2.' AS c', 'a.spv = c.user_id');
        $this->db->join($this->table2.' AS f', 'a.no_karywn = f.user_id ');
        $this->db->join($this->table2.' AS d', 'b.spv = d.user_id', 'left');
        $this->db->join($this->table2.' AS e', 'b.manager = e.user_id', 'left');
        // $this->db->join($this->table2.' AS a', $this->table3.'.spv = a.id');
        if($jb == "AGENT" || $jb == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
            $this->db->where('b.user_id',$user_id);
            // $this->db->where('a.status','0');
            // $this->db->join($this->table5, $this->table3.'.no_karywn = '.$this->table5.'.id_anak');
                // $this->db->where($this->table5.'.id_anak',$user_id);
        }
        else if($jb == "TL") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.spv');
            // $this->db->where('b.tl',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->join($this->table5, $this->table.'.tl = '.$this->table5.'.id_tl');
            // $this->db->where($this->table5.'.id_tl',$user_id);
        //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
        //     // $this->db->where($this->table5.'.id_sp',$user_id);
        }
        else if($jb == "SUPERVISOR") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
            // $this->db->where('b.spv',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','TL');
                $this->db->or_like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->or_where('a.no_karywn',$user_id);
            // $this->db->where('a.status','2');
            // $this->db->or_where('a.status','4');
                // $this->db->join($this->table5, $this->table.'.spv = '.$this->table5.'.id_spv');
                // $this->db->where($this->table5.'.id_spv',$user_id);
            //     // $this->db->join($this->table5, $this->table3.'.spv = '.$this->table5.'.id_tl');
            //     // $this->db->where($this->table5.'.id_spv',$user_id);
        }
        else if($jb == "MANAGER") {
            // $this->db->join($this->table3, $this->table.'.user_id = '.$this->table3.'.no_karywn');
            // $this->db->where('b.manager',$username);
            if($jabatan == NULL) {
                $this->db->like('f.user3','SUPERVISOR');
                $this->db->or_like('f.user3','TL');
                $this->db->or_like('f.user3','AGENT');
                $this->db->or_like('f.user3','INPUTER');
                $this->db->or_like('f.user3','SUPPORT');
                $this->db->or_like('f.user3','SOO');
            }
            // $this->db->where('a.status','3');
            // $this->db->or_where('a.status','4');
                // $this->db->join($this->table5, $this->table.'.manager = '.$this->table5.'.id_manager');
                // $this->db->where($this->table5.'.id_'.strtolower($jb),$user_id);
        }

        
        // $this->db->where($this->table3.'.spv',$user_id);
        // $this->db->or_where($this->table3.'.no_karywn',$user_id);
        $this->db->group_by('a.id');
        $this->db->order_by("f.user3 DESC, b.name ASC, a.tgl_mulai DESC");
        if($cari) {
            $this->db->like('b.name',$cari);
            $this->db->or_like('b.username',$cari);
        }

        if($date_awal) {
            $this->db->where('a.tgl_mulai >=', $date_awal);
            if($date_akhir) {
                $this->db->where('a.tgl_akhir <=', $date_akhir);
                $date = $date_akhir;
            }
            else {
                $date = date("Y-m-d");
            }
        }

        if($date_akhir) {
            $this->db->where('a.tgl_akhir <=', $date_akhir);
            $date = $date_akhir;
        }
        else {
            $date = date("Y-m-d");
        }

        if($jabatan != NULL || $jabatan != '') {
            $this->db->where('f.user3',$jabatan);
        }

        $array_approve = array();
        
        if($jb == 'AGENT' || $jb == 'INPUTER' || $jb == 'SUPPORT' || $jb == 'SOO'){
            $array_approve = array('0');
        }
        elseif($jb == 'TL') {
            $array_approve = array('1');
        }
        elseif($jb == 'SUPERVISOR') {
            $array_approve = array('2');
        }
        elseif($jb == 'MANAGER') {
            $array_approve = array('3');
        }

        if($approve_ver == 'APPROVE') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where_in('a.status', $array_approve);
        }
        elseif($approve_ver == 'VERIFIKASI') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status', '4');
        }
        elseif($approve_ver == 'TIDAK AKTIF') {
            $this->db->where('a.tgl_akhir <=', $date);
            // $this->db->where('a.status','5');
        }
        elseif($approve_ver == 'AKTIF') {
            $this->db->where('a.tgl_akhir >=', $date);
            $this->db->where('a.status <= ','4');
        }

		return $this->db->get()->result();
	}

    function getJabatan(){	
        $this->db->distinct();
        $this->db->select($this->table2.'.user3');
        $this->db->from($this->table2);
        $this->db->order_by($this->table2.".user3");
		return $this->db->get()->result();
	}

	function insert($data) {
		return $this->db->insert($this->table3, $data);
	}

    function data_ccm_detail($id,$cekJabatan) {
        
       
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
        $this->db->from($this->table3);
        $this->db->where('id',$id);
		return $this->db->get()->row();
	}

    function update($id, $data) {
		$data_id = array('id' => $id);
		return $this->db->update($this->table3, $data, $data_id);
	}

    function get_id_ccm($id) {
        $this->db->select('a.id, b.username, b.name, f.user3, f.user2, f.user5, f.user6, a.tgl_mulai, a.tgl_akhir, a.kode, a.pelanggaran, a.penyuluhan, a.komitmen, a.tgl_verifi, a.verifikasi, a.alasan, a.kronologis, a.status, a.level, a.spv, b.user_id as id_anak, b.`name` as nama_anak, c.user_id as id_tl, c.user2 as nama_tl, c.user3 as jabatan_tl, d.user_id as id_spv, d.user2 as nama_spv, d.user3 as jabatan_spv, e.user_id as id_manager, e.user2 as nama_manager, e.user3 as jabatan_manager,');
        $this->db->from($this->table3.' AS a');
        $this->db->join($this->table.' AS b', 'a.no_karywn = b.user_id');
        $this->db->join($this->table2.' AS c', 'a.spv = c.user_id');
        $this->db->join($this->table2.' AS f', 'a.no_karywn = f.user_id ');
        $this->db->join($this->table2.' AS d', 'b.spv = d.user_id', 'left');
        $this->db->join($this->table2.' AS e', 'b.manager = e.user_id', 'left');
        $this->db->where('a.id',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_dokumen" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}
}