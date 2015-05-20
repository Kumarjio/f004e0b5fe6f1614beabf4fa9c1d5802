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

    function managePacket($id) {
        if ($this->input->post() !== false) {

            $old_id = $this->input->post('old_id');
            $old_weight = $this->input->post('old_weight');
            $old_measurement = $this->input->post('old_measurement');

            for($i=0; $i< count($old_id); $i++){
                if(!empty($old_weight[$old_id[$i]]) && !empty($old_measurement[$old_id[$i]])){

                    $packet = new Packet();
                    if($this->session_data->role == 1 || $this->session_data->role == 2){
                        $packet->where('id', $id)->get();
                    } else if($this->session_data->role == 3 ){
                        $packet->where(array('id' => $old_id[$i], 'supplier_id' => $this->session_data->supplier_id))->get();
                    }

                    $packet->weight = $old_weight[$old_id[$i]];
                    $packet->measurement = $old_measurement[$old_id[$i]];
                    $packet->updated_id = $this->session_data->id;
                    $packet->update_datetime = get_current_date_time()->get_date_time_for_db();

                    $packet->save();
                }
            }

            $weight = $this->input->post('weight');
            $measurement = $this->input->post('measurement');

            for($i=0; $i<= count($weight); $i++){
                if(!empty($weight[$i]) && !empty($measurement[$i])){

                    $packet = new Packet();
                    if($this->session_data->role ==1 || $this->session_data->role ==2){
                        $packet->supplier_id = $this->input->post('supplier_id');
                    } else {
                        $packet->supplier_id = $this->session_data->supplier_id;
                    }

                    $packet->product_id = $id;
                    $packet->weight = $weight[$i];
                    $packet->measurement = $measurement[$i];

                    $packet->created_id = $this->session_data->id;
                    $packet->created_datetime = get_current_date_time()->get_date_time_for_db();
                    $packet->updated_id = $this->session_data->id;
                    $packet->update_datetime = get_current_date_time()->get_date_time_for_db();

                    $packet->save();
                }
            }

            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'packet', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('manage') . ' ' . $this->lang->line('packet'));

            $obj_supplier_product = new Supplierproduct();
            $obj_supplier_product->where(array('supplier_id' => $this->session_data->supplier_id, 'product_id' => $id))->get();

            if($obj_supplier_product->result_count() == 1){
                $obj_packet = new Packet();
                $obj_packet->where(array('supplier_id' => $this->session_data->supplier_id, 'product_id' => $id));
                $data['packets_details'] = $obj_packet->get();

                $obj_product = new Product();
                $data['product_details'] = $obj_product->where('id', $id)->get();;

                $this->layout->view('user/packets/manage', $data);
            } else {
                redirect(USER_URL . 'packet', 'refresh');
            }
        }
    }

    function deletePacket($id) {
        if (!empty($id)) {
            $obj_packet = new Packet();
            if($this->session_data->role == 1 || $this->session_data->role == 2){
                $obj_packet->where('id', $id)->get();
            } else if($this->session_data->role == 3 ){
                $obj_packet->where(array('id' => $id, 'supplier_id' => $this->session_data->supplier_id))->get();
            }

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
