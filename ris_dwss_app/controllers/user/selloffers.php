<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class selloffers extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('selloffer'));
        $this->session_data = $this->session->userdata('user_session');

        if($this->session_data->role == 3){
            if(!checkSuppliersupplierAmenities(4, $this->session_data->id)){
                $this->session->set_flashdata('error', 'You dont have permission to see it Please contact Administrator');
                redirect(USER_URL . 'denied', 'refresh');
            }
        }
    }
    
    function viewSelloffer() {
        $this->layout->view('user/selloffers/view');
    }

    function addSelloffer() {
        if ($this->input->post() !== false) {
            $selloffer = new Selloffer();

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $selloffer->supplier_id = $this->input->post('supplier_id');
            } else {
                $selloffer->supplier_id = $this->session_data->id;
            }

            $selloffer->product_id = $this->input->post('product_id');

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_title') != '') {
                    $selloffer->{$key . '_title'} = $this->input->post($key . '_title');
                } else {
                    $selloffer->{$key . '_title'} = $this->input->post('en_title');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_description') != '') {
                    $selloffer->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $selloffer->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            $selloffer->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
            if($this->input->post('end_date') != ''){
                $selloffer->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            }
        

            $selloffer->status = $this->input->post('status');
            $selloffer->created_id = $this->session_data->id;
            $selloffer->created_datetime = get_current_date_time()->get_date_time_for_db();
            $selloffer->updated_id = $this->session_data->id;
            $selloffer->update_datetime = get_current_date_time()->get_date_time_for_db();

            $selloffer->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'selloffer', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('selloffer'));

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $obj_supplier = new Supplier();
                $data['supplier_details'] = $obj_supplier->get();
                $data['products_details'] = NULL;
            } else {
                $obj_supplier_product = new Supplierproduct();
                $obj_supplier_product->where('supplier_id', $this->session_data->id);
                $product_data =array();
                foreach ($obj_supplier_product->get() as $products_detail) {
                    $prod_temp = $products_detail->Product->get();
                    $cat_temp = $products_detail->Product->Productcategory->get();
                    $product_data[$cat_temp->stored->id]['category_id'] = $cat_temp->stored->id;
                    $product_data[$cat_temp->stored->id]['category_name'] = $cat_temp->stored->{$this->session_data->language.'_name'};

                    $temp = array();
                    $temp['id'] = $prod_temp->stored->id;
                    $temp['name'] = $prod_temp->stored->{$this->session_data->language.'_name'};
                    $product_data[$cat_temp->stored->id]['products'][] = $temp;
                }

                $data['products_details'] = $product_data;
            }

            $this->layout->view('user/selloffers/add', $data);
        }
    }
    
    function editSelloffer($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $selloffer = new Selloffer();
                $selloffer->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $selloffer->supplier_id = $this->input->post('supplier_id');
                } else {
                    $selloffer->supplier_id = $this->session_data->id;
                }

                $selloffer->product_id = $this->input->post('product_id');

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_title') != '') {
                        $selloffer->{$key . '_title'} = $this->input->post($key . '_title');
                    } else {
                        $selloffer->{$key . '_title'} = $this->input->post('en_title');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '') {
                        $selloffer->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $selloffer->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $selloffer->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
                if($this->input->post('end_date') != ''){
                    $selloffer->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                }

                $selloffer->status = $this->input->post('status');
                $selloffer->updated_id = $this->session_data->id;
                $selloffer->update_datetime = get_current_date_time()->get_date_time_for_db();

                $selloffer->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'selloffer', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('selloffer'));

                $selloffer = new Selloffer();
                $data['selloffer'] = $selloffer->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $obj_supplier = new Supplier();
                    $data['supplier_details'] = $obj_supplier->get();
                    $supplier_id = $selloffer->supplier_id;
                } else {
                    $supplier_id = $this->session_data->id;
                }

                $obj_supplier_product = new Supplierproduct();
                $obj_supplier_product->where('supplier_id', $supplier_id);
                $product_data =array();
                foreach ($obj_supplier_product->get() as $products_detail) {
                    $prod_temp = $products_detail->Product->get();
                    $cat_temp = $products_detail->Product->Productcategory->get();
                    $product_data[$cat_temp->stored->id]['category_id'] = $cat_temp->stored->id;
                    $product_data[$cat_temp->stored->id]['category_name'] = $cat_temp->stored->{$this->session_data->language.'_name'};

                    $temp = array();
                    $temp['id'] = $prod_temp->stored->id;
                    $temp['name'] = $prod_temp->stored->{$this->session_data->language.'_name'};
                    $product_data[$cat_temp->stored->id]['products'][] = $temp;
                }

                $data['products_details'] = $product_data;
                $this->layout->view('user/selloffers/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'selloffer', 'refresh');
        }
    }

    function deleteSelloffer($id) {
        if (!empty($id)) {
            $obj_selloffer = new Selloffer();
            $obj_selloffer->where('id', $id)->get();
            if ($obj_selloffer->result_count() == 1) {
                $obj_selloffer->delete();
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
