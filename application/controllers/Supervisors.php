<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Supervisors extends CI_Controller {

		function __construct() {
	        parent::__construct();
	        
	        $this->load->model('Supervisors_Model');

	        ob_clean();
	    }

	    public function proc_supervisors() {

            $aObjRet    =  array();
            $sAction    =  $this->input->post('action');
            $sType      =  $this->input->post('type');

            switch ($sAction) {

                case 'save':
                	$aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                	$sReturn 	=   $this->Supervisors_Model->proc_supersivors($sAction, $aData, $sType);
               	break;

               	case 'edit':
                	$aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                	$sReturn 	=   $this->Supervisors_Model->proc_supersivors($sAction, $aData, '');
               	break;

               	case 'update':
                	$aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                	$sReturn 	=   $this->Supervisors_Model->proc_supersivors($sAction, $aData, $sType);
               	break;

               	case 'delete':
                	$aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
                	$sReturn 	=   $this->Supervisors_Model->proc_supersivors($sAction, $aData, 'supervisors');
               	break;

               	case 'fetch':
                    $sReturn 	=	$this->Supervisors_Model->proc_supersivors($sAction, '', '');
                break;

                case 'clientdds':
                    $aData      =   $this->input->post('data');
                    $sReturn    =   $this->Supervisors_Model->proc_supersivors($sAction, $aData, '');
                break;
            }            

            echo $sReturn;
        }
	}

?>