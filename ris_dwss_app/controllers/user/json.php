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

    public function getProductcategoriesJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'productcategories.' .$this->session_data->language . '_name AS product_category_name', 'productcategories.image');
        $this->datatable->eColumns = array('Productcategories.id');
        $this->datatable->sIndexColumn = "Productcategories.id";
        $this->datatable->sTable = " Productcategories, markets";
        $this->datatable->myWhere = " WHERE Productcategories.market_id = markets.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['product_category_name'];
            $temp_arr[] = 0;
            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/productcategory_images/' . $aRow['image'] .'" alt="" class="img-thumbnail">';

            $str = '';
            if (hasPermission('productcategories', 'editProductcategory')) {
                $str .= '<a href="' . USER_URL . 'productcategory/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('productcategories', 'deleteProductcategory')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getProductsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'products.' .$this->session_data->language . '_name AS product_name', 'products.images');
        $this->datatable->eColumns = array('products.id');
        $this->datatable->sIndexColumn = "products.id";
        $this->datatable->sTable = " products, markets";
        $this->datatable->myWhere = " WHERE products.market_id = markets.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['product_name'];
            if(!empty($aRow['images'])){
                $images = unserialize($aRow['images']);
                $image = $images[rand(0, count($images) - 1)];
                $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/product_images/'. $image .'" alt="" class="img-thumbnail">';
            } else {
                $temp_arr[] = '&nbsp;';
            }

            $str = '';
            if (hasPermission('products', 'editProduct')) {
                $str .= '<a href="' . USER_URL . 'product/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('products', 'deleteProduct')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getProductratesJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('productrates.date', 'products.' .$this->session_data->language . '_name AS product_name', 'productrates.min_rate', 'productrates.max_rate', 'productrates.income', 'productcategories.' .$this->session_data->language . '_name AS product_category_name','markets.' .$this->session_data->language . '_name AS market_name');
        $this->datatable->eColumns = array('productrates.id');
        $this->datatable->sIndexColumn = "productrates.id";
        $this->datatable->sTable = " productrates, productcategories, products, markets";
        $this->datatable->myWhere = " WHERE productcategories.id=products.productcategory_id AND products.market_id = markets.id AND products.id=productrates.product_id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = date('d-m-Y', strtotime($aRow['date']));
            $temp_arr[] = $aRow['product_name'];
            $temp_arr[] = $aRow['min_rate'];
            $temp_arr[] = $aRow['max_rate'];
            $temp_arr[] = $aRow['income'];
            $temp_arr[] = $aRow['product_category_name'];
            $temp_arr[] = $aRow['market_name'];

            $str = '';
            if (hasPermission('productrate', 'editProductrate')) {
                $str .= '<a href="' . USER_URL . 'productrate/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('productrate', 'deleteProductrate')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getSuppliersJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('suppliers.' .$this->session_data->language . '_suppplier_name AS supplier_name', 'suppliers.' .$this->session_data->language . '_shop_name AS shop_name', 'suppliers.mobile_no', 'suppliers.suppliertype_id', 'suppliers.supplierbusinesstypes_id', 'suppliers.supplieramenities_id');
        $this->datatable->eColumns = array('suppliers.id');
        $this->datatable->sIndexColumn = "suppliers.id";
        $this->datatable->sTable = " suppliers";
        $this->datatable->myWhere = " WHERE 1=1";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['supplier_name'];
            $temp_arr[] = $aRow['shop_name'];
            $temp_arr[] = $aRow['mobile_no'];
            $temp_arr[] = $aRow['suppliertype_id'];
            $temp_arr[] = $aRow['supplierbusinesstypes_id'];
            $temp_arr[] = $aRow['supplieramenities_id'];

            $str = '';
            if (hasPermission('productrate', 'editProductrate')) {
                $str .= '<a href="' . USER_URL . 'productrate/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('productrate', 'deleteProductrate')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
    
}
