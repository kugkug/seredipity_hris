<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Company extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Company_Model');
        } 

        public function index()
        { 
            // $aCityMuniProv  =   $this->hatvclib->DropDowns('dropcitymuniprov', array('citymuni',$nRegionId), $nCityMuniProv);
            // $aBrgy          =   $this->hatvclib->DropDowns('dropbrgy', array('brgy',$nCityMuniProv), $nBrgyId);

            $aDropDowns     =   array(

                                        "region" => $this->hatvclib->DropDowns('region', array('region', ''), '')
                                        // "cityprovmuni" => $aCityMuniProv['message'],
                                        // "brgy" => $aBrgy['message'],
                                    );
            
            $this->load->view('company_v', $aDropDowns);
        }

        public function proc_dropdown_listing()
        {   
            
            $sReturn    =   "";
            $sAction    =   $this->input->post('action'); 

            switch ($sAction) {
                case 'get_ques':
                    $aData      =   array("quespageid" => $this->input->post('selPages'));
                    $sReturn =  $this->Company_Model->proc_dropdown_listing('get-ques', $aData);

                break;

                case 'get_ans':
                    $aData      =   array("quesid" => $this->input->post('selQues'));
                    $sReturn =  $this->Company_Model->proc_dropdown_listing('get-ans', $aData);

                break;

                case 'save':

                    $sQuesId        =   $this->input->post('selQues');
                    $sType          =   $this->input->post('selType');

                    $aDelete        =  $this->Company_Model->proc_dropdown_listing('delete', array('ans_ques_id' => $sQuesId));

                    
                    if ($aDelete['return'] == "ok") {

                        if ($sType == "range") {
                            $aQueryData =   array(  
                                                    "ans_data" => $this->input->post('txtRangeFrom') ."|".$this->input->post('txtRangeTo'),
                                                    "ans_increment" => $this->input->post('txtIncrement'),
                                                    "ans_ques_id" => $sQuesId,
                                                    "ans_type" => $sType,
                                                    "ans_status" => "active",
                                                );

                            $sReturn =  $this->Company_Model->proc_dropdown_listing('save', $aQueryData);
                        }
                        else 
                        {
                            $aDatas     =   array();
                            $aJsonValue =   json_decode($this->input->post('jsondata'));

                            $x = 0;

                            while ($x < sizeof($aJsonValue)) {

                                $aDatas[]  = "('".$aJsonValue[$x]."','".$aJsonValue[$x + 1]."','". $sQuesId."','".$sType."', 'active')";

                                $x += 2;
                            }

                            $aQueryData =   array(  "cols" =>   array("ans_data","ans_order","ans_ques_id","ans_type","ans_status"),
                                                    "vals" =>   $aDatas,
                                                 );
                            $sReturn =  $this->Company_Model->proc_dropdown_listing('savebatch', $aQueryData);
                        }
                    } else {
                        $sReturn = json_encode($aDelete);
                    }
                    

                break;
            }

            echo $sReturn;
        }
    }
?>