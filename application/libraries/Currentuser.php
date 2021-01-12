<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Currentuser {
		private $CI;

		function __construct() { $this->CI =& get_instance(); }

		public function set_userid($userid) { get_instance()->session->set_userdata('sess_userid', $userid); }
		public function get_userid() { return get_instance()->session->userdata('sess_userid'); }

		public function set_username($username) { get_instance()->session->set_userdata('sess_username', $username); }
		public function get_username() { return get_instance()->session->userdata('sess_username'); }

		public function set_token($vToken) { get_instance()->session->set_userdata('sess_token', $vToken); }
		public function get_token() { return get_instance()->session->userdata('sess_token'); }

		public function get_useragent() { return $_SERVER['HTTP_USER_AGENT']; }

		public function get_ipaddress() { return $_SERVER['REMOTE_ADDR']; }

		public function get_user_info($sUname) {

			$eUserName =	$this->CI->db->query("SELECT * FROM tblkp_users WHERE `Username` ='".$sUname."'");
			$aUserName =	$eUserName->result_array();


			return $aUserName;
		}		
	}
?>