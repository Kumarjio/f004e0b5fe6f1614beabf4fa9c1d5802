<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class stafves extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('staff'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewStaff() {
        $staff = new Staff();
        $data['count'] = $staff->count();

        $this->layout->view('user/stafves/view', $data);
    }

    function addStaff() {
        if ($this->input->post() !== false) {
            $staff = new Staff();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $staff->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $staff->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_position') != '') {
                    $staff->{$key . '_position'} = $this->input->post($key . '_position');
                } else {
                    $staff->{$key . '_position'} = $this->input->post('en_position');
                }
            }

            $staff->status = $this->input->post('status');
            $staff->created_id = $this->session_data->id;
            $staff->created_datetime = get_current_date_time()->get_date_time_for_db();
            $staff->updated_id = $this->session_data->id;
            $staff->update_datetime = get_current_date_time()->get_date_time_for_db();

            $staff->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'staff', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('staff'));
            $this->layout->view('user/stafves/add');
        }
    }
    
    function editStaff($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $staff = new Staff();
                $staff->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $staff->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $staff->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_position') != '') {
                        $staff->{$key . '_position'} = $this->input->post($key . '_position');
                    } else {
                        $staff->{$key . '_position'} = $this->input->post('en_position');
                    }
                }

                $staff->status = $this->input->post('status');
                $staff->updated_id = $this->session_data->id;
                $staff->update_datetime = get_current_date_time()->get_date_time_for_db();

                $staff->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'staff', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('staff'));

                $staff = new Staff();
                $data['staff'] = $staff->where('id', $id)->get();

                $this->layout->view('user/stafves/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'staff', 'refresh');
        }
    }

    function deleteStaff($id) {
        if (!empty($id)) {
            $obj_staff = new Staff();
            $obj_staff->where('id', $id)->get();
            if ($obj_staff->result_count() == 1) {
                $obj_staff->delete();
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
        if ($field == 'staff_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/staff_images",
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

            if ($field == 'staff_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/staff_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'exact');
                $magicianObj->saveImage('./assets/uploads/staff_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/staff_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'exact');
                $magicianObj->saveImage('./assets/uploads/staff_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}
