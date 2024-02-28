<?php 
 
class M_news extends CI_Model{	

    // public $table = 'item_dokumen';
    public $table = 'news';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
    function data_news(){	
		return $this->db->get_where($this->table, array('status'=>'AKTIF'))->result();
	}
}