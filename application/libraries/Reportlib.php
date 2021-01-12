<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

   class Reportlib {
         private $oCI;

         function __construct()
       {
           // Assign by reference with "&" so we don't create a copy
           $this->oCI = &get_instance();
       }

      public function exportReports($aData)
      {

        $aReportData 	= 	array();
        $oExcelClass 	= 	new Spreadsheet();
   
        $sSpName     	=  	"sp_GenerateExcelReport";

        $eQuery     	=  	$this->oCI->hatvclib->execQuery($sSpName, $aData);
        $aResult    	= 	$eQuery->result_array();


        $eQuery->free_result();
        $eQuery->next_result();
         

        foreach ($aResult as $nKey => $aValues) {

            foreach ($aValues as $sColName => $sValue) {
               $aReportData[$aValues['part_region_id']][$aValues['part_household_code']][$sColName] = $sValue;
            }
        }
         

        $sFileName  =  'downloads/Participants_Report_'.ucfirst($aData['type']).'_'.date("M-d-Y").'.xlsx';
        $writer     =  new Xlsx($oExcelClass);

        $nSheetNo   = 0;

        $aHeader    =  array(
         						'part_id'=>array('Participant No.', '20'), 'part_age'=>array('Age', '10'), 'part_gender'=>array('Sex', '10'), 'part_occupation'=>array('Occupation', '35'), 'part_educ_attain_id'=>array('Educational Attainment', '50'),
         						'hist_sys_dis'=>array('Systemic Disease', '25'), 'hist_life_con'=>array('Lifestyle Disease', '25'), 'hist_sys_med'=>array('Systemic Medication', '25'), 'hist_ocu_med'=>array('Ocular Medication Disease', '25'),
         						'bmi_bmi'=>array('BMI Classification', '25'), 'bmi_waist_hip'=>array('', '25'), 'bmi_vital_signs'=> array('', '30'), 'ih_smoke_alc'=> array('Smoking Pack Years', '30'),
         						'bmi_eh_sun_expo'=> array('Sunlight Exposure', '30'), 'bmi_eh_near_work'=> array('Near Work', '25'), 'bmi_eh_location'=>array('', '25'), 'soc_house_fac'=>array('Socioeconomic Cluster', '25'),
         						'va_vis_acu'=>array('', '30'), 'va_auto_refrac'=>array('', '30'), 'tono_dila'=>array('', '15'), 'ocu_find_diag'=>array('', '30'), 'ocu_exam'=>array('', '30')


     						);
         
        $aReturn = array();

        ksort($aReportData);        

        foreach ($aReportData as $nRegionId => $aReportValues)
        {
            $objWorkSheet = $oExcelClass->createSheet($nSheetNo);
            $oExcelClass->setActiveSheetIndex($nSheetNo);
            $oExcelClass->getActiveSheet()->setTitle($nRegionId."_".REGION[abs($nRegionId)]);

            $oExcelClass->getActiveSheet()->setCellValue('A1', 'Household Code');
            $oExcelClass->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $sCol    =  66;
            foreach ($aHeader as $sColName => $aValue)
            {
            	if ($sColName == "bmi_waist_hip") {
            		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Waist-to-Hip Ratio');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);

               		$sCol++;

               		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Waist-to-Height Ratio');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);
               	} else if ($sColName == "bmi_vital_signs") {
            		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Blood Pressure');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);

               		$sCol++;

               		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Blood Glucose Classification');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);
               	} else if ($sColName == "bmi_eh_location") {
            		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'GPS Location');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);

               		$sCol++;

               		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Area Classification');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);

               		$sCol++;

               		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'Distance From the Sea');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);
               	} else if ($sColName == "va_vis_acu") {
            		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'VA-Without-Correction');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);

               		$sCol++;

               		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', 'VA Best Corrected Vision');
               		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);
               	} else if ($sColName == "va_auto_refrac") {
            		$oExcelClass->getActiveSheet()->setCellValue('Y'.'1', 'AR-OD-Sphere');
               		$oExcelClass->getActiveSheet()->getColumnDimension('Z')->setWidth($aValue[1]);
               		

               		$oExcelClass->getActiveSheet()->setCellValue('Z'.'1', 'AR-OD-Cylinder');
               		$oExcelClass->getActiveSheet()->getColumnDimension('Z')->setWidth($aValue[1]);

               		$oExcelClass->getActiveSheet()->setCellValue('AA1', 'AR-OD-Axis');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AA')->setWidth($aValue[1]);
               		

               		$oExcelClass->getActiveSheet()->setCellValue('AB1', 'AR-OS-Sphere');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AB')->setWidth($aValue[1]);
               		

               		$oExcelClass->getActiveSheet()->setCellValue('AC1', 'AR-OS-Cylinder');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AC')->setWidth($aValue[1]);
               		

               		$oExcelClass->getActiveSheet()->setCellValue('AD1', 'AR-OS-Axis');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AD')->setWidth($aValue[1]);
               	} else if ($sColName == "tono_dila") {
               		$oExcelClass->getActiveSheet()->setCellValue('AE1', 'IOP-OD');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AE')->setWidth($aValue[1]);

               		$oExcelClass->getActiveSheet()->setCellValue('AF1', 'IOP-OS');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AF')->setWidth($aValue[1]);

               	} else if ($sColName == "ocu_find_diag") {
               		$oExcelClass->getActiveSheet()->setCellValue('AG1', 'Findings and Diagnostics');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AG')->setWidth($aValue[1]);

               		$oExcelClass->getActiveSheet()->setCellValue('AH1', 'Eye');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AH')->setWidth($aValue[1]);

               	} else if ($sColName == "ocu_exam") {
               		$oExcelClass->getActiveSheet()->setCellValue('AI1', 'Ocular Procedure');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AI')->setWidth($aValue[1]);

               		$oExcelClass->getActiveSheet()->setCellValue('AJ1', 'Eye');
               		$oExcelClass->getActiveSheet()->getColumnDimension('AJ')->setWidth($aValue[1]);

            	} else {
            		$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).'1', $aValue[0]);
              		$oExcelClass->getActiveSheet()->getColumnDimension(chr($sCol))->setWidth($aValue[1]);	
            	}
               	
               $sCol++;
            }
            
            $nRow = 2;
            foreach ($aReportValues as $sHHCode => $aValues) 
            { 
               $nHighestRow	=  0;
               $sCol    	=  65;

               $oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sHHCode);
               $sCol++;
               foreach ($aValues as $sColName => $sValue)
               {  
               		$nLastRow 	=  $nRow;
                  	if (isset($aHeader[$sColName])) 
                  	{
	                    if ($sColName == "part_occupation") {
	                       $oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, OCCUPATION[$sValue]);
	                    } else if ($sColName == "part_educ_attain_id") {
	                       $oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, EDUCATION[strtolower($sValue)]);
	                       // / h.``, h.``,
						} else if ($sColName == "hist_sys_dis" || $sColName == "hist_life_con" || $sColName == "hist_sys_med" || $sColName == "hist_ocu_med") {

							if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);

								switch ($sColName) {
									case 'hist_sys_dis': $sColumn = "hist_sys_disease"; break;
									case 'hist_life_con': $sColumn = "hist_life_condition"; break;
									case 'hist_sys_med': $sColumn = "hist_sys_medication"; break;
									case 'hist_ocu_med': $sColumn = "ocu_medication"; break;
								}

								foreach ($aJsonArray as $nKey => $aHistory) {
									$oExcelClass->getActiveSheet()->setCellValue('A'.$nLastRow, $aValues['part_household_code']);
									$oExcelClass->getActiveSheet()->setCellValue('B'.$nLastRow, $aValues['part_id']);
									if (isset($aHistory->$sColumn)) {
										if ($aHistory->$sColumn !== "n_a") {
											$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nLastRow, $aHistory->$sColumn);
										} else {
											$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nLastRow, '');
										}
									} else {
										$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nLastRow, '');
									}
									$nLastRow++;
								}
							} else {
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nLastRow, '');
							}
						} else if ($sColName == "ocu_find_diag") {
							if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								foreach ($aJsonArray as $nKey => $aFindDiag) {
									
									$oExcelClass->getActiveSheet()->setCellValue('A'.$nLastRow, $aValues['part_household_code']);
									$oExcelClass->getActiveSheet()->setCellValue('B'.$nLastRow, $aValues['part_id']);

									if (isset($aFindDiag->ofd_findings_diagnosis)) 
									{
										if ($aFindDiag->ofd_findings_diagnosis !== "n_a") {
											$oExcelClass->getActiveSheet()->setCellValue('AG'.$nLastRow, $aFindDiag->ofd_findings_diagnosis);
											$oExcelClass->getActiveSheet()->setCellValue('AH'.$nLastRow, $aFindDiag->ofd_eye);
										} else {
											$oExcelClass->getActiveSheet()->setCellValue('AG'.$nLastRow, '');
											$oExcelClass->getActiveSheet()->setCellValue('AH'.$nLastRow, '');
										}
									} else {
										$oExcelClass->getActiveSheet()->setCellValue('AG'.$nLastRow, '');
										$oExcelClass->getActiveSheet()->setCellValue('AH'.$nLastRow, '');
									}

									$nLastRow++;
								}
							} else {
								$oExcelClass->getActiveSheet()->setCellValue('AG'.$nLastRow, '');
								$oExcelClass->getActiveSheet()->setCellValue('AH'.$nLastRow, '');
							}

						} else if ($sColName == "ocu_exam") {
							if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								foreach ($aJsonArray as $nKey => $aOcuExam) {
									
									$oExcelClass->getActiveSheet()->setCellValue('A'.$nLastRow, $aValues['part_household_code']);
									$oExcelClass->getActiveSheet()->setCellValue('B'.$nLastRow, $aValues['part_id']);

									if (isset($aOcuExam->olsp_ocu_procedure)) 
									{
										if ($aOcuExam->olsp_ocu_procedure !== "n_a") {
											$oExcelClass->getActiveSheet()->setCellValue('AI'.$nLastRow, $aOcuExam->olsp_ocu_procedure);
											$oExcelClass->getActiveSheet()->setCellValue('AJ'.$nLastRow, $aOcuExam->oslp_eye);
										} else {
											$oExcelClass->getActiveSheet()->setCellValue('AI'.$nLastRow, '');
											$oExcelClass->getActiveSheet()->setCellValue('AJ'.$nLastRow, '');
										}
									} else {
										$oExcelClass->getActiveSheet()->setCellValue('AI'.$nLastRow, '');
										$oExcelClass->getActiveSheet()->setCellValue('AJ'.$nLastRow, '');
									}

									$nLastRow++;

								}
							} else {
								$oExcelClass->getActiveSheet()->setCellValue('AI'.$nLastRow, '');
								$oExcelClass->getActiveSheet()->setCellValue('AJ'.$nLastRow, '');
							}

						} else if ($sColName == "bmi_bmi") {
							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$sBmiClass 	=	isset($aJsonArray->txtBmiClass) ? $aJsonArray->txtBmiClass : "";

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sBmiClass);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "bmi_waist_hip") {
							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);

								$nWaistHipRatio 	=	isset($aJsonArray->txtWaistHipRatio) ? $aJsonArray->txtWaistHipRatio : "";
								$nWaistHeightRatio 	=	isset($aJsonArray->txtWaistHipRatio) ? $aJsonArray->txtWaistHeightRatio : "";
								
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nWaistHipRatio);								

								$sCol++;
								
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nWaistHeightRatio);
								
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// 	$sCol++;
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "bmi_vital_signs") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);

								$nSystolic 		=	isset($aJsonArray->vs_bp_systolic) ? $aJsonArray->vs_bp_systolic : "0";
								$nDiastolic 	=	isset($aJsonArray->vs_bp_diastolic) ? $aJsonArray->vs_bp_diastolic : "0";
								$sGlucoseClass 	=	isset($aJsonArray->txtClassification) ? $aJsonArray->txtClassification : "0";
								
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nSystolic."/".$nDiastolic);
								
								$sCol++;

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sGlucoseClass);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// 	$sCol++;
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "ih_smoke_alc") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$sPackYears	=	isset($aJsonArray->txtSmokeDuration) ? $aJsonArray->txtSmokeDuration : "";

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sPackYears);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "bmi_eh_sun_expo") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$nLifeStage	=	isset($aJsonArray->txtSunExpLifeStageAve) ? $aJsonArray->txtSunExpLifeStageAve : 0;
								$nOutdoor 	=	isset($aJsonArray->txtSunExpOutdoorAve) ? $aJsonArray->txtSunExpOutdoorAve : 0;

								$fAveRage	=	($nLifeStage + $nOutdoor) > 0 ? number_format((($nLifeStage + $nOutdoor) / 2) ,2) : 0;

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $fAveRage);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "bmi_eh_near_work") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$nLifeStage	=	isset($aJsonArray->txtNearWorkLifeStageAve) ? $aJsonArray->txtNearWorkLifeStageAve : ""; 
								$nPerDay	=	isset($aJsonArray->txtWorkPerDayAve) ? $aJsonArray->txtWorkPerDayAve : ""; 
								$nGadget	=	isset($aJsonArray->txtNearWorkGadgetAve) ? $aJsonArray->txtNearWorkGadgetAve : ""; 

								$fNearWork	=	($nLifeStage + $nPerDay + $nGadget) > 0 ? number_format((($nLifeStage + $nPerDay + $nGadget) / 3), 2) : 0;

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $fNearWork);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "bmi_eh_location") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$sGPsLoc	=	isset($aJsonArray->txtGPSLoc) ? $aJsonArray->txtGPSLoc : ""; 
								$sAreaClass	=	isset($aJsonArray->loc_area_class) ? $aJsonArray->loc_area_class : ""; 
								$nDistSea	=	isset($aJsonArray->loc_dist_sea) ? $aJsonArray->loc_dist_sea : ""; 								

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sGPsLoc);
								$sCol++;
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sAreaClass);
								$sCol++;
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nDistSea);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "soc_house_fac") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);
								$nSocieCluster	=	isset($aJsonArray->txtSocieCluster) ? $aJsonArray->txtSocieCluster : "";

								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nSocieCluster);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }

						} else if ($sColName == "va_vis_acu") {

							// if (!empty($sValue)) {
							// 	$aJsonArray	=	json_decode($sValue);
							// 	$nSocieCluster	=	isset($aJsonArray->txtSocieCluster) ? $aJsonArray->txtSocieCluster : "";

							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $nSocieCluster);
								
							// } else {
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
								$sCol++;
								$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }
						} else if ($sColName == "va_auto_refrac") {

							$aJsonArray	=	json_decode($sValue);

							$fArOdSphere	=	isset($aJsonArray->ar_od_sphere) ? $aJsonArray->ar_od_sphere : "";
							$fArOdCylinder	=	isset($aJsonArray->ar_od_cylinder) ? $aJsonArray->ar_od_cylinder : "";
							$fArOdAxis		=	isset($aJsonArray->ar_od_axis) ? $aJsonArray->ar_od_axis : "";

							$fArOsSphere	=	isset($aJsonArray->ar_os_sphere) ? $aJsonArray->ar_os_sphere : "";
							$fArOsCylinder	=	isset($aJsonArray->ar_os_cylinder) ? $aJsonArray->ar_os_cylinder : "";
							$fArOsAxis		=	isset($aJsonArray->ar_os_axis) ? $aJsonArray->ar_os_axis : "";

							$oExcelClass->getActiveSheet()->setCellValue('Y'.$nRow, $fArOdSphere);
							$oExcelClass->getActiveSheet()->setCellValue('Z'.$nRow, $fArOdCylinder);
							$oExcelClass->getActiveSheet()->setCellValue('AA'.$nRow, $fArOdAxis);
							$oExcelClass->getActiveSheet()->setCellValue('AB'.$nRow, $fArOsSphere);
							$oExcelClass->getActiveSheet()->setCellValue('AC'.$nRow, $fArOsCylinder);
							$oExcelClass->getActiveSheet()->setCellValue('AD'.$nRow, $fArOsAxis);
							
						} else if ($sColName == "tono_dila") {

							// if (!empty($sValue)) {
								$aJsonArray	=	json_decode($sValue);

								$fIopOd		=	isset($aJsonArray->intra_press_od) ? $aJsonArray->intra_press_od : "";
								$fIopOs		=	isset($aJsonArray->intra_press_os) ? $aJsonArray->intra_press_os : "";

								$oExcelClass->getActiveSheet()->setCellValue('AE'.$nRow, $fIopOd);
								$oExcelClass->getActiveSheet()->setCellValue('AF'.$nRow, $fIopOs);
								
							// } else {
							// 	$oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, '');
							// }

	                    } else {
	                       $oExcelClass->getActiveSheet()->setCellValue(chr($sCol).$nRow, $sValue);
	                    }
	                     
	                    $sCol++;
                  	}

                  	$nHighestRow = ($nLastRow > $nHighestRow) ? $nLastRow : $nHighestRow;
               }
               $nRow = $nHighestRow;
            }
            $nSheetNo++;
         }
         
         $oExcelClass->removeSheetByIndex($oExcelClass->getIndex($oExcelClass->getSheetByName('Worksheet')));
         $writer->save($sFileName);

         return $sFileName;
      }
   }
?>