<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Executor extends CI_Controller {
        function __construct() { 
            parent::__construct();
            ob_clean();
        } 


        public function proc_executor() {

            $aObjRet    =  array();
            $sAction    =  $this->input->post('action');
            $sType      =  $this->input->post('type');

            switch ($sAction) {

                case 'save':
                    $sData          =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    unset($sData['DataId']);

                    
                    $aDeptList      =   $this->hatvclib->JsonToArray(json_decode($this->input->post('deptlist')));                    
                    $aClientData    =   $this->hatvclib->createQuery($sAction, $sData, $sType);

                    $sSpName        =   "sp_ExecQuery";
                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aClientData);

                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    $eExecQuery->next_result();
                    $eExecQuery->free_result();

                    if ($sResult == 0) {
                        $aObjRet['return']      = "error";
                        $aObjRet['message']     = $sResult;
                    } else {

                        $aDeptNames     =   array();
                        foreach ($aDeptList as $nKey => $sDeptName) {
                            $aDeptNames[]   =   "('".$sData['ClientId']."', '".$sDeptName."')";
                        }

                        $oDeptData      =   array('cols' => array('client_id', 'dept_name'), 'vals' => $aDeptNames);
                        $aDeptData      =   $this->hatvclib->createQuery('savebatch', $oDeptData, 'dept');

                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDeptData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 

                        if ($sResult == 0) {
                            
                            $aObjRet['return']      = "error";
                            $aObjRet['message']     = $sResult;

                        } else {

                            $aObjRet['return']      = "ok";
                            $aObjRet['message']     = "saved";
                        }

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();
                    }

                break;


                case 'update':
                    $sSpName        =   "sp_ExecQuery";

                    $aData                  =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    $aDeptList              =   $this->hatvclib->JsonToArray(json_decode($this->input->post('deptlist')));

                    $aData['ModifyBy']      =   $this->session->userdata('sess_username');
                    $aData['ModifyDate']    =   date("Y-m-d H:i:s");
                    $aData['where']         =   array("DataId" => $aData['DataId']);

                    unset($aData['DataId']);
                    

                    $aClientData    =   $this->hatvclib->createQuery($sAction, $aData, $sType);

                    $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aClientData);
                    $aResult        =   $eExecQuery->result_array();
                    $sResult        =   $aResult[0]['vFlag']; 

                    $eExecQuery->next_result();
                    $eExecQuery->free_result();

                    if ($sResult == 0) {
                        $aObjRet['return']      = "error";
                        $aObjRet['message']     = $sResult;
                    } else {

                        $aDelData['client_id'] =  $aData['ClientId'];
                        $aDeptDelData   =   $this->hatvclib->createQuery('single_delete', $aDelData, 'departments');

                        // echo json_encode($aDeptDelData);
                        // die();

                        
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDeptDelData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        if ($sResult == 0) {
                            $aObjRet['return']      = "error";
                            $aObjRet['message']     = $sResult;
                        } else {


                            $aDeptNames     =   array();
                            foreach ($aDeptList as $nKey => $sDeptName) {
                                $aDeptNames[]   =   "('".$aData['ClientId']."', '".$sDeptName."')";
                            }

                            if (sizeof($aDeptNames) > 0 ) {
                                $oDeptData      =   array('cols' => array('client_id', 'dept_name'), 'vals' => $aDeptNames);
                                $aDeptData      =   $this->hatvclib->createQuery('savebatch', $oDeptData, 'dept');

                                $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDeptData);
                                $aResult        =   $eExecQuery->result_array();
                                $sResult        =   $aResult[0]['vFlag']; 

                                if ($sResult == 0) {
                                    
                                    $aObjRet['return']      = "error";
                                    $aObjRet['message']     = $sResult;

                                } else {

                                    $aObjRet['return']      = "ok";
                                    $aObjRet['message']     = "updated";
                                }
                            } else {
                                $aObjRet['return']      = "ok";
                                $aObjRet['message']     = "updated";
                            }

                            $eExecQuery->next_result();
                            $eExecQuery->free_result();
                        }
                    }

                break;

                case 'delete' :

                        $aData['DeleteBy']   =   $this->session->userdata('sess_username');
                        $aData['DeleteDate'] =   date("Y-m-d H:i:s");
                        $aData['where']      =   array("ClientId" => $this->input->post('data'));
                        unset($aData['clientid']);

                        $aClientData      =   $this->hatvclib->createQuery($sAction, $aData, 'newclient');
                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aClientData);
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

                break;

            }
            ob_clean(); 
            echo json_encode($aObjRet);
        }
    }
?>