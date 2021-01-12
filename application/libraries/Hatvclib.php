<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    include('/phpmailer/class.phpmailer.php');

   class Hatvclib {
   		protected $encryptMethod = 'AES-256-CBC';

   		public function __construct()
	    {
	        require_once APPPATH.'third_party/phpmailer/class.phpmailer.php';
	    }

   		/* Put Page chosen session so it will be set */
	  	public function setPage($sData) {

	  		$CI =& get_instance();

	  		$CI->session->set_userdata('currpage', $sData);

	  		return $sData;
	  	}

	  	public function logActivity($sModule, $aPrevStatus, $aNewStatus, $aLogInfo) {
	  		$CI =& get_instance();

        	$objPrevStatus 	=	json_encode($aPrevStatus);
	    	$objNewStatus 	=	json_encode($aNewStatus);
	    	$objLogInfo 	=	json_encode($aLogInfo);

	    	$aData =    array(
							'app_id' 		=> "APP-001",
							'user_id' 		=> "kugkug",
							'useragent' 	=> addslashes($_SERVER['HTTP_USER_AGENT']),
							'remote_addr' 	=> addslashes($_SERVER['REMOTE_ADDR']),
							'host_name' 	=> addslashes(gethostbyaddr($_SERVER['REMOTE_ADDR'])),
							'operating_system'	=>	$this->getOS($_SERVER['HTTP_USER_AGENT']),
							'module' 		=>  $sModule,
							'prevstatus' 	=> $objPrevStatus,
							'newstatus' 	=> $objNewStatus,
							'log_info' 		=> $objLogInfo
						);

	    	// $oActivityLogSP =	"CALL sp_AddActivityLogs(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	    	// $eInsert 		= 	$CI->db->query($oActivityLogSP, $aData);
        // $eInsert->next_result();
        // $eInsert->free_result();
        //
	    	// return $eInsert;

	  	}

	  	

	  	public function createQuery($sAction, $aArrData, $sType)
	  	{	
	  		$CI =& get_instance();
	  		$aReturn 			=	array();

	  		switch ($sAction) {
	  			
	  			case 'save':
	  					$aReturn['act'] = 	"save";
	  					$aReturn['typ']	=	$sType;
	  					$sCols 	=	"";
	  					$sVals 	=	"";

	  					foreach ($aArrData as $sColName => $sValue) {
	  						$sCols 	.=	$CI->datakeys->getKey($sColName).",";
	  						$sVals	.=	"'".addslashes($sValue)."',";
	  					}

	  					$aReturn['cols']	=	"(".substr($sCols, 0, -1).")";
	  					$aReturn['vals']	=	"(".substr($sVals, 0, -1).")";

	  				break;
	  			
	  			case 'savebatch':
	  					$aReturn['act'] = "save";
	  					$aReturn['typ']	= $sType;
	  					$sCols 	=	"";
	  					$sVals 	=	"";

	  					foreach ($aArrData as $nKey => $aData) {

	  						if ($nKey === 0) {
	  							$sCols 	.=	$CI->datakeys->getKey('AgentTrxId').",";
	  							foreach ($aData as $sColName => $sValue) {
	  								
	  								$sCols 	.=	$CI->datakeys->getKey($sColName).",";
	  							}

	  							$aReturn['cols']	=	"(".substr($sCols, 0, -1).")";
	  						}
	  					}

	  					
						foreach ($aArrData as $nKey => $aData) {

							$sSubVal 	=	"";
							if ($nKey !== "AgentTrxId") {
								$sSubVal 	.=	"'".$aArrData['AgentTrxId']."',";

	  							foreach ($aData as $sColName => $sValue) {

	  								if ($sColName == "EducFile" || $sColName == "SkillFile" || $sColName == "TrainFile" || $sColName == "JobFile" || $sColName == "MedFile" ) {
	  									$sSubVal 	.=	"'".base_url().'attachments/'.$sValue."',";
	  								} else {
	  									$sSubVal 	.=	"'".addslashes(mb_strtolower($sValue, 'UTF-8'))."',";	
	  								}
	  								
		  						}
		  						$sVals 	.=	"(".substr($sSubVal, 0, -1)."),";

		  						
		  					}	  						
	  					}
	  						  					
	  					$aReturn['vals']	=	substr($sVals, 0, -1);

	  				break;
	  			case 'updatehealth':
	  			case 'update':

	  					
	  					$aReturn['act'] = "update";
	  					$aReturn['typ']	= $sType;
	  					$sCols 	=	"";
	  					$sVals 	=	"";

	  					foreach ($aArrData as $sColName => $sValue) {

	  						if ($sColName == "where") {
	  							foreach ($sValue as $sWhereKey => $sWhereVal) {
	  								$sCols 	.=	$CI->datakeys->getKey($sWhereKey)." = '".addslashes($sWhereVal)."' AND";
	  							}
	  							
	  						} else {
	  							$sVals	.=	$CI->datakeys->getKey($sColName)." = '".addslashes($sValue)."',";	
	  						}

	  					}

	  					$aReturn['data']	=	substr($sVals, 0, -1);
	  					$aReturn['wher']	=	trim(substr($sCols, 0, -3));

	  				break;
	  			case 'delete':

	  					
	  					$aReturn['act'] = "delete";
	  					$aReturn['typ']	= $sType;
	  					$sCols 	=	"";
	  					$sVals 	=	"";

	  					foreach ($aArrData as $sColName => $sValue) {
	  						if ($sColName == "where") {
	  							foreach ($sValue as $sWhereKey => $sWhereVal) {
	  								$sCols 	.=	$CI->datakeys->getKey($sWhereKey)." = '".$sWhereVal."' AND";
	  							}
	  						} else {
	  							$sVals	.=	$CI->datakeys->getKey($sColName)." = '".$sValue."',";	
	  						}
	  					}

	  					$aReturn['data']	=	substr($sVals, 0, -1);
	  					$aReturn['wher']	=	trim(substr($sCols, 0, -3));

	  				break;

	  			case 'single_delete':
	  				  					
	  					$aReturn['act'] = "single_delete";
	  					$aReturn['typ']	= $sType;
	  					$sCols 	=	"";
	  					$sVals 	=	"";

	  					foreach ($aArrData as $sColName => $sValue) {
	  						$sCols 	.=	$sColName." = '".$sValue."' AND";
	  					}

	  					$aReturn['data']	=	'';
	  					$aReturn['wher']	=	trim(substr($sCols, 0, -3));

	  				break;


	  			default:
	  				# code...
	  				break;
	  		}

	  		return $aReturn;
	  	}

	  	

	  	public function execQuery($sSpName, $aArrData)
	  	{
	  		$CI =& get_instance();

	  		$dbHris 	=	$CI->load->database('default', TRUE);

	  		$n 			=	0;
	  		$sSpData 	=	"(";
	  		$qQueryData	=	"";
	  		$vResult 	=	"";

	  		if (sizeof($aArrData) > 0)
	  		{
	  			foreach ($aArrData as $key => $value) { if ($n < sizeof($aArrData)) { $sSpData .= "?,"; $n++; } }

	  			$sSpData	= 	substr($sSpData, 0, strlen($qQueryData) -1);
	  			$sSpData 	.=	")";

	  			$qQueryData =	"CALL ".$sSpName."".$sSpData; //die(json_encode($qQueryData));
	  		}
	  		else
	  		{
	  			$qQueryData =	"CALL ".$sSpName."()"; //die(json_encode($qQueryData));
	  		}
	  		
	  		// $eQueryData	=	$CI->db->query($qQueryData, $aArrData);
	  		$eQueryData	=	$dbHris->query($qQueryData, $aArrData);
	  		
	  		
	  		$vReturn 	=	$eQueryData;

	  		return $vReturn;
	  	}

	  	public function execQueryTna($sSpName, $aArrData)
	  	{
	  		$CI =& get_instance();

	  		$dbTna 	=	$CI->load->database('swtna', TRUE);

	  		$n 			=	0;
	  		$sSpData 	=	"(";
	  		$qQueryData	=	"";
	  		$vResult 	=	"";

	  		if (sizeof($aArrData) > 0)
	  		{
	  			foreach ($aArrData as $key => $value) { if ($n < sizeof($aArrData)) { $sSpData .= "?,"; $n++; } }

	  			$sSpData	= 	substr($sSpData, 0, strlen($qQueryData) -1);
	  			$sSpData 	.=	")";

	  			$qQueryData =	"CALL ".$sSpName."".$sSpData; //die(json_encode($qQueryData));
	  		}
	  		else
	  		{
	  			$qQueryData =	"CALL ".$sSpName."()"; //die(json_encode($qQueryData));
	  		}
	  		
	  		$eQueryData	=	$dbTna->query($qQueryData, $aArrData);
	  		
	  		$vReturn 	=	$eQueryData;

	  		return $vReturn;
	  	}

	  	public function ConnClose($eQuery) {
	  		
	  		$CI =& get_instance();
	  		// $eQuery->next_result();
            $eQuery->free_result();
            // $CI->db->close();
	  	}

	  	public function returnData($sCode, $sMsgs, $sData)
	  	{
	  		return json_encode(array("return" => $sCode, "message" => $sMsgs, "data" => $sData));
	  	}

	  	public function getKeyCode()
	  	{
	  		$vCurl	=	curl_init("http://185.160.182.17/key_api/api_key_generator.php");

			curl_setopt($vCurl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($vCurl, CURLOPT_POST, TRUE);
			curl_setopt($vCurl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($vCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($vCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($vCurl, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($vCurl, CURLOPT_HTTPHEADER,
							array
							(
								'Content-Type : application/json',
								'Accept : application/json'
							)
						);
			$result	=	curl_exec($vCurl);

			return $result;
	  	}

	  	public function EncryptPass($sData)
	  	{
	  		$vEncrypted =	md5($sData."".KEYCODE);

	  		return $vEncrypted;
	  	}

	  	public function getOS($userAgent) {
		    // Create list of operating systems with operating system name as array key
		    $oses = array (
		        'iPhone'            => '(iPhone)',
		        'Windows 3.11'      => 'Win16',
		        'Windows 95'        => '(Windows 95)|(Win95)|(Windows_95)',
		        'Windows 98'        => '(Windows 98)|(Win98)',
		        'Windows 2000'      => '(Windows NT 5.0)|(Windows 2000)',
		        'Windows XP'        => '(Windows NT 5.1)|(Windows XP)',
		        'Windows 2003'      => '(Windows NT 5.2)',
		        'Windows Vista'     => '(Windows NT 6.0)|(Windows Vista)',
		        'Windows 7'         => '(Windows NT 6.1)|(Windows 7)',
		        'Windows NT 4.0'    => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		        'Windows ME'        => 'Windows ME',
		        'Open BSD'          => 'OpenBSD',
		        'Sun OS'            => 'SunOS',
		        'Linux'             => '(Linux)|(X11)',
		        'Safari'            => '(Safari)',
		        'Mac OS'            => '(Mac_PowerPC)|(Macintosh)',
		        'QNX'               => 'QNX',
		        'BeOS'              => 'BeOS',
		        'OS/2'              => 'OS/2',
		        'Search Bot'        => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
		    );

		    // Loop through $oses array
		    foreach($oses as $os => $preg_pattern) {
		        // Use regular expressions to check operating system type
		        if ( preg_match('@' . $preg_pattern . '@', $userAgent) ) {
		            // Operating system was matched so return $oses key
		            return $os;
		        }
		    }

		    // Cannot find operating system so return Unknown

		    return 'n/a';
		}

		public function autoUniqueKey()
		{
			return md5(date("YmdHis"));
		}

				
		public function genDropDown($sOptions, $sName, $sId, $sClasses, $sAction, $vType)
		{
			if ($vType != "multi")
			{
				$sDropDown	=	"";
				$sDropDown	.=	"<select name='".$sName."' id='".$sId."' class=' ".$sClasses." ' ".$sAction." >";
				$sDropDown	.=	"<option value=''></option>";
				$sDropDown	.=	$sOptions;
				$sDropDown	.=	"</select>";
			}
			else
			{
				$sDropDown	=	"";
				$sDropDown	.=	"<select multiple name='".$sName."' id='".$sId."' class=' ".$sClasses." ' ".$sAction." >";
				$sDropDown	.=	$sOptions;
				$sDropDown	.=	"</select>";
			}

			return $sDropDown;
		}



		public function GenPartInfo($sRegionId, $sPartId) {

			$qGenPartInfo  	=   "sp_GeneratePartInfo";
	        $eGenPartInfo  	=   $this->execQuery($qGenPartInfo, array($sRegionId));
	        $aPartInfo['records'] = $eGenPartInfo->result();

	        if (empty($sPartId))
	        {
		        if ($aPartInfo['records'][0]->hh_code == ""){
		        	// $nHHCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad("1", 4, "0", STR_PAD_LEFT);
		        	$nHHCode 	=	REGION[abs($sRegionId)] ."-".str_pad("1", 4, "0", STR_PAD_LEFT);
		        } else {
		        	$aHHCode 	=	explode("-", $aPartInfo['records'][0]->hh_code);
		        	// $nHHCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad((abs($aHHCode[1]) + 1), 4, "0", STR_PAD_LEFT);
		        	$nHHCode 	=	REGION[abs($sRegionId)]  ."-".str_pad((abs($aHHCode[1]) + 1), 4, "0", STR_PAD_LEFT);
		        }

		        if ($aPartInfo['records'][0]->part_id == ""){
		        	// $nPPCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad("1", 5, "0", STR_PAD_LEFT);
		        	$nPPCode 	=	REGION[abs($sRegionId)] ."-".str_pad("1", 5, "0", STR_PAD_LEFT);
		        } else {
		        	$aPPCode 	=	explode("-", $aPartInfo['records'][0]->part_id);
		        	// $nPPCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad((abs($aPPCode[1]) + 1), 5, "0", STR_PAD_LEFT);
		        	$nPPCode 	=	REGION[abs($sRegionId)] ."-".str_pad((abs($aPPCode[1]) + 1), 5, "0", STR_PAD_LEFT);
		        }
		    } 
		    else {
		    	$aCurrPartInfo 	=	explode("-", $sPartId);

		    	if (abs($sRegionId) == abs($aCurrPartInfo[0])) {
		    		// $nHHCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad($aCurrPartInfo[1], 4, "0", STR_PAD_LEFT);
		    		// $nPPCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad($aCurrPartInfo[1], 5, "0", STR_PAD_LEFT);
		    		$nHHCode 	=	REGION[abs($sRegionId)] ."-".str_pad($aCurrPartInfo[1], 4, "0", STR_PAD_LEFT);
		    		$nPPCode 	=	REGION[abs($sRegionId)] ."-".str_pad($aCurrPartInfo[1], 5, "0", STR_PAD_LEFT);
		    	} else {
		    		if ($aPartInfo['records'][0]->hh_code == ""){
		        		// $nHHCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad("1", 4, "0", STR_PAD_LEFT);
		        		$nHHCode 	=	REGION[abs($sRegionId)] ."-".str_pad("1", 4, "0", STR_PAD_LEFT);
			        } else {
			        	$aHHCode 	=	explode("-", $aPartInfo['records'][0]->hh_code);
			        	// $nHHCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad((abs($aHHCode[1]) + 1), 4, "0", STR_PAD_LEFT);
			        	$nHHCode 	=	REGION[abs($sRegionId)] ."-".str_pad((abs($aHHCode[1]) + 1), 4, "0", STR_PAD_LEFT);
			        }

			        if ($aPartInfo['records'][0]->part_id == ""){
			        	// $nPPCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad("1", 5, "0", STR_PAD_LEFT);
			        	$nPPCode 	=	REGION[abs($sRegionId)] ."-".str_pad("1", 5, "0", STR_PAD_LEFT);
			        } else {
			        	$aPPCode 	=	explode("-", $aPartInfo['records'][0]->part_id);
			        	// $nPPCode 	=	str_pad($sRegionId, 2, "0", STR_PAD_LEFT) ."-".str_pad((abs($aPPCode[1]) + 1), 5, "0", STR_PAD_LEFT);
			        	$nPPCode 	=	REGION[abs($sRegionId)] ."-".str_pad((abs($aPPCode[1]) + 1), 5, "0", STR_PAD_LEFT);
			        }
		    	}
		    }
	        

	        return array("hh_code" => $nHHCode, "pp_code" => $nPPCode);
		}

		public function DropGender($sDataKey, $sSelected) {

			$sSelMale 	=	strtolower($sSelected) == "m" ? " selected" : "";
			$sSelFema 	=	strtolower($sSelected) == "f" ? " selected" : "";

			$sOptions=	  "<select class='form-control input-sm' data='req' data-key='".$sDataKey."' data-default='".ucfirst(strtolower($sSelected))."'>";
			$sOptions.=   "<option value =''></value>";
			$sOptions.=   "<option value ='m' ".$sSelMale.">Male</value>";
			$sOptions.=   "<option value ='f' ".$sSelFema.">Female</value>";
			$sOptions.=	  "</select>";

			return $sOptions;
		}

		public function DropCivilStat($sDataKey, $sSelected) {

			$sOptions=	  "<select class='form-control input-sm' data='req' data-key='".$sDataKey."'  data-default='".ucfirst(strtolower($sSelected))."'>";
			$sOptions.=   "<option value =''></value>";

			foreach (CIVILSTATS as $sKey => $sValue) {
				$sSel 	=	$sSelected == $sKey ? " selected" : "";
				$sOptions.=   "<option value ='".$sKey."'". $sSel.">".$sValue."</value>";
			}
			
			
			$sOptions.=	  "</select>";

			return $sOptions;
		}

		public function DropAppStat($sDataKey, $sSelected) {

			$sOptions=	  "<select class='form-control input-sm' data='req' data-key='".$sDataKey."'  data-default='".ucfirst(strtolower($sSelected))."'>";
			$sOptions.=   "<option value =''></value>";

			$aAppStat =	APPSTAT;
			asort($aAppStat);

			foreach (APPSTAT as $sKey => $sValue) {
				$sSel 	=	$sSelected == $sKey ? " selected" : "";
				$sOptions.=   "<option value ='".$sKey."'". $sSel.">".$sValue."</value>";
			}
			
			
			$sOptions.=	  "</select>";

			return $sOptions;
		}


		public function DropOccupation($sId, $sSelected) {

			$sOptions=	  "<select id='".$sId."' name='".$sId."' class='form-control input-sm' data='req' data-default='".strtolower($sSelected)."'>";
			$sOptions.=   "<option value =''></value>";

			$aOccupation 	=	OCCUPATION;
			asort($aOccupation);

			foreach ($aOccupation as $sOccuKey => $sOccuVal) {
				$sSel =		strtolower($sSelected) == $sOccuKey ? " selected" : "";
				$sOptions.=   "<option value ='".$sOccuKey."' ". $sSel.">".$sOccuVal."</value>";
			}

			$sOptions.=	  "</select>";

			return $sOptions;
		}

		public function DropEducAttain($sSelected) {

			$sOptions=	  "<select class='form-control input-sm' data='req' data-key='EducType' data-default='".ucfirst(strtolower($sSelected))."'>";
			$sOptions.=   "<option value =''></value>";
			foreach (EDUCTYPE as $cKey => $sValue) {

				$sSel 	=	$sSelected == $cKey ? " selected" : "";
				$sOptions.=   "<option value ='".$cKey."'". $sSel.">".$sValue."</value>";
					
			}

			$sOptions.=	  '</select>';
			return $sOptions;
		}

		public function DropSkillLevel($sSelected) {

			$sOptions=	  "<select class='form-control input-sm' data='req' data-key='SkillsLevel'  data-default='".ucfirst(strtolower($sSelected))."'>";
			$sOptions.=   "<option value =''></value>";
			foreach (SKILLLEVEL as $cKey => $sValue) {

				$sSel 	=	$sSelected == $cKey ? " selected" : "";
				$sOptions.=   "<option value ='".$cKey."'". $sSel.">".$sValue."</value>";
					
			}

			$sOptions.=	  '</select>';
			return $sOptions;
		}

		public function DropPages() {

			$CI =& get_instance();
	        $sHtml      =   '';

	        $qGetPages   	=   "sp_GetPages";
	        $eGetPages   	=   $this->execQuery($qGetPages, array());
	        $aPagesData['records'] = $eGetPages->result();

	        $sReturn        =   "<select name='selPages' id='selPages' class='form-control input-sm' data='req'>";
	        $sReturn        .=  "<option value=''>";

	        foreach ($aPagesData['records'] as $sData)
	        {
	            $sReturn    .=  "<option value='".$sData->ModID."'>".$sData->ModTitle;
	        }

	        $sReturn        .=   "</select>";


	        $eGetPages->next_result();
        	$eGetPages->free_result();

	        return $sReturn;
	    }

	    public function DropDowns($sType, $aData, $sSelected) {

			$CI =& get_instance();
			$aReturn 	=	array();

			switch ($sType) {

				case 'region':
						$qDropdowns   	=   "sp_DropAddress";
						$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);

				        $aDropdowns['records'] = $eDropdowns->result();

				        $sReturn        =   "<select name='selRegion' id='selRegion' class='form-control input-sm' data='req' data-key='ClientRegion'>";
				        $sReturn        .=  "<option value=''>";

				        foreach ($aDropdowns['records'] as $sData)
				        {
				        	$sSel =	$sSelected == $sData->regCode ? " selected" : "";
				            $sReturn    .=  "<option value='".$sData->regCode."' ".$sSel.">".$sData->regDesc;
				        }

				        $sReturn        .=   "</select>";

				        $eDropdowns->next_result();
        				$eDropdowns->free_result();

        				return $sReturn;
					break;

				case 'dropcitymuniprov':
						
						$qDropdowns   	=   "sp_DropAddress";
						$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);

				        $aDropdowns['records'] = $eDropdowns->result();


				        $sReturn        =  "<option value=''>";

				        foreach ($aDropdowns['records'] as $sData)
				        {
				        	$sSel =	$sSelected == $sData->citymunCode ? " selected" : "";
				            $sReturn    .=  "<option value='".$sData->citymunCode."' ".$sSel.">".$sData->citymunDesc;
				        }

				        $aReturn['return'] = "ok";
				        $aReturn['message'] = $sReturn;

				        
        				$eDropdowns->next_result();
        				$eDropdowns->free_result();

				        return $aReturn;

					break;

				case 'dropbrgy':
						$qDropdowns   	=   "sp_DropAddress";
						$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);

				        $aDropdowns['records'] = $eDropdowns->result();

				        $sReturn        =  "<option value=''>";

				        foreach ($aDropdowns['records'] as $sData)
				        {
				        	$sSel =	$sSelected == $sData->id ? " selected" : "";
				            $sReturn    .=  "<option value='".$sData->id."' ".$sSel.">".$sData->brgyDesc;
				        }

				        $aReturn['return'] = "ok";
				        $aReturn['message'] = $sReturn;

				        $eDropdowns->next_result();
        				$eDropdowns->free_result();

				        $this->ConnClose($eDropdowns);

				        return $aReturn;

					break;
			}
			
	        return $sReturn;
	    }

	    public function GetQuestions($aData, $aSelectedData) {
// return $aSelectedData;
			$CI =& get_instance();
	        $sHtml      =   '';
	        $aQues 		=	array();
	        $aReturn	=	array();

	        $aArrMultiData =	array('hist_sys_dis', 'hist_life_con', 'hist_sys_med', 'hist_ocu_med', 'hist_diet_sup', 'ocu_exam', 'manage_plan', 'symp_ocu', 'symp_non_ocu', 'ocu_find_diag');


	        $qGetQues  	=   "sp_GetQuestions";
	        $eGetQues  	=   $this->execQuery($qGetQues, $aData);
	        
	        $aQuesData['records'] = $eGetQues->result();

	        
	        foreach ($aQuesData['records'] as $key => $aValues) {
	        	$aQues[$aValues->id]['ques_name'] = $aValues->ques_name;
	        	$aQues[$aValues->id]['ques_desc'] = $aValues->ques_desc;

	        	$aQues[$aValues->id]['ans'][$aValues->ans_id]['ans_data'] 		= $aValues->ans_data;
	        	$aQues[$aValues->id]['ans'][$aValues->ans_id]['ans_order'] 		= $aValues->ans_order;
	        	$aQues[$aValues->id]['ans'][$aValues->ans_id]['ans_increment'] 	= $aValues->ans_increment;
	        	$aQues[$aValues->id]['ans'][$aValues->ans_id]['ans_type'] 		= $aValues->ans_type;
	        }

	        foreach ($aSelectedData as $sTabKey => $aTabData) 
	        {	
	        	if (sizeof($aTabData) > 0) 
	        	{
	        		if (in_array($sTabKey, $aArrMultiData))
	        		{
	        			foreach ($aTabData as $nKey => $aMultiData) 
	        			{
	        				foreach ($aMultiData as $sElemId => $sValues) 
	        				{
	        					foreach ($aQues as $nQuesId => $aVals) 
				        		{
				        			$sQuesName =	$aVals['ques_name'];

				        			if (isset($aMultiData->$sQuesName)) 
				        			{
				        				if (substr($sElemId, 0, 3) != "txt" && substr($sElemId, 0, 3) != "chk") {
				        					$sHtml 	=	"<select name='".$sQuesName."' id='".$sQuesName."' class='form-control input-sm' data='req'>";
								        	// $sHtml 	.= 	"<option value=''>";
								        	$sHtml 	.= 	"<option value='n_a' selected>N\A";

								        	foreach ($aVals['ans'] as $nAnsId => $aOptions) 
								        	{	        		
								        		if ($aOptions['ans_type'] === "range") {

								        			$aAnsData =	explode("|", $aOptions['ans_data']);
													$x = $aAnsData[0];

													while($x <= $aAnsData[1]) {

										        		$sSelected = $x == $aMultiData->$sQuesName ? " selected" : "";

										        		if (strpos($sQuesName, "_sphere") > -1 || strpos($sQuesName, "_cylinder") > -1) {
															$sHtml 	.=	"<option value='".number_format($x, 2)."' ".$sSelected.">".number_format($x, 2);
														} else {
															$sHtml 	.=	"<option value='".$x."' ".$sSelected.">".$x;
														}
														
														$x += $aOptions['ans_increment'];
													}	        			

								        		} else if ($aOptions['ans_type'] == "option") {
								        			
									        		$sSelected = $aOptions['ans_data'] === $aMultiData->$sQuesName ? " selected" : "";
								        			$sHtml 	.=	"<option value='".$aOptions['ans_data']."' ".$sSelected."> ".$aOptions['ans_data'];
								        		}
								        	}

								        	$sHtml 	.=	"</select>";

				        					$aReturn[$sTabKey][$nKey][$sQuesName] =	$sHtml;

				        				} 
				        				else if (substr($sElemId, 0, 3) == "chk") 
				        				{
				        					
				        					$sChecked =	$sValues == "true" ? " checked" : "";
				        					$aReturn[$sTabKey][$nKey][$sElemId] =	'<input type="checkbox" name="rdButton" id="'.$sElemId.'"'.$sChecked.'>';
				        				}
				        				else 
				        				{
				        					if (strpos(strtolower($sElemId), 'year') !== false) {
				        						$aReturn[$sTabKey][$nKey][$sElemId] =	'<input type="text" class="form-control input-sm month-year-picker date-duration" name="'.$sElemId.'" id="'.$sElemId.'"  placeholder="mm/yyyy" data="req" value="'.$sValues.'">';
				        					} else {
				        						$aReturn[$sTabKey][$nKey][$sElemId] =	'<input type="text" class="form-control input-sm" name="'.$sElemId.'" id="'.$sElemId.'" readonly="" value="'.$sValues.'">';
				        					}
				        					
				        				}
	        						}
	        					}
	        				}
	        			}
	        		}
		        	else 
		        	{
				        foreach ($aQues as $nQuesId => $aVals) 
				        {
				        	$sQuesName =	$aVals['ques_name'];

				        	if (isset($aTabData[$sQuesName])) 
				        	{
					        	$sHtml 	=	"<select name='".$sQuesName."' id='".$sQuesName."' class='form-control input-sm' data='req'>";
					        	// $sHtml 	.= 	"<option value=''>";
					        	$sHtml 	.= 	"<option value='n_a' selected>N\A";

					        	foreach ($aVals['ans'] as $nAnsId => $aOptions) {	        		

					        		if ($aOptions['ans_type'] == "range") {

					        			$aAnsData =	explode("|", $aOptions['ans_data']);
										$x = intval($aAnsData[0]);

										while($x <= intval($aAnsData[1])) {

							        		$sSelected = $x == $aTabData[$sQuesName] ? " selected" : "";

											// $sHtml 	.=	"<option value='".$x."' ".$sSelected.">".$x;
											if (strpos($sQuesName, "_sphere") > -1 || strpos($sQuesName, "_cylinder") > -1) {
												$sHtml 	.=	"<option value='".number_format($x, 2)."' ".$sSelected.">".number_format($x, 2);
											} else {
												$sHtml 	.=	"<option value='".$x."' ".$sSelected.">".$x;
											}
											$x += $aOptions['ans_increment'];
										}	        			

					        		} else if ($aOptions['ans_type'] == "option") {
					        			
						        		$sSelected = $aOptions['ans_data'] == $aTabData[$sQuesName] ? " selected" : "";
					        			$sHtml 	.=	"<option value='".$aOptions['ans_data']."' ".$sSelected.">".$aOptions['ans_data'];
					        		}
					        	}

					        	$sHtml 	.=	"</select>";

					        	$aReturn[$aVals['ques_name']] = $sHtml;
					        }
					    }
					}
					

			        foreach ($aTabData as $sTxtKey => $sTxtValue) {
			        	if (substr($sTxtKey, 0, 3) == "txt") {
			        		$aReturn[$sTxtKey] = $sTxtValue;
			        	}
			        }
				}
			    else 
			    {
			    	
			    	foreach ($aQues as $nQuesId => $aVals) 
			        {
			        	$sQuesName =	$aVals['ques_name'];
			        	if (!isset($aReturn[$sQuesName])) {
				        	
				        	$sHtml 	=	"<select name='".$sQuesName."' id='".$sQuesName."' class='form-control input-sm' data='req'>";
				        	// $sHtml 	.= 	"<option value=''>";
				        	$sHtml 	.= 	"<option value='n_a'>N\A";

				        	foreach ($aVals['ans'] as $nAnsId => $aOptions) {	        		

				        		if ($aOptions['ans_type'] == "range") {

				        			$aAnsData =	explode("|", $aOptions['ans_data']);
									$x = intval($aAnsData[0]);

									while($x <= intval($aAnsData[1])) {

										// $sHtml 	.=	"<option value='".$x."'>".$x;
										if (strpos($sQuesName, "_sphere") > -1 || strpos($sQuesName, "_cylinder") > -1) {
											$sHtml 	.=	"<option value='".number_format($x, 2)."'>".number_format($x, 2);
										} else {
											$sHtml 	.=	"<option value='".$x."'>".$x;
										}
										
										$x += $aOptions['ans_increment'];
									}	        			

				        		} else if ($aOptions['ans_type'] == "option") {
				        			
				        			$sHtml 	.=	"<option value='".$aOptions['ans_data']."'>".$aOptions['ans_data'];
				        		}
				        	}

				        	$sHtml 	.=	"</select>";

				        	$aReturn[$aVals['ques_name']] = $sHtml;
				        }				        
			        }
			    }
			}

	        $eGetQues->next_result();
        	$eGetQues->free_result();
	        return $aReturn;
	    }

	    public function GetAnswers($aData) {
	    	$aQues 		=	array();
	        $aReturn	=	array();


	        $qGetAns  	=   "sp_GetAnswers";
	        $eGetAns  	=   $this->execQuery($qGetAns, $aData);

	        $aQuesData = $eGetAns->result();

	        $eGetAns->next_result();
        	$eGetAns->free_result();

	        return $aQuesData;

	    }

	    public function GetAnalysisQues($aData) {
	    	
	        $CI =& get_instance();

	        
	        $sReturn      	=   '';
	        
	        $qGetQues  	=   "sp_GetAnalysisQues";
	        $eGetQues  	=   $this->execQuery($qGetQues, $aData);

	        $aQuesData['records'] = $eGetQues->result();

	        $sReturn     =  "<select class='form-control input-sm selQues' data='req'>";

	        $sReturn    .=  "<option value=''>";
	        $sReturn    .=  "<option value='region'>Region";
	        $sReturn    .=  "<option value='age'>Age";
	        $sReturn    .=  "<option value='gender'>Gender";
	        $sReturn    .=  "<option value='occupation'>Occupation";
	        $sReturn    .=  "<option value='educattain'>Educational Attainment";

	        foreach ($aQuesData['records'] as $sData)
	        {
	        	if (in_array($sData->ques_name, ANALYSISQUES) == true)
	        	{
	        		$sReturn    .=  "<option value='".$sData->id."|".$sData->ques_name."|".$sData->ques_page_id."'>".$sData->ques_desc;
	        	}
	        }

	        $sReturn    .=   "</select>";

	        $eGetQues->next_result();
			$eGetQues->free_result();

	        return $sReturn;
	    }

		public function transformNullToEmptyStr($value) {
			return $value ?? "";
		}

		public function ArrayToJson($aJsonData, $sDataType) {

			$aReturn 	=	array();

			switch ($sDataType) {
				case 'nested':

					foreach ($aJsonData as $nKey => $aValue) {
						$aReturn[$nKey] 	=	json_encode($aValue);
					}
				break;

				case 'single':
						$aReturn 	=	json_encode($aJsonData);
					break;
			}

			return $aReturn;
		}

		public function JsonToArray($aJsonData) {

			$aReturn 	=	array();
			
			if (sizeof($aJsonData) > 0)
			{
				$aJsonArray	=	$aJsonData;
				foreach ($aJsonArray as $sDataKey => $value)
				{
					$aReturn[$sDataKey] = $value;
				}
			} return $aReturn;
		}

		public function ArrayToLine($aArrData) {

	  		$sVals 	=	"";

			if(sizeof($aArrData) > 0) {
				foreach ($aArrData as $nKey => $sValue) {
					$sVals	.=	" ".$sValue.",";
				}
			}

			$sVals	=	substr($sVals, 0, -1);

			return $sVals;
		}

		public function getQualifications($aQualifications) {
			$sVals 	=	"";

			if(sizeof($aQualifications) > 0) {

				foreach ($aQualifications as $nKey => $sValue) {
					if ($sValue != "") {
						$sVals	.=	" ".QUALIFICATIONS[$sValue].",";	
					} else{
						$sVals	.=	"";
					}
					
				}
			}


			$sVals	=	substr($sVals, 0, -1);

			return $sVals;
		}

		public function get_user_modules() {

			$CI =& get_instance();


			$aUrl       =   parse_url($_SERVER['REQUEST_URI']);
			$aUrls 		=	explode("/", $aUrl['path']);
			$sCurrPage	= 	$aUrls[sizeof($aUrls) - 1];

			$sSessUname =   $CI->session->userdata('sess_username');
	        $aUserInfo  =   $CI->currentuser->get_user_info($sSessUname);


	        $nAccestype =	$aUserInfo[0]['AccessType'];
	        $sHtml      =   '';

	        $qGetMenu   =   "CALL sp_GetModules()";
	        $eGetMenu   =   $CI->db->query($qGetMenu);
	        $aMenuData['records'] = $eGetMenu->result();

	        $aMenus     =   array();
	    
	        foreach ($aMenuData['records'] as $sData)
	        {
	            $sMenuTitle =   $sData->menutitle;
	            $sMenuIcon  =   $sData->menuicon;
	            $sMenuType  =   $sData->menutype;

	            $sModTitle  =   $sData->modtitle;
	            $sModPath   =   $sData->modpath;
	            $sModAccess =   $sData->modaccess;

	            $aMenus[str_replace(" ", "_", $sMenuTitle)."|".$sMenuIcon."|".$sMenuType][] =  $sModTitle."|".$sModPath."|".$sModAccess;
	        }

	        $sHtml .= "<ul id='ul-sidebar-menu' class='sidebar-menu' data-widget='tree'>
	                    <li class='header'>MAIN NAVIGATION</li>
	                    ";
	        foreach ($aMenus as $sMenuDetails => $aModules)
	        {
	            $aMenuDetails   =   explode("|", $sMenuDetails);

	            $sActive = "";

	            foreach ($aModules as $key => $value) {
	                $aMods  =   explode("|", $value);

	                $sActive =  $aMods[1] == $sCurrPage ? " menu-open active" : "";
	                $sDis    =  $aMods[1] == $sCurrPage ? "block" : "none";

	                if ($sActive != "")
	                {
	                    break;
	                }
	            }

	            if ($aMenuDetails[2] == 'Tree') 
	            {
	                $sHtml .= ' <li class="treeview '.$sActive.'">
	                            <a href="#">
	                                <i class="fa '.$aMenuDetails[1].'"></i> <span>'.ucwords(strtolower(str_replace("_", " ", $aMenuDetails[0]))).'</span>
	                                <span class="pull-right-container">
	                                  <i class="fa fa-angle-left pull-right"></i>
	                                </span>
	                            </a>';
	                $sHtml .= '     <ul class="treeview-menu" style="display:'.$sDis.'">';
	                
	                foreach ($aModules as $nKey => $sModDetails)
	                {
	                    $aTitelDet  =   explode("|", $sModDetails);
	                    $sModTitle  =   strtolower(str_replace("_", " ", $aTitelDet[0]));
	                    $sModPath   =   $aTitelDet[1];

	                    $sActive   =    $sCurrPage == $sModPath ? "active" : "";
	                    
	                    if ($sCurrPage == $sModPath) {
	                        $CI->kgsessions->get_session('sess_pagetitle', ucwords(strtolower($sModTitle)));
	                    }

	                    $aAccess 	=	explode(",", $aTitelDet[2]);
	                    
	                    if (in_array($nAccestype, $aAccess) ) {
	                    	$sHtml .=   '   <li class="'.$sActive.'"><a href="'.$sModPath.'" data-path="'.$sModPath.'"> <i class="fa fa-circle-o"></i>'.ucwords(strtolower($sModTitle)).'</a></li>';
	                    }

	                }
	                    $sHtml .= "  </ul>";
	                $sHtml .= " </li>";
	            }
	            else {
	            
	                $sActive   =    $sCurrPage == strtolower(str_replace(" ", "_", $aMenuDetails[0])) ? "active" : "";
	                $sHtml .= "<li class='".$sActive."'>
	                            <a href='".strtolower(str_replace(" ", "_", $aMenuDetails[0]))."' data-path='".strtolower(str_replace(" ", "_", $aMenuDetails[0]))."'>
	                                <i class='fa ".$aMenuDetails[1]."'></i>
	                                <span>".ucwords(strtolower(str_replace("_", " ", $aMenuDetails[0])))."</span>
	                            </a>
	                            </li>";
	        
	            }
	            
	        }

	        $sHtml .= " </ul>";


	        $aPage              =   explode("/", $sCurrPage);
	        $aHtml['html']      =   $sHtml;
	        $aHtml['page']      =   ucwords(strtolower(str_replace("_", " ", $sCurrPage)));
	        $aHtml['home']      =   ucwords(strtolower(str_replace("_", " ", $aPage[0])));
	        $aHtml['user']      =   $CI->kgsessions->get_session('sess_username');
	        $aHtml['secpage']   =   ucwords(strtolower($CI->kgsessions->get_session('sess_secpage')));


	        $eGetMenu->free_result();
	        $eGetMenu->next_result();
	        return $aHtml;
	    }
		

		public function Upload($sFileName, $sPath) {

	    	$CI =& get_instance();
	    	
	        $config = array (
	        	'file_name' 	=> $sFileName,
	            'upload_path'   => "./".$sPath."/",
	            'allowed_types' => 'png|jpeg|jpg',
	            'overwrite'     => TRUE,
	        );
	        
	        $CI->load->library('upload', $config);
        	$CI->upload->initialize($config);
        	
        	if ($CI->upload->do_upload('upFile'))
        	{

        		return json_encode(array("return" => true, "filename" => $sFileName));
        	}
        	else 
        	{
        		return json_encode(array("return" => false));
        	}
	    }

	    public function getDropDowns($aData) {
	    	$CI =& get_instance();

	    	// $aDropTypes		=	array('position', 'religion', 'shift', 'branch');

	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= $eDropdowns->result();

	        $eDropdowns->next_result();
			$eDropdowns->free_result();

			$aRepresentatives	=	$this->getRepresentatives();


	        foreach ($aDropdowns as $nKey => $aValue) {
	        	$aDropList[$aValue->dropdown_type][] = array('id' => $aValue->id, 'value' => $aValue->dropdown_value, 'drpkey' => $aValue->dropdown_key);
	        }
	        
	        foreach (DROPTYPES as $nKey => $sType) {

	        	
	        	if (isset($aDropList[$sType])) {
	        		$sHtml 	=	'<table class="table table-striped table-hover table-data">';
		        	foreach ($aDropList[$sType] as $vKey => $aValue) {

		        		$sActions 	=	'<a href="" class="text-red" data-id="'.$aValue['id'].'" data-trigger="drpdel"><i class="fa fa-remove"></i></a>&nbsp;&nbsp;';
		        		

		        		if ($sType == "shift") {
		        			$aShifts 	=	explode("-", $aValue['value']);
		        			$nDuration 	=	$this->calcTime($aShifts[0], $aShifts[1]);
		        			$sValue 	=	addslashes(strtoupper($aValue['value']))." (".$nDuration." hrs.)";
		        		} else {
		        			$sValue 	= 	addslashes(ucwords(strtolower($aValue['value'])));
		        		}

						
						if ($aValue['drpkey'] == "") {
							$sJsonData 	=	json_encode($aValue);
							$sActions 	.=	'<a href="" class="text-blue" data-value="'.$sJsonData.'" data-trigger="drpedit"><i class="fa fa-edit"></i></a>';
							$sHtml 	.=	'
		        					<tr>
		        						<td>
		        							'.$sValue.'
		        						</td>
		        						
										<td width="15%">
		        							'.$sActions.'
		        						</td>

		        					</tr>
		        				';
						} else {
							$aClientInfo	=	$CI->customer->GetClientInfo(array('clientid' => $aValue['drpkey']));
							$sDrpValue 		=	$aClientInfo['ClientName'];

							if (isset($aRepresentatives[$aValue['id']])) {

								// $sJsonData 	=	json_encode($aValue);
								// $sActions 	.=	'<a href="" class="text-red" data-value="'.$sJsonData.'" data-trigger="drpedit"><i class="fa fa-edit"></i></a>';

								$sHtml 	.=	'
			        					<tr>
			        						<td>
			        							'.$sValue.'
			        						</td>
			        						<td>
			        							'.$sDrpValue.'
			        						</td>
			        						<td>
			        							'.$aRepresentatives[$aValue['id']]['fullname'].'
			        						</td>

			        						<td>
			        							'.$aRepresentatives[$aValue['id']]['contact'].'
			        						</td>

			        						<td>
			        							'.$aRepresentatives[$aValue['id']]['email'].'
			        						</td>
											<td width="10px;">
			        							'.$sActions.'
			        						</td>

			        					</tr>
			        				';
		        			} else {
		        				$sJsonData 	=	json_encode($aValue);
								$sActions 	.=	'<a href="" class="text-blue" data-value="'.$sJsonData.'" data-trigger="drpedit"><i class="fa fa-edit"></i></a>';

		        				$sHtml 	.=	'
			        					<tr>
			        						<td>
			        							'.$sValue.'
			        						</td>
			        						<td>
			        							'.$sDrpValue.'
			        						</td>
			        						<td>&nbsp;</td>

			        						<td>&nbsp;</td>

			        						<td>&nbsp;</td>
											<td width="15%">
			        							'.$sActions.'
			        						</td>

			        					</tr>
			        				';
		        			}
						}

		        		
		        	}
		        	$sHtml 	.=	"</table>";

		        	$aDropReturn[$sType] = $sHtml;
		        } else {
		        	if (!empty($sType)) {
		        		$aDropReturn[$sType] =	"List empty";
		        	}
		        }
	        }

	        

	        return $aDropReturn;
	    }

	    public function getRepresentatives() {
	    	$aReturn 		=	array();
			$sSpName        =   "sp_GetRepresentatives";
            $eExecQuery     =   $this->execQuery($sSpName, array());
            $aResult        =   $eExecQuery->result_array();

            foreach ($aResult as $nKey => $aValue) {
            	if ($aValue['branch_id'] != '') {
            		$aReturn[$aValue['branch_id']] =	array('fullname' => $aValue['rep_fullname'], 'contact' => $aValue['rep_contact'], 'email' => $aValue['rep_email']);	
            	}
            }

            $eExecQuery->next_result();
			$eExecQuery->free_result();
            return $aReturn;
		}

	    public function getDropDownsDd($aData, $sSelected) {
	    	$CI =& get_instance();

	    	// $aDropTypes		=	array('position', 'religion', 'shift', 'branch');

	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= $eDropdowns->result();

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

			        		
			        		$sHtml  		.=	"<option value='".$aValue['id']."' ".$sSel.">".ucwords(strtolower($sValue))."</option>";
			        	}
			        	$sHtml 	.=	"</select>";


			        } else {

	        			$sHtml  		=	"<select class='input-sm form-control' data='req' data-key='".ucfirst(strtolower($sType))."Id'>";
            			$sHtml  		.=	"<option value=''></option>";
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

	    public function getPositionList($aData, $nClientId, $aSelectedData) {
	    	$CI =& get_instance();

	    	$sHtml 			=	"";

	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= $eDropdowns->result();

	        if (sizeof($aDropdowns) > 0) {
		        foreach ($aDropdowns as $nKey => $aValue) {
		        	if ($aValue->dropdown_type == "position") {
		        		if ($nClientId == $aValue->dropdown_key) {
		        			$aDropList[] = array('id' => $aValue->id, 'value' => $aValue->dropdown_value, 'drpkey' => $aValue->dropdown_key);		        		
		        		}
		        	}
		        }
		    }

		    if (sizeof($aDropList) > 0) {
		        foreach ($aDropList as $nKey => $aValues) {
		        	if (sizeof($aSelectedData) > 0) {
		        		$sChecked 	=	in_array($aValues['id'], $aSelectedData) ? " checked" : "";
		        	} else {
		        		$sChecked 	=	"";
		        	}

		        	$sHtml .=	"<div class='form-group'>
					               	<label>
					                   <input type='checkbox' value='".$aValues['id']."' ".$sChecked.">&nbsp;&nbsp;
					                   ".$aValues['value']."
					                 </label>
						 		</div>";
		        }
		    } else {
		    	
		        	$sHtml  =	"";
		    }		    

	        $eDropdowns->next_result();
			$eDropdowns->free_result();


	        return $sHtml;
	    }

	    public function getPositionLine($aData, $aIds) {
	    	$CI =& get_instance();

	    	
	    	$sVals 			=	"";

	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= $eDropdowns->result();

	        if (sizeof($aDropdowns) > 0) {
		        foreach ($aDropdowns as $nKey => $aValue) {
		        	if ($aValue->dropdown_type == "position") {
		        		if (in_array($aValue->id, $aIds)) {
		        			$aDropList[] = array('id' => $aValue->id, 'value' => $aValue->dropdown_value, 'drpkey' => $aValue->dropdown_key);		        		
		        		}
		        	}
		        }
		    }
		     
	        if(sizeof($aDropList) > 0) {
				foreach ($aDropList as $nKey => $aValue) {
					$sVals	.=	" ".$aValue['value'].",";
				}

				$sVals	=	substr($sVals, 0, -1);

		    } else {
		    	
		        $sVals 	=	"";
		    }		    

	        $eDropdowns->next_result();
			$eDropdowns->free_result();


	        return $sVals;
	    }

	    public function getDropDownsValue($aData, $sSelected) {
	    	$CI =& get_instance();

	    	// $aDropTypes		=	array('position', 'religion', 'shift', 'branch');

	    	$aDropReturn	=	array();
	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= 	$eDropdowns->result();

	        $eDropdowns->next_result();
			$eDropdowns->free_result();

	        if (sizeof($aDropdowns) > 0) {
		        foreach ($aDropdowns as $nKey => $aValue) {
		        	if ($sSelected == $aValue->id) {
		        		return $aValue->dropdown_value;
		        	}
		        }
		    }
	    }

	    public function getDropDownsGroup($aData, $sSelected) {
	    	$CI =& get_instance();

	    	// $aDropTypes		=	array('position', 'religion', 'shift', 'branch');

	    	$aDropList 		=	array();
	    	$qDropdowns   	=   "sp_GetDropDowns";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);
	        $aDropdowns 	= 	$eDropdowns->result();

	        $eDropdowns->next_result();
			$eDropdowns->free_result();

	        if (sizeof($aDropdowns) > 0) {
		        foreach ($aDropdowns as $nKey => $aValue) {
		        	if ($sSelected == $aValue->dropdown_type) {
		        		$aDropList[$aValue->id] = $aValue->dropdown_value;
		        	}
		        }
		    }

		    return $aDropList;
	    }


	    public function calcTime($tFrom, $tTo) {
	    	$aFrom 	=	explode(" ", $tFrom);
	    	$aTo 	=	explode(" ", $tTo);

    		$nTo 		=	date('H:i', strtotime('+12 hours', strtotime($aTo[0])));
    		$nDuration 	=	(strtotime($nTo) - strtotime($aFrom[0])) / 3600;

	    	return $nDuration;
	    }
		
		public function sendSms($aCellNos, $sMessage, $sAppStat) {
	  		$CI =& get_instance();
	  		$sNewMessage 	=	$sMessage."\n\nThis is a system generated message, please do not reply.\n\nThank you, \nSMPC Recruitment Team.";
	  		
	  		if (sizeof($aCellNos) > 0) {

	  			foreach ($aCellNos as $key => $nCellNo) 
	  			{

	  				$ch = curl_init();
					$itexmo = array('1' => $nCellNo, '2' => $sNewMessage, '3' => APICODE, 'passwd' => APIPASS);
					curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, 
					http_build_query($itexmo));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$nResult 	=	curl_exec($ch);
					curl_close ($ch);

					if ($nResult == 0) {
						if ($sAppStat != "") {

							$aData =   array('AppstatId' => $sAppStat, 'ModifyBy' => $CI->session->userdata('sess_username'), 'ModifyDate' =>  date("Y-m-d H:i:s.u"), 'where' => array('AgentTrxId' => $key));
							// return $aData;
                        	$aGenInfoData   =   $this->createQuery('update', $aData, 'divPerInfo');

                        	// return $aGenInfoData;
                        	$sSpName        =   "sp_ExecQuery";
                            $eExecQuery     =   $this->execQuery($sSpName, $aGenInfoData);                            
                            $this->ConnClose($eExecQuery);
                        }
					}
	  			}				
			}	
	  	}


	    public function sendEmail($aData, $sLink)
		{
			$CI =& get_instance();

			$mail = new PHPMailer();
 
			$mail->IsSMTP();
			$mail->SMTPAuth 	= true;
			$mail->Host 		= 'mail.serendipitywalk.com';
			$mail->Username 	= 'recruitment@serendipitywalk.com';
			$mail->Password 	= 'Thec0debr3@ker';
			$mail->From 		= 'recruitment@serendipitywalk.com';
			$mail->FromName 	= "SMPC Recruitment";
			// $mail->SMTPSecure 	= 'tls';
			$mail->Port 		= 8889;

			$mail->AddReplyTo('recruitment@serendipitywalk.com', 'SMPC Recruitment');
			$mail->AddAddress($aData['request_contact_email']);



			$mail->Subject = "SMPC | Candidates List";
			$mail->Body = nl2br('Hi '.$aData['client_name'].', <br /> <br />
								Please click on the link below to chech the applicants for your requested manpower.
								<br /><br />
								'.$sLink.'
								<br /><br />

								This is an auto-generated email, please do not reply. <br /> <br />
								Kind Regards, <br />
								SMPC Recruitment');			
			$mail->IsHTML(true);
			

			if(!$mail->Send()) {
				return "unsent";
			} else {
				$ch = curl_init();
				$itexmo = array('1' => $aData['request_contact_number'], '2' => "We would like to inform you that we have applicants for your review. Please check your email.\n\nThank you.", '3' => APICODE, 'passwd' => APIPASS);
				curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, 
				http_build_query($itexmo));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$nResult 	=	curl_exec($ch);
				curl_close ($ch);
				
				return "sent";
			}
		}



		public function getCitiesDd($aData){
			$qDropdowns   	=   "sp_DropAddress";
			$eDropdowns   	=   $this->execQuery($qDropdowns, $aData);

	        $aDropdowns['records'] = $eDropdowns->result();

	         $sReturn        =   "<select class='form-control input-sm select2' data='req' data-key='DropDownSub'>";
	        $sReturn        .=  "<option value=''>";

	        foreach ($aDropdowns['records'] as $sData)
	        {
	        	$aRegDesc 	=	explode("(", $sData->regDesc);
	            $sReturn    .=  "<option value='".$sData->citymunCode."'>".$sData->citymunDesc." (".$aRegDesc[1];
	        }

	        $sReturn        .=   "</select>";


	        $eDropdowns->next_result();
			$eDropdowns->free_result();

			return $sReturn;
		}

		public function getDashboard(){
			$qDashboard   	=   "sp_Dashboard";
			$eDashboard   	=   $this->execQuery($qDashboard, array());

	        $aDashboard 	= 	$eDashboard->result_array();

	        $eDashboard->next_result();
			$eDashboard->free_result();

			$aReturn 	=	array();
			foreach ($aDashboard as $nKey => $aValue) 
			{
				foreach ($aValue as $sKey => $sValue) {
					if ($sKey != "agent_standing" && $sKey != "cnt")
					{
						$aReturn[$sKey] = $sValue;
					} 
					else if ($sKey == "agent_standing")
					{
						if ($aValue[$sKey] == "") {
							$aReturn['status']['ne'] = $aValue['cnt'];	
						} else {
							$aReturn['status'][$aValue[$sKey]] = $aValue['cnt'];		
						}
						
					}

				}
				
			}
			return $aReturn;
		}
		
	}
?>
