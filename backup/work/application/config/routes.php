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

|	https://codeigniter.com/user_guide/general/routing.html

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



$route['default_controller'] = 'gigs';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



$route['index/(:any)'] = 'gigs/index/$1';
$route['index/(:any)/(:any)'] = 'gigs/index/$1/$2';


$route['admin/completed_orders'] = 'admin/orders/completed_orders';
$route['admin/gig_activate'] = 'admin/gigs/gig_activate';
$route['admin/admin_delete_gigs'] = 'admin/gigs/admin_delete_gigs';

$route['admin/pending_orders'] = 'admin/orders/pending_orders';
$route['admin/reports'] = 'admin/review/report';

$route['admin/cancel_orders'] = 'admin/orders/cancel_orders';

$route['admin/decline_orders'] = 'admin/orders/decline_orders';

$route['admin/completed_payments/(:any)'] = 'admin/completed_payments/index/$1';

$route['admin/orders/(:any)'] = 'admin/orders/index/$1';

$route['admin/rejected_orders'] = 'admin/orders/rejected_orders';

$route['admin/rejected_orders/(:any)'] = 'admin/orders/rejected_orders/$1';

$route['admin/completed_orders/(:any)'] = 'admin/orders/completed_orders/$1';

$route['admin/pending_orders/(:any)'] = 'admin/orders/pending_orders/$1';

$route['admin/cancel_orders/(:any)'] = 'admin/orders/cancel_orders/$1';

$route['admin/decline_orders/(:any)'] = 'admin/orders/decline_orders/$1';

$route['orders'] = 'admin/orders';

$route['orders/accept_rejected_orders/(:any)/(:any)'] = 'admin/orders/accept_rejected_orders/$1/$2';

$route['activate_account/(:any)'] = 'user/dashboard/activate_account/$1';

$route['change_password/(:any)'] = 'user/dashboard/change_password/$1';

$route['pages/(:any)'] = 'gigs/pages/$1';

$route['pages/(:any)'] = 'gigs/pages/$1';

$route['help-center/category/(:num)/(:any)'] = 'gigs/help_center_pages/$1/$2';

$route['help-center/search-for/(:any)'] = 'gigs/help_center_pages_search_result/$1';
$route['help-center/form_submit/'] = 'gigs/form_submit/';


// for admin
$route['FAQ/category'] = 'admin/help_center/category';

$route['FAQ/content'] = 'admin/help_center/content';
$route['FAQ/add_category'] = 'admin/help_center/add_category';
$route['FAQ/edit-category/(:num)'] = 'admin/help_center/edit_category/$1';
$route['FAQ/add-new-content'] = 'admin/help_center/add_new_content';
$route['FAQ/edit-content/(:num)'] = 'admin/help_center/edit_content/$1';
// $route['FAQ/form_submit/'] = 'gigs/form_submit/';

// for admin


$route['account_activate/(:any)'] = 'gigs/index2/$1';





$route['admin'] = 'admin/dashboard';

$route['admin/terms'] = 'admin/dashboard/terms';

$route['admin/create'] = 'admin/dashboard/create';

/* user  */


$route['signup']='user/signup';
$route['signup/(:any)']='user/signup/index/$1';
$route['login']='user/signup/user_login';
$route['login/(:any)']='user/signup/user_login/$1';

// $route['signup/index/(:any)']='user/signup/index/$1';



$route['load_more_userfeedbacks'] = 'gigs/load_more_userfeedbacks';

$route['escort-profile'] = 'user/sell_service';

$route['escort-profile/(:any)/(:any)'] = 'user/sell_service/edit_user/$1/$2';

$route['agency-profile/(:any)/(:any)'] = 'user/sell_service/edit_user/$1/$2';

$route['establishment-profile/(:any)/(:any)'] = 'user/sell_service/edit_user/$1/$2';

$route['buy-service/(:any)'] = 'user/buy_service/index/$1';

$route['buy-service'] = 'user/buy_service';

$route['my-gigs'] = 'gigs/my_gigs';

$route['my-packages'] = 'gigs/my_gigs';



$route['load_more_feedbacks'] = 'gigs/load_more_feedbacks';

$route['check_password'] = 'gigs/check_password';


$route['remove_favourites'] = 'gigs/remove_favourites';

$route['add_favourites'] = 'gigs/add_favourites';


$route['view-all-category'] = 'gigs/view_all_category';


$route['search_influencer'] = 'gigs/search_influencer';

$route['tandc'] = 'gigs/tandc';
$route['t&c'] = 'gigs/tandc';

$route['get_state_list'] = 'gigs/get_state_list';



$route['logout'] = 'gigs/logout';

$route['devicedetails'] = 'gigs/devicedetails';



$route['prf_crop'] = 'gigs/prf_crop';

$route['my-gigs/(:any)'] = 'gigs/my_gigs/$1';

$route['user-packages/(:any)/(:any)'] = 'gigs/user_gigs_get_dsp/$1/$2';

$route['user-packages/(:any)'] = 'gigs/user_gigs_get_dsp/$1';

$route['package-preview'] = 'gigs/gig_preview'; 

