<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('dashboard'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    public function index() {
        if (empty($this->session_data)) {
            redirect(USER_URL . 'login', 'refresh');
        } else {
            switch ($this->session_data->role) {
                case 1:
                    $this->dashboardSuperAdmin();
                    break;

                case 2:
                    $this->dashboardAdmin();
                    break;

                case 3:
                    $this->dashboardSupplier();
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

    private function _getTotalCounts(){
        $obj_market = new Market();
        $data['total_markets'] = $obj_market->get()->result_count();

        $obj_productcategory = new Productcategory();
        $data['total_product_categories'] = $obj_productcategory->get()->result_count();

        $obj_product = new Product();
        $data['total_products'] = $obj_product->get()->result_count();

        $obj_supplier = new Supplier();
        $data['total_suppliers'] = $obj_supplier->get()->result_count();

        $obj_news = new News();
        $data['total_news'] = $obj_news->get()->result_count();

        $obj_tender = new Tender();
        $data['total_tenders'] = $obj_tender->get()->result_count();

        $obj_bod = new Bod();
        $data['total_bods'] = $obj_bod->get()->result_count();

        $obj_saff = new Staff();
        $data['total_stafves'] = $obj_saff->get()->result_count();

        return $data;
    }

    function dashboardSuperAdmin(){
        $data = $this->_getTotalCounts();
        $this->layout->view('user/dashboard/super_admin', $data);
    }

    function dashboardAdmin(){
        $data = $this->_getTotalCounts();
        $this->layout->view('user/dashboard/admin', $data);
    }

    function dashboardSupplier(){
        $supplier_id = $this->session_data->supplier_id;

        $obj_supplier_product = new Supplierproduct();
        $data['total_supplier_product'] = $obj_supplier_product->where('supplier_id', $supplier_id)->get()->result_count();

        $obj_selloffer = new Selloffer();
        $obj_selloffer->where('supplier_id', $supplier_id)->get();
        $data['total_selloffer'] = $obj_selloffer->result_count();

        $obj_supplierrequriment = new Supplierrequriment();
        $obj_supplierrequriment->where('supplier_id', $this->session_data->supplier_id)->get();
        $data['total_supplierrequriment'] = $obj_supplierrequriment->result_count();

        $advertisement = new Advertisement();
        $advertisement->where('supplier_id', $supplier_id)->get();
        $data['total_advertisement'] = $advertisement->result_count();

        $this->layout->view('user/dashboard/supplier', $data);
    }

    public function updateProfile(){
        if($this->input->post() !== false) {
            $user = new User();
            $user->where('id', $this->session_data->id)->get();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_fullname') != '') {
                    $user->{$key . '_fullname'} = $this->input->post($key . '_fullname');
                } else {
                    $user->{$key . '_fullname'} = $this->input->post('en_fullname');
                }
            }

            $user->username = $this->input->post('username');
            $user->email = $this->input->post('email');
            $user->mobile = $this->input->post('mobile');

            if ($_FILES['user_image']['name'] != '') {
                $image = $this->uploadImage('user_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'profile', 'refresh');
                } else if (isset($image['upload_data'])) {
                    if (!empty($user->profile_pic) && $user->profile_pic != 'no-avtar.png' && file_exists('assets/uploads/user_images/' . $user->profile_pic)) {
                        unlink('assets/uploads/user_images/' . $user->profile_pic);
                    }
                    $user->profile_pic = $image['upload_data']['file_name'];
                }
            }

            $user->updated_id = $this->session_data->id;
            $user->update_datetime = get_current_date_time()->get_date_time_for_db();

            $user->save();

            $user = new User();
            $user->where('id', $this->session_data->id)->get();
            $user = $user->stored;
            $user->role = $user->role_id;
            unset($user->role_id);
            $user->language = $this->config->item('default_language');
            $newdata = array('user_session' => $user);
            $this->session->set_userdata($newdata);

            $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
            redirect(USER_URL . 'profile', 'refresh');
        } else {
            $this->layout->view('user/dashboard/user_profile');
        }
    }

    public function updatePassword(){
        if($this->input->post() !== false) {
            $user = new User();
            $user->where('id', $this->session_data->id)->get();

            if(md5($this->input->post('old_password')) == $user->password){
                if(md5($this->input->post('new_password')) == md5($this->input->post('cnew_password'))){
                    $user->password = md5($this->input->post('new_password'));
                    $user->updated_id = $this->session_data->id;
                    $user->update_datetime = get_current_date_time()->get_date_time_for_db();
                    $user->save();
                    $this->session->set_flashdata('success', $this->lang->line('password_reset_success'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('both_pwd_not_match'));
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('old_pwd_not_match'));
            }

            redirect(USER_URL . 'password', 'refresh');
        } else {
            $this->layout->view('user/dashboard/user_password');
        }
    }

    function uploadImage($field) {
        if ($field == 'user_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/user_images",
                    'allowed_types' => 'jpg|jpeg|gif|png',
                    'overwrite' => FALSE,
                    'remove_spaces' => TRUE,
                    'encrypt_name' => TRUE
                )
            );
        }
        
        if (!$this->upload->do_upload($field)) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data($field));

            if ($field == 'user_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/user_images/' . $image);
                $magicianObj->resizeImage(200, 200, 'auto');
                $magicianObj->saveImage('./assets/uploads/user_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}
