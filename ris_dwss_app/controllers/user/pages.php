<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class pages extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('page_templates'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewPage() {
        $this->layout->view('user/pages/view');
    }
    
    function editPage($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $page = new Page();
                $page->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_title') != '') {
                        $page->{$key . '_title'} = $this->input->post($key . '_title');
                    } else {
                        $page->{$key . '_title'} = $this->input->post('en_title');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '' && $this->input->post($key . '_description') != '<p><br></p>') {
                        $page->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $page->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $page->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(USER_URL . 'page', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('page_templates'));
                $page = new Page();
                $data['page'] = $page->where('id', $id)->get();
                $this->layout->view('user/pages/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(USER_URL . 'page', 'refresh');
        }
    }
    
}
