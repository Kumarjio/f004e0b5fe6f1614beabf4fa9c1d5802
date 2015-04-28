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

    function getProductByCategoryForRate($category_id){
        $obj_product = new Product();
        $obj_product->where('productcategory_id', $category_id)->get();

        $str = '';
        foreach ($obj_product as $product) {
            $obj_product_rate = new Productrate();
            $obj_product_rate->where(array('product_id' => $product->id));
            $obj_product_rate->order_by('date desc');
            $obj_product_rate->limit(1);
            $obj_product_rate->get();

            $str .='<div class="form-group">';
                $str .='<input type="hidden" name="product_id[]" value="'. $product->id .'"/>';
                $str .='<label class="col-lg-2 control-label">'. $product->{$this->session_data->language . '_name'} .'<span class="text-danger">&nbsp;</span></label>';
                $str .='<div class="col-lg-9">';
                    $str .='<div class="row">';
                        $str .='<div class="col-lg-4">';
                            $str .='<input type="text" class="form-control required" name="product_min_rate[]" value="'. $obj_product_rate->min_rate .'" placeholder="Min rate"/>';
                        $str .='</div>';
                        $str .='<div class="col-lg-4">';
                            $str .='<input type="text" class="form-control required"  name="product_max_rate[]" value="'. $obj_product_rate->max_rate .'" placeholder="Max rate"/>';
                        $str .='</div>';
                        $str .='<div class="col-lg-4">';
                            $str .='<input type="text" class="form-control required"  name="product_income[]" value="'. $obj_product_rate->income .'"  placeholder="Income"/>';
                        $str .='</div>';
                    $str .='</div>';
                $str .='</div>';
            $str .='</div>' ."\n\r";
        }
        echo $str;
    }

    function checkUsernameExit($id = null) {
        $user = new User();
        $user->where('username', $this->input->get('username'))->get();
        if ($id != '0') {
            if ($user->result_count() == 1 && $user->id != $id) {
                echo 'false';
            } else {
                echo 'true';
            }
        } else {
            if ($user->result_count() == 1) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    
    function checkEmailExit($id = null) {
        $user = new User();
        $user->where('email', $this->input->get('email'))->get();
        if ($id != '0') {
            if ($user->result_count() == 1 && $user->id != $id) {
                echo 'false';
            } else {
                echo 'true';
            }
        } else {
            if ($user->result_count() == 1) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
    
    function checkCurrentPassword() {
        $user = new User();
        $user->where(array('id' => $this->session_data->id, 'password' => md5($this->input->get('current_pwd'))));
        $user->get();
        if ($user->result_count() == 1) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
}
