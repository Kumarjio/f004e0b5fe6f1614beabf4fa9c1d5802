<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class villages extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('villages'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewVillage() {
        $village = new Village();
        $data['count'] = $village->count();

        $this->layout->view('user/villages/view', $data);
    }

    function addVillage() {
        if ($this->input->post() !== false) {
            $village = new Village();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $village->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $village->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            $village->created_id = $this->session_data->id;
            $village->created_datetime = get_current_date_time()->get_date_time_for_db();
            $village->updated_id = $this->session_data->id;
            $village->update_datetime = get_current_date_time()->get_date_time_for_db();

            $village->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            if($this->input->post('save_add_new') != null) {
                redirect(USER_URL . 'village/add', 'refresh');
            } else {
                redirect(USER_URL . 'village', 'refresh');    
            }
            
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('village'));
            $this->layout->view('user/villages/add');
        }
    }
    
    function editVillage($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $village = new Village();
                $village->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $village->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $village->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                $village->updated_id = $this->session_data->id;
                $village->update_datetime = get_current_date_time()->get_date_time_for_db();

                $village->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'village', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('village'));

                $village = new Village();
                $data['village'] = $village->where('id', $id)->get();

                $this->layout->view('user/villages/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'village', 'refresh');
        }
    }

    function deleteVillage($id) {
        if (!empty($id)) {
            $obj_village = new Village();
            $obj_village->where('id', $id)->get();
            if ($obj_village->result_count() == 1) {
                $obj_village->delete();
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
