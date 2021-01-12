<?php
	 class Global_funcs_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
            ob_clean();
        } 

        public function proc_global_funcs($sAction, $aData) {
        	switch ($sAction) {

        		case 'dropcitymuniprov':
        			$aSelect     =   $this->hatvclib->DropDowns($sAction, $aData, '');
        			
                    $aReturn    =   array("prov" => $aSelect);

                    return json_encode($aReturn);
        		break;

        		case 'dropbrgy':
    				return json_encode($this->hatvclib->DropDowns($sAction, $aData, ''));
    			break;

                case 'save':
                    $sObjRet = array();
                    $aGenInfoData   =   $this->hatvclib->createQuery($sAction, $aData, 'tna');
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
                        $sObjRet['message']     = $sResult;
                    }

                    return json_encode($sObjRet);
                break;
    		}
        }

        public function proc_dropdowns($aData, $aRepData) {

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
                    if ($aData['action'] != "addbranch") {
                        $sSpName        =   "sp_ExecDropdowns";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 

                        if ($sResult != "0") {

                            $sObjRet['return']      = "ok";
                            if ($aData['action'] =='drpdel') {
                                $sObjRet['message']     = 'removed';
                            }
                             else {
                                $sObjRet['message']     = 'saved';
                             }

                        } else {
                            $sObjRet['return']      = "error";
                            $sObjRet['message']     = '';
                        }

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();
                        break;
                    } else {
                        $sSpName        =   "sp_ExecDropdowns";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult        =   $eExecQuery->result_array();
                        $sResult        =   $aResult[0]['vFlag']; 


                        if ($sResult != "0") {
                            
                            $aRepData['datakey']     =   $sResult;
                            
                            $eExecQuery->next_result();
                            $eExecQuery->free_result();    

                            $sSpName        =   "sp_ExecDropdowns";
                            $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aRepData);
                            $aResult        =   $eExecQuery->result_array();
                            $sResult        =   $aResult[0]['vFlag'];


                            $eExecQuery->next_result();
                            $eExecQuery->free_result();

                            if ($sResult != "0") {

                                $sObjRet['return']      = "ok";
                                if ($aData['action'] =='drpdel') {
                                    $sObjRet['message']     = 'deleted';
                                }
                                 else {
                                    $sObjRet['message']     = 'saved';
                                 }

                            } else {
                                $sObjRet['return']      = "error";
                                $sObjRet['message']     = '';
                            }

                        } else {
                            $sObjRet['return']      = "error";
                            $sObjRet['message']     = '';
                        }
                    }
            }
            

            return json_encode($sObjRet);
        }
    }

?>