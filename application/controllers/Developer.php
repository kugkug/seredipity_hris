<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developer extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Developer_Model');
    }

	public function index()
	{
		$this->load->view('devop/devop');
	}

	public function add_new_menu()
	{
		$sMenuTitle = ucfirst(strtolower(addslashes($this->input->post('txtMenuTit'))));
		$aMenuData 	= array("menutitle" => $sMenuTitle);
		
        $qInsert    = $this->Developer_Model->insert("tbl_sysmenus", $aMenuData);
        if ($qInsert == true) {
            echo "ok";
        }
        else {
            echo "er";  
        }
	}

    public function add_new_modules()
    {
        $sModTitle  = addslashes($this->input->post('txtModTitle'));
        $sModDir    = strtolower(str_replace(" ", "_", $this->input->post('txtModTitle'))).".php";
        $sModCat    = $this->input->post('selModCat');

        $aFileName  = explode(".", $sModDir);
        $sFileName  = $aFileName[0];
        $sExtName   = $aFileName[1];

        $sModelFile = ucfirst(strtolower($aFileName[0]))."_Model.".$sExtName;
        $sViewFile  = strtolower($aFileName[0])."_v.".$sExtName;
        $sContFile  = ucfirst(strtolower($aFileName[0])).".".$sExtName;


        $aModuleData= array(
                                "modtitle"      => $sModTitle,
                                "modpath"       => $sFileName,
                                "modcatid"      => $sModCat,
                                "createddate"   => date("Y-m-d H:i:s")
                            );

        $qInsert    = $this->Developer_Model->insert("tbl_sysmodules", $aModuleData);

        if ($qInsert == true){
            $this->createFile("model", $sModelFile, $sFileName);
            $this->createFile("view", $sViewFile, $sFileName);
            $this->createFile("controller", $sContFile, $sFileName);
            echo "ok";
        }else{
            echo "er";
        }
    }

	public function get_menu_list()
	{ 
		$qGetMenu = $this->db->get("tbl_sysmenus");

        $aMenuData['records'] = $qGetMenu->result();

        $sJsonRes =	"";
        $sSelect  = "<option value=''>";

        $sHtml = "<div class='panel-group' id='accordion'>";
        foreach ($aMenuData['records'] as $sData)
        {
        	$sSelect .= "<option value='".$sData->MenuID."'>".$sData->MenuTitle;
        	$sHtml .= "<div class='panel panel-primary'>
                            <div class='panel-heading'><h4 class='panel-title'><a data-toggle='collapse' href='#collapse_".$sData->MenuID."'>".$sData->MenuTitle."</a></h4></div>
                                <div id='collapse_".$sData->MenuID."' class='panel-collapse collapse'>
                                    <div class='panel-body'>";

            $qGetModule = $this->db->get_where("tbl_sysmodules", array("modcatid" => $sData->MenuID));
            $aModuleData['records'] = $qGetModule->result();

            $sHtml .=   "<ul>";
            foreach ($aModuleData['records'] as $module) {
                $sHtml .=   "<li><a href='javascript:void(0)' onclick=_load('".strtolower($module->ModTitle)."');> ".ucfirst(strtolower($module->ModTitle))."</a></li>";
            }

            $sHtml .=   "</ul>";

            $sHtml .=               "</div>
                                </div>
                            </div>";
        }
        $sHtml .= "</div>";

        $aResult['inner']['divResult'] = $sHtml;
        $aResult['value']['selModCat'] = $sSelect;
       	
       	echo json_encode($aResult);
	}

    public function createFile($vType, $vFileName, $vFunction)
    {
        switch ($vType) {
            
            case 'model':
                    $sFileName =   "application/models/".$vFileName;
                    $sContent  =    "<?php
    defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class ".ucfirst(strtolower($vFunction))."_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
        } 
    }
?>";
                break;
            
            case 'view':
                    $sFileName =   "application/views/".strtolower($vFileName);
                    $sContent  =    "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <h1>".strtolower($vFileName)."</h1>
    </body>
</html>";
                
                break;

                case 'controller':
                    $sFileName =   "application/controllers/".ucfirst(strtolower($vFileName));
                    $sContent  =    "<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ".ucfirst(strtolower($vFunction))." extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $".""."this->load->model('".ucfirst(strtolower($vFunction))."_Model');
        } 

        public function index()
        { 
            $".""."this->load->view('".strtolower($vFunction)."_v');
        }
    }
?>";
            break;
        }
        // die($sFileName." | ".$sContent);
        $fp=fopen($sFileName,'a+');
        fwrite($fp, $sContent);
        fclose($fp);
    }
}
