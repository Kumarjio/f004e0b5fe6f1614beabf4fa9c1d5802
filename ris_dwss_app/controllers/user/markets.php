<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class markets extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Market Templates');
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewMarket() {
        $this->layout->view('user/markets/view');
    }

    function addMarket() {
        if ($this->input->post() !== false) {
            $market = new Market();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $market->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $market->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            if ($_FILES['market_image']['name'] != '') {
                $image = $this->uploadImage('market_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'market/add', 'refresh');
                } else if (isset($image['upload_data'])) {
                    $market->image = $image['upload_data']['file_name'];
                }
            }

            $market->status = $this->input->post('status');
            $market->created_id = $this->session_data->id;
            $market->created_datetime = get_current_date_time()->get_date_time_for_db();
            $market->updated_id = $this->session_data->id;
            $market->update_datetime = get_current_date_time()->get_date_time_for_db();

            $market->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'market', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('market'));
            $this->layout->view('user/markets/add');
        }
    }
    
    function editMarket($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $market = new Market();
                $market->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $market->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $market->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                if ($_FILES['market_image']['name'] != '') {
                    $image = $this->uploadImage('market_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'market/edit/'. $id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        if (!is_null($market->image) && file_exists('assets/uploads/market_images/' . $market->image)) {
                            unlink('assets/uploads/market_images/' . $market->image);
                        }
                        $market->image = $image['upload_data']['file_name'];
                    }
                }

                $market->status = $this->input->post('status');
                $market->updated_id = $this->session_data->id;
                $market->update_datetime = get_current_date_time()->get_date_time_for_db();

                $market->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'market', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('market'));

                $market = new Market();
                $data['market'] = $market->where('id', $id)->get();

                $this->layout->view('user/markets/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(ADMIN_URL . 'market', 'refresh');
        }
    }

    function deleteMarket($id) {
        if (!empty($id)) {
            $obj_market = new Market();
            $obj_market->where('id', $id)->get();
            if ($obj_market->result_count() == 1) {
                if (file_exists('assets/uploads/market_images/' . $obj_market->image)) {
                    unlink('assets/uploads/market_images/' . $obj_market->image);
                }
                $obj_market->delete();
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
        if ($field == 'market_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/market_images",
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
