<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'my404';
$route['translate_uri_dashes'] = FALSE;


/**customers auth */
$route['login'] = "Customer/Auth/login";
$route['register'] = "Customer/Auth/register";
$route['customer_register_req'] = "Customer/Auth/register_req";
$route['otp'] = "Customer/Auth/otp_screen";
$route['verify_otp_req'] = "Customer/Auth/verify_otp_req";
$route['user_name_password'] = "Customer/Auth/user_name_password";
$route['login_req'] = "Customer/Auth/login_req";
$route['destroy_session_user'] = "Customer/Auth/destroy_session_user";

$route['register_resend/(:num)'] = "Customer/Auth/register_resend/$1";




/**puja  */
$route['pooja-list'] = "Customer/Puja/index";
$route['pooja-details/(:num)'] = "Customer/Puja/puja_details/$1";

/**astrologer */

$route['astrologer-list'] = "Customer/Astrologer/index";


















// $route['api/customers/add_to_cart_update'] = "webservices/add_to_cart_update";






















































// professionals app
$route['api/professionals/job_action'] = "webservices/job_action";
$route['api/professionals/job_complete'] = "webservices/job_complete";
$route['api/professionals/job_start'] = "webservices/job_start";
$route['api/professionals/end_job'] = "webservices/end_job_otp";
$route['api/professionals/professionals_support'] = "webservices/professionals_support";
$route['api/professionals/update_lat_long'] = "webservices/pro_update_lat_long";
$route['api/professionals/pay_by_cash'] = "webservices/cash_payment";
$route['api/professionals/pro_login'] = "webservices/pro_login";
$route['api/professionals/pro_forgot_password'] = "webservices/pro_forgot_password";
$route['api/professionals/pro_ongoing_booking'] = "webservices/pro_ongoing_booking";
$route['api/professionals/pro_booking'] = "webservices/pro_booking";
$route['api/professionals/pro_start_booking_details'] = "webservices/pro_start_booking_details";
$route['api/professionals/pro_booking_history_details'] = "webservices/pro_booking_history_details";
$route['api/professionals/pro_update_lat_long'] = "webservices/pro_update_lat_long";












// saloon admin login

$route['saloon'] = "saloon/login";


//saloon API
$route['api/saloon/saloon_login'] = "webservices/saloon_login";
$route['api/saloon/saloon_forgot_password'] = "webservices/saloon_forgot_password";
$route['api/saloon/saloon_new_booking'] = "webservices/saloon_new_booking";
$route['api/saloon/saloon_my_booking'] = "webservices/saloon_my_booking";
$route['api/saloon/saloon_assign_job'] = "webservices/saloon_assign_job";
$route['api/saloon/saloon_professional'] = "webservices/saloon_professional";
$route['api/saloon/saloon_logout'] = "webservices/saloon_logout";
$route['api/saloon/saloon_services'] = "webservices/saloon_services";
$route['api/saloon/saloon_my_profile'] = "webservices/saloon_my_profile";
$route['api/saloon/saloon_edit_profile_request'] = "webservices/saloon_edit_profile_request";
$route['api/saloon/saloon_total_earning'] = "webservices/saloon_total_earning";

$route['api/saloon/saloon_job_action'] = "webservices/saloon_job_action";
$route['api/saloon/shop_notifications'] = "webservices/shop_notifications";


//SD
$route['Login'] = "sdauth/login";
$route['Registration'] = "sdauth/registration";
$route['Otpverify'] = "sdauth/otpverify";
$route['ResendOtp'] = "sdauth/resendOtp";
$route['ResendOtpPwd'] = "sdauth/resendOtppwd";
$route['Otpverifypwd'] = "sdauth/otpverifypwd";
$route['Forget'] = "sdauth/forget";
$route['Change-password'] = "sdauth/change_password";
$route['GetAstrologer'] = "sdauth/GetAstrologer";
$route['HOME'] = 'home';



