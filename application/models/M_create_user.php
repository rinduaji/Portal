<?php 
 
class M_create_user extends CI_Model{	

    public $table1 = 'cc147_main_users_extended';
    public $table2 = 'cc147_main_users';
    public $table3 = 'groupmail';

    public function rules()
    {
        return [
            ['field' => 'user1',
            'label' => 'Username',
            'rules' => 'required'],

            ['field' => 'user2',
            'label' => 'Nama',
            'rules' => 'required'],

            ['field' => 'user3',
            'label' => 'Jabatan',
            'rules' => 'required'],

            ['field' => 'user5',
            'label' => 'Site',
            'rules' => 'required'],

        ];
    }

	function insert($data1, $tl = NULL, $spv = NULL, $manager = NULL) {
        $this->db->insert($this->table1, $data1);
        $user_id = $this->cekIdUser($data1['user1']);
        if($tl == NULL && $spv == NULL && $manager == NULL) {
            $user_id_tl = $this->cekIdUser($tl);
            $user_id_spv = $this->cekIdUser($spv);
            $user_id_manager = $this->cekIdUser($manager);
        }

        $data_username = array('user1' => $data1['user1']);
        $data_id = array('user_id' => $user_id->id);

        
        $this->db->update($this->table1, $data_id, $data_username);
        
        if(strpos($data1['user3'], 'AGENT') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'], 'TL') == TRUE) {
            $id_anak = '';
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'], 'SUPERVISOR') == TRUE) {
            $id_anak = '';
            $id_tl = '';
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'MANAGER') == TRUE) {
            $id_anak = '';
            $id_tl = '';
            $id_spv = '';
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'INPUTER') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'SOO') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'RANGER') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'SUPPORT SALES') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else if(strpos($data1['user3'],'SUPPORT CAPS') == TRUE) {
            $id_anak = $user_id->id;
            $id_tl = $user_id_tl->id;
            $id_spv = $user_id_spv->id;
            $id_manager = $user_id_manager->id;
        }
        else {
            $id_anak = '';
            $id_tl = '';
            $id_spv = '';
            $id_manager = '';
        }

        $data2 = array(
            'user_id' => $user_id->id,
            'username' => $data1['user1'],
			'name' => $data1['user2'],
            'tl' => $id_tl,
			'spv' => $id_spv,
            'manager' => $id_manager,
            'user_password' => md5('infomedia'),
		);
        $this->db->insert($this->table2, $data2);
        
	}

    function cekIdUser($username){	
        $this->db->from($this->table1);
        $this->db->where($this->table1.'.user1',$username);	
		return $this->db->get()->row();
	}

    function dataJabatan(){	
        $this->db->distinct();
        $this->db->select('user3');
        $this->db->from($this->table1);
        $this->db->order_by('user3 ASC');
		return $this->db->get()->result();
	}

    function showTL(){	
        $this->db->from($this->table1);
        $this->db->like($this->table1.'.user3','TL');	
		return $this->db->get()->result();
	}

    function showSPV(){	
        $this->db->from($this->table1);
        $this->db->like($this->table1.'.user3','SUPERVISOR');	
		return $this->db->get()->result();
	}

    function showManager(){	
        $this->db->from($this->table1);
        $this->db->like($this->table1.'.user3','MANAGER');	
		return $this->db->get()->result();
	}

    function showUsernameMax(){	
        $this->db->select_max('user1');
        $this->db->from($this->table1);	
		return $this->db->get()->row();
	}
}