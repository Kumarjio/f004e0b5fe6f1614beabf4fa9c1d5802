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
        if($this->session_data->role != 1){
            $communication->where('from_id', $this->session_data->id)->get();
            $data['count'] = $communication->result_count();
        } else {
            $data['count'] = $communication->count();
        }

        $this->layout->view('user/communications/view', $data);
    }

    function sendCommunication(){
        if ($this->input->post() !== false) {

            $users = array_unique(array_filter($this->input->post('users')));
            $description = $this->input->post('description');

            foreach ($users as $user) {
                $user_details = explode('--', $user);
                $check = sendSMS($user_details[1], $description);

                $obj = new Communication();
                $obj->from_id = $this->session_data->id;
                $obj->to_id = $user_details[0];
                $obj->mobile_no = $user_details[1];
                $obj->title = $this->input->post('title');
                $obj->message = $description;
                $obj->status = $check;
                $obj->created_id = $this->session_data->id;
                $obj->created_datetime = get_current_date_time()->get_date_time_for_db();
                $obj->updated_id = $this->session_data->id;
                $obj->update_datetime = get_current_date_time()->get_date_time_for_db();
                $obj->save();
            }

            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'communication', 'refresh');
        } else{
            $this->layout->setField('page_title', $this->lang->line('communication_sendsms'));

            $obj = new Communication();
            $data['users_details'] = $obj->getAllNumbersAndEmails();

            $this->layout->view('user/communications/send_sms', $data);
        }
    }

    function resendCommunication($id){
        $obj = new Communication();
        $obj->where(array('id'=>$id, 'from_id' => $this->session_data->id))->get();

        if($obj->result_count() == 1){
            $check = sendSMS($obj->mobile_no, $obj->message);

            $obj_new = new Communication();
            $obj_new->from_id = $this->session_data->id;
            $obj_new->to_id = $obj->to_id;
            $obj_new->mobile_no = $obj->mobile_no;
            $obj_new->title = $obj->title;
            $obj_new->message = $obj->message;
            $obj_new->status = $check;
            $obj_new->created_id = $this->session_data->id;
            $obj_new->created_datetime = get_current_date_time()->get_date_time_for_db();
            $obj_new->updated_id = $this->session_data->id;
            $obj_new->update_datetime = get_current_date_time()->get_date_time_for_db();
            $obj_new->save();
        
            $data = array('status' => 'success', 'msg' => $this->lang->line('send_sms_success'));   
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('send_sms_error'));
        }

        echo json_encode($data);
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
