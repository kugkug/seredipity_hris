<?php

defined('BASEPATH') OR exit('No direct script access allowed');    

class Hatvcapi_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function apiActivityLogs($sModule, $sPrevStatus, $sNewStatus, $sLogInfo) {
    	$aData =    array(
    						'app_id' 		=> "APP-001",
    						'user_id' 		=> "kugkug",
    						'useragent' 	=> addslashes($_SERVER['HTTP_USER_AGENT']),
    						'remote_addr' 	=> addslashes($_SERVER['REMOTE_ADDR']),
    						'host_name' 	=> addslashes(gethostbyaddr($_SERVER['REMOTE_ADDR'])),
    						'operating_system'	=>	$this->hatvclib->getOS($_SERVER['HTTP_USER_AGENT']),
    						'module' 		=>  $sModule,
    						'prevstatus' 	=> $sPrevStatus,
    						'newstatus' 	=> $sNewStatus,
    						'log_info' 		=>  $sLogInfo
    					);
    	return $aData;
    	// $oActivityLogSP =	"CALL sp_AddActivityLogs(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    	// $eInsert 		= 	$this->db->query($oActivityLogSP, $aData);
    	
    	// return $eInsert;
    }

    public function isLoggedIn() {
        $is_logged_in = $this->session->userdata('sess_token');

        // if(!isset($is_logged_in))
        if(empty($is_logged_in))
        {
            redirect('/', 'refresh');
            exit;
        }
    }

    public function get_user_modules() {

        $sCurrPage  =   $this->kgsessions->get_session('sess_page');
        $sHtml      =   '';

        $qGetMenu   =   "CALL sp_GetModules()";
        $eGetMenu   =   $this->db->query($qGetMenu);
        $aMenuData['records'] = $eGetMenu->result();

        $aMenus     =   array();
    
        foreach ($aMenuData['records'] as $sData)
        {
            $sMenuTitle =   $sData->menutitle;
            $sMenuIcon  =   $sData->menuicon;
            $sMenuType  =   $sData->menutype;

            $sModTitle  =   $sData->modtitle;
            $sModPath   =   $sData->modpath;

            $aMenus[str_replace(" ", "_", $sMenuTitle)."|".$sMenuIcon."|".$sMenuType][] =  $sModTitle."|".$sModPath;
        }

        $sHtml .= "<ul id='ul-sidebar-menu' class='sidebar-menu' data-widget='tree'>
                    <li class='header'>MAIN NAVIGATION</li>
                    ";
        foreach ($aMenus as $sMenuDetails => $aModules)
        {
            $aMenuDetails   =   explode("|", $sMenuDetails);

            $sActive = "";

            foreach ($aModules as $key => $value) {
                $aMods  =   explode("|", $value);

                $sActive =  $aMods[1] == $sCurrPage ? " menu-open active" : "";
                $sDis    =  $aMods[1] == $sCurrPage ? "block" : "none";

                if ($sActive != "")
                {
                    break;
                }
            }


            if ($aMenuDetails[2] == 'Tree') 
            {
                $sHtml .= ' <li class="treeview '.$sActive.'">
                            <a href="#">
                                <i class="fa '.$aMenuDetails[1].'"></i> <span>'.ucwords(strtolower(str_replace("_", " ", $aMenuDetails[0]))).'</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>';
                $sHtml .= '     <ul class="treeview-menu" style="display:'.$sDis.'">';
                
                foreach ($aModules as $nKey => $sModDetails)
                {
                    $aTitelDet  =   explode("|", $sModDetails);
                    $sModTitle  =   strtolower(str_replace("_", " ", $aTitelDet[0]));
                    $sModPath   =   $aTitelDet[1];

                    $sActive   =    $sCurrPage == $sModPath ? "active" : "";
                    
                    if ($sCurrPage == $sModPath) {
                        $this->kgsessions->get_session('sess_pagetitle', ucwords(strtolower($sModTitle)));
                    }
                    
                    $sHtml .=   '   <li class="'.$sActive.'"><a href="menu-link" data-path="'.$sModPath.'"> <i class="fa fa-circle-o"></i>'.ucwords(strtolower($sModTitle)).'</a></li>';

                }
                    $sHtml .= "  </ul>";
                $sHtml .= " </li>";
            }
            else {
            
                $sActive   =    $sCurrPage == strtolower(str_replace(" ", "_", $aMenuDetails[0])) ? "active" : "";
                $sHtml .= "<li class='".$sActive."'>
                            <a href='menu-link' data-path='".strtolower(str_replace(" ", "_", $aMenuDetails[0]))."'>
                                <i class='fa ".$aMenuDetails[1]."'></i>
                                <span>".ucwords(strtolower(str_replace("_", " ", $aMenuDetails[0])))."</span>
                            </a>
                            </li>";
        
            }
            
        }

        $sHtml .= " </ul>";


        $aPage              =   explode("/", $sCurrPage);
        $aHtml['html']      =   $sHtml;
        $aHtml['page']      =   ucwords(strtolower(str_replace("_", " ", $sCurrPage)));
        $aHtml['home']      =   ucwords(strtolower(str_replace("_", " ", $aPage[0])));
        $aHtml['user']      =   $this->kgsessions->get_session('sess_username');
        $aHtml['secpage']   =   ucwords(strtolower($this->kgsessions->get_session('sess_secpage')));

        return $aHtml;
    }


    public function get_page($sNewModule, $sNewModData, $sCurrPage, $sModTitle) {

        $aReturn    =   array();
        $aPrevStat  =   array();
        $aNewStat   =   array();
        $aLogInfo   =   array();

        $sPrevPage  =   $this->session->userdata('sess_prevpage');
        $sTitle     =   $this->session->userdata('sess_pagetitle');

        if (empty($sNewModule) && empty($sNewModData)) {

            if (empty($sCurrPage)) {
                $sPage  =    "home";

            }
            else {
                $sNewPage   =   $sCurrPage;
                $this->session->set_userdata('sess_page', $sNewPage);

                $sPage  =   $this->session->userdata('sess_page');
            }
        }
        else
        {
            if (!empty($sNewModule)){
                $sNewPage   =   $sNewModule;

                $this->session->set_userdata('sess_page', $sNewPage);
                $this->session->set_userdata('sess_pagetitle', $sModTitle);


                $sPage      =   $this->session->userdata('sess_page');
                $sTitle     =   $this->session->userdata('sess_pagetitle');

            }
            else if (empty($sNewModule) && !empty($sNewModData)) {
                $sPage  =    $sCurrPage."/second_page";
            }
        }

        if ($sPage != "" && $sCurrPage != $sPage) {
            $this->session->set_userdata('sess_prevpage', $sCurrPage);
        }

        $aPrevStat['from_page']     =   $sCurrPage;
        $aNewStat['to_page']        =   $sPage;
        $aLogInfo['action_taken']   =   "navigate";

        $this->session->set_userdata('sess_page', $sPage);

        // if ($sCurrPage != $sPage) {
        //     $this->hatvclib->logActivity($sPage, $aPrevStat, $aNewStat, $aLogInfo);
        // }

        $aPage =    explode("/", $sPage);

        $aReturn['return']  =   "ok";
        $aReturn['page']    =   $sPage;
        $aReturn['prev']    =   $this->session->userdata('sess_prevpage');
        $aReturn['title']   =   ucwords(strtolower($sTitle));
        $aReturn['home']    =   ucwords(strtolower(str_replace("_", " ", $aPage[0])));
        $aReturn['secpage'] =   ucwords(strtolower($this->session->userdata('sess_secpage')));

        return json_encode($aReturn);
    }
}
?>