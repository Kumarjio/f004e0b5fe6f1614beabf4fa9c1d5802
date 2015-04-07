<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

include_once (APPPATH . 'helpers/inflector_helper.php');

$path = explode('/', $_SERVER['REQUEST_URI']);
if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '192.168.1.29') {
  @$controller = null;
  if(@$path[2] == 'user'){
    @$controller = $path[3];  
  }
} else {
  @$controller = null;
  if(@$path[2] == 'user'){
    @$controller = $path[3];  
  }
}

$route['user/' . $controller] = 'user/' . plural($controller) . "/view" . ucwords($controller);
$route['user/' . $controller . '/list'] = 'user/' . plural($controller) . "/view" . ucwords($controller);
$route['user/' . $controller . '/view/(:num)'] = 'user/' . plural($controller) . "/view" . ucwords($controller) . "/$1";
$route['user/' . $controller . '/view/(:num)/(:any)'] = 'user/' . plural($controller) . "/view" . ucwords($controller) . "/$1/$2";
$route['user/' . $controller . '/add'] = 'user/' . plural($controller) . "/add" . ucwords($controller);
$route['user/' . $controller . '/edit/(:num)'] = 'user/' . plural($controller) . "/edit" . ucwords($controller) . "/$1";
$route['user/' . $controller . '/delete/(:num)'] = 'user/' . plural($controller) . "/delete" . ucwords($controller) . "/$1";
$route['user/' . $controller . '/getjson'] = "user/json/get" . ucwords(plural($controller)) . "JsonData";

//Default
$route['default_controller'] = "welcome/index";
$route['404_override'] = '';

/*
* user SIDE URLS
*/

$route['user/change_language/(:any)'] = "user/ajax/setNewLanguage/$1";

//Authenticate
$route['user'] = "user/dashboard/index";
$route['user/dashboard'] = "user/dashboard/index";
$route['user/login'] = "user/authenticate/index";
$route['user/validate'] = "user/authenticate/validateUser";
$route['user/logout'] = "user/authenticate/logout";
$route['user/forgot_password'] = "user/authenticate/userForgotPassword";
$route['user/send_reset_password_link'] = "user/authenticate/userSendResetPasswordLink";
$route['user/reset_password/(:any)'] = "user/authenticate/userResetPassword/$1";
$route['user/denied'] = "user/authenticate/permissionDenied";

//Dashboard
$route['user/get_dashboard_count'] = 'user/ajax/getDashboardTotalCountData';

//System Setting
$route['user/system_setting/(:any)'] = "user/systemsettings/viewSystemSetting/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */