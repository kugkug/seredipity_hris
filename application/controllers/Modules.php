<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules extends CI_Controller {

    private $aModules;
    private $sUname;
    public function __construct() {
        parent::__construct();
        // $this->load->library('hatvclib');


        $this->aModules = $this->hatvclib->get_user_modules();
        $this->sUname   = $this->session->userdata('sess_username');

    }

    public function index() {
        echo "Forbidden Access";
    }

    public function home() {
        $aHtml                  =   $this->aModules;
        $aHtml['user']          =   $this->sUname;
        $aHtml['title']         =   '<i class="fa fa-home" style="font-size: 24px !important;"></i> Dashboard';
        $aHtml['headtitle']     =   "Dashboard";

        $aHtml['datacnt']       =   $this->hatvclib->getDashboard();
        $aViewData              =   array("module" => $this->load->view("shared/home_v", $aHtml, TRUE));

        $this->load->view('devop/main', $aViewData);
    }

    public function applications() {

        // $aDropDowns             =   $this->hatvclib->getDropDownsDd(array(), '');
        $sSessUname             =   $this->session->userdata('sess_username');
        $aHtml                  =   $this->hatvclib->get_user_modules();

        $aHtml['headtitle']     =   "Applicants";
        $aHtml['user']          =   $sSessUname;

        $aHtml['employees']     =   $this->customer->GetApplicantList();
        $aHtml['clients']       =   $this->customer->getClientsDd(array('client_id' => ''), '');
        
        $aHtml['title']         =   '<i class="fa fa-users" style="font-size: 24px !important;"></i> Applicants';
        $aHtml['appstat']       =   $this->hatvclib->DropAppStat('AppstatId', '');
        

        $aViewData = array("module" => $this->load->view("shared/applicants_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }


    public function deployment() {

        $sSessUname =   $this->session->userdata('sess_username');
        $aHtml  =   $this->hatvclib->get_user_modules();
        
        $aHtml['headtitle']     =   "Deployment";
        $aHtml['user'] = $sSessUname;
        $aHtml['title'] = '<i class="fa fa-users" style="font-size: 24px !important;"></i> Deployment';

        $aViewData = array("module" => $this->load->view("shared/user_accounts_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function workers() {

        $sSessUname     =   $this->session->userdata('sess_username');
        $aHtml          =   $this->hatvclib->get_user_modules();

        $aHtml['headtitle']     =   "Employees";
        $aHtml['user']          = $sSessUname;
        $aHtml['employees']     = $this->customer->GetEmployeeList();
        $aHtml['title']         = '<i class="fa fa-users" style="font-size: 24px !important;"></i> Employees';
        

        $aViewData = array("module" => $this->load->view("shared/workers_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

     public function workerview() {

        $aUrl               =   parse_url($_SERVER['REQUEST_URI']);
        $vTrxId             =   $aUrl['query'];

        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();

        $aHtml['headtitle'] =   "Employees";
        $aHtml['user']      = $sSessUname;
        $aHtml['employee']  = $this->customer->GetEmployeeInfo(array('trxid' => $vTrxId));
        

        $aHtml['boxheader'] =   $aHtml['employee']['agent_status'] == "deployed" ? "box-success" : "box-danger";
        $sHref              =   $aHtml['employee']['agent_status'] == "deployed" ? "workers" : "applications";

        $aHtml['title']     = '<i class="fa fa-users" style="font-size: 24px !important;"></i> Employees <small class="pull-right" style="cursor:pointer;"><a href="'.$sHref.'"> Back to List</a></small>';
        

        $aViewData = array("module" => $this->load->view("subview/view_workers_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function applicantview() {

        $aUrl               =   parse_url($_SERVER['REQUEST_URI']);
        $vTrxId             =   $aUrl['query'];

        $this->kgsessions->set_session('sess_trxid', $vTrxId);
        $aEmpInfo           =   $this->customer->GetEmployeeInfo(array('trxid' => $vTrxId));
        
        $aDetails           =   $this->customer->GetAgentDetails($vTrxId);


        $aHtml              =   $this->aModules;
        $aHtml['user']      =   $this->sUname;
        $aHtml['trxid']     =   $vTrxId;

        $aHtml['headtitle'] =   "Applicant Info";
        $aHtml['employee']  =   $aEmpInfo;
        $aHtml['details']   =   $aDetails;

        $sDepts                 =   $this->customer->getClientDeptsDd(array('clientid' => $aEmpInfo['client_id']), '', '');
        $aDropDowns             =   $this->hatvclib->getDropDownsDd(array(), '');
        // $sSupList               =   $this->customer->getBranchSup(array("client_id" => $aEmpInfo['client_id'], 'branch_id' => $aEmpInfo['branch_id'], 'dept_id' => $aEmpInfo['dept_id'])); 
        

        $sClientList            =   $this->customer->getClientsDd(array("client_id" => ''), $aEmpInfo['client_id']);
        $aBranch                =   $this->customer->getClientBranch(array(), $aEmpInfo['branch_id'], $aEmpInfo['client_id']);
        $aPosition              =   $this->customer->getClientBranch(array(), $aEmpInfo['position_id'], $aEmpInfo['client_id']);

        $aHtml['region']        =   $this->hatvclib->DropDowns('region', array('region', ''), $aEmpInfo['client_region']);
        $aHtml['city']          =   $this->hatvclib->DropDowns('dropcitymuniprov', array('citymuni', $aEmpInfo['client_region']), $aEmpInfo['client_city']);

        $aHtml['brgy']          =   $this->hatvclib->DropDowns('dropbrgy', array('brgy',  $aEmpInfo['client_city']), $aEmpInfo['client_brgy']);

        $aHtml['gender']        =   $this->hatvclib->DropGender('Gender', $aEmpInfo['agent_gender']);
        $aHtml['civilstat']     =   $this->hatvclib->DropCivilStat('CivilStatus', $aEmpInfo['agent_civil_status']);
        $aHtml['dropdown']      =   $this->hatvclib->getDropDownsDd(array(), $aEmpInfo['religion_id']);
        $aHtml['clients']       =   $sClientList;
        $aHtml['branch']        =   $aBranch['branch'];
        $aHtml['position']      =   $aPosition['position'];

        $aHtml['appstatus']     =   $this->hatvclib->DropAppStat('AppstatId',$aEmpInfo['agent_standing']);

        $aHtml['boxheader']     =  "box-danger";


        $aHtml['dropdowns']     =   $aDropDowns;
        $aHtml['supervisors']   =   '';
        $aHtml['department']    =   $sDepts;

        $sHref                  =   $aHtml['employee']['agent_status'] == "deployed" ? "workers" : "applications";



        $aHtml['title']     = '<i class="fa fa-users" style="font-size: 24px !important;"></i> Applicant Details <small class="pull-right" style="cursor:pointer;"><a href="'.$sHref.'"> Back to List</a></small>';
        

        $aViewData = array("module" => $this->load->view("subview/view_applicant_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function company() {
        
        $sClientList        =   $this->customer->getClientsList(array("clientid" => ""));
        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Client';

        $aHtml['clients']   =   $sClientList;
        $aHtml['headtitle'] =   "Clients";

        $aViewData = array("module" => $this->load->view("shared/company_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    //Client Request
    public function requests() {

        $sClientRequests    =   $this->customer->getClientsRequestsList(array("requestid" => ""));
        
        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Client Requests ';

        $aHtml['requests']   =   $sClientRequests;
        $aHtml['headtitle'] =   "Client Requests";

        $aViewData = array("module" => $this->load->view("shared/client_request_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function newrequest() {
        
        $sClientList        =   $this->customer->getClientsDd(array("clientid" => ""), '');
        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Service Requisition Form <small class="pull-right" style="cursor:pointer;"><a href="requests"> Back to List</a></small>';

        $aHtml['clients']   =   $sClientList;
        $aHtml['headtitle'] =   "Client Request";

        $aViewData = array("module" => $this->load->view("subview/client_request_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function process_client_request() {
        $aUrl               =   parse_url($_SERVER['REQUEST_URI']);
        $nRequestId         =   $aUrl['query'];

        $aRequestInfo       =   $this->customer->procClientRequest(array("requestid" => $nRequestId));


        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Process Client Request <small class="pull-right" style="cursor:pointer;"><a href="requests"> Back to List</a></small>';

        $aHtml['request']   =   $aRequestInfo[0];
        $aHtml['headtitle'] =   "Client Request";

        $aViewData = array("module" => $this->load->view("subview/client_request_process_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function edit_client_request(){
        $aUrl               =   parse_url($_SERVER['REQUEST_URI']);
        $nRequestId         =   $aUrl['query'];

        $aRequestInfo       =   $this->customer->procClientRequest(array("requestid" => $nRequestId));

        $sClientList        =   $this->customer->getClientsDd(array("clientid" =>''), $aRequestInfo[0]['client_id']);
        $aBranch            =   $this->customer->getClientBranch(array(), $aRequestInfo[0]['branch_id'], $aRequestInfo[0]['client_id']);
        $sPosition          =   $this->hatvclib->getPositionList(array(), $aRequestInfo[0]['client_id'], $this->hatvclib->JsonToArray(json_decode($aRequestInfo[0]['request_positions'])));

        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Service Requisition Form <small class="pull-right" style="cursor:pointer;"><a href="requests"> Back to List</a></small>';

        $aHtml['clients']   =   $sClientList;
        $aHtml['drpdown']   =   $aBranch;
        $aHtml['request']   =   $aRequestInfo[0];
        $aHtml['positions'] =   $sPosition;
        $aHtml['requestid'] =   $nRequestId;
        

        $aHtml['nature']    =   $this->hatvclib->JsonToArray(json_decode($aRequestInfo[0]['request_nature']));
        $aHtml['qualify']   =   $this->hatvclib->JsonToArray(json_decode($aRequestInfo[0]['request_qualifications']));
        $aHtml['headtitle'] =   "Client Request";

        $aViewData = array("module" => $this->load->view("subview/client_request_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function supervisors() {

        $sSessUname         =   $this->session->userdata('sess_username'); 
        $aDropDowns         =   $this->hatvclib->getDropDownsDd(array(), ''); 
        $sClientList        =   $this->customer->getClientsDd(array("client_id" => ''), ''); 
        $sSupList           =   $this->customer->getSuppList(array("sup_id" => '')); 
        
        $aHtml              =   $this->hatvclib->get_user_modules();

        $aHtml['headtitle']     =   "Supervisors";
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-users" style="font-size: 24px !important;"></i> Supervisors';

        $aHtml['dropdowns']     =   $aDropDowns;
        $aHtml['clients']       =   $sClientList;
        $aHtml['supervisors']   =   $sSupList;
        
        $aViewData = array("module" => $this->load->view("shared/supervisors_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function dropdowns() {

        $aDropDown          =   $this->hatvclib->getDropDowns(array());
        $sSessUname         =   $this->session->userdata('sess_username');
        $sClientList        =   $this->customer->getClientsDd(array("client_id" => ''), '');         
        $sCities            =   $this->hatvclib->getCitiesDd(array('type' => 'cities', 'dataid' => '')); 

        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['headtitle'] =   "Settings";
        $aHtml['dropdowns'] =   $aDropDown;
        $aHtml['clients']   =   $sClientList;
        $aHtml['cities']    =   $sCities;
        
        $aHtml['user'] = $sSessUname;
        $aHtml['title'] = '<i class="fa fa-list" style="font-size: 24px !important;"></i> Dropdown Lists';

        $aViewData = array("module" => $this->load->view("shared/dropdown_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function users() {

        $sSessUname =   $this->session->userdata('sess_username');
        $aHtml  =   $this->hatvclib->get_user_modules();

        $aHtml['headtitle']     =   "Accounts";
        $aHtml['user'] = $sSessUname;
        $aHtml['title'] = '<i class="fa fa-users" style="font-size: 24px !important;"></i> User Accounts';


        $aViewData = array("module" => $this->load->view("shared/user_accounts_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);
    }

    public function newclient() {
        $aDropDowns         =   $this->hatvclib->getDropDownsDd(array(), '');
        
        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['headtitle']     =   "New client";
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Add New Client <small class="pull-right" style="cursor:pointer;"><a href="company"> Back to List</a></small>';
        $aHtml['region']    =   $this->hatvclib->DropDowns('region', array('region', ''), '');
        $aHtml['dropdowns'] =   $aDropDowns;

        $aViewData          =   array("module" => $this->load->view("subview/new_client_pv", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);

        
    }

    public function editclient() {
        $aUrl               =   parse_url($_SERVER['REQUEST_URI']);
        $nClientId          =   $aUrl['query'];
        
        $aClientInfo        =   $this->customer->GetClientInfo(array('clientid' => $nClientId));

        if ($aClientInfo['ClientPayrollPeriod'] == "sm") {

            $sPayrollPeriod     =   array('PayrollCutOffFrom'  => $aClientInfo['PayrollCutOffFrom'], 'PayrollCutOffTo'  => $aClientInfo['PayrollCutOffTo'], 'PaymentSchedFrom' => $aClientInfo['PaymentSchedFrom'], 'PaymentSchedTo' => $aClientInfo['PaymentSchedTo']);
            
        } else {
            $sPayrollPeriod     =   array('PaymentSched' => $aClientInfo['PaymentSched'], 'PayrollCutOff' => $aClientInfo['PayrollCutOff']);
        }


        $aDepartments       =   $this->customer->GetClientDepts(array('clientid' => $aClientInfo['ClientId']));


        $sSessUname         =   $this->session->userdata('sess_username');
        $aHtml              =   $this->hatvclib->get_user_modules();
        $aHtml['headtitle']     =   "Update Client";
        $aHtml['user']      =   $sSessUname;
        $aHtml['title']     =   '<i class="fa fa-institution" style="font-size: 24px !important;"></i> Add New Client <small class="pull-right" style="cursor:pointer;"><a href="company"> Back to List</a></small>';
        

        // $aDropDowns         =   $this->hatvclib->getDropDownsDd(array(), $aClientInfo['BranchId']);
        $aCityMuni          =   $this->hatvclib->DropDowns('dropcitymuniprov', array('citymuni',$aClientInfo['ClientRegion']), $aClientInfo['ClientCity']);
        $aBrgy              =   $this->hatvclib->DropDowns('dropbrgy', array('brgy',$aClientInfo['ClientCity']), $aClientInfo['ClientBrgy']);

        $aHtml['region']    =   $this->hatvclib->DropDowns('region', array('region', ''), $aClientInfo['ClientRegion']);
        $aHtml['citymuni']  =   $aCityMuni['message'];
        $aHtml['brgy']      =   $aBrgy['message'];

        // $aHtml['dropdowns'] =   $aDropDowns;
        $aHtml['clientinfo']=   $aClientInfo;
        $aHtml['payrolls']  =   json_encode($sPayrollPeriod);
        $aHtml['depts']     =   $aDepartments;


        $aViewData          =   array("module" => $this->load->view("subview/new_client_pv", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);

        
    }

    public function change_password() {
        $sSessUname     =   $this->session->userdata('sess_username');
        $aHtml          =   $this->hatvclib->get_user_modules();

        $aHtml['user']  = $sSessUname;
        $aHtml['title'] = '<i class="fa fa-gear" style="font-size: 24px !important;"></i> Change Password';
        $aHtml['headtitle']     =   "Change Password";
        $aViewData = array("module" => $this->load->view("shared/change_password_v", $aHtml, TRUE));

        $this->load->view('devop/main', $aViewData);
    }

    //TNA
    //
    public function dtr_summary() {

        
        $sSessUname =   $this->session->userdata('sess_username');
        $aHtml  =   $this->hatvclib->get_user_modules();

        $aHtml['dtrlist'] =  $this->customer->GetDtr('', '', '');

        $aHtml['headtitle']     =   "DTR Summary";
        $aHtml['user'] = $sSessUname;
        $aHtml['title'] = '<i class="fa fa-clock-o" style="font-size: 24px !important;"></i> Timekeeping';


        $aViewData = array("module" => $this->load->view("shared/dtr_summary_v", $aHtml, TRUE));
        $this->load->view('devop/main', $aViewData);    
    }

}
?>