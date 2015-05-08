<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class products extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('product'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewProduct() {
        $obj_market = new Market();
        $data['markets'] = $obj_market->where('status',1)->get();

        $obj_product = new Product();
        $data['count'] = $obj_product->count();

        foreach ($obj_market as $market) {
            $temp = array();
            $temp['name'] = $market->{$this->session_data->language.'_name'};
            $temp['count'] = $market->Product->count();
            $data['counts'][] = $temp;
        }

        $this->layout->view('user/products/view', $data);
    }

    function addProduct() {
        if ($this->input->post() !== false) {
            $product = new Product();

            $product->market_id = $this->input->post('market_id');
            $product->productcategory_id = $this->input->post('productcategory_id');
            $product->rate = $this->input->post('rate');
            
            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $product->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $product->{$key . '_name'} = $this->input->post('en_name');
                }

                if ($this->input->post($key . '_description') != '') {
                    $product->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $product->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            $images = array();
            if (!empty($_FILES['product_image'])) {
                $image = $this->uploadImage('product_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'product/add', 'refresh');
                } else if (isset($image)) {
                    
                    foreach ($image as $key => $value) {
                        $images[] = $value['file_name'];
                    }
                }
            }
            
            if(!empty($images)){
                $product->images = serialize($images);
            }

            $product->created_id = $this->session_data->id;
            $product->created_datetime = get_current_date_time()->get_date_time_for_db();
            $product->updated_id = $this->session_data->id;
            $product->update_datetime = get_current_date_time()->get_date_time_for_db();

            $product->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'product', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('product'));

            $obj_markert = new Market();
            $data['markets'] = $obj_markert->where('status',1)->get();

            $this->layout->view('user/products/add', $data);
        }
    }
    
    function editProduct($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $product = new Product();
                $product->where('id', $id)->get();
                $product->market_id = $this->input->post('market_id');
                $product->rate = $this->input->post('rate');
                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $product->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $product->{$key . '_name'} = $this->input->post('en_name');
                    }

                    if ($this->input->post($key . '_description') != '') {
                        $product->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $product->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                $images = array();
                if (!empty($_FILES['product_image'])) {
                    $image = $this->uploadImage('product_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'product/add', 'refresh');
                    } else if (isset($image)) {
                        $tmp_images = unserialize($product->images);
                        foreach ($tmp_images as $tmp_image) {
                            if (file_exists('assets/uploads/product_images/' . $tmp_image)) {
                                unlink('assets/uploads/product_images/' . $tmp_image);
                            }

                            if (file_exists('assets/uploads/product_images/thumb/' . $tmp_image)) {
                                unlink('assets/uploads/product_images/thumb/' . $tmp_image);
                            }
                        }

                        foreach ($image as $key => $value) {
                            $images[] = $value['file_name'];
                        }
                    }
                }
                
                if(!empty($images)){
                    $product->images = serialize($images);
                }

                $product->updated_id = $this->session_data->id;
                $product->update_datetime = get_current_date_time()->get_date_time_for_db();

                $product->save();
                $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
                redirect(USER_URL . 'product', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('product'));

                $product = new Product();
                $data['product'] = $product->where('id', $id)->get();

                $obj_markert = new Market();
                $data['markets'] = $obj_markert->where('status',1)->get();

                $this->layout->view('user/products/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'product', 'refresh');
        }
    }

    function deleteProduct($id) {
        if (!empty($id)) {
            $obj_product = new Product();
            $obj_product->where('id', $id)->get();
            if ($obj_product->result_count() == 1) {
                $images = unserialize($obj_product->images);
                foreach ($images as $image) {
                    if (file_exists('assets/uploads/product_images/' . $image)) {
                        unlink('assets/uploads/product_images/' . $image);
                    }

                    if (file_exists('assets/uploads/product_images/thumb/' . $image)) {
                        unlink('assets/uploads/product_images/thumb/' . $image);
                    }
                }

                $obj_product->delete();
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
        if ($field == 'product_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/product_images",
                    'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                    'overwrite' => FALSE,
                    'remove_spaces' => TRUE,
                    'encrypt_name' => TRUE
                )
            );
        }
        
        if ($this->upload->do_multi_upload($field)) {
            $return = $this->upload->get_multi_upload_data();
            foreach ($return as $key => $value) {
                $image = str_replace(' ', '_', $value['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/product_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'auto');
                $magicianObj->saveImage('./assets/uploads/product_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/product_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'auto');
                $magicianObj->saveImage('./assets/uploads/product_images/' . $image, 100);
            }
        } else {
            $return = array('error' => $this->upload->display_errors());
        }
        
        return $return;
    }
}