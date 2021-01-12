<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('Auth_Model');
    }

	public function index()
	{
        $sSessUname =   $this->session->userdata('sess_username');
        if (isset($sSessUname))
        {
            redirect("home");
        }
        else
        {
            $this->load->view('login');
        }

	}

    public function get_page() {

        $sCurrPage  =   $this->session->userdata('sess_page');

        $sModule    =   trim($this->input->post('module'));
        $sModData   =   trim($this->input->post('moddata'));
        $sModTitle  =   trim($this->input->post('modtitle'));

        if (!empty($sModData)) {
            $this->session->set_userdata("sess_secdata", $sModData);
        }

        echo $this->Hatvcapi_Model->get_page($sModule, $sModData, $sCurrPage, $sModTitle);

    }

    public function logout() {

        $this->session->unset_userdata('sess_username');
        $this->session->unset_userdata('sess_page');
        $this->session->unset_userdata('sess_pagetitle');
        
        redirect('/' ,'refresh');
        exit;

    }

    public function login() {
        
        $sUname =  $this->input->post('txtUserName');
        $sPword =  $this->input->post('txtPassWord');

        echo $this->Auth_Model->login($sUname, $sPword);
        // redirect('/' ,'refresh');
    }
}

?>
