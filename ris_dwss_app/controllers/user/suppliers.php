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
        $this->layout->view('user/suppliers/view');
    }

    function addSupplier() {
        if ($this->input->post() !== false) {
            $supplier = new Supplier();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_suppplier_name') != '') {
                    $supplier->{$key . '_suppplier_name'} = $this->input->post($key . '_suppplier_name');
                } else {
                    $supplier->{$key . '_suppplier_name'} = $this->input->post('en_suppplier_name');
                }
            }

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_shop_name') != '') {
                    $supplier->{$key . '_shop_name'} = $this->input->post($key . '_shop_name');
                } else {
                    $supplier->{$key . '_shop_name'} = $this->input->post('en_shop_name');
                }
            }

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


            $this->layout->view('user/suppliers/add', $data);
        }
    }
    
    function editSupplier($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $supplier = new Supplier();
                $supplier->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $supplier->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $supplier->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                if ($_FILES['supplier_image']['name'] != '') {
                    $image = $this->uploadImage('supplier_image');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'supplier/edit/'. $id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        if ($supplier->image != 'no-avtar.png' && file_exists('assets/uploads/supplier_images/' . $supplier->image)) {
                            unlink('assets/uploads/supplier_images/' . $supplier->image);
                        }

                        if ($supplier->image != 'no-avtar.png' && file_exists('assets/uploads/supplier_images/thumb/' . $supplier->image)) {
                            unlink('assets/uploads/supplier_images/thumb/' . $supplier->image);
                        }
                        $supplier->image = $image['upload_data']['file_name'];
                    }
                }

                $supplier->status = $this->input->post('status');
                $supplier->updated_id = $this->session_data->id;
                $supplier->update_datetime = get_current_date_time()->get_date_time_for_db();

                $supplier->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'supplier', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('supplier'));

                $supplier = new Supplier();
                $data['supplier'] = $supplier->where('id', $id)->get();

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
        if ($field == 'supplier_image') {
            $this->upload->initialize(
                array(
                    'upload_path' => "./assets/uploads/supplier_images",
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

            if ($field == 'supplier_image' && $data['upload_data']['file_name'] != '') {
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                $this->load->helper('image_manipulation/image_manipulation');
                include_lib_image_manipulation();
                $magicianObj = new imageLib('./assets/uploads/supplier_images/' . $image);
                $magicianObj->resizeImage(150, 150, 'exact');
                $magicianObj->saveImage('./assets/uploads/supplier_images/thumb/' . $image, 100);

                $magicianObj = new imageLib('./assets/uploads/supplier_images/' . $image);
                $magicianObj->resizeImage(400, 400, 'exact');
                $magicianObj->saveImage('./assets/uploads/supplier_images/' . $image, 100);
            }
        }
        
        return $data;
    }
}
