<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dtr_summary extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Dtr_Summary_Model');
        } 

        public function index()
        {
            $sPage      =   $this->session->userdata('sess_page');


            $aHtml =  $this->customer->GetDtr($this->session->userdata('sess_username'));
            
            $this->load->view('dtr_summary_v', $aHtml);
        }


        
    }

?>