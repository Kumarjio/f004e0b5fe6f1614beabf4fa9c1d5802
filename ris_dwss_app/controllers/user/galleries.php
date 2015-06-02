<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class galleries extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', $this->lang->line('gallery'));
        $this->session_data = $this->session->userdata('user_session');
    }
    
    function viewGallery() {
        $obj_gallery = new Gallery();
        $data['count'] = $obj_gallery->count();
        $this->layout->view('user/galleries/view', $data);
    }

    function addGallery() {
        if ($this->input->post() !== false) {
            $gallery = new Gallery();

            foreach ($this->config->item('custom_languages') as $key => $value) {
                if ($this->input->post($key . '_name') != '') {
                    $gallery->{$key . '_name'} = $this->input->post($key . '_name');
                } else {
                    $gallery->{$key . '_name'} = $this->input->post('en_name');
                }
            }

            $gallery->created_id = $this->session_data->id;
            $gallery->created_datetime = get_current_date_time()->get_date_time_for_db();
            $gallery->updated_id = $this->session_data->id;
            $gallery->update_datetime = get_current_date_time()->get_date_time_for_db();

            $gallery->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(USER_URL . 'gallery', 'refresh');
        } else {
            $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('gallery'));
            $this->layout->view('user/galleries/add');
        }
    }
    
    function editGallery($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $gallery = new Gallery();
                $gallery->where('id', $id)->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($this->input->post($key . '_name') != '') {
                        $gallery->{$key . '_name'} = $this->input->post($key . '_name');
                    } else {
                        $gallery->{$key . '_name'} = $this->input->post('en_name');
                    }
                }

                $gallery->updated_id = $this->session_data->id;
                $gallery->update_datetime = get_current_date_time()->get_date_time_for_db();

                $gallery->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(USER_URL . 'gallery', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('gallery'));

                $gallery = new Gallery();
                $data['gallery'] = $gallery->where('id', $id)->get();

                $this->layout->view('user/galleries/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(USER_URL . 'gallery', 'refresh');
        }
    }

    function deleteGallery($id) {
        if (!empty($id)) {
            $obj_gallery = new Gallery();
            $obj_gallery->where('id', $id)->get();
            if ($obj_gallery->result_count() == 1) {
                    $obj_gallery_image = new Galleryimage();
                    $obj_gallery_image->where('gallery_id', $id)->get();

                    foreach ($obj_gallery_image as $gallery_image) {
                        if (file_exists('assets/uploads/gallery_images/' . $gallery_image->image)) {
                            unlink('assets/uploads/gallery_images/' . $gallery_image->image);
                        }

                        $gallery_image->delete();
                    }

                $obj_gallery->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }

    function viewGalleryImages($id){
        $gallery = new Gallery();
        $gallery->where('id', $id)->get();

        if($gallery->result_count() == 1){
            $obj_gallery_image = new Galleryimage();
            $obj_gallery_image->where('gallery_id', $id)->get();            
            $data['count'] = $obj_gallery_image->result_count();
            $data['gallery_details'] = $gallery->stored;
            $this->layout->view('user/galleries/view_gallery_images', $data);
        } else {
            redirect(USER_URL . 'gallery', 'refresh');
        }
    }

    function addGalleryImages($id){
        $gallery = new Gallery();
        $gallery->where('id', $id)->get();

        if($gallery->result_count() == 1){
            if ($this->input->post() !== false) {
                foreach ($this->config->item('custom_languages') as $key => $value) {
                    ${$key.'_image_title'} = $this->input->post($key . '_image_title');
                }

                for ($i=0; $i < count($en_image_title); $i++) {
                    
                    if(empty($en_image_title[$i])){
                        continue;
                    }

                    $obj_gallery_image = new Galleryimage();
                    $obj_gallery_image->gallery_id = $id;

                    foreach ($this->config->item('custom_languages') as $key => $value) {
                        if (${$key.'_image_title'}[$i] != '') {
                            $obj_gallery_image->{$key . '_name'} = ${$key.'_image_title'}[$i];
                        } else {
                            $obj_gallery_image->{$key . '_name'} = $en_image_title[$i];
                        }
                    }

                    if ($_FILES['image_file']['name'][$i] != '') {
                        $_FILES['temp_image_file']['name']= $_FILES['image_file']['name'][$i];
                        $_FILES['temp_image_file']['type']= $_FILES['image_file']['type'][$i];
                        $_FILES['temp_image_file']['tmp_name']= $_FILES['image_file']['tmp_name'][$i];
                        $_FILES['temp_image_file']['error']= $_FILES['image_file']['error'][$i];
                        $_FILES['temp_image_file']['size']= $_FILES['image_file']['size'][$i];
                        $image = $this->uploadImage('temp_image_file');
                        if (isset($image['upload_data'])) {
                            $obj_gallery_image->image = $image['upload_data']['file_name'];
                        }
                    }

                    $obj_gallery_image->created_id = $this->session_data->id;
                    $obj_gallery_image->created_datetime = get_current_date_time()->get_date_time_for_db();
                    $obj_gallery_image->updated_id = $this->session_data->id;
                    $obj_gallery_image->update_datetime = get_current_date_time()->get_date_time_for_db();
                    $obj_gallery_image->save();
                }
                redirect(USER_URL . 'gallery/view/' . $id, 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('gallery_image'));
                $data['gallery_details'] = $gallery->stored;
                $this->layout->view('user/galleries/add_gallery_images', $data);
            }
        } else {
            redirect(USER_URL . 'gallery', 'refresh');
        }
    }

    function editGalleryImages($gallery_id, $image_id){
        $gallery = new Gallery();
        $gallery->where('id', $gallery_id)->get();

        $obj_gallery_image = new Galleryimage();
        $obj_gallery_image->where(array('id' => $image_id, 'gallery_id' => $gallery_id))->get();

        if($gallery->result_count() == 1 && $obj_gallery_image->result_count() == 1){
            if ($this->input->post() !== false) {    
                $obj_gallery_image = new Galleryimage();
                $obj_gallery_image->where(array('id' => $image_id, 'gallery_id' => $gallery_id))->get();

                foreach ($this->config->item('custom_languages') as $key => $value) {
                    if ($key.'_image_title' != '') {
                        $obj_gallery_image->{$key . '_name'} = $this->input->post($key.'_image_title');
                    } else {
                        $obj_gallery_image->{$key . '_name'} = $this->input->post('en_image_title');
                    }
                }

                if ($_FILES['image_file']['name'] != '') {
                    $image = $this->uploadImage('image_file');
                    if (isset($image['error'])) {
                        $this->session->set_flashdata('file_errors', $image['error']);
                        redirect(USER_URL . 'gallery/edit/image/'. $gallery_id .'/'. $image_id, 'refresh');
                    } else if (isset($image['upload_data'])) {
                        if (!is_null($obj_gallery_image->image) && file_exists('assets/uploads/gallery_images/' . $obj_gallery_image->image)) {
                            unlink('assets/uploads/gallery_images/' . $obj_gallery_image->image);
                        }
                        $obj_gallery_image->image = $image['upload_data']['file_name'];
                    }
                }

                $obj_gallery_image->updated_id = $this->session_data->id;
                $obj_gallery_image->update_datetime = get_current_date_time()->get_date_time_for_db();
                $obj_gallery_image->save();
                redirect(USER_URL . 'gallery/view/' . $gallery_id, 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('add') . ' ' . $this->lang->line('gallery_image'));
                
                $data['gallery_details'] = $gallery->stored;
                $data['gallery_image_details'] = $obj_gallery_image->stored;
                $this->layout->view('user/galleries/edit_gallery_images', $data);
            }
        } else {
            redirect(USER_URL . 'gallery', 'refresh');
        }
    }

    function uploadImage($field) {
        $this->upload->initialize(
            array(
                'upload_path' => "./assets/uploads/gallery_images",
                'allowed_types' => 'jpg|jpeg|gif|png|bmp',
                'overwrite' => FALSE,
                'remove_spaces' => TRUE,
                'encrypt_name' => TRUE
            )
        );
        
        if (!$this->upload->do_upload($field)) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data($field));
        }
        
        return $data;
    }

    function delteGalleryImages($gallery_id, $image_id) {
        if (!empty($gallery_id) && !empty($image_id)) {
            $obj_gallery_image = new Galleryimage();
            $obj_gallery_image->where(array('id' => $image_id, 'gallery_id' => $gallery_id))->get();
            if ($obj_gallery_image->result_count() == 1) {
                
                if (file_exists('assets/uploads/gallery_images/' . $obj_gallery_image->image)) {
                    unlink('assets/uploads/gallery_images/' . $obj_gallery_image->image);
                }

                $obj_gallery_image->delete();
                $data = array('status' => 'success', 'msg' => $this->lang->line('delete_data_success'));
            } else {
                $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
            }
        } else {
            $data = array('status' => 'error', 'msg' => $this->lang->line('delete_data_error'));
        }
        echo json_encode($data);
    }
}
