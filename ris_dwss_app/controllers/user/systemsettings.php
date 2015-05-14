<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class systemsettings extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Settings');
        $this->session_data = $this->session->userdata('user_session');
    }
    
    public function viewSystemSetting($type = null) {
        if (is_null($type) || is_integer($type)) {
            $this->session->set_flashdata('error', $this->lang->line('unauthorize_access'));
            redirect(USER_URL . 'dashboard', 'refresh');
        }
        
        $setting = new Systemsetting();
        $data['setting'] = $setting->where('type', $type)->order_by('sequence', 'ASC')->get();

        switch ($type) {
            case 'general':
                $data['page_h1_title'] = 'General Setting';
                $this->layout->view('user/systemsettings/general_setting', $data);
                break;
            case 'update_general':
                $this->_updateSetting('general');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(USER_URL . 'system_setting/general', 'refresh');
                break;
            case 'mail':
                $data['page_h1_title'] = 'Mail Setting';
                $this->layout->view('user/systemsettings/mail_setting', $data);
                break;
            case 'update_mail':
                $this->_updateSetting('mail');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(USER_URL . 'system_setting/mail', 'refresh');
                break;
            case 'login_credential':
                $data['page_h1_title'] = 'Login Credential';
                $this->layout->view('user/systemsettings/login_credential_setting', $data);
                break;
            case 'update_login_credential':
                $this->_updateSetting('login_credential');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(USER_URL . 'system_setting/login_credential', 'refresh');
                break;
            default:
                $data['page_h1_title'] = 'General Setting';
                $this->layout->view('user/systemsettings/general_setting', $data);
                break;
        }
    }
    
    private function _updateSetting($type) {
        $setting = new Systemsetting();
        $setting->where('type', $type)->get();

        foreach ($setting as $value) {
            if($value->sys_key != 'smtp_pass'){
                $setting->where('sys_key', $value->sys_key)->update('sys_value', htmlentities($this->input->post($value->sys_key)));
            } else {
                $setting->where('sys_key', $value->sys_key)->update('sys_value', $this->input->post($value->sys_key));
            }
        }

        return TRUE;
    }
}
