<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class advertisements extends CI_Controller {
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('advertisement'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewAdvertisement() {
        $advertisement = new Advertisement();
        if($this->session_data->role == 1 || $this->session_data->role == 2){
            $data['count'] = $advertisement->count();
        } else {
            $advertisement->where('supplier_id', $this->session_data->supplier_id)->get();
            $data['count'] = $advertisement->result_count();
        }

        $this->layout->view('user/advertisements/view', $data);
    }

    function addAdvertisement(){
        if ($this->input->post() !== false) {
            $obj = new Advertisement();

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $obj->supplier_id = $this->input->post('supplier_id');
            } else {
                $obj->supplier_id = $this->session_data->supplier_id;
            }

            $obj->place = $this->input->post('place');

            if ($_FILES['advertisement_image']['name'] != '') {
                $image = $this->uploadImage('advertisement_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'advertisement/add', 'refresh');
                } else if (isset($image['upload_data'])) {
                    $obj->image = $image['upload_data']['file_name'];
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $obj->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $obj->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            if($this->input->post('url') != ''){
                $obj->url = $this->input->post('url');
            }

            if($this->input->post('start_date') != ''){
                $obj->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            }
            
            if($this->input->post('end_date') != ''){
                $obj->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            }

            if($this->session_data->role ==1 || $this->session_data->role ==2){
                $obj->status = $this->input->post('status');
            } else {
                $obj->status = 0;
            }

            $obj->created_id = $this->session_data->id;
            $obj->created_datetime = get_current_date_time()->get_date_time_for_db();
            $obj->updated_id = $this->session_data->id;
            $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
            $obj->save();

            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'advertisement', 'refresh');
        } else{
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('advertisement'));
            
            $obj = new Supplier();
            $data['suppliers'] = $obj->get();
            
            $this->layout->view('user/advertisements/add', $data);
        }
    }

    function editAdvertisement($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $obj = new Advertisement();
                $obj->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $obj->supplier_id = $this->input->post('supplier_id');
                }

                $obj->place = $this->input->post('place');

                if ($_FILES['advertisement_image']['name'] != '') {
                    $image = $this->uploadImage('advertisement_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'advertisement/edit/'. $id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        if (file_exists('assets/uploads/advertisement_images/' . $obj->image)) {
                            unlink('assets/uploads/advertisement_images/' . $obj->image);
                        }

                        $obj->image = $image['upload_data']['file_name'];
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $obj->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $obj->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                if($this->input->post('url') != ''){
                    $obj->url = $this->input->post('url');
                } else{
                    $obj->url = NULL;
                }

                if($this->input->post('start_date') != ''){
                    $obj->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                }
                
                if($this->input->post('end_date') != ''){
                    $obj->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                }

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $obj->status = $this->input->post('status');
                }

                $obj->updated_id = $this->session_data->id;
                $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                $obj->save();

                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'advertisement', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('advertisement'));

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $advertisement = new Advertisement();
                    $data['advertisement'] = $advertisement->where(array('id' => $id))->get();
                    $supplier_id = $data['advertisement']->supplier_id;
                } else if($this->session_data->role == 3){
                    $supplier_id = $this->session_data->supplier_id;
                    $advertisement = new Advertisement();
                    $data['advertisement'] = $advertisement->where(array('id' => $id, 'supplier_id' => $supplier_id))->get();
                }

                if($advertisement->result_count() == 1){
                    $obj = new Supplier();
                    $data['suppliers'] = $obj->get();

                    $this->layout->view('user/advertisements/edit', $data);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
                    redirect(USER_URL . 'advertisement', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'advertisement', 'refresh');
        }
    }

    function approveAdvertisement($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $obj = new Advertisement();
                $obj->where('id', $id)->get();

                if($this->session_data->role ==1 || $this->session_data->role ==2){
                    $obj->status = $this->input->post('status');
                }

                if ($this->input->post('remark') != '') {
                    $obj->remark = $this->input->post('remark');
                }

                $obj->updated_id = $this->session_data->id;
                $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                $obj->save();

                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'advertisement', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('advertisement_approve') . ' ' . $this->lang->line('advertisement'));

                $advertisement = new Advertisement();
                $data['advertisement'] = $advertisement->where(array('id' => $id))->get();
                $supplier_id = $data['advertisement']->supplier_id;

                if($advertisement->result_count() == 1){
                    $this->layout->view('user/advertisements/approval', $data);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
                    redirect(USER_URL . 'advertisement', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'advertisement', 'refresh');
        }
    }

    function deleteAdvertisement($id) {
        if (!empty($id)) {
            $obj_communication = new Advertisement();
            $obj_communication->where('id', $id)->get();
            if ($obj_communication->result_count() == 1) {
                if (file_exists('assets/uploads/advertisement_images/' . $obj_communication->image)) {
                    unlink('assets/uploads/advertisement_images/' . $obj_communication->image);
                }
                $obj_communication->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }

    function uploadImage($field) {
        if ($field == 'advertisement_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/advertisement_images",
                    'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                    'overwrite' => FALSE,
                    'remove_spaces' => TRUE,
                    'encrypt_name' => TRUE
                )
            );
        }
        
        if (!$this->upload->do_upload($field)) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data($field));
        }
        
        return $data;
    }
}
