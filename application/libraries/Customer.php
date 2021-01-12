<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Customer {
		private $CI;

		function __construct() {
			$this->CI =& get_instance();
			ob_clean();
		}

		public function GetEmployees($aData) {
			
			$aEmployee 		=	array();
			$sSpName        =   "sp_GetEmployee";
            $eEmpInfo       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eEmpInfo->result_array();
            
            $this->CI->hatvclib->ConnClose($eEmpInfo);

            return $aResult;
		}

		public function GetApplicants($aData) {
			
			$aEmployee 		=	array();
			$sSpName        =   "sp_GetApplicants";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();

            $this->CI->hatvclib->ConnClose($eGetData);
            
            return $aResult;
		}

		public function GetAgentDetails($vTrxId) {
			$aReturn 		=	array();
			$aTables 		=	array('educ' => 'tbl_education', 'skills' => 'tbl_skills', 'trains' => 'tbl_trainings', 'employ' => 'tbl_employment', 'medic' => 'tbl_medical', 'reqs' => 'tbl_requirements');

			foreach ($aTables as $sKey => $sTblName) {
				$qQuery 		=	"SELECT * FROM `".$sTblName."` WHERE `agent_trx_id` ='".$vTrxId."'";
	            $eGetData       =   $this->CI->db->query($qQuery);
	            $aResult        =   $eGetData->result_array();

	            if (sizeof($aResult) > 0 )
	            {
	        		// $eGetData->next_result();    
    				$eGetData->free_result();

    				$aReturn[$sKey] =	$aResult;
    			}
    			else {
    				$aReturn[$sKey] =	array();
    			}	  
			}

        	return $aReturn;
            
		}

		public function GetEmployeeInfo($aData) {

			$aReturn 	=	array();
			$aInfo 		=	$this->GetEmployees($aData);	

			// $aDetails 	=	$this->GetAgentDetails($aData['trxid']);

			return $aInfo[0];
		}

		public function GetEmployeeList() {
			$aList 	=	$this->GetEmployees(array('trxid' => ''));

			$sHtml 			=	"<table class='table table-striped table-hover table-data'>
								<thead>
            					</tr>
            						<th class='hidden-xs hidden-sm'>Employee No.</th>
            						<th>Employee Name</th>
            						<th class='hidden-xs hidden-sm'>Position</th>
            						<th class='hidden-xs hidden-sm'>Company Assigned</th>
            						<th class='hidden-xs hidden-sm'>Work Location</th>
            						<th class='hidden-xs hidden-sm'>Supervisor</th>
            						<th class='hidden-xs hidden-sm'>Status</th>
            						<th>Action</th>
            					</tr>
            					</thead>
            					";
            if (sizeof($aList) > 0 ) {

	           	foreach ($aList as $nKey => $aEmpValues) {

	        		// <li><a href='#' class='text-green' data-trigger='edit' data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-edit'></i> Edit Info</a></li>
	        		$sActions 	=	"
	        						<div class='btn-group'>
	            						<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
						                    <span class='fa fa-tasks' style='font-size: 1.2em !important;'></span>
						                    <span class='sr-only'>Toggle Dropdown</span>
						                  </a>
						                <ul class='dropdown-menu' role='menu'>
						                	<li><a href='#' class='text-light-blue' data-trigger='view' data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-search'></i> View Details</a></li>
						                	<li><a href='#' class='text-yellow' data-trigger='trans' data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-undo'></i> Transfer</a></li>
						                    <li class='divider'></li>";

					if ($aEmpValues['agent_status'] == "deployed") 
					{
						$sActions 	.= "<li><a href='#' class='text-red' data-trigger='endo' data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-remove'></i> End of Contract</a></li>";
					}

					$sActions 	.=       "</ul>
						               </div>
	        						";
	        		$sColor 	=	$aEmpValues['agent_status'] == "deployed" ? "text-green" : "text-red";

					$sHtml	.=	"<tr>
	        						<td class='hidden-xs hidden-sm'>".$aEmpValues['agent_empid']."</td>
	        						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'],'UTF-8'))."</td>
	        						<td class='hidden-xs hidden-sm'>".$aEmpValues['position']."</td>
	        						<td class='hidden-xs hidden-sm'>".$aEmpValues['client_name']."</td>
	        						<td class='hidden-xs hidden-sm'>".$aEmpValues['branch']."</td>
	        						<td class='hidden-xs hidden-sm'>".ucwords(mb_strtolower($aEmpValues['sup_lname'].", ".$aEmpValues['sup_fname']." ".$aEmpValues['sup_mname'] ,'UTF-8'))." (".$aEmpValues['sup_position'].")</td>
	        						<td class='".$sColor." hidden-xs hidden-sm'>".ucfirst(strtolower($aEmpValues['agent_status']))."</td>
	        						<td>".$sActions."</td>
	        					</tr>";
	            }
	        } else {
	        	$sHtml	.=	"</tr><td colspan='6'>List empty</td></tr>";
	        }
            $sHtml 			.= "</table>";
			return $sHtml;
		}

		public function GetApplicantList() {
			$aList 		=	$this->GetApplicants(array('trxid' => ''));
			$sHtml1 	=	"";
			$sHtml 		=	"<table class='table table-striped table-hover table-data' id='table-data'>
								<thead>
	            					<tr>
	            						<th>
	            						<label>
	            							<input type='checkbox'  trigger='all'>
	            						</label>
	            						</th>
	            						<th class='hidden-xs hidden-sm'>Application Date</th>
	            						<th >Applicant Name</th>
	            						<th class='hidden-xs hidden-sm'>Contact</th>
	            						<th class='hidden-xs hidden-sm'>Desired Position</th>
	            						<th class='hidden-xs hidden-sm'>Preferred Client</th>
	            						<th class='hidden-xs hidden-sm'>Work Location</th>
	            						
	            						<th class='hidden-xs hidden-sm'>Status</th>
	            						<th>Action</th>
	            					</tr>
	            				</thead>
            					";
            if (sizeof($aList) > 0 ) {

            	$nCntr = 1;
	           	foreach ($aList as $nKey => $aEmpValues) {

	        		// <li><a href='#' class='text-green' data-trigger='edit' data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-edit'></i> Edit Info</a></li>
	        		$sActions 	=	"
	        						<div class='btn-group'>
	            						<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
						                    <span class='fa fa-tasks' style='font-size: 1.2em !important;'></span>
						                    <span class='sr-only'>Toggle Dropdown</span>
						                  </a>
						                <ul class='dropdown-menu' role='menu'>
						                	<li><a href='#' class='text-green' onclick=\"_execAction('process', '".$aEmpValues['agent_trx_id']."');\" data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-gear'></i> Process</a></li>
						                	<li><a href='#' class='text-light-blue' onclick=\"_execAction('view', '".$aEmpValues['agent_trx_id']."');\" data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-search'></i> View Details</a></li>
						                ";
						                	

					if ($aEmpValues['agent_status'] == "deployed") 
					{
						$sActions 	.= "<li class='divider'></li>
										<li><a href='#' class='text-red' onclick=\"_execAction('delete', '".$aEmpValues['agent_trx_id']."');\" data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-remove'></i> End of Contract</a></li>";
					} else {
						$sActions 	.= "<li class='divider'></li>
										<li><a href='#' class='text-red' onclick=\"_execAction('remove', '".$aEmpValues['agent_trx_id']."');\" data-id='".$aEmpValues['agent_trx_id']."'><i class='fa fa-remove'></i> Remove Application</a></li>";
					}

					$sActions 	.=       "</ul>
						               </div>
	        						";
	        		$sColor 	=	"text-blue";
	        		// $sChkDis 	=	($aEmpValues['agent_standing'] != "" ? " disabled" : "");

	        		if ($aEmpValues['agent_standing'] == "") {
						$sHtml	.=	"<tr data-id='".$aEmpValues['agent_trx_id']."'>
		        						<td>
			        						<label>
		            							<input type='checkbox' value='".$aEmpValues['agent_celno']."'>
		            						</label>
		            					</td>
		        						<td class='hidden-xs hidden-sm'>".date("F d, Y", strtotime($aEmpValues['entrydate']))." </td>
		        						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'], 'UTF-8'))." </td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['agent_celno']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['position']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['client_name']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['branch']."</td>
		        						<td class='".$sColor." hidden-xs hidden-sm'>".($aEmpValues['agent_standing'] != "" ? ( !isset(APPSTAT[strtolower($aEmpValues['agent_standing'])]) ? "Unknown" : APPSTAT[strtolower($aEmpValues['agent_standing'])] ) : "New")."</td>
		        						<td>".$sActions."</td>
		        					</tr>
		        					";
		        	} else {
		        		$sHtml1	.=	"<tr data-id='".$aEmpValues['agent_trx_id']."'>
		        						<td>
			        						<label>
		            							<input type='checkbox' value='".$aEmpValues['agent_celno']."' disabled>
		            						</label>
		            					</td>
		        						<td class='hidden-xs hidden-sm'>".date("F d, Y", strtotime($aEmpValues['entrydate']))." </td>
		        						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'], 'UTF-8'))." </td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['agent_celno']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['position']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['client_name']."</td>
		        						<td class='hidden-xs hidden-sm'>".$aEmpValues['branch']."</td>
		        						<td class='".$sColor." hidden-xs hidden-sm'>".($aEmpValues['agent_standing'] != "" ? ( !isset(APPSTAT[strtolower($aEmpValues['agent_standing'])]) ? "Unknown" : APPSTAT[strtolower($aEmpValues['agent_standing'])] ) : "New")."</td>
		        						<td>".$sActions."</td>
		        					</tr>
		        					";
		        	}
	        				$nCntr++;
	            }
	        } else {
	        	$sHtml	.=	"</tr><td colspan='6'>List empty</td></tr>";
	        }
	        $sHtml 			.=	$sHtml1;
            $sHtml 			.= "</table>";
			return $sHtml;
		}

		public function GetClientInfo($aData) {

			$aClient 		=	array();
			$sSpName        =   "sp_GetClients";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();


        	if (sizeof($aResult) > 0) {
            	foreach ($aResult[0] as $sColId => $sColValue) {
            		$aClient[$this->CI->datakeys->getValue($sColId)] 	=	$sColValue;
            	}
	        }
            
            $eGetData->next_result();
            $eGetData->free_result();

            return $aClient;
		}

		public function GetClientDepts($aData) {
			

			$aDepartment	=	array();
			$sSpName        =   "sp_GetDepartments";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();


        	if (sizeof($aResult) > 0) {
            	foreach ($aResult as $sColId => $sColValue) {
            		$aDepartment[$sColValue['id']] 	=	$sColValue['dept_name'];
            	}
	        }
	        
            
            $eGetData->next_result();
            $eGetData->free_result();

            return $aDepartment;
		}

		public function createUserAccnt($aData){
			
			$sSpName        =   "sp_NewAccount";
            $eNewAccounts   =   $this->CI->hatvclib->execQueryTna($sSpName, $aData);
            $aResult        =   $eNewAccounts->result_array();

            $sResult        =   $aResult[0]['vReturn'];

            if ($sResult == -1) {
                $sObjRet['return']      = "error";
                $sObjRet['message']     = "Username Already Exists.";
                $aLogInfo['action_status'] = "user_exists";
            }
            else if ($sResult == -9) {
                $sObjRet['return']      = "system";
                $sObjRet['message']     = "";
                $aLogInfo['action_status'] = "failed";
            }
            else {
                $aLogInfo['action_status'] = "success";
                $sObjRet['return']      = "ok";
                $sObjRet['message']     = "saved";
            }

            $eNewAccounts->next_result();
            $eNewAccounts->free_result();
		}

		public function CheckInfoKey($aArrayData, $sKey) {
			return array_key_exists($sKey, $aArrayData) ? $aArrayData[$sKey] : "";
		}

		public function GetDtr($sEmpNo, $dCutOffFrom, $dCutOffTo) {


			$aShifts 	=	$this->CI->hatvclib->getDropDownsGroup(array(), 'shift');
			$aLogTypes 	=	$this->CI->hatvclib->getDropDownsGroup(array(), 'timelogs');

 			$sSpName 	=	"sp_ExecGetDtr";
			$aData 		=   array('emp_no' => $sEmpNo, 'cutofffrom' => $dCutOffFrom, 'cutoffto' => $dCutOffTo);
			$aDtr 		= 	$this->CI->hatvclib->execQueryTna($sSpName, $aData);
			$aResult    =   $aDtr->result_array();


			
			// <th>Shift Schedule</th>
			// <th>GP (mins)</th>
			// <th>Lunch (mins)</th>
			// <th>Late (mins)</th>
			// <th>Late Count</th>
			// <th>ST</th>
			// <th>OT</th>
			// <th>ND</th>

			$sReturn 	=	"<table class='table table-bordered table-striped table-hover table-dtr'>
								<tr>
									<th>Employee No.</th>
									<th>Date</th>
									<th>DOW</th>
									
									
									<th>Time In</th>
									<th>Break Out (AM)</th>
									<th>Break In (AM)</th>
									<th>Lunch Out</th>
									<th>Lunch In</th>
									<th>Break Out (PM)</th>
									<th>Break In (PM)</th>
									<th>Time Out</th>
									<th>OT In</th>
									<th>OT Out</th>
									<th>Photo</th>
								</tr>
							";
			$aDtrData 	=	array();
			if (sizeof($aResult) > 0) {
            	foreach ($aResult as $nKey => $aValue) {

            		
            		$sLogType 	=	$aLogTypes[$aValue['log_type']];

            		$aDtrData[strtoupper($aValue['emp_no'])][$aValue['log_date']][strtolower($aLogTypes[$aValue['log_type']])][] = array('log_time' => $aValue['log_time'], 'emp_no' => $aValue['emp_no'], 'log_photo' => $aValue['log_photo']);
            	}

				// return $aDtrData;
            	$nCnt 	=	0;
            	foreach ($aDtrData as $nEmpNo => $aLogData) {

            		foreach ($aLogData as $dDate => $aDetails) {
            			$dDate 		= 	date("m/d/Y", strtotime($dDate));
            			$sDow 		= 	date("D", strtotime($dDate));

            			$aTimeIn 		=	$this->getLogTime('time in', $aDetails);
	            		$aBreakOutAm 	=	$this->getLogTime('break out (am)', $aDetails);
	            		$aBreakInAm 	=	$this->getLogTime('break in (am)', $aDetails);
	            		$aLunchOut	 	=	$this->getLogTime('lunch out', $aDetails);
	            		$aLunchIn 		=	$this->getLogTime('lunch in', $aDetails);
	            		$aBreakOutPm 	=	$this->getLogTime('break out (pm)', $aDetails);
	            		$aBreakInPm 	=	$this->getLogTime('break in (pm)', $aDetails);
	            		$aTimeOut 		=	$this->getLogTime('time out', $aDetails);
	            		$aOtIn 			=	$this->getLogTime('ot in', $aDetails);
	            		$aOtOut			=	$this->getLogTime('ot out', $aDetails);

	            		$sLogInPhoto	=	$aTimeIn['log_photo'] != "" ? $aTimeIn['log_photo'] : "";
	            		$sLogOutPhoto	=	$aTimeOut['log_photo'] != "" ? $aTimeOut['log_photo'] : "";
            			$sPhoto 		=	"<i class='fa fa-image' data-src='".$sLogInPhoto."|".$sLogOutPhoto."' data-trigger='viewphoto' style=' cursor:pointer;'>";


            			
            			$sReturn 	.=	"<tr>
		            						<td style='text-align: left !important;'>".$nEmpNo."</td>
		            						<td style='text-align: left !important;'>".$dDate."</td>
		            						<td style='text-align: left !important;'>".$sDow."</td>
		            						<td>".$aTimeIn['log_time']."</td>
											<td>".$aBreakOutAm['log_time']."</td>
											<td>".$aBreakInAm['log_time']."</td>
											<td>".$aLunchOut['log_time']."</td>
											<td>".$aLunchIn['log_time']."</td>
											<td>".$aBreakOutPm['log_time']."</td>
											<td>".$aBreakInPm['log_time']."</td>
											<td>".$aTimeOut['log_time']."</td>
											<td>".$aOtIn['log_time']."</td>
											<td>".$aOtOut['log_time']."</td>
											<td style='text-align:center !important;'>".$sPhoto."</td>
										</tr>
										";
            		}
            	}
	        }

	        $sReturn 	.=	"</table>";

	        return $sReturn;
		}

		private function getLogTime($vKey, $aData) {
			
			$aReturn 	=	array();

			if ($vKey != "time out") {
				if (isset($aData[$vKey])) {
					$aReturn['emp_no']		=	$aData[$vKey][0]['emp_no'];
					$aReturn['log_time']	=	date("h:i A", strtotime($aData[$vKey][0]['log_time']));
					$aReturn['log_photo']	=	$aData[$vKey][0]['log_photo'];
				} else {
					$aReturn['emp_no']		=	"-";
					$aReturn['log_time']	=	"-";				
					$aReturn['log_photo']	=	"images/no_photo.png";
				}
			} else {
				if (isset($aData[$vKey])) {
					$aReturn['emp_no']		=	$aData[$vKey][sizeof($aData[$vKey]) - 1]['emp_no'];
					$aReturn['log_time']	=	date("h:i A", strtotime($aData[$vKey][sizeof($aData[$vKey]) - 1]['log_time']));
					$aReturn['log_photo']	=	$aData[$vKey][sizeof($aData[$vKey]) - 1]['log_photo'];
				} else {
					$aReturn['emp_no']		=	"-";
					$aReturn['log_time']	=	"-";				
					$aReturn['log_photo']	=	"images/no_photo.png";
				}
			}

			return $aReturn;
		}

		


		public function getClientsList($aData) {

			$sSpName        =   "sp_GetClients";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();
            
            $sHtml 			=	"<table class='table table-striped table-hover table-data'>
            					</tr>
            						
            						<th>Client Name</th>
            						<th class='hidden-xs hidden-sm'>Telephone</th>
            						<th class='hidden-xs hidden-sm'>Contract Period</th>
            						<th class='hidden-xs hidden-sm'>Employee No.</th>
            						<th>Action</th>
            					</tr>
            					";

            if (sizeof($aResult) > 0) {
            	foreach ($aResult as $nKey => $aClientValues) {

            		// <li><a href="#" class="text-light-blue"><i class="fa fa-search"></i> View Details</a></li>
            		$sActions 	=	"
            						<div class='btn-group'>
	            						<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
						                    <span class='fa fa-tasks' style='font-size: 1.2em !important;'></span>
						                    <span class='sr-only'>Toggle Dropdown</span>
						                  </a>
						                <ul class='dropdown-menu' role='menu'>
						                	
						                	<li><a href='#' class='text-green' data-trigger='edit' data-id='".$aClientValues['client_id']."'><i class='fa fa-edit'></i> Edit Info</a></li>
						                    
						                    <li class='divider'></li>
						                    <li><a href='#' class='text-red' data-trigger='delete' data-id='".$aClientValues['client_id']."'><i class='fa fa-remove'></i> Remove</a></li>
						                </ul>
						               </div>
            						";


					$sHtml	.=	"</tr>
            						<td>".ucwords(strtolower($aClientValues['client_name']))."</td>
            						<td class='hidden-xs hidden-sm'>".$aClientValues['client_telno']."</td>
            						<td class='hidden-xs hidden-sm'>".date("d-M-Y",strtotime($aClientValues['client_period_from']))." to ".date("d-M-Y",strtotime($aClientValues['client_period_to']))."</td>
            						<td class='hidden-xs hidden-sm'>1</td>
            						<td align='left'>".$sActions."</td>
            					</tr>
            					";
            	}
	        } else {
	        	$sHtml	.=	"</tr><td colspan='7'>List empty</td></tr>";
	        }

	        $sHtml	.= "</table>";

            $eGetData->next_result();
            $eGetData->free_result();

            return $sHtml;
		}

		public function getClientBranch($aData, $sSelected, $nDataKey) {
	    	$CI =& get_instance();


	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->CI->hatvclib->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= 	$eDropdowns->result();

	        if (sizeof($aDropdowns) > 0) {
		        foreach ($aDropdowns as $nKey => $aValue) {
		        	$aDropList[$aValue->dropdown_type][] = array('id' => $aValue->id, 'value' => $aValue->dropdown_value, 'drpkey' => $aValue->dropdown_key);
		        }
		    }

		    if (sizeof($aDropList) > 0) {
		        foreach (DROPTYPES as $nKey => $sType) {
		        	
		        	if (isset($aDropList[$sType])) {
		        			$sHtml  		=	"<select class='input-sm form-control' data='req' data-key='".ucfirst(strtolower($sType))."Id'>";
	            			$sHtml  		.=	"<option value=''></option>";
			        	foreach ($aDropList[$sType] as $vKey => $aValue) {

			        		$sSel =	$sSelected == $aValue['id'] ? " selected" : "";

			        		$sValue 	= 	addslashes(ucwords(strtolower($aValue['value'])));

			        		if ($aValue['drpkey'] == $nDataKey) {
			        		
			        			$sHtml  		.=	"<option value='".$aValue['id']."' ".$sSel.">".ucwords(strtolower($sValue))."</option>";
			        		}
			        	}
			        	$sHtml 	.=	"</select>";


			        } else {

	        			$sHtml  =	"<select class='input-sm form-control' data='req' data-key='".ucfirst(strtolower($sType))."Id'>";
            			$sHtml  .=	"<option value=''></option>";
            			$sHtml 	.=	"</select>";
			        }
			        $aDropReturn[$sType] = $sHtml;
		        }
		    } else {
		    	foreach (DROPTYPES as $nKey => $sType) {
		        	$sHtml  =	"<select class='input-sm form-control' data='req' data-key='".ucfirst(strtolower($sType))."Id'></select>";
		        	$aDropReturn[$sType] = $sHtml;
		    	}
		    }
		    

	        $eDropdowns->next_result();
			$eDropdowns->free_result();

	        return $aDropReturn;
	    }

	    public function getClientDeptsDd($aData, $sSelected, $nDataKey) {
	    	
	    	$CI =& get_instance();

	    	$aClientInfo    =   $this->GetClientInfo(array('clientid' => $aData));
	        $aDepartments 	= 	$this->GetClientDepts(array('clientid' => $aClientInfo['ClientId']));

	        // return $aDepartments;
	        

		    if (sizeof($aDepartments) > 0) {
		        $sHtml  =	"<select class='input-sm form-control' data='req' data-key='DeptId'>";
		        $sHtml  		.=	"<option value=''></option>";
	        	foreach ($aDepartments as $vKey => $sVal) {

	        		$sSel =	$sSelected == $vKey ? " selected" : "";

	        		$sValue 	= 	addslashes(ucwords(strtolower($sVal)));

	        		
	        		
	        			$sHtml  .=	"<option value='".$vKey."' ".$sSel.">".ucwords(strtolower($sValue))."</option>";
	        		
	        	}

	        	$sHtml 	.=	"</select>";


		    } else {
		    	
		        	$sHtml  =	"<select class='input-sm form-control' data='req' data-key='DeptId'></select>";
		    }
		    

	        return $sHtml;
	    }

		public function getSuppList($aData) {

			$sSpName        =   "sp_GetSupervisors";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();
            
            $sHtml 			=	"<table class='table table-striped table-hover table-data'>
            					</tr>
            						<th>Representative</th>
            						<th class='hidden-xs hidden-sm'>Position</th>
            						<th class='hidden-xs hidden-sm'>Client</th>
            						<th class='hidden-xs hidden-sm'>Branch</th>
            						<th class='hidden-xs hidden-sm'>Department</th>
            						<th>Action</th>
            					</tr>
            					";

            if (!isset($aResult[0]['vFlag'])) {
	            if (sizeof($aResult) > 0) {
	            	foreach ($aResult as $nKey => $aSupValues) {

	            		// <li><a href='#' class='text-light-blue'><i class='fa fa-search'></i> View Details</a></li>
	            		$sActions 	=	"
	            						<div class='btn-group'>
		            						<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
							                    <span class='fa fa-tasks' style='font-size: 1.2em !important;'></span>
							                    <span class='sr-only'>Toggle Dropdown</span>
							                  </a>
							                <ul class='dropdown-menu' role='menu'>
							                	
							                	<li><a href='#' class='text-green' data-trigger='edit' data-id='".$aSupValues['id']."'><i class='fa fa-edit'></i> Edit Info</a></li>
							                    
							                    <li class='divider'></li>
							                    <li><a href='#' class='text-red' data-trigger='delete' data-id='".$aSupValues['id']."'><i class='fa fa-remove'></i> Remove</a></li>
							                </ul>
							               </div>
	            						";


						$sHtml	.=	"</tr>
	            						<td>".$aSupValues['sup_lname'].", ".$aSupValues['sup_fname']." ".$aSupValues['sup_mname']."</td>
	            						<td class='hidden-xs hidden-sm'>".ucwords(strtolower($aSupValues['position']))."</td>
	            						<td class='hidden-xs hidden-sm'>".ucwords(strtolower($aSupValues['client_name']))."</td>
	            						
	            						<td class='hidden-xs hidden-sm'>".$aSupValues['branch']."</td>	
	            						<td class='hidden-xs hidden-sm'>".ucwords(strtolower($aSupValues['dept_name']))."</td>
	            						<td align='left'>".$sActions."</td>
	            					</tr>
	            					";
	            	}
		        } else {
		        	$sHtml	.=	"</tr><td colspan='5'>List empty</td></tr>";
		        }
		    } else {
		    	$sHtml	.=	"</tr><td colspan='5'>List empty</td></tr>";
		    }

	        $sHtml	.= "</table>";

            $eGetData->next_result();
            $eGetData->free_result();

            return $sHtml;
		}


		public function getClientsDd($aData, $sSelected) {

			$sSpName        =   "sp_GetClients";

            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();            

            $sHtml  		=	"<select class='input-sm form-control' data='req' data-key='ClientId'>";
            $sHtml  		.=	"<option value=''></option>";
            if (!isset($aResult[0]['vFlag'])) {
	             if (sizeof($aResult) > 0) {
	            	foreach ($aResult as $nKey => $aClientValues) {
	            		$sSel =	$aClientValues['client_id'] == $sSelected ? " selected" : "";

	            		$sHtml  		.=	"<option value='".$aClientValues['client_id']."' ".$sSel.">".ucwords(strtolower($aClientValues['client_name']))."</option>";
	            	}
	            } 
	        }
            $sHtml  		.=	"</select>";

            $eGetData->next_result();
            $eGetData->free_result();

            return $sHtml;
		}



		public function getSuppListDd($aData) {

			$sSpName        =   "sp_GetSupervisors";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();

            $sHtml  		=	"<select class='input-sm form-control' data='req' data-key='SupId'>";
            $sHtml  		.=	"<option value=''></option>";
            if (!isset($aResult[0]['vFlag'])) {
	             if (sizeof($aResult) > 0) {
	            	foreach ($aResult as $nKey => $aSupValues) {
	            		$sHtml  		.=	"<option value='".$aSupValues['id']."'>".ucwords(strtolower($aSupValues['sup_fname']." ".$aSupValues['sup_mname']." ".$aSupValues['sup_lname']))."</option>";

	            	}
	            } 
	        }
            $sHtml  		.=	"</select>";

            $eGetData->next_result();
            $eGetData->free_result();

            return $sHtml;
		}


		public function getBranchSup($aData) {
			
			$aReturn 		=	array(); 	
			$sSpName        =   "sp_GetBranchSup";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();

            $sHtml  		=	"<option value=''></option>";
            if (!isset($aResult[0]['vFlag'])) {
	             if (sizeof($aResult) > 0) {
	            	foreach ($aResult as $nKey => $aSupValues) {
	            		$sHtml  		.=	"<option value='".$aSupValues['id']."'>".ucwords(strtolower($aSupValues['sup_fname']." ".$aSupValues['sup_mname']." ".$aSupValues['sup_lname']))."</option>";

	            	}
	            } 
	            $aReturn['return']	=	"ok";
            	$aReturn['message']	=	$sHtml;
	        } else {
	        	$aReturn['return']	=	$sHtml;
            	$aReturn['message']	=	'error';
	        }


            $eGetData->next_result();
            $eGetData->free_result();

            return $aReturn;
		}
		

		public function getClientsRequests($aData) {

			$aReturn 		=	array(); 	
			$sSpName        =   "sp_GetClientRequests";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,$aData);
            $aResult        =   $eGetData->result_array();

            $this->CI->hatvclib->ConnClose($eGetData);

            return $aResult;
		}

		public function procClientRequest($aData) {

			$aReturn 		=	array(); 	
			$aRequestList 	=	$this->getClientsRequests($aData);


            return $aRequestList;
		}

		public function getClientsRequestsList($aData) {

			$nCntr 	= 1;
			$aRequestList =	$this->getClientsRequests($aData);

			$sHtml 			=	"<table class='table table-striped table-hover table-data' id='table-data'>
								<thead>
            					<tr>
            						<th>#</th>
            						<th>Client Name</th>
            						<th class='hidden-xs hidden-sm'>Branch</th>
            						<th class='hidden-xs hidden-sm'>Requested Date</th>
            						<th class='hidden-xs hidden-sm'>Requested Position</th>
            						<th class='hidden-xs hidden-sm'>Manpower</th>
            						<th class='hidden-xs hidden-sm'>Scheduled Interview</th>
            						<th class='hidden-xs hidden-sm'>Requested By</th>
            						<th class='hidden-xs hidden-sm'>Status</th>
            						<th>Action</th>
            					</tr>
            					</thead>
            					";
            if (sizeof($aRequestList) > 0) {
            	foreach ($aRequestList as $nKey => $aReqData) {

            		$sActions 	=	"
            						<div class='btn-group'>
	            						<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
						                    <span class='fa fa-tasks' style='font-size: 1.2em !important;'></span>
						                    <span class='sr-only'>Toggle Dropdown</span>
						                  </a>
						                <ul class='dropdown-menu' role='menu'>";

	  			if ($aReqData['request_status'] != "approved" && $aReqData['request_status'] != "close") {
					$sActions 	.=	"
										<li><a href='#' class='text-yellow' onclick=\"_execAction('edit', '".$aReqData['reqid']."', $(this).closest('tr'));\"'><i class='fa fa-edit'></i> Edit </a></li>
									";
				}
          
				$sActions 	.=	"				<li><a href='#' class='text-blue' onclick=\"_execAction('process', '".$aReqData['reqid']."', $(this).closest('tr'));\"'><i class='fa fa-gear'></i> Process </a></li>
												<li><a href='#' class='text-green' onclick=\"_execAction('close', '".$aReqData['reqid']."', $(this).closest('tr'));\"'><i class='fa  fa-check-circle'></i> Close </a></li>
												<li class='divider'></li>
							            		<li><a href='#' class='text-red' onclick=\"_execAction('delete', '".$aReqData['reqid']."', $(this).closest('tr'));\"'><i class='fa fa-remove'></i> Cancel</a></li>
						          			</ul>
						               </div>
            						";

            		$sStatus 	=	strtolower($aReqData['request_status']) == "approved" ? "For Interview" : ucwords(strtolower($aReqData['request_status']));
					$sHtml	.=	"<tr>
									<td>".$nCntr."</td>	
            						<td>".$aReqData['client_name']."</td>
            						<td class='hidden-xs hidden-sm'>".$aReqData['branch']."</td>
            						<td class='hidden-xs hidden-sm'>".date("F d, Y", strtotime($aReqData['entrydate']))."</td>
            						<td class='hidden-xs hidden-sm'>".$this->CI->hatvclib->getPositionLine(array(), json_decode($aReqData['request_positions']))."</td>
            						<td class='hidden-xs hidden-sm'>".$aReqData['request_man_power']."</td>	
            						<td class='hidden-xs hidden-sm'>".date("F d, Y", strtotime($aReqData['request_interview_date']))." " .$aReqData['request_interview_time']. "</td>
            						<td class='hidden-xs hidden-sm'>".$aReqData['request_by']."</td>	
            						<td class='hidden-xs hidden-sm'>".$sStatus."</td>	
            						<td align='left'>".$sActions."</td>
            					</tr>
            					";
            		$nCntr++;
            	}

            } else {
		        	$sHtml	.=	"</tr><td colspan='8'>List empty</td></tr>";
		    }

	        $sHtml	.= "</table>";

            return $sHtml;
		}


		public function getCandidates($aRequestInfo) {
			
			$sWhere 		=	"";
			$aPosition 		=	$this->CI->hatvclib->JsonToArray(json_decode($aRequestInfo['request_positions']));
			$aQualifications=	$this->CI->hatvclib->JsonToArray(json_decode($aRequestInfo['request_qualifications']));
			$aCandidates	=	$this->CI->hatvclib->JsonToArray(json_decode($aRequestInfo['request_candidates']));
			$aChosen		=	$this->CI->hatvclib->JsonToArray(json_decode($aRequestInfo['request_candidates_chosen']));


			// return $aCandidates;

			// if($aRequestInfo['request_status'] == "pending" || $aRequestInfo['request_status'] == "new")
			// {
			// 	$sDisable 		=	"";
			// } else {
			// 	$sDisable 		=	" disabled";
			// }

			// if (in_array('m', $aQualifications) && in_array('f', $aQualifications)) {
			// 	$sWhere .= " AND (emp.agent_gender = 'm' OR emp.agent_gender = 'f')";
			// }
			// else {
			// 	if (in_array('m', $aQualifications)) {
			// 		$sWhere .= " AND emp.agent_gender = 'm'";
			// 	}

			// 	if (in_array('f', $aQualifications)) {
			// 		$sWhere .= " AND emp.agent_gender = 'm'";
			// 	}	
			// }			

			$sSpName        =   "sp_GetCandidates";
            $eExecQuery     =   $this->CI->hatvclib->execQuery($sSpName, array());
            $aResult        =   $eExecQuery->result_array();


            $eExecQuery->next_result();
            $eExecQuery->free_result();

            $nCandidCntr 	= 1;
            $nApplicCntr 	= 1;

			$sCandidates	=	"<table class='table table-striped table-hover table-data'>
	            					<tr>
	            						<th>Candidate Name</th>
	            						<th>Status</th>
	            						<th>Desired Position</th>
	            						<th>Desired Branch</th>
	            						<th></th>
	            					</tr>
            					";

            $sChosen		=	"<table class='table table-striped table-hover table-data'>
	            					<tr>
	            						<th>Candidate Name</th>
	            						<th>Status</th>
	            						<th>Desired Position</th>
	            						<th>Desired Branch</th>
	            						<th></th>
	            					</tr>
            					";

            $sApplicants	=	"<table class='table table-striped table-hover table-data'>
	            					<tr>
	            						<th>Applicant Name</th>
	            						<th>Status</th>
	            						<th>Desired Position</th>
	            						<th>Desired Branch</th>
	            						<th></th>
	            					</tr>
            					";
           	$sCandidAction 	=	"<a class='btn-remove text-red ' href='javascript:void(0);' title='Remove'><i class='fa fa-remove'></i></a>";
           	$sApplicAction 	=	"<a class='btn-add text-red ' href='javascript:void(0);' title='Add'><i class='fa fa-plus'></i></a>";

            if (sizeof($aResult) > 0) {
            	foreach ($aResult as $key => $aEmpValues) {

            		if ( in_array($aEmpValues['agent_trx_id'], $aCandidates)) {

	            		$sCandidates 	.=	"<tr data-trxid = '".$aEmpValues['agent_trx_id']."' data-celno = '".$aEmpValues['agent_celno']."'>
		            						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'], 'UTF-8'))."</td>
		            						<td>".($aEmpValues['agent_standing'] != "" ? ( !isset(APPSTAT[strtolower($aEmpValues['agent_standing'])]) ? "Unknown" : APPSTAT[strtolower($aEmpValues['agent_standing'])] ) : "New")." </td>
		            						<td>".$aEmpValues['position']."</td>
		            						<td>".$aEmpValues['branch']."</td>
		            						<td>";
    					// if ($aRequestInfo['request_status'] != "approved") 
    					// {
    						$sCandidates .= $sCandidAction;
    					// }	 else {
    					// 	$sCandidates .= "";
    					// }
		            	$sCandidates 	.=	"</td>
		            					</tr>";
	            		$nCandidCntr++;
	            	} else if (in_array($aEmpValues['agent_trx_id'], $aChosen)) {
	            		$sChosen 	.=	"<tr data-trxid = '".$aEmpValues['agent_trx_id']."' data-celno = '".$aEmpValues['agent_celno']."'>
			            						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'], 'UTF-8'))."</td>
			            						<td>".($aEmpValues['agent_standing'] != "" ? ( !isset(APPSTAT[strtolower($aEmpValues['agent_standing'])]) ? "Unknown" : APPSTAT[strtolower($aEmpValues['agent_standing'])] ) : "New")." </td>
			            						<td>".$aEmpValues['position']."</td>
			            						<td>".$aEmpValues['branch']."</td>
			            						<td><a href='applicantinfo?".$aEmpValues['agent_trx_id']."'>Process</a></td>
			            					</tr>";

	            	} else {

	            		if (in_array($aEmpValues['position_id'], $aPosition) && $aEmpValues['branch_id'] == $aRequestInfo['branch_id'])
	            		{
		            		$sApplicants 	.=	"<tr data-trxid = '".$aEmpValues['agent_trx_id']."'>
				            						<td>".ucwords(mb_strtolower($aEmpValues['agent_lname'].", ".$aEmpValues['agent_fname']." ".$aEmpValues['agent_mname'], 'UTF-8'))."</td>
				            						<td>".($aEmpValues['agent_standing'] != "" ? ( !isset(APPSTAT[strtolower($aEmpValues['agent_standing'])]) ? "Unknown" : APPSTAT[strtolower($aEmpValues['agent_standing'])] ) : "New")." </td>
				            						<td>".$aEmpValues['position']."</td>
				            						<td>".$aEmpValues['branch']."</td>
				            						<td>
				            							".$sApplicAction."
				            						</td>
				            						
				            					</tr>";
				            $nApplicCntr++;
				        }
	            	}
            	}
            }

            $sCandidates 			.= "</table>";
            $sApplicants 			.= "</table>";
			return array('candidates' => $sCandidates, 'applicants' => $sApplicants, 'chosen' => $sChosen);
		}


		public function GetAppDetails($aData) {

			$aAppInfo =	$this->GetApplicants($aData);

			$sCandidates	=	"";
			$nCandidCntr 	=	1;

            if (sizeof($aAppInfo) > 0) 
            {
            	foreach ($aAppInfo as $key => $aEmpValues) { 		
            		$sPhoto 		=	str_replace("_photo", "_Photo", $aEmpValues['part_photo']);
            		$sCandidates	.=	"
							              	<div class='row invoice-info'>
								              	<div class='col-sm-3' style='text-align: center;'>
								              		<div style='background-image: url(".$sPhoto."); background-size: cover; background-repeat: no-repeat; height: 200px; width: 200px; position: relative;'></div>
								              	</div>
					                            <div class='col-sm-3 invoice-col'>
					                              	Full Name
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_lname'].', '.$aEmpValues['agent_fname'].' '.$aEmpValues['agent_mname'])) ."
					                                	</strong>
					                              	</address>

					                              	Birthday
					                              	<address>
					                                	<strong>
					                                		".date('F, d Y', strtotime($aEmpValues['agent_bday']))."
					                                	</strong>
					                              	</address>

					                              	Civil Status
					                              	<address>
					                              		<strong>
					                              			".CIVILSTATS[$aEmpValues['agent_civil_status']]."
					                              		</strong>
					                              	</address>

					                              	Nationality
					                              	<address>
					                                	<strong>
					                                		".ucwords($aEmpValues['agent_citizenship'])."
					                                	</strong>
					                              	</address>

					                              	
					                            </div>

					                            <div class='col-sm-3 invoice-col'>
					                            	Height
					                              	<address>
					                                	<strong>
					                                		".$aEmpValues['agent_ht_ft']."'".$aEmpValues['agent_ht_in']."
					                                	</strong>
					                              	</address>

					                              	Weight
					                              	<address>
					                                	<strong>
					                                		".$aEmpValues['agent_weight']." lbs.
					                                	</strong>
					                              	</address>

					                              	Religion
					                              	<address>
					                                	<strong>
					                                		".$aEmpValues['religion']."
					                                	</strong>
					                              	</address>

					                              	Facebook Link.
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_facebook']))."
					                                	</strong>
					                              	</address>
					                            </div>

					                            <div class='col-sm-3 invoice-col'>

					                            	SSS No.
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_sssno']))."
					                                	</strong>
					                              	</address>

					                              	TIN No.
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_tinno']))."
					                                	</strong>
					                              	</address>

					                              	PhilHealth No.
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_philhealthno']))."
					                                		
					                                	</strong>
					                              	</address>

					                              	Pag-ibig No.
					                              	<address>
					                                	<strong>
					                                		".ucwords(strtolower($aEmpValues['agent_pagibigno']))."
					                                	</strong>
					                              	</address>
					                              	
					                            </div>

		            					";
	            }

	            $aDetails       =   $this->GetAgentDetails($aData['AgentTrxId']);

                $sCandidates       .=   "
                                    <div class='row'>
                                        <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-bottom: 10px;'> <h4><i class='fa fa-graduation-cap'></i> Educational Attainment </h4> </div>
                                    </div>
                                    <div class='row invoice-info divTitles'>
                                        <div class='col-sm-2 '> Level </div>
                                        <div class='col-sm-4 '> School Name </div>
                                        <div class='col-sm-3 '> Course </div>
                                        <div class='col-sm-3 '> Duration </div>
                                    </div>";

                foreach ($aDetails['educ'] as $key => $aValue) {
                    $sCandidates     .=   "<div class='row invoice-info'>
                                            <div class='col-sm-2'> <strong>".EDUCTYPE[$aValue['educ_type']]."</strong> </div>
                                            <div class='col-sm-4 '><strong>".ucwords($aValue['educ_school'])."</strong> </div>
                                            <div class='col-sm-3 '><strong>".ucwords($aValue['educ_course'])."</strong> </div>
                                            <div class='col-sm-3 '><strong>".$aValue['educ_year_start']." - ".$aValue['educ_year_end']."</strong> </div>
                                        </div>";
                }

                $sCandidates .=    "<div class='row'>
                                    <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-top: 10px;' ></div>
                                </div>";

                $sCandidates     .=   "
                                    <div class='row'>
                                        <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-bottom: 10px;'> <h4><i class='fa fa-gear'></i> Skills</h4> </div>
                                    </div>
                                    <div class='row invoice-info divTitles'>
                                        <div class='col-sm-2 '> Skill </div>
                                        <div class='col-sm-7 '> Description </div>
                                        <div class='col-sm-3 '> Level </div>
                                    </div>";

                foreach ($aDetails['skills'] as $key => $aValue) {
                    $sCandidates     .=   "<div class='row invoice-info'>
                                            <div class='col-sm-2 '> <strong>".ucwords($aValue['skills'])."</strong>  </div>
                                            <div class='col-sm-7 '> <strong>".ucwords($aValue['skills_description'])." </strong> </div>
                                            <div class='col-sm-3 '> <strong>".SKILLLEVEL[$aValue['skills_level']]." </strong> </div>
                                        </div>";
                }

                $sCandidates .=    "<div class='row'>
                                    <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-top: 10px;'></div>
                                </div>";

                $sCandidates     .=   "
                                    <div class='row'>
                                        <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-bottom: 10px;'><h4><i class='fa fa-gear'></i> Trainings</h4> </div>
                                    </div>
                                    <div class='row invoice-info divTitles'>
                                        <div class='col-sm-2 '> Title </div>
                                        <div class='col-sm-7 '> Description </div>
                                    </div>";

                foreach ($aDetails['trains'] as $key => $aValue) {
                    $sCandidates     .=   "<div class='row invoice-info'>
                                            <div class='col-sm-2 '> <strong>".ucwords($aValue['training_title'])."</strong>  </div>
                                            <div class='col-sm-7 '> <strong>".ucwords($aValue['training_description'])." </strong> </div>
                                        </div>";
                }

                $sCandidates .=    "<div class='row'>
                                    <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-top: 10px;'></div>
                                </div>";

                $sCandidates     .=   "
                                    <div class='row'>
                                        <div class='col-md-12' style='border-bottom: 1px solid #e5e5e5; margin-bottom: 10px;'> <h4><i class='fa fa-institution'></i> Employment History</h4> </div>
                                    </div>
                                    <div class='row invoice-info divTitles'>
                                        <div class='col-sm-2 '> Position </div>
                                        <div class='col-sm-2 '> Company </div>
                                        <div class='col-sm-3 '> Reason of Leaving </div>
                                        <div class='col-sm-3 '> Duties and Responsibilities </div>
                                        <div class='col-sm-2 '> Duration </div>
                                    </div>";

                foreach ($aDetails['employ'] as $key => $aValue) {
                    $sCandidates     .=   "<div class='row invoice-info'>
                                            <div class='col-sm-2 '> <strong>".ucwords($aValue['job_position'])."</strong>  </div>
                                            <div class='col-sm-2 '> <strong>".ucwords($aValue['job_employer'])." </strong> </div>
                                            <div class='col-sm-3 '> <strong>".$aValue['job_reason']." </strong> </div>
                                            <div class='col-sm-3 '> <strong>".$aValue['job_duties']." </strong> </div>
                                            <div class='col-sm-2 '> <strong>".$aValue['job_started']." - ".$aValue['job_ended']." </strong> </div>
                                        </div>";
                }
	        }

	        return $sCandidates;
		}

		public function genEmpId($dHiredDate) {

			$nPrefix 	=	date("Ym", strtotime($dHiredDate));

			$aReturn 		=	array(); 	
			$sSpName        =   "sp_GenerateEmpId";
            $eGetData       =   $this->CI->hatvclib->execQuery($sSpName,array($nPrefix));
            $aResult        =   $eGetData->result_array();

            $this->CI->hatvclib->ConnClose($eGetData);

            return $nPrefix."-".str_pad(($aResult[0]['MaxId'] + 1), 2, '0', STR_PAD_LEFT);
		}

	}

?>
