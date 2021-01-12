<?php
    class Applicants_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
            ob_clean();
        } 

        public function proc_applicants($sAction, $aData) {
            $sObjRet = "";
            switch ($sAction) {

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

                        $sObjRet =   "_systemAlert('system');";

                    } else {
                        $sObjRet =   "_systemMsg('updated'); $(sParent).fadeOut();";
                    }

                break;

                case 'view':
                    $sObjRet =  "
                                    $('#modalAppDetails div.divData').html(\"".trim(preg_replace('/\s\s+/', '', $this->customer->GetAppDetails($aData)))."\");
                                    $('#modalAppDetails').modal('show');
                                ";
                break;
            }

            return $sObjRet;
        }
    }

?>