<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Client_request extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Client_request_Model');

            ob_clean();
        } 


        public function proc_client_request() {

            $sReturn    =  "";
            $sAction    =  $this->input->post('action');
            $sType      =  $this->input->post('type');

            
            switch ($sAction) {
	            case 'clientdds':
                    $aData   =   $this->input->post('data');
                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, '');
                break;

                case 'clientrep':
                    $aData   =   $this->input->post('data');
                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, '');
                break;

                case 'getcandids':
                    $aData   =   array('DataId' => $this->input->post('requestid'));
                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, '');
                break;


                case 'save':
                    $aData   =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    $aData['ReqPositions']      =   $this->input->post('positions');
                    $aData['ReqNature']         =   $this->input->post('reqnature');
                    $aData['ReqQualifications'] =   $this->input->post('reqqualify');
                    $aData['ReqStatus']         =   'NEW';
                    
                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, $sType);
                break;

                case 'update':
                    $aData   =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    $aData['ReqPositions']      =   $this->input->post('positions');
                    $aData['ReqNature']         =   $this->input->post('reqnature');
                    $aData['ReqQualifications'] =   $this->input->post('reqqualify');
                    $aData['ReqStatus']         =   'NEW';
                    
                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, $sType);
                break;

                case 'send':
                    $aData['DataId']            =   $this->input->post('requestid');
                    $aData['ReqCandidates']     =   $this->input->post('data');
                    $aData['ReqStatus']         =   'approved';

                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, 'newreques');
                break;

                case 'sendsms':                    
                    $aData['CelNos']            =   $this->hatvclib->JsonToArray(json_decode($this->input->post('data')));
                    $aData['DataId']            =   $this->input->post('requestid');
                    $aData['Message']           =   $this->input->post('message');
                    $aData['ReqStatus']         =   'approved';

                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, 'newreques');
                break;

                case 'delete' :

                    $aData['DeleteBy']   =   $this->session->userdata('sess_username');
                    $aData['DeleteDate'] =   date("Y-m-d H:i:s");
                    $aData['where']      =   array("DataId" => $this->input->post('data'));
                    unset($aData['clientid']);

                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, $sType);
                break;

                case 'close' :

                    $aData['ModifyBy']   =   $this->session->userdata('sess_username');
                    $aData['ModifyDate'] =   date("Y-m-d H:i:s");
                    $aData['ReqStatus']  =   'completed';
                    $aData['where']      =   array("DataId" => $this->input->post('data'));
                    unset($aData['clientid']);

                    $sReturn =   $this->Client_request_Model->proc_client_request($sAction, $aData, $sType);
                break;


            }
            print_r($sReturn);
        }
    }
?>