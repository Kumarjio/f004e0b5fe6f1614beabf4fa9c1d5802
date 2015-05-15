<?php

if (!function_exists('hasPermission')) {
    function hasPermission($controller, $method) {
        $data = get_instance()->session->userdata('user_session');
        if ($data->role == 1) {
            return TRUE;
        } else {
            $permissions= get_instance()->config->item('user_premission');

            if (is_array($permissions) && array_key_exists($controller, $permissions) && in_array($method, $permissions[$controller])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}

if(!function_exists('checkSuppliersupplierAmenities')){
    function checkSuppliersupplierAmenities($amenity_id, $suppplier_id){
        $obj_supplier = new Supplier();
        $obj_supplier->where('id', $suppplier_id)->get();

        if(in_array($amenity_id, explode(',', $obj_supplier->supplieramenity_id))){
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('printPermission')) {
    function printPermission($key, $array, $parent_key, $given_permission) {
        $str = '';
        $name = NULL;
        if (!is_null($parent_key)) {
            $name = 'name="perm[' . $parent_key . '][]"';
            if (is_array($given_permission) && array_key_exists($parent_key, $given_permission) && in_array($key, $given_permission[$parent_key])) {
                $str = ' checked="checked"';
            }
        } else {
            if (is_array($given_permission) && array_key_exists($key, $given_permission)) {
                $str = ' checked="checked"';
            }
        }


        foreach ($array as $k => $v) {
            if ($k != 'hasChild') {
                if (array_key_exists('type', $array)) {
                    $type = $array['type'];
                } else {
                    $type = 'checkbox';
                }



                if (array_key_exists('key', $array)) {
                    $name = 'name = "perm' . strip_quotes($array['key']) . '" ';

                    $v3 = 'given_permission' . $array['key'];
                    $check = eval('return isset($' . $v3 . ');');

                    if ($check) {
                        if ($type == 'checkbox') {
                            $str = ' checked="checked"';
                        } else {
                            if (eval('return $' . $v3 . ';') == $key) {
                                $str = ' checked="checked"';
                            }
                        }
                    }
                }

                if($type == 'checkbox'){
                    //$class = 'class="icheckbox_square-grey"';
                } else {
                    //$class = 'class="iradio_square-grey"';
                }


                return '<li><input type="' . $type . '" value="' . $key . '"' . $name . $str . @$class . '/><span>&nbsp;' . $v . '</span>';
            } else {
                break;
            }
        }
    }
}

if (!function_exists('loopPermissionArray')) {
    function loopPermissionArray($array, $given_permission = null, $parent_key = null) {
        foreach ($array as $key => $value) {
            if (isset($value['hasChild'])) {
                echo printPermission($key, $value, $parent_key, $given_permission), '<ul>';
                $key = array_key_exists('key', $value['hasChild']) ? $value['hasChild']['key'] : $key;
                loopPermissionArray($value['hasChild'], $given_permission, $key);
                echo '</ul>';
            } else {
                echo printPermission($key, $value, $parent_key, $given_permission);
            }
        }
    }
}

if (!function_exists('createPermissionArray')) {
    function createPermissionArray() {
        $CI =& get_instance();
        $permission = array(
            'roles' => array(
                'name' => 'Roles',
                'hasChild' => array(
                    'viewRole' => array('name' => 'List'),
                    'addRole' => array('name' => 'Add'),
                    'editRole' => array('name' => 'Edit/Update'),
                    'deleteRole' => array('name' => 'Delete'),
                )
            ),
            'markets' => array(
                'name' => 'Market',
                'hasChild' => array(
                    'viewMarket' => array('name' => 'List'),
                    'addMarket' => array('name' => 'Add'),
                    'editMarket' => array('name' => 'Edit/Update'),
                    'deleteMarket' => array('name' => 'Delete'),
                )
            ),
            'latestnews' => array(
                'name' => 'News',
                'hasChild' => array(
                    'viewLatestnews' => array('name' => 'List'),
                    'addLatestnews' => array('name' => 'Add'),
                    'editLatestnews' => array('name' => 'Edit/Update'),
                    'deleteLatestnews' => array('name' => 'Delete'),
                )
            ),
            'tenders' => array(
                'name' => 'Tender',
                'hasChild' => array(
                    'viewTender' => array('name' => 'List'),
                    'addTender' => array('name' => 'Add'),
                    'editTender' => array('name' => 'Edit/Update'),
                    'deleteTender' => array('name' => 'Delete'),
                )
            ),
            'bods' => array(
                'name' => 'Board of Directores',
                'hasChild' => array(
                    'viewBod' => array('name' => 'List'),
                    'addBod' => array('name' => 'Add'),
                    'editBod' => array('name' => 'Edit/Update'),
                    'deleteBod' => array('name' => 'Delete'),
                )
            ),
            'stafves' => array(
                'name' => 'Staff Directory',
                'hasChild' => array(
                    'viewStaff' => array('name' => 'List'),
                    'addStaff' => array('name' => 'Add'),
                    'editStaff' => array('name' => 'Edit/Update'),
                    'deleteStaff' => array('name' => 'Delete'),
                )
            ),
            'productcategories' => array(
                'name' => 'Product Category',
                'hasChild' => array(
                    'viewProductcategory' => array('name' => 'List'),
                    'addProductcategory' => array('name' => 'Add'),
                    'editProductcategory' => array('name' => 'Edit/Update'),
                    'deleteProductcategory' => array('name' => 'Delete'),
                )
            ),
            'products' => array(
                'name' => 'Product',
                'hasChild' => array(
                    'viewProduct' => array('name' => 'List'),
                    'addProduct' => array('name' => 'Add'),
                    'editProduct' => array('name' => 'Edit/Update'),
                    'deleteProduct' => array('name' => 'Delete'),
                )
            ),
            'productrates' => array(
                'name' => 'Product Rates',
                'hasChild' => array(
                    'viewProductrate' => array('name' => 'List'),
                    'addProductrate' => array('name' => 'Add'),
                    'editProductrate' => array('name' => 'Edit/Update'),
                    'deleteProductrate' => array('name' => 'Delete'),
                )
            ),
            'suppliers' => array(
                'name' => 'Suppliers',
                'hasChild' => array(
                    'viewSupplier' => array('name' => 'List'),
                    'addSupplier' => array('name' => 'Add'),
                    'editSupplier' => array('name' => 'Edit/Update'),
                    'deleteSupplier' => array('name' => 'Delete'),
                    'manageProductSupplier' => array('name' => 'Manage Products'),
                )
            ),
            'selloffers' => array(
                'name' => 'Sell Offer',
                'hasChild' => array(
                    'viewSelloffer' => array('name' => 'List'),
                    'addSelloffer' => array('name' => 'Add'),
                    'editSelloffer' => array('name' => 'Edit/Update'),
                    'deleteSelloffer' => array('name' => 'Delete'),
                )
            ),
            'supplierrequriments' => array(
                'name' => 'Supplier Requriments',
                'hasChild' => array(
                    'viewSupplierrequriment' => array('name' => 'List'),
                    'addSupplierrequriment' => array('name' => 'Add'),
                    'editSupplierrequriment' => array('name' => 'Edit/Update'),
                    'deleteSupplierrequriment' => array('name' => 'Delete'),
                    'smsSupplierrequriment' => array('name' => 'List SMS'),
                    'sendSmsSupplierrequriment' => array('name' => 'Send SMS'),
                    'deleteSmsSupplierrequriment' => array('name' => 'Delete SMS'),
                    'resendSmsSupplierrequriment' => array('name' => 'Re-Send SMS'),
                )
            ),
            'communications' => array(
                'name' => 'Communication SMS',
                'hasChild' => array(
                    'viewCommunication' => array('name' => 'List'),
                    'sendCommunication' => array('name' => 'Send'),
                    'resendCommunication' => array('name' => 'Re-Send'),
                    'deleteCommunication' => array('name' => 'Delete'),
                )
            ),
            'advertisements' => array(
                'name' => 'Advertisements',
                'hasChild' => array(
                    'viewAdvertisement' => array('name' => 'List'),
                    'addAdvertisement' => array('name' => 'Add'),
                    'editAdvertisement' => array('name' => 'Edit/Update'),
                    'deleteAdvertisement' => array('name' => 'Delete'),
                    'approveAdvertisement' => array('name' => 'Approval'),
                )
            ),
            'packets' => array(
                'name' => 'Manage Order Packing',
                'hasChild' => array(
                    'viewPacket' => array('name' => 'List'),
                    'addPacket' => array('name' => 'Add'),
                    'editPacket' => array('name' => 'Edit/Update'),
                    'deletePacket' => array('name' => 'Delete')
                )
            ),
            'emails' => array(
                'name' => 'Email Templates',
                'hasChild' => array(
                    'viewEmail' => array('name' => 'List'),
                    'editEmail' => array('name' => 'Edit/Update'),
                )
            ),
            'systemsettings' => array(
                'name' => 'Setting',
                'hasChild' => array(
                    'viewSystemSetting' => array('name' => 'Edit/Update')
                )
            )
        );
        return $permission;
    }
}

?>
