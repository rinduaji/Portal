<?php 
 
class M_detail_news extends CI_Model{	

    // public $table = 'item_dokumen';
    public $table = 'news';

	// function cek_login($where){		
	// 	return $this->db->get_where($this->table,$where);
	// }
    function detail_data_news($id){	
		return $this->db->get_where($this->table, array('status'=>'AKTIF', 'id_news' => $id))->row();
	}
}
