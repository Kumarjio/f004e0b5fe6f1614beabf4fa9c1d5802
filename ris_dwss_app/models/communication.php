<?php
class Communication extends DataMapper {

	var $session_data;

    function __construct($id = NULL) {
        parent::__construct($id);
        $this->ci = get_instance();
        $this->ci->session_data = $this->ci->session->userdata('user_session');
    }

    function getAllNumbersAndEmails(){
    	$this->db->select('id, ' . $this->ci->session_data->language .'_name AS name');
    	$query = $this->db->get('supplierbusinesstypes');
    	$result= array();

    	foreach ($query->result() as $type) {
    		$this->db->select('suppliers.'.$this->ci->session_data->language .'_shop_name AS shop_name, users.' . $this->ci->session_data->language .'_fullname AS supplier_name, users.id, users.email, users.mobile');
    		$this->db->from('suppliers');
    		$this->db->join('users', 'users.id=suppliers.user_id');
    		$this->db->where('FIND_IN_SET('. $type->id.', supplierbusinesstype_id)');
    		$res = $this->db->get();
    		if($res->num_rows() > 0){
    			$result[$type->id]['name'] = $type->name;
    			$result[$type->id]['users'] = $res->result();
    		}
    	}

    	return $result;
    }
}
?>
