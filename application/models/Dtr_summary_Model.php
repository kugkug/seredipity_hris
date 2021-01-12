<?php
    defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class Dtr_summary_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        } 

        public function proc_dtr_summary($vAction, $aData) {

        	return json_encode(array("action" => $vAction));
        }
    }
?>