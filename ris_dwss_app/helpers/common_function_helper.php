<?php
/*
 *   Array Function Start
*/

    if (!function_exists('MultiArrayToSinlgeArray')) {
        function MultiArrayToSinlgeArray($multi_dimensional_array) {
            $single_dimensional_array = array();
            foreach ($multi_dimensional_array as $val) {
                if (is_array($val)) {
                    foreach ($val as $val2) {
                        $single_dimensional_array[] = $val2;
                    }
                }
            }
            return $single_dimensional_array;
        }
    }

    if (!function_exists('subvalue_sort')) {
        function subvalue_sort($a, $subkey) {
            $c = NULL;
            foreach ($a as $k => $v) {
                $b[$k] = strtolower($v->$subkey);
            }
            if (isset($b) && is_array($b)) {
                asort($b);
                foreach ($b as $key => $val) {
                    $c[] = $a[$key];
                }
            }
            return $c;
        }
    }

    if (!function_exists('getArrayNexyValue')) {
        function getArrayNexyValue(&$array, $curr_val) {
            $next = false;
            reset($array);
            do {
                $tmp_val = current($array);
                $res = next($array);
            } while (($tmp_val != $curr_val) && $res);
            if ($res) {
                $next = current($array);
            }
            return $next;
        }
    }

    if (!function_exists('getArrayPreviousValue')) {
        function getArrayPreviousValue(&$array, $curr_val) {
            end($array);
            $prev = current($array);
            do {
                $tmp_val = current($array);
                $res = prev($array);
            } while (($tmp_val != $curr_val) && $res);
            if ($res) {
                $prev = current($array);
            }
            return $prev;
        }
    }

    if (!function_exists('objectToArray')) {
        function objectToArray($array) {
            if (is_object($array)) {
                $array = get_object_vars($array);
            }
            
            if (is_array($array)) {
                return array_map(__FUNCTION__, $array);
            } else {
                return $array;
            }
        }
    }

    if (!function_exists('array_column')) {
        function array_column($array, $column) {
            $col = array();
            if(is_object($array)){
                $array = objectToArray($array);    
            }
            
            foreach ($array as $k => $v) {
                if(is_object($v)){
                    $v = objectToArray($v);    
                }
                $col[$k] = $v[$column];
            }
            return $col;
        }
    }

/*
 *   Array Function End
*/

if (!function_exists('setLanguage')) {
    
    function setLanguage() {
        $ci = & get_instance();
        $session = $ci->session->userdata('user_session');
        
        if (!empty($session)) {
            $lang = $session->language;
        } else {
            $lang = $ci->config->item('default_language');
        }

        $all_langs = $ci->config->item('custom_languages');
        $lang = $all_langs[$lang];
        $ci->config->set_item('language', $lang);
        $file = 'main';
        $ci->lang->load($file, $lang);
    }
}

if (!function_exists('getRoleName')) {
    
    function getRoleName($id) {
        $role = new Role();
        $role->where('id', $id)->get();
        $ci = & get_instance();
        $session = $ci->session->userdata('user_session');
        if (!empty($session)) {
            return $role->{$session->language . '_role_name'};
        } else {
            return $role->en_role_name;
        }
    }
}
?>