<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Policy {
		private $CI;

		function __construct() {
			$this->CI =& get_instance();
		}


		/*
			SUMMARY
				adds policy log

			PARAMETER
				nCustId 	int 	Customer ID
				username 	string 	Current user/ agent who did the transaction

			RETURN
				sPolicyNum 	string 	Generated policy number
		*/
		public function add_policy_log($nCustId, $username) {
			$parms					= 	array("vCustId" => $nCustId, "username" => $username);

			$sSpName                =   "sp_AddPolicyLog";
            $insertData             =   $this->CI->hatvclib->execQuery($sSpName, $parms);
            $aResult                =   $insertData->result_array();

            $return = array();

			if($aResult[0]["vFlag"] == "1") {
				$return = array(
					"status"		=> "ok",
					"message"		=> "success",
					"policy_num"	=> $aResult[0]["sPolNo"]
				);
			} else {
				$return = array(
					"status"		=> "failed",
					"message"		=> "Failed to generate policy number",
					"policy_num"	=> null
				);
			}

            $insertData->next_result();
            $insertData->free_result();

            return $return;
		}

		/*
			SUMMARY
				adds policy to tbl_policy

			PARAMTER
		*/
		public function add_policy($sPolicyNumber, $nCustomerId, $sSaleStaus, $sPaymentMethod, $sPaymentFrequency, $nAmount) {
			$parms = array(
				"policy_number"		=> $sPolicyNumber,
				"customer_id"		=> $nCustomerId,
				"sale_status"		=> $sSaleStaus,
				"payment_method"	=> $sPaymentMethod,
				"payment_frequency"	=> $sPaymentFrequency,
				"amount"			=> $nAmount
			);

			$return = array();

			$sSpName        =   "sp_AddPolicy";
            $insertData     =   $this->CI->hatvclib->execQuery($sSpName, $parms);
            $aResult        =   $insertData->result_array();

            if($aResult[0]["vFlag"] == "1") {
				$return = array(
					"status"		=> "ok",
					"message"		=> "success"
				);
			} else {
				$return = array(
					"status"		=> "failed",
					"message"		=> "Failed to add policy"
				);
			}

            $insertData->next_result();
            $insertData->free_result();

            return $return;
		}
	}

?>