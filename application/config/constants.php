<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('ACT_LOGIN'		, '01');
define('ACT_PAGEVISIT'	, '02');
define('ACT_TIMEOUT'	, '03');
define('ACT_LOGOUT'		, '04');
define('ACT_ADD'		, '05');
define('ACT_EDIT'		, '06');
define('ACT_DELETE'		, '07');
define('ACT_FILTER'		, '08');
define('ACT_PRINT'		, '09');
define('ACT_EXPORT'		, '10');
define('ACT_APICALL'	, '11');

define('KEYCODE' 		, 'Thec0debr3@ker');
define('APPLICATIONID'	, 'APP-SEREHRIS-001');
define('APICODE', 'PR-JESTH925252_E2218');
define('APIPASS', 'gu8p#61$j1');

define('SESSKEY' 		, 'serendipity_hris');
define('SESSEXP'		, 15);

define('REGION',  array(
	'1' => 'IR',
	'2' => 'CG',
	'3' => 'CL',
	'4' => 'ST',
	'5' => 'BR',
	'6' => 'WV',
	'7' => 'CV',
	'8' => 'EV',
	'9' => 'ZP',
	'10' => 'NM',
	'11' => 'DR',
	'12' => 'SK',
	'13' => 'MM',
	'14' => 'CO',
	'15' => 'BA',
	'16' => 'CR',
	'17' => 'SW',
	'18' => 'TT'
));



define('DROPTYPES', array('position', 'religion', 'shift', 'branch', 'timelogs', 'appstat'));

define('APPSTAT', 	array('ne' => 'New', 'ii' => "Initial Interview", 'de' => "Deployment", 'fa' => "Fail", 'fi' => "Final Interview", 'fm' => "For Medical", 'fr' => "For Requirements", 'in' => "Invited", 'pa' => "Pass", 'pq' => "Pre-qualified", 'tr' => "Training"));

define('STATPALETTE', 	array('ne' => 'bg-aqua', '
	ii' => "bg-aqua", 
	'de' => "bg-light-blue", 
	'fa' => "bg-gray", 
	'fi' => "bg-orange", 
	'fm' => "bg-maroon", 
	'fr' => "bg-teal", 
	'in' => "br-blue", 
	'pa' => "bg-green", 
	'pq' => "bg-purple", 
	'tr' => "Training"));


define('CIVILSTATS', array(
				's' => 'Single',
				'm' => 'Married',
				'd' => 'Divorced',
				'l' => 'Leagally Separated',
				'w' => 'Widow',
				'r' => 'Widower'
			));
define('GENDER', array('m' => 'Male', 'f' => 'Female'));




define('QUALIFICATIONS', array(
							'm' 		=>	'Male',
							'f'			=>	'Female',
							'agelimit' 	=>	'Age Limit',
							'h' 		=>	'High School Graduate',
							'c' 		=>	'College Level',
							'cg' 		=>	'College Graduate',
							'wexpe' 	=>	'With Experience',
							'woexpe' 	=>	'Without Experience',
							'license' 	=>	'License Code',
						));

define('LICENSECODE', array(
							'1' 		=>	'1',
							'1,2'		=>	'1,2',
							'1,2,3' 	=>	'1,2,3',
						));

define('RECRUITMENTURL', 'http://localhost:8080/serendipity_recruitment/candidates');

define('EDUCTYPE', array('e' => 'Elementary','h' => 'High School','s' => 'Senior High','v' =>'Vocational','c' => 'College','m' => 'Mastery/Doctorate'));
define('SKILLLEVEL', array('b' => 'Begginer','i' => 'Intermediate','p' => 'Proficient','e' =>'Expert'));

define('ACCESSLEVEL', array('1' => 'Office Recruiter', '2' => 'Account Administrator', '3' => 'System Administrator'));