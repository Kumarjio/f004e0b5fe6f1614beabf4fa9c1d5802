<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class communications extends CI_Controller {
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('communication'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewCommunication() {
        $communication = new Communication();
        $data['count'] = $communication->count();

        $this->layout->view('user/communications/view', $data);
    }

    function sendCommunication(){
        if ($this->input->post() !== false) {
            $mobile_nos = $this->input->post('mobile');
            $description = $this->input->post('description');
            foreach ($mobile_nos as $mobile) {
                if(!empty($mobile)){
                    $check = sendSMS($mobile, $description);

                    $obj = new Communication();
                    $obj->from_id = $this->session_data->id;
                    $obj->to_id = $to_id;
                    $obj->mobile_no = $mobile;
                    $obj->message = $description;
                    $obj->status = $check;
                    $obj->created_id = $this->session_data->id;
                    $obj->created_datetime = get_current_date_time()->get_date_time_for_db();
                    $obj->updated_id = $this->session_data->id;
                    $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                    $obj->save();
                }
            }

            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'communication', 'refresh');
        } else{
            $this->layout->view('user/communicationss/send_sms', $data);
        }
    }

    function resendCommunication(){

    }

    function deleteCommunication($id) {
        if (!empty($id)) {
            $obj_communication = new Communication();
            $obj_communication->where('id', $id)->get();
            if ($obj_communication->result_count() == 1) {
                $obj_communication->delete();
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
