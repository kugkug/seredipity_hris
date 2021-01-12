<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Analysis extends CI_Controller {
        function __construct() { 
            parent::__construct();
            $this->load->model('Analysis_Model');
        
        } 

        public function index()
        { 
            $sPage                  =   $this->session->userdata('sess_page');
            $aDrpDwns['questions']  =   $this->Analysis_Model->proc_analysis('get-ques', array());

            $this->load->view('analysis_v', $aDrpDwns);
        }

        public function proc_analysis() {
            $sAction    =   $this->input->post('action');
            
            switch ($sAction) {
                case 'get_ans':

                        $aQuestion  =   explode("|", $this->input->post('question'));
                        $aData      =   array("quesid" => $aQuestion[0]);
                        $sReturn    =  $this->Analysis_Model->proc_analysis('get-ans', $aData);

                        echo $sReturn;

                    break;
                case 'filter':

                        $aJsonObj   =   $this->hatvclib->CreateAnalysisQuery(json_decode($this->input->post('jsondata')));
                        // echo json_encode($aJsonObj);
                        // return;
                            $sHtml      =   '<table id="tblData" class="table table-bordered table-striped table-hovered">
                                                <thead>
                                                <tr>
                                                    <th>Participant No.</th>
                                                    <th>Household No.</th>
                                                    <th>Participant Name</th>
                                                    <th>Gender</th>
                                                    <th>Age</th>
                                                    <th>Civil Status</th>
                                                    <th>Occupation</th>

                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                    <tbody>';
                            if ($aJsonObj != "0") {
                                foreach ($aJsonObj as $key => $aValue) {
                                    $sHtml .=   '<tr>
                                                    <td>'.$aValue['part_id'].'</td>
                                                    <td>'.$aValue['part_household_code'].'</td>
                                                    <td>'.ucwords(strtolower($aValue['part_lname'].' '.$aValue['part_fname'].', '.$aValue['part_mname'])).'</td>
                                                    <td>'.ucfirst($aValue['part_gender']).'</td>
                                                    <td>'.$aValue['part_age'].'</td>
                                                    <td>'.ucfirst(strtolower($aValue['part_civil_status'])).'</td>
                                                    <td>'.OCCUPATION[$aValue['part_occupation']].'</td>
                                                    <td><button class="btn btn-primary" title="Print" btn-data="'.$aValue['part_id'].'"><i class="fa fa-print"></i></button> </td>
                                                </tr>';
                                }
                            } else {
                                $sHtml .=   '<tr> <td colspan="7">No record found...</td> </tr>';
                            }
                            $sHtml .= '</tbody></table>';

                        echo json_encode(array('html' => $sHtml));
                break;
            }
        }

        public function proc_analysis_report(){
            $nPartId    =   $this->input->post('part_id');

            print_r($this->Analysis_Model->genReport($nPartId));
        }

        public function proc_analysis_excel(){
            $sType    =   $this->input->post('type');
            if ($sType == "all") {
                print_r($this->reportlib->exportReports(array('type'=> $sType, 'param' => '')));
            } else {
                // echo json_encode($this->hatvclib->CreateAnalysisReportQuery(json_decode($this->input->post('jsondata'))));
                print_r($this->reportlib->exportReports(array('type'=> $sType, 'param' => $this->hatvclib->CreateAnalysisReportQuery(json_decode($this->input->post('jsondata'))))));
            }
        }
    }
?>