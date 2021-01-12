<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
      
   
    class Company_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        } 

        function proc_dropdown_listing($vAction, $aData){

            $sObjRet =  array();

            switch ($vAction) {
                case 'get-modules':
                        return $this->hatvclib->DropPages();
                    break;
                case 'get-ques':

                        $sObjRet['return'] =  "ok";
                        $sObjRet['message'] =  $this->hatvclib->DropDowns('questions', $aData, '');
                        
                    break;

                case 'get-ans':

                        $aReturn =  $this->hatvclib->GetAnswers($aData);
                        $sObjRet['return'] =  "ok";
                        if (sizeof($aReturn) > 0) {
                            if ($aReturn[0]->ans_type == "range") {
                                $sObjRet['message'] = array('type' => "range", 'answers' => $aReturn);
                            } else {
                                $sTable = "";

                                foreach ($aReturn as $key => $oValue) {
                                    $sTable .=   '<tr>
                                                    <td><input type="text" name="txtOptions" id="txtOptions" value="'.$oValue->ans_data.'" class="form-control input-sm" readOnly></td>
                                                    <td>
                                                        <input type="text" name="txtOrderNo" id="txtOrderNo" class="form-control input-sm" value="'.$oValue->ans_order.'">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger btn-remove">
                                                            <i class="fa fa-times" title="Remove"></i>
                                                        </button>
                                                    </td>
                                                </tr>';
                                }

                                $sObjRet['message'] = array('type' => "option", 'answers' => $sTable);
                            }
                        } else {
                            $sObjRet['message'] = "";
                        } 

                        
                        
                    break;

                case 'save':
                case 'savebatch':

                        $aDatas         =  $this->hatvclib->createQuery($vAction, $aData, 'drpans');
                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDatas);
                        $aResult        =   $eExecQuery->result_array();
                        
                        $sResult        =   $aResult[0]['vFlag'];                         

                        if ($sResult == 0) {
                            $sObjRet['return']      = "error";
                            $sObjRet['message']     = $sResult;
                        }
                        else 
                        {
                            $sObjRet['return']      = "ok";
                            $sObjRet['message']     = "saved";
                        }
                        

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();
                    break;

                case 'delete':

                        $aDatas         =  $this->hatvclib->createQuery($vAction, $aData, 'drpans');
                        
                        $sSpName        =   "sp_ExecQuery";
                        $eExecQuery     =   $this->hatvclib->execQuery($sSpName, $aDatas);
                        $aResult        =   $eExecQuery->result_array();
                        
                        $sResult        =   $aResult[0]['vFlag'];
                        

                        if ($sResult == 0) {
                            $sObjRet['return']      = "error";
                            $sObjRet['message']     = $sResult;
                        }
                        else 
                        {
                            $sObjRet['return']      = "ok";
                            $sObjRet['message']     = "saved";
                        }

                        $eExecQuery->next_result();
                        $eExecQuery->free_result();

                        return $sObjRet;
                        
                    break;

            }

            return json_encode($sObjRet);
        }
    }
?>