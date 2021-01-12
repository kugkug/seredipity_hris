<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] 	= 	'login';
$route['404_override'] 			= 	'Modules/not_found';
$route['translate_uri_dashes']  = 	FALSE;


/* Developer's Option Route Pages*/
$route['devop-add-menu'] 		=	"Developer/add_new_menu";
$route['devop-get-menu'] 		=	"Developer/get_menu_list";
$route['devop-add-modules'] 	=	"Developer/add_new_modules";


//Login Routes

$route['get-page']				=	"Login/get_page";
$route['check-login']			=	"Login/login";
$route['logout']				=	"Login/logout";

//Accounts Settings 
$route['proc-accounts-settings'] 	=	"Account_settings/proc_account_settings";

//Accounts Routes
$route['proc-accounts']				=	"User_accounts/proc_accounts";

$route['proc-company']				=	"Company/proc_company";
$route['proc-general-information']	=	"General_information/proc_general_information";
$route['proc-supervisors']			=	"Supervisors/proc_supervisors";
$route['proc-upload-photo-sign']	=	"Global_funcs/upload_photo_sign";
$route['proc-global']				=	"Global_funcs/proc_global_funcs";
$route['proc-dropdowns']			=	"Global_funcs/proc_dropdowns";
$route['proc-executor']				=	"Executor/proc_executor";
$route['proc-workers']				=	"Workers/proc_workers";
$route['proc-applicants']			=	"Applicants/proc_applicants";
$route['proc-client-request']		=	"Client_request/proc_client_request";


$route['proc-summary']				=	"Summary/proc_summary";
$route['proc-summary-report']		=	"Summary/genReport";
$route['proc-upload']				=	"Home/proc_upload";
$route['proc-home-timer']			=	"Home/proc_home_timer";
$route['home'] 						=	"Modules/home";

$route['newclient']					=	"Modules/newclient";
$route['newrequest']				=	"Modules/newrequest";
$route['procclient']				=	"Modules/process_client_request";
$route['editrequest']				=	"Modules/edit_client_request";
$route['editclient']				=	"Modules/editclient";
$route['dropwdowns']				=	"Modules/dropwdowns";
$route['workerinfo']				=	"Modules/workerview";
$route['applicantinfo']				=	"Modules/applicantview";
$route['changepassword']			=	"Modules/change_password";


require_once( BASEPATH .'database/DB.php');
$db =& DB();
$query = $db->get( 'tbl_sysmodules' );

$result = $query->result();
foreach( $result as $row )
{
 	$route[strtolower($row->ModPath)]	=	"Modules/".ucfirst(strtolower($row->ModPath));
}
