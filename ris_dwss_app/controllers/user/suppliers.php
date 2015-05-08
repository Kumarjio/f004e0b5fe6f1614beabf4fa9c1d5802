<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class suppliers extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('supplier'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewSupplier() {
        $obj_market = new Market();
        $data['markets'] = $obj_market->where('status',1)->get();

        $obj_suppliertype = new Suppliertype();
        $data['suppliertypes'] = $obj_suppliertype->get();

        $obj_supplierbusinesstype = new Supplierbusinesstype();
        $data['supplierbusinesstypes'] = $obj_supplierbusinesstype->get();

        $obj_supplieramenitie = new Supplieramenitie();
        $data['supplieramenities'] = $obj_supplieramenitie->get();

        $obj_supplier = new Supplier();
        $data['count'] = $obj_supplier->count();

        foreach ($obj_market as $market) {
            $temp = array();
            $temp['name'] = $market->{$this->session_data->language.'_name'};
            $temp['count'] = $market->Supplier->count();
            $data['counts'][] = $temp;
        }

        $this->layout->view('user/suppliers/view', $data);
    }

    function addSupplier() {
        if ($this->input->post() !== false) {
            $user = new User();
            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_fullname') != '') {
                    $user->{$key . '_fullname'} = $this->input->post($key . '_fullname');
                } else {
                    $user->{$key . '_fullname'} = $this->input->post('en_fullname');
                }
            }

            $user->role_id = 3;
            $user->username = $this->input->post('username');
            $user->password = md5($this->input->post('password'));
            $user->mobile = $this->input->post('mobile');
            $user->email = $this->input->post('email');
            $user->status = $this->input->post('status');
            $user->save();

            $supplier = new Supplier();
            $supplier->market_id = $this->input->post('market_id');
            $supplier->user_id = $user->id;
            $supplier->form_no = $this->input->post('form_no');
            $supplier->form_date = date('Y-m-d', strtotime($this->input->post('form_date')));
            $supplier->shop_no = $this->input->post('shop_no'); 
            $supplier->suppliertype_id = implode(',', $this->input->post('suppliertype_id'));

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_shop_name') != '') {
                    $supplier->{$key . '_shop_name'} = $this->input->post($key . '_shop_name');
                } else {
                    $supplier->{$key . '_shop_name'} = $this->input->post('en_shop_name');
                }
            }

            if ($_FILES['supplier_shop_image']['name'] != '') {
                $image = $this->uploadImage('supplier_shop_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'supplier/add', 'refresh');
                } else if (isset($image['upload_data'])) {
                    $supplier->image = $image['upload_data']['file_name'];
                }
            }

            $supplier->owner = $this->input->post('owner');
            $supplier->working_days = implode(',', $this->input->post('working_days'));
            $supplier->working_time = $this->input->post('working_time');
            $supplier->estd_year = $this->input->post('estd_year');
            $supplier->payment = implode(',', $this->input->post('payment'));
            $supplier->website = $this->input->post('website');
            $supplier->supplierbusinesstype_id = implode(',', $this->input->post('supplierbusinesstype_id'));
            $supplier->no_employees = $this->input->post('no_employees');
            $supplier->sms_requriment = $this->input->post('sms_requriment');
            $supplier->supplieramenity_id = implode(',', $this->input->post('supplieramenity_id'));

            $supplier->created_id = $this->session_data->id;
            $supplier->created_datetime = get_current_date_time()->get_date_time_for_db();
            $supplier->updated_id = $this->session_data->id;
            $supplier->update_datetime = get_current_date_time()->get_date_time_for_db();

            $supplier->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'supplier', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('supplier'));
            
            $obj_markert = new Market();
            $data['markets'] = $obj_markert->where('status',1)->get();

            $obj_suppliertype = new Suppliertype();
            $data['suppliertypes'] = $obj_suppliertype->get();

            $obj_supplierbusinesstype = new Supplierbusinesstype();
            $data['supplierbusinesstypes'] = $obj_supplierbusinesstype->get();

            $obj_supplieramenitie = new Supplieramenitie();
            $data['supplieramenities'] = $obj_supplieramenitie->get();

            $obj_supplier = new Supplier();
            $data['form_no'] = $obj_supplier->autoIncerementNumber();

            $this->layout->view('user/suppliers/add', $data);
        }
    }
    
    function editSupplier($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $supplier = new Supplier();
                $supplier->where('id', $id)->get();
                $supplier->market_id = $this->input->post('market_id');
                $supplier->form_date = date('Y-m-d', strtotime($this->input->post('form_date')));
                $supplier->shop_no = $this->input->post('shop_no'); 
                $supplier->suppliertype_id = implode(',', $this->input->post('suppliertype_id'));

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_shop_name') != '') {
                        $supplier->{$key . '_shop_name'} = $this->input->post($key . '_shop_name');
                    } else {
                        $supplier->{$key . '_shop_name'} = $this->input->post('en_shop_name');
                    }
                }

                if ($_FILES['supplier_shop_image']['name'] != '') {
                    $image = $this->uploadImage('supplier_shop_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'supplier/edit/' . $id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        
                        if ($supplier->image != 'no-image.png' && file_exists('assets/uploads/supplier_shop_image/' . $supplier->image)) {
                            unlink('assets/uploads/supplier_shop_image/' . $supplier->image);
                        }

                        if ($supplier->image != 'no-image.png' && file_exists('assets/uploads/supplier_shop_image/thumb/' . $supplier->image)) {
                            unlink('assets/uploads/supplier_shop_image/thumb/' . $supplier->image);
                        }

                        $supplier->image = $image['upload_data']['file_name'];
                    }
                }

                $supplier->owner = $this->input->post('owner');
                $supplier->working_days = implode(',', $this->input->post('working_days'));
                $supplier->working_time = $this->input->post('working_time');
                $supplier->estd_year = $this->input->post('estd_year');
                $supplier->payment = implode(',', $this->input->post('payment'));
                $supplier->website = $this->input->post('website');
                $supplier->supplierbusinesstype_id = implode(',', $this->input->post('supplierbusinesstype_id'));
                $supplier->no_employees = $this->input->post('no_employees');
                $supplier->sms_requriment = $this->input->post('sms_requriment');
                $supplier->supplieramenity_id = implode(',', $this->input->post('supplieramenity_id'));

                $supplier->updated_id = $this->session_data->id;
                $supplier->update_datetime = get_current_date_time()->get_date_time_for_db();

                $supplier->save();

                $user = new User();
                $user->where('id', $supplier->user_id)->get();
                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_fullname') != '') {
                        $user->{$key . '_fullname'} = $this->input->post($key . '_fullname');
                    } else {
                        $user->{$key . '_fullname'} = $this->input->post('en_fullname');
                    }
                }

                $user->username = $this->input->post('username');

                if($this->input->post('password') != ''){    
                    $user->password = md5($this->input->post('password'));
                }

                $user->mobile = $this->input->post('mobile');
                $user->email = $this->input->post('email');
                $user->status = $this->input->post('status');
                $user->save();

                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'supplier', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('supplier'));


                $obj_markert = new Market();
                $data['markets'] = $obj_markert->where('status',1)->get();

                $obj_suppliertype = new Suppliertype();
                $data['suppliertypes'] = $obj_suppliertype->get();

                $obj_supplierbusinesstype = new Supplierbusinesstype();
                $data['supplierbusinesstypes'] = $obj_supplierbusinesstype->get();

                $obj_supplieramenitie = new Supplieramenitie();
                $data['supplieramenities'] = $obj_supplieramenitie->get();

                $supplier = new Supplier();
                $data['supplier'] = $supplier->where('id', $id)->get();

                $obj_markert = new Market();
                $data['markets'] = $obj_markert->where('status',1)->get();

                $user = new User();
                $data['user_details'] = $user->where('id', $supplier->user_id)->get();

                $this->layout->view('user/suppliers/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'supplier', 'refresh');
        }
    }

    function deleteSupplier($id) {
        if (!empty($id)) {
            $obj_supplier = new Supplier();
            $obj_supplier->where('id', $id)->get();
            if ($obj_supplier->result_count() == 1) {
                if ($obj_supplier->image != 'no-avtar.png' && file_exists('assets/uploads/supplier_images/' . $obj_supplier->image)) {
                    unlink('assets/uploads/supplier_images/' . $obj_supplier->image);
                }

                if ($obj_supplier->image != 'no-avtar.png' && file_exists('assets/uploads/supplier_images/thumb/' . $obj_supplier->image)) {
                    unlink('assets/uploads/supplier_images/thumb/' . $obj_supplier->image);
                }
                $obj_supplier->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }

    function uploadImage($field) {
        if ($field == 'supplier_shop_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/supplier_shop_image",
                    'allowed_types' => 'jpg|jpeg|gif|png|bmp',
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

            if ($field == 'supplier_shop_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/supplier_shop_image/' . $image);
                $magicianObj->resizeImage(150, 150, 'exact');
                $magicianObj->saveImage('./assets/uploads/supplier_shop_image/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/supplier_shop_image/' . $image);
                $magicianObj->resizeImage(400, 400, 'landscape');
                $magicianObj->saveImage('./assets/uploads/supplier_shop_image/' . $image, 100);
            }
        }
        
        return $data;
    }

    function manageProductSupplier($supplier_id = null){
        if ($this->input->post() !== false) {
            if($this->session_data->role == 3) {
                $supplier_id = $this->session_data->id;
                $valid = true;
            } else if($this->session_data->role == 1 || $this->session_data->role == 2) {
                if(empty($supplier_id)){
                    $valid = false;
                } else {
                    $valid = true;
                }
            } else {
                $valid = false;
            }

            if($valid){
                $obj_supplier_product = new Supplierproduct();
                $obj_supplier_product->where('supplier_id', $supplier_id)->get();
                $product_ids = $this->input->post('product_ids');

                if($obj_supplier_product->result_count() > 0){
                    $product_already = array();
                    $product_remove = array();
                    $product_add = array();

                    foreach ($obj_supplier_product as $product) {
                        $product_already[] = $product->product_id;
                        if(!in_array($product->product_id, $product_ids)){
                            $product_remove[] = $product->product_id;
                        }
                    }

                    foreach ($product_ids as $product) {
                        if(!in_array($product, $product_already)){
                            $product_add[] = $product;
                        }
                    }



                    foreach ($product_remove as $remove_product) {
                        $obj_supplier_product_remove = new Supplierproduct();
                        $obj_supplier_product_remove->where(array('supplier_id' => $supplier_id, 'product_id' => $remove_product));
                        $obj_supplier_product_remove->get();
                        $obj_supplier_product_remove->delete();
                    }
                    
                    foreach ($product_add as $add_product) {
                        $obj_supplier_product_add = new Supplierproduct();
                        $obj_supplier_product_add->supplier_id = $supplier_id;
                        $obj_supplier_product_add->product_id  = $add_product;
                        $obj_supplier_product_add->created_id = $this->session_data->id;
                        $obj_supplier_product_add->created_datetime = get_current_date_time()->get_date_time_for_db();
                        $obj_supplier_product_add->updated_id = $this->session_data->id;
                        $obj_supplier_product_add->update_datetime = get_current_date_time()->get_date_time_for_db();
                        $obj_supplier_product_add->save();
                    }

                } else {
                    foreach ($product_ids as $product_id) {
                        $supplier_product = new Supplierproduct();

                        $supplier_product->supplier_id = $supplier_id;
                        $supplier_product->product_id  = $product_id;
                        $supplier_product->created_id = $this->session_data->id;
                        $supplier_product->created_datetime = get_current_date_time()->get_date_time_for_db();
                        $supplier_product->updated_id = $this->session_data->id;
                        $supplier_product->update_datetime = get_current_date_time()->get_date_time_for_db();
                        $supplier_product->save();
                    }
                }

                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'supplier', 'refresh');
            } else {
                $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
                redirect(USER_URL . 'supplier', 'refresh');
            }
        } else {
            $valid = false;
            if($this->session_data->role == 3) {
                $supplier_id = $this->session_data->id;
                $valid = true;
            } else if($this->session_data->role == 1 || $this->session_data->role == 2) {
                if(empty($supplier_id)){
                    $valid = false;
                } else {
                    $valid = true;
                }
            } else {
                $valid = false;
            }

            if($valid){
                $obj_supplier = new Supplier();
                $obj_supplier->where('id', $supplier_id)->get();

                if($obj_supplier->result_count() == 1){
                    $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('supplier'));

                    $data['supplier_details'] = $obj_supplier->stored;

                    $obj_product_catgory = new Productcategory();
                    $obj_product_catgory->where('market_id', $obj_supplier->stored->id);

                    $product_data =array();
                    foreach ($obj_product_catgory->get() as $product_category) {
                        $products = $product_category->product->get();
                        $product_data[$product_category->stored->id]['category_id'] = $product_category->stored->id;
                        $product_data[$product_category->stored->id]['category_name'] = $product_category->stored->{$this->session_data->language.'_name'};
                        foreach ($products as $product) {
                            $temp = array();
                            $temp['id'] = $product->stored->id;
                            $temp['name'] = $product->stored->{$this->session_data->language.'_name'};
                            $product_data[$product_category->stored->id]['products'][] = $temp;
                        }
                        
                    }

                    $data['products'] = $product_data;

                    $obj_supplier_product = new Supplierproduct();
                    $obj_supplier_product->where('supplier_id', $supplier_id)->get();
                    
                    $temp = array();
                    foreach ($obj_supplier_product as $supplier_product) {
                        $temp[] = $supplier_product->product_id;
                    }

                    $data['supplier_product'] = $temp;

                    $this->layout->view('user/suppliers/add_product', $data);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
                    redirect(USER_URL . 'supplier', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
                redirect(USER_URL . 'supplier', 'refresh');
            }
        }
    }

    function deleteProductSupplier($supplier_id, $product_id){

    }
}
