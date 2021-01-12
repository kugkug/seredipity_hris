<?php
    class Workers_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
            ob_clean();
        } 

        public function proc_workers($sAction, $aData) {
            $sObjRet = array();
            switch ($sAction) {

                case 'endo':
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

                        $sObjRet['return']      = "error";
                        $sObjRet['message']     = $sResult;

                    } else {
                        $sObjRet['return']      = "ok";
                        $sObjRet['message']     = "updated";
                    }

                break;
            }

            return json_encode($sObjRet);
        }
    }

?>