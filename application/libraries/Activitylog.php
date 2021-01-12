<?php
	/*
		Created by 		: Consumer Cloud Services/ Datahold, Inc. (Philippines)
		Created date 	: July 12, 2019

		============================================================================================================
		Documentation 	
			Current version 	: 1.0.0
			Previous versions 	: none
			Last Modified 		: July 12, 2019

		PROPERTIES:
			Name 				Data Type 	Value/ Description
			- app_id			string 		A constant unique value.
											'APP-HATVC-001' is the app_id for this system
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- ip_address 		string 		IP Address of current user
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- user_id			bigint		User ID of current user
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- user_agent 		string 		User agent of current user
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- host_name 		string 		Current URL when a certain activity of 
											cuurent user occur
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- activity_code 	string 		See below codes for reference:
											ACT_LOGIN		= 01 : Use when current user logs in the system
											ACT_PAGEVISIT	= 02 : Use when current user redirects to another URL inside the system
											ACT_TIMEOUT		= 03 : Use when the session of current user expires
											ACT_LOGOUT		= 04 : Use when current user logs out in the system
											ACT_ADD			= 05 : Use when an item has been added by the current user
											ACT_EDIT		= 06 : Use when an item has been edited by the current user
											ACT_DELETE		= 07 : Use when an item has been deleted by the current user
											ACT_FILTER		= 08 : Use when the current user filter an item list
											ACT_PRINT		= 09 : Use when the current user prints an item
											ACT_EXPORT		= 10 : Use when the current user exports an item
											ACT_APICALL		= 11 : Use when there is an API call
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- item_name 		string 		TBD (To Be Defined)
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- item_id	 		bigint		Item Id of the item that to be edited/added
											(i.e.: User Id for user)
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- session_token 	string 		random string to be created every new session
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- pre_state 		JSON/ 		Current data before an update has been saved
								Array 		When passing to a function, it should be
											Array
			+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			- post_state 		JSON/ 		Data after an update has been saved
								Array		When passing to a function, it should be
											Array

			
	*/

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/// Ginagamit para i-save ang mga datos sa kalipunan ng dato
	class Activitylog extends CurrentUser {

		/// Gamitin pag gumawa ng bagong datos ang user
		public function LogAddItem($nItemId, $sItemName, $vPostState) {
			$this->LogUpdateItem(ACT_ADD, $nItemId, $sItemName, null, $vPostState);
		}

		/// Gamitin pag may binagong datos ang user
		public function LogEditItem($nItemId, $sItemName, $vPreState, $vPostState) {
			$this->LogUpdateItem(ACT_EDIT, $nItemId, $sItemName, $vPreState, $vPostState);
		}

		/// Gamitin pag may tinanggal na datos ang user
		public function LogDeleteItem($nItemId, $sItemName, $vPreState, $vPostState) {
			$this->LogUpdateItem(ACT_DELETE, $nItemId, $sItemName, $vPreState, $vPostState);
		}

		/// Gamitin pag nag-filter ang user
		/// Sa pagkakataong ito, ang nilalaman ng $vPostState ay
		/// ang mga value na kanyang ibinigay. Ang sumusunod na halimbawa ay filter ng user
		/// array("usrname" => "admin")
		public function LogFilterItem($sItemName, $vPostState) {
			$this->LogUpdateItem(ACT_FILTER, null, $sItemName, null, $vPostState);
		}

		/// Gamitin pag nag-export ang user
		/// Sa pagkakataong ito, ang nilalaman ng $vPostState ay
		/// ang mga value ng kanyang filte. Ang sumusunod na halimbawa ay filter ng user
		/// array("username" => "abc")
		public function LogExportItem($sItemName, $vPostState) {
			$this->LogUpdateItem(ACT_EXPORT, null, $sItemName, null, $vPostState);
		}

		/// Maaari itong gamitin kung ayaw mong gamitin ang mga nasa itass.
		/// Mangyari lamang na tignan ang dokumentasyon (PROPERTIES: activity_code) upang malaman ang value ng $vMethod
		public function LogUpdateItem($vMethod, $nItemId, $sItemName, $vPreState, $vPostState) {
			$aActivity = array(
				"activity_code"	=> $Method,
				"item_name"		=> $sItemName,
				"item_id"		=> $nItemId,
				"pre_state"		=> json_encode($vPreState),
				"post_state"	=> json_encode($vPostState)
			);

			$this->SaveActivity($aActivity);
		}

		/// Gamitin pag ang user pag may pinuntahang isang kawing (URL) na nasa loob ng sistema
		public function PageVisit() {
			$CI =& get_instance();

			$aActivity = array(
				"activity_code"	=> ACT_PAGEVISIT,
				"item_name"		=> $CI->session->userdata('sess_page'),
				"item_id"		=> null,
				// "pre_state"		=> json_encode(array(
				// 						"url"	=> $CI->agent->referrer()
				// 				   )),
				"pre_state"		=> null,
				"post_state"	=> json_encode(array(
										"url"	=> current_url()
								   ))
			);

			$this->SaveActivity($aActivity);
		}

		public function LogAPI($sItemName, $aPreState, $aPostState) {
			$aActivity = array(
				"activity_code"	=> ACT_APICALL,
				"item_name"		=> $sItemName,
				"item_id"		=> null,
				"pre_state"		=> json_encode(array("body" => $vPreState)),
				"post_state"	=> json_encode(array("returndata" => $vPostState))
			);

			$this->SaveActivity($aActivity);
		}

		public function SaveActivity($aData) {
			$CI =& get_instance();
			$CI->load->library('user_agent');

			$aActivity = array(
				"app_id" 		=> APPLICATIONID,
				"ip_address"	=> $this->get_ipaddress(),
				"user_id"		=> $this->get_userid(),
				"user_agent"	=> $this->get_useragent(),
				"host_name"		=> current_url(),
				"activity_code"	=> $aData["activity_code"],
				"item_name"		=> $aData["item_name"],
				"item_id"		=> $aData["item_id"],
				"session_token"	=> $this->get_token(),
				"pre_state"		=> $aData["pre_state"],
				"post_state"	=> $aData["post_state"]
			);

			$CI->hatvclib->execQuery("sp_AddActivityLog", $aActivity);
		}
	}
?>