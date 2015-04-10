<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class json extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->session_data = $this->session->userdata('user_session');

        if (empty($this->session_data)) {
            redirect(USER_URL . 'login', 'refresh');
        }
    }

    public function getEmailsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('subject');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " emails";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['subject'];
            if (hasPermission('emails', 'editEmail')) {
                $temp_arr[] = '<a href="' . USER_URL . 'email/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            } else {
                $temp_arr[] = '';
            }
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getRolesJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('name');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = 'id';
        $this->datatable->sTable = 'roles';
        $this->datatable->myWhere = ' WHERE id > 1';
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] =  $aRow['name'];

            if (hasPermission('roles', 'editRole')) {
                $temp_arr[] = '<a href="' . USER_URL . 'role/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            } else {
                $temp_arr[] = '';
            }

            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getMarketsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', 'image','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " markets";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/market_images/' . $aRow['image'] .'" alt="" class="img-thumbnail">';

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('markets', 'editMarket')) {
                $str .= '<a href="' . USER_URL . 'market/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('markets', 'deleteMarket')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getNewsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', 'start_date','end_date','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " news";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];

            $temp_arr[] =  date('d-m-Y', strtotime($aRow['start_date']));
            if(!empty($aRow['end_date'])){
                $temp_arr[] =  date('d-m-Y', strtotime($aRow['end_date']));
            } else {
                $temp_arr[] = '';
            }

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('latestnews', 'editLatestnews')) {
                $str .= '<a href="' . USER_URL . 'latestnews/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('latestnews', 'deleteLatestnews')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getTendersJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', 'start_date','end_date','file','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " tenders";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];

            $temp_arr[] =  date('d-m-Y', strtotime($aRow['start_date']));
            if(!empty($aRow['end_date'])){
                $temp_arr[] =  date('d-m-Y', strtotime($aRow['end_date']));
            } else {
                $temp_arr[] = '';
            }

            $temp_arr[] = '<a href="'. USER_URL.'tender/download/'. $aRow['id'] .'/' . $aRow['file'] .'">'. $this->lang->line('download') .'</a>';

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('tenders', 'editTender')) {
                $str .= '<a href="' . USER_URL . 'tender/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('tenders', 'deleteTender')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getBodsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', $this->session_data->language . '_number', $this->session_data->language . '_position', 'image', 'status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " bods";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];
            $temp_arr[] = $aRow[$this->session_data->language . '_number'];
            $temp_arr[] = $aRow[$this->session_data->language . '_position'];

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/bod_images/' . $aRow['image'] .'" alt="" class="img-thumbnail">';

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('bods', 'editBod')) {
                $str .= '<a href="' . USER_URL . 'bod/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('bods', 'deleteBod')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getStafvesJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'stafves.' .$this->session_data->language . '_name AS staff_name', $this->session_data->language . '_number', $this->session_data->language . '_position', 'stafves.image', 'stafves.status');
        $this->datatable->eColumns = array('stafves.id');
        $this->datatable->sIndexColumn = "stafves.id";
        $this->datatable->sTable = " stafves, markets";
        $this->datatable->myWhere = " WHERE stafves.market_id = markets.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['staff_name'];
            $temp_arr[] = $aRow[$this->session_data->language . '_number'];
            $temp_arr[] = $aRow[$this->session_data->language . '_position'];

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/staff_images/' . $aRow['image'] .'" alt="" class="img-thumbnail">';

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('stafves', 'editStaff')) {
                $str .= '<a href="' . USER_URL . 'staff/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('stafves', 'deleteStaff')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
    
}
