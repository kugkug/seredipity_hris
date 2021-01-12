<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Summary extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Summary_Model');
        } 

        public function index()
        {
            if (!empty($this->session->userdata('sess_partid')))
            {
                $aSummary      = $this->Summary_Model->proc_summary('get-info','');
                // print_r($aSummary);
                $this->load->view('summary_v', $aSummary);
            }
            else 
            {
                $this->load->view('home_v', array('redirect'=> "yes"));
            } 
        }

        public function genReport(){
            print_r($this->Summary_Model->genReport($this->session->userdata('sess_partid')));
        }
    }
?>