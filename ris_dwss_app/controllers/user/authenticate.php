<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class authenticate extends CI_Controller
{
    
    function __construct() {
        parent::__construct();
        $this->layout->setLayout('user/template/layout_login');
        $this->layout->setField('page_title', $this->lang->line('login_title'));
    }
    
    public function index() {
        $session = $this->session->userdata('user_session');
        if (!empty($session)) {
            redirect(USER_URL . 'dashboard', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('login_title'));
            $this->layout->view('user/authenticate/login');
        }
    }
    
    private function _setSessionData($user) {
        $user->role = $user->role_id;
        unset($user->role_id);
        $user->language = $this->config->item('default_language');

        if($user->role == 3){
            $obj_supplier = new Supplier();
            $obj_supplier->where('user_id', $user->id)->get();
            $user->supplier_id = $obj_supplier->stored->id;
        }

        $newdata = array('user_session' => $user);
        $this->session->set_userdata($newdata);
        return true;
    }
    
    function validateUser() {
        $this->form_validation->set_rules('username', $this->lang->line('email'), 'required');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', $this->lang->line('all_fields_are_compulsory'));
            redirect(USER_URL .'login', 'refresh');
        } else {
            $user = new User();
            $user->where('username', $this->input->post('username'));
            $user->where('password', md5($this->input->post('password')));
            $user->get();
            
            if ($user->result_count() != 1) {
                $this->session->set_flashdata('error', $this->lang->line('invalid_username_password'));
                redirect(USER_URL . 'login', 'refresh');
            } else {
                if($user->stored->status == 1){
                    $this->_setSessionData($user->stored);
                    redirect(USER_URL . 'dashboard', 'refresh');
                } else if($user->stored->status == 0){
                    $this->session->set_flashdata('info', $this->lang->line('user_inactive'));
                    redirect(USER_URL . 'login', 'refresh');
                } else {
                    $this->session->set_flashdata('info', $this->lang->line('login_contact_admin'));
                    redirect(USER_URL . 'login', 'refresh');
                }
            }
        }
    }

    function optimizeTable() {
        $this->load->dbutil();
        CI_DB_utility::optimizeTable();
    }
    
    function logout() {
        $this->session->unset_userdata('user_session');
        $this->session->sess_destroy();
        
        redirect(USER_URL . 'login', 'refresh');
    }
    
    function userForgotPassword() {
        $this->layout->setField('page_title', $this->lang->line('forgot_password'));
        $this->layout->view('user/authenticate/forgot_password');
    }
    
    function userSendResetPasswordLink() {
        $this->form_validation->set_rules('email', $this->lang->line('email_address'), 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', $this->lang->line("all_field_compulsory"));
            redirect(USER_URL .'forgot_password', 'refresh');
        } else {
            $user = new User();
            $user->where('email', $this->input->post('email'))->get();
            
            $email = new Email();
            $email->where('type', 'forgot_password')->get();
            if ($user->result_count() == 1 && $email->result_count() == 1) {
                $random_string = random_string('alnum', 32);
                $user->password = $random_string;
                $user->save();

                $message = $email->message;
                $message = str_replace('#user_name', $user->fullname, $message);
                $link = '<a href="' . USER_URL . 'reset_password/' . $random_string . '">'. $this->lang->line("click_here_reset_mail") .'</a>';
                $message = str_replace('#reset_link', $link, $message);
                
                $option['tomailid'] = $user->email;
                $option['subject'] = $email->subject;
                $option['message'] = $message;
                if (!is_null($email->attachment)) {
                    $option['attachement'] = 'assets/email_attachments/' . $email->attachment;
                }

                if (send_mail($option)) {
                    $this->session->set_flashdata('success', $this->lang->line("forgot_email_success"));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line("forgot_mail_not_send"));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("forgot_email_not_exit"));
            }
            redirect(USER_URL . 'forgot_password', 'refresh');
        }
    }
    
    function userResetPassword($random_string) {
        if ($this->input->post() !== false) {
            $this->form_validation->set_rules('new_password', $this->lang->line("enter_password"), 'required');
            $this->form_validation->set_rules('new_cpassword', $this->lang->line("re_enter_password"), 'required');

            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error', $this->lang->line("all_field_compulsory"));
                redirect(USER_URL .'reset_password/' . $random_string , 'refresh');
            } else if($this->input->post('new_password') != $this->input->post('new_cpassword')){
                $this->session->set_flashdata('error', $this->lang->line("password_dose_not_match"));
                redirect(USER_URL .'reset_password/' . $random_string , 'refresh');
            } else {
                $user = new User();
                $user->where('password', $random_string)->get();
                if ($user->result_count() == 1) {
                    $user->password = md5($this->input->post('new_password'));
                    $user->save();
                    $this->session->set_flashdata('success', $this->lang->line("password_reset_success"));
                    redirect(USER_URL . 'login', 'refresh');
                } else {
                    $this->session->set_flashdata('error', $this->lang->line("password_reset_error"));
                    redirect(USER_URL . 'reset_password/' . $random_string, 'refresh');
                }
            }
        } else {
            $this->layout->setField('page_title', $this->lang->line('reset_password'));
            $data['random_string'] = $random_string;
            $this->layout->view('user/authenticate/reset_password', $data);
        }
    }

    function permissionDenied() {
        $this->layout->view('user/authenticate/permission');
    }
    
    function error_404() {
        $this->layout->view('authenticate/error_404');
    }

}
