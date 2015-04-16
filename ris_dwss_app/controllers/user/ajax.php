<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ajax extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function setNewLanguage($lang_prefix) {
        $session = $this->session->userdata('user_session');
        $session->language = $lang_prefix;
        $newdata = array('user_session' => $session);
        $this->session->set_userdata($newdata);
        echo TRUE;
    }

    function getProductCategoryByMarket($market_id) {
        $obj_productcategory = new Productcategory();
        $obj_productcategory->where('market_id', $market_id)->get();

        $option = '';
        if($obj_productcategory->result_count() > 0){
            $option = '<option>'. $this->lang->line('product_select_category') .'</option>';
            foreach ($obj_productcategory as $productcategory) {
                $option .= '<option value="'. $productcategory->id .'">'.  $productcategory->{$this->session_data->language .'_name'} .'</option>';
            }
        } else {
            $option = '<option>'. $this->lang->line('no_product_category_found') .'</option>';
        }

        echo $option;
    }
}
