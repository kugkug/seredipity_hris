<?php
    defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class User_accounts_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        } 
        
        public function proc_account($vAction, $aData)
        {
            $sObjRet        =   array();
            $sTable         =   "";
            $aLogInfo       =   array("action_taken" => $vAction, "data" => $aData);
            $sPage          =   $this->session->userdata('sess_page');
            
            switch ($vAction) {
                case "save":
                        $aPrevStatus    =   array("prevstatus" => "new account");
                        $aNewStatus     =   array("newstatus" => "new account");
                        $aLogInfo       =   array("data" => $aData);

                        $sSpName                =   "sp_NewAccount";
                        $eNewAccounts           =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult                =   $eNewAccounts->result_array();

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
                    break;

                case "fetch":
                        $aPrevStatus    =   array("prevstatus" => "fetch accounts");
                        $aNewStatus     =   array("newstatus" => "fetch accounts");

                        $sStatus        =   "";

                        $sSpName                =   "sp_GetAccounts";
                        $eGetAccounts           =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult['result']      =   $eGetAccounts->result();
                        
                        $sTable.=   "<table id='tblData' class='table table-striped table-hover table-data'>";
                        $sTable.=   "<thead>
                                        <tr> 
                                            <th>
                                                <label>
                                                    <input type='checkbox'  name='chkCheckAll' id='chkCheckAll' value='all' class='chkData'>
                                                </label>
                                            </th>
                                            </th>
                                            <th>Username </th>
                                            <th>Status </th>
                                            <th>Name </th> 
                                            <th>Access </th> 
                                            <th>Last Login </th> 
                                        </tr>
                                    </thead>";
                                    // <th>First Name </th>
                        foreach ($aResult['result'] as $row)
                        {
                            $vStatus    =   $row->LoginFailedAttempts >= 3 ? "locked" : $row->Status; 
                            $sTable.=   "<tr>
                                            <td>
                                                <label>
                                                    <input type='checkbox' name='chkUser_".$row->id."' id='chkUser_".$row->id."' value='".$row->id."' class='chkData'>
                                                </label>
                                            </td>
                                            
                                            
                                            <td>".$row->Username."</td>
                                            <td>".ucfirst(strtolower($vStatus))."</td> 
                                            <td>".ucfirst($row->Firstname)." ".ucfirst($row->Surname)."</td> 

                                            
                                            <td>".ACCESSLEVEL[$row->AccessType]."</td> 
                                            <td>".$row->LastLogin."</td> 
                                            
                                        </tr>";
                        }
                        $sTable.=   "</table>";
                        // <td>".$row->EmailAddress."</td> 


                        $sObjRet['return']      = "ok"; 
                        $sObjRet['message']     = $sTable;
                        // $sObjRet['message']     = $aResult['result'];
                        
                    break;

                case "edit":
                        $sResults       =   array();
                        $aPrevStatus    =   array("prevstatus" => "fetch accounts");
                        $aNewStatus     =   array("newstatus" => "fetch accounts");


                        $sSpName            =   "sp_EditAccount";
                        $eGetAccounts       =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult['result']  =   $eGetAccounts->result();
                        $row                =   $aResult['result'][0];

                        // $oGetAccounts    =   "CALL sp_EditAccount(?)";
                        // $eGetAccounts        =   $this->db->query($oGetAccounts, $aData);
                        // $aResult['result']  =   $eGetAccounts->result();
                                          
                        $sResults['txtAcctId']      =   $row->id;
                        $sResults['txtAccess']      =   $row->AccessType;
                        $sResults['txtFname']       =   $row->Firstname;
                        $sResults['txtPword']       =   $row->Password;
                        $sResults['txtEmail']       =   $row->EmailAddress;
                        $sResults['txtConPword']    =   $row->Password;
                        $sResults['txtStatus']      =   $row->LoginFailedAttempts >= 3 ? "locked" : $row->Status;
                        $sResults['txtLname']       =   $row->Surname;
                        $sResults['txtTitle']       =   $row->Title;
                        $sResults['txtUname']       =   $row->Username;

                        $this->session->set_userdata("sess_prestat", $sResults);
                        $this->session->set_userdata("sess_editid",$row->id);

                        $sObjRet['return']      = "ok";
                        $sObjRet['message']     = $sResults;
                        
                    break;
                    
                    case "update":
                        $sNewPass   =   $aData["Password"];
                        unset($aData["Password"]);

                        $sSpName            =   "sp_UpdateAccount";
                        $eUpdateAccounts    =   $this->hatvclib->execQuery($sSpName, $aData);
                        $aResult['result']  =   $eUpdateAccounts->result();
                        $row                =   $aResult['result'][0];

                                                
                        $sResults['txtAccess']      =   $row->AccessType;
                        $sResults['txtFname']       =   $row->Firstname;
                        $sResults['txtPword']       =   $row->Password;
                        $sResults['txtStatus']      =   $row->LoginFailedAttempts >= 3 ? "locked" : $row->Status;
                        $sResults['txtLname']       =   $row->Surname;
                        $sResults['txtEmail']       =   $row->EmailAddress;
                        $sResults['txtTitle']       =   $row->Title;
                        $sResults['txtUname']       =   $row->Username;


                        $aNewStatus =   $sResults;

                        if ($aData['Status'] == "k")
                        {
                            $sSendNotif =   $this->hatvclib->sendEmail('unlock', array('fname' => $sResults['txtFname'], 'email' => $sResults['txtEmail'], 'pword' => $sNewPass));

                            // if ($sSendNotif == "sent")
                            // {
                            $sName  =   $sResults['txtFname']." ".$sResults['txtLname'];

                            $sHtml  =   '<table cellpadding="0" cellspacing="0" border ="1">
                                            <tr>
                                                <td width="200px;">
                                                    Name
                                                </td>
                                            
                                                <td>
                                                    Email Address
                                                </td>
                                                <td>
                                                    Status
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="200px;">
                                                    '.ucwords(strtolower($sName)).'
                                                </td>
                                            
                                                <td width="300px;">
                                                    '.$sResults['txtEmail'].'
                                                </td>

                                                <td>
                                                    '.ucfirst($sSendNotif).'
                                                </td>
                                            </tr>
                                        </table>';

                            $sAdminSend =   $this->hatvclib->sendEmail('unlockadmin', $sHtml);

                            $eUpdateAccounts->next_result();
                            $eUpdateAccounts->free_result();
                        }

                        $sObjRet['return']      = "ok";
                        $sObjRet['message']     = "updated";
                        
                    break;

                    case "update_batch":

                        $aNewData   =   array();

                        if (!array_key_exists('status', $aData))
                        {
                            $sHtml  =   '<table cellpadding="0" cellspacing="0" border ="1"> <tr> <td width="200px;"> Name </td> <td> Email Address </td> <td> Status </td> </tr>';

                            foreach ($aData as $nAcctId => $sPass) {

                                $aNewData['autoids']    = $nAcctId;
                                $aNewData['status']     = 'k';

                                $sSpName            =   "sp_EditAccount";
                                $eGetAccounts       =   $this->hatvclib->execQuery($sSpName, array('autoid' => $nAcctId));
                                $aResult['result']  =   $eGetAccounts->result();
                                $row                =   $aResult['result'][0];

                                $aNewData['pword']  =   $this->hatvclib->EncryptPass($sPass.$row->Username);

                                $eGetAccounts->next_result();
                                $eGetAccounts->free_result();

                                $sSpName            =   "sp_UpdateBatchAccounts";
                                $eUpdateAccounts    =   $this->hatvclib->execQuery($sSpName, $aNewData);
                                $aResult['result']  =   $eUpdateAccounts->result();
                                $res                =   $aResult['result'][0];
                                
                                $sName          =   $res->Firstname." ".$res->Surname;  
                                $sSendNotif     =   "";
                                $sSendNotif     =   $this->hatvclib->sendEmail('unlock', array('fname' => $res->Firstname, 'email' => $res->EmailAddress, 'pword' => $sPass));

                                $sHtml          .= '<tr> <td width="200px;"> '.ucwords(strtolower($sName)).' </td> <td width="300px;"> '.$res->EmailAddress.' </td> <td> '.ucfirst($sSendNotif).' </td> </tr>';

                                $eUpdateAccounts->next_result();
                                $eUpdateAccounts->free_result();
                            }
                            $sHtml  .= "</table>";

                            $sAdminSend =   $this->hatvclib->sendEmail('unlockadmin', $sHtml);
                            $sObjRet['return']  =   "ok";
                            $sObjRet['message'] =   "updated";
                        }
                        else
                        {
                            $sSpName            =   "sp_UpdateBatchAccounts";
                            $eUpdateAccounts    =   $this->hatvclib->execQuery($sSpName, $aData);
                            $aResult['result']  =   $eUpdateAccounts->result();

                            $eUpdateAccounts->next_result();
                            $eUpdateAccounts->free_result();

                            $sObjRet['return']  =   "ok";
                            $sObjRet['message'] =   "updated";
                        }
                        
                    break;

                case 'updatepass':

                    // $aData          =   array($sUserName, $this->hatvclib->EncryptPass($sPassWord.$sUserName), $vToken);
                    // 
                    $sUname     =   $this->currentuser->get_username();
                    $sCurPass   =   $aData['CurPass'];
                    $sNewPass   =   $aData['NewPass'];
                    $sConPass   =   $aData['ConPass'];

                    if ($sNewPass != $sConPass) {
                        echo "_systemAlert('Passwords did not matched');";
                    } else {
                        $sSpName            =   "sp_ChangePassword";
                        $eUpdateAccounts    =   $this->hatvclib->execQuery($sSpName, array('uname' => $sUname, 'curpass' => $this->hatvclib->EncryptPass($sCurPass.$sUname), 'newpass' => $this->hatvclib->EncryptPass($sNewPass.$sUname)));
                        $aResult            =   $eUpdateAccounts->result_array();


                        $eUpdateAccounts->next_result();
                        $eUpdateAccounts->free_result();

                        if ($aResult[0]['vReturn'] == '0') {

                            echo "_systemAlert('Invalid current password');";
                        } else {
                            echo "_systemMsg('updated'); $('input[type=password]').val('');";
                        }
                    }

                    return;
                break;

                default:

                    break;
            }
            
            return json_encode($sObjRet);
        }
    }
?>