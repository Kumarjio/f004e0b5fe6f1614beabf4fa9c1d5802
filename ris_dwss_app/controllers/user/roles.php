<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class roles extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Roles');
        $this->session_data = $this->session->userdata('user_session');
        $this->load->library('acl');
    }
    
    function viewRole() {
        $data['page_h1_title'] = 'View Roles';
        $this->layout->view('user/roles/view', $data);
    }
    
    function editRole($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $role = new Role();
                $role->where('id', $id)->get();
                $role->name = $this->input->post('name');
                $role->permission = serialize($this->input->post('perm'));
                $role->user_id = $this->session_data->id;
                $role->save();
                $this->session->set_flashdata('success', 'Updated data successfully');
                redirect(USER_URL . 'role', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Role');
                
                $data['page_h1_title'] = 'Edit Role';

                $role = new Role();
                $data['role'] = $role->where('id', $id)->get();
                
                $this->layout->view('user/roles/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in Editing Data');
            redirect(USER_URL . 'role', 'refresh');
        }
    }
}
