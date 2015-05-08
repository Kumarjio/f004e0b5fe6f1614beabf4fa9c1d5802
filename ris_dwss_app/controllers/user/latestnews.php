<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class latestnews extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('news'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewLatestnews() {
        $news = new News();
        $data['count'] = $news->count();

        $this->layout->view('user/news/view', $data);
    }

    function addLatestnews() {
        if ($this->input->post() !== false) {
            $news = new News();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $news->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $news->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_description') != '') {
                    $news->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $news->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            $news->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
            if($this->input->post('end_date') != ''){
                $news->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            }
        

            $news->status = $this->input->post('status');
            $news->created_id = $this->session_data->id;
            $news->created_datetime = get_current_date_time()->get_date_time_for_db();
            $news->updated_id = $this->session_data->id;
            $news->update_datetime = get_current_date_time()->get_date_time_for_db();

            $news->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'latestnews', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('news'));
            $this->layout->view('user/news/add');
        }
    }
    
    function editLatestnews($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $news = new News();
                $news->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $news->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $news->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_description') != '') {
                        $news->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $news->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $news->start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            
                if($this->input->post('end_date') != ''){
                    $news->end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                }

                $news->status = $this->input->post('status');
                $news->updated_id = $this->session_data->id;
                $news->update_datetime = get_current_date_time()->get_date_time_for_db();

                $news->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'latestnews', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('news'));

                $news = new News();
                $data['news'] = $news->where('id', $id)->get();

                $this->layout->view('user/news/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'latestnews', 'refresh');
        }
    }

    function deleteLatestnews($id) {
        if (!empty($id)) {
            $obj_news = new News();
            $obj_news->where('id', $id)->get();
            if ($obj_news->result_count() == 1) {
                $obj_news->delete();
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
