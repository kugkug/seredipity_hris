<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Global_funcs extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Global_funcs_Model');

            ob_clean();
        } 


        public function proc_global_funcs() {

            $sReturn =  "";
            $sAction =  $this->input->post('action');

            switch ($sAction) {
	            case 'dropcitymuniprov':
	                    $aData      =   array('citymuni', $this->input->post('data'));
	                    $sReturn    =   $this->Global_funcs_Model->proc_global_funcs($sAction, $aData);
	            break;

	           	case 'dropbrgy':
                        $aData   =  array('brgy', $this->input->post('data'));
                        $sReturn =   $this->Global_funcs_Model->proc_global_funcs($sAction, $aData);
                break;


                case 'save':
                        $dDate      =   date("Y-m-d H:i:s");
                        $dLogDate   =   date("Y-m-d", strtotime($dDate));
                        $dLogTime   =   date("H:i:s", strtotime($dDate));

                        $aData   =  array("emp_no" => $this->session->userdata('sess_username'), "log_date" => $dLogDate, "log_time" => $dLogTime, "entrydate" => $dDate);
                        $sReturn =   $this->Global_funcs_Model->proc_global_funcs($sAction, $aData);
                break;

            }            
            echo $sReturn;
        }

        // public function upload_photo_sign() {

        //     $aPhotoFile     =   $_FILES['photo'];

        //     $_FILES['upFile']['name']      = $aPhotoFile['name'];
        //     $_FILES['upFile']['type']      = $aPhotoFile['type'];
        //     $_FILES['upFile']['tmp_name']  = $aPhotoFile['tmp_name'];
        //     $_FILES['upFile']['error']     = $aPhotoFile['error'];
        //     $_FILES['upFile']['size']      = $aPhotoFile['size'];
            
        //     $sFileName      =   $aPhotoFile['name'];
        //     $aFileName      =   explode(".", $sFileName);

        //     $sNewFileName   =   date("Ymdhisu")."_Photo.".$aFileName[sizeof($aFileName) - 1];

        //     $sResult =  json_decode($this->hatvclib->Upload($sNewFileName, 'photos'));

        //     if($sResult->return == true) {
        //         $sPhotoFileName     =   $sResult->filename;

        //         $sSignatureFileName =   $sNewFileName   =   date("Ymdhisu")."_Sign.png";
        //         $aSignFile          =   $_FILES['signature']['tmp_name'];

        //         file_put_contents( "signatures/".$sSignatureFileName, file_get_contents($aSignFile));

        //         echo json_encode(array('return' => "ok", 'photo_file' => $sPhotoFileName, 'sign_file' => $sSignatureFileName));

        //     } else {
        //         echo json_encode(array('return' => "error"));
        //     }
        // }

        public function upload_photo_sign() {

            $aPhotoFile     =   $_FILES['txtPhoto'];

            $_FILES['upFile']['name']      = $aPhotoFile['name'];
            $_FILES['upFile']['type']      = $aPhotoFile['type'];
            $_FILES['upFile']['tmp_name']  = $aPhotoFile['tmp_name'];
            $_FILES['upFile']['error']     = $aPhotoFile['error'];
            $_FILES['upFile']['size']      = $aPhotoFile['size'];
            
            $sFileName      =   $aPhotoFile['name'];
            $aFileName      =   explode(".", $sFileName);

            $sNewFileName   =   date("Ymdhisu")."_Photo.".$aFileName[sizeof($aFileName) - 1];

            $sResult =  json_decode($this->hatvclib->Upload($sNewFileName, 'photos'));

            if($sResult->return == true) {
                $sPhotoFileName     =   $sResult->filename;

                echo json_encode(array('return' => "ok", 'photo_file' => $sPhotoFileName));

            } else {
                echo json_encode(array('return' => "error"));
            }
        }
        
        public function proc_dropdowns() {

            $sAction        =   $this->input->post('action');

            switch ($sAction) {
                case 'fetch':
                        $aData          =   array('action' => $sAction); 
                        echo $this->Global_funcs_Model->proc_dropdowns($aData, array());
                    break;
                
                default:
                    if ($sAction != 'addbranch') {
                        $aDropData      =   $this->hatvclib->JsontoArray($this->input->post('data'));
                        $aData          =   array('action' => $sAction, 'dropkey' => $aDropData['dropkey'], 'dropval' => $aDropData['dropval'], 'dropsub' => $aDropData['dropsub'], 'datakey' => ''); 
                        echo $this->Global_funcs_Model->proc_dropdowns($aData, array());
                    } else {
                        $aDropData      =   $this->hatvclib->JsontoArray($this->input->post('data'));
                        $aData          =   array('action' => $sAction, 'dropkey' => $aDropData['dropkey'], 'dropval' => $aDropData['dropval'], 'dropsub' => $aDropData['dropsub'], 'datakey' => ''); 

                        $aRepData       =   array('action' => 'addrep', 'conperson' => $aDropData['conperson'], 'connumber' => $aDropData['connumber'], 'conemail' => $aDropData['conemail']); 
                        echo $this->Global_funcs_Model->proc_dropdowns($aData, $aRepData);
                    }
                break;
            }

            
        }
    }
?>