<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class General_information extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('General_information_Model');

            ob_clean();
        } 
        public function proc_general_information() {

            $sReturn    =  "";
            $sAction    =  $this->input->post('action');
            $sType      =  $this->input->post('type');

            switch ($sAction) {
                case 'dropcitymuniprov':
                        $aData      =   array('citymuni', $this->input->post('data'));
                        $sReturn    =   $this->General_information_Model->proc_general_information($sAction, $aData, '');

                    break;

                case 'dropbrgy':
                        $aData   =  array('brgy', $this->input->post('data'));
                        $sReturn =   $this->General_information_Model->proc_general_information($sAction, $aData, $sType);
                    break;

                case 'getsup':
                        $aData   =  $this->hatvclib->JsonToArray($this->input->post('data'));
                        $sReturn =   $this->General_information_Model->proc_general_information($sAction, $aData, $sType);
                    break;

                case 'save':
                    
                    // $aData   =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    // $sReturn =   $this->General_information_Model->proc_general_information($sAction, $aData, $sType);

                    if ($sType == "divPerInfo" || $sType == "divReq") {
                        $aData   =   $this->hatvclib->JsonToArray($this->input->post('data'));
                        $sReturn =   $this->General_information_Model->proc_general_information('update', $aData, $sType);
                    } else {                        
                        $aData   =   json_decode($this->input->post('data'));                  
                        $sReturn =   $this->General_information_Model->proc_general_information('savebatch', $aData, $sType);
                    }
                    
                break;

                case 'clientdds':
                    $aData   =   $this->input->post('data');
                    $sReturn =   $this->General_information_Model->proc_general_information($sAction, $aData, '');
                break;

                case 'remove':
                    $aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                    $sReturn    =   $this->General_information_Model->proc_general_information($sAction, $aData, $sType);
                break;

                case 'sendsms':
                    $aData['CelNos']   =   $this->hatvclib->JsonToArray(json_decode($this->input->post('data')));


                    $aData['Message']  =   $this->input->post('message');

                    $sReturn =   $this->General_information_Model->proc_general_information($sAction, $aData, '');
                break;
            }
            ob_clean();
            echo $sReturn;
        }
    }
?>