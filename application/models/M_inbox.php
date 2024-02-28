<?php 
 
class M_inbox extends CI_Model{	

    public $table = 'inbox';
    public $table2 = 'cc147_main_users';
    public $table3 = 'cc147_main_users_extended';
    public $table4 = 'notifikasi_inbox';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
	public function rules()
    {
        return [
            ['field' => 'judul',
            'label' => 'Judul Plan Rooster',
            'rules' => 'required'],

            ['field' => 'topik',
            'label' => 'Topik Plan Rooster',
            'rules' => 'required'],

            ['field' => 'short_description',
            'label' => 'Short Description',
            'rules' => 'required'],

        ];
    }

    public function setIdInbox() {
        $this->db->select('MAX(id_inbox) as id');
        $this->db->from($this->table);
		return $this->db->get()->row();
    }

    public function getPengawakan($username, $jabatan) {
        $this->db->select('username');
        $this->db->from($this->table2);
        if($jabatan == "TL") {
            $this->db->where('tl', $username);
        }
        elseif($jabatan == "SUPERVISOR") {
            $this->db->where('spv', $username);
        }
        elseif($jabatan == "MANAGER") {
            $this->db->where('manager', $username);
        }
		return $this->db->get()->result();
    }

    function insertNotif($data) {
		return $this->db->insert($this->table4, $data);
	}

	function data_inbox($limit ,$start ,$cari = null, $date_awal = null, $date_akhir = null, $jabatan = NULL,$filter=NULL,$username=NULL){	
        $this->db->from($this->table.' as a');
        if($filter == "KIRIM INBOX") {
            $this->db->join($this->table2.' as b', 'a.login = b.username');
            $this->db->where('b.username', $username);
        }
        elseif ($filter == "PRIVATE INBOX"){
            $this->db->join($this->table2.' as b', 'a.login_private = b.username');
            $this->db->where('a.jenis', "PRIVATE");
            $this->db->where('b.username', $username);
        }
        else {
            if($jabatan != "" || $jabatan != NULL) {
                if($jabatan == "TL") {
                    $this->db->join($this->table2.' as b', 'a.login = b.spv');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
                elseif($jabatan == "SUPERVISOR") {
                    $this->db->join($this->table2.' as b', 'a.login = b.manager');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
                elseif($jabatan == "AGENT" || $jabatan == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
                    $this->db->join($this->table2.' as b', 'a.login = b.tl');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
            }
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by("a.tanggal, a.judul", "desc");
        if($cari) {
            $this->db->like('a.judul',$cari);
        }

        if($date_awal) {
            $this->db->where('a.tanggal >=', $date_awal);
            if($date_akhir) {
                $this->db->where('a.tanggal >=', $date_awal);
                $this->db->where('a.tanggal <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('a.tanggal <=', $date_akhir);
        }

		return $this->db->get()->result();
	}

    function jumlah_data($cari = null, $date_awal = null, $date_akhir = null, $jabatan = NULL,$filter=NULL,$username=NULL){	
        $this->db->from($this->table.' as a');
        if($filter == "KIRIM INBOX") {
            $this->db->join($this->table2.' as b', 'a.login = b.username');
            $this->db->where('b.username', $username);
        }
        elseif ($filter == "PRIVATE INBOX"){
            $this->db->join($this->table2.' as b', 'a.login_private = b.username');
            $this->db->where('b.username', $username);
        }
        else {
            if($jabatan != "" || $jabatan != NULL) {
                if($jabatan == "TL") {
                    $this->db->join($this->table2.' as b', 'a.login = b.spv');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
                elseif($jabatan == "SUPERVISOR") {
                    $this->db->join($this->table2.' as b', 'a.login = b.manager');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
                elseif($jabatan == "AGENT" || $jabatan == "INPUTER" || $jabatan == "SOO" || $jabatan == "SUPPORT") {
                    $this->db->join($this->table2.' as b', 'a.login = b.tl');
                    // $this->db->join($this->table3.' as c', 'a.login = c.user1');
                    $this->db->where('a.jenis', "BLAST");
                    $this->db->where('b.username', $username);
                }
            }
        }
        // $this->db->limit($limit, $start);
        $this->db->order_by("a.tanggal, a.judul", "desc");
        if($cari) {
            $this->db->like('a.judul',$cari);
        }

        if($date_awal) {
            $this->db->where('a.tanggal >=', $date_awal);
            if($date_akhir) {
                $this->db->where('a.tanggal >=', $date_awal);
                $this->db->where('a.tanggal <=', $date_akhir);
            }
        }

        if($date_akhir) {
            $this->db->where('a.tanggal <=', $date_akhir);
        }
		return $this->db->count_all_results();
	}

	function insert($data) {
		return $this->db->insert($this->table, $data);
	}

	function update($id, $data) {
		$data_id = array('id_inbox' => $id);
		return $this->db->update($this->table, $data, $data_id);
	}

	function get_id($id) {
        $this->db->from($this->table);
        $this->db->where('id_inbox',$id);
		return $this->db->get()->row();
	}

	function delete($id) {
		$hapus_id = array("id_inbox" => $id);
		return $this->db->delete($this->table, $hapus_id);
	}

    function listAgent() {
        $this->db->from($this->table3);
        $this->db->order_by("user3, user1", "asc");
		return $this->db->get()->result();
	}
}