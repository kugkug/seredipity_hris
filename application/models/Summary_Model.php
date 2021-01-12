<?php
    defined('BASEPATH') OR exit('No direct script access allowed');    
      
   
    class Summary_Model extends CI_Model {
        function __construct() { 
            parent::__construct();
            include APPPATH.'third_party/fpdf/fpdf.php';
       } 

        public function proc_summary($vAction, $aData) {

        	switch ($vAction) {
        		case 'get-info':
                    $aRetQues   =   array();

                    $nPartId    =   $this->session->userdata('sess_partid');
                    $aGenInfo   =   $this->customer->GetPartFullInfo(array("partid" => $nPartId));

                    $sPhoto     =   $this->customer->CheckInfoKey($aGenInfo, 'part_photo') != "" ? "<img src='photos/".$this->customer->CheckInfoKey($aGenInfo, 'part_photo')."'>" : "<img src='images/no_photo.png' style='width: 220px;'>";

                    $aHealthLife        =   $this->customer->GetPartInfo(array("type" => "healthlife", "partid" => $nPartId));
                    $aHealthLifeData    =   $this->hatvclib->JsonToArray(
                                        array(
                                                'bmi_bmi'           => $aHealthLife['bmi_bmi'],
                                                'bmi_waist_hip'     => $aHealthLife['bmi_waist_hip'],
                                                'bmi_vital_signs'   => $aHealthLife['bmi_vital_signs'],
                                                'hist_sys_dis'      => $aHealthLife['hist_sys_dis'],
                                                'hist_life_con'     => $aHealthLife['hist_life_con'],
                                                'hist_sys_med'      => $aHealthLife['hist_sys_med'],
                                                'hist_ocu_med'      => $aHealthLife['hist_ocu_med'],
                                                'hist_diet_sup'     => $aHealthLife['hist_diet_sup'],
                                                'ih_health_insu'    => $aHealthLife['ih_health_insu'],
                                                'ih_smoke_alc'      => $aHealthLife['ih_smoke_alc'],
                                                'ih_diet_nutri'     => $aHealthLife['ih_diet_nutri'],
                                                'bmi_eh_sun_expo'   => $aHealthLife['bmi_eh_sun_expo'],
                                                'bmi_eh_near_work'  => $aHealthLife['bmi_eh_near_work'],
                                                'bmi_eh_location'   => $aHealthLife['bmi_eh_location'],
                                                'bmi_eh_women_health'=> $aHealthLife['bmi_eh_women_health'],
                                                'bmi_gen_eye_health' => $aHealthLife['bmi_gen_eye_health']
                                            )
                                    );
                    $aEyeExam       =   $this->customer->GetPartInfo(array("type" => "eyeexam", "partid" => $nPartId));
                    $aEyeExamData   =   $this->hatvclib->JsonToArray(
                                            array(
                                                    'hist_sys_dis' => $aEyeExam['hist_sys_dis'],
                                                    'hist_life_con'=> $aEyeExam['hist_life_con'],
                                                    'hist_sys_med' => $aEyeExam['hist_sys_med'],
                                                    'hist_ocu_med' => $aEyeExam['hist_ocu_med'],
                                                    'symp_ocu'     => $aEyeExam['symp_ocu'],
                                                    'symp_non_ocu' => $aEyeExam['symp_non_ocu'],
                                                    'va_vis_acu'   => $aEyeExam['va_vis_acu'],
                                                    'tono_dila'     => $aEyeExam['tono_dila'],
                                                    'va_auto_refrac' => $aEyeExam['va_auto_refrac'],
                                                    'va_keratometry' => $aEyeExam['va_keratometry'],
                                                    'va_eye_glasses' => $aEyeExam['va_eye_glasses'],
                                                    'va_color_vision'=> $aEyeExam['va_color_vision'],
                                                    'amsler_chart'  => $aEyeExam['amsler_chart'],
                                                    'bf_blood_glucose' => $aEyeExam['bf_blood_glucose'],
                                                    'ocu_find_diag'  => $aEyeExam['ocu_find_diag'],
                                                    'ocu_exam'=> $aEyeExam['ocu_exam'],
                                                    'manage_plan' => $aEyeExam['manage_plan']
                                                )
                                        );

                    $aSocioEco  =   $this->customer->GetPartInfo(array("type" => "socioeco", "partid" => $nPartId));

                    $aSocSocioEco=   $this->hatvclib->JsonToArray(
                            array(
                                    'soc_socio_economic' => $aSocioEco['soc_socio_economic'],
                                    'soc_vehicle_own' => $aSocioEco['soc_vehicle_own'],
                                    'soc_house_own' => $aSocioEco['soc_house_own'],
                                    'soc_durable_fac' => $aSocioEco['soc_durable_fac'],
                                    'soc_house_fac' => $aSocioEco['soc_house_fac']
                                )
                    );

                    $aGenInfo['part_photo']	=	$sPhoto;
                    $aRetQues['gen_info']   =	$aGenInfo;
                    $aRetQues['healthlife'] =   $aHealthLifeData;
                    $aRetQues['eyeexam']    =   $aEyeExamData;
                    $aRetQues['socioeco']    =   $aSocSocioEco;

                    return $aRetQues;
                 break;
            }
        }

        public function genReport($sPartId) {
            

            $aGenInfo           =   $this->customer->GetPartFullInfo(array("partid" => $sPartId));
            $aHealthLife        =   $this->customer->GetPartInfo(array("type" => "healthlife", "partid" => $sPartId));
            $aHealthLifeData    =   $this->hatvclib->JsonToArray(
                                array(
                                        'bmi_bmi'           => $aHealthLife['bmi_bmi'],
                                        'bmi_waist_hip'     => $aHealthLife['bmi_waist_hip'],
                                        'bmi_vital_signs'   => $aHealthLife['bmi_vital_signs'],
                                        'hist_sys_dis'      => $aHealthLife['hist_sys_dis'],
                                        'hist_life_con'     => $aHealthLife['hist_life_con'],
                                        'hist_sys_med'      => $aHealthLife['hist_sys_med'],
                                        'hist_ocu_med'      => $aHealthLife['hist_ocu_med'],
                                        'hist_diet_sup'     => $aHealthLife['hist_diet_sup'],
                                        'ih_health_insu'    => $aHealthLife['ih_health_insu'],
                                        'ih_smoke_alc'      => $aHealthLife['ih_smoke_alc'],
                                        'ih_diet_nutri'     => $aHealthLife['ih_diet_nutri'],
                                        'bmi_eh_sun_expo'   => $aHealthLife['bmi_eh_sun_expo'],
                                        'bmi_eh_near_work'  => $aHealthLife['bmi_eh_near_work'],
                                        'bmi_eh_location'   => $aHealthLife['bmi_eh_location'],
                                        'bmi_eh_women_health'=> $aHealthLife['bmi_eh_women_health'],
                                        'bmi_gen_eye_health' => $aHealthLife['bmi_gen_eye_health']
                                    )
                            );

            $aEyeExam       =   $this->customer->GetPartInfo(array("type" => "eyeexam", "partid" => $sPartId));
            $aEyeExamData   =   $this->hatvclib->JsonToArray(
                                    array(
                                            'hist_sys_dis' => $aEyeExam['hist_sys_dis'],
                                            'hist_life_con'=> $aEyeExam['hist_life_con'],
                                            'hist_sys_med' => $aEyeExam['hist_sys_med'],
                                            'hist_ocu_med' => $aEyeExam['hist_ocu_med'],
                                            'symp_ocu'     => $aEyeExam['symp_ocu'],
                                            'symp_non_ocu' => $aEyeExam['symp_non_ocu'],
                                            'va_vis_acu'   => $aEyeExam['va_vis_acu'],
                                            'tono_dila'     => $aEyeExam['tono_dila'],
                                            'va_auto_refrac' => $aEyeExam['va_auto_refrac'],
                                            'va_keratometry' => $aEyeExam['va_keratometry'],
                                            'va_eye_glasses' => $aEyeExam['va_eye_glasses'],
                                            'va_color_vision'=> $aEyeExam['va_color_vision'],
                                            'amsler_chart'  => $aEyeExam['amsler_chart'],
                                            'bf_blood_glucose' => $aEyeExam['bf_blood_glucose'],
                                            'ocu_find_diag'  => $aEyeExam['ocu_find_diag'],
                                            'ocu_exam'=> $aEyeExam['ocu_exam'],
                                            'manage_plan' => $aEyeExam['manage_plan']
                                        )
                                );
            $aSocioEco  =   $this->customer->GetPartInfo(array("type" => "socioeco", "partid" => $sPartId));
            $aSocSocioEco=   $this->hatvclib->JsonToArray(
                    array(
                            'soc_socio_economic' => $aSocioEco['soc_socio_economic'],
                            'soc_vehicle_own' => $aSocioEco['soc_vehicle_own'],
                            'soc_house_own' => $aSocioEco['soc_house_own'],
                            'soc_durable_fac' => $aSocioEco['soc_durable_fac'],
                            'soc_house_fac' => $aSocioEco['soc_house_fac']
                        )
            );
            

            $sFileName  =   $sPartId."_Summary.pdf";

            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,10,"Participant's Summary", 0, 0, 'C');

            $pdf->Ln(10);
            //190
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Participant Number:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,$aGenInfo['part_id'], 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Household Number:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,$aGenInfo['part_household_code'], 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,5,"Date Examined:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20,5,date("M d, Y | D", strtotime($aGenInfo['entrydate'])), 0, 0, 'L');

            $pdf->Ln(5);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'General Information', 'B', 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Region:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,$aGenInfo['regDesc'], 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Province:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(40,5,$aGenInfo['provDesc'], 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,5,"Barangay:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20,5,$aGenInfo['brgyDesc'], 0, 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Age(Yrs)/Sex:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(50,5,$aGenInfo['part_age']."/".$aGenInfo['part_gender'], 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Occupation:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20,5,OCCUPATION[strtolower($aGenInfo['part_occupation'])], 0, 0, 'L');

            $pdf->Ln(8);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'Health and Lifestyle', 'B', 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Height(cm):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $fHeight =  isset($aHealthLifeData['bmi_bmi']['bmi_height']) ? $aHealthLifeData['bmi_bmi']['bmi_height'] : "";
            $pdf->Cell(50,5,$fHeight, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Weight(kg):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $fWeight =  isset($aHealthLifeData['bmi_bmi']['bmi_weight']) ? $aHealthLifeData['bmi_bmi']['bmi_weight'] : "";
            $pdf->Cell(40,5,$fWeight, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,5,"BMI(kg/m):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $fBMI       =  isset($aHealthLifeData['bmi_bmi']['txtBmi']) ? $aHealthLifeData['bmi_bmi']['txtBmi'] : ""; 
            $fBMIClass  =  isset($aHealthLifeData['bmi_bmi']['txtBmi']) ? $aHealthLifeData['bmi_bmi']['txtBmiClass'] : ""; ;
            $pdf->Cell(20,5,$fBMI."(".$fBMIClass.")", 0, 1, 'L');


            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Waist Cir(cm):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $fWaistCir =  isset($aHealthLifeData['bmi_waist_hip']['whm_waist_circ']) ? $aHealthLifeData['bmi_waist_hip']['whm_waist_circ'] : "";
            $pdf->Cell(50,5,$fWaistCir, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Hip Cir(cm):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $fHipCir =  isset($aHealthLifeData['bmi_waist_hip']['whm_hip_circ']) ? $aHealthLifeData['bmi_waist_hip']['whm_hip_circ'] : "";
            $pdf->Cell(40,5,$fHipCir, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,5,"WHpR:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $fWHpR =  isset($aHealthLifeData['bmi_waist_hip']['txtWaistHipRatio']) ? $aHealthLifeData['bmi_waist_hip']['txtWaistHipRatio'] : ""; 
            $sWaistCirCls   =  $fWaistCir != "" ? $this->customer->WaistToHeightClass(strtolower($aGenInfo['part_gender']), $fWHpR) : "";
            $pdf->Cell(40,5,$fWHpR." (".$sWaistCirCls.")", 0, 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(140,5,"", 0, 0, 'R');
            $pdf->Cell(20,5,"WHtR:", 0, 0, 'L');
            
            $pdf->SetFont('Arial','B',8);

            $fWHtR =  isset($aHealthLifeData['bmi_waist_hip']['txtWaistHeightRatio']) ? $aHealthLifeData['bmi_waist_hip']['txtWaistHeightRatio'] : ""; 
            $sWaistHipCls   =  $fWaistCir != "" ? $this->customer->WaistToHeightClass(strtolower($aGenInfo['part_gender']), $fWHtR) : "";            
            $pdf->Cell(29,5,$fWHtR." (".$sWaistHipCls.")", 0, 1, 'R');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Blood Pressure:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $nSystolic  =  isset($aHealthLifeData['bmi_vital_signs']['vs_bp_systolic']) ? $aHealthLifeData['bmi_vital_signs']['vs_bp_systolic'] : ""; 
            $nDiastolic =  isset($aHealthLifeData['bmi_vital_signs']['vs_bp_diastolic']) ? $aHealthLifeData['bmi_vital_signs']['vs_bp_diastolic'] : ""; 
            
            $pdf->Cell(50,5,$nSystolic."/".$nDiastolic, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(25,5,"Glucose Level(mg/dL):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $nGlucoseLevel =  isset($aHealthLifeData['bmi_vital_signs']['vs_glucose_level']) ? $aHealthLifeData['bmi_vital_signs']['vs_glucose_level'] : "";
            $pdf->Cell(40,5,$nGlucoseLevel, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,5,"Last Meal:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            
            $sLastMealHrs =  isset($aHealthLifeData['bmi_vital_signs']['vs_last_meal_hrs']) ? $aHealthLifeData['bmi_vital_signs']['vs_last_meal_hrs'] : "";
            $pdf->Cell(20,5,$sLastMealHrs, 0, 0, 'L');


            $pdf->Ln(5);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'History', 0, 1, 'L');


            if ($aHealthLifeData['hist_sys_dis'] != "") {

                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(75,5,"Systemic Disease", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                foreach ($aHealthLifeData['hist_sys_dis'] as $key => $aValues)
                {
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(75,5,$aValues->hist_sys_disease, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->txtSysDisDurationAuto, 0, 1, 'L');

                    if($key == 2) {
                        break;
                    }
                }
            }

            if ($aHealthLifeData['hist_life_con'] != "") {

                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(75,5,"Lifestyle Condition", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                foreach ($aHealthLifeData['hist_life_con'] as $key => $aValues)
                {
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(75,5,$aValues->hist_life_condition, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->txtLifeConDurationAuto, 0, 1, 'L');

                    if($key == 2) {
                        break;
                    }
                }
            }

            if ($aHealthLifeData['hist_sys_med'] != "") {

                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(75,5,"Systemic Medication", 0, 0, 'L');
                $pdf->Cell(25,5,"Dose", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                foreach ($aHealthLifeData['hist_sys_med'] as $key => $aValues)
                {
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(75,5,$aValues->hist_sys_medication, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->hist_sys_medication_dose, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->txtSysMedDurationAuto, 0, 1, 'L');

                    if($key == 2) {
                        break;
                    }
                }
            }

            // if ($aHealthLifeData['hist_ocu_med'] != "") {

            //     $pdf->SetFont('Arial','',7);
            //     $pdf->Cell(25,5,"", 0, 0, 'L');
            //     $pdf->Cell(75,5,"Ocular Medication", 0, 0, 'L');
            //     $pdf->Cell(25,5,"Dose", 0, 0, 'L');
            //     $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

            //     foreach ($aHealthLifeData['hist_ocu_med'] as $key => $aValues)
            //     {
            //         $pdf->SetFont('Arial','B',8);
            //         $pdf->Cell(25,5,"", 0, 0, 'L');
            //         $pdf->Cell(75,5,$aValues->ocu_medication, 0, 0, 'L');
            //         $pdf->Cell(25,5,$aValues->ocu_medication_dose, 0, 0, 'L');
            //         $pdf->Cell(25,5,$aValues->txtOcuMedDurationAuto, 0, 1, 'L');

            //         if($key == 2) {
            //             break;
            //         }
            //     }
            // }

            if ($aHealthLifeData['hist_diet_sup'] != "") {

                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(75,5,"Dietary Supplement", 0, 0, 'L');
                $pdf->Cell(25,5,"Dose", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                foreach ($aHealthLifeData['hist_diet_sup'] as $key => $aValues)
                {
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(75,5,$aValues->diet_supplement, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->diet_supplement_dose, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->txtDietSupDurationAuto, 0, 1, 'L');

                    if($key == 2) {
                        break;
                    }
                }
            }

            $pdf->Ln(2);

            if (isset($aHealthLifeData['ih_smoke_alc']['sac_smoker']) && (strtolower($aHealthLifeData['ih_smoke_alc']['sac_smoker']) != "no" || strtolower($aHealthLifeData['ih_smoke_alc']['sac_smoker']) != "n_a")) {
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(40,5,"Smoking Pack Years:", 0, 0, 'L');
                $pdf->SetFont('Arial','B',8);
             
                $pdf->Cell(50,5,$aHealthLifeData['ih_smoke_alc']['txtSmokeDuration'], 0, 1, 'L');
            }

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,5,"Average Sun Exposure:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(30,5,(intval($aHealthLifeData['bmi_eh_sun_expo']['txtSunExpOutdoorAve']) + intval($aHealthLifeData['bmi_eh_sun_expo']['txtSunExpLifeStageAve'])) / 2, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,5,"Average Near Work (hrs):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20,5,(intval($aHealthLifeData['bmi_eh_near_work']['txtNearWorkLifeStageAve']) + intval($aHealthLifeData['bmi_eh_near_work']['txtNearWorkPerDayAve']) + intval($aHealthLifeData['bmi_eh_near_work']['txtNearWorkGadgetAve'])) / 3, 0, 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,5,"GPS Lat^Long [Elevation mtrs]", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $sGPSLoc    =   isset($aHealthLifeData['bmi_eh_location']['txtGPSLoc']) ? $aHealthLifeData['bmi_eh_location']['txtGPSLoc'] : "";
            $pdf->Cell(30,5,$sGPSLoc, 0, 0, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,5,"Distance from the sea (meters):", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);

            $nSeaDist   =   isset($aHealthLifeData['bmi_eh_location']['loc_dist_sea']) ?  $aHealthLifeData['bmi_eh_location']['loc_dist_sea'] : "";
            $pdf->Cell(20,5,$nSeaDist, 0, 1, 'L');

            $pdf->SetFont('Arial','',7);
            $pdf->Cell(40,5,"Socioeconomic Cluster:", 0, 0, 'L');
            $pdf->SetFont('Arial','B',8);
            $nSocieCluster   =   isset($aSocSocioEco['soc_house_fac']['txtSocieCluster']) ? $aSocSocioEco['soc_house_fac']['txtSocieCluster'] : "";
            $pdf->Cell(30,5,$nSocieCluster, 0, 0, 'L');


            $pdf->Ln(5);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'Eye Exam', 'B', 1, 'L');

            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'History', 0, 1, 'L');

            if ($aEyeExamData['hist_ocu_med'] != "") {
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Ocular Medication", 0, 0, 'L');
                $pdf->Cell(25,5,"Dose", 0, 0, 'L');
                $pdf->Cell(25,5,"Eye", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                $pdf->SetFont('Arial','B',8);
                foreach ($aHealthLifeData['hist_ocu_med'] as $key => $aValues) 
                {
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(50,5,$aValues->ocu_medication, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->ocu_medication_dose, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->ocu_medication_eye, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->txtOcuMedDurationAuto, 0, 1, 'L');

                    if($key == 2) {
                        break;
                    }
                }
            }

            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'Symptoms', 0, 1, 'L');

            if ($aEyeExamData['symp_ocu'] != "") {
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"", 0, 0, 'L');
                $pdf->Cell(40,5,"Symptom", 0, 0, 'L');
                $pdf->Cell(25,5,"Duration (month/s)", 0, 1, 'L');

                $aSymptoms = array();
                foreach ($aEyeExamData['symp_ocu'] as $key => $aValues) {
                    if ($aValues->chkOcuSympOd == true) {
                        $aSymptoms['OD']['symptoms']    = $aValues->symp_ocu_symptoms;
                        $aSymptoms['OD']['duration']    = $aValues->symp_ocu_duration;
                    }

                    if ($aValues->chkOcuSympOs == true) {
                        $aSymptoms['OS']['symptoms']    = $aValues->symp_ocu_symptoms;
                        $aSymptoms['OS']['duration']    = $aValues->symp_ocu_duration;
                    } 

                    if ($aValues->chkOcuSympPat == true) {
                        $aSymptoms['PA']['symptoms']    = $aValues->symp_ocu_symptoms;
                        $aSymptoms['PA']['duration']    = $aValues->symp_ocu_duration;
                    }
                }

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Ocular Symptom, OD", 0, 0, 'L');
                if (isset($aSymptoms['OD'])) 
                {
                    $pdf->Cell(40,5,$aSymptoms['OD']['symptoms'], 0, 0, 'L');
                    $pdf->Cell(25,5,$aSymptoms['OD']['duration'], 0, 1, 'L');
                }
                else 
                {
                    $pdf->Cell(40,5,"-", 0, 0, 'L');
                    $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }

                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Ocular Symptom, OD", 0, 0, 'L');
                if (isset($aSymptoms['OS'])) 
                {
                    
                    $pdf->Cell(40,5,$aSymptoms['OS']['symptoms'], 0, 0, 'L');
                    $pdf->Cell(25,5,$aSymptoms['OS']['duration'], 0, 1, 'L');
                }
                else 
                {
                    $pdf->Cell(40,5,"-", 0, 0, 'L');
                    $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }


                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Ocular Symptom, Patient", 0, 0, 'L');
                if (isset($aSymptoms['PA'])) 
                {
                    $pdf->Cell(40,5,$aSymptoms['PA']['symptoms'], 0, 0, 'L');
                    $pdf->Cell(25,5,$aSymptoms['PA']['duration'], 0, 1, 'L');
                }
                else 
                {
                    $pdf->Cell(40,5,"-", 0, 0, 'L');
                    $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }
            }

            $pdf->Ln(5);
            $pdf->SetFont('Arial','',7);
            
            $pdf->Cell(60,5,"VISUAL ACUITY", 1, 0, 'C');
            $pdf->Cell(10,5,"", 0, 0, 'C');
            $pdf->Cell(80,5,"AUTOMATED REFRACTION", 1, 0, 'C');
            $pdf->Cell(10,5,"", 0, 0, 'C');
            $pdf->Cell(30,5,"TONOMETRY", 1, 1, 'C');    

            $pdf->Cell(20,5,"Eye", 1, 0, 'C');
            $pdf->Cell(20,5,"Best Vision", 1, 0, 'C');
            $pdf->Cell(20,5,"W/O Corretion", 1, 0, 'C');

            $pdf->Cell(10,5,"", 0, 0, 'C');

            $pdf->Cell(20,5,"Sphere", 1, 0, 'C');
            $pdf->Cell(20,5,"Cylinder", 1, 0, 'C');
            $pdf->Cell(20,5,"Axis", 1, 0, 'C');
            $pdf->Cell(20,5,"Pupil Distance", 1, 0, 'C');

            $pdf->Cell(10,5,"", 0, 0, 'C');

            $pdf->Cell(30,5,"IOP (mmHg)", 1, 1, 'C');

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(20,5,'OD', 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_vis_acu']['va_right_best_vision'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_vis_acu']['va_right_without_correction'], 1, 0, 'C');

            $pdf->Cell(10,5,"", 0, 0, 'C');

            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_od_sphere'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_od_cylinder'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_od_axis'], 1, 0, 'C');
            $pdf->Cell(20,10,$aEyeExamData['va_auto_refrac']['ar_pupil_distance'], 1, 0, 'C');

            $pdf->Cell(10,5,"", 0, 0, 'C');

            $pdf->Cell(30,5,$aEyeExamData['tono_dila']['intra_press_od'], 1, 1, 'C');

            $pdf->Cell(20,5,'OD', 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_vis_acu']['va_left_best_vision'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_vis_acu']['va_left_without_correction'], 1, 0, 'C');

            $pdf->Cell(10,5,"", 0, 0, 'C');

            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_os_sphere'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_os_cylinder'], 1, 0, 'C');
            $pdf->Cell(20,5,$aEyeExamData['va_auto_refrac']['ar_os_axis'], 1, 0, 'C');

            $pdf->Cell(30,5,"", 0, 0, 'C');

            $pdf->Cell(30,5,$aEyeExamData['tono_dila']['intra_press_os'], 1, 0, 'C');

            $pdf->Ln(5);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'Findings and Diagnosis', 0, 1, 'L');

            if ($aEyeExamData['symp_ocu'] != "") {
                $pdf->SetFont('Arial','',7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Diagnosis", 0, 0, 'L');
                $pdf->Cell(40,5,"Diagnosis", 0, 1, 'L');
                // $pdf->Cell(25,5,"Eye", 0, 1, 'L');

                $aFindings = array();
                foreach ($aEyeExamData['ocu_find_diag'] as $key => $aValues) {
                    if ($aValues->chkDiagOd == true) {
                        $aFindings['OD']['findings']= $aValues->ofd_findings_diagnosis;
                        $aFindings['OD']['eye']     = $aValues->ofd_eye;
                    } 
                    if ($aValues->chkDiagOs == true) {
                        $aFindings['OS']['findings']= $aValues->ofd_findings_diagnosis;
                        $aFindings['OS']['eye']     = $aValues->ofd_eye;
                    } 
                    if ($aValues->chkDiagPat == true) {
                        $aFindings['PA']['findings']= $aValues->ofd_findings_diagnosis;
                        $aFindings['PA']['eye']     = $aValues->ofd_eye;
                    } 
                    if ($aValues->chkCauseVl == true) {
                        $aFindings['VL']['findings']= $aValues->ofd_findings_diagnosis;
                        $aFindings['VL']['eye']     = $aValues->ofd_eye;
                    }
                }   

                $pdf->SetFont('Arial','B', 8);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Diagnosis, OD", 0, 0, 'L');
                
                if (isset($aFindings['OD'])) 
                {
                    $pdf->Cell(40,5,$aFindings['OD']['findings'], 0, 1, 'L');
                    // $pdf->Cell(25,5,$aFindings['OD']['eye'], 0, 1, 'L');
                }
                else {
                    $pdf->Cell(40,5,"-", 0, 1, 'L');
                    // $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }

                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Diagnosis, OS", 0, 0, 'L');
                
                if (isset($aSymptoms['OS'])) 
                {
                    
                    $pdf->Cell(40,5,$aFindings['OS']['findings'], 0, 1, 'L');
                    // $pdf->Cell(25,5,$aFindings['OS']['eye'], 0, 1, 'L');
                }
                else 
                {
                    $pdf->Cell(40,5,"-", 0, 1, 'L');
                    // $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }


                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Diagnosis, Patient", 0, 0, 'L');
                if (isset($aFindings['PA'])) 
                {
                    $pdf->Cell(40,5,$aFindings['PA']['findings'], 0, 1, 'L');
                    // $pdf->Cell(25,5,$aFindings['PA']['eye'], 0, 1, 'L');
                }
                else 
                {
                    $pdf->Cell(40,5,"-", 0, 1, 'L');
                    // $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }

                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Main Cause of Visual Loss", 0, 0, 'L');

                if (isset($aFindings['VL'])) 
                {
                    $pdf->Cell(40,5,$aFindings['VL']['findings'], 0, 1, 'L');
                    // $pdf->Cell(25,5,$aFindings['VL']['eye'], 0, 1, 'L');
                }else {
                    $pdf->Cell(40,5,"-", 0, 0, 'L');
                    // $pdf->Cell(25,5,"-", 0, 1, 'L');   
                }
            }

            $pdf->Ln(3);
            $pdf->SetFont('Arial','B', 7);
            $pdf->Cell(190,5,'Ocular Surgery/Laser/Procedure Objectively Seen During Examination', 'B', 1, 'L');

            if ($aEyeExamData['ocu_exam'] != "") {
                $pdf->SetFont('Arial','', 7);
                $pdf->Cell(25,5,"", 0, 0, 'L');
                $pdf->Cell(50,5,"Ocular Procedure", 0, 0, 'L');
                $pdf->Cell(25,5,"Eye", 0, 0, 'L');
                $pdf->Cell(25,5,"Surgery Outcome", 0, 1, 'L');

                $pdf->SetFont('Arial','B', 8);
                foreach ($aEyeExamData['ocu_exam'] as $key => $aValues) 
                {
                    $pdf->Cell(25,5,"", 0, 0, 'L');
                    $pdf->Cell(50,5,$aValues->olsp_ocu_procedure, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->oslp_eye, 0, 0, 'L');
                    $pdf->Cell(25,5,$aValues->oslp_proc_outcome, 0, 1, 'L');
                }
                
            }

            $pdf->Output('F', 'downloads/'.$sFileName, true);

            return base_url()."downloads/". $sFileName;
            
        }
    }
?>