<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class statistics extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('statistical_data'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewStatistic() {
        $this->layout->view('user/statistics/view');
    }

    function addStatistic() {
        if ($this->input->post() !== false) {
            $statistics = new Statistic();
            $statistics->from_year = $this->input->post('from_year');
            $statistics->to_year = $this->input->post('to_year');
            $statistics->market_fee = $this->input->post('market_fee');
            $statistics->license_fee = $this->input->post('license_fee');
            $statistics->other_income = $this->input->post('other_income');
            $statistics->total_income = $this->input->post('total_income');
            $statistics->total_expenses = $this->input->post('total_expenses');
            $statistics->fund_left = $this->input->post('fund_left');
            $statistics->created_id = $this->session_data->id;
            $statistics->created_datetime = get_current_date_time()->get_date_time_for_db();
            $statistics->updated_id = $this->session_data->id;
            $statistics->update_datetime = get_current_date_time()->get_date_time_for_db();
            $statistics->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'statistic', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('statistical_data'));
            $this->layout->view('user/statistics/add');
        }
    }
    
    function editStatistic($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $statistics = new Statistic();
                $statistics->where('id', $id)->get();
                $statistics->from_year = $this->input->post('from_year');
                $statistics->to_year = $this->input->post('to_year');
                $statistics->market_fee = $this->input->post('market_fee');
                $statistics->license_fee = $this->input->post('license_fee');
                $statistics->other_income = $this->input->post('other_income');
                $statistics->total_income = $this->input->post('total_income');
                $statistics->total_expenses = $this->input->post('total_expenses');
                $statistics->fund_left = $this->input->post('fund_left');
                $statistics->updated_id = $this->session_data->id;
                $statistics->update_datetime = get_current_date_time()->get_date_time_for_db();
                $statistics->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'statistic', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('statistical_data'));

                $statistics = new Statistic();
                $data['statistics'] = $statistics->where('id', $id)->get();

                $this->layout->view('user/statistics/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'statistic', 'refresh');
        }
    }

    function deleteStatistic($id) {
        if (!empty($id)) {
            $obj_statistics = new Statistic();
            $obj_statistics->where('id', $id)->get();
            if ($obj_statistics->result_count() == 1) {
                $obj_statistics->delete();
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
