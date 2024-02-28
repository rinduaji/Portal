<?php 
 
class M_login extends CI_Model{	

    public $table1 = 'cc147_main_users';
	public $table2 = 'cc147_main_users_extended';
	public $table3 = 'app_roosterfix';
	public $table4 = 'app_briefing';

	function cek_login($username, $password, $tanggal){	
		$this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.username = '.$this->table2.'.user1');
		// $this->db->join($this->table3, $this->table1.'.username = '.$this->table3.'.login');
		$this->db->where('username',$username);
		$this->db->where('user_password',$password);
		$this->db->not_like('user3','AGENT');
		return $this->db->get();
	}	

	function data_login($username, $password, $tanggal){		
		$this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.username = '.$this->table2.'.user1');
		// $this->db->join($this->table3, $this->table1.'.username = '.$this->table3.'.login');
		$this->db->where('username',$username);
		$this->db->where('user_password',$password);
		$this->db->not_like('user3','AGENT');
		return $this->db->get();
	}

	function cek_login_briefing($username, $password, $tanggal){	
		$this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.username = '.$this->table2.'.user1');
		$this->db->join($this->table4, $this->table1.'.username = '.$this->table4.'.agent');
		$this->db->where('username',$username);
		$this->db->where('user_password',$password);
		$this->db->where('tanggal',$tanggal);
		return $this->db->get();
	}	

	function data_login_briefing($username, $password, $tanggal){		
		$this->db->from($this->table1);
        $this->db->join($this->table2, $this->table1.'.username = '.$this->table2.'.user1');
		$this->db->join($this->table4, $this->table1.'.username = '.$this->table4.'.agent');
		$this->db->where('username',$username);
		$this->db->where('user_password',$password);
		$this->db->where('tanggal',$tanggal);
		return $this->db->get();
	}
}