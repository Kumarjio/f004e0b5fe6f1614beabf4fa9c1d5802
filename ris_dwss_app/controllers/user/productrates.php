<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class productrates extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('product_rate'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewProductrate() {
        $this->layout->view('user/product_rates/view');
    }

    function addProductrate() {
        if ($this->input->post() !== false) {
            $product_ids = $this->input->post('product_id');
            $product_min_rates = $this->input->post('product_min_rate');
            $product_max_rates = $this->input->post('product_max_rate');
            $product_incomes = $this->input->post('product_income');
            $date = get_current_date_time()->get_date_time_for_db();

            for($i=0; $i<count($product_ids); $i++){
                $product_rate = new Productrate();
                $product_rate->where(array('product_id' => $product_ids[$i], 'date'=> $date))->get();

                $product_rate->product_id = $product_ids[$i];
                $product_rate->min_rate   = $product_min_rates[$i];
                $product_rate->max_rate   = $product_max_rates[$i];
                $product_rate->income     = $product_incomes[$i];
                $product_rate->date       = $date;

                if($product_rate->result_count() == 0){
                    $product_rate->created_id = $this->session_data->id;
                    $product_rate->created_datetime = get_current_date_time()->get_date_time_for_db();
                }
                
                $product_rate->updated_id = $this->session_data->id;
                $product_rate->update_datetime = get_current_date_time()->get_date_time_for_db();
                $product_rate->save();    
            }

            
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'productrate', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('product_rate'));

            $obj_markert = new Market();
            $data['markets'] = $obj_markert->where('status',1)->get();

            $this->layout->view('user/product_rates/add', $data);
        }
    }
    
    function editProductrate($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $product_rate = new Productrate();
                $product_rate->where('id', $id)->get();

                $product_rate->min_rate   = $this->input->post('min_rate');
                $product_rate->max_rate   = $this->input->post('max_rate');
                $product_rate->income     = $this->input->post('income');
                $product_rate->updated_id = $this->session_data->id;
                $product_rate->update_datetime = get_current_date_time()->get_date_time_for_db();

                $product_rate->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'productrate', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('product_rate'));

                $product_rate = new Productrate();
                $product_rate->where('id', $id)->get();
                $data['productrate'] = $product_rate->stored;
                $data['product'] = $product_rate->product->get()->stored;
                $data['product_category'] = $product_rate->product->productcategory->get()->stored;
                $data['product_market'] = $product_rate->product->market->get()->stored;

                $this->layout->view('user/product_rates/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'product_rate', 'refresh');
        }
    }

    function deleteProductrate($id) {
        if (!empty($id)) {
            $obj_product_rate = new Productrate();
            $obj_product_rate->where('id', $id)->get();
            if ($obj_product_rate->result_count() == 1) {
                $obj_product_rate->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }

}
