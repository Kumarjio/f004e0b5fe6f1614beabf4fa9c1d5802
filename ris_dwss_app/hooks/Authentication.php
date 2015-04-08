<?php

class Authentication extends CI_Controller {

    var $allowed_for_all;
    var $allowed_controller;

    public function __construct() {
        parent::__construct();
        $this->__clear_cache();
        $this->setAllowedMethod();
        $this->setAllowedController();
        $this->setSystemSetting();
        setLanguage();
    }

    private function __clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function checkLogin() {
        $array = array('authenticate');
        $path = explode('/', $_SERVER['REQUEST_URI']);

        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '192.168.1.29') {
            $path_admin = $path[2];
        } else {
            $path_admin = $path[2];
        }

        if ($path_admin == 'user' && !in_array($this->router->class, $array)) {
            $session = $this->session->userdata('user_session');
            if (empty($session)) {
                $this->session->set_flashdata('error', 'Please do login first');
                redirect(USER_URL . 'login', 'refresh');
            } else {
                $this->checkPermission();
            }
        }
    }

    private function setAllowedController() {
        $this->allowed_controller = array(
            'authenticate',
            'json',
            'dashboard'
        );
    }

    private function setAllowedMethod() {
        $this->allowed_for_all = array();
    }

    function checkPermission() {
        if ($this->router->fetch_directory() == "user/" && !in_array($this->router->class, $this->allowed_controller) && !in_array($this->router->method, $this->allowed_for_all)) {

            $session = $this->session->userdata('user_session');
            if (isset($session) && !empty($session)) {
                if (hasPermission($this->router->class, $this->router->method) === false) {
                    $this->session->set_flashdata('error', 'You dont have permission to see it Please contact Administrator');
                    redirect(USER_URL . 'denied', 'refresh');
                }
            }
        }
    }

    function setSystemSetting() {
        foreach (Systemsetting::getSystemSetting() as $value) {
            $this->config->set_item($value['sys_key'], $value['sys_value']);
        }

        $session = $this->session->userdata('user_session');
        if (isset($session) && !empty($session)) {
            $user = new User();
            $permissions = $user->userRoleByID($session->id, $session->role);
            $this->config->set_item('user_premission', $permissions);
        }
    }

}

?>