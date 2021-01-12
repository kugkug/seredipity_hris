<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Workers extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Workers_Model');

            ob_clean();
        } 


        public function proc_workers() {

            $sReturn =  "";
            $sAction =  $this->input->post('action');

            switch ($sAction) {
                case 'remove':
	                    $aData      =   $this->hatvclib->JsonToArray($this->input->post('data'));
	                    $sReturn    =   $this->Workers_Model->proc_workers($sAction, $aData);
	            break;

            }            
            echo $sReturn;
        }

    }
?>