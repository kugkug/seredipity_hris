<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 

    class Auth_Model extends CI_Model {

    /** Return values login
    * 0  = Username Not Found
    * 1  = Success
    * -1 = Wrong Password
    * -2 = Invalid Email
    * -3 = Account Locked
    */

    public function login($sUserName, $sPassWord)
    {
        $vToken         =   md5(date("YmdHis")."".KEYCODE);
        $aData          =   array($sUserName, $this->hatvclib->EncryptPass($sPassWord.$sUserName), $vToken);

        $sSpName        =   "sp_Authenticate";
        $eAuthenticate  =   $this->hatvclib->execQuery($sSpName, $aData);
        $aResult        =   $eAuthenticate->result_array();
        $sResult        =   $aResult[0]['vReturn'];
        $nUserId        =   $aResult[0]['nUserId'];
        $sObjRet        =   array();

        // $oTokenUpdate   =   "CALL sp_Authenticate(?, ?, ?)";
        // $eAuthenticate  =   $this->db->query($oTokenUpdate, $aData);
        // $aResult        =   $eAuthenticate->result_array();
        // $sResult        =   $aResult[0]['vReturn'];
        // $sObjRet        =   array();

        if ($sResult == "0") {
            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Username doesn't exists.";
        }
        else if ($sResult == "-1") {
            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Wrong password";
        }
        else if ($sResult == "-2") {
            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Invalid email Address";
        }
        else if ($sResult == "-3") {

            // $this->hatvclib->sendEmail('login', $sUserName);

            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Account has been locked.";
        }
        else if ($sResult == "-4") {

            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Account has been locked.";
        }
        else if ($sResult == "1") {
            $sObjRet['return']      = "good";
            $sObjRet['message']     = base_url();

            // $this->session->set_userdata('sess_username', $sUserName);
            // $this->session->set_userdata('sess_token', $vToken);
            $this->currentuser->set_username($sUserName);
            $this->currentuser->set_token($vToken);
            $this->currentuser->set_userid($nUserId);
        }
        else
        {
            $sObjRet['return']      = "error";
            $sObjRet['message']     = "Account has been ". $this->hatvclib->EncryptPass($sPassWord.$sUserName);
        }

        // $sObjRet['return']      = "error";
        // $sObjRet['message']     = $this->hatvclib->doEncrypt($sPassWord);
        return json_encode($sObjRet);
    }
}