<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class productcategories extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('product_category'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewProductcategory() {
        $this->layout->view('user/productcategories/view');
    }

    function addProductcategory() {
        if ($this->input->post() !== false) {
            $product_category = new Productcategory();
            $product_category->market_id = $this->input->post('market_id');
            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $product_category->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $product_category->{$key . '_name'} = $this->input->post('en_name');
                }

                if ($this->input->post($key . '_description') != '') {
                    $product_category->{$key . '_description'} = $this->input->post($key . '_description');
                } else {
                    $product_category->{$key . '_description'} = $this->input->post('en_description');
                }
            }

            if ($_FILES['product_category_image']['name'] != '') {
                $image = $this->uploadImage('product_category_image');
                if (isset($image['error'])) {
                    $this->session->set_flashdata('file_errors', $image['error']);
                    redirect(USER_URL . 'productcategory/add', 'refresh');
                } else if (isset($image['upload_data'])) {
                    $product_category->image = $image['upload_data']['file_name'];
                }
            }

            $product_category->created_id = $this->session_data->id;
            $product_category->created_datetime = get_current_date_time()->get_date_time_for_db();
            $product_category->updated_id = $this->session_data->id;
            $product_category->update_datetime = get_current_date_time()->get_date_time_for_db();

            $product_category->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'productcategory', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('product_category'));

            $obj_markert = new Market();
            $data['markets'] = $obj_markert->where('status',1)->get();

            $this->layout->view('user/productcategories/add', $data);
        }
    }
    
    function editProductcategory($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $product_category = new Productcategory();
                $product_category->where('id', $id)->get();
                $product_category->market_id = $this->input->post('market_id');
                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $product_category->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $product_category->{$key . '_name'} = $this->input->post('en_name');
                    }

                    if ($this->input->post($key . '_description') != '') {
                        $product_category->{$key . '_description'} = $this->input->post($key . '_description');
                    } else {
                        $product_category->{$key . '_description'} = $this->input->post('en_description');
                    }
                }

                if ($_FILES['product_category_image']['name'] != '') {
                    $image = $this->uploadImage('product_category_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'productcategory/add', 'refresh');
                    } else if (isset($image['upload_data'])) {
                        
                        if ($product_category->image != 'no-category.png' && file_exists('assets/uploads/productcategory_images/' . $product_category->image)) {
                            unlink('assets/uploads/productcategory_images/' . $product_category->image);
                        }

                        if ($product_category->image != 'no-category.png' && file_exists('assets/uploads/productcategory_images/thumb/' . $product_category->image)) {
                            unlink('assets/uploads/productcategory_images/thumb/' . $product_category->image);
                        }

                        $product_category->image = $image['upload_data']['file_name'];
                    }
                }

                $product_category->updated_id = $this->session_data->id;
                $product_category->update_datetime = get_current_date_time()->get_date_time_for_db();

                $product_category->save();
                $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
                redirect(USER_URL . 'productcategory', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('product_category'));

                $product_category = new Productcategory();
                $data['product_category'] = $product_category->where('id', $id)->get();

                $obj_markert = new Market();
                $data['markets'] = $obj_markert->where('status',1)->get();

                $this->layout->view('user/productcategories/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'productcategory', 'refresh');
        }
    }

    function deleteProductcategory($id) {
        if (!empty($id)) {
            $obj_product_category = new Productcategory();
            $obj_product_category->where('id', $id)->get();
            if ($obj_product_category->result_count() == 1) {
                if ($obj_product_category->image != 'no-category.png' && file_exists('assets/uploads/productcategory_images/' . $obj_product_category->image)) {
                    unlink('assets/uploads/productcategory_images/' . $obj_product_category->image);
                }

                if ($obj_product_category->image != 'no-category.png' && file_exists('assets/uploads/productcategory_images/thumb/' . $obj_product_category->image)) {
                    unlink('assets/uploads/productcategory_images/thumb/' . $obj_product_category->image);
                }
                $obj_product_category->delete();
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
        if ($field == 'product_category_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/productcategory_images",
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

            if ($field == 'product_category_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/productcategory_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'auto');
                $magicianObj->saveImage('./assets/uploads/productcategory_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/productcategory_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'auto');
                $magicianObj->saveImage('./assets/uploads/productcategory_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}