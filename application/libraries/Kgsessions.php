<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Kgsessions {
		private $CI;

		function __construct() { 
			$this->CI =& get_instance();
		}

		public function set_session($sSessKey, $sSessData) {
			get_instance()->session->set_userdata(SESSKEY."_".$sSessKey, $sSessData);
		}

		public function get_session($sSessKey) {
			return get_instance()->session->userdata(SESSKEY."_".$sSessKey);
		}

		public function unset_session($sSessKey) {
			get_instance()->session->unset_userdata(SESSKEY."_".$sSessKey);
		}

		public function check_session() {
			$dLastVisit =	date("Ymdhi", strtotime($this->get_session("last_visit"))); 
			$dExpTime 	=	date("Ymdhi", strtotime("-".SESSEXP." minutes"));

			if (!empty($dLastVisit)) {
				if ($dLastVisit > $dExpTime) {
					$this->set_session("last_visit", date("YmdHi"));
					return true;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}
	}
?>