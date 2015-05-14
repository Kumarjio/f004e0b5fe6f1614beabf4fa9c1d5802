<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packets extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('packet'));
        $this->session_data = $this->session->userdata('user_session');

        if($this->session_data->role == 3){
            if(!checkSuppliersupplierAmenities(5, $this->session_data->supplier_id)){
                $this->session->set_flashdata('error', 'You dont have permission to see it Please contact Administrator');
                redirect(USER_URL . 'denied', 'refresh');
            }
        }
    }
    
    function viewPacket() {
        $obj_packet = new Packet();
        if($this->session_data->role == 1 || $this->session_data->role == 2){
            $data['count'] = $obj_packet->count();
        } else {
            $obj_packet->where('supplier_id', $this->session_data->supplier_id)->get();
            $data['count'] = $obj_packet->result_count();
        }

        $this->layout->view('user/packets/view', $data);
    }

    function addPacket() {
        if ($this->input->post() !== false) {
            $packet = new Packet();

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $packet->supplier_id = $this->input->post('supplier_id');
            } else {
                $packet->supplier_id = $this->session_data->supplier_id;
            }

            $packet->product_id = $this->input->post('product_id');
            $packet->weight = $this->input->post('weight');
            $packet->measurement = $this->input->post('measurement');

            $packet->created_id = $this->session_data->id;
            $packet->created_datetime = get_current_date_time()->get_date_time_for_db();
            $packet->updated_id = $this->session_data->id;
            $packet->update_datetime = get_current_date_time()->get_date_time_for_db();

            $packet->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'packet', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('packet'));

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $obj_supplier = new Supplier();
                $data['supplier_details'] = $obj_supplier->get();
                $data['products_details'] = NULL;
            } else {
                $obj_supplier_product = new Supplierproduct();
                $obj_supplier_product->where('supplier_id', $this->session_data->supplier_id);
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

            $this->layout->view('user/packets/add', $data);
        }
    }
    
    function editPacket($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $packet = new Packet();
                $packet->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $packet->supplier_id = $this->input->post('supplier_id');
                } else {
                    $packet->supplier_id = $this->session_data->supplier_id;
                }

                $packet->product_id = $this->input->post('product_id');

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_title') != '') {
                        $packet->{$key . '_title'} = $this->input->post($key . '_title');
                    } else {
                        $packet->{$key . '_title'} = $this->input->post('en_title');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '') {
                        $packet->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $packet->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $packet->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
                if($this->input->post('end_date') != ''){
                    $packet->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                }

                $packet->status = $this->input->post('status');
                $packet->updated_id = $this->session_data->id;
                $packet->update_datetime = get_current_date_time()->get_date_time_for_db();

                $packet->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'packet', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('packet'));

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $packet = new Packet();
                    $data['packet'] = $packet->where(array('id' => $id))->get();
                    $supplier_id = $data['packet']->supplier_id;
                } else if($this->session_data->role == 3){
                    $supplier_id = $this->session_data->supplier_id;
                    $packet = new Packet();
                    $data['packet'] = $packet->where(array('id' => $id, 'supplier_id' => $supplier_id))->get();
                }

                if($packet->result_count() == 1){
                    $obj_supplier = new Supplier();
                    $data['supplier_details'] = $obj_supplier->get();
                    $data['products_details'] = NULL;

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
                    $this->layout->view('user/packets/edit', $data);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('no_record_exits'));
                    redirect(USER_URL . 'packet', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'packet', 'refresh');
        }
    }

    function deletePacket($id) {
        if (!empty($id)) {
            $obj_packet = new Packet();
            $obj_packet->where('id', $id)->get();
            if ($obj_packet->result_count() == 1) {
                $obj_packet->delete();
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
