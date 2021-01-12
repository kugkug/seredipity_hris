<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('hatvclib');

    }

    public function index() {
        $this->load->view('home_v');
        
    }
    
    public function proc_home_timer() {

        echo json_encode(array("date" => date("F d, Y"), "time" => date("H:i:s")));
    }
}
?>