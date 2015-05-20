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

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/market_images/' . $aRow['image'] .'" alt="" class="img-thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">';

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
        $status    = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $where = '1=1';
        if($status == '0' || $status == '1'){
            $where .= ' AND status=' . $status; 
        }

        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND start_date >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND end_date <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', 'start_date','end_date','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " news";
        $this->datatable->myWhere = " WHERE $where";
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
        $status    = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $where = '1=1';
        if($status == '0' || $status == '1'){
            $where .= ' AND status=' . $status; 
        }

        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND start_date >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND end_date <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', 'start_date','end_date','file','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " tenders";
        $this->datatable->myWhere = " WHERE $where";
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
        $status    = $this->input->get('status');

        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_name', $this->session_data->language . '_number', $this->session_data->language . '_position', 'image', 'status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " bods";
        if($status == '0' || $status == '1'){
            $this->datatable->myWhere = ' WHERE status=' . $status; 
        }
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];
            $temp_arr[] = $aRow[$this->session_data->language . '_number'];
            $temp_arr[] = $aRow[$this->session_data->language . '_position'];

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/bod_images/' . $aRow['image'] .'" alt="" class="img-thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">';

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
        $status    = $this->input->get('status');
        $market_id = $this->input->get('market_id');

        $where = '';
        if($status == '0' || $status == '1'){
            $where .= ' AND stafves.status=' . $status; 
        }

        if(!empty($market_id) && strtolower($market_id) != 'null'){
            $where .= ' AND stafves.market_id =' . $market_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'stafves.' .$this->session_data->language . '_name AS staff_name', $this->session_data->language . '_number', $this->session_data->language . '_position', 'stafves.image', 'stafves.status');
        $this->datatable->eColumns = array('stafves.id');
        $this->datatable->sIndexColumn = "stafves.id";
        $this->datatable->sTable = " stafves, markets";
        $this->datatable->myWhere = " WHERE stafves.market_id = markets.id $where";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['staff_name'];
            $temp_arr[] = $aRow[$this->session_data->language . '_number'];
            $temp_arr[] = $aRow[$this->session_data->language . '_position'];

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/staff_images/' . $aRow['image'] .'" alt="" class="img-thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">';

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
        $market_id = $this->input->get('market_id');

        $where = '';
        if(!empty($market_id) && strtolower($market_id) != 'null'){
            $where .= ' AND productcategories.market_id =' . $market_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'productcategories.' .$this->session_data->language . '_name AS product_category_name', '(SELECT COUNT(*) FROM products WHERE products.productcategory_id = productcategories.id) AS total_product','productcategories.image');
        $this->datatable->eColumns = array('productcategories.id');
        $this->datatable->sIndexColumn = "productcategories.id";
        $this->datatable->sTable = " productcategories, markets";
        $this->datatable->myWhere = " WHERE productcategories.market_id = markets.id $where";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['product_category_name'];
            $temp_arr[] = $aRow['total_product'];
            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/productcategory_images/' . $aRow['image'] .'" alt="" class="img-thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">';

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
        $market_id = $this->input->get('market_id');
        $product_category = $this->input->get('product_category');

        $where = '';
        if(!empty($market_id) && strtolower($market_id) != 'null'){
            $where .= ' AND products.market_id =' . $market_id; 
        }

        if(!empty($product_category) && strtolower($product_category) != 'null'){
            $where .= ' AND products.productcategory_id =' . $product_category; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('markets.' .$this->session_data->language . '_name AS market_name', 'productcategories.' .$this->session_data->language . '_name AS category_name','products.' .$this->session_data->language . '_name AS product_name', 'products.images');
        $this->datatable->eColumns = array('products.id');
        $this->datatable->sIndexColumn = "products.id";
        $this->datatable->sTable = " products, markets, productcategories";
        $this->datatable->myWhere = " WHERE products.market_id = markets.id AND products.productcategory_id = productcategories.id $where";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['category_name'];
            $temp_arr[] = $aRow['product_name'];
            if(!empty($aRow['images'])){
                $images = unserialize($aRow['images']);
                $image = $images[rand(0, count($images) - 1)];
                $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/product_images/'. $image .'" alt="" class="img-thumbnail col-xs-12 col-sm-12 col-md-12 col-lg-12">';
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
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');
        $market_id = $this->input->get('market_id');
        $product_category = $this->input->get('product_category');
        $product_id = $this->input->get('product_id');

        $where = '';
        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND productrates.date >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND productrates.date <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        if(!empty($market_id) && strtolower($market_id) != 'null'){
            $where .= ' AND products.market_id =' . $market_id; 
        }

        if(!empty($product_category) && strtolower($product_category) != 'null'){
            $where .= ' AND products.productcategory_id =' . $product_category; 
        }

        if(!empty($product_id) && strtolower($product_id) != 'null'){
            $where .= ' AND productrates.product_id =' . $product_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('productrates.date', 'products.' .$this->session_data->language . '_name AS product_name', 'productrates.min_rate', 'productrates.max_rate', 'productrates.income', 'productcategories.' .$this->session_data->language . '_name AS product_category_name','markets.' .$this->session_data->language . '_name AS market_name');
        $this->datatable->eColumns = array('productrates.id');
        $this->datatable->sIndexColumn = "productrates.id";
        $this->datatable->sTable = " productrates, productcategories, products, markets";
        $this->datatable->myWhere = " WHERE productcategories.id=products.productcategory_id AND products.market_id = markets.id AND products.id=productrates.product_id $where";
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
        $market_id = $this->input->get('market_id');
        $suppliertype_id = $this->input->get('suppliertype_id');
        $supplierbusinesstype_id = $this->input->get('supplierbusinesstype_id');
        $supplieramenity_id = $this->input->get('supplieramenity_id');

        $where = '';
        if(!empty($market_id) && strtolower($market_id) != 'null'){
            $where .= ' AND suppliers.market_id =' . $market_id; 
        }

        if(!empty($suppliertype_id) && strtolower($suppliertype_id) != 'null'){
            $where .= ' AND FIND_IN_SET('. $suppliertype_id .', suppliers.suppliertype_id)';
        }

        if(!empty($supplierbusinesstype_id) && strtolower($supplierbusinesstype_id) != 'null'){
            $where .= ' AND FIND_IN_SET('. $supplierbusinesstype_id .', suppliers.supplierbusinesstype_id)';
        }

        if(!empty($supplieramenity_id) && strtolower($supplieramenity_id) != 'null'){
            $where .= ' AND FIND_IN_SET('. $supplieramenity_id .', suppliers.supplieramenity_id)';
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array(
            'users.' .$this->session_data->language . '_fullname AS supplier_name',
            'suppliers.' .$this->session_data->language . '_shop_name AS shop_name',
            'markets.' .$this->session_data->language . '_name AS market_name',
            'GROUP_CONCAT(DISTINCT(suppliertypes.'. $this->session_data->language . '_name)) AS supplier_types',
            'GROUP_CONCAT(DISTINCT(supplierbusinesstypes.'. $this->session_data->language . '_name)) AS supplierbusiness_types',
            'GROUP_CONCAT(DISTINCT(supplieramenities.'. $this->session_data->language . '_name)) AS supplieramenities',
        );
        $this->datatable->eColumns = array('suppliers.id');
        $this->datatable->sIndexColumn = "suppliers.id";
        $this->datatable->sTable = " users, suppliertypes, suppliers, supplierbusinesstypes, supplieramenities, markets";
        $this->datatable->myWhere = " WHERE users.id=suppliers.user_id AND suppliers.market_id = markets.id AND FIND_IN_SET(suppliertypes.id, suppliers.suppliertype_id) AND FIND_IN_SET(supplierbusinesstypes.id, suppliers.supplierbusinesstype_id) AND FIND_IN_SET(supplieramenities.id, suppliers.supplieramenity_id) $where";
        $this->datatable->groupBy = " GROUP BY suppliertype_id, supplierbusinesstype_id, supplieramenity_id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['supplier_name'];
            $temp_arr[] = $aRow['shop_name'];
            $temp_arr[] = $aRow['market_name'];
            $temp_arr[] = $aRow['supplier_types'];
            $temp_arr[] = $aRow['supplierbusiness_types'];
            $temp_arr[] = $aRow['supplieramenities'];

            $str = '';
            if (hasPermission('suppliers', 'manageProductSupplier')) {
                $str .= '<a href="' . USER_URL . 'supplier/product/' . $aRow['id'] . '" class="btn btn-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('manage') . ' ' . $this->lang->line('supplier_prodcut') .'"><i class="clip-list-2"></i></a>';
            }

            if (hasPermission('suppliers', 'editSupplier')) {
                $str .= '&nbsp;<a href="' . USER_URL . 'supplier/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('suppliers', 'deleteSupplier')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getPagesJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_title AS title');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " pages";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['title'];
            $str = '';
            if (hasPermission('productrate', 'editProductrate')) {
                $str .= '<a href="' . USER_URL . 'productrate/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }
            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getSelloffersJsonData() {
        $status    = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $where = '';
        if($status == '0' || $status == '1'){
            $where .= ' AND selloffers.status=' . $status; 
        }

        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND selloffers.start_date >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND selloffers.end_date <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        if($this->session_data->role == 3){
            $where .= ' AND selloffers.supplier_id =' . $this->session_data->supplier_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('products.'.$this->session_data->language . '_name AS product', 'selloffers.'.$this->session_data->language . '_title AS title', 'selloffers.start_date','selloffers.end_date','selloffers.status');
        $this->datatable->eColumns = array('selloffers.id');
        $this->datatable->sIndexColumn = "selloffers.id";
        $this->datatable->sTable = " selloffers, products";
        $this->datatable->myWhere = " WHERE selloffers.product_id=products.id $where";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['product'];
            $temp_arr[] = $aRow['title'];

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
            if (hasPermission('selloffers', 'editSelloffer')) {
                $str .= '<a href="' . USER_URL . 'selloffer/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('selloffers', 'deleteSelloffer')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getSupplierrequrimentsJsonData() {
        $status    = $this->input->get('status');
        
        $where = '1=1';
        if($status == '0' || $status == '1'){
            $where .= ' AND status=' . $status; 
        }

        if($this->session_data->role == 3){
            $where .= ' AND supplier_id =' . $this->session_data->supplier_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array($this->session_data->language . '_title AS title','status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " supplierrequriments";
        $this->datatable->myWhere = " WHERE $where";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['title'];

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('in_active') .'">'. $this->lang->line('in_active') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('active') .'">'. $this->lang->line('active') .'</span>';
            }

            $str = '';
            if (hasPermission('supplierrequriments', 'smsSupplierrequriment')) {
                $str .= '<a href="' . USER_URL . 'supplierrequriment/sms/' . $aRow['id'] . '" class="btn btn-green" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('supplierrequriment_viewsms') .'"><i class="icon-envelope"></i></a>';
            }

            if (hasPermission('supplierrequriments', 'editSupplierrequriment')) {
                $str .= '&nbsp;<a href="' . USER_URL . 'supplierrequriment/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('supplierrequriments', 'deleteSupplierrequriment')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function getSmsSupplierrequrimentJsonData(){
        $id = $this->input->get('id');
        $status    = $this->input->get('status');

        if(!empty($id)){
            $where = null;
            if($status == '0' || $status == '1'){
                $where .= ' AND supplierrequrimentsms.status=' . $status; 
            }

            if($this->session_data->role == 3){
                $where .= ' AND supplierrequriments.supplier_id =' . $this->session_data->supplier_id; 
            }

            $this->load->library('datatable');
            $this->datatable->aColumns = array('supplierrequriments.' . $this->session_data->language . '_title AS title','supplierrequrimentsms.mobile_no','supplierrequrimentsms.status');
            $this->datatable->eColumns = array('supplierrequrimentsms.id');
            $this->datatable->sIndexColumn = "supplierrequrimentsms.id";
            $this->datatable->sTable = " supplierrequriments, supplierrequrimentsms";
            $this->datatable->myWhere = " WHERE supplierrequrimentsms.supplierrequriment_id=supplierrequriments.id AND supplierrequrimentsms.supplierrequriment_id = " . $id . $where;
            $this->datatable->datatable_process();

            foreach ($this->datatable->rResult->result_array() as $aRow) {
                $temp_arr = array();
                $temp_arr[] = $aRow['title'];
                $temp_arr[] = $aRow['mobile_no'];

                if($aRow['status'] == 0){
                    $temp_arr[] = '<span class="label label-warning" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('not_delivered') .'">'. $this->lang->line('not_delivered') .'</span>';
                } else {
                    $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('delivered') .'">'. $this->lang->line('delivered') .'</span>';
                }

                $str = '';
                if (hasPermission('supplierrequriments', 'resendSmsSupplierrequriment')) {
                    $str .= '&nbsp;<a href="javascript:;" onclick="resendsms(this)" class="btn btn-green" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('supplierrequriment_resendsms') .'" title="'. $this->lang->line('supplierrequriment_resendsms') .'"><i class="icon-remove icon-refresh"></i></i></a>';
                }

                if (hasPermission('supplierrequriments', 'deleteSmsSupplierrequriment')) {
                    $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
                }

                $temp_arr[] = $str;

                $this->datatable->output['aaData'][] = $temp_arr;
            }
        } else {
            $this->datatable->output['aaData'][] = array();
        }

        echo json_encode($this->datatable->output);
        exit();    
    }

    function getCommunicationsJsonData(){
        $id = $this->input->get('id');
        $status    = $this->input->get('status');

        $where = null;
        if($status == '0' || $status == '1'){
            $where .= ' AND communications.status=' . $status; 
        }

        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND communications.created_datetime >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND communications.created_datetime <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        if($this->session_data->role == 3){
            $where .= ' AND communications.from_id =' . $this->session_data->id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('from_user.' . $this->session_data->language .'_fullname AS from_username', 'to_user.' . $this->session_data->language .'_fullname AS to_username', 'communications.mobile_no', 'communications.title', 'communications.message', 'communications.status');
        $this->datatable->eColumns = array('communications.id', 'communications.from_id', 'communications.to_id');
        $this->datatable->sIndexColumn = "communications.id";
        $this->datatable->sTable = " communications, users from_user, users to_user";
        $this->datatable->myWhere = " WHERE from_user.id=communications.from_id AND  to_user.id=communications.to_id" . $where;
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['from_username'];
            $temp_arr[] = $aRow['to_username'];
            $temp_arr[] = $aRow['mobile_no'];
            $temp_arr[] = $aRow['title'];
            $temp_arr[] = $aRow['message'];

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-warning" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('not_delivered') .'">'. $this->lang->line('not_delivered') .'</span>';
            } else {
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('delivered') .'">'. $this->lang->line('delivered') .'</span>';
            }

            $str = '';
            if (hasPermission('communications', 'resendCommunication')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="resendsms(this)" class="btn btn-green" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('supplierrequriment_resendsms') .'" title="'. $this->lang->line('supplierrequriment_resendsms') .'"><i class="icon-remove icon-refresh"></i></i></a>';
            }

            if (hasPermission('communications', 'deleteCommunication')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }

        echo json_encode($this->datatable->output);
        exit();
    }

    public function getAdvertisementsJsonData() {
        $status    = $this->input->get('status');
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $where = '';
        if($status == '0' || $status == '1'){
            $where .= ' AND advertisements.status=' . $status; 
        }

        if(!empty($start_date) && strtolower($start_date) != 'null'){
            $where .= ' AND advertisements.start_date >=\'' . date('Y-m-d', strtotime($start_date)) .'\''; 
        }

        if(!empty($end_date) && strtolower($end_date) != 'null'){
            $where .= ' AND advertisements.end_date <=\'' . date('Y-m-d', strtotime($end_date)) .'\''; 
        }

        if($this->session_data->role == 3){
            $where .= ' AND advertisements.supplier_id =' . $this->session_data->supplier_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('place','suppliers.'.$this->session_data->language . '_shop_name', 'advertisements.'.$this->session_data->language . '_name', 'start_date','end_date','status');
        $this->datatable->eColumns = array('advertisements.id');
        $this->datatable->sIndexColumn = "advertisements.id";
        $this->datatable->sTable = " advertisements, suppliers";
        $this->datatable->myWhere = " WHERE suppliers.id=advertisements.supplier_id $where";
        $this->datatable->datatable_process();
        
        $places = $this->config->item('advertisement_places');
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();

            if($aRow['place'] == 'T'){
                $temp_arr[] = '<label class="label label-warning">'. $places[$aRow['place']][$this->session_data->language] .'<label>';    
            } else if($aRow['place'] == 'R'){
                $temp_arr[] = '<label class="label label-success">'. $places[$aRow['place']][$this->session_data->language] .'<label>';    
            } else if($aRow['place'] == 'B'){
                $temp_arr[] = '<label class="label label-info">'. $places[$aRow['place']][$this->session_data->language] .'<label>';    
            } else if($aRow['place'] == 'L'){
                $temp_arr[] = '<label class="label label-danger">'. $places[$aRow['place']][$this->session_data->language] .'<label>';    
            }
            
            $temp_arr[] = $aRow[$this->session_data->language . '_shop_name'];
            $temp_arr[] = $aRow[$this->session_data->language . '_name'];

            $temp_arr[] =  date('d-m-Y', strtotime($aRow['start_date']));
            if(!empty($aRow['end_date'])){
                $temp_arr[] =  date('d-m-Y', strtotime($aRow['end_date']));
            } else {
                $temp_arr[] = '';
            }

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-warning" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('pending') .'">'. $this->lang->line('pending') .'</span>';
            } else if($aRow['status'] == 1){
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('approved') .'">'. $this->lang->line('approved') .'</span>';
            } else if($aRow['status'] == 2){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('unapproved') .'">'. $this->lang->line('unapproved') .'</span>';
            }  else if($aRow['status'] == 3){
                $temp_arr[] = '<span class="label label-info" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('over') .'">'. $this->lang->line('over') .'</span>';
            }

            $str = '';

            if (hasPermission('advertisements', 'approveAdvertisement')) {
                $str .= '<a href="' . USER_URL . 'advertisement/approve/' . $aRow['id'] . '" class="btn btn-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('advertisement_approve') .'"><i class="clip-checkmark"></i></a>';
            }

            if ($aRow['status'] != 3 && hasPermission('advertisements', 'editAdvertisement')) {
                $str .= '&nbsp;<a href="' . USER_URL . 'advertisement/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            if (hasPermission('advertisements', 'deleteAdvertisement')) {
                $str .= '&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="btn btn-bricky" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="'. $this->lang->line('delete') .'" title="'. $this->lang->line('delete') .'"><i class="icon-remove icon-white"></i></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getPacketsJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array( 'products.'.$this->session_data->language . '_name');
        $this->datatable->eColumns = array('supplierproducts.id', 'supplierproducts.product_id');
        $this->datatable->sIndexColumn = "supplierproducts.id";
        $this->datatable->sTable = " supplierproducts, products";
        $this->datatable->myWhere = " WHERE products.id=supplierproducts.product_id AND supplierproducts.supplier_id=" . $this->session_data->supplier_id;
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();

            $temp_arr[] = $aRow[$this->session_data->language . '_name'];

            $temp_arr[] = '<a href="' . USER_URL . 'packet/manage/' . $aRow['product_id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('manage') .'"><i class="icon-edit"></i></a>';

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    public function getUsersJsonData() {
        $status = $this->input->get('status');
        $role_id = $this->input->get('role_id');

        $where = '';
        if($status == '0' || $status == '1'){
            $where .= ' AND users.status=' . $status; 
        }

        if(!empty($role_id) && $role_id > 1){
            $where .= ' AND users.role_id=' . $role_id; 
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('users.profile_pic', 'users.'.$this->session_data->language . '_fullname AS name', 'username', 'roles.name AS role', 'mobile', 'status');
        $this->datatable->eColumns = array('users.id');
        $this->datatable->sIndexColumn = "users.id";
        $this->datatable->sTable = " users, roles";
        $this->datatable->myWhere = ' WHERE role_id > 1 AND users.role_id=roles.id ' . $where; 
        $this->datatable->datatable_process();

        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();

            $temp_arr[] = '<img src="'. ASSETS_URL .'uploads/user_images/' . $aRow['profile_pic'] .'" alt="" class="col-xs-12 col-sm-6 col-md-12 col-lg-12">';

            $temp_arr[] = $aRow['name'];
            $temp_arr[] = $aRow['username'];
            $temp_arr[] = $aRow['role'];
            $temp_arr[] = $aRow['mobile'];

            if($aRow['status'] == 0){
                $temp_arr[] = '<span class="label label-danger" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('user_status_inactive') .'">'. $this->lang->line('user_status_inactive') .'</span>';
            } else if($aRow['status'] == 1){
                $temp_arr[] = '<span class="label label-success" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('user_status_active') .'">'. $this->lang->line('user_status_active') .'</span>';
            } else if($aRow['status'] == 2){
                $temp_arr[] = '<span class="label label-info" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('user_status_banned') .'">'. $this->lang->line('user_status_banned') .'</span>';
            } else {
                $temp_arr[] = '&nbsp;';
            }

            $str = '';
            if (hasPermission('bods', 'editBod')) {
                $str .= '<a href="' . USER_URL . 'user/edit/' . $aRow['id'] . '" class="btn btn-primary" data-toggle="tooltip" title="" data-original-title="'. $this->lang->line('edit') .'"><i class="icon-edit"></i></a>';
            }

            $temp_arr[] = $str;

            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
    
}