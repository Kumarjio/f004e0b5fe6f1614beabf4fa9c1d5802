<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('user'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewUser() {
        $user = new User();
        $data['count'] = $user->count();

        $role = new Role();
        $data['roles'] = $role->where('id >', $this->session_data->role)->get();

        $this->layout->view('user/users/view', $data);
    }

    function addUser() {
        if ($this->input->post() !== false) {
            $user = new User();
            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_fullname') != '') {
                    $user->{$key . '_fullname'} = $this->input->post($key . '_fullname');
                } else {
                    $user->{$key . '_fullname'} = $this->input->post('en_fullname');
                }
            }

            $user->role_id = @$this->input->post('role_id');
            $user->username =$this->input->post('username');
            $user->password = md5($this->input->post('password'));
            $user->mobile = $this->input->post('mobile');
            $user->email = @$this->input->post('email');
            $user->status = $this->input->post('status');
            $user->created_id = $this->session_data->id;
            $user->created_datetime = get_current_date_time()->get_date_time_for_db();
            $user->updated_id = $this->session_data->id;
            $user->update_datetime = get_current_date_time()->get_date_time_for_db();
            $user->save();

            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'user', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('user'));

            $role = new Role();
            $data['roles'] = $role->where('id >', $this->session_data->role)->get();

            $this->layout->view('user/users/add', $data);
        }
    }
    
    function editUser($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $user = new User();
                $user->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_fullname') != '') {
                        $user->{$key . '_fullname'} = $this->input->post($key . '_fullname');
                    } else {
                        $user->{$key . '_fullname'} = $this->input->post('en_fullname');
                    }
                }

                $user->role_id = @$this->input->post('role_id');
                $user->username =$this->input->post('username');
                if($this->input->post('password') != ''){    
                    $user->password = md5($this->input->post('password'));
                }
                $user->mobile = $this->input->post('mobile');
                $user->email = @$this->input->post('email');
                $user->status = $this->input->post('status');
                $user->updated_id = $this->session_data->id;
                $user->update_datetime = get_current_date_time()->get_date_time_for_db();
                $user->save();
                
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'user', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('user'));

                $user = new User();
                $data['user'] = $user->where('id', $id)->get();

                $role = new Role();
                $data['roles'] = $role->where('id >', $this->session_data->role)->get();

                $this->layout->view('user/users/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'user', 'refresh');
        }
    }

    function deleteUser($id) {
        if (!empty($id)) {
            $obj_user = new User();
            $obj_user->where('id', $id)->get();
            if ($obj_user->result_count() == 1) {
                if ($obj_user->image != 'no-avtar.png' && file_exists('assets/uploads/user_images/' . $obj_user->image)) {
                    unlink('assets/uploads/user_images/' . $obj_user->image);
                }

                if ($obj_user->image != 'no-avtar.png' && file_exists('assets/uploads/user_images/thumb/' . $obj_user->image)) {
                    unlink('assets/uploads/user_images/thumb/' . $obj_user->image);
                }
                $obj_user->delete();
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
        if ($field == 'user_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/user_images",
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

            if ($field == 'user_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/user_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'exact');
                $magicianObj->saveImage('./assets/uploads/user_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/user_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'exact');
                $magicianObj->saveImage('./assets/uploads/user_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}
