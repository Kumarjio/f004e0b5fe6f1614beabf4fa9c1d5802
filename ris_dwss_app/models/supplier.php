    <?php
class Supplier extends DataMapper {

    var $has_many = array("supplierproduct");
    var $has_one  = array('market');

    function __construct($id = NULL) {
        parent::__construct($id);
    }

    function autoIncerementNumber(){
    	$last_id = 0;
        $new_id = 0;
        
        $this->db->select('*');
        $this->db->from('suppliers');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $res = $this->db->get();
        $result = $res->result();
        
        $common_string_1 = 'S' . date('Ymd', strtotime(get_current_date_time()->get_date_for_db()));
        
        if ($res->num_rows > 0) {
            $explode = explode('-', $result[0]->form_no);
            $last_id = @$explode[1];
        }
        
        $new_id = $common_string_1 . '-' . str_pad(($last_id + 1), 5, '0', STR_PAD_LEFT);
        
        return $new_id;
    }
}
?>