$route['price-table-for/(:any)'] = 'gigs/price_table_for/$i';  
$route['addon'] = 'gigs/addon_data';  

$route['escort/(:any)/(:any)'] = 'gigs/public_profile/$1/$2';
$route['agency/(:any)/(:any)'] = 'gigs/public_profile/$1/$2';
$route['establishment/(:any)/(:any)'] = 'gigs/public_profile/$1/$2';


$route['package-preview'] = 'gigs/gig_preview';  

$route['es-preview/(:any)/(:any)'] = 'gigs/gig_preview/$1/$2';


$route['user-profile'] =  'gigs/user_profile';


$route['terms'] = 'gigs/terms';

$route['user-profile/(:any)'] = 'gigs/user_profile/$1';

$route['user-about/(:any)'] = 'gigs/user_about/$1';

$route['user-review/(:any)'] = 'gigs/user_review/$1';

$route['user-profile/(:any)/(:num)'] = 'gigs/user_profile/$1/$2';

$route['last-visited'] = 'gigs/last_visited';

$route['payment-settings'] = 'gigs/payment_settings';  

$route['edit-gig/(:any)'] = 'gigs/edit_gig/$1';


$route['edit-package/(:any)/(:any)'] = 'gigs/edit_gig/$1/$2';

$route['category-search/(:any)'] = 'user/search/category_search/$1';

$route['purchase-success']= 'user/buy_service/purchase_success';

$route['purchase-success/(:any)']= 'user/buy_service/purchase_success/$1';



$route['files'] = 'user/sales/my_files'; // Digital Downloads 

$route['files/(:any)'] = 'user/sales/my_files/$1';

$route['upload'] = 'user/sales/my_upload_file'; // Digital Downloads 

//$route['lists'] = 'user/sales/file_list'; // Digital Downloads 

$route['fileremove'] = 'user/sales/file_remove'; // Digital Downloads 



$route['reminder'] = 'gigs/reminder';

$route['profile'] = 'gigs/profile';

$route['password'] = 'gigs/password';

$route['social-profile'] = 'gigs/social_profile';

$route['notification'] = 'gigs/notification';  

$route['search'] = 'user/search/index';

// $route['search/'] = 'user/search/index';

$route['search/index'] = 'user/search/index';

$route['search/index/(:any)'] = 'user/search/index/$1/'; 

$route['search/index/(:any)/(:any)'] = 'user/search/index/$1/$2'; 

$route['search/index/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3'; 

// Search country and state 

$route['search/index/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4'; 	

$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5'; 	

$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15/$16'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15/$16/$17'; 	
$route['search/index/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'user/search/index/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10/$11/$12/$13/$14/$15/$16/$17/$18'; 

	

$route['search/location'] = 'user/search/location';

$route['search/location/(:any)'] = 'user/search/location/$1';

$route['search/recent'] = 'user/search/recent';

$route['search/recent/(:any)'] = 'user/search/recent/$1';

$route['search/category'] = 'user/search/category';

$route['search/category/(:any)'] = 'user/search/category/$1';

$route['search/category/(:any)/(:any)'] = 'user/search/category/$1/$2';


$route['admin/manage-city'] = 'admin/city/index/';

$route['message'] = 'user/message';

$route['message/(:any)'] = 'user/message/index/$1';

$route['purchases'] = 'user/purchases';

$route['purchases/(:any)'] = 'user/purchases/index/$1';

$route['sales'] = 'user/sales';

$route['sales/(:any)'] = 'user/sales/index/$1';

$route['payments'] = 'user/payments';

$route['payments/(:any)'] = 'user/payments/index/$1';

$route['wallets'] = 'user/wallets';



$route['admin/emailsettings'] = 'admin/settings/emailsettings';

$route['admin/gigs/(:any)'] = 'admin/gigs/index/$1';
$route['admin/packages'] = 'admin/gigs/index/$1';

$route['admin/enquiry'] = 'admin/gigs/enquiry';
$route['admin/get_one_data'] = 'admin/gigs/get_one_data';

$route['admin/packages/package_preview/(:any)'] = 'admin/gigs/gig_preview/$1';

$route['admin/packages/(:any)'] = 'admin/gigs/index/$1';
$route['gigs/index/(:any)'] = 'gigs/index/$1';



$route['our-blog/(:any)/(:any)'] = 'gigs/blog/$i/$i';
$route['our-blog/(:any)/(:any)/(:any)'] = 'gigs/blog/$1/$2/$3';

$route['contact_us'] = 'gigs/contact_us';
$route['aboutus'] = 'gigs/aboutus';
$route['help_center'] = 'gigs/help_center';





$route['read-blog/(:any)/(:any)'] = 'gigs/read_blog/$1/$2';


$route['admin/manage-membership'] = 'admin/membership/index/';
$route['admin/manage-banner'] = 'admin/banner/index/';
$route['admin/manage-membership/edit-membership/(:any)'] = 'admin/membership/edit_membership/$1';
$route['admin/manage-membership/add-membership'] = 'admin/membership/add_membership/';

$route['admin/manage-dropdown'] = 'admin/dropdown/index/';