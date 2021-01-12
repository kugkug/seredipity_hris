<?php
    defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class Supervisors_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        }

        public function proc_supersivors($sAction, $aData ,$sType) {

        	switch ($sAction) {
        		case 'save':

                        $aData['EntryBy']   =   $this->session->userdata('sess_username');
                        $aData['EntryDate']   =   date("Y-m-d H:i:s");
                        unset($aData['DataId']);
                        
                        $aSuppData      =   $this->hatvclib->createQuery($sAction, $aData, $sType);
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aSuppData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        if ($sResult == 0) {
                            $aObjRet['return']      = "error";
                            $aObjRet['message']     = $sResult;

                        } else {

                             $aData  =   array(
                                "Title"         => '',
                                "FirstName"     => mb_strtolower($aData['SupFname'], 'UTF-8'),
                                "SurName"       => mb_strtolower($aData['SupLname'], 'UTF-8'), 
                                "Email"         => '', 
                                "UserName"      => "sup_".mb_strtolower($aData['SupLname'], 'UTF-8'), 
                                "PassWord"      => $this->hatvclib->EncryptPass(date("mY", strtotime($aData['SupBday'])).""."sup_".mb_strtolower($aData['SupLname'], 'UTF-8')),
                                "AccessType"    => '2',
                                "Agent_Trx_Id"  => md5(date("Ymdhisu")),
                                "Status"        => "active"
                                );

                            $this->customer->createUserAccnt($aData);

                                $aLogInfo['action_taken']   =   "save";
                                $aLogInfo['data']           =   $aData;


                            $aObjRet['return']      = "ok";
                            $aObjRet['message']     = "saved";
                        }
                        return json_encode($aObjRet);

        			break;

                case 'edit':
                        
                        $aReturn        =   array();
                        $sSpName        =   "sp_GetSupervisors";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult        =   $eExecQuery->result_array();
                        $vResult        =   $aResult[0]; 
                        
                        $eExecQuery->next_result();
                        $eExecQuery->free_result();
                        $aReturn['return']  =   "edit";

                        $aDropDown  =   $this->customer->getClientBranch(array(), '', $vResult['client_id']);
                        $sDepts     =   $this->customer->getClientDeptsDd(array('clientid' => $vResult['client_id']), '', '');
                        
                        $aReturn['message'][]   =   "$('[data-key=BranchId]').remove();";
                        $aReturn['message'][]   =   "$('[data-key=DeptId]').remove();";
                        $aReturn['message'][]   =   "$('.divBranch').append(\"".trim(preg_replace('/\s\s+/', '', $aDropDown['branch']))."\");";
                        $aReturn['message'][]   =   "$('.divDepts').append(\"".trim(preg_replace('/\s\s+/', '', $sDepts))."\");";

                        foreach ($vResult as $sCol => $sValue) {

                            $aReturn['message'][] =   "$('[data-key=".$this->datakeys->getValue($sCol)."]').val('".$sValue."')";
                        }

                        return json_encode($aReturn);

                    break;

                case 'update':

                        $aData['ModifyBy']   =   $this->session->userdata('sess_username');
                        $aData['ModifyDate'] =   date("Y-m-d H:i:s");
                        $aData['where']      =   array("DataId" => $aData['DataId']);

                        unset($aData['DataId']);

                        $aSuppData      =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aSuppData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        if ($sResult == 0) {
                            $aObjRet['return']      = "error";
                            $aObjRet['message']     = $sResult;

                        } else {

                            $aObjRet['return']      = "ok";
                            $aObjRet['message']     = "updated";
                        }
                        return json_encode($aObjRet);

                    break;

                case 'delete':

                        $aData['DeleteBy']   =   $this->session->userdata('sess_username');
                        $aData['DeleteDate'] =   date("Y-m-d H:i:s");
                        $aData['where']      =   array("DataId" => $aData['supid']);

                        unset($aData['supid']);

                        $aSuppData      =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aSuppData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        if ($sResult == 0) {
                            $aObjRet['return']      = "error";
                            $aObjRet['message']     = $sResult;

                        } else {

                            $aObjRet['return']      = "ok";
                            $aObjRet['message']     = "removed";
                        }
                        return json_encode($aObjRet);

                    break;


                case 'fetch':

                        $sReturn    =   "";
                        $aDropDown  =   $this->customer->getSuppList(array("sup_id" => ''));
                        $sReturn    =   "$('.divSup').html(\"".trim(preg_replace('/\s\s+/', '', $aDropDown))."\");";

                        return $sReturn;
                        
                    break;

                case 'clientdds':

                        $sReturn    =   "";
                        $aDropDown  =   $this->customer->getClientBranch(array(), '', $aData);
                        $sDepts     =   $this->customer->getClientDeptsDd(array('clientid' =>$aData), '', '');
                        
                        $sReturn    =   "
                                            $('[data-key=BranchId]').remove();
                                            $('[data-key=DeptId]').remove();
                                            $('.divBranch').append(\"".trim(preg_replace('/\s\s+/', '', $aDropDown['branch']))."\");
                                            $('.divDepts').append(\"".trim(preg_replace('/\s\s+/', '', $sDepts))."\");
                                        ";

                        return $sReturn;
                        
                    break;
        	}          

        }
    }
?>