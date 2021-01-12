 <?php defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class General_information_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        } 

        public function proc_general_information($sAction, $aData ,$sType) {

        	switch ($sAction) {
                case 'get-ques':
                        return $this->hatvclib->GetQuestions($aData);
                break;

        		case 'dropcitymuniprov':

        			$aSelect     =   $this->hatvclib->DropDowns($sAction, $aData, '');

                    $aReturn    =   array("prov" => $aSelect);

                    return json_encode($aReturn);
        		break;

        		case 'dropbrgy':
    				return json_encode($this->hatvclib->DropDowns($sAction, $aData, ''));
    			break;

                case 'getsup':
                    return json_encode($this->customer->getBranchSup($aData));
                break;

                case 'update':
                        if ($sType == "divPerInfo") {
                            $sLocation = '';
                            if (isset($aData['ShiftId'])) {
                                $sName                  =  strtoupper($aData['FirstName']." ".$aData['LastName']);
                                $aData['AgentStatus']   = "deployed";
                                $aData['EmpId']         = $this->customer->genEmpId($aData['DateHired']);
                                $sScript                = "_infoBox2('Applicant ".$sName." was succesfully deployed.', 'window.location=\'applications\''); ";

                            } else {

                                $sScript                = "_systemMsg('saved'); $('a[aria-controls=".$sType."] .fa-circle').fadeOut();";

                            }

                            $dModifiedDate  =   date("Y-m-d H:i:s.u");
                            $sPhotoLink     =   base_url()."photos/".$aData['Photo'];
                            $aData['Photo'] =   $sPhotoLink;

                            $aData['where'] =   array('AgentTrxId' => $aData['AgentTrxId']);

                            unset($aData['AgentTrxId']);

                            $aGenInfoData   =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                            // return "console.log(\"".json_encode($aGenInfoData)."\")";

                            $sSpName        =   "sp_ExecQuery";

                            $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aGenInfoData);

                            $aResult        =   $eExecQuery->result_array();
                            $sResult        =   $aResult[0]['vFlag']; 

                            $eExecQuery->next_result();
                            $eExecQuery->free_result();

                            if ($sResult == 0) {

                                $sReturn =   "_systemAlert('system');";

                            } else {

                               $sReturn =   $sScript;
                               
                            }
                            return $sReturn;
                        } else {
                            $aGenInfoData   =   $this->hatvclib->createQuery($sAction, $aData, $sType);
                        
                            $sSpName        =   "sp_ExecQuery";

                            $eExecQuery     =   $this->hatvclib->execQueryHris($sSpName, $aGenInfoData);

                            $aResult        =   $eExecQuery->result_array();
                            $sResult        =   $aResult[0]['vFlag']; 

                            $eExecQuery->next_result();
                            $eExecQuery->free_result();

                            if ($sResult == 0) {

                                $sReturn =   "_systemAlert('system')";

                            } else {
                                $vReturn   =   "    
                                                    _infoBox('Congratulations, you have completed the application process. Give us time to review, and we will send a message for your job interview schedule. If you do not hear from us, you are probably not considered in the applied position.<br /><br />Thank you', \"window.location = '".base_url()."'\");
                                                ";
                                $sReturn =   $vReturn."
                                                $('a[aria-controls=".$sType."] .fa-circle').fadeOut();
                                            " ;
                            }
                        }
                break;

                case 'savebatch':
                        
                        $aData['AgentTrxId']        =  $this->kgsessions->get_session('sess_trxid');
                        $aDelData['agent_trx_id']   =  $this->kgsessions->get_session('sess_trxid');

                        $sSpName        =   "sp_ExecQuery";
                        $aDeptDelData   =   $this->hatvclib->createQuery('single_delete', $aDelData, $sType);
                        
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDeptDelData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        if ($sResult == 0) {
                            $sReturn =   "_systemAlert('system')";
                        } 
                        else
                        {
                            $aGenInfoData   =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                            $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aGenInfoData);

                            $aResult        =   $eExecQuery->result_array();
                            $sResult        =   $aResult[0]['vFlag']; 

                            $eExecQuery->next_result();
                            $eExecQuery->free_result();

                            if ($sResult == 0) {

                                $sReturn =   "_systemAlert('system')";

                            } else {
                                $sReturn =   $vReturn."
                                                _systemMsg('saved');
                                                $('a[aria-controls=".$sType."] .fa-circle').fadeOut();
                                            ";
                            }
                        }

                        return $sReturn;
                break;


                case 'clientdds':

                            $sReturn    =   "";
                            $aDropDown  =   $this->customer->getClientBranch(array(), '', $aData);
                            $aPosition  =   $this->hatvclib->getDropDownsDd(array(), $aData);
                            // $aDropDown  =   $this->customer->getClientBranch(array(), '', $aData);
                            $sDepts     =   $this->customer->getClientDeptsDd(array('clientid' =>$aData), '', '');
                            
                            $sReturn    =   "                                                
                                                $('[data-key=BranchId]').remove();
                                                $('[data-key=DeptId]').remove();
                                                $('[data-key=PositionId]').remove();
                                                $('.divPosi').append(\"".trim(preg_replace('/\s\s+/', '', $aDropDown['position']))."\");
                                                $('.divBranch').append(\"".trim(preg_replace('/\s\s+/', '', $aDropDown['branch']))."\");
                                                $('.divDepts').append(\"".trim(preg_replace('/\s\s+/', '', $sDepts))."\");
                                            ";
                            return $sReturn;
                            
                break;

                case 'remove':
                    $aData['ModifyBy']   =   $this->session->userdata('sess_username');
                    $aData['ModifyDate'] =   date("Y-m-d H:i:s");
                    $aData['where']      =   array("AgentTrxId" => $aData['AgentTrxId']);

                    unset($aData['AgentTrxId']);

                    $aGenInfoData   =   $this->hatvclib->createQuery('update', $aData, 'divPerInfo');

                    
                    $sSpName        =   "sp_ExecQuery";

                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aGenInfoData);

                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    $eExecQuery->next_result();
                    $eExecQuery->free_result();

                    if ($sResult == 0) {

                        $sReturn    =   "_systemAlert('system');";

                    } else {
                        $sReturn    =   "
                                            _systemMsg('Application successfully removed.');
                                            window.location = 'applications';
                                        ";
                    }
                    return $sReturn;
                break;

                case 'sendsms':

                        $sMessage               =   $aData['Message'];
                        $aCelNo                 =   $aData['CelNos'];
                        $sSms                   =   $this->hatvclib->sendSms($aCelNo, $sMessage, 'in');
                        // return "console.log('".json_encode($sSms)."')";
                        if ($sSms != 0) {
                            $sReturn    =   "
                                                _systemAlert('Data saved, but failed to send message');
                                            ";
                        } else {
                            $sReturn    =   "
                                            _alertBox('Message Successfuly Sent.'); 
                                            $('input[type=checkbox]').prop('checked', false); $('textarea').val(''); $('#modalMessage').modal('hide'); $('[data-trigger=texts]').addClass('disabled');";
                        } 

                        return $sReturn;
                        
                break;


            }
        }
    }
?>