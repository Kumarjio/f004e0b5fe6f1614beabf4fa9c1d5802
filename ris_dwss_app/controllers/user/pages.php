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
                $page->title = $this->input->post('title');
                $page->description = $this->input->post('description');
                $page->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(USER_URL . 'page', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('page'));
                $page = new Page();
                $data['page'] = $page->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Page Details';
                $this->layout->view('user/pages/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(USER_URL . 'page', 'refresh');
        }
    }
    


}
