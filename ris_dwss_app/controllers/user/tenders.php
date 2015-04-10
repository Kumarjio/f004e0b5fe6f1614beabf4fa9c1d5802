<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class tenders extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('tender'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewTender() {
        $this->layout->view('user/tenders/view');
    }

    function addTender() {
        if ($this->input->post() !== false) {
            $tender = new Tender();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $tender->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $tender->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_description') != '') {
                    $tender->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $tender->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            if ($_FILES['tender_file']['name'] != '') {
                $file = $this->uploadImage('tender_file');
                if (isset($file['error'])) {
                    $this->session->set_flashdata('file_errors', $file['error']);
                    redirect(USER_URL . 'tender/add', 'refresh');
                } else if (isset($file['upload_data'])) {
                    $tender->file = $file['upload_data']['file_name'];
                }
            }

            $tender->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
            if($this->input->post('end_date') != ''){
                $tender->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            } else {
                $tender->end_date = null;
            }

            $tender->status = $this->input->post('status');
            $tender->created_id = $this->session_data->id;
            $tender->created_datetime = get_current_date_time()->get_date_time_for_db();
            $tender->updated_id = $this->session_data->id;
            $tender->update_datetime = get_current_date_time()->get_date_time_for_db();

            $tender->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'tender', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('tender'));
            $this->layout->view('user/tenders/add');
        }
    }
    
    function editTender($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $tender = new Tender();
                $tender->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $tender->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $tender->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '') {
                        $tender->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $tender->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                if ($_FILES['tender_file']['name'] != '') {
                    $file = $this->uploadImage('tender_file');
                    if (isset($file['error'])) {
                        $this->session->set_flashdata('file_errors', $file['error']);
                        redirect(USER_URL . 'tender/edit/' .$id, 'refresh');
                    } else if (isset($file['upload_data'])) {
                        if (!is_null($tender->file) && file_exists('assets/uploads/tender_files/' . $tender->file)) {
                            unlink('assets/uploads/tender_files/' . $tender->file);
                        }
                        $tender->file = $file['upload_data']['file_name'];
                    }
                }

                $tender->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                
                if($this->input->post('end_date') != ''){
                    $tender->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                } else {
                    $tender->end_date = null;
                }

                $tender->status = $this->input->post('status');
                $tender->updated_id = $this->session_data->id;
                $tender->update_datetime = get_current_date_time()->get_date_time_for_db();

                $tender->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'tender', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('tender'));

                $tender = new Tender();
                $data['tender'] = $tender->where('id', $id)->get();

                $this->layout->view('user/tenders/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'tender', 'refresh');
        }
    }

    function deleteTender($id) {
        if (!empty($id)) {
            $obj_tender = new Tender();
            $obj_tender->where('id', $id)->get();
            if ($obj_tender->result_count() == 1) {
                if (file_exists('assets/uploads/tender_files/' . $obj_tender->file)) {
                    unlink('assets/uploads/tender_files/' . $obj_tender->file);
                }
                $obj_tender->delete();
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
        if ($field == 'tender_file') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/tender_files",
                    'allowed_types' => 'jpg|jpeg|gif|png|bmp|pdf|doc|docx|xls|xlxs',
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
