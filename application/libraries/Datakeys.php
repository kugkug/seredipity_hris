<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	

	class Datakeys {

		private $aDatakeys 	= array(

			"DataId" 		=> 'id',
			"RequestId" 		=> 'id',

			"ClientAddress" =>  'client_address',
			"BranchId" 	=>	'branch_id',
			"ClientBrgy" 	=>	'client_brgy',
			"ClientCity" 	=>	'client_city',
			"ClientId" 		=>	'client_id',
			"ClientName" 	 	=>	'client_name',
			"ClientPayrollPeriod" 	=>	'client_payroll_period',
			"ClientPeriodFrom"  =>	'client_period_from',
			"ClientPeriodTo" =>	'client_period_to',
			"ClientRegion"	=>	'client_region',
			"ClientSegments" =>	'client_segment',
			"ClientTel"		=>	'client_telno',
			"ClientEmail"		=>	'client_email',
			"ClientTinNo" 	=>	'client_tinno',
			"PaymentSched" 	=>	'client_payment_sched',
			"PayrollCutOff" 	=>	'client_payroll_cutoff',
			"PaymentSchedFrom"	=>	'client_payment_sched_from',
			"PaymentSchedTo" => 'client_payment_sched_to',
			"PayrollCutOffFrom" => 'client_cutoff_from',
			"PayrollCutOffTo" => 'client_cutoff_to',


			"AgentTrxId" => 'agent_trx_id',
			"AgentId" => 'agent_id',
			"EmpId" => 'agent_empid',
			"FirstName" =>'agent_fname',
			"LastName" =>'agent_lname',
			"MiddleName" =>'agent_mname',
			"SuffixName" =>'agent_sname',
			"NickName" =>'agent_nname',
			"DateOfBirth" =>'agent_bday',
			"Age" => 'agent_age',
			"EmpTelNo" => 'agent_telno',
			"EmpCellNo" => 'agent_celno',
			"EmpAddress" => 'agent_address',
			"AgentStatus" => 'agent_status',
			"AppstatId" => 'agent_standing',
			"AgentComments" => 'agent_comments',

			"Gender" =>'agent_gender',
			"Citizenship" => 'agent_citizenship',
			"CivilStatus" => 'agent_civil_status',
			"Religion" => 'agent_religion',
			"HeightFt" =>'agent_ht_ft',
			"HeightIn" =>'agent_ht_in',
			"Weight" => 'agent_weight',
			
			"DateHired" =>'agent_date_hired',
			"EmpSign" =>'agent_signature',
			"Position1" =>'agent_position1',
			"Position2" =>'agent_position2',
			"Position3" =>'agent_position3',
			"Salary" =>'agent_opt_salary',
			"Photo" => 'part_photo',
			"AgentNote" => 'agent_note',

			"EntryBy" => 'entryby',
			"EntryDate" => 'entrydate',
			"ModifyBy" => 'modifiedby',
			"ModifyDate" => 'modifieddate',
			"DeleteBy" => 'deletedby',
			"DeleteDate" => 'deleteddate',

			"SupId" => 'sup_id',
			"SupFname" =>'sup_fname',
			"SupLname" =>'sup_lname',
			"SupMname" =>'sup_mname',
			"SupBday" =>'sup_dob',
			"PositionId" =>'sup_position',

			"DeptId"	=>	"dept_id",
			"ShiftId"=> 'shift_id',
			"ReligionId"=> 'religion_id',

			"SssNo" => 'agent_sssno',
			"TinNo" => 'agent_tinno',
			"PhilhealthNo" => 'agent_philhealthno',
			"PagibigNo" => 'agent_pagibigno',
			"FacebookLink" => 'agent_facebook',
			"EmerPerson" => 'agent_emergency_person',
			"EmerAddress" => 'agent_emergency_address',
			"EmerNumber" => 'agent_emergency_contact',

			'EmpNo'	=> 'emp_no',
			'LogPhoto'	=> 'log_photo',
			'LogDate'	=> 'log_date',
			'LogTime'	=> 'log_time',

			'DeviceIP'	=> 'device_ip',

			//Education
			'EducType' 		=>	'educ_type',
			'EducSchool'	=>	'educ_school',
			'EducCourse'	=>	'educ_course',
			'EducYearStart'	=>	'educ_year_start',
			'EducYearEnd' 	=>	'educ_year_end',
			'EducFile' 		=>	'educ_attachment',

			//Skills
			'Skills' 		=>	'skills',
			'SkillsDesc'	=>	'skills_description',
			'SkillsLevel'	=>	'skills_level',
			'SkillFile'		=>	'skills_attachment',

			//Training
			'TrainTitle' 	=>	'training_title',
			'TrainDesc'		=>	'training_description',
			'TrainDocNo'	=>	'training_doc_no',
			'TrainFile'		=>	'training_attachment',

			//Employment
			'JobPosition' 	=>	'job_position',
			'JobEmployer'	=>	'job_employer',
			'JobAddress'	=>	'job_address',
			'JobReason'		=>	'job_reason',
			'JobDuties' 	=>	'job_duties',
			'JobAccomp'		=>	'job_accomplishment',
			'JobStarted'	=>	'job_started',
			'JobEnded'		=>	'job_ended',
			'JobFile'		=>	'job_attachment',

			//Medical
			'MedDesc'		=>	'medical_description',
			'MedHosp'		=>	'medical_hospital',
			'MedStatus'		=>	'medical_status',
			'MedTaken'		=>	'medical_taken',
			'MedIssued'		=>	'medical_issued',
			'MedExpiry'		=>	'medical_expiry',
			'MedFile'		=>	'medical_attachment',


			//Requirements
			'NbiFile'		=>	'nbi_clearance',
			'Policefile'	=>	'police_clearance',
			'BrgyFile'		=>	'brgy_clearance',
			'ResiFile'		=>	'residence_proof',
			'EmpCert'		=>	'employment_certificate',
			'BirthCert'		=>	'birth_certificate',
			'MarrCont'		=>	'marriage_contract',
			'HealthCert'	=>	'health_certificate',
			'MedRes'		=>	'medical_result',
			'XrayRes'		=>	'xray_result',
			'DrugRes'		=>	'drug_result',
			'DriverLic'		=>	'driver_license',

			"ReqManPower" => 'request_man_power',
			"ReqBenefits" => 'request_benefits',
			"ReqBenifits" => 'request_benefits',
			"ReqSchedDate" => 'request_interview_date',
			"ReqSchedTime" =>'request_interview_time',
			"ReqContactPerson" =>'request_contact_person',
			"ReqContactNumber" =>'request_contact_number',
			"ReqContactEmail" =>'request_contact_email',
			"ReqNature" =>'request_nature',
			"ReqQualifications" =>'request_qualifications',
			"NatureDuration" => 'request_duration',
			"BasicLicenseCode" => 'request_license_code',
			"ReqPositions" => 'request_positions',
			"ReqJobDesc" => 'request_job_description',
			"ReqRequestedBy" => 'request_by',
			"ReqExpeNeeded" => 'request_experience',
			"ReqNotedBy" => 'request_noted_by',
			"ReqStartDate" => 'request_start_date',
			"ReqStatus" => 'request_status',
			"ReqNotes" => 'request_notes',
			"ReqCandidates" => 'request_candidates',
			"ReqPassCode" => 'request_passcode',


		);

		public function getKey($sDataKey) {

			return $this->aDatakeys[$sDataKey];
		}

		public function getValue($sValue) {

			return array_search($sValue, $this->aDatakeys);
		}
	}

?>