<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class bods extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('bod'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewBod() {
        $bod = new Bod();
        $data['count'] = $bod->count();

        $this->layout->view('user/bods/view', $data);
    }

    function addBod() {
        if ($this->input->post() !== false) {
            $bod = new Bod();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $bod->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $bod->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_position') != '') {
                    $bod->{$key . '_position'} = $this->input->post($key . '_position');
                } else {
                    $bod->{$key . '_position'} = $this->input->post('en_position');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_address') != '') {
                    $bod->{$key . '_address'} = $this->input->post($key . '_address');
                } else {
                    $bod->{$key . '_address'} = $this->input->post('en_address');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_number') != '') {
                    $bod->{$key . '_number'} = $this->input->post($key . '_number');
                } else {
                    $bod->{$key . '_number'} = $this->input->post('en_number');
                }
            }

            if ($_FILES['bod_image']['name'] != '') {
                $image = $this->uploadImage('bod_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'bod/add', 'refresh');
                } else if (isset($image['upload_data'])) {
                    $bod->image = $image['upload_data']['file_name'];
                }
            }

            $bod->status = $this->input->post('status');
            $bod->created_id = $this->session_data->id;
            $bod->created_datetime = get_current_date_time()->get_date_time_for_db();
            $bod->updated_id = $this->session_data->id;
            $bod->update_datetime = get_current_date_time()->get_date_time_for_db();

            $bod->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'bod', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('bod'));
            $this->layout->view('user/bods/add');
        }
    }
    
    function editBod($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $bod = new Bod();
                $bod->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $bod->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $bod->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                if ($_FILES['bod_image']['name'] != '') {
                    $image = $this->uploadImage('bod_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'bod/edit/'. $id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        if ($bod->image != 'no-avtar.png' && file_exists('assets/uploads/bod_images/' . $bod->image)) {
                            unlink('assets/uploads/bod_images/' . $bod->image);
                        }

                        if ($bod->image != 'no-avtar.png' && file_exists('assets/uploads/bod_images/thumb/' . $bod->image)) {
                            unlink('assets/uploads/bod_images/thumb/' . $bod->image);
                        }
                        $bod->image = $image['upload_data']['file_name'];
                    }
                }

                $bod->status = $this->input->post('status');
                $bod->updated_id = $this->session_data->id;
                $bod->update_datetime = get_current_date_time()->get_date_time_for_db();

                $bod->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'bod', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('bod'));

                $bod = new Bod();
                $data['bod'] = $bod->where('id', $id)->get();

                $this->layout->view('user/bods/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'bod', 'refresh');
        }
    }

    function deleteBod($id) {
        if (!empty($id)) {
            $obj_bod = new Bod();
            $obj_bod->where('id', $id)->get();
            if ($obj_bod->result_count() == 1) {
                if ($obj_bod->image != 'no-avtar.png' && file_exists('assets/uploads/bod_images/' . $obj_bod->image)) {
                    unlink('assets/uploads/bod_images/' . $obj_bod->image);
                }

                if ($obj_bod->image != 'no-avtar.png' && file_exists('assets/uploads/bod_images/thumb/' . $obj_bod->image)) {
                    unlink('assets/uploads/bod_images/thumb/' . $obj_bod->image);
                }
                $obj_bod->delete();
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
        if ($field == 'bod_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/bod_images",
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

            if ($field == 'bod_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/bod_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'exact');
                $magicianObj->saveImage('./assets/uploads/bod_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/bod_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'exact');
                $magicianObj->saveImage('./assets/uploads/bod_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}
