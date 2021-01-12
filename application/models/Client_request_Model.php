<?php
     class Client_request_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
            ob_clean();
        } 

        public function proc_client_request($sAction, $aData, $sType) {

            switch ($sAction) {

                case 'clientdds':

                    $sReturn    =   "";
                    $aDropDown  =   $this->customer->getClientBranch(array(), '', $aData);
                    $sPosition  =   $this->hatvclib->getPositionList(array(), $aData, array());
                    $sDepts     =   $this->customer->getClientDeptsDd(array('clientid' =>$aData), '', '');
                    
                    $sReturn    =   "
                                        $('[data-key=BranchId]').remove();
                                        $('#divPositions').html('');
                                        $('.divPositions').html(\"".trim(preg_replace('/\s\s+/', '', $sPosition))."\");
                                        $('.divBranch').append(\"".trim(preg_replace('/\s\s+/', '', $aDropDown['branch']))."\");
                                        execFuncs();
                                    ";
                
                break;

                case 'clientrep':

                    $sReturn    =   "";
                    $aClientReps=   $this->hatvclib->getRepresentatives();
                    
                    if (isset($aClientReps[$aData])) {
                        $sReturn    =   "
                                            $('[data-key=ReqContactPerson]').val('".ucwords(mb_strtolower($aClientReps[$aData]['fullname']), 'UTF-8')."');
                                            $('[data-key=ReqContactNumber]').val('".$aClientReps[$aData]['contact']."');
                                            $('[data-key=ReqContactEmail]').val('".$aClientReps[$aData]['email']."');

                                            $('[data-key=ReqContactPerson]').attr('readOnly', true);
                                            $('[data-key=ReqContactNumber]').attr('readOnly', true);
                                            $('[data-key=ReqContactEmail]').attr('readOnly', true);
                                        ";
                    }  else {
                        $sReturn    =   "
                                            $('[data-key=ReqContactPerson]').val('');
                                            $('[data-key=ReqContactNumber]').val('');
                                            $('[data-key=ReqContactEmail]').val('');

                                            $('[data-key=ReqContactPerson]').attr('readOnly', false);
                                            $('[data-key=ReqContactNumber]').attr('readOnly', false);
                                            $('[data-key=ReqContactEmail]').attr('readOnly', false);
                                        ";
                    }
                
                break;

                case 'getcandids':

                    $aRequestInfo       =   $this->customer->procClientRequest($aData);
                    $aReturnData        =   $this->customer->getCandidates($aRequestInfo[0]);

                    $sReturn    =   "
                                        $('.divCandidates').html(\"".trim(preg_replace('/\s\s+/', '', $aReturnData['candidates']))."\");
                                        $('.divApplicants').html(\"".trim(preg_replace('/\s\s+/', '', $aReturnData['applicants']))."\");
                                        $('.divChosen').html(\"".trim(preg_replace('/\s\s+/', '', $aReturnData['chosen']))."\");
                                        _execFuncs();
                                    ";
                break;

                case 'save':
                        // $nPasscCode     =   sprintf("%06d", mt_rand(1, 999999));
                        // $sLink          =   RECRUITMENTURL."?".base64_encode($aData['DataId']."|".trim($nPasscCode));
                        // $aRequestInfo   =   $this->customer->procClientRequest(array("requestid" =>$aData['DataId']) );
                        

                        // $aData['ReqPassCode']   =   $nPasscCode;
                        $aData['EntryBy']   =   $this->session->userdata('sess_username');
                        $aData['EntryBy']   =   $this->session->userdata('sess_username');
                        $aData['EntryDate']   =   date("Y-m-d H:i:s");
                        unset($aData['DataId']);

                        
                        $aQueryData     =   $this->hatvclib->createQuery($sAction, $aData, $sType);
                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aQueryData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        if ($sResult == 0) {
                            $sReturn    =   "
                                                _systemAlert('system');
                                            ";
                        } else {
                            // $sEmail         =   $this->hatvclib->sendEmail($aRequestInfo[0], $sLink);
                            // if ($sEmail != "sent") {
                            //     $sReturn    =   "
                            //                     _systemAlert('Data saved, but failed to send message');
                            //                 ";    
                            // } else {
                                $sReturn    =   "
                                                _systemMsg('saved');
                                                $('input[type=checkbox]').prop('checked', false);
                                                $('.divPositions').html('');
                                                _clearFields('frmData');
                                            ";
                            // }
                            
                        }
                        $eExecQuery->next_result();
                        // $eExecQuery->free_result();

                        

                    break;

                case 'update':
                        // $nPasscCode     =   sprintf("%06d", mt_rand(1, 999999));
                        // $sLink          =   RECRUITMENTURL."?".base64_encode($aData['DataId']."|".trim($nPasscCode));

                        // $aRequestInfo   =   $this->customer->procClientRequest(array("requestid" =>$aData['DataId']) );
                        // $sEmail         =   $this->hatvclib->sendEmail($aRequestInfo[0], $sLink);

                        $aData['ReqPassCode']   =   $nPasscCode;
                        $aData['ModifyBy']      =   $this->session->userdata('sess_username');
                        $aData['ModifyDate']    =   date("Y-m-d H:i:s");
                        $aData['where']         =   array("DataId" => $aData['DataId']);
                        unset($aData['DataId']);             
                        
                        $aQueryData     =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aQueryData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        if ($sResult == 0) {
                            $sReturn    =   "
                                                _systemAlert('system');
                                            ";
                        } else {
                            $sReturn    =   "
                                                _systemMsg('updated');
                                            ";
                        }
                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        

                break;

                 case 'send':
                        $nPasscCode     =   sprintf("%06d", mt_rand(1, 999999));
                        $sLink          =   RECRUITMENTURL."?".base64_encode($aData['DataId']."|".trim($nPasscCode));
                        $aRequestInfo   =   $this->customer->procClientRequest(array("requestid" =>$aData['DataId']) );
                        // return "console.log('".json_encode($aRequestInfo)."');";
                        $aData['ReqPassCode']   =   $nPasscCode;
                        $aData['ModifyBy']      =   $this->session->userdata('sess_username');
                        $aData['ModifyDate']    =   date("Y-m-d H:i:s");
                        $aData['where']         =   array("DataId" => $aData['DataId']);
                        unset($aData['DataId']);             
                        
                        $aQueryData     =   $this->hatvclib->createQuery('update', $aData, $sType);
                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aQueryData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        if ($sResult == 0) {
                            $sReturn    =   "
                                                _systemAlert('system');
                                            ";
                        } else {
                            $sEmail         =   $this->hatvclib->sendEmail($aRequestInfo[0], $sLink);
                            if ($sEmail != "sent") {
                                $sReturn    =   "
                                                _systemAlert('Data saved, but failed to send message');
                                            ";    
                            } else {
                                $sReturn    =   "
                                                    _alertBox('Successfully sent to client for review.');
                                                ";
                            }   
                        }
                        $eExecQuery->next_result();
                        $eExecQuery->free_result();                        

                break;

                case 'sendsms':

                    $aData['ModifyBy']      =   $this->session->userdata('sess_username');
                    $aData['ModifyDate']    =   date("Y-m-d H:i:s");
                    $aData['where']         =   array("DataId" => $aData['DataId']);

                    $sMessage               =   $aData['Message'];
                    $aCelNo                 =   $aData['CelNos'];
                    unset($aData['DataId']);
                    unset($aData['Message']);
                    unset($aData['CelNos']);

                    $aQueryData     =   $this->hatvclib->createQuery('update', $aData, $sType);
                    $sSpName        =   "sp_ExecQuery";
                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aQueryData);
                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    if ($sResult == 0) {
                            $sReturn    =   "
                                                _systemAlert('system');
                                            ";
                    } else {
                        $sSms    =   $this->hatvclib->sendSms($aCelNo, $sMessage);
                        
                        if ($sSms != 0) {
                            $sReturn    =   "
                                            _systemAlert('Data saved, but failed to send message');
                                        ";    
                        } else {
                            $sReturn    =   "_systemMsg('Message Successfuly Sent.'); $('#modalMessage').modal('hide'); $('[data-trigger=texts]').hide();";
                        }   
                    }

                    
                    // $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, 'newreques');
                break;

                case 'delete' :

                    $aClientData      =   $this->hatvclib->createQuery('update', $aData, $sType);
                    
                    $sSpName        =   "sp_ExecQuery";
                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aClientData);
                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    if ($sResult == 0) {
                        $sReturn    =   "
                                            _systemAlert('system');
                                        ";
                    } else {
                        $sReturn    =   "
                                            _systemMsg('removed');
                                            $(sObjData.trparent).fadeOut();
                                        ";
                    }
                    $eExecQuery->next_result();
                    $eExecQuery->free_result();

                break;

                case 'close' :

                    $aClientData      =   $this->hatvclib->createQuery('update', $aData, $sType);
                    
                    $sSpName        =   "sp_ExecQuery";
                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aClientData);
                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    if ($sResult == 0) {
                        $sReturn    =   "
                                            _systemAlert('system');
                                        ";
                    } else {
                        $sReturn    =   "
                                            _infoBox('Request Successfully Completed.');
                                            $(sObjData.trparent).fadeOut();
                                        ";
                    }
                    $eExecQuery->next_result();
                    $eExecQuery->free_result();

                break;
            }

            ob_clean();
            return $sReturn;
        }

        public function proc_dropdowns($aData) {

            $sObjRet        =   array();

            switch ($aData['action']) {
                case 'fetch':
                        
                        $sReturn    =   "";
                        $aDropDown  =   $this->hatvclib->getDropDowns(array());

                        foreach (DROPTYPES as $nKey => $sType) {
                            $sReturn .= "$('.div".ucfirst($sType)."').html('".trim(preg_replace('/\s\s+/', '', $aDropDown[$sType]))."');";
                        }

                        echo $sReturn;
                    break;
                
                default:
                    
                    $sSpName        =   "sp_ExecDropdowns";
                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aData);
                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    if ($sResult != "0") {

                        $sObjRet['return']      = "ok";
                        $sObjRet['message']     = $sResult;

                    } else {
                        $sObjRet['return']      = "error";
                        $sObjRet['message']     = '';
                    }

                    $eExecQuery->next_result();
                    $eExecQuery->free_result();
                    break;
            }
            

            return json_encode($sObjRet);
        }
    }

?>