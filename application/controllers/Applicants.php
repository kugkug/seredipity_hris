<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Applicants extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Applicants_Model');

            ob_clean();
        } 


        public function proc_applicants() {

            $sReturn =  "";
            $sAction =  $this->input->post('action');

            switch ($sAction) 
            {
                case 'remove':
	                    $aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));                        
	                    $sReturn    =   $this->Applicants_Model->proc_applicants($sAction, $aData);
	            break;

                case 'view':
                        $aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                        $sReturn    =   $this->Applicants_Model->proc_applicants($sAction, $aData);
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