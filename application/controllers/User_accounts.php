<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class User_accounts extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('User_accounts_Model');

            ob_clean();
        } 
        
        public function index()
        {
            $this->load->view('user_accounts_v');
        }

        public function proc_accounts()
        {
            $sObjRet    =   array();
            $vAction    =   $this->input->post('action');
            $dEventDate =   date("Y-m-d H:i:s");
            $dDate      =   date("Ymd", strtotime($dEventDate));
            $aPrevStatus=   array();
            $aNewStatus =   array();
            $aLogInfo   =   array();
            $sPage      =   $this->session->userdata('sess_page');

            switch ($vAction) {
                case 'save':
                    
                    $aData  =   array(
                                "Title"         => $this->input->post('txtTitle'),
                                "FirstName"     => $this->input->post('txtFname'),
                                "SurName"       => $this->input->post('txtLname'), 
                                "Email"         => $this->input->post('txtEmail'), 
                                "UserName"      => $this->input->post('txtUname'), 
                                "PassWord"      => $this->hatvclib->EncryptPass($this->input->post('txtPword')."".$this->input->post('txtUname')),
                                "AccessType"    => $this->input->post('txtAccess'), 
                                "Status"        => "active"
                        );

                        $aLogInfo['action_taken']   =   "save";
                        $aLogInfo['data']           =   $aData;


                    break;

                case 'fetch':
                        $aData =    array($this->input->post('txtSearch'), $this->input->post('txtFilter'));
                        // echo $this->Accounts_Model->proc_account($vAction, $aData);
                break;

                case 'edit':
                        $aData =    array("id" => $this->input->post('id'));

                        // echo json_encode($aData);
                        // return;
                break;

                case 'update':
                        if ($this->input->post('val') == "a" || $this->input->post('val') == "d" || $this->input->post('val') == "r" || $this->input->post('val') == "u")
                        {
                            switch ($this->input->post('val')) {
                                case 'a': $sStatus    = "active"; break;
                                case 'd': $sStatus    = "deactivated"; break;
                                case 'r': $sStatus    = "removed"; break;
                                case 'u': $sStatus    = "active"; break;
                            }
                            
                            $sPassword  = $this->input->post('txtPword');
                        }
                        else
                        {
                            $sStatus    =  "k";
                            $sPassword  =  $this->hatvclib->genRandomString();
                        }


                        $aData  =   array(
                                        "id"            => $this->input->post('txtAcctId'),
                                        "Title"         => $this->input->post('txtTitle'),
                                        "FirstName"     => $this->input->post('txtFname'), 
                                        "SurName"       => $this->input->post('txtLname'), 
                                        "Email"         => $this->input->post('txtEmail'), 
                                        "Pword"         => $this->hatvclib->EncryptPass($sPassword."".$this->input->post('txtUname')),
                                        "AccessType"    => $this->input->post('txtAccess'),
                                        "Status"        => $sStatus,
                                        "Password"      => $sPassword    
                                    );


                    break;

                case 'update_batch':
                        if ($this->input->post('val') == "d")
                        {
                            $sStatus =  "deactivated";
                        }
                        else if ($this->input->post('val') == "r")
                        {
                            $sStatus =  "removed";
                        }
                        else
                        {
                            $sStatus =  "k";   
                        }

                        if ($sStatus == "k")
                        {
                            $aData      =   array();
                            $aAcctIds   =   explode(",", $this->input->post('acctids'));

                            foreach ($aAcctIds as $key => $nAcctId) {
                                $sNewPass   =   $this->hatvclib->genRandomString();
                                $aData[$nAcctId] =  $sNewPass;
                            }                        
                        }
                        else
                        {
                            $aData  =   array('autoids' => $this->input->post('acctids'), 'status' => $sStatus, 'pword' => '');
                        }

                    break;
                
                case 'updatepass' : 
                        $aData =    $this->hatvclib->JsonToArray($this->input->post('data'));
                break;

                default:
                    # code...
                    break;
            }

            echo $this->User_accounts_Model->proc_account($vAction, $aData);
        }   
    }
?>