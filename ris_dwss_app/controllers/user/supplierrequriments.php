<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class supplierrequriments extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('supplierrequriment'));
        $this->session_data = $this->session->userdata('user_session');

        if($this->session_data->role == 3){
            if(!checkSuppliersupplierAmenities(4, $this->session_data->id)){
                $this->session->set_flashdata('error', 'You dont have permission to see it Please contact Administrator');
                redirect(USER_URL . 'denied', 'refresh');
            }
        }
    }
    
    function viewSupplierrequriment() {
        $this->layout->view('user/supplierrequriments/view');
    }

    function addSupplierrequriment() {
        if ($this->input->post() !== false) {
            $supplierrequriment = new Supplierrequriment();

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $supplierrequriment->supplier_id = $this->input->post('supplier_id');
            } else {
                $supplierrequriment->supplier_id = $this->session_data->id;
            }

            $supplierrequriment->product_id = $this->input->post('product_id');

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_title') != '') {
                    $supplierrequriment->{$key . '_title'} = $this->input->post($key . '_title');
                } else {
                    $supplierrequriment->{$key . '_title'} = $this->input->post('en_title');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_description') != '') {
                    $supplierrequriment->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $supplierrequriment->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            $supplierrequriment->status = $this->input->post('status');
            $supplierrequriment->created_id = $this->session_data->id;
            $supplierrequriment->created_datetime = get_current_date_time()->get_date_time_for_db();
            $supplierrequriment->updated_id = $this->session_data->id;
            $supplierrequriment->update_datetime = get_current_date_time()->get_date_time_for_db();

            $supplierrequriment->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'supplierrequriment', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('supplierrequriment'));

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

            $this->layout->view('user/supplierrequriments/add', $data);
        }
    }
    
    function editSupplierrequriment($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $supplierrequriment = new Supplierrequriment();
                $supplierrequriment->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $supplierrequriment->supplier_id = $this->input->post('supplier_id');
                } else {
                    $supplierrequriment->supplier_id = $this->session_data->id;
                }

                $supplierrequriment->product_id = $this->input->post('product_id');

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_title') != '') {
                        $supplierrequriment->{$key . '_title'} = $this->input->post($key . '_title');
                    } else {
                        $supplierrequriment->{$key . '_title'} = $this->input->post('en_title');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '') {
                        $supplierrequriment->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $supplierrequriment->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $supplierrequriment->status = $this->input->post('status');
                $supplierrequriment->updated_id = $this->session_data->id;
                $supplierrequriment->update_datetime = get_current_date_time()->get_date_time_for_db();

                $supplierrequriment->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'supplierrequriment', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('supplierrequriment'));

                $supplierrequriment = new Supplierrequriment();
                $data['supplierrequriment'] = $supplierrequriment->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $obj_supplier = new Supplier();
                    $data['supplier_details'] = $obj_supplier->get();
                    $supplier_id = $supplierrequriment->supplier_id;
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
                $this->layout->view('user/supplierrequriments/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'supplierrequriment', 'refresh');
        }
    }

    function deleteSupplierrequriment($id) {
        if (!empty($id)) {
            $obj_supplierrequriment = new Supplierrequriment();
            $obj_supplierrequriment->where('id', $id)->get();
            if ($obj_supplierrequriment->result_count() == 1) {
                $obj_supplierrequriment->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }

    function smsSupplierrequriment($id){
        $supplierrequriment = new Supplierrequriment();
        if($this->session_data->role == 3) {
            $data['supplierrequriment'] = $supplierrequriment->where(array('id' => $id, 'supplier_id' => $this->session_data->id))->get();
        } else {
            $data['supplierrequriment'] = $supplierrequriment->where('id', $id)->get();
        }
        

        if($supplierrequriment->result_count() == 1){
            $this->layout->view('user/supplierrequriments/view_sms', $data); 
        } else{
            redirect(USER_URL . 'supplierrequriment', 'refresh');
        }  
    }

    function sendSmsSupplierrequriment($id){
        $supplierrequriment = new Supplierrequriment();
        if($this->session_data->role == 3) {
            $data['supplierrequriment'] = $supplierrequriment->where(array('id' => $id, 'supplier_id' => $this->session_data->id))->get();
        } else {
            $data['supplierrequriment'] = $supplierrequriment->where('id', $id)->get();
        }

        if($supplierrequriment->result_count() == 1){
            if ($this->input->post() !== false) {
                $mobile_nos = $this->input->post('mobile');
                $description = $this->input->post('description');
                foreach ($mobile_nos as $mobile) {
                    if(!empty($mobile)){
                        $check = sendSMS($mobile, $description);

                        $obj = new Supplierrequrimentsms();
                        $obj->mobile_no = $mobile;
                        $obj->supplierrequriment_id = $id;
                        $obj->message = $description;
                        $obj->status = $check;
                        $obj->created_id = $this->session_data->id;
                        $obj->created_datetime = get_current_date_time()->get_date_time_for_db();
                        $obj->updated_id = $this->session_data->id;
                        $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                        $obj->save();
                    }
                }

                $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
                redirect(USER_URL . 'supplierrequriment/sms/' . $id, 'refresh');
            } else{
                $this->layout->view('user/supplierrequriments/send_sms', $data);
            }
        } else {
            redirect(USER_URL . 'supplierrequriment', 'refresh');
        }
    }

    function deleteSmsSupplierrequriment($id){
        $obj = new Supplierrequrimentsms();
        $obj->where('id', $id)->get();

        if($obj->result_count() == 1){
            $supplierrequriment = new Supplierrequriment();
            if($this->session_data->role == 3) {
                $supplierrequriment->where(array('id' => $obj->supplierrequriment_id, 'supplier_id' => $this->session_data->id))->get();
            } else {
                $supplierrequriment->where('id', $obj->supplierrequriment_id)->get();
            }

            if($supplierrequriment->result_count() == 1){
                $obj->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }   
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }

        echo json_encode($data);
    }

    function resendSmsSupplierrequriment($id){
        $obj = new Supplierrequrimentsms();
        $obj->where('id', $id)->get();

        if($obj->result_count() == 1){
            $supplierrequriment = new Supplierrequriment();
            if($this->session_data->role == 3) {
                $supplierrequriment->where(array('id' => $obj->supplierrequriment_id, 'supplier_id' => $this->session_data->id))->get();
            } else {
                $supplierrequriment->where('id', $obj->supplierrequriment_id)->get();
            }

            if($supplierrequriment->result_count() == 1){
                $check = sendSMS($obj->mobile_no, $obj->message);
                $obj = new Supplierrequrimentsms();
                $obj->status = $check;
                $obj->updated_id = $this->session_data->id;
                $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                $obj->save();
                $data = array('status' => 'success', 'msg' => $this->lang->line('send_sms_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('send_sms_error'));
            }   
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('send_sms_error'));
        }

        echo json_encode($data);
    }
}