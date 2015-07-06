<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class commodities extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('commodities'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewCommodity() {
        $commodity = new Commodity();
        $data['count'] = $commodity->count();

        $this->layout->view('user/commodities/view', $data);
    }

    function addCommodity() {
        if ($this->input->post() !== false) {
            $commodity = new Commodity();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $commodity->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $commodity->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_desc') != '') {
                    $commodity->{$key . '_desc'} = $this->input->post($key . '_desc');
                } else {
                    $commodity->{$key . '_desc'} = $this->input->post('en_desc');
                }
            }

            $commodity->created_id = $this->session_data->id;
            $commodity->created_datetime = get_current_date_time()->get_date_time_for_db();
            $commodity->updated_id = $this->session_data->id;
            $commodity->update_datetime = get_current_date_time()->get_date_time_for_db();

            $commodity->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'commodity', 'refresh');    
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('commodity'));
            $this->layout->view('user/commodities/add');
        }
    }
    
    function editCommodity($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $commodity = new Commodity();
                $commodity->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $commodity->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $commodity->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_desc') != '') {
                        $commodity->{$key . '_desc'} = $this->input->post($key . '_desc');
                    } else {
                        $commodity->{$key . '_desc'} = $this->input->post('en_desc');
                    }
                }

                $commodity->updated_id = $this->session_data->id;
                $commodity->update_datetime = get_current_date_time()->get_date_time_for_db();

                $commodity->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'commodity', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('commodity'));

                $commodity = new Commodity();
                $data['commodity'] = $commodity->where('id', $id)->get();

                $this->layout->view('user/commodities/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'commodity', 'refresh');
        }
    }

    function deleteCommodity($id) {
        if (!empty($id)) {
            $obj_commodity = new Commodity();
            $obj_commodity->where('id', $id)->get();
            if ($obj_commodity->result_count() == 1) {
                $obj_commodity->delete();
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
