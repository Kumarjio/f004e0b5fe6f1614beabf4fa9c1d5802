<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Dashboard');
        $this->session_data = $this->session->userdata('user_session');
    }
    
    public function index() {
        if (empty($this->session_data)) {
            redirect(USER_URL . 'login', 'refresh');
        } else {
            $data['page_h1_title'] = 'Dashboard';           
            $this->layout->view('user/dashboard/view', $data);
        }
    }
}
