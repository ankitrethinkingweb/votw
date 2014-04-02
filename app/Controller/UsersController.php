<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('File', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));

class UsersController extends AppController {

	public $helpers = array('Html', 'Form', 'Session', 'Usermgmt.NumberToWord');
	var $scaffold;
	public $components = array('Session');
	public $uses = array(
        'User',
        'Relation','AppMeta','Admin'
        );

        public function visa_app($id = null,$uid=0)
        {
        	$empType1 = array(''=>'Select'); 
        	$empData = $this->User->query('Select * from emp_type_master Where status=1');
        	$empType2 = Set::combine($empData, '{n}.emp_type_master.emp_type_id', '{n}.emp_type_master.emp_type');	
        	$empType3 = array('other'=>'Other');
        	$empType = $empType1 + $empType2 + $empType3;
        	$this->set('empType', $empType);
        			
        	$relation=$this->get_dropdown('relation_id', 'relation','relation_master');
        	$this->set('relation', $relation);

        	$marital_status=$this->get_dropdown('marital_id', 'marital_status','marital_master');
        	$this->set('marital_status', $marital_status);

        	$language=$this->get_dropdown('lang_id', 'language','language_master');
        	$this->set('language', $language);

        	$country=$this->get_dropdown('country_id', 'country','country_master');
        	$this->set('country', $country);

        	$religion=$this->get_dropdown('religion_id', 'religion','religion_master');
        	$this->set('religion', $religion);

        	$profession=$this->get_dropdown('prof_id', 'profession','profession_master');
        	$this->set('profession', $profession);

        	$education=$this->get_dropdown('education_id', 'education','education_master');
        	$this->set('education', $education);

        	$airline=$this->get_dropdown('airline_id', 'airline','airline_master');
        	$this->set('airline', $airline);

        	$currency=$this->get_dropdown('currency_id', 'currency','currency_master');
        	$this->set('currency', $currency);

        	$passport_type=$this->get_dropdown('pass_type_id', 'passport_type','passport_type_master');
        	$this->set('passport_type', $passport_type);

        	if($this->UserAuth->getGroupName() != 'Admin')
        	$uid = $this->UserAuth->getUserId();

        	$visa_type=$this->get_visa_dropdown($uid);
        	$this->set('visa_type', $visa_type);

        	$visit_purpose =$this->get_dropdown('purpose_id', 'purpose','visit_purpose_master');
        	$this->set('visit_purpose', $visit_purpose);

        	$emp_type=$this->get_dropdown('emp_type_id', 'emp_type','emp_type_master');
        	$this->set('emp_type', $emp_type);

        	$travel_city=$this->get_dropdown('travel_city_id', 'travel_city','travel_city_master');
        	$this->set('travel_city', $travel_city);

        	if(strlen($id) == 0)
        	$this->render('group_visa_app');
        	//$this->render('visa_app');
        }

        function get_dropdown($id_key, $value_key, $table ){
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = $table;
        	$result=$this->Relation->query("Select * From ".$table." Where status <> 0 order by ".$value_key." asc");
        	$data =array();
//if($table = 'emp_type_master')
//$data[] = 'Select'; 
//else
$data['select']='Select';

        	foreach ($result as $row)
        	{
        		$data[$row[$table][$id_key]]=$row[$table][$value_key];
        	}
        	return $data;

        }

 		function get_admin_tr_status_dropdown(){
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = 'admin_tr_status';
        	$result=$this->Relation->query("Select * From admin_tr_status Where status = 1 order by atr_status_id asc");
        	$data =array();

        	$data['select']='Select';

        	foreach ($result as $row)
        	{
        		$data[$row['admin_tr_status']['atr_status_id']]=$row['admin_tr_status']['atr_status'];
        	}
        	return $data;
        }
        
        function get_visa_dropdown($id=null){

        	$result=$this->User->query("Select * From visa_type_master Where status = 1");
        	$data =array();

        	$data['select']='Select';

        	foreach ($result as $row)
        	{
        		if($id == null){
        			$data[$row['visa_type_master']['visa_type_id']]=$row['visa_type_master']['visa_type'] . ' - ' .$row['visa_type_master']['visa_scost'] .' (INR)';

        		}else{
			$currency = $this->currency_val($id);
        	//$this->set('currency',$currency);
        			
        			$data1 = $this->User->query('Select * From visa_cost Where user_id = '.$id.' and visa_type = '.$row['visa_type_master']['visa_type_id']);
        			if(count($data1) > 0){
        				$amt  = 0;
        				if($data1[0]['visa_cost']['visa_scost'] != null && strlen($data1[0]['visa_cost']['visa_scost']) > 0) $amt = $data1[0]['visa_cost']['visa_scost'];
        				$data[$row['visa_type_master']['visa_type_id']] = $row['visa_type_master']['visa_type'] .' - '. $amt.' ('.$currency.')';
        			}else
        			$data[$row['visa_type_master']['visa_type_id']]=$row['visa_type_master']['visa_type'] . ' - ' .$row['visa_type_master']['visa_scost'].' ('.$currency.')';
        		}
        	}
        	return $data;

        }
        
        public function save_app()
        {
        	//	print_r($this->request->data);
        	if ($this->request->isPost()) {
        		$this->User->set($this->data);
        		$this->set('data', $this->data);
        		$visaNo = array(); $visa_array = array();
        		$visaNo = $this->User->query('Select group_id,group_no From visa_app_group ');
        		$visa_array = Set::combine($visaNo,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_no');
        		
        		$random =rand(111111,999999);
        		$group_no1 = 'GVG-'.$random;
        		//$group_no1 = 'GVG-368980';
        		$group_no = $this->get_visa_no($group_no1,$visa_array,'group');
        	
        		$this->request->data['User']['group_no'] = $group_no;
        		$this->request->data['User']['app_date'] = date('d-m-Y H:i:s');
        		$this->request->data['User']['user_id'] =  $this->UserAuth->getUserId();
        		$this->request->data['User']['tent_date'] = $this->request->data['User']['tent_yy'].'-'.$this->request->data['User']['tent_mm'].'-'.$this->request->data['User']['tent_dd'];
        		if(isset($this->request->data['show']) && $this->request->data['show'] == 1){
        			$this->User->query('Update visa_app_group set visa_type = "'.$this->request->data['User']['visa_type'].'",tent_date = "'.$this->request->data['User']['tent_date'].'",citizenship = "'.$this->request->data['User']['citizenship'].'",destination = "'.$this->request->data['User']['destination'].'",adult = "'.$this->request->data['User']['adult'].'",children = "'.$this->request->data['User']['children'].'",infants="'.$this->request->data['User']['infants'].'" Where group_id = '.$this->request->data['groupId']);
        			$groupId = $this->request->data['groupId'];
        			$this->get_data();
        		}else{
        			$this->User->query('Insert into visa_app_group(group_no,user_id,visa_type,tent_date,citizenship,destination,adult,children,infants,app_date,status) values("'.$this->request->data['User']['group_no'].'","'.$this->request->data['User']['user_id'].'","'.$this->request->data['User']['visa_type'].'","'.$this->request->data['User']['tent_date'].'","'.$this->request->data['User']['citizenship'].'","'.$this->request->data['User']['destination'].'","'.$this->request->data['User']['adult'].'","'.$this->request->data['User']['children'].'","'.$this->request->data['User']['infants'].'","'.$this->request->data['User']['app_date'].'",0)');
        			$visa_grp_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        			$groupId = $visa_grp_Id[0][0]['id'];
        				
        			$this->autoRender = false;
        				
        			$this->visa_app(1);

        			$this->set('groupId', $groupId);
        			$this->render('visa_app');
        		}
        	}
        }
        public function save_visa_app()
        {
        	$app=array();
        	if ($this->request -> isPost()) {
        		$this->User->set($this->data);
        		$visaNo = array(); $visa_array = array();
					$visaNo = $this->User->query('Select app_id,app_no From visa_tbl Where 1');
					$visa_array = Set::combine($visaNo,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
					
        		$ak = 1; $bk = 1; $ck = 1;
        		$a = $this->request->data['adult']; $b = $this->request->data['adult']+$this->request->data['children'];
        		for($i=1;$i<=$this->request->data['hid_count1'];$i++){
        			if($a != 0 && $i <= $a){  $id = '-A'.$ak;$ak++; }
        			else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $bk++;}
        			else{ $id = '-I'.$ck; $ck++;}
        				
        				
        			$data =$this->User->find('all',array('conditions'=>array('passport_no'=>1)));
        			if(is_array($data) and count($data) > 0)
        			{
        				$this->Session->setFlash(__('You have already applied for Passport No : '.$this->request->data['User']['passport_no'.$id] .'!'));
        				$this->autoRender = false;
        				$this->set('data',$this->data);
        				$this->set('show',1);
        				$this->visa_app();
        			}else{
        				$this->User->query('Update visa_app_group set status = 1 Where group_id ='.$this->request->data['groupId']);
        				$this->User->useTable = 'visa_tbl';
        				$this->User->create();
        				$random =rand(111111,999999);
        				$visa_no1 = 'GV-'.$random;
        				$visa_no = $this->get_visa_no($visa_no1,$visa_array);
        			
        				$this->request->data['User']['app_no'] = $visa_no;
        				$this->request->data['User']['create_date'] = date('d-m-Y');
        				$this->request->data['User']['user_id'] = $this->UserAuth->getUserId();
        				$this->request->data['User']['group_id'] = $this->request->data['groupId'];
        				$this->request->data['User']['passport_no'] = $this->request->data['User']['passport_no'.$id];
        				$this->request->data['User']['first_name'] = $this->request->data['User']['given_name'.$id];
        				$this->request->data['User']['last_name'] = $this->request->data['User']['surname'.$id];
        				$this->User->save($this->request->data,true);
        				$userId=$this->User->getLastInsertID();

        				$detail =  array('given_name'.$id,'surname'.$id,'spouse_name'.$id,'father_name'.$id,'mother_name'.$id,'gender'.$id,'marital_status'.$id,'language'.$id,'pre_nationality'.$id,'dob_dd'.$id,'dob_mm'.$id,'dob_yy'.$id,'birth_place'.$id,'religion'.$id,'education'.$id,'passport_type'.$id,'passport_no'.$id,'issue_country'.$id,'doi_dd'.$id,'doi_mm'.$id,'doi_yy'.$id,'issue_place'.$id,'doe_dd'.$id,'doe_mm'.$id,'doe_yy'.$id,'pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id);
        				$visa_data = array('pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id);
        				foreach($visa_data as $v) $this->request->data['User'][$v] = '';
        				$group_data = array('add_doc1','add_doc2','add_doc3','add_doc4');
        				foreach($group_data as $gd) $this->request->data['User'][$gd] = '';

        				if($i == 1){
        					$grp_data = array('email_id','address1','address2','city','country','pin','std_code','phone','emp_type','occupation','company_name','company_address','company_contact','designation','last_doe_dd','last_doe_mm','last_doe_yy','arr_airline','arrival_flight','arr_date_dd','arr_date_mm','arr_date_yy','arrival_time','arr_pnr_no','dep_airline','departure_flight','dep_date_dd','dep_date_mm','dep_date_yy','departure_time','dep_pnr_no','add_doc1','add_doc2','add_doc3','add_doc4','remarks','applicant');
        					foreach($this->request->data['User'] as $key => $value)
        					{
        						if(in_array($key,$grp_data)){
        							$this->User->query('Insert into group_meta(group_id,meta_key,meta_value) values('.$this->request->data['User']['group_id'].',"'.$key.'","'.$value.'")');
        						}
        					}
        				}
        				
        				foreach($this->request->data['User'] as $key => $value)
        				{
        					if(in_array($key,$detail)){
        						$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$key.'","'.$value.'")');
        					}
        				}
        				$app_data = 'app_no'.$id;
        				$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$app_data.'","'.$this->request->data['User']['app_no'].'")');
        			}
        		}
        		$this->Session->setFlash(__('Visa Application Details Submitted Successfully. Now Upload the required documents'));

        		$data = $this->get_upload_data($this->request->data['groupId']);
        		if(is_array($data)){
        			foreach($data as $keys=>$values){
        				$app['User'][$keys]=$values;
        			}
        		}
        		//print_r($app);
        		$this->set('data',$app);
        		$this->set('groupId',$this->request->data['groupId']);
        		$this->autoRender = false;
        		$this->visa_app(1);
        		$this->render('upload');
        	}else{
        		$this->autoRender = false;
        		$this->visa_app();
        	}
        }


        public function get_upload_data($groupId){

        	if (!empty($groupId)) {
        		$id = $groupId;
        		$data[0] = '';
        		$this->autoRender = false;
        		$this->Relation->useTable = 'visa_tbl';
        		$data = $this->Relation->query('select * from visa_tbl where group_id='.$id);
        		$this->Relation->useTable = 'visa_app_group';
        		$grp_data = $this->Relation->query('select * from visa_app_group where group_id='.$id.' and status = 1');
        		if(is_array($grp_data)){
        			foreach($grp_data as $g){
        				$adult = $g['visa_app_group']['adult']; $child = $g['visa_app_group']['children']; $infants = $g['visa_app_group']['infants'];
        				$appdata['count'] = $adult + $child + $infants;

        				$appdata['group_no'] = $g['visa_app_group']['group_no'];
        				$appdata['visa_type'] = $g['visa_app_group']['visa_type'];
        				$appdata['adult'] = $g['visa_app_group']['adult'];
        				$appdata['children'] = $g['visa_app_group']['children'];
        				$appdata['infants'] = $g['visa_app_group']['infants'];

        			}
        		}
        		//echo '<pre>'; print_r($appdata);

        		$grp_meta_data =  $this->Relation->query('select * from group_meta where group_id='.$id);
        		foreach($grp_meta_data as $gm){
        			$appdata[$gm['group_meta']['meta_key']] = $gm['group_meta']['meta_value'];
        		}

        		if(is_array($data)){ foreach($data as $d){
        			$res = $this->Relation->query('select * from visa_meta where app_id='.$d['visa_tbl']['app_id']);
        			foreach($res as $r){
        				$appdata[$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        			}
        		}
        		}
        		return $appdata;
        	}
        }


        public function zipData($group = ''){
        	$this->autoRender = false;
        	$zip_file_name = WWW_ROOT.'zip/'.$group.'.zip';
        	$src = WWW_ROOT.'uploads/'.$group;
        	if(file_exists($zip_file_name))
        	{
        		header("Content-Type: application/zip");
        		header("Content-Disposition: attachment; filename=".$group.'.zip');
        		header('Content-Length: '.filesize($zip_file_name));
        		readfile($zip_file_name);
			}else{
        		$this->Session->setFlash(__('Sorry !! You Can Not Export This Application.'));
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$data = $this->get_visa_data();
        		$this->autoRender = false;
        		$this->render('all_visa_app');
        	}
        	//return;

        }

        public function currency_val($id){
        	$data = array(); $currency = 'INR';

        	$data = $this->User->query('Select * From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$id.' and currency_master.status = 1');	
	        if(count($data) > 0)
	        	$currency = $data[0]['currency_master']['currency_code'];
	        //	echo $currency; exit;
      
        	return $currency;
        }
        
        public function all_visa_app($app= null,$status = null)
        {
        	$userId=$this->UserAuth->getUserId(); $total= 0;
        	$atr_status = $this->get_admin_tr_status_dropdown();
	        $this->set('atr_status', $atr_status);
        	$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	$this->set('tr_status', $tr_status);
        	$data = $this->get_visa_data($app,$status);
        	//$this->getVisa($app,$status);
        
        }

 public function get_visa_data($app=null,$status = null){
        	$this->User->useTable = '';
        	
        	//echo $this->Session->read('role1.visa_type') ; exit;
			if($app == 0 && $app != 'all') $app = null; $visa_apps = array();
			//echo $app; exit;
        	$appData  = array(); $app_no = array(); $gData  = array(); $sData = array();  
        	if($status == null){
        		if($this->UserAuth->getGroupName() != 'User'){ 
	        		$this->User->useTable = 'visa_app_group';
	        		if($app == 'all'){
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc limit 0,200');
	        		}else if($app == null ){
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status  > 1 order by group_id desc limit 0,200');
	        		}else{
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status="'.$app.'" order by group_id desc limit 0,200');}
	        		}else if($this->UserAuth->getGroupName() == 'User'){
	        		
	        		$userId=$this->UserAuth->getUserId(); 
	        		$this->User->useTable = 'visa_app_group';
	        		if($app == 'all') 
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc limit 0,200');
	        		else if($app == null || $app == 0)
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' order by group_id desc limit 0,200');
	        		else
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' and tr_status="'.$app.'" order by group_id desc limit 0,200');
	        	}
	        	
        	}else{
        		
        		if($this->UserAuth->getGroupName() != 'User'){ 
	        		$this->User->useTable = 'visa_app_group'; 
	        	if($app == 'all'){
	        			
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc'); 
	        	}else if($app == null || $app == 0){  
	        			
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status  > 1 order by group_id desc'); 
        		}else{  
	        			if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
        				$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status "'.$app.'" and visa_type in ('.$this->Session->read('role1.visa_type').') order by group_id desc');
	        			else
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status "'.$app.'" order by group_id desc'); 
        		}
        		
        		}else if($this->UserAuth->getGroupName() == 'User'){
	        			$userId=$this->UserAuth->getUserId(); 
					$this->User->useTable = 'visa_app_group';
        			if($app == 'all') { 
        				$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc ');
        			}else if($app == null || $app == 0){
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' order by group_id desc');
	        		}else{
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' and tr_status="'.$app.'" order by group_id desc');
	        		}
	        	}
        	}
//echo count($visa_apps) ; exit;
        	if( count($visa_apps) > 0){ 
        		$visa_id = '';
        		$visaData = Set::combine($visa_apps, '{n}.visa_app_group.group_id', '{n}.visa_app_group.group_id');
        		$visa_id = implode(',',$visaData);
        		if(strlen($visa_id) > 0){
        			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0){
$visa_apps2 = $this->User->query('Select * From visa_app_group Where group_id in ('.$visa_id.') and visa_type in ('.$this->Session->read('role1.visa_type').') ');
					}else 
		        	$visa_apps2 = $this->User->query('Select * From visa_app_group Where group_id in ('.$visa_id.')');
        		}else $visa_apps2 = $visa_apps;
        	}
        	if(isset($visa_apps2)){
        	$this->set('visa_apps',$visa_apps2);
			   $date = array();
        	
        	$visa_type='';$status='';$username = '';$applicant= '';$k = 1; $astatus = '';$app_no ='';$gData = ''; $sData = '';
        	
        	$userData = $this->User->query('Select id,username From users Where status = 1');
        	$username = Set::combine($userData,'{n}.users.id','{n}.users.username');
        	$receipt = array();
        	$receiptData = $this->User->query('Select a_value,a_value2,agent_id From agent_settings Where status = 1 and a_key = "receipt"');
        	$receipt = Set::combine($receiptData,'{n}.agent_settings.agent_id','{n}.agent_settings.a_value');
        	$receiptT = Set::combine($receiptData,'{n}.agent_settings.agent_id','{n}.agent_settings.a_value2');
        	
        	$visaType = array();
        	$ans1 = $this->User->query('select visa_type_id,visa_type,status from visa_type_master ');
        	$visa_type = Set::combine($ans1,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
        	$visa_status = Set::combine($ans1,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.status');
      		//if(count($visa_type) > 0){ foreach($visa_type as $k=>$v){ if(isset($visa_status[$k]) && $visa_status[$k] == 0) $visaType[$k] = $v.' <span style = "color:red;">(Inactive Visa Type)</span>'; else $visaType[$k] = $v; }}
        	
      		if(is_array($visa_apps2)){
        		foreach($visa_apps2 as $row)
        		{
        			$astatus[$row['visa_app_group']['group_id']] = '';
        			if($row['visa_app_group']['apply_date'] <> NULL)
        			$date[$row['visa_app_group']['group_id']] = strtotime($row['visa_app_group']['apply_date']);
        			else
        			$date[$row['visa_app_group']['group_id']] = strtotime($row['visa_app_group']['app_date']);
        			
        			$this->Relation->useTable = 'group_meta';
        			$ans12 = $this->Relation->query('select * from group_meta where group_id='.$row['visa_app_group']['group_id'].' and meta_key = "applicant"');
        			if(count($ans12) > 0){ $applicant[$row['visa_app_group']['group_id']] = $ans12[0]['group_meta']['meta_value']; }

					$this->Relation->useTable = 'visa_tbl';
        			$ansData = $this->Relation->query('select * from visa_tbl where group_id='.$row['visa_app_group']['group_id']);
        			$appData[$row['visa_app_group']['group_id']] = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_id');
        			$appI = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_id');
        			$name = Set::combine($ansData, '{n}.visa_tbl.app_id', array('{0} {1} / {2}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name','{n}.visa_tbl.passport_no'));
        			$gname[$row['visa_app_group']['group_id']] = implode(',<br/>',$name);
        			$app_no1 = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_no');
        			$app_no[$row['visa_app_group']['group_id']] = implode(',<br/>',$app_no1);
        			/*if(count($ansData) > 0){
        				$app_id = implode(',',$appI);
        				$givenName= $this->Relation->query('select * from visa_meta where app_id in ('.$app_id.')  and visa_meta_key like "given_name%"');
        				$gData[$row['visa_app_group']['group_id']] = Set::combine($givenName, '{n}.visa_meta.app_id', '{n}.visa_meta.visa_meta_value');
        				$surName = $this->Relation->query('select * from visa_meta where app_id in ('.$app_id.') and visa_meta_key like "surname%"');
        				$sData[$row['visa_app_group']['group_id']] = Set::combine($surName,'{n}.visa_meta.app_id','{n}.visa_meta.visa_meta_value');
					}*/
        			$k++;
        		}
        	}
        	
        	$this->set('app',$appData);
        	$this->set('appNo',$app_no);
        	$this->set('gname',$gname);
        	//$this->set('surName',$sData);
        	$this->set('visa_type',$visa_type);
        	$this->set('visa_status',$visa_status);
        	$this->set('applicant',$applicant);
        	$this->set('username',$username);
        	$this->set('receipt',$receipt);
        	$this->set('receiptT',$receiptT);
        	
        	if(count($date) > 0)
        	arsort($date);
        	$this->set('sortDate',$date);
        	}
        	
        }

        public function view_visa_app($id =0,$view=1)
        {
        	//echo $view;
        	if($id != 0)
        	{
        		$data[0] = '';
        		$this->autoRender = false;
        		$this->Relation->useTable = 'visa_tbl';
        		$data = $this->Relation->query('select * from visa_tbl where group_id='.$id.' and status = 1');

        		$grp_data = $this->Relation->query('select * from visa_app_group where group_id='.$id);
        		if(is_array($grp_data)){
        		
        			foreach($grp_data as $g){
        				$adult = $g['visa_app_group']['adult']; $child = $g['visa_app_group']['children']; $infants = $g['visa_app_group']['infants'];
        				$count = $adult + $child + $infants;
						$currency = $this->currency_val($g['visa_app_group']['user_id']);
			        	$data[0]['visa_tbl']['group_no'] = $g['visa_app_group']['group_no'];
        				$data[0]['visa_tbl']['visa_type'] = $g['visa_app_group']['visa_type'];
        				$data[0]['visa_tbl']['tent_date'] = $g['visa_app_group']['tent_date'];
        				$data[0]['visa_tbl']['adult'] = $g['visa_app_group']['adult'];
        				$data[0]['visa_tbl']['children'] = $g['visa_app_group']['children'];
        				$data[0]['visa_tbl']['infants'] = $g['visa_app_group']['infants'];
        				$data[0]['visa_tbl']['citizenship'] = $g['visa_app_group']['citizenship'];
        				$data[0]['visa_tbl']['destination'] = $g['visa_app_group']['destination'];
        				$data[0]['visa_tbl']['visa_path'] = $g['visa_app_group']['visa_path'];
        				$data[0]['visa_tbl']['visa_fee'] = $g['visa_app_group']['visa_fee'];
        				$data[0]['visa_tbl']['transaction'] = $g['visa_app_group']['tr_status'];
        				$data[0]['visa_tbl']['app_type'] = $g['visa_app_group']['app_type'];
        			}
        		}

        		if(is_array($data)){
        			$k = 1;
        			foreach($data as $d){
        				$data[0][$d['visa_tbl']['app_id']] = $d['visa_tbl']['app_no'];
        				$res = $this->Relation->query('select * from visa_meta where app_id='.$d['visa_tbl']['app_id']);
        				foreach($res as $r){

        					$file_array = array('addr_proof'=>'addr_proof','photograph'=>'photograph','bio_page'=>'bio_page','last_page'=>'last_page','ticket'=>'ticket','add_doc1'=>'add_doc1','add_doc2'=>'add_doc2','add_doc3'=>'add_doc3','add_doc4'=>'add_doc4');
        					$app_no = $d['visa_tbl']['app_no'];

        					if(array_key_exists($r['visa_meta']['visa_meta_key'],$file_array)){
        						if(!file_exists(WWW_ROOT.'uploads/'.$app_no.'/'.$r['visa_meta']['visa_meta_value']))
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = "";
        						else
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}else{
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}
        				}
        				$k++;
        			}
        		}

        		if(is_array($res)){
        			$ak = 1; $bk = 1; $ck = 1;
        			$b = $adult + $child;
        			for($i = 1;$i<=$count;$i++){
        				if($adult != 0 && $i <= $adult){ $id = '-A'.$ak; $ak++;}
        				else if($b != 0 && $i <= $b){ $id = '-C'.$bk;	$bk++;}
        				else{ $id = '-I'.$ck;	$ck++;	}
        				$data[0]['visa_tbl']['religion'.$id] = $this->get_master_data('religion_master',$data[0]['visa_tbl']['religion'.$id],'religion_id','religion');
        				$data[0]['visa_tbl']['pre_nationality'.$id] = $this->get_master_data('country_master',$data[0]['visa_tbl']['pre_nationality'.$id],'country_id','country');
        				$data[0]['visa_tbl']['language'.$id] = $this->get_master_data('language_master',$data[0]['visa_tbl']['language'.$id],'lang_id','language');
        				$data[0]['visa_tbl']['marital_status'.$id] = $this->get_master_data('marital_master',$data[0]['visa_tbl']['marital_status'.$id],'marital_id','marital_status');
        				$data[0]['visa_tbl']['issue_country'.$id] = $this->get_master_data('country_master',$data[0]['visa_tbl']['issue_country'.$id],'country_id','country');
        				$data[0]['visa_tbl']['passport_type'.$id] = $this->get_master_data('passport_type_master',$data[0]['visa_tbl']['passport_type'.$id],'pass_type_id','passport_type');
        			   if(isset($data[0]['visa_tbl']['emp_type'.$id])){ if($data[0]['visa_tbl']['emp_type'.$id] != 'other') $data[0]['visa_tbl']['empType'.$id] = $this->get_master_data('emp_type_master',$data[0]['visa_tbl']['emp_type'.$id],'emp_type_id','emp_type'); else $data[0]['visa_tbl']['empType'.$id] =$data[0]['visa_tbl']['emp_type'.$id]; }
        			}
        		}

        		$grp_meta = $this->Relation->query('select * from group_meta where group_id ='.$data[0]['visa_tbl']['group_id']);

        		if(is_array($grp_meta))
        		{
        			foreach($grp_meta as $gm)
        			{
        				$data[0]['visa_tbl'][$gm['group_meta']['meta_key']] = $gm['group_meta']['meta_value'];
        			}
        			$data[0]['visa_tbl']['emp_type'] = $this->get_master_data('emp_type_master',$data[0]['visa_tbl']['emp_type'],'emp_type_id','emp_type');
        			$data[0]['visa_tbl']['country'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['country'],'country_id','country');
        			$data[0]['visa_tbl']['tr_status'] = $this->get_master_data('tr_status_master',$data[0]['visa_tbl']['tr_status'],'tr_status_id','tr_status');
        			$data[0]['visa_tbl']['citizenship'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['citizenship'],'country_id','country');
        			$data[0]['visa_tbl']['destination'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['destination'],'country_id','country');
        			$data[0]['visa_tbl']['visa_type'] = $this->get_master_data('visa_type_master',$data[0]['visa_tbl']['visa_type'],'visa_type_id','visa_type');
        			$data[0]['visa_tbl']['arr_airline'] = $this->get_master_data('airline_master',$data[0]['visa_tbl']['arr_airline'],'airline_id','airline');
        			$data[0]['visa_tbl']['dep_airline'] = $this->get_master_data('airline_master',$data[0]['visa_tbl']['dep_airline'],'airline_id','airline');
        		}

        		$this->set('data',$data[0]);
        		$this->set('count',$count);
        		$this->set('adult',$adult);
        		$this->set('child',$child);
        		$this->set('infant',$infants);
				$this->set('currency',$currency);
        		if($view == 1){
        			$this->render('view_visa_app');
					
        		}elseif($view == 2){
        			$this->set('application','all');
        			$this->render('view_visa_app');

        		}else
        		{
        			$arr['data']=$data[0];
        			$arr['count'] =$count;
        			$arr['adult']=$adult;
        			$arr['child']=$child;
        			$arr['infant']=$infants;
        			$arr['currency'] = $currency;
        			return $arr;
        		}
        	}
        }

        public function get_master_data($master,$id,$key,$value)
        {
        	if($id != 'select' and strlen($id) > 0)
        	{
        		$ans = $this->User->query('select * from '.$master.' where '.$key.'= '.$id);
        		if(count($ans)>0)
        		return $ans[0][$master][$value];
        		else
        		return '';
        	}
        	else
        	return '';
        }

        public function online_pay($id,$visa_type){
        	$userId = $this->UserAuth->getUserId();
        	$users = $this->User->query('Select * from users Where id='.$userId);

        	if (!empty($id) && !empty($visa_type)) {
        		$userId = $this->UserAuth->getUserId();

        		$cost_val = $this->User->query('Select * From visa_cost Where user_id = '.$userId.' and visa_type ="'.$visa_type.'"');
        		if(count($cost_val) > 0){
        			$amount = $cost_val[0]['visa_cost']['visa_cost'];
        		}else{
        			$amt_data = $this->User->query('Select * From visa_type_master Where visa_type_id = '.$visa_type);
        			$amount =  $amt_data[0]['visa_type_master']['visa_cost'];
        		}
        			
        		$grpData = $this->User->query('Select * From visa_app_group Where group_id = '.$id);
        		$count = $grpData[0]['visa_app_group']['adult'] + $grpData[0]['visa_app_group']['children'] + $grpData[0]['visa_app_group']['infants'];
        		$amount = $count * $amount;
        	}

        	$data = array("firstname"=>$users[0]['users']['username'],"email"=>$users[0]['users']['email'],"phone"=>"1234567890","productinfo"=>"tavel","key"=>"C0Dr8m","surl"=>SITE_URL."afterPay/1","furl"=>SITE_URL."afterPay/2");

        	$data['User']['amt'] = $amount;
        	$this->pay($data);
        	$this->autoRender = false;
        }


        public function new_transaction() {

        	$tr_mode=$this->get_dropdown('tr_mode_id', 'tr_mode','tr_mode_master');
        	$this->set('tr_mode', $tr_mode);
        		
        	$country=$this->get_dropdown('country_id', 'country','country_master');
        	$this->set('country', $country);
        		
        	$userId = $this->UserAuth->getUserId();
        	$currency = $this->currency_val($userId);
        	$this->set('currency',$currency);
        	
        	$users = $this->User->query('Select * from users Where id='.$userId);
        	$this->set('users', $users);
        	//print_r($users);exit;

			if($this->Session->read('UserAuth.User.user_group_id') == 1){
			$users_list = $this->User->query("SELECT * FROM `users`	WHERE `user_group_id` = 2 AND `status` = 1");
			$users_list = Set::combine($users_list, '{n}.users.id', '{n}.users.username');
			$users_list = array(''=>'Select') + $users_list;
			$this->set('users_list', $users_list);
			$this->set('is_admin', true);
			}
			else {
			$this->set('is_admin', false);
			}
			
			
        	$username = $this->UserAuth->getUserName();
        	if ($this->request ->isPost()) {
        		if(strlen($this->request->data['User']['receipt']['name']) > 0)
        		{
        			if(!file_exists(WWW_ROOT.'uploads/'.$username))
        			mkdir(WWW_ROOT.'uploads/'.$username, 0777, true);
        			$random =rand(111,999);
        			$addr_ext = explode('.',$this->request->data['User']['receipt']['name']);
        			$extension = $addr_ext[1];
        			$addr_name = 'receipt_'.$addr_ext[0].$random.'.'.$addr_ext[1];
 
        			move_uploaded_file($this->request->data['User']['receipt']['tmp_name'], WWW_ROOT.'uploads/'.$username.'/'.$addr_name);
        			$this->request->data['User']['receipt']= $addr_name;
        		}else
        		$this->request->data['User']['receipt']='';
        		 
        		$this->User->set($this->data);
        		//if ($this->User->TransactionValidate()) {
        		$data = $this->request->data;

        		if($data['User']['trans_mode'] == 7)
        		$this->pay($data);
        		else{
        			$user_id = $this->UserAuth->getUserId();
        			$value_data = "";
        			foreach($data['User'] as $k=>$d){
        				if($k != 'tent_dd' and $k != 'tent_mm' and $k != 'tent_yy')
        				{
        					if(strlen($value_data) > 0)
        					$value_data .= ",";
        					$value_data .= "'".$d."'";
        				}
        				if($k == 'trans_no')
        				{
        					$date = $data['User']['tent_yy'].'-'.$data['User']['tent_mm'].'-'.$data['User']['tent_dd'];
        					//echo $date;
        					if(strlen($value_data) > 0)
        					$value_data .= ",";
        					$value_data .= "'".$date."'";
        				}

        			}
        			$value_data .= ',"P"';
        			$value_data .= ',1';
        			$value_data .= ',"'.date('d-m-Y H:i:s').'"';
        			$value_data .= ',"'.$this->UserAuth->getUserId().'"';
        			$this->User->useTable = "";
        			$this->User->useTable = "new_transaction";
        			$this->User->query("Insert into new_transaction(user_id,trans_mode,amt,trans_id_dd,bank_name,bank_branch,country,account_no,trans_no,trans_date,remarks,receipt,trans_status,payment_status,date,role_id) Values (".$value_data.") ");
        			$tr_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        			$transId = $tr_Id[0][0]['id'];
        			$trans_data = $this->User->query('Select * from new_transaction Where trans_id = '.$transId);
        			$tr_mode = $this->get_master_data('tr_mode_master',$trans_data[0]['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
        			$trans = array($data['User']['amt'],$tr_mode,$date);
        			
        			$this->User->sendAdminTransMail($users,$this->trans_From_email(),$transId,$trans);
        			$this->Session->setFlash(__('Transaction Done Successfully'));
        			$this->redirect('/Users/all_transaction');
        		}
        		//}
        	}
        }

public function trans_From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'user_roles_meta';
		$email_val = ''; $ad_email = ''; $all_email = array(); $email = array();
		
		$data = $this->Relation->query("Select role_id From user_roles_meta Where meta_key = 'trans_bank' and meta_value = 1");
		$roleId = Set::combine($data,'{n}.user_roles_meta.role_id','{n}.user_roles_meta.role_id');
		
		if(count($data) > 0){
			$roleIdList = implode(',',$roleId);
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'user_roles';
			if(strlen($roleIdList) > 0){
			$data = $this->Relation->query("Select role_email,role_id From user_roles Where role_id in (".$roleIdList.") and role_status = 1");
			$email = Set::combine($data,'{n}.user_roles.role_id','{n}.user_roles.role_email');
			}
			$ad_email = $this->From_email();
			$all_email = array_merge($email,array(count($ad_email)=>$ad_email));
			$all_email = array_unique($all_email);
			$email_val = implode(',',$all_email);
			
			return $email_val;
			
		}
	}
	
        public function pay($data=null){
        	$this->set('data',$data);
        	$this->autoRender = false;
        	$this->render('/Users/pay');
        }

        public function after_payment($status){
        	$data = $_SESSION['trans_data'];

        	if($status == 1){
        			
        		$user_id = $this->UserAuth->getUserId();
        		$value_data = "";
        		foreach($data['User'] as $k=>$d){
        			if($k != 'tent_dd' and $k != 'tent_mm' and $k != 'tent_yy')
        			{
        				//if(strlen($value_data) > 0)
        				//$value_data .= ",";
        				$value_data[$k] = $d;
        			}
        			/*if($k == 'trans_no')
        			{
        				$date = $data['User']['tent_yy'].'-'.$data['User']['tent_mm'].'-'.$data['User']['tent_dd'];
        				if(strlen($value_data) > 0)
        				$value_data .= ",";
        				$value_data .= "'".$date."'";
        			}*/
        			
        			$country = '101';
        			$trans_date = date('d-m-Y H:i:s');
        			$receipt ='';
	        		$trans_status = 'A';
	        		$payment_status = 1;
	        		$date = date('d-m-Y H:i:s');
	        		$remarks = 'Transaction Successfully Done';
        		}
        		//$value_data .= ',""';
        		//$value_data .= ',"A"';
        		//$value_data .= ',1';
        		//$value_data .= ',"'.date('d-m-Y H:i:s').'"';
        		$this->User->useTable = "";
        		$this->User->useTable = "new_transaction";
        		//$this->User->query("Insert into new_transaction(user_id,trans_mode,amt,trans_id_dd,bank_type,bank_name,bank_branch,country,account_no,trans_no,trans_date,remarks,receipt,trans_status,payment_status,date) 
        		//Values (".$value_data.") ");
        		
        		$this->User->query("Insert into new_transaction
        		(user_id,trans_mode,amt,trans_id_dd,bank_name,country,bank_branch,account_no,trans_no,trans_date,remarks,receipt,trans_status,payment_status,date) 
        		Values ('".$value_data['user_id']."','".$value_data['trans_mode']."','".$value_data['amt']."','".$value_data['trans_id_dd']."','".$value_data['bank_name']."','".$country."','".$value_data['bank_branch']."','".$value_data['account_no']."','".$value_data['trans_no']."','".$trans_date."','".$remarks."','".$receipt."','".$trans_status."','".$payment_status."','".$date."') ");
        		
        		
        		$tr_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        		$transId = $tr_Id[0][0]['id'];
        		//$trans_data = $data;
        		$userdata = $this->User->query('Select * From user_wallet Where user_id = '.$user_id);
        		if(count($userdata) > 0){
        			$amount = $userdata[0]['user_wallet']['amount'] + $data['User']['amt']	;
        			$this->User->query('Update new_transaction set opening_bal ="'.$userdata[0]['user_wallet']['amount'].'" , closing_bal ="'.$amount.'" , app_date = "'.date('d-m-Y H:i:s').'" Where trans_id ='.$transId);
        			//$this->User->query('Update new_transaction set closing_bal ="'.$amount.'" Where trans_id ='.$transId);
        			$this->User->query('Update user_wallet set amount ="'.$amount.'" Where user_id ='.$user_id);
        		}else{
        			$this->User->query('Update new_transaction set closing_bal ="'.$data['User']['amt'].'" Where trans_id ='.$transId);
        			$this->User->query('Insert into user_wallet(user_id,amount) Values ('.$user_id.','.$data['User']['amt'].') ');
        		}

        		$userdata = $this->User->query('Select * from users where users.id = '.$user_id);
        		foreach($userdata[0]['users'] as $kd=>$ud) $user['User'][$kd] =$ud;
        		//echo "<pre>"; print_r($user);
        		// print_r($trans_data);
        		// print_r($transId);
        		// exit;
        		 
        		$trans_data = $this->User->query('Select * from new_transaction Where trans_id = '.$transId);
				$trans_data[0]['new_transaction']['tr_mode'] = $this->get_master_data('tr_mode_master',$trans_data[0]['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
				
				
        		$this->User->sendTransApprovalMail($user,$this->From_email(),$transId,$trans_data);
        		$this->Session->setFlash(__('Payment Done Successfully'));
        		$this->redirect('/Users/all_transaction');
        	}else{

        		$user_id = $this->UserAuth->getUserId();
        		$value_data = "";
        		foreach($data['User'] as $k=>$d){
        			
        			if($k != 'tent_dd' and $k != 'tent_mm' and $k != 'tent_yy' and $k != 'country')
        			{
        				$value_data[$k] = $d;
        			}
        			$country = '101';
        			$trans_date = date('d-m-Y H:i:s');
        			$receipt ='';
	        		$trans_status = 'F';
	        		$payment_status = 0;
	        		$date = date('d-m-Y H:i:s');
	        		$remarks = 'Transaction Failed';
        			/*if($k == 'trans_no')
        			{
        				//$date = $data['User']['tent_yy'].'-'.$data['User']['tent_mm'].'-'.$data['User']['tent_dd'];
        				$date = date('d-m-Y H:i:s');
        				if(strlen($value_data) > 0)
        				$value_data .= ",";
        				$value_data .= "'".$date."'";
        			}
        			if($k == 'country')
        			$value_data .= ',101';*/
        		}
        		
        		/*$value_data .= ',""';
        		$value_data .= ',"F"';
        		$value_data .= ',0';
        		$value_data .= ',"'.date('d-m-Y H:i:s').'"';*/
        		//echo $value_data;  exit;
        		$this->User->useTable = "";
        		$this->User->useTable = "new_transaction";
        		$this->User->query("Insert into new_transaction
        		(user_id,trans_mode,amt,trans_id_dd,bank_name,country,bank_branch,account_no,trans_no,trans_date,remarks,receipt,trans_status,payment_status,date) 
        		Values ('".$value_data['user_id']."','".$value_data['trans_mode']."','".$value_data['amt']."','".$value_data['trans_id_dd']."','".$value_data['bank_name']."','".$country."','".$value_data['bank_branch']."','".$value_data['account_no']."','".$value_data['trans_no']."','".$trans_date."','".$remarks."','".$receipt."','".$trans_status."','".$payment_status."','".$date."') ");

        		$this->Session->setFlash(__('Payment Failed'));
        		$this->redirect('/Users/all_transaction');
        	}
        }


        public function all_transaction(){
        	$trans=$this->User->query('Select * From new_transaction Where user_id ='.$this->UserAuth->getUserId().' and  status = 1 Order by trans_date desc');

        	$i = 0;
        	foreach($trans as $t){
        		$trans[$i]['new_transaction']['bank'] = $this->get_master_data('bank_master',$t['new_transaction']['bank_type'],'type_id','bank_type');
        			
        		$trans_mode_data = $t['new_transaction']['trans_mode'];
        		if($trans_mode_data != 'select'){
        			$this->Relation->useTable = '';
        			$this->Relation->useTable = 'tr_mode_master';
        			$ans =$this->Relation->query('Select * From tr_mode_master Where tr_mode_id ='.$trans_mode_data);
        			$trans[$i]['new_transaction']['tr_mode'] = $ans[0]['tr_mode_master']['tr_mode'];
        			$trans[$i]['new_transaction']['tr_mode_id'] = $trans_mode_data;
        		}else $trans[$i]['new_transaction']['tr_mode'] = $trans_mode_data;
        			
        		$count_data = $t['new_transaction']['country'];
        		if($count_data != 'select' && strlen($count_data) > 0){
        			$this->Relation->useTable = '';
        			$this->Relation->useTable = 'country_master';
        			$ans =$this->Relation->query('Select * From country_master Where country_id ='.$count_data);
        			$trans[$i]['new_transaction']['cntry'] = $ans[0]['country_master']['country'];
        		}else{
        			$trans[$i]['new_transaction']['cntry'] = $count_data;
        		}
        			
        		$i++;
        	}
        	$this->set('trans', $trans);

        	$userId=$this->UserAuth->getUserId();
        	$currency = $this->currency_val($userId);
        	$this->set('currency',$currency);
        	$username = $this->UserAuth->getUserName();
        	$this->set('username',$username);
        }

        public function editTrans($trans_Id=null) {

        	if (!empty($trans_Id)) {

        		$tr_mode=$this->get_dropdown('tr_mode_id', 'tr_mode','tr_mode_master');
        		$this->set('tr_mode', $tr_mode);
        			
        		$country=$this->get_dropdown('country_id', 'country','country_master');
        		$this->set('country', $country);
        			
        		$userId = $this->UserAuth->getUserId();
        		$users = $this->User->query('Select * from users Where status=1 and id='.$userId);
        		$this->set('users', $users);
        		
        		$userId=$this->UserAuth->getUserId();
	        	$currency = $this->currency_val($userId);
	        	$this->set('currency',$currency);
        			
        		if ($this->request-> isPost()) {
        			$this->User->set($this->data);
        			$data = $this->request->data;
        			$username = $this->UserAuth->getUserName();

        			if(strlen($this->request->data['User']['receipt']['name']) > 0)
        			{
        					
        				if(!file_exists(WWW_ROOT.'uploads/'.$username))
        				mkdir(WWW_ROOT.'uploads/'.$username, 0777, true);
        				$random =rand(111,999);
        				$addr_ext = explode('.',$this->request->data['User']['receipt']['name']);
        				$extension = $addr_ext[1];
        				$addr_name = 'receipt_'.$addr_ext[0].$random.'.'.$addr_ext[1];

        				 
        				move_uploaded_file($this->request->data['User']['receipt']['tmp_name'], WWW_ROOT.'uploads/'.$username.'/'.$addr_name);
        				$this->request->data['User']['receipt']= $addr_name;
        				$res['receipt'] = $addr_name;
        			}
        			//if ($this->User->TransactionValidate()) {

        			$res['amt'] = $this->request->data['User']['amt'];
        			$res['bank_name'] = $this->request->data['User']['bank_name'];
        			$res['bank_branch'] = $this->request->data['User']['bank_branch'];
        			$res['country'] = $this->request->data['User']['country'];
        			$res['account_no'] = $this->request->data['User']['account_no'];
        			$res['trans_mode'] = $this->request->data['User']['trans_mode'];
        			$res['trans_no'] = $this->request->data['User']['trans_no'];
        			$tr_date = $this->request->data['User']['tent_yy'].'-'.$this->request->data['User']['tent_mm'].'-'.$this->request->data['User']['tent_dd'];
        			$res['trans_date'] = $tr_date;
        			$res['remarks'] = $this->request->data['User']['remarks'];
        			$res['trans_id_dd'] = $this->request->data['User']['trans_id_dd'];

        			if(strlen($this->request->data['User']['receipt'] > 0))
        			$res['trans_id_dd'] = $this->request->data['User']['trans_id_dd'];
        			$this->User->useTable = "";
        			$this->User->useTable = 'new_transaction';
        			foreach($res as $key=>$value){
        				$this->User->query("Update new_transaction set ".$key." = '".$value."' Where trans_id = ".$trans_Id);
        			}

        			$this->Session->setFlash(__('Transaction Updated Successfully'));
        			$this->redirect('/Users/all_transaction');
        			//}
        		} else {
        			$username = $this->UserAuth->getUserName();
        			$data = $this->User->query('Select * From new_transaction Where trans_id='.$trans_Id);
        			foreach($data[0]['new_transaction'] as $k=>$v){
        					
        				if($k == 'trans_date')
        				{
        					if(strlen($v)  > 0 )
        					{
        						$piece = explode('-',$v);
        						$user['User']['tent_dd'] = $piece[2];
        						$user['User']['tent_mm'] = $piece[1];
        						$user['User']['tent_yy'] = $piece[0];
        					}
        				}
        				$user['User'][$k] = $v;
        			}
        			$user['User']['username'] = $username;
        				
        			if (!empty($user)) {
        				$this->request->data = $user;
        			}
        			$this->set('user',$user);
        			$this->set('trans_id',$trans_Id);
        			$this->autoRender = false;
        			$this->render('/Users/editTrans');
        		}
        	} else {
        		$this->redirect('/Users/all_transaction');
        	}
        }

        public function deleteTrans($transId = null) {
        	if (!empty($transId)) {
        		//if ($this->request->isPost()) {
        		$this->User->query('Update new_transaction set status = 0 Where trans_id = '.$transId);
        		$this->Session->setFlash(__('Transaction deleted successfully'));

        		//}
        		$this->redirect('/all_transaction');
        	} else {
        		$this->redirect('/all_transaction');
        	}
        }

        public function get_receipt($id =0)
        {
        	if($id != 0)
        	{
        		$data[0] = '';
        		$this->autoRender = false;
        		$this->Relation->useTable = 'visa_tbl';
        		$data = $this->Relation->query('select * from visa_tbl where group_id='.$id.' and status = 1');

        		$grp_data = $this->Relation->query('select * from visa_app_group where group_id='.$id.' and status = 1');
        		if(is_array($grp_data)){
        			foreach($grp_data as $g){
        				$adult = $g['visa_app_group']['adult']; $child = $g['visa_app_group']['children']; $infants = $g['visa_app_group']['infants'];
        				$count = $adult + $child + $infants;

        				$data[0]['visa_tbl']['group_no'] = $g['visa_app_group']['group_no'];
        				$data[0]['visa_tbl']['visa_type'] = $g['visa_app_group']['visa_type'];
        				$data[0]['visa_tbl']['tent_date'] = $g['visa_app_group']['tent_date'];
        				$data[0]['visa_tbl']['adult'] = $g['visa_app_group']['adult'];
        				$data[0]['visa_tbl']['children'] = $g['visa_app_group']['children'];
        				$data[0]['visa_tbl']['infants'] = $g['visa_app_group']['infants'];
        				$data[0]['visa_tbl']['citizenship'] = $g['visa_app_group']['citizenship'];
        				$data[0]['visa_tbl']['destination'] = $g['visa_app_group']['destination'];
        				$data[0]['visa_tbl']['visa_path'] = $g['visa_app_group']['visa_path'];
        				$data[0]['visa_tbl']['visa_fee'] = $g['visa_app_group']['visa_fee'];
        			}
        		}

        		if(is_array($data)){
        			$k = 1;
        			foreach($data as $d){
        				$data[0][$d['visa_tbl']['app_id']] = $d['visa_tbl']['app_no'];
        				$res = $this->Relation->query('select * from visa_meta where app_id='.$d['visa_tbl']['app_id']);
        				foreach($res as $r){

        					$file_array = array('addr_proof'=>'addr_proof','photograph'=>'photograph','bio_page'=>'bio_page','last_page'=>'last_page','ticket'=>'ticket','add_doc1'=>'add_doc1','add_doc2'=>'add_doc2','add_doc3'=>'add_doc3','add_doc4'=>'add_doc4');
        					$app_no = $d['visa_tbl']['app_no'];

        					if(array_key_exists($r['visa_meta']['visa_meta_key'],$file_array)){
        						if(!file_exists(WWW_ROOT.'uploads/'.$app_no.'/'.$r['visa_meta']['visa_meta_value']))
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = "";
        						else
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}else{
        						$data[0]['visa_tbl'][$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}

        				}
        				$app_name = '';
        				if($k == 1){
        					$appData = $this->Relation->query('select * from visa_meta where app_id='.$d['visa_tbl']['app_id'].' and (visa_meta_key = "given_name-A1" || visa_meta_key = "surname-A1")');
        					//print_r($appData); exit;
        					if(count($appData)){
        						$data[0]['visa_tbl']['app_name'] = $appData[0]['visa_meta']['visa_meta_value'].' '.$appData[1]['visa_meta']['visa_meta_value'];
        					}
        				}
        				$k++;
        			}
        		}



        		if(is_array($res)){
        			$ak = 1; $bk = 1; $ck = 1;
        			$b = $adult + $child;
        			for($i = 1;$i<=$count;$i++){
        				if($adult != 0 && $i <= $adult){ $id = '-A'.$ak; $ak++;}
        				else if($b != 0 && $i <= $b){ $id = '-C'.$bk;	$bk++;}
        				else{ $id = '-I'.$ck;	$ck++;	}

        				$data[0]['visa_tbl']['religion'.$id] = $this->get_master_data('religion_master',$data[0]['visa_tbl']['religion'.$id],'religion_id','religion');
        				$data[0]['visa_tbl']['pre_nationality'.$id] = $this->get_master_data('country_master',$data[0]['visa_tbl']['pre_nationality'.$id],'country_id','country');
        				$data[0]['visa_tbl']['language'.$id] = $this->get_master_data('language_master',$data[0]['visa_tbl']['language'.$id],'lang_id','language');
        				$data[0]['visa_tbl']['marital_status'.$id] = $this->get_master_data('marital_master',$data[0]['visa_tbl']['marital_status'.$id],'marital_id','marital_status');
        				$data[0]['visa_tbl']['issue_country'.$id] = $this->get_master_data('country_master',$data[0]['visa_tbl']['issue_country'.$id],'country_id','country');
        				$data[0]['visa_tbl']['passport_type'.$id] = $this->get_master_data('passport_type_master',$data[0]['visa_tbl']['passport_type'.$id],'pass_type_id','passport_type');
        			}
        		}

        		$grp_meta = $this->Relation->query('select * from group_meta where group_id='.$data[0]['visa_tbl']['group_id']);

        		if(is_array($grp_meta))
        		{
        			foreach($grp_meta as $gm)
        			{
        				$data[0]['visa_tbl'][$gm['group_meta']['meta_key']] = $gm['group_meta']['meta_value'];
        			}
        			$data[0]['visa_tbl']['emp_type'] = $this->get_master_data('emp_type_master',$data[0]['visa_tbl']['emp_type'],'emp_type_id','emp_type');
        			$data[0]['visa_tbl']['country'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['country'],'country_id','country');
        			$data[0]['visa_tbl']['tr_status'] = $this->get_master_data('tr_status_master',$data[0]['visa_tbl']['tr_status'],'tr_status_id','tr_status');
        			$data[0]['visa_tbl']['citizenship'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['citizenship'],'country_id','country');
        			$data[0]['visa_tbl']['destination'] = $this->get_master_data('country_master',$data[0]['visa_tbl']['destination'],'country_id','country');
        			$data[0]['visa_tbl']['visa_type'] = $this->get_master_data('visa_type_master',$data[0]['visa_tbl']['visa_type'],'visa_type_id','visa_type');
        			$data[0]['visa_tbl']['arr_airline'] = $this->get_master_data('airline_master',$data[0]['visa_tbl']['arr_airline'],'airline_id','airline');
        			$data[0]['visa_tbl']['dep_airline'] = $this->get_master_data('airline_master',$data[0]['visa_tbl']['dep_airline'],'airline_id','airline');
        		}

        		//echo '<pre>'; print_r($data[0]);
        		$this->set('appName',$app_name);
        		$this->set('data',$data[0]);
        		$this->set('count',$count);
        		$this->set('adult',$adult);
        		$this->set('child',$child);
        		$this->set('infant',$infants);

        	}

        	$this->autoRender =false;
        	$this->layout = null;
        	$this->render('receipt');
        }

        public function get_app_data($groupId=null)
        {
        	if (!empty($groupId)) {
        		$id = $groupId;
        		$data[0] = '';
        		$this->autoRender = false;
        		$this->Relation->useTable = 'visa_tbl';
        		$data = $this->Relation->query('select * from visa_tbl where group_id='.$id);

        		$grp_data = $this->Relation->query('select * from visa_app_group where group_id='.$id.' and status = 1');
        		if(is_array($grp_data)){
        			foreach($grp_data as $g){
        				$adult = $g['visa_app_group']['adult']; $child = $g['visa_app_group']['children']; $infants = $g['visa_app_group']['infants'];
        				$appdata['count'] = $adult + $child + $infants;

        				$appdata['group_no'] = $g['visa_app_group']['group_no'];
        				$appdata['visa_type'] = $g['visa_app_group']['visa_type'];
        				$appdata['tent_date'] = $g['visa_app_group']['tent_date'];
        				$tent_date = explode('-',$g['visa_app_group']['tent_date']);
        				$appdata['tent_dd'] = $tent_date[2];
        				$appdata['tent_mm'] = $tent_date[1];
        				$appdata['tent_yy'] = $tent_date[0];
        				$appdata['adult'] = $g['visa_app_group']['adult'];
        				$appdata['children'] = $g['visa_app_group']['children'];
        				$appdata['infants'] = $g['visa_app_group']['infants'];
        				$appdata['citizenship'] = $g['visa_app_group']['citizenship'];
        				$appdata['destination'] = $g['visa_app_group']['destination'];
        				$appdata['app_date'] = $g['visa_app_group']['app_date'];
$appdata['app_type'] = $g['visa_app_group']['app_type'];
        			}
        		}

        		if(is_array($data)){
        			foreach($data as $d){

        				$data[0][$d['visa_tbl']['app_id']] = $d['visa_tbl'];
        				$res = $this->Relation->query('select * from visa_meta where app_id='.$d['visa_tbl']['app_id']);

        				foreach($res as $r){

        					$file_array = array('addr_proof'=>'addr_proof','photograph'=>'photograph','bio_page'=>'bio_page','last_page'=>'last_page','ticket'=>'ticket','add_doc1'=>'add_doc1','add_doc2'=>'add_doc2','add_doc3'=>'add_doc3','add_doc4'=>'add_doc4');
        					$app_no = $d['visa_tbl']['app_no'];

        					if(array_key_exists($r['visa_meta']['visa_meta_key'],$file_array)){
        						if(!file_exists(WWW_ROOT.'uploads/'.$app_no.'/'.$r['visa_meta']['visa_meta_value']))
        						$appdata[$r['visa_meta']['visa_meta_key']] = "";
        						else
        						$appdata[$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}else{
        						$appdata[$r['visa_meta']['visa_meta_key']] = $r['visa_meta']['visa_meta_value'];
        					}

        				}
        			}
        		}


        		$grp_meta = $this->Relation->query('select * from group_meta where group_id='.$data[0]['visa_tbl']['group_id']);

        		if(is_array($grp_meta))
        		{
        			foreach($grp_meta as $gm)
        			{
        				$appdata[$gm['group_meta']['meta_key']] = $gm['group_meta']['meta_value'];
        			}
        		}
        		//print_r($appdata); exit;
        		return $appdata;
        			
        	}
        }

        public function edit_visa_app($groupId=null,$view=1)
        {
        	//echo $view;
        		if (!empty($groupId)) {
        		$agent = $this->User->query('select * from visa_app_group where group_id ='.$groupId);
        		if(count($agent) > 0)
        		$uid = $agent[0]['visa_app_group']['user_id'];
        		else
        		$uid =0;
        		$this->visa_app($groupId,$uid);
        			
        		if ($this->request->isPost()) {
        			
        	
        			$this->User->set($this->data);
        				
        			$curr_date = date('d-m-Y');
        			$ak = 1; $bk = 1; $ck = 1;
        			$a = $this->request->data['adult']; $b = $this->request->data['adult']+$this->request->data['children'];
        			for($i=1;$i<=$this->request->data['hid_count1'];$i++){
        				if($a != 0 && $i <= $a){  $id = '-A'.$ak;$ak++; }
        				else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $bk++;}
        				else{ $id = '-I'.$ck; $ck++;}
        				$cnt_data =	$this->User->query('Select * From visa_tbl Where app_no = "'.$this->request->data['User']['app_no'.$id].'"');
        					
        				if(is_array($cnt_data) && count($cnt_data) > 0){
        					$data =$this->User->find('all',array('conditions'=>array('passport_no'=>$this->request->data['User']['passport_no'.$id])));
        					foreach($cnt_data as $c){
        						$appId = $c['visa_tbl']['app_id'];
        					}
        					$this->User->useTable = 'visa_tbl';
        					$this->User->query('UPDATE visa_tbl SET passport_no="'.$this->request->data['User']['passport_no'.$id].'",first_name="'.$this->request->data['User']['given_name'.$id].'",last_name="'.$this->request->data['User']['surname'.$id].'",update_date="'.date('d-m-Y').'" WHERE app_id = '.$appId);

        					$detail =  array('given_name'.$id,'surname'.$id,'spouse_name'.$id,'father_name'.$id,'mother_name'.$id,'gender'.$id,'marital_status'.$id,'language'.$id,'pre_nationality'.$id,'dob_dd'.$id,'dob_mm'.$id,'dob_yy'.$id,'birth_place'.$id,'religion'.$id,'education'.$id,'passport_type'.$id,'passport_no'.$id,'issue_country'.$id,'doi_dd'.$id,'doi_mm'.$id,'doi_yy'.$id,'issue_place'.$id,'doe_dd'.$id,'doe_mm'.$id,'doe_yy'.$id,'emp_type'.$id,'emp_other'.$id);
        					
        				if($this->request->data['User']['emp_type'.$id] == 'other'){
        					$lower = strtolower($this->request->data['User']['emp_other'.$id]);
        					$upper = strtoupper($this->request->data['User']['emp_other'.$id]);
        					$title = ucwords($this->request->data['User']['emp_other'.$id]);
        					
        					$empType = $this->User->query('Select emp_type From emp_type_master Where status = 1 and (emp_type like "%'.$this->request->data['User']['emp_other'.$id].'%" || emp_type like "%'.$lower.'%" || emp_type like "%'.$upper.'%" || emp_type like "%'.$title.'%" )');
	        				if(strlen($this->request->data['User']['emp_other'.$id]) > 0 && count($empType) == 0){
	        					$this->User->query('Insert into emp_type_master (emp_type,create_date,update_date,status) values("'.$this->request->data['User']['emp_other'.$id].'","'.date('Y-m-d').'","'.date('Y-m-d').'",1)');
	        				}
        				}
        				
        					if($i == 1){
        						$grp_data = array('address1','address2','city','country','pin','std_code','phone','emp_type','occupation','company_name','company_address','company_contact','designation','last_doe_dd','last_doe_mm','last_doe_yy','arr_airline','arrival_flight','arr_date_dd','arr_date_mm','arr_date_yy','arrival_time','arr_pnr_no','dep_airline','departure_flight','dep_date_dd','dep_date_mm','dep_date_yy','departure_time','dep_pnr_no','remarks','applicant');
        						foreach($this->request->data['User'] as $key => $value)
        						{
        							if(in_array($key,$grp_data)){
        								$this->User->query('Update group_meta set meta_value = "'.$value.'" Where group_id = '.$this->request->data['groupId'].' and meta_key = "'.$key.'"');
        							}
        						}
        					}
        					foreach($this->request->data['User'] as $key => $value)
        					{
        						if(in_array($key,$detail)){
        							$this->User->query('Update visa_meta set visa_meta_value = "'.$value.'" Where app_id = '.$appId.' and visa_meta_key = "'.$key.'"');
        						}
        					}
        				}else{
        					$data =$this->User->find('all',array('conditions'=>array('passport_no'=>1)));
        					if(is_array($data) and count($data) > 0)
        					{
        						$this->Session->setFlash(__('You have already applied for Passport No : '.$this->request->data['User']['passport_no'.$id] .'!'));
        						$this->autoRender = false;
        						$this->set('data',$this->data);
        						$this->set('show',1);
        						$this->visa_app(null,$uid);
        					}else{
        						$this->User->useTable = 'visa_tbl';
        						$this->User->create();
        						$random =rand(111111,999999);
        						$this->request->data['User']['app_no'] = 'GV-'.$random;
        						$this->request->data['User']['create_date'] = date('d-m-Y');
        						$this->request->data['User']['user_id'] = $this->UserAuth->getUserId();
        						$this->request->data['User']['group_id'] = $this->request->data['groupId'];
        						$this->request->data['User']['passport_no'] = $this->request->data['User']['passport_no'.$id];
        						$this->request->data['User']['first_name'] = $this->request->data['User']['given_name'.$id];
        						$this->request->data['User']['last_name'] = $this->request->data['User']['surname'.$id];

        						$this->request->data['User']['pfp'.$id] = '';
        						$this->request->data['User']['plp'.$id] = '';
        						$this->request->data['User']['pop'.$id] = '';
        						$this->request->data['User']['addr'.$id] = '';
        						$this->request->data['User']['photograph'.$id] = '';
        						$this->request->data['User']['ticket1'.$id] = '';
        						$this->request->data['User']['ticket2'.$id] = '';
        						$this->request->data['User']['ticket3'.$id] = '';

        						$this->User->save($this->request->data,true);
        						$userId=$this->User->getLastInsertID();

        						$detail =  array('given_name'.$id,'surname'.$id,'spouse_name'.$id,'father_name'.$id,'mother_name'.$id,'gender'.$id,'marital_status'.$id,'language'.$id,'pre_nationality'.$id,'dob_dd'.$id,'dob_mm'.$id,'dob_yy'.$id,'birth_place'.$id,'religion'.$id,'education'.$id,'passport_type'.$id,'passport_no'.$id,'issue_country'.$id,'doi_dd'.$id,'doi_mm'.$id,'doi_yy'.$id,'issue_place'.$id,'doe_dd'.$id,'doe_mm'.$id,'doe_yy'.$id,'pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id);
        						if($i == 1){
        							$grp_data = array('address1','address2','city','country','pin','std_code','phone','emp_type','occupation','company_name','company_address','company_contact','designation','last_doe_dd','last_doe_mm','last_doe_yy','arr_airline','arrival_flight','arr_date_dd','arr_date_mm','arr_date_yy','arrival_time','arr_pnr_no','dep_airline','departure_flight','dep_date_dd','dep_date_mm','dep_date_yy','departure_time','dep_pnr_no','remarks');
        							foreach($this->request->data['User'] as $key => $value)
        							{
        								if(in_array($key,$grp_data)){
        									$this->User->query('Insert into group_meta(group_id,meta_key,meta_value) values('.$this->request->data['User']['group_id'].',"'.$key.'","'.$value.'")');
        								}
        							}
        						}
        						foreach($this->request->data['User'] as $key => $value)
        						{
        							if(in_array($key,$detail)){
        								$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$key.'","'.$value.'")');
        							}
        						}
        						$app_data = 'app_no'.$id;
        						$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$app_data.'","'.$this->request->data['User']['app_no'].'")');
        					}
        				}
        			}

        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->Relation->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Visa" and action_type = "Edit" and app_no = "'.$groupId.'"');
        			$this->Relation->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","Visa","Edit","'.$groupId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
        			$this->autoRender =false;
        			$this->Session->setFlash(__('Visa Application Updated successfully'));
        				
        			$this->autoRender =false;
        			
        			if($view == 2 )
        			       		 $this->redirect(array('controller' => 'users', 'action' => 'all_visa_app2'));
        			else
        			       		 $this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        		}else{
        				
        			$data = $this->User->query('Select * From visa_tbl Where group_id='.$groupId);
        			foreach($data[0]['visa_tbl'] as $k=>$v){
        				$app['User'][$k] = $v;
        			}
        			$data = $this->get_app_data($groupId);
        			if(is_array($data)){
        				foreach($data as $keys=>$values){
        					$app['User'][$keys]=$values;
        				}
        			}
        			if (!empty($app)) {
        				$this->request->data = $app;
        			}
        			$this->set('data',$app);
        			$this->set('groupId',$groupId);
        			$this->set('show',1);
        			$this->autoRender = false;
        			$this->visa_app(1,$uid);
        			if($view == 2)
        			$this->set('application','all');
        			$this->render('group_edit_visa');
        			//$this->render('visa_app');
        		}
        	}else{
        		$this->autoRender = false;
        		
        		if($view == 2 )
        			$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app2'));
        			else
        			$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));

        	}
        }

        public function get_data(){

        	if($this->request->data('application') == 'all')
        	$this->set('application','all');
        	$groupId = $this->request->data('groupId');
        	$data = $this->User->query('Select * From visa_tbl Where group_id='.$groupId);
        	foreach($data[0]['visa_tbl'] as $k=>$v){
        		$app['User'][$k] = $v;
        	}
        	$data = $this->get_app_data($groupId);
        	if(is_array($data)){
        		foreach($data as $keys=>$values){
        			$app['User'][$keys]=$values;
        		}
        	}

        	if (!empty($app)) {
        		$this->request->data = $app;
        	}


        	$this->set('data',$app);
        	$this->set('groupId', $groupId);
        	$this->autoRender = false;
        	$this->visa_app(1);
        	$this->render('edit_visa_app');
        }

        public function deleteVisa($groupId= null) {
        	$this->autoRender = false;
        	
        	if(!empty($groupId) && $groupId != null){
        		$visa_fee = 0; $data = array();   $userAmt = array();
        		 $total= 0; $amount = 0;
        		
        		$data = $this->User->query('Select * From visa_app_group Where group_id = '.$groupId);
        		if(count($data) > 0){ 
        		
        		$userId = $data[0]['visa_app_group']['user_id'];
        		
        		$group_no = $data[0]['visa_app_group']['group_no'];
        		$this->User->query('Update visa_app_group set status = 0 Where group_id = '.$groupId);
        		
        		//$this->User->query('Update visa_transactions set status = 0 Where app_id = '.$groupId.' and user_id = '.$userId);
        		
        		$visa_fee = $data[0]['visa_app_group']['visa_fee'];
        		
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];

        		$amount = $total + $visa_fee;
        		$this->User->query('Update user_wallet set amount = '.$amount.' Where user_id = '.$userId);
        		
        		$date = date('Y-m-d H:i:s');
        		$this->User->query('Insert into new_transaction(user_id,bank_type,amt,bank_name,bank_branch,country,account_no,trans_mode,trans_date,remarks,opening_bal,closing_bal,status,admin_status,trans_status,payment_status,date,app_date) values ("'.$userId.'",1,"'.$visa_fee.'","CREDIT AMOUNT","NO BRANCH",1,"NO ACCOUNT NUMBER",1,"'.$date.'","Deleted Visa App ('.$group_no.')","'.$total.'","'.$amount.'",1,1,"A",1,"'.$date.'","'.$date.'")'); 
				
        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Visa" and action_type = "Delete" and app_no = "'.$groupId.'"');
        			$this->User->query('Insert into user_action(role_id,type,action_type,app_no,date,status) values("'.$roleId.'","Visa","Delete","'.$groupId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
        		$this->Session->setFlash('Visa Application Deleted Successfully');
        		}else{
        			$this->Session->setFlash('Visa Application Does not Exist');
        		} 
        	}
       		 $this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        }

       public function apply_for_visa($id=null,$visa_type=null) {
       	$user_role_email = '';
        	$trData = $this->User->query('Select tr_status,group_no,app_type,adult,children,infants,user_id,role_id From visa_app_group Where group_id = '.$id.' and apply_date is null' );
        	//print_r($trData); exit;
        	if(count($trData) > 0 && $trData[0]['visa_app_group']['tr_status'] == 1){
        		$userId = $trData[0]['visa_app_group']['user_id'];
        		$receipt = 'Yes'; $receiptT = 'Regular'; $rec = array();
        		$rec = $this->User->query('Select a_value,a_value2 From agent_settings Where a_key = "receipt" and agent_id = '.$userId);
        		if(count($rec) > 0){
        			$receipt = $rec[0]['agent_settings']['a_value'];
        			$receiptT = $rec[0]['agent_settings']['a_value2'];
        		}
        		if (!empty($id) && !empty($visa_type)) {
        			$data_id = $this->User->query('Select email,id,username from users Where id = '.$userId);
					$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        			if(count($userData) > 0)
        			{
        				$amt_data = $this->User->query('Select * From visa_type_master Where visa_type_id = '.$visa_type);
        				$cost_val = $this->User->query('Select * From visa_cost Where user_id = '.$userId.' and visa_type ="'.$visa_type.'"');
        				if(count($cost_val) > 0){
        					$amount = $cost_val[0]['visa_cost']['visa_cost'];
        					$samount = ($cost_val[0]['visa_cost']['visa_scost'] == null) ? $amt_data[0]['visa_type_master']['visa_scost'] : $cost_val[0]['visa_cost']['visa_scost'];
        				}else{
        					$amount =  $amt_data[0]['visa_type_master']['visa_cost'];
        					$samount =  $amt_data[0]['visa_type_master']['visa_scost'];
        				}
        				$camount = $amount;	
        				$samount = $samount;	
        				
        				$count = $trData[0]['visa_app_group']['adult'] + $trData[0]['visa_app_group']['children'] + $trData[0]['visa_app_group']['infants'];
        				$amount = $count * $samount;
						$amount2 =  $count * $camount;
        				if($userData[0]['user_wallet']['amount'] >= $amount){
        					 
        					$amt = $userData[0]['user_wallet']['amount'] - $amount;
        					$this->User->query('Update user_wallet set amount = '.$amt.' Where user_id = '.$userId);
        					$this->User->query('Update visa_app_group set visa_fee = '.$amount.',tr_status = 2,apply_date="'.date('Y-m-d H:i:s').'" Where user_id = '.$userId.' and group_id = '.$id);
        					$this->User->query('Insert into visa_transactions(user_id,app_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$id.',"'.$amount.'","'.$userData[0]['user_wallet']['amount'].'","'.$amt.'","'.date('d-m-Y H:i:s').'")');
        					
        					$app = '';
        					$appdata = $this->get_app_data1($id);
        				$nameV = '';
        				if(is_array($appdata[3])) $nameV = reset($appdata[3]);
        				//echo reset($appdata[3]); exit;
        					$zip =$this->create_zip_excel($trData[0]['visa_app_group']['group_no'],$id);
        					$inv = ''; $ainv = '';
        					$inv = $this->create_invoice($id,$appdata[0]['visa_type'],$amount,$userId,$trData[0]['visa_app_group']['group_no'],$samount);
		        			$ainv = $this->create_invoice($id,$appdata[0]['visa_type'],$amount,$userId,$trData[0]['visa_app_group']['group_no'],$camount,$amount2);
		        					
        					//$oktbNo = implode("','",$pnrData); 
							$einv = explode('/',$inv);
							$eainv =  explode('/',$ainv);
							$this->User->query('Update visa_app_group set inv_path = "'.end($einv).'" ,inv_admin_path = "'.end($eainv).'" Where group_id ='.$id);
						if($receipt == 'Yes'){
							if($receiptT == 'Regular')
        					$this->User->sendApplyVisaMail($data_id[0],$this->visa_From_email(),$trData[0]['visa_app_group']['group_no'],$trData[0]['visa_app_group']['app_type'],$nameV,$inv);
							else
							$this->User->sendApplyVisaMail($data_id[0],$this->visa_From_email(),$trData[0]['visa_app_group']['group_no'],$trData[0]['visa_app_group']['app_type'],$nameV,$ainv);
						}else{
							$this->User->sendApplyVisaMail($data_id[0],$this->visa_From_email(),$trData[0]['visa_app_group']['group_no'],$trData[0]['visa_app_group']['app_type'],$nameV);
						}//}else $this->User->sendApplyVisaMail($data_id[0],$this->visa_From_email(),$trData[0]['visa_app_group']['group_no'],$trData[0]['visa_app_group']['app_type'],'');
        					
        					$zip['id']=$id;
        					
	        				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
			        			$roleId = $this->Session->read('role1.role_id');
			        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","Visa","Apply","'.$zip['id'].'","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
			        		}
        		
							$user_role_email = $this->visa_user_From_email($visa_type);
        					if(strlen($user_role_email) > 0)
        					$this->User->sendAdminApplyVisaMail($data_id[0],$user_role_email,$appdata,$zip,$ainv);
        					if($trData[0]['visa_app_group']['role_id'] == null)
        					$this->Session->setFlash(__("Your Visa Application is/are successfully submitted. Amount required for processing this application will be deducted from your wallet."));
        				else  
        					$this->Session->setFlash(__("Visa Application for ".$data_id[0]['users']['username']." is/are successfully submitted. Amount required for processing this application will is deducted from their wallet."));
        				
        				}else{
        					if($trData[0]['visa_app_group']['role_id'] == null)
        					$this->Session->setFlash('Oops! You don\'t have sufficient balance in your account for processing this application.', 'default', array('class' => 'errorMsg'));
	        				else  
	        				$this->Session->setFlash('Oops!This Agent ( '.$data_id[0]['users']['username'].' ) don\'t have sufficient balance for processing this application.', 'default', array('class' => 'errorMsg'));
        				}
        			}else{
        				if($trData[0]['visa_app_group']['role_id'] == null)
        					$this->Session->setFlash('Oops! You don\'t have sufficient balance in your account for processing this application.', 'default', array('class' => 'errorMsg'));
        				else
        				$this->Session->setFlash('Oops!This Agent ( '.$data_id[0]['users']['username'].' ) don\'t have sufficient balance for processing this application.', 'default', array('class' => 'errorMsg'));
        			}
        			$this->autoRender = false;
        			$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        		}else{
        			$this->autoRender = false;
        			$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        		}
        	}else{
        		$this->autoRender = false;
        		$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        	}
        }

        function export_xls($grp_id,$group_no) {
        	$this->User->recursive = 1;
        	$this->view_visa_app($grp_id,0);
        	//$fileName = $this->zipData($group_no);
        	$this->layout = null;
        	$this->header($group_no);
        	$this->render('export_xls');
        }
        public function From_email() {
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = 'admin_settings';
        	$data = $this->Relation->query("Select a_value From admin_settings Where a_key = 'admin_email'");
        	//print_r($data);
        	return $data[0]['admin_settings']['a_value'];
        }

	public function oktb_From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'admin_settings';
		$data = $this->Relation->query("Select * From admin_settings Where a_key = 'oktb_from'");
		return $data[0]['admin_settings']['a_value'];
	}
		
public function oktb_user_From_email($oktb_airline = null) {
		//echo $visa_type;
		$email_val = '';
		if($visa_type != null){
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'user_roles';
			$data = $this->Relation->query("Select role_email,role_id From user_roles Where oktb = 1 and role_status = 1 and (oktb_airline LIKE ('%,".$oktb_airline.",%') OR oktb_airline LIKE ('%,".$oktb_airline."') OR oktb_airline LIKE ('".$oktb_airline.",%') OR oktb_airline = '' OR oktb_airline = ".$oktb_airline.")");
			$email = Set::combine($data,'{n}.user_roles.role_id','{n}.user_roles.role_email');
			$email_val = implode(',',$email);
			if(strlen($email_val) > 0)
			return $email_val;
		}
	}
public function visa_user_From_email($visa_type = null) {
		
		//echo $visa_type;
		$email_val = ''; $email = array(); $ad_email = array(); $all_email = array();
		if($visa_type != null){
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'user_roles';
			$data = $this->Relation->query("Select role_email,role_id From user_roles Where visa = 1 and role_status = 1 and (visa_type LIKE ('%,".$visa_type.",%') OR visa_type LIKE ('%,".$visa_type."') OR visa_type LIKE ('".$visa_type.",%') OR visa_type = ''  OR visa_type = ".$visa_type.")");
			$email = Set::combine($data,'{n}.user_roles.role_id','{n}.user_roles.role_email');
		}
		$ad_email = $this->visa_From_email();
			$all_email = array_merge($email,array(count($email)=>$ad_email));
			$all_email = array_unique($all_email);
			$email_val = implode(',',$all_email); 
			if(strlen($email_val) > 0)
			return $email_val;
	}
	
public function visa_From_email() {
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'admin_settings';
			$data = $this->Relation->query("Select a_value From admin_settings Where a_key = 'visa_from'");	
			$email_val = $data[0]['admin_settings']['a_value'];
		    return $email_val;
	}
	
 public function approve_visa() {
 	$a_data = explode(',',$_POST['group']);
        	 $groupId = $a_data[0];
        	 $status =$a_data[1];
        	 $userid = $a_data[2];
        	 $visa_type = $a_data[3];
        	 $prev = $a_data[4];
        	 $comm = $_POST['data']['comments'];
 	
				$this->autoRender = false;
        	if (!empty($groupId )  && $status != 'select') {
        		
        		$this->User->query('Update visa_app_group set app_comments = "'.$comm.'" Where group_id = '.$groupId);
        		$this->User->query('Update visa_app_group set tr_status = '.$status.' Where group_id ='.$groupId);
        		$this->User->query('Update visa_tbl set tr_status = '.$status.' Where group_id ='.$groupId);
        		
        		$data_id = $this->User->query('Select * from users Where id = '.$userid);
        		$app_data = $this->User->query('Select * from visa_app_group Where group_id ='.$groupId);
        		
        		$tr_data = $this->User->query('Select * From tr_status_master Where tr_status_id ='.$status);
        		$visaType =$tr_data[0]['tr_status_master']['tr_status'];
        		
        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where type = "Visa" and action_type = "Change Status" and app_no = "'.$groupId.'"');
        			$this->User->query('Insert into user_action(role_id,type,action_type,app_no,prev_value,updated_value,date,status) values("'.$roleId.'","Visa","Change Status","'.$groupId.'","'.$prev.'","'.$status.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		if($tr_data[0]['tr_status_master']['tr_status'] != 'Approved')
        		$this->User->sendVisaApprovalMail($data_id[0],$this->visa_From_email(),$app_data[0],$visaType,$comm);
        		
        		$this->Session->setFlash('Visa App Status changed to '.$visaType);
        		
        		echo 'Success';
        	}else echo 'Error';
        }
        
        
  public function agent_trans($userId = null ){
        	if($userId == null)
        	$userId=$this->UserAuth->getUserId();
        	
        	$currency = $this->currency_val($userId);
        	$this->set('currency',$currency);
        	$outstanding = $this->get_outstanding2($userId);
        	$i = 0; $res = array(); $total = 0; $userAmt = array(); $threshold1 = 0;
        	$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        	if(count($userAmt) > 0)
        	$total = $userAmt[0]['user_wallet']['amount'];
        	$k = 1;

        	$thresAmt = array(); $threshold = 0;
        	$thresAmt = $this->User->query('Select total_th From threshold Where user_id = '.$userId.' and status = 1');
        	if(count($thresAmt) > 0)
        	$threshold = $thresAmt[0]['threshold']['total_th'];
        	$threshold1 =  $threshold; 
        	
        	$balance = $total - $threshold;
        	
        	if($balance <= 0){
        		$threshold = $threshold + $balance;
        		$balance = 0;
        	}
        	$this->set('threshold1',$threshold1);
        	$this->set('balance',$balance);
        	$this->set('outstanding', $outstanding);
        	
        	$query1 = $this->User->query('Select * From oktb_airline Where status = 1 or status = 2');
			$airline = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.a_name');
			//$this->set('airline',$result1);
			$trans_app = $this->User->query('Select * From new_transaction Where user_id = '.$userId.' and trans_status = "A" and status = 1 order by trans_date desc');
			
        	if(count($trans_app) > 0){
        		foreach($trans_app as $t){ $i =0;
        		if(strlen($t['new_transaction']['app_date']) > 0){
        			$i = strtotime($t['new_transaction']['app_date']);
        			if(array_key_exists($i,$res) == true ){
        				$i+=$k;
        				$k++;
        			}
        		}
        			$res[$i]['narration'] = 'Incoming';
        			$res[$i]['date'] = $t['new_transaction']['app_date'];
        			$res[$i]['bank_name'] = $t['new_transaction']['bank_name'];
        			$res[$i]['opening_bal'] = $t['new_transaction']['opening_bal'];
        			$res[$i]['closing_bal'] = $t['new_transaction']['closing_bal'];
        			$res[$i]['credit'] = $t['new_transaction']['amt'];
        			$res[$i]['type'] = $t['new_transaction']['remarks'];
        			$res[$i]['other'] = '-';
        		}
        	}

        	$visa_app = $this->User->query('Select * From visa_transactions Where user_id = '.$userId.' and status = 1 order by date desc ');
        	if(count($visa_app) > 0){
        		foreach($visa_app as $v){
        			$appDetail = $this->User->query('Select * From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id  Where visa_tbl.group_id = '.$v['visa_transactions']['app_id']);
        			//echo $v['visa_transactions']['opening_bal'];   echo '<br/>';	echo $v['visa_transactions']['closing_bal']; echo '<br/>'; echo $v['visa_transactions']['amount'] ; echo '<br/>'; 
        			if(count($appDetail) > 0){
        			$adult = $appDetail[0]['visa_app_group']['adult'];
        			$child = $appDetail[0]['visa_app_group']['children'];
        			$infants = $appDetail[0]['visa_app_group']['infants'];
        			$ctotal = $adult + $child + $infants; //echo '<br/>';
        			$amt = $v['visa_transactions']['amount'] / $ctotal; //echo '<br/>';
        			$visaGroup = '';
        			$i = strtotime($v['visa_transactions']['date']);
        		
        			for($a = 0; $a < $ctotal; $a++){
        			if(array_key_exists($i,$res) == true){
        				$i+=$k;
        				$k++;
        			}
        		
        			 $opening = $amt * $a;
        			
        			$opening_bal = $v['visa_transactions']['opening_bal'] - $opening;
        			$res[$i]['narration'] = 'Outgoing';
        			$res[$i]['group_no'] = '<strong>Group No : </strong>'.$appDetail[$a]['visa_app_group']['group_no'] .' <br/>'.$appDetail[$a]['visa_tbl']['first_name'].' '.$appDetail[$a]['visa_tbl']['last_name'].' / '.$appDetail[$a]['visa_tbl']['passport_no'];
        			$res[$i]['date'] = $v['visa_transactions']['date'];
        			$res[$i]['opening_bal'] = $opening_bal; //echo '<br/>';
        			$res[$i]['closing_bal'] = $opening_bal - $amt; //echo '<br/>';
        			$res[$i]['debit'] = $amt; //$v['visa_transactions']['amount'];
        			$res[$i]['other'] = $this->get_master_data('visa_type_master',$appDetail[$a]['visa_app_group']['visa_type'],'visa_type_id','visa_type');
        			$res[$i]['type'] = 'Visa Application ('.$appDetail[$a]['visa_tbl']['app_no'].')';
        			if($appDetail[$a]['visa_app_group']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			$i++;
        			}
        			}
        			//exit;
        		}
        		//exit;
        	}

        	$oktb_app = $this->User->query('Select * From oktb_transactions join oktb_details on oktb_details.oktb_id = oktb_transactions.oktb_id Where oktb_transactions.user_id = '.$userId.' and oktb_transactions.status = 1 order by oktb_transactions.date desc ');
        	if(count($oktb_app) > 0){
        		foreach($oktb_app as $v){
        			$i = strtotime($v['oktb_transactions']['date']);
        			if(array_key_exists($i,$res) == true){
        				$i+=$k;
        				$k++;
        			}
        			$res[$i]['narration'] = 'Outgoing';
        		
        			$res[$i]['group_no'] = '';
        			if(strlen($v['oktb_details']['oktb_group_no']) > 0 )
        			$res[$i]['group_no'] = '<strong>Group No : </strong>'.$v['oktb_details']['oktb_group_no'].' <br/>';
        			$res[$i]['group_no'] .= $v['oktb_details']['oktb_name'].' / '.$v['oktb_details']['oktb_passportno'];
        			$res[$i]['date'] = $v['oktb_transactions']['date'];
        			$res[$i]['opening_bal'] = $v['oktb_transactions']['opening_bal'];
        			$res[$i]['closing_bal'] = $v['oktb_transactions']['closing_bal'];
        			$res[$i]['debit'] = $v['oktb_transactions']['amount'];
        		$air = '';
        		if(isset($airline[$v['oktb_details']['oktb_airline_name']])) $air = $airline[$v['oktb_details']['oktb_airline_name']];
        			$res[$i]['other'] = $air;
        			$res[$i]['type'] = 'OKTB Application ('.$v['oktb_details']['oktb_no'].')';
        			if($v['oktb_details']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			$i++;
        		}
        	}
        	
   $ext_app = $this->User->query('Select * From ext_transactions join ext_details on ext_details.ext_id = ext_transactions.ext_id Where ext_transactions.user_id = '.$userId.' and ext_transactions.status = 1 order by ext_transactions.date desc');

        	if(count($ext_app) > 0){
        		foreach($ext_app as $t){ $i =0;
        		if(strlen($t['ext_transactions']['date']) > 0){
        			$i = strtotime($t['ext_transactions']['date']);
        			if(array_key_exists($i,$res) == true ){
        				$i+=$k;
        				$k++;
        			}
        		}
        			$res[$i]['narration'] = 'Outgoing';
        			$res[$i]['date'] = $t['ext_transactions']['date'];
        			if($t['ext_details']['ext_group_id'] != null){
        				$gData = $this->User->query('Select first_name,last_name,passport_no,app_no From visa_tbl Where app_id = '.$t['ext_details']['ext_group_id']);
        				if(count($gData) > 0)
        				$name = 'Application No : '.$gData[0]['visa_tbl']['app_no'].'<br/>'.$gData[0]['visa_tbl']['first_name'].' '.$gData[0]['visa_tbl']['last_name'].' / '.$gData[0]['visa_tbl']['passport_no'];
        			}else if($t['ext_details']['ext_name'] != null)
        			$name = $t['ext_details']['ext_name'].' / '.$t['ext_details']['ext_passportno'];
        			else $name = '';
        			$res[$i]['group_no'] = $name;
        			$res[$i]['opening_bal'] = $t['ext_transactions']['opening_bal'];
        			$res[$i]['closing_bal'] = $t['ext_transactions']['closing_bal'];
        			$res[$i]['debit'] = $t['ext_transactions']['amount'];
        			$res[$i]['type'] = 'Extension Visa Application ('.$t['ext_details']['ext_no'].')';
        			if($t['ext_details']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			//$i++;
        		}
        	}
        	
        	$th_app = array();
         $th_app = $this->User->query('Select * From threshold Where user_id = '.$userId.' order by date desc');

        	if(count($th_app) > 0){
        		foreach($th_app as $t){ $i =0;
        		if(strlen($t['threshold']['date']) > 0){
        			$i = strtotime($t['threshold']['date']);
        			if(array_key_exists($i,$res) == true ){
        				$i+=$k;
        				$k++;
        			}
        		}
        			$res[$i]['narration'] = 'Incoming';
        			$res[$i]['date'] = $t['threshold']['date'];
        			$res[$i]['bank_name'] = '-';
        			$res[$i]['opening_bal'] = $t['threshold']['opening_bal'];
        			$res[$i]['closing_bal'] = $t['threshold']['closing_bal'];
        			$res[$i]['credit'] = $t['threshold']['avail_th'];
        			$res[$i]['other'] = '-';
        			$res[$i]['type'] = 'Credit Limit Revised';
        		
        		}
        	}

$userDetails = $this->User->query('Select username From users Where id = '.$userId);
        	if(count($userDetails) > 0) $this->set('username',$userDetails[0]['users']['username']);
        	
        	//echo "<pre>"; print_r($res);
        	if(count($res) > 0){
        		krsort($res);
        		$this->set('transaction',$res);
        	}
        	$this->set('amtBal',$total);
        	$this->set('threshold',$threshold);
        }
          
        
  public function search()
        {
        	//$this->autoRender=false;
			//echo '<pre>';
			$visa_type=$this->get_visa_dropdown();
        	$this->set('visa_type', $visa_type);
			
			$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
        	$this->set('airline', $airline);
			
			$app_type = array('select'=>'Select','Visa Applications','OKTB Applications','Extension');
			$this->set('app_type', $app_type);

        	$country=$this->get_dropdown('country_id', 'country','country_master');
        	$this->set('country', $country);

        	$travel_city=$this->get_dropdown('travel_city_id', 'travel_city','travel_city_master');
        	$this->set('travel_city', $travel_city);

        	$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	$this->set('tr_status', $tr_status);
			//print_r($app_type);exit;
        }

public function app_report_filter(){
			$this->autoRender=false;
			if ($this->request->isPost()){
			$id = $this->request->data['id'];
			if($id == '0'){
				$visa_type=$this->get_visa_dropdown();
				unset($visa_type['select']);
				$select = array('select'=>'Select');
				$select_agent = $this->User->query("SELECT `id`, `username` FROM `users` WHERE user_group_id=2 AND status=1");
				$select_agent = Set::combine($select_agent,'{n}.users.id','{n}.users.username');
				$select_agent = $select_agent;
				$external_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
				unset($external_status['select']);
				$internal_status = $this->get_dropdown('atr_status_id', 'atr_status','admin_tr_status');
				unset($internal_status['select']);
				$this->set('external_status',$external_status);
				$this->set('select_agent',$select_agent);
				$this->set('internal_status',$internal_status);
				$this->set('visa_type', $visa_type);
				$this->render('by_visa_filter');
			} 
			elseif($id == '1') {
				$airline_type = $this->User->query("SELECT `a_id`, `a_name` FROM `oktb_airline` WHERE  status<>0");
				$airline_type = Set::combine($airline_type,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
				$airline_type = $airline_type;
				
				$select_agent = $this->User->query("SELECT `id`, `username` FROM `users` WHERE user_group_id=2 AND status=1");
				$select_agent = Set::combine($select_agent,'{n}.users.id','{n}.users.username');
				$select_agent =$select_agent;
				$external_status=array('5'=>'Approved','2'=>'In Process','1'=>'Click on the green arrow to make payment for this application');
				$export_type=array('1'=>'Group','2'=>'Individual');
				unset($external_status['select']);
				//$internal_status = $this->get_dropdown('atr_status_id', 'atr_status','admin_tr_status');
				//unset($internal_status['select']);
				$this->set('export_type',$export_type);
				$this->set('external_status',$external_status);
				$this->set('select_agent',$select_agent);
				//$this->set('internal_status',$internal_status);
				$this->set('airline_type', $airline_type);
					$this->render('by_oktb_filter');
			} 
			elseif($id == '2'){
				$visa_type=$this->get_visa_dropdown();

				unset($visa_type['select']);
				$select_agent = $this->User->query("SELECT `id`, `username` FROM `users` WHERE user_group_id=2 AND status=1");
				$select_agent = Set::combine($select_agent,'{n}.users.id','{n}.users.username');
				$select_agent = $select_agent;
				$external_status=array('8'=>'Applied','5'=>'Approved','2'=>'In Process');
				$internal_status = $this->get_dropdown('atr_status_id', 'atr_status','admin_tr_status');
				$this->set('external_status',$external_status);
				$this->set('select_agent',$select_agent);
				$this->set('internal_status',$internal_status);
				$this->set('visa_type', $visa_type);
				$this->render('by_visa_filter');
					$this->render('by_extension_filter');
			} else {
			echo '';
			}
			}
		}


public function visa_app_id_details($app_nos = array()){
		$data=array();
		foreach($app_nos as $app_no){
		$this->autoRender=false;
		$query1 = $this->User->query("SELECT * FROM `visa_tbl` WHERE `app_no` = '$app_no' ");
		foreach($query1 as $k=>$result_q1){
		$user_id = $result_q1['visa_tbl']['user_id'];
		$app_id = $result_q1['visa_tbl']['app_id'];
		$data[$result_q1['visa_tbl']['app_no']]['date_of_exit'] = isset($result_q1['visa_tbl']['last_doe'])? $result_q1['visa_tbl']['last_doe'] : 'NA';
		$data[$result_q1['visa_tbl']['app_no']]['app_name'] = $result_q1['visa_tbl']['first_name'].' '.$result_q1['visa_tbl']['last_name'];
		$data[$result_q1['visa_tbl']['app_no']]['app_no'] = $result_q1['visa_tbl']['app_no'];
		$data[$result_q1['visa_tbl']['app_no']]['pass_no'] = isset($result_q1['visa_tbl']['passport_no']) ? $result_q1['visa_tbl']['passport_no'] : 'NA';
		$query2 = $this->User->query("SELECT * FROM `users` WHERE `id` = $user_id AND status =1");
		$data[$result_q1['visa_tbl']['app_no']]['username'] = isset($query2[0]['users']['username']) ? $query2[0]['users']['username'] : 'NA';
		$group_id = $result_q1['visa_tbl']['group_id'];
		$data[$result_q1['visa_tbl']['app_no']]['group_id'] = $group_id;
		$query3 = $this->User->query("SELECT * FROM `visa_app_group` WHERE `group_id` = $group_id ORDER BY `apply_date` DESC");
		if(strlen($query3[0]['visa_app_group']['role_id']) > 0){
		$data[$result_q1['visa_tbl']['app_no']]['off'] = '<i class="icon-info-sign" style="color:red;" title="Offline"></i>';
		} else {
		$data[$result_q1['visa_tbl']['app_no']]['off'] = '';
		}
		$data[$result_q1['visa_tbl']['app_no']]['apply_date'] = isset($query3[0]['visa_app_group']['apply_date']) ? substr($query3[0]['visa_app_group']['apply_date'], 0, 10) : 'NA';
		$visa_type = $query3[0]['visa_app_group']['visa_type'];
		$tr_status = $query3[0]['visa_app_group']['tr_status'];
		$admin_tr_status = $query3[0]['visa_app_group']['admin_tr_status'];

		$data[$result_q1['visa_tbl']['app_no']]['apply_date'] = isset($query3[0]['visa_app_group']['apply_date']) ? $query3[0]['visa_app_group']['apply_date'] : 0;
		$data[$result_q1['visa_tbl']['app_no']]['group_no'] = $query3[0]['visa_app_group']['group_no'];
		$data[$result_q1['visa_tbl']['app_no']]['tent_date'] = $query3[0]['visa_app_group']['tent_date'];
		$data[$result_q1['visa_tbl']['app_no']]['amount'] = $query3[0]['visa_app_group']['visa_fee'] / ( $query3[0]['visa_app_group']['adult'] + $query3[0]['visa_app_group']['children'] + $query3[0]['visa_app_group']['infants'] );
		$query4 = $this->User->query("SELECT * FROM `visa_type_master` WHERE `visa_type_id` = $visa_type");
		$data[$result_q1['visa_tbl']['app_no']]['visa_type'] = isset($query4[0]['visa_type_master']['visa_type']) ? $query4[0]['visa_type_master']['visa_type'] : 'NA';
		$query5 = $this->User->query("SELECT * FROM `tr_status_master` WHERE `tr_status_id` = $tr_status");
		$data[$result_q1['visa_tbl']['app_no']]['status'] = isset($query5[0]['tr_status_master']['tr_status']) ? $query5[0]['tr_status_master']['tr_status'] : 'NA';
		$query6 = $this->User->query("SELECT * FROM `admin_tr_status` WHERE `atr_status_id` = 0 AND status =1");
		$data[$result_q1['visa_tbl']['app_no']]['admin_status'] = isset($query5[0]['admin_tr_status']['atr_status'])? $query5[0]['admin_tr_status']['atr_status'] : '';
		$query7 = $this->User->query("SELECT * FROM `visa_meta` WHERE `app_id` = $app_id AND `visa_meta_key` LIKE '%emp%' ");
		if(isset($query7[0]['visa_meta']['visa_meta_value']) && strlen($query7[0]['visa_meta']['visa_meta_value']) > 0){
		if($query7[0]['visa_meta']['visa_meta_value'] == 'other'){
		$data[$result_q1['visa_tbl']['app_no']]['profession'] = isset($query7[1]['visa_meta']['visa_meta_value']) ? $query7[1]['visa_meta']['visa_meta_value'] : 'NA';
		} else {
		$prof_id = $query7[0]['visa_meta']['visa_meta_value'];
		$query8 = $this->User->query("SELECT * FROM `emp_type_master` WHERE `emp_type_id` = $prof_id");
		$data[$result_q1['visa_tbl']['app_no']]['profession'] = (isset($query8[0]['emp_type_master']['emp_type']) && strlen($query8[0]['emp_type_master']['emp_type'])>0) ? $query8[0]['emp_type_master']['emp_type'] : 'NA';
		}
		} else {
		$data[$result_q1['visa_tbl']['app_no']]['profession'] = 'NA';
		}
		
		
		
		}
		
		}
		
		return $data;
		}
		
public function oktb_id_details($oktb_ids=array()){
		$data=array();
		$this->autoRender=false;

		foreach($oktb_ids as $oktb_id){
		
		$query1 = $this->User->query("SELECT * FROM `oktb_details` WHERE `oktb_no` = '$oktb_id' LIMIT 0,1");
		foreach($query1 as $result1){
		$data[$oktb_id]['oktb_no'] = (strlen($oktb_id) > 0)? $oktb_id : 'NA';
		$data[$oktb_id]['group_no'] = (strlen($result1['oktb_details']['oktb_group_no']) > 0)? $result1['oktb_details']['oktb_group_no'] : 'NA';
		$data[$oktb_id]['noa'] = $result1['oktb_details']['oktb_name'];
		$data[$oktb_id]['oktbid'] = $result1['oktb_details']['oktb_id'];
		$data[$oktb_id]['doj'] = $result1['oktb_details']['oktb_d_o_j'];
		$data[$oktb_id]['apply_date'] = $result1['oktb_details']['payment_date'];
		$data[$oktb_id]['pnr'] = isset($result1['oktb_details']['oktb_pnr']) ? $result1['oktb_details']['oktb_pnr'] : 'NA';
		$data[$oktb_id]['passport'] = $result1['oktb_details']['oktb_passportno'];
		$data[$oktb_id]['amount'] = isset($result1['oktb_details']['oktb_airline_amount']) ? $result1['oktb_details']['oktb_airline_amount'] : 'NA';
		$user_id = $result1['oktb_details']['oktb_user_id'];
		$query2 = $this->User->query("SELECT * FROM `users` WHERE `id` = $user_id");
		$data[$oktb_id]['username'] = $query2[0]['users']['username'];
		$airline = $result1['oktb_details']['oktb_airline_name'];
		if(strlen($airline) > 0){
		$query3 = $this->User->query("SELECT * FROM `oktb_airline` WHERE `a_id` = $airline ");
		$data[$oktb_id]['air_name'] = $query3[0]['oktb_airline']['a_name'];
		} else{
		$data[$oktb_id]['air_name'] = 'NA';
		}
		$data[$oktb_id]['appli_date_time'] = isset($result1['oktb_details']['payment_date']) ? $result1['oktb_details']['payment_date']:'NA         NA     ';
		$status = $result1['oktb_details']['oktb_payment_status'];
		$query4 = $this->User->query("SELECT * FROM `tr_status_master` WHERE `tr_status_id` = $status ");
		$data[$oktb_id]['status'] = $query4[0]['tr_status_master']['tr_status'];
		
		}
		}
		//$datax = Set::sort($data, '{n}.apply_date', 'desc');
		//echo '<pre>';
		//$datax = array('a','b','c');
		//print_r($datax);
		//print_r($data);
		return $data;
		}
		
		public function extension_id_details($extension_ids = array()){
		$this->autoRender=false;

		$data = array();
		foreach($extension_ids as $extension_id){
		
		$query1 = $this->User->query("SELECT * FROM `ext_details` WHERE `ext_no` = '$extension_id' ");
		$data[$extension_id]['ext_no']=$extension_id;
		$data[$extension_id]['ext_id']=$query1[0]['ext_details']['ext_id'];
		$user_id = $query1[0]['ext_details']['ext_user_id'];
		$query2 = $this->User->query("SELECT * FROM `users` WHERE `id` = $user_id");
		if(strlen($query1[0]['ext_details']['ext_group_id']) > 0){
		$group_id = $query1[0]['ext_details']['ext_group_id'];
		$query3 = $this->User->query("SELECT * FROM `visa_tbl` WHERE `app_id` = $group_id");
		$data[$extension_id]['app_no'] = $query3[0]['visa_tbl']['app_no'];
		$group_id_v = $query3[0]['visa_tbl']['group_id'];
		$data[$extension_id]['name'] = $query3[0]['visa_tbl']['first_name'].' '.$query3[0]['visa_tbl']['last_name'];//$query2[0]['users']['first_name'];
		$data[$extension_id]['passport_no'] = (strlen($query3[0]['visa_tbl']['passport_no']) > 0) ? $query3[0]['visa_tbl']['passport_no'] : 'NA';
		$data[$extension_id]['group_id'] =$group_id_v;
		$query4 = $this->User->query("SELECT * FROM `visa_app_group` WHERE `group_id` = $group_id_v");
		$visa_type = $query4[0]['visa_app_group']['visa_type'];
		$query5 = $this->User->query("SELECT * FROM `visa_type_master` WHERE `visa_type_id` = $visa_type");
		$data[$extension_id]['visa_type'] = $query5[0]['visa_type_master']['visa_type'];
		} else {
		$data[$extension_id]['name'] = $query1[0]['ext_details']['ext_name'];

		$data[$extension_id]['app_no'] = 'NA';
		$data[$extension_id]['visa_type'] = 'NA';
		$data[$extension_id]['passport_no'] = isset($query1[0]['visa_tbl']['ext_passportno']) ? $query1[0]['visa_tbl']['ext_passportno'] : 'NA';
		}
		$data[$extension_id]['username'] = $query2[0]['users']['username'];
		$data[$extension_id]['appli_date']  = (isset($query1[0]['ext_details']['ext_apply_date']) && $query1[0]['ext_details']['ext_apply_date'] > 0)?$query1[0]['ext_details']['ext_apply_date']:0;//$query1[0]['ext_details']['ext_apply_date'];//isset($query1[0]['ext_details']['ext_apply_date'])?$query1[0]['ext_details']['ext_apply_date']:0;
		$data[$extension_id]['ext_amount']  = $query1[0]['ext_details']['ext_amt'];
		$ext_status_id = $query1[0]['ext_details']['ext_payment_status'];
		$query6 = $this->User->query("SELECT * FROM `tr_status_master` WHERE `tr_status_id` = $ext_status_id");
		$data[$extension_id]['status'] = $query6[0]['tr_status_master']['tr_status'];
		//print_r($query1[0]['ext_details']['ext_name']);
		}
	//print_r($data);
		return $data;
	}

	
	
public function search_result2(){
		
			$this->autoRender=false;
			$app_type = $this->request->data['type'];
	
		if($app_type == 'visa'){
			$visa_type_res = array();
			$inter_arr = $this->User->query("SELECT visa_tbl.app_no FROM `visa_tbl` join visa_app_group on visa_app_group.group_id = visa_tbl.group_id Where visa_app_group.status = 1");
			$inter_arr = Set::combine($inter_arr,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
			$internal_status = $agent_name_res = $external_status = array();
			$visa_types_a = $this->request->data['visa_type']; $agents_a = $this->request->data['agent_name']; $ext_status_a = $this->request->data['external_status']; $int_status_a = $this->request->data['internal_status']; $export_type = $this->request->data['export_type'];
			if(strlen($this->request->data['app_no']) > 0 && $this->request->data['app_no'] != 'null'){
				$group_no = $this->request->data['app_no'];
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `group_no` = '$group_no'");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_i = implode(',', $query1);
				if(count($query1) > 0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_i)");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				} else {
				$query2 = array($this->request->data['app_no']=>$this->request->data['app_no']);
				}
				//print_r($query1);exit;
				$inter_arr = array_intersect($inter_arr, $query2);
			}
			$from_date = $this->request->data['from_date'];
			$to_date = $this->request->data['to_date'];
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `apply_date` >= '2014-03-03'");
				$query_x = "SELECT `group_id` FROM `visa_app_group` WHERE `apply_date` ";
				if(strlen($this->request->data['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND `apply_date` <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
				
			}
			
				if(strlen($this->request->data['doe']) > 5){
					$doe = $this->request->data['doe'];
					$queryy = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `last_doe` = '$doe' ");
					$queryy = Set::combine($queryy,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
					$inter_arr = array_intersect($inter_arr, $queryy);
				}
			
			
			if(strlen($this->request->data['passport_no']) > 0 && $this->request->data['passport_no'] != 'null'){
				$passport_no = $this->request->data['passport_no'];
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `passport_no` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->request->data['psg_name']) > 0 && $this->request->data['psg_name'] != 'null'){
				$psg_name = $this->request->data['psg_name'];
				$psg_name = explode(' ', $psg_name);
				$psg_name = implode('\',\'', $psg_name);
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `first_name` IN ('$psg_name') OR `last_name` IN ('$psg_name') ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if($visa_types_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `visa_type` IN($visa_types_a) and status = 1");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
			}

			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `user_id` IN ($agents_a)  and status = 1 ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$agent_name_res = $query1;
				if(count($query1) > 0){
						$inter_arr = array_intersect($inter_arr, $query1);
					} else {
						$inter_arr = array();
					}
			}

			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `tr_status` IN($ext_status_a)  and status = 1");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
				
			}
			
			if($int_status_a != 'null' && $int_status_a != 'undefined' && count($inter_arr) > 0){
			$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `admin_tr_status` IN($int_status_a)  and status = 1");
			$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
			$query1c = implode(',', $query1);
			//	if(count($query1) > 0){
				$query2 = ("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1c) and status=1");
				$query2 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$internal_status = $query2;
				$inter_arr = array_intersect($inter_arr, $query2);
			//	}
			}
			$data = $this->visa_app_id_details($inter_arr);
			$this->set('data',$data);
			$this->render('visa_report');
			
			} 
			
			
			elseif($app_type == 'oktb'){
			$visa_type_res = array();
			$inter_arr = $this->User->query("SELECT `oktb_no` FROM `oktb_details`");
			$inter_arr = Set::combine($inter_arr,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');


			$airline_type_a = $this->request->data['airline_type']; $agents_a = $this->request->data['agent_name']; $ext_status_a = $this->request->data['external_status'];
			if(strlen($this->request->data['oktb_no']) > 0 && $this->request->data['oktb_no'] != 'null'){
				$group_no = $this->request->data['oktb_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_group_no` = '$group_no'");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$this->Session->write('User.group',true);
				if(count($query1)==0){
				$query1 = array($this->request->data['oktb_no']=>$this->request->data['oktb_no']);
				$this->Session->write('User.group',false);
				}
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			$from_date = $this->request->data['from_date'];
			$to_date = $this->request->data['to_date'];
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query_x = "SELECT `oktb_no` FROM `oktb_details` WHERE date(payment_date) ";
				if(strlen($this->request->data['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND date(payment_date) <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->request->data['passport_no']) > 0 && $this->request->data['passport_no'] != 'null'){
				$passport_no = $this->request->data['passport_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_passportno` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->request->data['pnr_no']) > 0 && $this->request->data['pnr_no'] != 'null'){
				$pnr_no = $this->request->data['pnr_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_pnr` = '$pnr_no' ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->request->data['psg_name']) > 0 && $this->request->data['psg_name'] != 'null'){
				$psg_name = $this->request->data['psg_name'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_name` LIKE '%$psg_name%' ");
				$qryx = "SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_name` LIKE '%$psg_name%'";
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if($airline_type_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_airline_name` IN($airline_type_a) and oktb_status = 1");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}


			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_user_id` IN ($agents_a) and oktb_status = 1 ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$agent_name_res = $query1;
				$inter_arr = array_intersect($inter_arr, $query1);

			}
			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_payment_status` IN($ext_status_a)  and oktb_status = 1");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			if($this->request->data('export_type') == '1' ||$this->request->data('export_type') == '1,2'){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE LENGTH(`oktb_group_no`) > 6 ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			

			$data = $this->oktb_id_details($inter_arr);
			$this->set('data',$data);
			$this->render('oktb_report');
			
			} 
			elseif($app_type == 'extn'){

			$inter_arr = $this->User->query("SELECT `ext_no` FROM `ext_details`");
			$inter_arr = Set::combine($inter_arr,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
			$agent_name_res = $external_status = array();
			$visa_types_a = $this->request->data['visa_type']; $agents_a = $this->request->data['agent_name']; $ext_status_a = $this->request->data['external_status']; $int_status_a = $this->request->data['internal_status'];
			if(strlen($this->request->data['app_no']) > 0 && $this->request->data['app_no'] != 'null'){
				$query1 = array($this->request->data['app_no']=>$this->request->data['app_no']);
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			$from_date = $this->request->data['from_date'];
			$to_date = $this->request->data['to_date'];
			
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query_x = "SELECT `ext_no` FROM `ext_details` WHERE date(`ext_apply_date`) ";
				if(strlen($this->request->data['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND date(`ext_apply_date`) <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');

				$inter_arr = array_intersect($inter_arr, $query1);

			}
			
			
			if(strlen($this->request->data['passport_no']) > 0 && $this->request->data['passport_no'] != 'null'){
				$passport_no = $this->request->data['passport_no'];
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_passportno` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			if(strlen($this->request->data['psg_name']) > 0 && $this->request->data['psg_name'] != 'null'){
				$psg_name = $this->request->data['psg_name'];
				$psg_name = explode(' ', $psg_name);
				$psg_name = implode('\',\'', $psg_name);
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_name` IN ('$psg_name') ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			if($visa_types_a != 'null'){
				$query1 = $this->User->query("SELECT `ext_group_id` FROM `ext_details` WHERE `ext_group_id` IS NOT NULL and ext_status = 1");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_group_id','{n}.ext_details.ext_group_id');
				$query1_c = implode(',', $query1);
				
				if(count($query1)>0){
				$query2 = $this->User->query('Select visa_tbl.app_id,visa_tbl.app_no,visa_tbl.passport_no,visa_tbl.first_name,visa_tbl.last_name,visa_app_group.visa_type From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.app_id in ('.$query1_c.') AND visa_app_group.visa_type IN('.$visa_types_a.')');
	      		$query2 = Set::combine($query2,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
				$appId = implode('\',\'', $query2);
				$aquery2 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_group_id` IN('$appId')");
				
	      		$aquery2 = Set::combine($aquery2,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');

				$visa_type_res = $aquery2;
					if(count($aquery2) > 0){
						$inter_arr = array_intersect($inter_arr, $aquery2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
					
			}


			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_user_id` IN ($agents_a)  and ext_status = 1 ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);

			}
			
			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_payment_status` IN($ext_status_a)  and ext_status = 1");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			$data = $this->extension_id_details($inter_arr);
			$this->set('data',$data);
			$this->render('extn_report');
			} 
		}
	
	public function search_result3(){
		
			$this->autoRender=false;
			$app_type = $this->params['url']['type'];
			$export_filetype = $this->params['url']['ex_type'];
			$view = new View($this, false);
        	$view->layout = null;
			$view->viewPath = "Users";
		if($app_type == 'visa'){
			$visa_type_res = array();
			$inter_arr = $this->User->query("SELECT visa_tbl.app_no FROM `visa_tbl` join visa_app_group on visa_app_group.group_id = visa_tbl.group_id Where visa_app_group.status = 1");
			$inter_arr = Set::combine($inter_arr,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
			$internal_status = $agent_name_res = $external_status = array();
			$visa_types_a = $this->params['url']['visa_type']; $agents_a = $this->params['url']['agent_name']; $ext_status_a = $this->params['url']['external_status']; $int_status_a = $this->params['url']['internal_status'];
			if(strlen($this->params['url']['app_no']) > 0 && $this->params['url']['app_no'] != 'null'){
				$group_no = $this->params['url']['app_no'];
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `group_no` = '$group_no'");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_i = implode(',', $query1);
				if(count($query1) > 0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_i)");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				} else {
				$query2 = array($this->params['url']['app_no']=>$this->params['url']['app_no']);
				}
				//print_r($query1);exit;
				$inter_arr = array_intersect($inter_arr, $query2);
			}
			$from_date = $this->params['url']['from_date'];
			$to_date = $this->params['url']['to_date'];
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `apply_date` >= '2014-03-03'");
				$query_x = "SELECT `group_id` FROM `visa_app_group` WHERE `apply_date` ";
				if(strlen($this->params['url']['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND `apply_date` <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
				
			}
			
				if(strlen($this->params['url']['doe']) > 5){
					$doe = $this->params['url']['doe'];
					$queryy = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `last_doe` = '$doe' ");
					$queryy = Set::combine($queryy,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
					$inter_arr = array_intersect($inter_arr, $queryy);
				}
			
			
			if(strlen($this->params['url']['passport_no']) > 0 && $this->params['url']['passport_no'] != 'null'){
				$passport_no = $this->params['url']['passport_no'];
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `passport_no` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->params['url']['psg_name']) > 0 && $this->params['url']['psg_name'] != 'null'){
				$psg_name = $this->params['url']['psg_name'];
				$psg_name = explode(' ', $psg_name);
				$psg_name = implode('\',\'', $psg_name);
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `first_name` IN ('$psg_name') OR `last_name` IN ('$psg_name') ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if($visa_types_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `visa_type` IN($visa_types_a) and status = 1");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
			}

			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `user_id` IN ($agents_a)  and status = 1 ");
				$query1 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$agent_name_res = $query1;
				if(count($query1) > 0){
						$inter_arr = array_intersect($inter_arr, $query1);
					} else {
						$inter_arr = array();
					}
			}

			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `tr_status` IN($ext_status_a)  and status = 1");
				$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
				$query1_c = implode(',', $query1);
				if(count($query1)>0){
				$query2 = $this->User->query("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1_c)  and status = 1");
				$query2 = Set::combine($query2,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$visa_type_res = $query2;
					if(count($query2) > 0){
						$inter_arr = array_intersect($inter_arr, $query2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
				
			}
			
			if($int_status_a != 'null' && $int_status_a != 'undefined' && count($inter_arr) > 0){
			$query1 = $this->User->query("SELECT `group_id` FROM `visa_app_group` WHERE `admin_tr_status` IN($int_status_a)  and status = 1");
			$query1 = Set::combine($query1,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
			$query1c = implode(',', $query1);
			//	if(count($query1) > 0){
				$query2 = ("SELECT `app_no` FROM `visa_tbl` WHERE `group_id` IN($query1c) and status=1");
				$query2 = Set::combine($query1,'{n}.visa_tbl.app_no','{n}.visa_tbl.app_no');
				$internal_status = $query2;
				$inter_arr = array_intersect($inter_arr, $query2);
			//	}
			}
			//print_r($inter_arr);
			$data = $this->visa_app_id_details($inter_arr);
			//print_r($data);
			$view->set('data',$data);
			
			
			
			if(isset($export_filetype) && $export_filetype == 'xls') {
			$html = $view->render('export_visa_xml');
			echo $html;
			
			} elseif(isset($export_filetype) && $export_filetype == 'pdf') {
			$html = $view->render('export_visa_pdf');
			//echo $html;exit;
			if(file_exists(WWW_ROOT.'uploads/receipt/visa_ex') == false)
			mkdir(WWW_ROOT.'uploads/receipt/visa_ex');
			$my_file = WWW_ROOT.'uploads/receipt/visa_ex/Visa_Repoer.pdf';
			if(file_exists($my_file) == false)
			$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
			
			$this->dompdf = new DOMPDF();
			$papersize='legal';
			$orientation='landscape';
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper($papersize, $orientation);
			$this->dompdf->render();
			$output = $this->dompdf->output();
			//echo $this->dompdf->output();
			file_put_contents($my_file, $output);
			//return $my_file;
			
			
			$file=$my_file; //file location
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="Visa_Report_Export.pdf"');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			
			
			}
			
			
			
			
			} 
			
			
			elseif($app_type == 'oktb'){
			$visa_type_res = array();
			$inter_arr = $this->User->query("SELECT `oktb_no` FROM `oktb_details`");
			$inter_arr = Set::combine($inter_arr,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				
				if($this->params['url']['export_type'] == '1'){

				$this->Session->write('User.group','1');
			} elseif($this->params['url']['export_type'] == '2') {

				$this->Session->write('User.group','2');
			} elseif($this->params['url']['export_type'] == '1,2') {

				$this->Session->write('User.group','3');
			} else {
				$this->Session->write('User.group','3');
			}

			$airline_type_a = $this->params['url']['airline_type']; $agents_a = $this->params['url']['agent_name']; $ext_status_a = $this->params['url']['external_status'];
			if(strlen($this->params['url']['oktb_no']) > 0 && $this->params['url']['oktb_no'] != 'null'){
				$group_no = $this->params['url']['oktb_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_group_no` = '$group_no'");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$this->Session->write('User.group',true);
				if(count($query1)==0){
				$query1 = array($this->params['url']['oktb_no']=>$this->params['url']['oktb_no']);
				$this->Session->write('User.group',false);
				}
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			

			$from_date = $this->params['url']['from_date'];
			$to_date = $this->params['url']['to_date'];
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query_x = "SELECT `oktb_no` FROM `oktb_details` WHERE date(payment_date) ";
				if(strlen($this->params['url']['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND date(payment_date) <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->params['url']['passport_no']) > 0 && $this->params['url']['passport_no'] != 'null'){
				$passport_no = $this->params['url']['passport_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_passportno` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->params['url']['pnr_no']) > 0 && $this->params['url']['pnr_no'] != 'null'){
				$pnr_no = $this->params['url']['pnr_no'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_pnr` = '$pnr_no' ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if(strlen($this->params['url']['psg_name']) > 0 && $this->params['url']['psg_name'] != 'null'){
				$psg_name = $this->params['url']['psg_name'];
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_name` LIKE '%$psg_name%' ");
				$qryx = "SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_name` LIKE '%$psg_name%'";
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			if($airline_type_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_airline_name` IN($airline_type_a) and oktb_status = 1");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}


			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_user_id` IN ($agents_a) and oktb_status = 1 ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$agent_name_res = $query1;
				$inter_arr = array_intersect($inter_arr, $query1);

			}
			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE `oktb_payment_status` IN($ext_status_a)  and oktb_status = 1");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			
			
			if($this->params['url']['export_type'] == '1' || $this->params['url']['export_type'] == '1,2'){
				$query1 = $this->User->query("SELECT `oktb_no` FROM `oktb_details` WHERE LENGTH(`oktb_group_no`) > 6 ");
				$query1 = Set::combine($query1,'{n}.oktb_details.oktb_no','{n}.oktb_details.oktb_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			

			$data = $this->oktb_id_details($inter_arr);
			$view->set('data',$data);
			
			if(isset($export_filetype) && $export_filetype == 'xls') {
			$html = $view->render('export_oktb_xml');
			echo $html;
			} else{
			
			$html = $view->render('export_oktb_pdf');
			//echo $html;exit;
			//echo $html;
			if(file_exists(WWW_ROOT.'uploads/receipt/visa_ex') == false)
			mkdir(WWW_ROOT.'uploads/receipt/visa_ex');
			$my_file = WWW_ROOT.'uploads/receipt/visa_ex/OKTB_Repoer.pdf';
			if(file_exists($my_file) == false)
			$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
			
			$this->dompdf = new DOMPDF();
			$papersize='legal';
			$orientation='landscape';
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper($papersize, $orientation);
			$this->dompdf->render();
			$output = $this->dompdf->output();
			//echo $this->dompdf->output();
			file_put_contents($my_file, $output);
			//return $my_file;
			
			
			$file=$my_file; //file location
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="OKTB_Report_Export.pdf"');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			
			
			}
			
			
			
			
			} 
			elseif($app_type == 'extn'){

			$inter_arr = $this->User->query("SELECT `ext_no` FROM `ext_details`");
			$inter_arr = Set::combine($inter_arr,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
			$agent_name_res = $external_status = array();
			$visa_types_a = $this->params['url']['visa_type']; $agents_a = $this->params['url']['agent_name']; $ext_status_a = $this->params['url']['external_status']; $int_status_a = $this->params['url']['internal_status'];
			if(strlen($this->params['url']['app_no']) > 0 && $this->params['url']['app_no'] != 'null'){
				$query1 = array($this->params['url']['app_no']=>$this->params['url']['app_no']);
				$inter_arr = array_intersect($inter_arr, $query1);
			}
			$from_date = $this->params['url']['from_date'];
			$to_date = $this->params['url']['to_date'];
			
			if(strlen($from_date) > 5 || strlen($to_date) > 5){
				
				$query_x = "SELECT `ext_no` FROM `ext_details` WHERE date(`ext_apply_date`) ";
				if(strlen($this->params['url']['from_date']) > 5){
				$query_x .= " >= '$from_date' ";	
					if(strlen($to_date) > 5){
						$query_x .= " AND date(`ext_apply_date`) <= '$to_date' ";
					}
				} elseif(strlen($to_date) > 5 && strlen($from_date) < 5){
				$query_x .= " <= '$to_date' ";
				}
				$query1 = $this->User->query($query_x);
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');

				$inter_arr = array_intersect($inter_arr, $query1);

			}
			
			
			if(strlen($this->params['url']['passport_no']) > 0 && $this->params['url']['passport_no'] != 'null'){
				$passport_no = $this->params['url']['passport_no'];
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_passportno` = '$passport_no' ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			if(strlen($this->params['url']['psg_name']) > 0 && $this->params['url']['psg_name'] != 'null'){
				$psg_name = $this->params['url']['psg_name'];
				$psg_name = explode(' ', $psg_name);
				$psg_name = implode('\',\'', $psg_name);
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_name` IN ('$psg_name') ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			if($visa_types_a != 'null'){
				$query1 = $this->User->query("SELECT `ext_group_id` FROM `ext_details` WHERE `ext_group_id` IS NOT NULL and ext_status = 1");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_group_id','{n}.ext_details.ext_group_id');
				$query1_c = implode(',', $query1);
				
				if(count($query1)>0){
				$query2 = $this->User->query('Select visa_tbl.app_id,visa_tbl.app_no,visa_tbl.passport_no,visa_tbl.first_name,visa_tbl.last_name,visa_app_group.visa_type From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.app_id in ('.$query1_c.') AND visa_app_group.visa_type IN('.$visa_types_a.')');
	      		$query2 = Set::combine($query2,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
				$appId = implode('\',\'', $query2);
				$aquery2 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_group_id` IN('$appId')");
				
	      		$aquery2 = Set::combine($aquery2,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');

				$visa_type_res = $aquery2;
					if(count($aquery2) > 0){
						$inter_arr = array_intersect($inter_arr, $aquery2);
					} else {
						$inter_arr = array();
					}
				} else {
						$inter_arr = array();
					}
					
			}


			if($agents_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_user_id` IN ($agents_a)  and ext_status = 1 ");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);

			}
			
			if($ext_status_a != 'null' && count($inter_arr) > 0){
				$query1 = $this->User->query("SELECT `ext_no` FROM `ext_details` WHERE `ext_payment_status` IN($ext_status_a)  and ext_status = 1");
				$query1 = Set::combine($query1,'{n}.ext_details.ext_no','{n}.ext_details.ext_no');
				$inter_arr = array_intersect($inter_arr, $query1);
			}

			$data = $this->extension_id_details($inter_arr);
			$view->set('data',$data);
			
			
			if(isset($export_filetype) && $export_filetype == 'xls') {
			$html = $view->render('export_extn_report');
			echo $html;
			} else {
			
			$html = $view->render('export_extn_pdf');
			//echo $html;exit;
			if(file_exists(WWW_ROOT.'uploads/receipt/visa_ex') == false)
			mkdir(WWW_ROOT.'uploads/receipt/visa_ex');
			$my_file = WWW_ROOT.'uploads/receipt/visa_ex/EXTN_Repoer.pdf';
			if(file_exists($my_file) == false)
			$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
			
			$this->dompdf = new DOMPDF();
			$papersize='legal';
			$orientation='landscape';
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper($papersize, $orientation);
			$this->dompdf->render();
			$output = $this->dompdf->output();
			//echo $this->dompdf->output();
			file_put_contents($my_file, $output);
			//return $my_file;
			
			
			$file=$my_file; //file location
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="EXTN_Report_Export.pdf"');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			
			
			}
			
			
			
			} 
		}
    
		
		public function getxml_test($data){
	$view = new View($this, false);
        		$view->layout = null;
	header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
        	header ("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
        	header ("Cache-Control:  max-age=0, must-revalidate");
        	header ("Pragma: no-cache");
        	header ("Content-type: application/vnd.ms-excel");
        	header ('Content-Disposition: attachment;filename="Visa-App : .xls"');
        	header ("Content-Description: Generated Report" );
			$this->set('data',$data);
			$this->render('export_visa_xml');
	}
     
	public function visatype_ckedit($v_id) {
		//$v_id =2;
		$doc = '';
		$data = $this->User->query('Select * From visa_type_master Where visa_type_id = '.$v_id.' ');
        	if(count($data) > 0)
        	{	
				$v_id = $data[0]['visa_type_master']['visa_type_id'];
				$v_name = $data[0]['visa_type_master']['visa_type'];
        		$doc = $data[0]['visa_type_master']['eligibility_type'];
        		$this->set('doc',$doc);
        		$this->set('v_id',$v_id);
        		$this->set('v_name',$v_name);
        	}
			//$this->render('viewVisaCost');
        }
		
		
		public function update_visatype(){
			
			$this->autoRender = false;
        	if ($this->request ->isPost()) {
        		$v_id  = '';
        		$test = Sanitize::clean($this->request->data('document'), array('encode' => FALSE));
        		$v_id = $this->request->data('visa_type_id');
        		$this->User->query('Update visa_type_master set eligibility_type = "'.$test.'" WHERE visa_type_id = '.$v_id.' ');
	        	$this->visatype_ckedit($v_id);
        	}
        		$this->render('visatype_ckedit');
        }
		
		
		public function elegibility(){
		$this->autoRender=false;
		$userId = $_POST['id'];
		$type = ""; $value = "";
		$this->User->useTable = "";
		$this->User->useTable = 'visa_type_master';
		$ans = $this->User->find('all',array('conditions'=>array('visa_type_id'=>$_POST['id'])));
		foreach($ans as $a){
		$data = $this->User->query('Select eligibility_type From visa_type_master Where visa_type_id = '.$_POST['id'] );
		echo $a['User']['eligibility_type'];
		}
		}
	
        public function search_app()
        {
        	if ($this->request->isPost())
        	{
        		$this->Relation->useTable = 'visa_tbl';
        		if($this->UserAuth->getGroupName() != 'Admin') {
        			$userId = $this->UserAuth->getUserId();
        			$result = $this->Relation->find('all',array('conditions'=>array('status'=>1,'user_id'=>$userId)));
        		}else{
        			$result = $this->Relation->find('all',array('conditions'=>array('status'=>1)));
        		}
        		$app_id ='';$app_id_old ='';
        		if(count($result) > 0)
        		{
        			foreach($result as $r)
        			$app_id[$r['Relation']['app_id']]=$r['Relation']['app_id'];
        		}
        			
        		if(is_array($app_id))
        		{
        			$app_id_old =$app_id;
        			$app_id1 ='';
        			if(isset($this->request->data['User']['app_no']) and strlen($this->request->data['User']['app_no']) > 0 )
        			{
        				$app_id1 =array();
        				$ans = $this->Relation->query('select * from visa_tbl where app_no ="'.$this->request->data['User']['app_no'].'"');
        				if(count($ans) > 0)
        				{
        					foreach($ans as $a)
        					$app_id1[$a['visa_tbl']['app_id']] = $a['visa_tbl']['app_id'];
        				}else
        				$app_id1[]='';
        			}
        			 
        			if(is_array($app_id1))
        			$app_id = array_intersect($app_id, $app_id1);


        			$app_id1 ='';
        			if(isset($this->request->data['User']['group_id']) and strlen($this->request->data['User']['group_id']) > 0 )
        			{
        				$app_id1 =array();
        				$res = $this->Relation->query('select * from visa_app_group where group_no = "'.$this->request->data['User']['group_id'].'"');
        					
        				if(count($res) > 0)
        				{
        					foreach($res as $r)
        					{
        						$ans= $this->Relation->query('select * from visa_tbl where group_id = '.$r['visa_app_group']['group_id']);
        							
        						if(count($ans) > 0)
        						{
        							foreach($ans as $a)
        							$app_id1[$a['visa_tbl']['app_id']] = $a['visa_tbl']['app_id'];
        						}else
        						$app_id1[]='';
        					}
        				}
        			}

        			if(is_array($app_id1))
        			$app_id = array_intersect($app_id, $app_id1);

        			$app_id1 ='';
        			if(isset($this->request->data['User']['passport_no']) and strlen($this->request->data['User']['passport_no']) > 0 )
        			{
        				$app_id1 =array();
        				$ans = $this->Relation->query('select * from visa_tbl where passport_no ="'.$this->request->data['User']['passport_no'].'"');
        				if(count($ans) > 0)
        				{
        					foreach($ans as $a)
        					$app_id1[$a['visa_tbl']['app_id']] = $a['visa_tbl']['app_id'];
        				}else
        				$app_id1[]='';
        			}

        			if(is_array($app_id1))
        			$app_id = array_intersect($app_id, $app_id1);

        				
        			$app_id1 ='';
        			if(isset($this->request->data['User']['psg_name']) and strlen($this->request->data['User']['psg_name']) > 0 )
        			{
        				$app_id1 =array();
        				$p_name = explode(' ',$this->request->data['User']['psg_name']);
        				foreach($p_name as $p){
        					$ans = $this->Relation->query('select * from visa_tbl where first_name like "%'.$p.'%" or last_name like "%'.$p.'%"');
        				}
        					
        				if(count($ans) > 0)
        				{
        					foreach($ans as $a)
        					$app_id1[$a['visa_tbl']['app_id']] = $a['visa_tbl']['app_id'];
        				}else
        				$app_id1[]='';
        			}

        			if(is_array($app_id1)){ $app_id = array_intersect($app_id, $app_id1);
        			}
        		}
        		if(is_array($app_id) and count($app_id) > 0)
        		{
        			$appData = implode(',',$app_id);
        			$aData = $this->Relation->query('Select * From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.app_id in ('.$appData.') and visa_app_group.upload_status = 1 and visa_app_group.status = 1 and visa_app_group.tr_status > 1 ');
        			$aValue = Set::combine($aData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_id');
        			$data = $this->get_search_visa_data($aValue);
        				
        		}else
        		$this->Session->setFlash('Sorry!! No Applications Found for given criteria.', 'default', array('class' => 'errorMsg'));

        	}
        	else
        	$this->Session->setFlash('Sorry!! No Applications Found for given criteria.', 'default', array('class' => 'errorMsg'));

        	$this->autoRender =false;

        	$visa_type=$this->get_visa_dropdown();
        	$this->set('visa_type', $visa_type);

        	$airline=$this->get_dropdown('airline_id', 'airline','airline_master');
        	$this->set('airline', $airline);

        	$country=$this->get_dropdown('country_id', 'country','country_master');
        	$this->set('country', $country);

        	$travel_city=$this->get_dropdown('travel_city_id', 'travel_city','travel_city_master');
        	$this->set('travel_city', $travel_city);

        	$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	$this->set('tr_status', $tr_status);
        	$this->render('search');
        }

        public function get_search_visa_data($app_id){
        	$visa_apps='';$group_no = '';$tentative_date = '';$username = '';
        	foreach($app_id as $a)
        	{
        		$this->User->useTable='visa_tbl';
        		$res = $this->User->find('all',array('conditions'=>array('app_id'=>$a)));
        		foreach($res as $r)
        		$visa_apps[$r['User']['app_id']] = $r;
        	}
        	$this->set('visa_apps',$visa_apps);
        	$status ='';$tentative_date ='';$group_no='';$applicant = "";
        	foreach($visa_apps as $row)
        	{

        		$this->Relation->useTable = 'visa_app_group';
        		$ans1 = $this->Relation->query('select * from visa_app_group where group_id='.$row['User']['group_id']);

        		$this->Relation->useTable = 'tr_status_master';
        		$ans = $this->Relation->query('select * from tr_status_master where tr_status_id='.$ans1[0]['visa_app_group']['tr_status']);

        		if(count($ans) > 0)
        		{
        			$status[$row['User']['app_id']] = $ans[0]['tr_status_master']['tr_status'];
        		}

        		$this->Relation->useTable = 'users';
        		$ans = $this->Relation->query('select * from users where id='.$row['User']['user_id']);
        		if(count($ans) > 0)
        		{
        			$username[$row['User']['app_id']] = $ans[0]['users']['username'];
        		}

        		$this->Relation->useTable = 'visa_app_group';
        		$ans = $this->Relation->query('select * from visa_app_group where group_id='.$row['User']['group_id']);
        		if(count($ans) > 0)
        		{
        			$group_no[$row['User']['app_id']]=$ans[0]['visa_app_group']['group_no'];
        			$tentative_date[$row['User']['app_id']] = $ans[0]['visa_app_group']['tent_date'];
        		}

        		$this->Relation->useTable = 'group_meta';
        		$grpdata = $this->Relation->query('Select * From group_meta Where group_id = '.$row['User']['group_id'].' and meta_key = "applicant"');
        		if(count($grpdata) > 0){
        			$applicant[$row['User']['app_id']] = $grpdata[0]['group_meta']['meta_value'];
        		}
        	}

        	$this->set('username',$username);
        	$this->set('group_no',$group_no);
        	$this->set('tentative_date',$tentative_date);
        	$this->set('applicant',$applicant);
        	$this->set('status',$status);
        	return ;
        }


        public function visa_cost_settings()
        {
        	//$users=$this->User->find('all', array('conditions'=>array('status'=>1,'approve'=>0,'username !='=>'admin'),'order'=>'User.id desc'));
        	$this->User->useTable = 'users';
        	$users = $this->User->query('select * from users where status = 1 and approve = 1 and user_group_id = 2 order by id desc');
        	$admin_visa_cost = 50;
        	$ans = $this->User->query('select * from admin_settings where a_key ="admin_cost"');
        	if(count($ans) > 0)
        	$admin_visa_cost = $ans[0]['admin_settings']['a_value'];
        	if(count($users) > 0)
        	{
        		$this->set('users',$users);
        		$bus_name='';$visa_cost='';$cr_date='';
        		if(count($users) > 0){
        			foreach($users as $user)
        			{

        				
        				$cr_date[$user['users']['id']] = $user['users']['created'];
        				$this->Relation->useTable = 'user_meta';
        				$data =$this->Relation->query('select * from user_meta where user_id = '.$user['users']['id'].' and meta_key = "bus_name"');
        				foreach($data as $d)
        				{
        					$bus_name[$user['users']['id']] = $d['user_meta']['meta_value'];
        				}

        				$data =$this->Relation->query('select * from visa_cost where user_id = '.$user['users']['id']);
        				if(count($data)>0)
        				{
        					$visa_cost[$user['users']['id']] = $data[0]['visa_cost']['visa_cost'];
        					$cr_date[$user['users']['id']] = $data[0]['visa_cost']['update_date'];
        				}else
        				$visa_cost[$user['users']['id']] = $admin_visa_cost;
        			}
        		}
        		$this->set('cr_date',$cr_date);
        		$this->set('bus_name',$bus_name);
        		$this->set('visa_cost',$visa_cost);
        		//$this->set('currency',$currency);
        		$this->autoRender = false;

        		$this->render('visa_cost_settings');
        	}
        }

        public function change_cost($user_id,$app='no_val')
        {
        	$visa_type=$this->get_visa_dropdown($user_id);
        	$this->set('visa_type', $visa_type);

        	        	 
        	$admin_visa_cost = 50;
        	$ans = $this->User->query('select * from visa_type_master ');
        	if(count($ans) > 0)
        	$ans[0]['visa_type_master']['visa_type'] = $ans[0]['visa_type_master']['visa_cost'];

        	$this->User->useTable = 'users';
        	$this->Relation->useTable = 'user_meta';
        	$data =$this->Relation->query('select * from user_meta where user_id = '.$user_id.' and meta_key = "bus_name"');
        	foreach($data as $d)
        	{
        		$this->set('username',$d['user_meta']['meta_value']);
        	}

        	if($app == 'no_val')
        	{
        		$data =$this->Relation->query('select * from visa_cost where user_id = '.$user_id);
        		if(count($data)>0)
        		{
        			$this->set('visa_cost', $data[0]['visa_cost']['visa_cost']);
        		}else
        		$this->set('visa_cost', $admin_visa_cost);
        	}else
        	$this->set('visa_cost', $app);
        	$this->set('user_id', $user_id);
        	$this->render('change_cost');
        }

        public function viewVisaCost() {
        	$userId = $_POST['id'];
        	$type = ""; $value = "";
        	$this->User->useTable = "";
        	$this->User->useTable = 'visa_type_master';
        	$ans = $this->User->find('all',array('conditions'=>array('status'=>1)));
        		
        	foreach($ans as $a){
        		$type[$a['User']['visa_type_id']] = $a['User']['visa_type'];
        		$data = $this->User->query('Select * From visa_cost Where user_id = '.$userId.' and visa_type = '.$a['User']['visa_type_id']);

        		if(count($data) > 0){
        			$cost[$a['User']['visa_type_id']] = $data[0]['visa_cost']['visa_cost'];
        			$scost[$a['User']['visa_type_id']] = ($data[0]['visa_cost']['visa_scost'] == null) ? $a['User']['visa_scost'] : $data[0]['visa_cost']['visa_scost']; 
        		}else{ 
        			$cost[$a['User']['visa_type_id']] =$a['User']['visa_cost']; 
        			$scost[$a['User']['visa_type_id']] = $a['User']['visa_scost']; 
        		}
        	}
        	$currency = $this->currency_val($userId);
        	$this->set('currency',$currency);					
        	$this->set('type',$type);
        	$this->set('cost',$cost);
        	$this->set('scost',$scost);
        }

        public function save_cost()
        {
        	if ($this->request ->isPost()) {
        		$this->User->set($this->data);
        			
        		if ($this->User->VisaCostValidate())
        		{
        			$user_id = $this->request->data['User']['user_id'];
        			$this->User->useTable = 'visa_cost';
        			$ans = $this->User->find('all',array('conditions'=>array('user_id'=>$this->request->data['User']['user_id'],'visa_type'=>$this->request->data['User']['visa_type'])));
        			$this->request->data['User']['update_date']=date('d-m-Y');

        			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Change Visa Cost" and user_id = '.$this->request->data['User']['user_id'].' and other_id = '.$this->request->data['User']['visa_type']);
	        			if(count($ans) > 0) $this->User->query('Insert into user_action(role_id,type,user_id,other_id,prev_value,updated_value,date,status) values("'.$roleId.'","Change Visa Cost",'.$this->request->data['User']['user_id'].','.$this->request->data['User']['visa_type'].',"'.$ans[0]['User']['visa_cost'].'","'.$this->request->data['User']['visa_cost'].'","'.date('Y-m-d H:i:s').'",1) ');
	        			else $this->User->query('Insert into user_action(role_id,type,user_id,other_id,prev_value,updated_value,date,status) values("'.$roleId.'","Change Visa Cost",'.$this->request->data['User']['user_id'].','.$this->request->data['User']['visa_type'].',0,"'.$this->request->data['User']['visa_cost'].'","'.date('Y-m-d H:i:s').'",1) ');
        			}
        			
        			if(count($ans) > 0)
        			{
        				$date_cr =date('d-m-Y');
        				$this->User->query('update visa_cost set visa_cost = "'.$this->request->data['User']['visa_cost'].'",visa_scost = "'.$this->request->data['User']['visa_scost'].'", update_date="'.$this->request->data['User']['update_date'].'" where user_id = '.$this->request->data['User']['user_id'].' and visa_type = '.$this->request->data['User']['visa_type']);
        			}
        			else
        			$this->User->save($this->request->data,false);
        			$this->autoRender = false;
        			$this->visa_cost_settings();
        			$this->Session->setFlash(__('Visa Cost Updated!!'));
        			$this->change_cost($this->request->data['User']['user_id'],$this->request->data['User']['visa_cost'],$this->request->data['User']['visa_scost']);
        				
        		}else
        		{
        			$this->autoRender =false;
        			$this->change_cost($this->request->data['User']['user_id'],$this->request->data['User']['visa_cost']);
        		}
        	}else
        	{
        		$this->autoRender =false;
        		$this->visa_cost_settings();
        	}
        }

        public function save_upload()
        {
        	if ($this->request -> isPost()) {
        		$this->User->set($this->data);

        		$group_data = $this->User->query('Select * from visa_app_group Where group_id='.$this->request->data['groupId']);
        		$group_no = $group_data[0]['visa_app_group']['group_no'];
        		$visa_type = $group_data[0]['visa_app_group']['visa_type'];

        		$ak = 1; $bk = 1; $ck = 1;	$set = 1;
        		$a = $this->request->data['adult']; $b = $this->request->data['adult']+$this->request->data['children'];
        		for($i=1;$i<=$this->request->data['hid_count1'];$i++){
        			if($a != 0 && $i <= $a){  $id = '-A'.$ak;$ak++; }
        			else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $bk++;}
        			else{ $id = '-I'.$ck; $ck++;}

        			$random =rand(111111,999999);

        			$app_data = $this->User->query('Select * from visa_tbl Where app_no="'.$this->request->data['User']['app_no'.$id].'"');
        			$app_id = $app_data[0]['visa_tbl']['app_id'];

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no))
        			mkdir(WWW_ROOT.'uploads/'.$group_no, 0777, true);

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id]))
        			mkdir(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id], 0777, true);
        				
        			if(isset($this->request->data['User']['pfp'.$id]['name']) && strlen($this->request->data['User']['pfp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['pfp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$pfp_name = 'pfp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['pfp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$pfp_name);
        				$this->request->data['User']['pfp'.$id]= $pfp_name;
        			}else
        			$this->request->data['User']['pfp'.$id]='';

        			if(isset($this->request->data['User']['plp'.$id]['name']) && strlen($this->request->data['User']['plp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['plp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$plp_name = 'plp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['plp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$plp_name);
        				$this->request->data['User']['plp'.$id]= $plp_name;
        			}else
        			$this->request->data['User']['plp'.$id]='';
        				
        			if(isset($this->request->data['User']['pop'.$id]['name']) && strlen($this->request->data['User']['pop'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['pop'.$id]['name']);
        				$extension = $addr_ext[1];
        				$pop_name = 'pop_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['pop'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$pop_name);
        				$this->request->data['User']['pop'.$id]= $pop_name;
        			}else
        			$this->request->data['User']['pop'.$id]='';
        				
        			if(isset($this->request->data['User']['addr'.$id]['name']) && strlen($this->request->data['User']['addr'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['addr'.$id]['name']);
        				$extension = $addr_ext[1];
        				$addr_name = 'addr_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['addr'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$addr_name);
        				$this->request->data['User']['addr'.$id]= $addr_name;
        			}else
        			$this->request->data['User']['addr'.$id]='';
        				
        			if(isset($this->request->data['User']['photograph'.$id]['name']) && strlen($this->request->data['User']['photograph'.$id]['name']) > 0)
        			{
        				$photo_ext = explode('.',$this->request->data['User']['photograph'.$id]['name']);
        				$extension = $photo_ext[1];
        				$photo_name = 'photograph_'.$photo_ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['photograph'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$photo_name);
        				$this->request->data['User']['photograph'.$id]= $photo_name;
        			}else
        			$this->request->data['User']['photograph'.$id]='';

        			if(isset($this->request->data['User']['ticket1'.$id]['name']) && strlen($this->request->data['User']['ticket1'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket1'.$id]['name']);
        				$extension = $ext[1];
        				$ticket1_name = 'ticket1_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket1'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket1_name);
        				$this->request->data['User']['ticket1'.$id]= $ticket1_name;
        			}else
        			$this->request->data['User']['ticket1'.$id]='';

        			if(isset($this->request->data['User']['ticket2'.$id]['name']) && strlen($this->request->data['User']['ticket2'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket2'.$id]['name']);
        				$extension = $ext[1];
        				$ticket2_name = 'ticket2_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket2'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket2_name);
        				$this->request->data['User']['ticket2'.$id]= $ticket2_name;
        			}else
        			$this->request->data['User']['ticket2'.$id]='';


        			if(isset($this->request->data['User']['ticket3'.$id]['name']) && strlen($this->request->data['User']['ticket3'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket3'.$id]['name']);
        				$extension = $ext[1];
        				$ticket3_name = 'ticket3_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket3'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket3_name);
        				$this->request->data['User']['ticket3'.$id]= $ticket3_name;
        			}else
        			$this->request->data['User']['ticket3'.$id]='';
        				
        			$visa_data = array('pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id);
        			foreach($this->request->data['User'] as $key => $value)
        			{
        				if(in_array($key,$visa_data)){
        					$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$app_id.',"'.$key.'","'.$value.'")');
        				}
        			}
        			if(strlen($this->request->data['User']['pfp'.$id]) > 0 && strlen($this->request->data['User']['plp'.$id]) > 0 && strlen($this->request->data['User']['photograph'.$id]) > 0){
        				$set = $set + 1;
        			}
        		}

        		if(isset($this->request->data['User']['add_doc1']['name']) && strlen($this->request->data['User']['add_doc1']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc1']['name']);
        			$extension = $ext[1];
        			$add_doc1_name = 'doc1_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc1']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$add_doc1_name);
        			$this->request->data['User']['add_doc1']= $add_doc1_name;
        		}else
        		$this->request->data['User']['add_doc1']='';

        		if(isset($this->request->data['User']['add_doc2']['name']) && strlen($this->request->data['User']['add_doc2']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc2']['name']);
        			$extension = $ext[1];
        			$doc2_name = 'doc2_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc2']['tmp_name'],WWW_ROOT.'uploads/'.$group_no.'/'.$doc2_name);
        			$this->request->data['User']['add_doc2']= $doc2_name;
        		}else
        		$this->request->data['User']['add_doc2']='';
        			
        		if(isset($this->request->data['User']['add_doc3']['name']) && strlen($this->request->data['User']['add_doc3']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc3']['name']);
        			$extension = $ext[1];
        			$doc3_name = 'doc3_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc3']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$doc3_name);
        			$this->request->data['User']['add_doc3']= $doc3_name;
        		}else
        		$this->request->data['User']['add_doc3']='';
        			
        		if(isset($this->request->data['User']['add_doc4']['name']) && strlen($this->request->data['User']['add_doc4']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc4']['name']);
        			$extension = $ext[1];
        			$doc4_name ='doc4_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc4']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$doc4_name);
        			$this->request->data['User']['add_doc4']=$doc4_name;
        		}else
        		$this->request->data['User']['add_doc4']='';

        		$group_data = array('add_doc1','add_doc2','add_doc3','add_doc4');
        		foreach($this->request->data['User'] as $key => $value)
        		{
        			if(in_array($key,$group_data)){
        				$this->User->query('Insert into group_meta(group_id,meta_key,meta_value) values('.$this->request->data['groupId'].',"'.$key.'","'.$value.'")');
        			}
        		}
        		//exit;
        		//	echo $set; echo $i;
        		$resData = array();
        		if($set == $i) {
        			$resData = $this->User->query('Select * From visa_app_group Where group_id = '.$this->request->data['groupId'].' and tr_status = 2');
        			if(count($resData) == 0)
        			$this->User->query('Update visa_app_group set tr_status = 1 , upload_status = 1 Where group_id = '.$this->request->data['groupId']);
        		}
        			
        			
        		//	exit;
        		//$this->Session->setFlash(__('Visa Application successfully saved..Now make payment for further process'));
        		$this->autoRender =false;
        		//echo $this->request->data['groupId']; echo $visa_type; exit;
        		$this->apply_for_visa($this->request->data['groupId'],$visa_type,'');
        		
        	}else{
        		$this->autoRender = false;
        		
        		$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
        		
        	}
        }
        public function edit_upload_data($groupId,$view = 1){
        	$data = $this->get_upload_data($groupId);
        	if(is_array($data)){
        		foreach($data as $keys=>$values){
        			$app['User'][$keys]=$values;
        		}
        	}
        	//print_r($app);
        	$this->set('data',$app);
        	$this->set('groupId',$groupId);
        	if($view == 2)
        	$this->set('application','all');
        	$this->autoRender = false;
        	$this->visa_app(1);
        	$this->render('edit_upload');
        }

        public function edit_upload(){
        	if ($this->request -> isPost()) {
        		$this->User->set($this->data);
        		//	print_r($this->request->data());
        		$data = $this->get_upload_data($this->request->data['groupId']);
        		if(is_array($data)){
        			foreach($data as $keys=>$values){
        				$app['User'][$keys]=$values;
        			}
        		}
        		//echo '<pre>'; print_r($data);
        		$group_data = $this->User->query('Select * from visa_app_group Where group_id='.$this->request->data['groupId']);
        		$group_no = $group_data[0]['visa_app_group']['group_no'];
        		//print_r($this->request->data['User']); exit;
        		$ak = 1; $bk = 1; $ck = 1;	 $id_data = array();
        		$a = $this->request->data['adult']; $b = $this->request->data['adult']+$this->request->data['children'];
        		for($i=1;$i<=$this->request->data['hid_count1'];$i++){
        			if($a != 0 && $i <= $a){  $id = '-A'.$ak;$ak++; }
        			else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $bk++;}
        			else{ $id = '-I'.$ck; $ck++;}
        			$id_data[] = $id;

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no))
        			mkdir(WWW_ROOT.'uploads/'.$group_no, 0777, true);

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id]))
        			mkdir(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id], 0777, true);
        				
        			$app_data = $this->User->query('Select * from visa_tbl Where app_no="'.$this->request->data['User']['app_no'.$id].'"');
        			$app_id = $app_data[0]['visa_tbl']['app_id'];
        				
        			$app_no = $this->request->data['User']['app_no'.$id];
        			$app1 = explode('-',$app_no);
        			$random = $app1[1];

        			if(strlen($this->request->data['User']['pfp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['pfp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$pfp_name = 'pfp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['pfp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$pfp_name);
        				$this->request->data['User']['pfp'.$id]= $pfp_name;
        				if(strlen($app['User']['pfp'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['pfp'.$id]; if(file_exists($file)) unlink($file);  }
        			}else
        			$this->request->data['User']['pfp'.$id]='';

        			if(strlen($this->request->data['User']['plp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['plp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$plp_name = 'plp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['plp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$plp_name);
        				$this->request->data['User']['plp'.$id]= $plp_name;
        				if(strlen($app['User']['plp'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['plp'.$id]; if(file_exists($file)) unlink($file);  }
        					
        			}else
        			$this->request->data['User']['plp'.$id]='';
        				
        			if(strlen($this->request->data['User']['pop'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['pop'.$id]['name']);
        				$extension = $addr_ext[1];
        				$pop_name = 'pop_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['pop'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$pop_name);
        				$this->request->data['User']['pop'.$id]= $pop_name;
        				if(strlen($app['User']['pop'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['pop'.$id]; if(file_exists($file)) unlink($file);  }
        					
        			}else
        			$this->request->data['User']['pop'.$id]='';
        				
        			if(strlen($this->request->data['User']['addr'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['addr'.$id]['name']);
        				$extension = $addr_ext[1];
        				$addr_name = 'addr_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['addr'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$addr_name);
        				$this->request->data['User']['addr'.$id]= $addr_name;
        				if(strlen($app['User']['addr'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['addr'.$id]; if(file_exists($file)) unlink($file);   }
        					
        			}else
        			$this->request->data['User']['addr'.$id]='';
        				
        			if(strlen($this->request->data['User']['photograph'.$id]['name']) > 0)
        			{
        				$photo_ext = explode('.',$this->request->data['User']['photograph'.$id]['name']);
        				$extension = $photo_ext[1];
        				$photo_name = 'photograph_'.$photo_ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['photograph'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$photo_name);
        				$this->request->data['User']['photograph'.$id]= $photo_name;
        				if(strlen($app['User']['photograph'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['photograph'.$id]; if(file_exists($file)) unlink($file);  }
        					
        			}else
        			$this->request->data['User']['photograph'.$id]='';

        			if(strlen($this->request->data['User']['ticket1'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket1'.$id]['name']);
        				$extension = $ext[1];
        				$ticket1_name = 'ticket1_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket1'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket1_name);
        				$this->request->data['User']['ticket1'.$id]= $ticket1_name;
        				if(strlen($app['User']['ticket1'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['ticket1'.$id]; if(file_exists($file)) unlink($file);   }

        			}else
        			$this->request->data['User']['ticket1'.$id]='';

        			if(strlen($this->request->data['User']['ticket2'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket2'.$id]['name']);
        				$extension = $ext[1];
        				$ticket2_name = 'ticket2_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket2'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket2_name);
        				$this->request->data['User']['ticket2'.$id]= $ticket2_name;
        				if(strlen($app['User']['ticket2'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['ticket2'.$id]; if(file_exists($file)) unlink($file);  }

        			}else
        			$this->request->data['User']['ticket2'.$id]='';


        			if(strlen($this->request->data['User']['ticket3'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket3'.$id]['name']);
        				$extension = $ext[1];
        				$ticket3_name = 'ticket3_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket3'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$ticket3_name);
        				$this->request->data['User']['ticket3'.$id]= $ticket3_name;
        				if(strlen($app['User']['ticket3'.$id]) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'.$id].'/'.$app['User']['ticket3'.$id]; if(file_exists($file)) unlink($file);  }

        			}else
        			$this->request->data['User']['ticket3'.$id]='';
        				
        			$visa_data = array('pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id);
        			foreach($this->request->data['User'] as $key => $value)
        			{
        				if(in_array($key,$visa_data)){if(strlen($value) == 0) continue;
        				$this->User->query('Update visa_meta set visa_meta_value = "'.$value.'" Where app_id = '.$app_id.' and visa_meta_key = "'.$key.'"');
        				}
        			}
        		}

        		if(strlen($this->request->data['User']['add_doc1']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc1']['name']);
        			$extension = $ext[1];
        			$add_doc1_name = 'doc1_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc1']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$add_doc1_name);
        			$this->request->data['User']['add_doc1']= $add_doc1_name;
        			if(strlen($app['User']['add_doc1']) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$app['User']['add_doc1']; if(file_exists($file)) unlink($file);  }

        		}else
        		$this->request->data['User']['add_doc1']='';

        		if(strlen($this->request->data['User']['add_doc2']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc2']['name']);
        			$extension = $ext[1];
        			$doc2_name = 'doc2_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc2']['tmp_name'],WWW_ROOT.'uploads/'.$group_no.'/'.$doc2_name);
        			$this->request->data['User']['add_doc2']= $doc2_name;
        			if(strlen($app['User']['add_doc2']) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$app['User']['add_doc2']; if(file_exists($file)) unlink($file); }

        		}else
        		$this->request->data['User']['add_doc2']='';
        			
        		if(strlen($this->request->data['User']['add_doc3']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc3']['name']);
        			$extension = $ext[1];
        			$doc3_name = 'doc3_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc3']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$doc3_name);
        			$this->request->data['User']['add_doc3']= $doc3_name;
        			if(strlen($app['User']['add_doc3']) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$app['User']['add_doc3']; if(file_exists($file)) unlink($file);   }
        		}else
        		$this->request->data['User']['add_doc3']='';
        			
        		if(strlen($this->request->data['User']['add_doc4']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc4']['name']);
        			$extension = $ext[1];
        			$doc4_name ='doc4_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc4']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$doc4_name);
        			$this->request->data['User']['add_doc4']=$doc4_name;
        			if(strlen($app['User']['add_doc4']) > 0){ $file = WWW_ROOT.'uploads/'.$group_no.'/'.$app['User']['add_doc4']; if(file_exists($file)) unlink($file);   }
        		}else
        		$this->request->data['User']['add_doc4']='';
        			
        		$group_data = array('add_doc1','add_doc2','add_doc3','add_doc4');
        		foreach($this->request->data['User'] as $key => $value)
        		{
        			if(in_array($key,$group_data)){ if(strlen($value) == 0) continue;
        			$this->User->query('Update group_meta set meta_value = "'.$value.'" Where group_id='.$this->request->data['groupId'].' and meta_key = "'.$key.'"');
        			}
        		}

        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Visa" and action_type = "Edit Upload" and app_no = "'.$this->request->data['groupId'].'"');
        			$this->User->query('Insert into user_action(role_id,type,action_type,app_no,date,status) values("'.$roleId.'","Visa","Edit Upload","'.$this->request->data['groupId'].'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
        		$this->Session->setFlash(__('Visa Upload Data Updated successfully'));

        		$data1 = $this->get_upload_data($this->request->data['groupId']);

        		$set = 1;
        		foreach($id_data as $v){ $x1 = 0;$y1 = 0; $z1 = 0;
        		if(strlen($data1['pfp'.$v]) > 0 || strlen($this->request->data['User']['pfp'.$v]) > 0){
        			$x1 = 1;
        		}
        		if(strlen($data1['plp'.$v]) > 0 || strlen($this->request->data['User']['plp'.$v]) > 0){
        			$y1 = 1;
        		}
        		if(strlen($data1['photograph'.$v]) > 0 || strlen($this->request->data['User']['photograph'.$v]) > 0){
        			$z1 = 1;
        		}
        		if($x1 == 1 && $y1 == 1 && $z1 == 1) $set = $set + 1;
        			
        		}
        		if($set == $i) {
        			$this->User->query('Update visa_app_group set tr_status = 1 , upload_status = 1 Where group_id = '.$this->request->data['groupId'].' and tr_status = 0');
        		}
        			
        		$this->autoRender =false;
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$atr_status=$this->get_dropdown('atr_status_id', 'atr_status','admin_tr_status');
        		$this->set('atr_status', $atr_status);
        		$userId=$this->UserAuth->getUserId(); $total= 0;
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        		$this->set('userAmt',$total);
        		$this->get_visa_data();
        		//$this->set('visa_type',$data[0]);
        		//$this->set('status',$data[1]);
        		//$this->set('username',$data[2]);
        		//$this->set('applicant',$data[3]);
        		if($this->request->data['application'] == 'all')
        		$this->all_visa_app2();
        		else
        		$this->render('all_visa_app');
        	}else{
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$atr_status=$this->get_dropdown('atr_status_id', 'atr_status','admin_tr_status');
        		$this->set('atr_status', $atr_status);
        		$userId=$this->UserAuth->getUserId(); $total= 0;
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        		$this->set('userAmt',$total);
        		$data = $this->get_visa_data();
        		if($this->request->data['application'] == 'all')
        		$this->all_visa_app2();
        		else
        		$this->render('all_visa_app');
        	}

        }

        public function get_terms(){
        	$this->render('get_terms');
        }

        public function upload_visa($groupId=null){
        	if($groupId != null){
        		$this->set('groupId',$groupId);
        		$this->render('upload_visa');
        	}else{
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$userId=$this->UserAuth->getUserId(); $total= 0;
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        		$this->set('userAmt',$total);
        		$data = $this->get_visa_data();
   				$this->render('all_visa_app');
        	}
        }

 public function upload_visa1($groupId=null){
        	if($groupId != null){
        		if ($this->request ->isPost()) {
        			$email= '';
        			$data = $this->User->query('Select * From visa_app_group join users on visa_app_group.user_id = users.id Where visa_app_group.group_id='.$groupId);
					$user_role_email = '';
					$visa_type = $data[0]['visa_app_group']['visa_type'];
        			$group_no = $data[0]['visa_app_group']['group_no'];
        			$email = $data[0]['users']['email'];
        			$username = $data[0]['users']['username'];
        			if(isset($this->request->data['User']['upload']['name']) && strlen($this->request->data['User']['upload']['name']) > 0)
        			{
        				if(!file_exists(WWW_ROOT.'uploads/visa/'.$group_no))
        				mkdir(WWW_ROOT.'uploads/visa/'.$group_no, 0777, true);
        					
        				$random =rand(111111,999999);
        					
        				$ext = explode('.',$this->request->data['User']['upload']['name']);
        				$extension = $ext[1];
        				$upload_name = $group_no.'-Visa'.$random.'.'.$extension;
        				$path =  WWW_ROOT.'uploads/visa/'.$group_no.'/'.$upload_name;
        				move_uploaded_file($this->request->data['User']['upload']['tmp_name'],$path);
        				$this->User->query('Update visa_app_group set visa_path = "'.$upload_name.'" Where group_id = '.$groupId);
        				$this->User->sendUploadVisaMail($group_no,$this->visa_From_email(),$path,$email,$username);
        				$this->set('msg','Visa Uploaded Successfully');
        			}else
        			$this->set('err','Select a File to Upload');
        			$this->set('groupId',$groupId);
        			$this->render('upload_visa');
        		}else{
        			$this->set('groupId',$groupId);
        			$this->render('upload_visa');
        		}
        	}else{
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$userId=$this->UserAuth->getUserId(); $total= 0;
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        		$this->set('userAmt',$total);
        		$data = $this->get_visa_data();
        		 $this->render('all_visa_app');
        	}
        }
        public function download($groupId=null) {
        	if($groupId != null){
        		$data = $this->User->query('Select * From visa_app_group Where group_id='.$groupId);
        		$group_no = $data[0]['visa_app_group']['group_no'];
        		$path_name = $data[0]['visa_app_group']['visa_path'];

        		$path = WWW_ROOT.'uploads/visa/'.$group_no.'/'.$path_name;
        		if (file_exists($path)) {
        			$this->response->file($path, array(
        'download' => true,
        'name' => $path_name,
        			));
        			return $this->response;
        		}else{
        			$this->Session->setFlash(__('Sorry!!! File Not Found. '));
        			$this->autoRender = false;
        			$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        			$this->set('tr_status', $tr_status);
        			$userId=$this->UserAuth->getUserId(); $total= 0;
        			$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        			if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        			$this->set('userAmt',$total);
        			$data = $this->get_visa_data();
        			//$this->set('status',$data[1]);
        			//$this->set('airline',$data[0]);
        			//$this->set('username',$data[2]);
        			//$this->set('applicant',$data[3]);
        			$this->render('all_visa_app');
        		}
        	}else{
        		$userId=$this->UserAuth->getUserId(); $total= 0;
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
        		$this->set('userAmt',$total);
        		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        		$this->set('tr_status', $tr_status);
        		$data = $this->get_visa_data();
        		//$this->set('status',$data[1]);
        		//$this->set('airline',$data[0]);
        		//$this->set('username',$data[2]);
        		//$this->set('applicant',$data[3]);
        		$this->render('all_visa_app');
        	}
        }

        public function document(){
        	$data = $this->User->query('Select * From admin_settings Where a_key = "document"');
        	if(count($data) > 0)
        	{
        		$doc = $data[0]['admin_settings']['a_value'];
        		$this->set('doc',$doc);
        		$this->render('document');
        	}
        }

        public function adocument(){
        	$data = $this->User->query('Select * From admin_settings Where a_key = "document"');
        	if(count($data) > 0)
        	{
        		$doc = $data[0]['admin_settings']['a_value'];
        		$this->set('doc',$doc);
        	}
        }

        public function add_doc(){
        	if ($this->request ->isPost()) {
        		$test = Sanitize::clean($this->request->data('document'), array('encode' => FALSE));
        		$this->User->query('Update admin_settings set a_value = "'.$test.'" Where a_key = "document"');
        	}
        	$this->autoRender = false;
        	$this->adocument();
        	$this->render('adocument');
        }

                public function amt_bal(){
        	$data = $this->User->query('select * From users join user_wallet on user_wallet.user_id  = users.id Where users.status = 1 and users.active = 1');
        	//$amtData =Set::combine($data,'{n}.users.id','{n}.users.username');
        	//$amtData =Set::combine($data,'{n}.users.id','{n}.user_wallet.amount');
        	$cur_val = $this->User->query('Select * From currency_master Where status = 1');	
        	$currency =Set::combine($cur_val,'{n}.currency_master.currency_id','{n}.currency_master.currency_code');
        	$this->set('currency',$currency);
        	$this->set('amtData',$data);
        	$this->autoRender = false;
			//echo '<pre>';
			foreach($data as $test){
			//echo $test['users']['id'].' ';
			$fx[$test['users']['id']] = $this->get_outstanding2($test['users']['id']);
			}
			$this->set('fx',$fx);
        	$this->render('amt_bal');

        }	
		
	
	public function get_outstanding2($userId=0){

		$query1 = $this->User->query("SELECT SUM(`amount`) as sum1 FROM `visa_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum1 = $query1[0][0]['sum1'];
		$query2 = $this->User->query("SELECT SUM(`amount`) as sum2 FROM `oktb_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum2 = $query2[0][0]['sum2'];
		$query3 = $this->User->query("SELECT SUM(`amount`) as sum3 FROM `ext_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum3 = $query3[0][0]['sum3'];
		
		$first_sum = ($sum1+$sum2+$sum3 > 0) ? $sum1+$sum2+$sum3 : 0;
		
		$query4 = $this->User->query("SELECT SUM(`amt`) as sum4 FROM `new_transaction` WHERE `user_id` = $userId AND status = 1");
		$sum4 = $query4[0][0]['sum4'];
		$query5 = $this->User->query("SELECT SUM(`avail_th`) as sum5 FROM `threshold` WHERE `user_id` = $userId ");
		$sum5 = $query5[0][0]['sum5'];
		
		$second_amt = ($sum4+$sum5 > 0) ? $sum4+$sum5: 0;
		
		$currency = $this->User->query("SELECT `currency` FROM `users` WHERE `id` = $userId");
		$currency_num = isset($currency[0]['users']['currency'])?$currency[0]['users']['currency']:0;
		$currency_type = isset($currency[0]['users']['currency'])?$this->User->query("SELECT `currency_code` FROM `currency_master` WHERE `currency_id` = $currency_num"):'NA';
		$currency_typex = (is_array($currency_type) && isset($currency_type[0]['currency_master']['currency_code'])  )?$currency_type[0]['currency_master']['currency_code']:'NA';
		if($second_amt-$first_sum < $sum5){
			$outstandint_amt = $sum5 - ($second_amt-$first_sum);
		} else {
			$outstandint_amt = 0;
		}

		$data[1] = isset($outstandint_amt)?$outstandint_amt:0;
		$data[2] = isset($sum5)?$sum5:0;
		$data[3] = isset($currency_typex)?$currency_typex:'NA';
		return $data;$query1 = $this->User->query("SELECT SUM(`amount`) as sum1 FROM `visa_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum1 = $query1[0][0]['sum1'];
		$query2 = $this->User->query("SELECT SUM(`amount`) as sum2 FROM `oktb_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum2 = $query2[0][0]['sum2'];
		$query3 = $this->User->query("SELECT SUM(`amount`) as sum3 FROM `ext_transactions` WHERE `user_id` = $userId AND status = 1");
		$sum3 = $query3[0][0]['sum3'];
		
		$first_sum = ($sum1+$sum2+$sum3 > 0) ? $sum1+$sum2+$sum3 : 0;
		
		$query4 = $this->User->query("SELECT SUM(`amt`) as sum4 FROM `new_transaction` WHERE `user_id` = $userId AND status = 1");
		$sum4 = $query4[0][0]['sum4'];
		$query5 = $this->User->query("SELECT SUM(`avail_th`) as sum5 FROM `threshold` WHERE `user_id` = $userId ");
		$sum5 = $query5[0][0]['sum5'];
		
		$second_amt = ($sum4+$sum5 > 0) ? $sum4+$sum5: 0;
		
		$currency = $this->User->query("SELECT `currency` FROM `users` WHERE `id` = $userId");
		$currency_num = isset($currency[0]['users']['currency'])?$currency[0]['users']['currency']:0;
		$currency_type = isset($currency[0]['users']['currency'])?$this->User->query("SELECT `currency_code` FROM `currency_master` WHERE `currency_id` = $currency_num"):'NA';
		$currency_typex = (is_array($currency_type) && isset($currency_type[0]['currency_master']['currency_code'])  )?$currency_type[0]['currency_master']['currency_code']:'NA';
		
		if($second_amt-$first_amt < $sum5){
			$outstandint_amt = $sum5 - $second_amt-$first_amt;
		} else {
			$outstandint_amt = 0;
		}
		
		$data[1] = isset($outstandint_amt)?$outstandint_amt:0;
		$data[2] = isset($sum5)?$sum5:0;
		$data[3] = isset($currency_typex)?$currency_typex:'NA';
		return $data;
	}
	
        public function create_zip_excel($group =0,$group_id=0)
        {
        	$this->autoRender = false;
        	$zip_file_name='';
        	$src = WWW_ROOT.'uploads/'.$group;

        	if(!is_dir($src)){
        		$this->Session->setFlash(__('Download folder does not exist'));
        	} else{
        		$source = $src;


        		$html='';
        		ob_start();
        		$view = new View($this, false);
        		$view->layout = null;
        		$view->viewPath = "Users";
        		$arr= $this->view_visa_app($group_id,0);
        		//print_r($arr); exit;
        		$view->set('data',$arr['data']);
        		$view->set('count',$arr['count']);
        		$view->set('adult',$arr['adult']);
        		$view->set('child',$arr['child']);
        		$view->set('infant',$arr['infant']);
        		$view->set('currency',$arr['currency']);
        		
        		$html .= $view->render("export_xls");
        		ob_end_clean();
        		//print_r($html); exit;
        		file_put_contents($src."/".$group.".xls", $html);

        		//code for zip
        		$zip_file_name = WWW_ROOT.'zip/'.$group.'.zip';

        		$zip = new ZipArchive;

        		$res = $zip->open($zip_file_name, ZipArchive::CREATE);

        		if($res === TRUE  ) {
        			$source = str_replace('\\', '/', $source);

        			if (is_dir($source) === true)
        			{

        				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        				foreach ($files as $file)
        				{
        					$file = str_replace('\\', '/', $file);

        					// purposely ignore files that are irrelevant
        					if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
        					continue;

        					// $file = realpath($file);

        					if (is_dir($file) === true)
        					{
        						$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
        					}
        					else if (is_file($file) === true)
        					{
        						$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
        					}
        				}
        			}
        			else if (is_file($source) === true)
        			{
        				$zip->addFromString(basename($source), file_get_contents($source));
        			}
        		}

        	}


        	$res_new['zip_path'] = $zip_file_name;
        	$res_new['excel']=$html;
        	return $res_new;
        }


        public function sendCronMail($data,$from_email,$email_id,$username) {
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = emailFromName;
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($email_id);
        	//$email->to('sunita@rethinkingweb.com');
        	$email->sendAs = 'html';

        	$email->subject('Applications Forward to OK to Board');
        	$i =1;
        	if(count($data) > 0){
        		foreach($data as $k=>$v){
        			$emailBody .= $i.". ".$k . " ( " . $v . " ) <br/>";
        			$i++;
        		}
        	}

        	$link = Router::url(array('plugin'=>'usermgmt','controller'=>'users', 'action'=>'oktb'));

        	$body="Hello ".$username.",<br/><br/>
 
Application (Date of Travel) listed below needs to be proceeded for OK To Board.<br/><br/>

".$emailBody."


<br/>To apply for OK To Board.<br/>
<a href = 'http://www.global-voyages.in".$link."'>Click Here.</a><br/>
<br/>


Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
        	
        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
        }


        function app_cron() {
$data2 = array();
        	//$this->sendMail();
        	$data = $this->User->query("SELECT user_id,group_id,oktb_status FROM visa_app_group WHERE (DATE_FORMAT(tent_date,'%Y-%m-%d') like CURDATE() OR DATE_FORMAT(tent_date,'%Y-%m-%d') like DATE_ADD(CURDATE(), INTERVAL 3 DAY)) and upload_status = 1 and status = 1 and tr_status > 1 ");
        	$data2 =Set::combine($data,'{n}.visa_app_group.user_id','{n}.visa_app_group.user_id');
        	if(count($data2) > 0){
        	foreach($data2 as $d){ 
        		$data3 = array(); $data4 = array(); $data5 = array();
        	$data3 = $this->User->query("SELECT user_id,tent_date,group_no,group_id FROM visa_app_group WHERE user_id = ".$d." and (DATE_FORMAT(tent_date,'%Y-%m-%d') like CURDATE() OR DATE_FORMAT(tent_date,'%Y-%m-%d') like DATE_ADD(CURDATE(), INTERVAL 3 DAY)) and upload_status = 1 and status = 1 and tr_status > 1");

        	if(count($data3) > 0){
        		$data4 =Set::combine($data3,'{n}.visa_app_group.group_no','{n}.visa_app_group.tent_date');
        		$data10 =Set::combine($data3,'{n}.visa_app_group.group_no',array('{0} ( {1} ) ','{n}.visa_app_group.group_no','{n}.visa_app_group.tent_date'));
        		$data5 = $this->User->query('Select email,username from users Where id = '.$d);
        		$username = $data5[0]['users']['username'];
        		$email = $data5[0]['users']['email'];
        		$frmemail =$this->visa_From_email();
        		$this->sendCronMail($data4,$frmemail,$email,$username);
        		$cr_data = implode(',',$data10);
        		$this->User->query('Insert into cron_data(cr_date,cr_data,to_email) values("'.date('d-M-Y H:i:s').'","'.$cr_data.'","'.$email.'")');
        	}else{
        		$this->User->query('Insert into cron_data(cr_date,cr_data,to_email) values("'.date('d-M-Y H:i:s').'","","")');
        	}
        	}
        	echo 11;
        	}else
        	echo 00;
        	
        	$this->autoRender = false;
        	//$this->render('dashboard');

        }

        public function header($group_no){
        	header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
        	header ("Last-Modified: " . gmdate("D,d M Y H:i:s") . " GMT");
        	header ("Cache-Control:  max-age=0, must-revalidate");
        	header ("Pragma: no-cache");
        	header ("Content-type: application/vnd.ms-excel");
        	header ('Content-Disposition: attachment;filename="Visa-App : '.$group_no.'.xls"');
        	header ("Content-Description: Generated Report" );
        }

        public function all_visa_app2($app=null,$status = null)
        {
        	$userId=$this->UserAuth->getUserId(); $total= 0;
        	
        	$atr_status = $this->get_admin_tr_status_dropdown();
	        $this->set('atr_status', $atr_status);
        	$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	$this->set('tr_status', $tr_status);
        	$app = 'all';
        	$data = $this->get_visa_data($app,$status);
        	$this->set('application','all');
        	$this->autoRender = false;
        	$this->render('all_visa_app');
        }

        public function agent_airline_cost(){
        	$this->User->useTable = 'users';
        	$users = $this->User->query('select * from users where status = 1 and approve = 1 and user_group_id = 2 order by id desc');
        	if(count($users) > 0)
        	{
        		$this->set('users',$users);
        		$bus_name='';$visa_cost='';$cr_date='';
        		if(count($users) > 0){
        			foreach($users as $user)
        			{
        				$cr_date[$user['users']['id']] = $user['users']['created'];
        				$this->Relation->useTable = 'user_meta';
        				$data =$this->Relation->query('select * from user_meta where user_id = '.$user['users']['id'].' and meta_key = "bus_name"');
        				foreach($data as $d)
        				{
        					$bus_name[$user['users']['id']] = $d['user_meta']['meta_value'];
        				}

        				$data =$this->Relation->query('select * from agent_airline_cost where user_id = '.$user['users']['id']);
        				if(count($data)>0)
        				{
        					$cr_date[$user['users']['id']] = $data[0]['agent_airline_cost']['a_date'];
        				}
        			}
        		}
        		$this->set('cr_date',$cr_date);
        		$this->set('bus_name',$bus_name);
        		$this->autoRender = false;
        		$this->render('agent_airline_cost');
        	}
        }

        public function viewAirlineCost() {
        	$userId = $_POST['id'];
        	
        	$airline = ""; $value = "";
        	$this->User->useTable = "";
        	$this->User->useTable = 'oktb_airline';
        	$ans = $this->User->query('Select * From oktb_airline Where status = 1 || status = 2');
        	//print_r($ans); exit;
        	foreach($ans as $a){
        		$scost[$a['oktb_airline']['a_id']] = 0;
        		$cost[$a['oktb_airline']['a_id']] = 0;
        		$airline[$a['oktb_airline']['a_id']] = $a['oktb_airline']['a_name'];
        		$data = $this->User->query('Select * From agent_airline_cost Where user_id = '.$userId.' and air_id = '.$a['oktb_airline']['a_id']);
        		if(count($data) > 0){
        			$cost[$a['oktb_airline']['a_id']] = $data[0]['agent_airline_cost']['air_price'];
        			$scost[$a['oktb_airline']['a_id']] = ($data[0]['agent_airline_cost']['air_sprice'] == Null ) ?  $a['oktb_airline']['a_sprice'] : $data[0]['agent_airline_cost']['air_sprice'];
        		}else{
        		$cost[$a['oktb_airline']['a_id']] = $a['oktb_airline']['a_price'];
        		$scost[$a['oktb_airline']['a_id']] = $a['oktb_airline']['a_sprice'];
        		}
        	}
			$currency = $this->currency_val($userId);
        	$this->set('currency',$currency);
        	$this->set('airline',$airline);
        	$this->set('cost',$cost);
        	$this->set('scost',$scost);
        }

        public function change_airline_cost($user_id,$app='no_val')
        {
        	$airline=$this->get_airline_dropdown($user_id);
        	$this->set('airline', $airline);

        	/*$admin_visa_cost = 50;
        	 $ans = $this->User->query('select * from visa_type_master ');
        	 if(count($ans) > 0)
        	 $ans[0]['visa_type_master']['visa_type'] = $ans[0]['visa_type_master']['visa_cost'];*/

        	$this->User->useTable = 'users';
        	$this->Relation->useTable = 'user_meta';
        	$data =$this->Relation->query('select * from user_meta where user_id = '.$user_id.' and meta_key = "bus_name"');
        	foreach($data as $d)
        	{
        		$this->set('username',$d['user_meta']['meta_value']);
        	}

        	/*if($app == 'no_val')
        	 {
        	 $data =$this->Relation->query('select * from visa_cost where user_id = '.$user_id);
        	 if(count($data)>0)
        	 {
        	 $this->set('visa_cost', $data[0]['visa_cost']['visa_cost']);
        	 }else
        	 $this->set('visa_cost', $admin_visa_cost);
        	 }else
        	 $this->set('visa_cost', $app);*/
        	$this->set('user_id', $user_id);
        	$this->render('change_airline_cost');
        }


        function get_airline_dropdown($id=null){
			$result=$this->User->query("Select * From oktb_airline Where status = 1 or status = 2");
        	$data =array();

        	$data['select']='Select';

        	foreach ($result as $row)
        	{
        		if($id == null){
        			$data[$row['oktb_airline']['a_id']]=$row['oktb_airline']['a_name'] . ' - ' .$row['oktb_airline']['a_price'] . ' (INR)';

        		}else{
 				$currency = $this->currency_val($id); 
 				if(strlen($currency) == 0) $currency = 'INR';
        			$data1 = $this->User->query('Select * From agent_airline_cost Where user_id = '.$id.' and air_id = '.$row['oktb_airline']['a_id']);
        			if(count($data1) > 0){
        				if($data1[0]['agent_airline_cost']['air_sprice'] != null && strlen($data1[0]['agent_airline_cost']['air_sprice']) > 0) $amt = $data1[0]['agent_airline_cost']['air_sprice']; else $amt = $row['oktb_airline']['a_sprice']; 
        				$data[$row['oktb_airline']['a_id']] = $row['oktb_airline']['a_name'] .' - '. $amt . ' ('. $currency.')';
        			}else
        			$data[$row['oktb_airline']['a_id']]=$row['oktb_airline']['a_name'] . ' - ' .$row['oktb_airline']['a_sprice'] . ' ('. $currency.')';
        		}
        	}

        	return $data;
        }

        public function save_airline_cost()
        {
        	if ($this->request ->isPost()) {
        		$this->User->set($this->data);
        		if ($this->User->AirlineCostValidate())
        		{
        			$user_id = $this->request->data['User']['user_id'];
        			$this->User->useTable = 'agent_airline_cost';
        			$ans = $this->User->find('all',array('conditions'=>array('user_id'=>$this->request->data['User']['user_id'],'air_id'=>$this->request->data['User']['a_name'])));
        			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Change Airline Cost" and user_id = '.$this->request->data['User']['user_id'].' and other_id = '.$this->request->data['User']['a_name']);
	        			if(count($ans) > 0) $this->User->query('Insert into user_action(role_id,type,user_id,other_id,prev_value,updated_value,date,status) values("'.$roleId.'","Change Airline Cost",'.$this->request->data['User']['user_id'].','.$this->request->data['User']['a_name'].',"'.$ans[0]['User']['air_price'].'","'.$this->request->data['User']['airline_charge'].'","'.date('Y-m-d H:i:s').'",1) ');
	        			else $this->User->query('Insert into user_action(role_id,type,user_id,other_id,prev_value,updated_value,date,status) values("'.$roleId.'","Change Airline Cost",'.$this->request->data['User']['user_id'].','.$this->request->data['User']['a_name'].',0,"'.$this->request->data['User']['airline_charge'].'","'.date('Y-m-d H:i:s').'",1) ');
        			}
        		
        			if(count($ans) > 0)
        			{
        				$date_cr =date('d-m-Y');
        				$this->User->query('update agent_airline_cost set air_price = "'.$this->request->data['User']['cost_price'].'",air_sprice = "'.$this->request->data['User']['sell_price'].'", a_date="'.date('Y-m-d H:i:s').'" where user_id = '.$this->request->data['User']['user_id'].' and air_id = '.$this->request->data['User']['a_name']);
        			}
        			else
        			$this->User->query('INSERT INTO agent_airline_cost(air_id,user_id,air_price,air_sprice,a_date) VALUES ("'.$this->request->data['User']['a_name'].'","'.$this->request->data['User']['user_id'].'","'.$this->request->data['User']['cost_price'].'","'.$this->request->data['User']['sell_price'].'","'.date('Y-m-d H:i:s').'")');

$this->autoRender = false;
$this->agent_airline_cost();
$this->Session->setFlash(__('Airline Cost Updated!!'));
$this->change_airline_cost($this->request->data['User']['user_id'],$this->request->data['User']['cost_price'],$this->request->data['User']['sell_price']);

}else
{
$this->autoRender =false;
$this->change_airline_cost($this->request->data['User']['user_id'],$this->request->data['User']['cost_price'],$this->request->data['User']['sell_price']);
}
}else
{
$this->autoRender =false;
$this->agent_airline_cost();
}
}
	
public function quick_app(){
if($this->Session->read('form_submitted') == true)
        		$this->Session->delete('form_submitted');
$uid = null; $user = array();
			if($this->UserAuth->getGroupName() != 'User'){
        	$data = $this->User->query('Select id,username From users Where status = 1 and id != 1 and user_group_id = 2');
			$user = Set::combine($data,'{n}.users.id','{n}.users.username');
			$user = array('select'=>'Select') + $user;
			$this->set('agent', $user);
        	}else{
        		  	$uid = $this->UserAuth->getUserId();
        		  	$visa_type=$this->get_visa_dropdown($uid);
        			$this->set('visa_type', $visa_type);
        	}			
}

 public function save_quick_app()
        {
        	$this->autoRender = false;
  
        	if ($this->request->isPost()) {
        		$this->User->set($this->data);
        		$this->set('data', $this->data);

        		$visaNo = array(); $visa_array = array();
				$visaNo = $this->User->query('Select group_id,group_no From visa_app_group Where 1');
				$visa_array = Set::combine($visaNo,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_no');
					
        		$random =rand(111111,999999);
        		$visa_no1 = 'GVG-'.$random;
        		$visa_no = $this->get_visa_no($visa_no1,$visa_array,'group');
        		
        		$this->request->data['User']['group_no'] = $visa_no;
        		$this->request->data['User']['app_date'] = date('d-m-Y H:i:s');
        		 if($this->UserAuth->getGroupName() != 'User'){ 
        		$this->request->data['User']['user_id'] =  $this->request->data['User']['agent'];
        		 }else $this->request->data['User']['user_id'] =  $this->UserAuth->getUserId();
        		$this->request->data['User']['tent_date'] = $this->request->data['User']['tent_yy'].'-'.$this->request->data['User']['tent_mm'].'-'.$this->request->data['User']['tent_dd'];
        		
        			$this->User->query('Insert into visa_app_group(group_no,user_id,visa_type,tent_date,adult,children,infants,app_type,app_date,status) values("'.$this->request->data['User']['group_no'].'","'.$this->request->data['User']['user_id'].'","'.$this->request->data['User']['visa_type'].'","'.$this->request->data['User']['tent_date'].'","'.$this->request->data['User']['adult'].'","'.$this->request->data['User']['children'].'","'.$this->request->data['User']['infants'].'","quick_app","'.$this->request->data['User']['app_date'].'",0)');
        			$visa_grp_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        			$groupId = $visa_grp_Id[0][0]['id'];
        			
        			 if($this->UserAuth->getGroupName() != 'User'){ 
        			 $this->User->query('Update visa_app_group set role_id = '.$this->UserAuth->getUserId().' Where group_id = '.$groupId);	
        			 }
        			//$this->visa_app(1);
        			$this->set('groupId', $groupId);
        			$empType1 = array(''=>'Select'); 
        			$empData = $this->User->query('Select * from emp_type_master Where status=1');
        			$empType2 = Set::combine($empData, '{n}.emp_type_master.emp_type_id', '{n}.emp_type_master.emp_type');	
        			$empType3  = array('other'=>'Other');
        			$empType = $empType1 + $empType2 + $empType3;
        			$this->set('empType', $empType);
        			
        			$this->render('quick_visa_app');
        	}
        }
        
      public function quick_visa_app()
        {
        	$app=array();
        	//print_r($_POST);
        	//print_r($_FILES); exit;
        	if ($this->request -> isPost()) {

if($this->Session->read('form_submitted') != 1)
        		{
        			//echo $this->Session->read('form_submitted'); exit;
        		$this->Session->write('form_submitted', 1);

        		$set = 1;
        		$this->User->set($this->data);

        		$visaNo = array(); $visa_array = array();
        		$visaNo = $this->User->query('Select app_id,app_no From visa_tbl');
        		$visa_array = Set::combine($visaNo,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
        		
        		
        		$group_data = $this->User->query('Select * from visa_app_group Where group_id='.$this->request->data['groupId']);
        		$group_no = $group_data[0]['visa_app_group']['group_no'];
        		$visa_type = $group_data[0]['visa_app_group']['visa_type'];
        		$appUser = $group_data[0]['visa_app_group']['user_id'];
        		
        		$ak = 1; $bk = 1; $ck = 1;
        		$a = $this->request->data['adult']; $b = $this->request->data['adult']+$this->request->data['children'];
        		for($i=1;$i<=$this->request->data['hid_count1'];$i++){
        			if($a != 0 && $i <= $a){  $id = '-A'.$ak;$ak++; }
        			else if($b != 0 && $i <= $b){ $id = '-C'.$bk; $bk++;}
        			else{ $id = '-I'.$ck; $ck++;}
        			$id_data[] = $id;
        	
        				$this->User->query('Update visa_app_group set status = 1 Where group_id ='.$this->request->data['groupId']);

        				$this->User->useTable = 'visa_tbl';
        				$this->User->create();
        				$random =rand(111111,999999);
        				$visa_no1 = 'GV-'.$random;
        				//$visa_no1 = 'GV-672012';
        				$visa_no = $this->get_visa_no($visa_no1,$visa_array);
        				//	exit;
        				$this->request->data['User']['app_no'] = $visa_no;
        				$this->request->data['User']['create_date'] = date('d-m-Y');
        				$this->request->data['User']['user_id'] = $appUser;
        				$this->request->data['User']['group_id'] = $this->request->data['groupId'];
        				$this->request->data['User']['passport_no'] = $this->request->data['User']['passport_no'.$id];
        				$this->request->data['User']['first_name'] = $this->request->data['User']['given_name'.$id];
        				$this->request->data['User']['last_name'] = $this->request->data['User']['surname'.$id];
        				$this->User->save($this->request->data,true);
        				$userId=$this->User->getLastInsertID();

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no))
        			mkdir(WWW_ROOT.'uploads/'.$group_no, 0777, true);

        			if(!file_exists(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no']))
        			mkdir(WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'], 0777, true);
        				
        			if(isset($this->request->data['User']['pfp'.$id]['name']) && strlen($this->request->data['User']['pfp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['pfp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$pfp_name = 'pfp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['pfp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'].'/'.$pfp_name);
        				$this->request->data['User']['pfp'.$id]= $pfp_name;
        			}else
        			$this->request->data['User']['pfp'.$id]='';

        			if(isset($this->request->data['User']['plp'.$id]['name']) && strlen($this->request->data['User']['plp'.$id]['name']) > 0)
        			{
        				$addr_ext = explode('.',$this->request->data['User']['plp'.$id]['name']);
        				$extension = $addr_ext[1];
        				$plp_name = 'plp_'.$addr_ext[0].$random.'.'.$addr_ext[1];
        				move_uploaded_file($this->request->data['User']['plp'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'].'/'.$plp_name);
        				$this->request->data['User']['plp'.$id]= $plp_name;
        			}else
        			$this->request->data['User']['plp'.$id]='';
        			
        			if(isset($this->request->data['User']['photograph'.$id]['name']) && strlen($this->request->data['User']['photograph'.$id]['name']) > 0)
        			{
        				$photo_ext = explode('.',$this->request->data['User']['photograph'.$id]['name']);
        				$extension = $photo_ext[1];
        				$photo_name = 'photograph_'.$photo_ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['photograph'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'].'/'.$photo_name);
        				$this->request->data['User']['photograph'.$id]= $photo_name;
        			}else
        			$this->request->data['User']['photograph'.$id]='';

        			if(isset($this->request->data['User']['ticket'.$id]['name']) && strlen($this->request->data['User']['ticket'.$id]['name']) > 0)
        			{
        				$ext = explode('.',$this->request->data['User']['ticket'.$id]['name']);
        				$extension = $ext[1];
        				$ticket1_name = 'ticket1_'.$ext[0].$random.'.'.$extension;
        				move_uploaded_file($this->request->data['User']['ticket'.$id]['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$this->request->data['User']['app_no'].'/'.$ticket1_name);
        				$this->request->data['User']['ticket'.$id]= $ticket1_name;
        			}else
        			$this->request->data['User']['ticket'.$id]='';
        			
        				$detail =  array('given_name'.$id,'surname'.$id,'spouse_name'.$id,'father_name'.$id,'mother_name'.$id,'gender'.$id,'marital_status'.$id,'language'.$id,'pre_nationality'.$id,'dob_dd'.$id,'dob_mm'.$id,'dob_yy'.$id,'birth_place'.$id,'religion'.$id,'education'.$id,'passport_type'.$id,'passport_no'.$id,'issue_country'.$id,'doi_dd'.$id,'doi_mm'.$id,'doi_yy'.$id,'issue_place'.$id,'doe_dd'.$id,'doe_mm'.$id,'doe_yy'.$id,'pfp'.$id,'plp'.$id,'pop'.$id,'addr'.$id,'photograph'.$id,'ticket1'.$id,'ticket2'.$id,'ticket3'.$id,'emp_type'.$id,'emp_other'.$id);
        				$visa_data = array('pop'.$id,'addr'.$id,'ticket2'.$id,'ticket3'.$id);
        				foreach($visa_data as $v) $this->request->data['User'][$v] = '';
        				//$group_data = array('add_doc1','add_doc2','add_doc3','add_doc4');
        				//foreach($group_data as $gd) 
        				$lower = ''; $upper = ''; $title = ''; $empType  = array();
        				
        				if($this->request->data['User']['emp_type'.$id] == 'other'){
        					$lower = strtolower($this->request->data['User']['emp_other'.$id]);
        					$upper = strtoupper($this->request->data['User']['emp_other'.$id]);
        					$title = ucwords($this->request->data['User']['emp_other'.$id]);
        					
        					$empType = $this->User->query('Select emp_type From emp_type_master Where status = 1 and (emp_type like "%'.$this->request->data['User']['emp_other'.$id].'%" || emp_type like "%'.$lower.'%" || emp_type like "%'.$upper.'%" || emp_type like "%'.$title.'%" )');
	        				if(strlen($this->request->data['User']['emp_other'.$id]) > 0 && count($empType) == 0){
	        					$this->User->query('Insert into emp_type_master (emp_type,create_date,update_date,status) values("'.$this->request->data['User']['emp_other'.$id].'","'.date('Y-m-d').'","'.date('Y-m-d').'",1)');
	        				}
        				}
        		
        				if($i == 1){
        					
        		$this->request->data['User']['add_doc4'] = '';
        		if(isset($this->request->data['User']['add_doc1']['name']) && strlen($this->request->data['User']['add_doc1']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc1']['name']);
        			$extension = $ext[1];
        			$add_doc1_name = 'doc1_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc1']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$add_doc1_name);
        			$this->request->data['User']['add_doc1']= $add_doc1_name;
        		}else
        		$this->request->data['User']['add_doc1']='';

        		if(isset($this->request->data['User']['add_doc2']['name']) && strlen($this->request->data['User']['add_doc2']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc2']['name']);
        			$extension = $ext[1];
        			$doc2_name = 'doc2_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc2']['tmp_name'],WWW_ROOT.'uploads/'.$group_no.'/'.$doc2_name);
        			$this->request->data['User']['add_doc2']= $doc2_name;
        		}else
        		$this->request->data['User']['add_doc2']='';
        			
        		if(isset($this->request->data['User']['add_doc3']['name']) && strlen($this->request->data['User']['add_doc3']['name']) > 0)
        		{
        			$ext = explode('.',$this->request->data['User']['add_doc3']['name']);
        			$extension = $ext[1];
        			$doc3_name = 'doc3_'.$ext[0].$random.'.'.$extension;
        			move_uploaded_file($this->request->data['User']['add_doc3']['tmp_name'], WWW_ROOT.'uploads/'.$group_no.'/'.$doc3_name);
        			$this->request->data['User']['add_doc3']= $doc3_name;
        		}else
        		$this->request->data['User']['add_doc3']='';
        		
        					$grp_data = array('email_id','address1','address2','city','country','pin','std_code','phone','emp_type','occupation','company_name','company_address','company_contact','designation','last_doe_dd','last_doe_mm','last_doe_yy','arr_airline','arrival_flight','arr_date_dd','arr_date_mm','arr_date_yy','arrival_time','arr_pnr_no','dep_airline','departure_flight','dep_date_dd','dep_date_mm','dep_date_yy','departure_time','dep_pnr_no','add_doc1','add_doc2','add_doc3','add_doc4','remarks','applicant');
        					foreach($grp_data as $key => $value)
        					{
        						//if(in_array($key,$grp_data)){
        							if(!isset($this->request->data['User'][$value]))
        							$this->request->data['User'][$value] = NULL;
        							$this->User->query('Insert into group_meta(group_id,meta_key,meta_value) values('.$this->request->data['User']['group_id'].',"'.$value.'","'.$this->request->data['User'][$value].'")');
        						//}
        					}
        				}
        				foreach($detail as $key => $value)
        				{
        						if(!isset($this->request->data['User'][$value]))
        							$this->request->data['User'][$value] = NULL;
        						$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$value.'","'.$this->request->data['User'][$value].'")');
        				}
        				$app_data = 'app_no'.$id;
        				$this->User->query('Insert into visa_meta(app_id,visa_meta_key,visa_meta_value) values('.$userId.',"'.$app_data.'","'.$this->request->data['User']['app_no'].'")');
        			
        				
        		if(strlen($this->request->data['User']['pfp'.$id]) > 0 && strlen($this->request->data['User']['plp'.$id]) > 0 && strlen($this->request->data['User']['photograph'.$id]) > 0){
        				$set = $set + 1;
        			}
        		}
        		if($set == $i){
        			$this->User->query('Update visa_app_group set tr_status = 1 , upload_status = 1 Where group_id = '.$this->request->data['groupId']);  
        		}
        		$this->Session->setFlash(__('Visa Application is Successfully Submitted'));
				$this->autoRender =false;
        		$this->apply_for_visa($this->request->data['groupId'],$visa_type,$appUser);
}else{
        			$this->Session->setFlash(__('Visa Application is Successfully Submitted'));
        			$this->redirect(array('controller' => 'users', 'action' => 'all_visa_app'));
				}
        	}else{
        		$this->autoRender = false;
        		$this->quick_app();
        	}
        }
        
public function sendExtensionCronMail($gdata,$from_email,$email_id,$username,$day_no) {
	$from = explode(',',$from_email);
		//print_r($from); exit;
		if(count($from) > 0 ){ foreach($from as $f_email){ if(strlen($f_email) > 0){ 
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $f_email;
        	$fromNameConfig = 'Extension Visa Application';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($email_id);
        	$email->subject('Extend The Visa');
        	$i =1;
        
$link = Router::url(array('plugin'=>'usermgmt','controller'=>'users', 'action'=>'all_extension'));

        	$body="Dear Sir/Madam,<br/><br/>                                                    

Please let us know within 48 hours whether your following Clients needs to extend their Visa.<br/><br/>";
        	
$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
		<th style = 'padding:3px;'>Group No.</th>
		<th style = 'padding:3px;'>Applicant Name</th>
		<th style = 'padding:3px;'>Passport No</th>
		<th style = 'padding:3px;'>Date of Exit</th>
		<th style = 'padding:3px;'>Last Date</th>
		<th style = 'padding:3px;'>Comments</th>";

foreach($gdata as $k=>$o){
	$body .= "<tr>
<td style = 'padding:3px;'>".$o['app_no']."</td>
<td style = 'padding:3px;'>". $o['first_name'].' '.$o['last_name']."</td>
<td style = 'padding:3px;'>".$o['passport_no']."</td>
<td style = 'padding:3px;'>".date('d-m-Y',strtotime($o['date_of_exit']))."</td>
<td style = 'padding:3px;'>".date('d-m-Y',strtotime($o['last_doe']))."</td>";
if($day_no[$k] == '36')
$body .= "<td style = 'padding:3px;background-color:#FAB0B0'>Today is his ".$day_no[$k]."<sup>th</sup> day in Dubai</td>";
else 	
$body .= "<td style = 'padding:3px;'>Today is his ".$day_no[$k]."<sup>th</sup> day in Dubai</td>";

$body .= "</tr>";
}
$body .= "</tbody></table><br/><br/>
To Apply online for Extensions.<br/>
<a href = 'http://www.global-voyages.in".$link."'>Click Here.</a><br/>
<br/>
Thank You<br/><br/>

Regards,<br/>
Global Reservations HelpDesk<br/>
Global Voyages | the. Travel. archer.";

        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send extension cron email ";
        		$this->log($result, LOG_DEBUG);
        	}
		} } }
        }
	
 public function extension_cron(){
		$this->autoRender = false;
		$data = $this->User->query('Select visa_tbl.user_id,visa_tbl.app_id,visa_tbl.extend_status From  visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where (visa_tbl.date_of_exit like  CURDATE() OR visa_tbl.date_of_exit like DATE_SUB(CURDATE(), INTERVAL 6 DAY)) and visa_app_group.upload_status = 1 and visa_app_group.status = 1 and visa_app_group.tr_status > 1 and visa_tbl.extend_status = 1 ');
		if(count($data) > 0){
			$data2 =Set::combine($data,'{n}.visa_tbl.user_id','{n}.visa_tbl.user_id');
			foreach($data2 as $d){ $data3 = array(); $visaData = array(); $grpData = array(); $nameData = array(); $passport = array(); $day_no = ''; $day1 = '';
			$data3 = $this->User->query('Select visa_tbl.first_name,visa_tbl.last_name,visa_tbl.passport_no,visa_tbl.user_id,visa_tbl.app_id,visa_tbl.extend_status,visa_tbl.app_no,visa_tbl.date_of_exit,visa_tbl.last_doe From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.user_id = '.$d.' and (visa_tbl.date_of_exit like  CURDATE() OR visa_tbl.date_of_exit like DATE_SUB(CURDATE(), INTERVAL 6 DAY)) and visa_app_group.upload_status = 1 and visa_app_group.status = 1 and visa_app_group.tr_status > 1 and visa_tbl.extend_status = 1');
        	if(count($data3) > 0){
        	//$visaData = $this->User->query('Select first_name,last_name,passport_no,group_id From visa_tbl Where app_id in ('.$groupId.')');
			//$this->User->query('Update visa_app_group set extend_status = 1 Where group_id in ('.$groupId.')');
			
        	//$nameData =Set::combine($data3,'{n}.visa_tbl.app_id',array('{0} {1}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name'));
        	//$passport = Set::combine($data3,'{n}.visa_tbl.app_id','{n}.visa_tbl.passport_no');
        	$grpData =Set::combine($data3,'{n}.visa_tbl.app_id','{n}.visa_tbl');
        	$grpNo =Set::combine($data3,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
        	//echo '<pre>'; print_r($grpData); exit;
        	if(count($grpData) > 0){
        		foreach($grpData as $k=>$g){
        			$day1 = $g['date_of_exit'];
        			$curr = date('Y-m-d'); 
        			if($day1 == $curr) $day_no[$k] = '30'; else $day_no[$k] = '36'; 
        		}
        	}
        	$data5 = $this->User->query('Select email,username from users Where id = '.$d);
        	$username = $data5[0]['users']['username'];
        	$email = $data5[0]['users']['email'];
        	$frmemail =$this->extension_From_email();
        	$this->sendExtensionCronMail($grpData,$frmemail,$email,$username,$day_no);
        	 $cr_data = implode(',',$grpNo);  
        	echo 'email Send';
        	
        	$this->User->query('Insert into cron_data(cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","'.$cr_data.'","'.$email.'","extension")');
        
        	}else{
        		echo 'email NOT Send';
        		$this->User->query('Insert into cron_data(cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","","","extension")');
        	}
        }
        	echo 11;
		}else echo 00;
	}
	
public function extension_From_email() {
		//echo $visa_type;
		$email_val = ''; $email = array(); $ad_email = array(); $all_email = array();
		
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'user_roles';
			$data = $this->Relation->query("Select role_email,role_id From user_roles Where extension = 1 and role_status = 1 ");
			$email = Set::combine($data,'{n}.user_roles.role_id','{n}.user_roles.role_email');
		
			$ad_email = $this->visa_From_email();
			$all_email = array_merge($email,array(count($email)=>$ad_email));
			$all_email = array_unique($all_email);
			$email_val = implode(',',$all_email);
			if(strlen($email_val) > 0)
			return $email_val;
	}
	
	public function get_visa_no($visa_no,$no_array,$type=null){
		$this->autoRender = false;
        	while(in_array($visa_no,$no_array)){
        		$random =rand(111111,999999);
				if ($type == 'group')
				$visa_no1 = 'GVG-'.$random;
				else
				$visa_no1 = 'GV-'.$random;
				
				$visa_no = $this->get_visa_no($visa_no1,$no_array,$type);
        	}
       			 return $visa_no;
	}
	
	
public function threshold(){
	$this->autoRender = false;
		$agent['select'] = 'Select';
			$data = $this->User->query('Select * From users Where status = 1 and id <> 1 and user_group_id = 2');
			if(count($data) > 0){
				foreach($data as $d){
					$eData = array();
					$agent[$d['users']['id']] = $d['users']['username'];
					$currency = $this->get_master_data('currency_master',$d['users']['currency'],'currency_id','currency_code');
					if(count($currency) == 0) $currency = 'INR';  
					$eData = $this->User->query('Select total_th,avail_th From threshold Where user_id = '.$d['users']['id'].' and status = 1');
					if(count($eData) == 0 || !isset($eData[0]['threshold']['total_th']) || $eData[0]['threshold']['total_th'] == null) $price = 0; else $price = $eData[0]['threshold']['total_th'];
					$agent[$d['users']['id']] .= ' - '.$price.' '.$currency;
				}
			}	
		$this->set('agent',$agent);
		$this->render('set_threshold');	
	}
	
	public function set_threshold(){
		$this->autoRender = false;
		if ($this->request -> isPost()) {
			$agent = $this->request->data['User']['agent'];			
			$threshold = $this->request->data['User']['threshold_cost'];	
			$data = array(); $prev_amt = 0; $wallet = array(); $w_update = 0; $w_update2 = 0; $currency  = 'INR';
			$opening_bal = 0;
			$closing_bal = 0;
			$prev_amt = 0;
			$data = $this->User->query('Select * From threshold Where user_id = '.$agent.' and status = 1');
			if(count($data) > 0)
			 $prev_amt = $data[0]['threshold']['total_th']; 
			
			$user = $this->User->query('Select * From users Where id ='.$agent);
			$currency = $this->currency_val($agent);
			$name = $user[0]['users']['username'];
			$to_email = $user[0]['users']['email'];
			$wallet = $this->User->query('Select * From user_wallet Where user_id = '.$agent);
			$avail_th = $threshold - $prev_amt;
			
			if(count($wallet) > 0 ){ 
				 $w_update = $threshold - $prev_amt; 
				 $opening_bal = $wallet[0]['user_wallet']['amount'];
				 $this->User->sendThresholdMail($name,$to_email,$this->From_email(),$threshold,$currency,0);
				  $w_update2 = $w_update + $opening_bal ; 
			}else{
				$this->User->query('Insert into user_wallet(user_id,amount) values ("'.$agent.'","'.$threshold.'")');
				$this->User->sendThresholdMail($name,$to_email,$this->From_email(),$threshold,$currency,1);
				$w_update2 = $threshold ; 
			}
			
			$this->User->query('Update user_wallet set amount = '.$w_update2.' Where user_id = '.$agent);
			
			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->Relation->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Set Credit Limit" and user_id = "'.$agent.'"');
        			$this->Relation->query('Insert into user_action (role_id,type,user_id,prev_value,updated_value,date,status) values("'.$roleId.'","Set Credit Limit","'.$agent.'","'.$prev_amt.'","'.$threshold.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
			// echo $w_update2; exit;
			$this->User->query('Update threshold set status = 0 Where user_id = '.$agent);
			$this->User->query('Insert into threshold (total_th,avail_th,opening_bal,closing_bal,date,user_id) values ("'.$threshold.'","'.$avail_th.'","'.$opening_bal.'","'.$w_update2.'","'.date('Y-m-d H:i:s').'","'.$agent.'")');
			
			
			$this->Session->setFlash(__('Credit Amount Saved Successfully'));
		}
		$this->redirect('threshold');
	}
	
	public function get_data_from_visa_tbl($groupId){
		$name = array(); $nameData = '';
		$appdata = $this->User->query('Select app_no,passport_no,first_name,last_name,app_id From visa_tbl Where group_id = '.$groupId);
		$appId = Set::combine($appdata,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
		$name = Set::combine($appdata,'{n}.visa_tbl.app_id',array('{0} {1} / {2}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name','{n}.visa_tbl.passport_no'));
		//print_r($name); exit;
		$nameData = implode(',<br/>',$name);
		return $nameData;
	}
	
	public function get_data_from_oktb_tbl($groupNo){
		$name = array(); $nameData = '';
		$appdata = $this->User->query('Select oktb_name,oktb_passportno,oktb_id From oktb_details Where oktb_group_no = "'.$groupNo.'"');
		//$appId = Set::combine($appdata,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
		$name = Set::combine($appdata,'{n}.oktb_details.oktb_id',array('{0} / {1} ','{n}.oktb_details.oktb_name','{n}.oktb_details.oktb_passportno'));
		$nameData = implode(',<br/>',$name);
		return $nameData;
	}
	
	public function last_day(){
		$this->autoRender = false; $extId = array(); $extid = '';
		$current_date  = date('Y-m-d'); $extension = array();
		$data = $this->User->query('Select * From extension Where ext_last_date like CURDATE()');
		$extId = Set::combine($data,'{n}.extension.ext_id','{n}.extension.ext_id');
		$extid = implode(',',$extId);
		if(count($data) > 0){
			$gdata = Set::combine($data,'{n}.extension.ext_user_id','{n}.extension.ext_id');
			foreach($gdata as $k=>$g){ 
				$user = array(); $extension =array(); $name = array(); $last_date = array(); $group_no = array(); $grp_no_data = ''; $email = '';
				$user = $this->User->query('Select username,email From users Where id = '.$k);
				$email = $user[0]['users']['email'];
				$extension = $this->User->query('Select * From extension Where ext_id in ('.$extid.') and ext_user_id = '.$k);
				$name = Set::combine($extension,'{n}.extension.ext_id','{n}.extension.ext_name');
				$group_no = Set::combine($extension,'{n}.extension.ext_id','{n}.extension.ext_no');
				$grp_no_data = implode(',',$group_no);
				$last_date = Set::combine($extension,'{n}.extension.ext_id','{n}.extension.ext_last_date');
				$this->sendLastDayMail($user,$name,$last_date,$this->From_email());
				
				$this->User->query('Insert into cron_data (cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","'.$grp_no_data.'","'.$email.'","last_day")');
			}
			echo 11;
		}else echo 00;
	} 
	
	public function sendLastDayMail($user,$name,$last_date,$from_email){
		
			$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = emailFromName;
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($user[0]['users']['email']);
        	$email->sendAs = 'html';
//print_r($name); exit;
        	$email->subject('Last Day in Dubai');
      
        	$body="Dear Sir,<br/><br/>
        	This mail is to notify that today is the last day for your following client(s) in Dubai.
<br/><br/>
Please talk to your client and tell them to exit Dubai by today evening.<br/><br/>
Passenger Name ( Last Date )<br/>";
        	
foreach($name as $k=>$n){
	$body .=  $n .' ( '.$last_date[$k].' )<br/>';
}
$body .= "<br/>Please revert as soon as possible or else heavy penalty will be levied on you.<br/><br/>
		Regards,<br/>
		Online  Administrator<br/>
		Global Voyages | the. Travel. archer.";
  	//echo $body; exit;
        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
	}
	
 public function approve_admin_visa() {
        	$groupId = $_POST['id'];
        	$status = $_POST['astatus'];
        	$prev = $_POST['prev_status'];
        	//$userid = $_POST['userid'];
			$this->autoRender = false;
        	if (!empty($groupId) && $status != 'select') { $tr_data = array();
        		$this->User->query('Update visa_app_group set admin_tr_status = '.$status.' Where group_id ='.$groupId);
        		$tr_data = $this->User->query('Select * From admin_tr_status Where atr_status_id ='.$status);
        		
        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){ 
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Visa" and action_type = "Change Admin Status" and app_no = "'.$groupId.'"');
        			$this->User->query('Insert into user_action(role_id,type,action_type,app_no,prev_value,updated_value,date,status) values("'.$roleId.'","Visa","Change Admin Status","'.$groupId.'","'.$prev.'","'.$status.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
        		if(count($tr_data) > 0){
        		$result =$tr_data[0]['admin_tr_status']['atr_status'];
        		 echo $result;
        		}else echo 'Error';
        	}else echo 'Error';
        }
        
        public function low_bal_cron(){
        	$this->autoRender = false;
        	$data = $this->User->query('Select user_wallet.user_id,user_wallet.amount,users.username,users.email From users join user_wallet on users.id = user_wallet.user_id Where users.status = 1');
        	if(count($data) > 0){
        		foreach($data as $d){ $tdata = array(); $low_bal = array();
        		//echo $d['user_wallet']['user_id'];
        		$low_bal = $this->User->query('Select * From agent_settings Where a_key = "lowest_bal" and agent_id = '.$d['user_wallet']['user_id']);
        		if(count($low_bal) > 0) $default = $low_bal[0]['agent_settings']['a_value']; else $default = 5000;	
        		//echo $default; exit; 
        			if($d['user_wallet']['amount'] <= $default){
        				$currency = $this->currency_val($d['user_wallet']['user_id']);
        				$tdata = $this->User->query('Select total_th From threshold Where user_id = '.$d['user_wallet']['user_id'].' and status = 1');
        				if(count($tdata) > 0) $threshold_val = $tdata[0]['threshold']['total_th']; else $threshold_val = 0;
        				//echo $this->From_email(); exit;
        				$this->sendLowBalMail($d['user_wallet']['amount'],$threshold_val,$d['users']['username'],$d['users']['email'],$currency,$this->From_email());
        				$this->User->query('Insert into cron_data (cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","'.$d['user_wallet']['user_id'].'","'.$d['users']['email'].'","low_balance")');
        			}
        		}	
        		echo 11;
        	}else echo 00;
        }
        
 public function sendLowBalMail($amount,$threshold,$username,$email_id,$currency,$from_email) {
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = 'Global Voyages';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($email_id);

if(strlen($currency) > 0) $curr = $currency. ' '.$amount ; else $curr = 'INR '.$amount;
$sub = 'URGENT: Low balance in your Global Voyages Account ('.$curr.')'; 
$wallet = $amount - $threshold;
        	$email->subject($sub);
     $link = $link = Router::url(array('plugin'=>'usermgmt','controller'=>'users', 'action'=>'login'),false);   	
     
        	$body="Dear ".$username.",<br/><br/>

 This is to notify you that Funds under your Global Voyages account have dropped below the minimum balance. You are advised to immediately remit funds so that you can continue to apply. <br/>
<br/><strong><u>Your Wallet Details</u></strong><br/> Balance Amount = <strong>".$curr."</strong><br/>
Threshold Amount = <strong>".$currency." ".$threshold."</strong><br/>
Wallet Amount = <strong>".$currency." ".$wallet."</strong><br/><br/>

Please follow the process below for adding funds to your account-<br/>
1. Login to your Global Voyages Account<br/>
<a href = 'http://www.global-voyages.in".$link."'>Click Here to Login.</a><br/>

2. Click on Bank Transactions -> Add New Bank Transaction<br/><br/>

Note that once Funds under your Global Voyages account are exhausted, any Application applied by you would remain Locked in Processing.<br/> These Applications shall only be processed once there are enough Funds in your Global Voyages Account.<br/><br/>

Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
        	
        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
        }
        
        public function weekly_app_report(){
        	$this->autoRender = false;
        	$data = $this->User->query('Select id,email,username From users Where status = 1 and id != 1');
        	$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
        	$airline = $this->User->query('Select * from oktb_airline Where status = 1 or status = 2');
        	$a_val = Set::combine($airline,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
        	$tr_status = $this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	
        	if(count($data) > 0){
        		foreach($data as $d){ 
        		$visa_name = array(); $visa = array(); 
        		 //$d['users']['id'] = 51	;
        		 
        			$vdata = $this->User->query('Select group_id,group_no,tent_date,visa_type,adult,children,infants,app_date,tr_status,app_type,visa_fee From visa_app_group Where user_id = '.$d['users']['id'].' and TIMESTAMPDIFF(DAY,STR_TO_DATE(apply_date, "%d-%m-%Y"),NOW()) <= 7 and status = 1 ');
        			$visa = Set::combine($vdata,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_id');
        			$odata = $this->User->query('Select oktb_id,oktb_no,oktb_group_no,oktb_payment_status,oktb_posted_date,oktb_name,oktb_pnr,oktb_passportno,oktb_d_o_j,oktb_doj_time,oktb_airline_name,oktb_airline_amount From oktb_details Where oktb_user_id = '.$d['users']['id'].' and TIMESTAMPDIFF(DAY,STR_TO_DATE(oktb_posted_date, "%Y-%m-%d"),NOW()) <= 7 and oktb_status = 1');
        			$edata = $this->User->query('Select ext_name,ext_passportno,ext_no,ext_amt,ext_payment_status,ext_date From extension Where ext_user_id = '.$d['users']['id'].' and TIMESTAMPDIFF(DAY,STR_TO_DATE(ext_date, "%Y-%m-%d"),NOW()) <= 7');
        			
        			foreach($visa as $v)
        			$visa_name[$v] = $this->get_data_from_visa_tbl($v);
        			//echo '<pre>'; print_r($visa_name); print_r($vdata); print_r($odata); print_r($edata); exit;
					$this->exportData($vdata,$odata,$edata,$visa_name,$tr_status,$a_val,$visa_type, $d['users']['username'],$d['users']['email'],$d['users']['id']);
        		}
        		echo 11;
        	}else echo 00;
        }
        
 public function weekly_agent_app_report(){
        	$this->autoRender = false;
ini_set('maximum_execution_time',0);
        	$wallet = 0; $arrData = array(); $openBal = 0;
        	$data = $this->User->query('Select id,email,username,id From users Where status = 1 and id != 1');
        	$wallet = $this->User->query('Select amount,user_id From user_wallet Where status = 1');
        	$wallet = Set::combine($wallet,'{n}.user_wallet.user_id','{n}.user_wallet.amount');
$udata = Set::combine($data, '{n}.users.id', '{n}.users.id');	
$ulist = implode(',',$udata);
$curdata = $this->User->query('Select currency_master.currency_code,users.id From users join currency_master on users.currency = currency_master.currency_id Where users.id in ( '.$ulist.')');
        $cdata = Set::combine($curdata, '{n}.users.id', '{n}.currency_master.currency_code');		
//print_r($wallet); exit;
        	$k = 1; $cnt = 1;
        	if(count($data) > 0){
        		foreach($data as $d){
        		if($cnt == 7){
        			$this->User->getDatasource()->reconnect();
        			$cnt = 1;
        		}
        			$user['curr'] = 'INR';
        			$user['wallet']= 0;$res = array(); $visa_name = array(); $visa = array(); 
        		$userId =  $d['users']['id'] ;
        		
        		$amt1 = 0; $amt2 = 0; $amt3 = 0; $amt4 = 0;
				$amtt1 = array(); $amtt2 = array(); $amtt3 = array(); $amtt4 = array();
				$amtt1 = $this->User->query('Select SUM(amt) as add_val  From new_transaction Where user_id = '.$userId);
        		$amt1 = (strlen($amtt1[0][0]['add_val']) > 0) ? $amtt1[0][0]['add_val'] : $amt1;
				$amtt2 = $this->User->query('Select SUM(amount) as add_val From oktb_transactions Where user_id = '.$userId);
				$amt2 = (strlen($amtt2[0][0]['add_val']) > 0) ? $amtt2[0][0]['add_val'] : $amt2;
				$amtt3 = $this->User->query('Select SUM(amount) as add_val From visa_transactions Where user_id = '.$userId);
				$amt3 = (strlen($amtt3[0][0]['add_val']) > 0) ? $amtt3[0][0]['add_val'] : $amt3;
				$amtt4 = $this->User->query('Select SUM(amount) as add_val From ext_transactions Where user_id = '.$userId);
				$amt4 = (strlen($amtt4[0][0]['add_val']) > 0) ? $amtt4[0][0]['add_val'] : $amt4;
				
        		
      			if(isset($cdata[$userId]) && strlen($cdata[$userId]) > 0) $user['curr'] = $cdata[$userId];
      	
        		$user['email'] = $d['users']['email'];
        		$user['username'] = $d['users']['username'];
        		
        	$arr_check = array('bus_name','mob_no','pin','city','state');
			foreach($arr_check as $a){
				$udata = $this->User->query('Select meta_value From user_meta Where user_id = '.$userId.' and meta_key = "'.$a.'"');
				if(count($udata) > 0)
				$user[$a] =  $udata[0]['user_meta']['meta_value'];
				else
				$user[$a] = '';
		    }
        	$trans_app = $this->User->query('Select app_date,trans_mode,bank_name,opening_bal,amt From new_transaction Where user_id = '.$userId.' and trans_status = "A" and status = 1 and  TIMESTAMPDIFF(DAY,STR_TO_DATE(trans_date, "%Y-%m-%d"),NOW()) <= 7 ');
        	$trans_app2 = $this->User->query('Select SUM(amt) as add_val From new_transaction Where user_id = '.$userId.' and trans_status = "A" and status = 1 and  TIMESTAMPDIFF(DAY,STR_TO_DATE(trans_date, "%Y-%m-%d"),NOW()) <= 7 ');
        	$credit1 = (strlen($trans_app2[0][0]['add_val']) > 0) ? $trans_app2[0][0]['add_val'] : 0;
        	if(count($trans_app) > 0){
        		foreach($trans_app as $t){ $i =0;
        		if(strlen($t['new_transaction']['app_date']) > 0){ $i = strtotime($t['new_transaction']['app_date']);
        			if(array_key_exists($i,$res) == true ){  $i+=$k;   $k++;  }
        		}
        			$res[$i]['date'] = $t['new_transaction']['app_date'];
        			$tr_mode = $this->get_master_data('tr_mode_master',$t['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
        			$res[$i]['app_no'] = $t['new_transaction']['bank_name'];
        			$res[$i]['opening_bal'] = $t['new_transaction']['opening_bal'];
        			//$res[$i]['closing_bal'] = $t['new_transaction']['closing_bal'];
        			$res[$i]['credit'] = $t['new_transaction']['amt'];
        			$res[$i]['type'] = $tr_mode;
        		}
        	}
        	
        	$visa_app = $this->User->query('Select app_id,opening_bal,amount,date From visa_transactions Where user_id = '.$userId.' and status = 1 and TIMESTAMPDIFF(DAY,STR_TO_DATE(date, "%d-%m-%Y"),NOW()) <= 7 ');
        	$visa_app2 = $this->User->query('Select SUM(amount) as add_val From visa_transactions Where user_id = '.$userId.' and status = 1 and TIMESTAMPDIFF(DAY,STR_TO_DATE(date, "%d-%m-%Y"),NOW()) <= 7 ');
        	
        	$debit1 = (strlen($visa_app2[0][0]['add_val']) > 0) ? $visa_app2[0][0]['add_val'] : 0;
        	//print_r($visa_app); exit;
        	if(count($visa_app) > 0){
        		foreach($visa_app as $v){
        			$appDetail = $this->User->query('Select visa_app_group.adult,visa_app_group.children,visa_app_group.infants,visa_app_group.visa_type,visa_app_group.group_no,visa_tbl.app_no,visa_tbl.first_name,visa_tbl.last_name,visa_tbl.passport_no,visa_app_group.role_id From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id  Where visa_tbl.group_id = '.$v['visa_transactions']['app_id']);
        			if(count($appDetail) > 0){
        			$ctotal = $appDetail[0]['visa_app_group']['adult'] + $appDetail[0]['visa_app_group']['children'] + $appDetail[0]['visa_app_group']['infants'];
        			$amt = $v['visa_transactions']['amount'] / $ctotal; //echo '<br/>';
        			$i = strtotime($v['visa_transactions']['date']);
        			for($a = 0; $a < $ctotal; $a++){
        			if(array_key_exists($i,$res) == true){
        				$i+=$k;
        				$k++;
        			}
        			$opening = $amt * $a;
        			$opening_bal = $v['visa_transactions']['opening_bal'] - $opening;
        			$visa_type = $this->get_master_data('visa_type_master',$appDetail[$a]['visa_app_group']['visa_type'],'visa_type_id','visa_type');
        			$res[$i]['app_no'] = '<strong>App No : </strong>'.$appDetail[$a]['visa_tbl']['app_no'] .' <br/>'.$appDetail[$a]['visa_tbl']['first_name'].' '.$appDetail[$a]['visa_tbl']['last_name'].' / '.$appDetail[$a]['visa_tbl']['passport_no'].'/'.$visa_type;
        			$res[$i]['group_no'] = $appDetail[$a]['visa_app_group']['group_no'];
        			$res[$i]['date'] = $v['visa_transactions']['date'];
        			$res[$i]['opening_bal'] = $opening_bal;
        			//$res[$i]['closing_bal'] = $opening_bal - $amt; //echo '<br/>';
        			$res[$i]['debit'] = $amt;
        			$res[$i]['type'] = 'Visa Application ('.$appDetail[$a]['visa_app_group']['group_no'].')';
        			if($appDetail[$a]['visa_app_group']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			$i++;
        			}
        			}
        		}
        	}
        	
        	
        	$oktb_app = $this->User->query('Select oktb_transactions.date,oktb_details.oktb_airline_name,oktb_details.oktb_group_no,oktb_details.oktb_name,oktb_details.oktb_passportno,oktb_transactions.opening_bal,oktb_transactions.amount,oktb_details.oktb_no,oktb_details.role_id From oktb_transactions join oktb_details on oktb_details.oktb_id = oktb_transactions.oktb_id Where oktb_transactions.user_id = '.$userId.' and oktb_transactions.status = 1 and  TIMESTAMPDIFF(DAY,STR_TO_DATE(oktb_transactions.date, "%d-%m-%Y"),NOW()) <= 7  ');
        	$oktb_app2 = $this->User->query('Select SUM(amount) as add_val From oktb_transactions Where user_id = '.$userId.' and status = 1 and  TIMESTAMPDIFF(DAY,STR_TO_DATE(date, "%d-%m-%Y"),NOW()) <= 7  ');
        	$debit2 = (strlen($oktb_app2[0][0]['add_val']) > 0) ? $oktb_app2[0][0]['add_val'] : 0;
        	if(count($oktb_app) > 0){
        		foreach($oktb_app as $v){
        			$i = strtotime($v['oktb_transactions']['date']);
        			if(array_key_exists($i,$res) == true){
        				$i+=$k;
        				$k++;
        			}
        			
        			$air = '';
        			if(isset($airline[$v['oktb_details']['oktb_airline_name']])) $air = ' / '.$airline[$v['oktb_details']['oktb_airline_name']];
        			$res[$i]['group_no'] = $v['oktb_details']['oktb_group_no'];
        			$res[$i]['app_no'] = $v['oktb_details']['oktb_name'].' / '.$v['oktb_details']['oktb_passportno'].$air;
        			$res[$i]['date'] = $v['oktb_transactions']['date'];
        			$res[$i]['opening_bal'] = $v['oktb_transactions']['opening_bal'];
        			//$res[$i]['closing_bal'] = $v['oktb_transactions']['closing_bal'];
        			$res[$i]['debit'] = $v['oktb_transactions']['amount'];
        			$res[$i]['type'] = 'OKTB Application ('.$v['oktb_details']['oktb_no'].')';
        			if($v['oktb_details']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			$i++;
        		}
        	}
        	
   $ext_app = $this->User->query('Select ext_transactions.date,ext_details.ext_group_id,ext_details.ext_name,ext_details.ext_passportno,ext_transactions.opening_bal,ext_transactions.amount,ext_details.ext_no,ext_details.role_id From ext_transactions join ext_details on ext_details.ext_id = ext_transactions.ext_id Where ext_transactions.user_id = '.$userId.' and ext_transactions.status = 1 and TIMESTAMPDIFF(DAY,STR_TO_DATE(ext_transactions.date, "%Y-%m-%d"),NOW()) <= 7 order by ext_transactions.date desc');
   $ext_app2 = $this->User->query('Select SUM(amount) as add_val From ext_transactions Where user_id = '.$userId.' and status = 1 and TIMESTAMPDIFF(DAY,STR_TO_DATE(date, "%Y-%m-%d"),NOW()) <= 7 order by date desc');
   $debit3 = (strlen($ext_app2[0][0]['add_val']) > 0) ? $ext_app2[0][0]['add_val'] : 0;
        	if(count($ext_app) > 0){
        		foreach($ext_app as $t){ $i =0;
        		if(strlen($t['ext_transactions']['date']) > 0){
        			$i = strtotime($t['ext_transactions']['date']);
        			if(array_key_exists($i,$res) == true ){
        				$i+=$k;
        				$k++;
        			}
        		}
				$gData = array();
        			$res[$i]['date'] = $t['ext_transactions']['date'];
        			if($t['ext_details']['ext_group_id'] != null){
        				$gData = $this->User->query('Select first_name,last_name,passport_no,app_no From visa_tbl Where app_id = '.$t['ext_details']['ext_group_id']);
        				if(count($gData) > 0)
        				$name = $gData[0]['visa_tbl']['first_name'].' '.$gData[0]['visa_tbl']['last_name'].' / '.$gData[0]['visa_tbl']['passport_no'];
        			}else if($t['ext_details']['ext_name'] != null)
        			$name = $t['ext_details']['ext_name'].' / '.$t['ext_details']['ext_passportno'];
        			else $name = '';
        			$res[$i]['app_no'] = $name;
        			$res[$i]['group_no'] = isset($gData[0]['visa_tbl']['app_no']) ? $gData[0]['visa_tbl']['app_no'] : 'NA';
        			$res[$i]['opening_bal'] = $t['ext_transactions']['opening_bal'];
        			//$res[$i]['closing_bal'] = $t['ext_transactions']['closing_bal'];
        			$res[$i]['debit'] = $t['ext_transactions']['amount'];
        			$res[$i]['type'] = 'Extension Visa Application ('.$t['ext_details']['ext_no'].')';
        			if($t['ext_details']['role_id'] != null)
        			$res[$i]['added_by'] = 1; else $res[$i]['added_by'] = 0;
        			//$i++;
        		}
        	}
        	
        	$th_app = array();
         $th_app = $this->User->query('Select date,opening_bal,avail_th From threshold Where user_id = '.$userId.' and TIMESTAMPDIFF(DAY,STR_TO_DATE(date, "%Y-%m-%d"),NOW()) <= 7');
        	if(count($th_app) > 0){
        		foreach($th_app as $t){ $i =0;
        		if(strlen($t['threshold']['date']) > 0){
        			$i = strtotime($t['threshold']['date']);
        			if(array_key_exists($i,$res) == true ){
        				$i+=$k;
        				$k++;
        			}
        		}
        			$res[$i]['date'] = $t['threshold']['date'];
        			$res[$i]['app_no'] = '-';
        			$res[$i]['opening_bal'] = $t['threshold']['opening_bal'];
        			//$res[$i]['closing_bal'] = $t['threshold']['closing_bal'];
        			$res[$i]['credit'] = $t['threshold']['avail_th'];
        			$res[$i]['type'] = 'Credit Limit Revised';
        		}
        	}
        	
        	if(count($res) > 0){
        		ksort($res);
        		$user['wallet'] = $wallet[$userId];
        		$arrData = array_slice($res, 0, 1);
        		$user['openBal'] = $arrData[0]['opening_bal'];
				$report = $this->get_weekly_report_data($user,$res); 
        		$credited = $amt1; $debited = $amt2 + $amt3 + $amt4;
        		
        		$wcredited = $credit1; $wdebited = $debit1 + $debit2 + $debit3;
        		
        		$this->sendWeeklyReportMail($user,$this->From_email(),$report,$credited,$debited,$wcredited,$wdebited);
        		$this->User->query('Insert into cron_data (cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","'.$userId.'","'.$user['email'].'","weekly_report")');
        		if(strlen($report) > 0) unlink($report);
        	} 
        	//exit;
        		$cnt++;
        		}
        		echo 11;
        	}else echo 00;
        }
        
        
public function get_weekly_report_data($user=array(),$res=array()){
      	$this->autoRender = false;
     	if(count($user) > 0 && count($res) > 0){
     	$src = WWW_ROOT.'uploads/weekly';
       if(!is_dir($src)){
        		$this->Session->setFlash(__('Download folder does not exist'));
        		}else{ 
     	
      	$html = '';	
       ob_start();
       $view = new View($this, false);
       $view->set('user',$user);
       $view->set('res',$res);
       
       $view->layout = null;
       $view->viewPath = "Users";
       $html .= $view->render("weekly_agent_app_report");
       //echo $html; exit;
       ob_end_clean();
       $file_name = $src."/Weekly_Report-".$user['username']."(".date('d-m-Y').").pdf";
		if(file_exists($file_name) == false)
		$handle = fopen($file_name, 'w') or die('Cannot open file: '.$file_name);
		
		$this->dompdf = new DOMPDF();
		$papersize='legal';
		$orientation='portrait';
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper($papersize, $orientation);
		$this->dompdf->render();
		$output = $this->dompdf->output();
		//echo $this->dompdf->output();
		file_put_contents($file_name, $output);
		return $file_name;
        	}
     	 }
      }

      public function sendWeeklyReportMail($user,$from_email,$path,$camt,$damt,$wcamt,$wdamt) {
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = 'Global Voyages';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($user['email']);

 $sub = 'Weekly Application Report  From '.date('Y-m-d', strtotime(' -7 day')).' to '.date('Y-m-d'); 
     $email->subject($sub);
     if(strlen($path) > 0)
		$email->attachments($path);
        $body="Dear ".$user['username'].",<br/><br/>
Please find the attached copy.<br/><br/>This Attachment is a Report of Visa , OKTB and Extension Application you have applied Last Week.<br/><br/>
<br/>
<b>TRANSACTION HISTORY</b><br/>
<b>Your Balance Amount</b> : ".$user['curr']." ".$user['wallet']."<br/>
<br/>

Weekly Transactions : <br/>
<table>
<tr>
<td>Credited Amt</td>
<td> - </td>
<td>".$user['curr']." ".$wcamt."</td>
</tr>

<tr>
<td>Debited Amt</td>
<td> - </td>
<td>".$user['curr']." ".$wdamt."</td>
</tr>
</table><br/>

Overall Transactions : <br/>
<table>
<tr>
<td>Total Credited Amt</td>
<td> - </td>
<td>".$user['curr']." ".$camt."</td>
</tr>

<tr>
<td>Total Debited Amt</td>
<td> - </td>
<td>".$user['curr']." ".$damt."</td>
</tr>
</table><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
       
        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        		$this->log($result, LOG_DEBUG);
        	}
        }
       
 		function exportData($vdata,$odata,$edata,$visa_name,$tr_status,$a_val,$visa_type,$username,$email,$userid) {
 				$this->autoRender = false;
 			if(count($vdata) > 0 && count($odata) > 0 && count($edata) > 0){
 				$src = WWW_ROOT.'uploads/weekly';
 				if(!is_dir($src)){
        		$this->Session->setFlash(__('Download folder does not exist'));
        		}else{ 
        		$html='';
        		ob_start();
        		$view = new View($this, false);
        		$view->layout = null;
        		$view->viewPath = "Users";
        		$view->set('vdata',$vdata);
        		$view->set('odata',$odata);
        		$view->set('edata',$edata);
        		$view->set('visa_name',$visa_name);
        		$view->set('tr_status',$tr_status);
        		$view->set('airline',$a_val);
        		$view->set('visa_type',$visa_type);
        	
        		$html = $view->render("export_data");
        		ob_end_clean();
        		//print_r($html); exit;
        		$file_name = $src."/Weekly_Report-".$username."(".date('d-m-Y').").xls";
        		file_put_contents($file_name, $html);
        		$this->sendWeeklyReportMail($username,$email,$this->From_email(),$file_name);
        		$this->User->query('Insert into cron_data (cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","'.$userid.'","'.$email.'","weekly_report")');
        		 unlink($file_name);
        		}
 			}
        }	
        
        
/*public function sendWeeklyReportMail($username,$email_id,$from_email,$path) {
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = 'Global Voyages';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($email_id);

 $sub = 'Weekly Application Report  From '.date('Y-m-d', strtotime(' -7 day')).' to '.date('Y-m-d'); 
        	$email->subject($sub);
     if(strlen($path) > 0)
		$email->attachments($path);
        	$body="Dear ".$username.",<br/><br/>
Please find the attached copy.<br/><br/> This attachment is a report of Visa , OKTB and Extension Application you have applied last week.<br/><br/>

Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
        }*/
       
        public function getLowestBalData(){
        	$this->autoRender = false;
        	if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['value']) && !empty($_POST['value'])){
        		if($_POST['value'] == 3){
        		$data = $this->User->query('Select a_value From agent_settings Where a_key = "lowest_bal" and agent_id = '.$_POST['id']);
        		if(count($data) > 0)
        		echo $data[0]['agent_settings']['a_value'];
        		else echo 0;
        		}else if($_POST['value'] == 2){
        		$data = $this->User->query('Select a_value From agent_settings Where a_key = "urgent_date" and agent_id = '.$_POST['id']);
        		if(count($data) > 0)
        		echo $data[0]['agent_settings']['a_value'];
        		else echo 0;
        		}
        	}
         }
         
 	 public function user_roles(){
        	$this->autoRender = false;
        	$vData = array('all'=>'All') ; $cData = array('all'=>'All');
        	$result=$this->User->query("Select visa_type_id,visa_type From visa_type_master Where status = 1 order by visa_type_id asc");
        	$visa_type = Set::combine($result,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
        	$visa_d = $vData + $visa_type;
        	$this->set('visa_type', $visa_d);
        	
        	$result=$this->User->query("Select a_id,a_name From oktb_airline Where status = 1 or status = 2 order by a_id asc");
        	$airline = Set::combine($result,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
        	$airline_d = $cData + $airline;
        	$this->set('airline', $airline_d);
				$this->set('visa_select',0);
        		$this->set('oktb_select',0);
        	if ($this->request -> isPost()) {
        		//print_r($_POST); exit;
        		$user_check = 0; $email_check = 0;
        		$data = $this->User->query('Select username,email,id From users ');
        		$email_arr = Set::combine($data,'{n}.users.id','{n}.users.email');
        		$username_arr = Set::combine($data,'{n}.users.id','{n}.users.username');
        		
        		$data2 = $this->User->query('Select role_username,role_email,role_id From user_roles Where role_status = 1');
        		$email_arr2 = Set::combine($data2,'{n}.user_roles.role_id','{n}.user_roles.role_email');
        		$username_arr2 = Set::combine($data2,'{n}.user_roles.role_id','{n}.user_roles.role_username');
        		//print_r($username_arr2); print_r($email_arr2);  exit;
        		if(count($data) > 0){
        			if(in_array($this->request->data['User']['username'],$username_arr) || in_array($this->request->data['User']['username'],$username_arr2)){
        				$user_check = 1;
        			}
        			
        			if(in_array($this->request->data['User']['emailId'],$email_arr) || in_array($this->request->data['User']['emailId'],$email_arr2)){
        				$email_check = 1;
        			}
        			//echo $user_check; echo $email_check; exit;
        			if($user_check == 0 && $email_check == 0){
        				$visa_type = ''; $oktb_airline = '';
        				if(is_array($this->request->data['User']['visa_type'])){
        					if(in_array('all',$this->request->data['User']['visa_type'])) $visa_type = '';
        					else $visa_type = implode(',',$this->request->data['User']['visa_type']);
        				}
        				
        				if(is_array($this->request->data['User']['oktb_airline'])){
        					if(in_array('all',$this->request->data['User']['oktb_airline'])) $oktb_airline = '';
        					else $oktb_airline = implode(',',$this->request->data['User']['oktb_airline']);
        				}
        					//echo $visa_type; echo $oktb_airline; exit;
        					$arr_check = array('name','username','password','contact_no','emailId','cpassword','visa_type','oktb_airline');
        					
        					$this->User->useTable ='user_roles';
        					$role_date = date('Y-m-d H:i:s');
        					$this->User->query('Insert into user_roles(role_name,role_username,role_password,visa_type,oktb_airline,role_contact,role_email,role_date) values("'.$this->request->data['User']['name'].'","'.$this->request->data['User']['username'].'","'.md5($this->request->data['User']['password']).'","'.$visa_type.'","'.$oktb_airline.'","'.$this->request->data['User']['contact_no'].'","'.$this->request->data['User']['emailId'].'","'.$role_date.'")');
							$tr_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        					$insertId = $tr_Id[0][0]['id'];
        					
        					$this->User->query('Update user_roles set agent = '.$this->request->data['User']['agent'].',visa = '.$this->request->data['User']['visa'].',oktb = '.$this->request->data['User']['oktb'].',extension = '.$this->request->data['User']['extension'].' Where role_id = '.$insertId);
        					$this->User->query('Insert into users(user_group_id,username,password,email,first_name,active,approve,created,status) values("'.$insertId.'","'.$this->request->data['User']['username'].'","'.md5($this->request->data['User']['password']).'","'.$this->request->data['User']['emailId'].'","'.$this->request->data['User']['name'].'",1,1,"'.$role_date.'",1)');
        					$this->User->query('Insert into user_groups(id,name,alias_name,allowRegistration,created) values("'.$insertId.'","'.$this->request->data['User']['username'].'","'.$this->request->data['User']['username'].'",1,"'.$role_date.'")');
        					
        					if($this->request->data['User']['visa'] == 1) $this->request->data['User']['visa_view'] = 1;
        					if($this->request->data['User']['oktb'] == 1) $this->request->data['User']['oktb_view'] = 1;
        					$func_arr = array();  
        					
        					$func_arr = array('dashboard');
        					foreach($this->request->data['User'] as $k=>$v){ 
        						if(!in_array($k,$arr_check)){
        							if($v == 1) {
        								$function1 = $this->User->query('Select functions,func_id From app_functions Where func_name = "'.$k.'"');
        								$function2 = Set::combine($function1,'{n}.app_functions.func_id','{n}.app_functions.functions');
        								$func_arr = array_merge($function2,$func_arr);
        							}
        						}
        					}
        					$function = array_unique($func_arr);
        					foreach($function as $f2){
        						$per_check = array();
        						$per_check = $this->User->query('Select * From user_group_permissions Where user_group_id = '.$insertId.' and controller = "Users" and action = "'.$f2.'"');
        						if(count($per_check) > 0){
        						$this->User->query('Update user_group_permissions set action = "'.$f2.'" Where user_group_id = '.$insertId.' and controller = "Users" and action = "'.$f2.'"');
        						}else
        						$this->User->query('Insert into user_group_permissions(user_group_id,controller,action) values("'.$insertId.'","Users","'.$f2.'")');
        					}
        					
        					foreach($this->request->data['User'] as $k=>$v){
        						if(!in_array($k,$arr_check)){
        							$this->User->query('Insert into user_roles_meta(role_id,meta_key,meta_value) values("'.$insertId.'","'.$k.'","'.$v.'")');
        						}
							}
							$this->redirect('/Users/all_user_roles');
        			}else{
        				$visa_select = 0 ;  $oktb_select = 0;
        				if(is_array($this->request->data['User']['visa_type']))
        				$visa_select = 1;
        				
        				if(is_array($this->request->data['User']['oktb_airline']))
        				$oktb_select = 1;
        				
        				$this->set('visa_select',$visa_select);
        				$this->set('oktb_select',$oktb_select);
        				$this->set('visa',$this->request->data['User']['visa']);
        				$this->set('oktb',$this->request->data['User']['oktb']);
        				$this->set('extension',$this->request->data['User']['extension']);
        				$this->set('agent',$this->request->data['User']['agent']);
        				
        				if($user_check == 1)
        				$this->set('userMsg','This Username is already taken');
        				if($email_check == 1)
        				$this->set('emailMsg','Email Id is already registered');
        			}
        		}
        	}
        	$this->render('set_user_roles');
        }
        
		function get_oktbairline_dropdown(){
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = 'oktb_airline';
        	return $data;
        }
        
        function all_user_roles(){
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = 'user_roles';
        	$data = $this->User->query('Select * From user_roles Where role_status = 1');
        	$this->set('user_roles',$data);
        	$this->autoRender = false;
        	$this->render('all_user_roles');
        }
        
function access_rights(){
			$this->autoRender = false;
			if(!empty($_POST['role_id'])){
        	$this->Relation->useTable = "";
        	$this->Relation->useTable = 'user_roles_meta';
        	$data = $this->User->query('Select * From user_roles_meta Where role_id = '.$_POST['role_id']);
        	if(count($data) > 0){
	        	foreach($data as $d){
	        		$meta_data[$d['user_roles_meta']['meta_key']] = $d['user_roles_meta']['meta_value'];
	        	}
        	}
        	$this->set('meta_info',$meta_data);
        	$this->render('access_rights');
			}else echo 'Error';
        }
        
        public function delete_user_roles($role_id=null){
        	if($role_id != null){
        		$this->User->query('Update user_roles set role_status = 0 Where role_id = '.$role_id);
        		$this->User->query('Update users set active = 0,status = 0 Where user_group_id = '.$role_id);
        	}
        		$this->redirect('/Users/all_user_roles');
        }
        
        public function edit_user_roles($role_id=null,$msg = null){
        	if($msg != null) $this->set('emailMsg','Email Id is already registered');
        	if($role_id != null){
        		$this->autoRender = false;
        	$vData = array('all'=>'All') ; $cData = array('all'=>'All');
        	$result=$this->User->query("Select visa_type_id,visa_type From visa_type_master Where status = 1 order by visa_type_id asc");
        	$visa_type = Set::combine($result,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
        	$visa_d = $vData + $visa_type;
        	$this->set('visa_type', $visa_d);
        	
        	$result=$this->User->query("Select a_id,a_name From oktb_airline Where status = 1 or status = 2 order by a_id asc");
        	$airline = Set::combine($result,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
        	$airline_d = $cData + $airline;
        	$this->set('airline', $airline_d);
		
        	$result2 = $this->User->query('Select * From user_roles Where role_id = '.$role_id);
        	if(count($result2) > 0){
        		foreach($result2[0]['user_roles'] as $k2=>$r2){
        			$role['User'][$k2] = $r2;	
        		}        		
        	}
        	
        	
        	$result3 = $this->User->query('Select * From user_roles_meta Where role_id = '.$role_id);
        	if(count($result3) > 0){
        		foreach($result3 as $r2){ //print_r($r2); exit;
        			$role['User'][$r2['user_roles_meta']['meta_key']] = $r2['user_roles_meta']['meta_value'];	
        		}        		
        	}
        	//echo '<pre>	'; print_r($role); exit;
        	$this->set('data',$role);
        	if (!empty($role)) {
        				$this->request->data = $role;
        			}
        			
        			$visa_select = 0 ;  $oktb_select = 0;
        			$this->set('visa',$role['User']['visa']);
        			$this->set('oktb',$role['User']['oktb']);
        			$this->set('extension',$role['User']['extension']);
        			$this->set('agent',$role['User']['agent']);
        			//echo $role['User']['visa']; exit;
        				if($role['User']['visa'] == 1){
        				$visa_select = 1;
        				if(strlen($role['User']['visa_type']) > 0)
        				$role['User']['visa_type'] = explode(',',$role['User']['visa_type']);
        				else $role['User']['visa_type'] = array('all');
        				}
        				
        				if($role['User']['oktb'] == 1){
        				$oktb_select = 1;
        				if(strlen($role['User']['oktb_airline']) > 0)
        				$role['User']['oktb_airline'] = explode(',',$role['User']['oktb_airline']);
        				else $role['User']['oktb_airline'] = array('all');
        				}
        				$this->set('data',$role);
        				$this->set('visa_select',$visa_select);
        				$this->set('oktb_select',$oktb_select);
        				$this->set('role_id',$role_id);
						$this->render('edit_user_roles');
        			}else $this->redirect('/Users/all_user_roles');
        	}
        	
        	public function save_edit_roles($role_id=null){
        		$this->autoRender = false;
        		        	if (!empty($role_id) && $this->request -> isPost()) {
        		        $email_check = 0;		
        		$data = $this->User->query('Select username,email,id From users Where user_group_id <> '.$role_id);
        		$email_arr = Set::combine($data,'{n}.users.id','{n}.users.email');
        		$data2 = $this->User->query('Select role_email,role_id From user_roles Where role_id <> '.$role_id);
        		$email_arr2 = Set::combine($data2,'{n}.user_roles.role_id','{n}.user_roles.role_email');
        			if(in_array($this->request->data['User']['role_email'],$email_arr) || in_array($this->request->data['User']['role_email'],$email_arr2)){
        				$email_check = 1;
        			}
        	if($email_check == 0){		
        		        		//print_r($_POST); exit;
        	$visa_type = ''; $oktb_airline = '';
        				if(is_array($this->request->data['User']['visa_type'])){
        					if(in_array('all',$this->request->data['User']['visa_type'])) $visa_type = '';
        					else $visa_type = implode(',',$this->request->data['User']['visa_type']);
        				}
        				
        				if(is_array($this->request->data['User']['oktb_airline'])){
        					if(in_array('all',$this->request->data['User']['oktb_airline'])) $oktb_airline = '';
        					else $oktb_airline = implode(',',$this->request->data['User']['oktb_airline']);
        				}
        					//echo $visa_type; echo $oktb_airline; exit;
        					$arr_check = array('role_name','role_contact','role_email','visa_type','oktb_airline');
        					
        					$this->User->useTable ='user_roles';
        					$role_date = date('Y-m-d H:i:s');
        					$this->User->query('Update user_roles set role_name = "'.$this->request->data['User']['role_name'].'",role_email = "'.$this->request->data['User']['role_email'].'",visa_type= "'.$visa_type.'",oktb_airline = "'.$oktb_airline.'",role_contact = "'.$this->request->data['User']['role_contact'].'",modified= "'.$role_date.'" Where role_id = '.$role_id);
							$this->User->query('Update user_roles set agent = '.$this->request->data['User']['agent'].',visa = '.$this->request->data['User']['visa'].',oktb = '.$this->request->data['User']['oktb'].',extension = '.$this->request->data['User']['extension'].' Where role_id = '.$role_id);
        					
							$func_arr = array(); $func_arr1 = array(); $func_arr2 = array(); $func_arr3 = array();
        					if($this->request->data['User']['visa'] == 1) $this->request->data['User']['visa_view'] = 1;
        					if($this->request->data['User']['oktb'] == 1) $this->request->data['User']['oktb_view'] = 1;
        					//print_r($this->request->data['User']); exit;
        					foreach($this->request->data['User'] as $k=>$v){ 
        						if(!in_array($k,$arr_check)){
        							if($v == 1) {
        								$function1 = $this->User->query('Select functions,func_id From app_functions Where func_name = "'.$k.'"');
        								$function2 = Set::combine($function1,'{n}.app_functions.func_id','{n}.app_functions.functions');
        								$func_arr = array_merge($function2,$func_arr);
        							}
        						}
        					}
        					$function = array_unique($func_arr);
        					$this->User->query('Update user_group_permissions set allowed = 0 Where controller = "Users" and action <> "dashboard" and user_group_id = '.$role_id);
        					//print_r($function);  exit;
        					foreach($function as $f2){ //echo $f2;
        						$per_check = array();
        						$per_check = $this->User->query('Select * From user_group_permissions Where user_group_id = '.$role_id.' and controller = "Users" and action = "'.$f2.'"');
        						
        						if(count($per_check) > 0){ 
        						$this->User->query('Update user_group_permissions set action = "'.$f2.'",allowed = 1 Where user_group_id = '.$role_id.' and controller = "Users" and action = "'.$f2.'"');
        						}else{
        						$this->User->query('Insert into user_group_permissions(user_group_id,controller,action,allowed) values("'.$role_id.'","Users","'.$f2.'",1)');
        					}
        					}
        					//print_r($this->request->data['User']); exit;
        					
        					foreach($this->request->data['User'] as $k=>$v){
        						if(!in_array($k,$arr_check)){
        							$c_check = array();
        							$c_check = $this->User->query('Select * From user_roles_meta Where role_id = '.$role_id.' and meta_key = "'.$k.'"');
        							if(count($c_check) > 0)
        							$this->User->query('Update user_roles_meta set meta_value = "'.$v.'" Where role_id = '.$role_id.' and meta_key = "'.$k.'"');
        							else
        							$this->User->query('Insert into user_roles_meta(role_id,meta_key,meta_value) values("'.$role_id.'","'.$k.'","'.$v.'")');
        						}
							}
							$this->Session->setFlash(__('User Role Updated Successfully'));
							$this->redirect('/Users/all_user_roles');
        	}else{
        		$msg = 'Email Id is already registered';
        		$this->edit_user_roles($role_id,$msg);
        	/*	$visa_select = 0 ;  $oktb_select = 0;
        				if(is_array($this->request->data['User']['visa_type']))
        				$visa_select = 1;
        				
        				if(is_array($this->request->data['User']['oktb_airline']))
        				$oktb_select = 1;
        				
        				$vData = array('all'=>'All') ; $cData = array('all'=>'All');
        	$result=$this->User->query("Select visa_type_id,visa_type From visa_type_master Where status = 1 order by visa_type_id asc");
        	$visa_type = Set::combine($result,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
        	$visa_d = $vData + $visa_type;
        	$this->set('visa_type', $visa_d);
        	
        	$result=$this->User->query("Select a_id,a_name From oktb_airline Where status = 1 or status = 2 order by a_id asc");
        	$airline = Set::combine($result,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
        	$airline_d = $cData + $airline;
        	$this->set('airline', $airline_d);
        	$this->set('role_id',$role_id);
        				$this->set('visa_select',$visa_select);
        				$this->set('oktb_select',$oktb_select);
        				$this->set('visa',$this->request->data['User']['visa']);
        				$this->set('oktb',$this->request->data['User']['oktb']);
        				$this->set('extension',$this->request->data['User']['extension']);
        				
        				if($email_check == 1)
        				$this->set('emailMsg','Email Id is already registered');
        				$this->render('edit_user_roles');	*/
        	}
        				}else $this->render('edit_user_roles');
        	}
        	
 public function getVisa($app=null,$status = null){
        	$this->User->useTable = '';
        	//echo $this->Session->read('role1.visa_type') ; exit;
			if($app == 0) $app = null; $visa_apps = array();
        	$appData  = array(); $app_no = array(); $gData  = array(); $sData = array();  
        	if($status == null){
        		if($this->UserAuth->getGroupName() != 'User'){ 
	        		$this->User->useTable = 'visa_app_group';
	        		if($app == 'all'){
	        			
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc limit 0,200');
	        		}else if($app == null ){
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status  > 1 order by group_id desc limit 0,200');
	        		}else{
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status="'.$app.'" order by group_id desc limit 0,200');}
	        		}else if($this->UserAuth->getGroupName() == 'User'){
	        		/*$currency = '';
	        		
					$cdata = $this->Relation->query('Select currency_code From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$userId.' and currency_master.status = 1');	
	        		if(count($cdata) > 0)
	        	 $currency = $cdata[0]['currency_master']['currency_code']; 	
	        		$this->set('currency',$currency);*/
	        		$userId=$this->UserAuth->getUserId(); 
	        		$this->User->useTable = 'visa_app_group';
	        		if($app == 'all') 
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc limit 0,200');
	        		else if($app == null || $app == 0)
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' order by group_id desc limit 0,200');
	        		else
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' and tr_status="'.$app.'" order by group_id desc limit 0,200');
	        	}
	        	
        	}else{
        		
        		if($this->UserAuth->getGroupName() != 'User'){ 
	        		$this->User->useTable = 'visa_app_group'; 
	        	if($app == 'all'){
	        			
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc'); 
	        	}else if($app == null || $app == 0){  
	        			
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status  > 1 order by group_id desc'); 
        		}else{  
	        			if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
        				$visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status "'.$app.'" and visa_type in ('.$this->Session->read('role1.visa_type').') order by group_id desc');
	        			else
	        			 $visa_apps = $this->User->query('Select group_id From visa_app_group Where upload_status = 1 and status = 1 and tr_status "'.$app.'" order by group_id desc'); 
        		}
        		
        		}else if($this->UserAuth->getGroupName() == 'User'){
	        		/*$currency = '';
	        	
					$cdata = $this->Relation->query('Select currency_code From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$userId.' and currency_master.status = 1');	
	        		if(count($cdata) > 0)
	        		$currency = $cdata[0]['currency_master']['currency_code'];	
	        		$this->set('currency',$currency);*/
	        			$userId=$this->UserAuth->getUserId(); 
					$this->User->useTable = 'visa_app_group';
        			if($app == 'all') { 
        				$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 order by group_id desc ');
        			}else if($app == null || $app == 0){
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' order by group_id desc');
	        		}else{
	        			$visa_apps = $this->User->query('Select group_id From visa_app_group Where status = 1 and user_id='.$userId.' and tr_status="'.$app.'" order by group_id desc');
	        		}
	        	}
        	}
        	
        	if( count($visa_apps) > 0){ 
        		$visa_id = '';
        		$visaData = Set::combine($visa_apps, '{n}.visa_app_group.group_id', '{n}.visa_app_group.group_id');
        		$visa_id = implode(',',$visaData);
        		if(strlen($visa_id) > 0){
        			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0){
$visa_apps2 = $this->User->query('Select * From visa_app_group Where group_id in ('.$visa_id.') and visa_type in ('.$this->Session->read('role1.visa_type').') ');
					}else 
		        	$visa_apps2 = $this->User->query('Select * From visa_app_group Where group_id in ('.$visa_id.')');
        		}else $visa_apps2 = $visa_apps;
        	}
        	
        	if(isset($visa_apps2)){
        	$this->set('visa_apps',$visa_apps2);
			   $date = array();
        	
        	$visa_type='';$status='';$username = '';$applicant= '';$k = 1; $astatus = '';$app_no ='';$gData = ''; $sData = '';
        	
        	$userData = $this->User->query('Select id,username From users Where status = 1');
        	$username = Set::combine($userData,'{n}.users.id','{n}.users.username');
        	
        	$ans1 = $this->User->query('select visa_type_id,visa_type from visa_type_master where status = 1');
        	$visa_type = Set::combine($ans1,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
    
        	if(is_array($visa_apps2)){
        		foreach($visa_apps2 as $row)
        		{
        			$astatus[$row['visa_app_group']['group_id']] = '';
        			if($row['visa_app_group']['apply_date'] <> NULL)
        			$date[$row['visa_app_group']['group_id']] = strtotime($row['visa_app_group']['apply_date']);
        			else
        			$date[$row['visa_app_group']['group_id']] = strtotime($row['visa_app_group']['app_date']);
        			
        			$this->Relation->useTable = 'group_meta';
        			$ans12 = $this->Relation->query('select * from group_meta where group_id='.$row['visa_app_group']['group_id'].' and meta_key = "applicant"');
        			if(count($ans12) > 0){ $applicant[$row['visa_app_group']['group_id']] = $ans12[0]['group_meta']['meta_value']; }

					$this->Relation->useTable = 'visa_tbl';
        			$ansData = $this->Relation->query('select * from visa_tbl where group_id='.$row['visa_app_group']['group_id']);

        			$appData[$row['visa_app_group']['group_id']] = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_id');
        			$appI = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_id');
        			$app_no1 = Set::combine($ansData, '{n}.visa_tbl.app_id', '{n}.visa_tbl.app_no');
        			$app_no[$row['visa_app_group']['group_id']] = implode(',<br/>',$app_no1);
 //print_r($app_no); exit;
        			if(count($ansData) > 0){
        				$app_id = implode(',',$appI);
        				$givenName= $this->Relation->query('select * from visa_meta where app_id in ('.$app_id.')  and visa_meta_key like "given_name%"');
        				$gData[$row['visa_app_group']['group_id']] = Set::combine($givenName, '{n}.visa_meta.app_id', '{n}.visa_meta.visa_meta_value');

        				$surName = $this->Relation->query('select * from visa_meta where app_id in ('.$app_id.') and visa_meta_key like "surname%"');
        				$sData[$row['visa_app_group']['group_id']] = Set::combine($surName,'{n}.visa_meta.app_id','{n}.visa_meta.visa_meta_value');
					}
        			
        			$k++;
        		}
        	}
        	$this->set('app',$appData);
        	$this->set('appNo',$app_no);
        	$this->set('givenName',$gData);
        	$this->set('surName',$sData);
        	$this->set('visa_type',$visa_type);
        	$this->set('applicant',$applicant);
        	$this->set('username',$username);
        	
        	if(count($date) > 0)
        	arsort($date);
        	$this->set('sortDate',$date);
        	}
      }
        
      public function getVisaApp(){
      	$this->autoRender = false;
      	if(isset($_POST['group']) && !empty($_POST['group']) && isset($_POST['groupNo'])){
      		$data = $this->User->query('Select * From visa_tbl Where group_id = '.$_POST['group']);
      		$value1 = Set::combine($data, '{n}.visa_tbl.app_id', '{n}.visa_tbl');
      		$arr_search = array('dob_dd','dob_mm','dob_yy','emp_type','emp_other');
      		foreach($value1 as $k=>$v){
      			foreach($arr_search as $a){
		      		$meta_data = $this->User->query('Select * From visa_meta Where app_id = '.$k.' and visa_meta_key like "'.$a.'%" ');
		      		if(isset($meta_data[0]['visa_meta']['visa_meta_key']))
		      		$value2[$k][$a] = $meta_data[0]['visa_meta']['visa_meta_value'];	
      			}
      		}
      		$emp_type=$this->get_dropdown('emp_type_id', 'emp_type','emp_type_master');
        	$this->set('emp_type', $emp_type);
        	
      		$this->set('value',$data);
      		$this->set('value2',$value2);
      		$this->set('groupNo',$_POST['groupNo']);
      	//	print_r($value2); exit;
      		$this->render('getVisaApp');
      	}else echo 'Error';
      }
      
      public function getAppDoc(){
      	$this->autoRender = false;
      	 if(isset($_POST['app']) && !empty($_POST['app']) && isset($_POST['groupNo'])){ 
      	 	$value = '';
      	 	$arr_check = array('pfp','plp','photograph','app_no');
      	 	foreach($arr_check as $ar){ $data = array(); 
	      		$data = $this->User->query('Select * From visa_meta Where app_id = '.$_POST['app'].' and visa_meta_key like "'.$ar.'%"');
	      		if(count($data) > 0)
	      		$value[$ar] = $data[0]['visa_meta']['visa_meta_value'];
      	 	}
      	 	$this->set('value',$value);
      	 	$this->set('groupNo',$_POST['groupNo']);
      	 	$this->render('getAppDoc');
     	 }else echo 'Error';
      }

    
      public function send_admin_report(){
      	$this->autoRender = false;
      	$data = $this->User->query('Select * From user_action Where TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0');
      	
      	if(count($data) > 0){
      		$this->set('data',$data);
      		$roleId = ''; $extId = ''; $visaId = ''; $oktbId = ''; $userId = '';
      		$user = array();$roleUser = array();$visaApp = array();$oktbApp = array();$extApp = array();$transApp = array();

      	$userData = $this->User->query('Select action_id,user_id From user_action Where TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and user_id is not null and user_id  <> ""');
      	$user = Set::combine($userData,'{n}.user_action.action_id','{n}.user_action.user_id');
        $user = array_unique($user); $userId = implode(',',$user);
        if(strlen($userId) > 0){
      	$user_name = $this->User->query('Select id,username From users Where id in ('.$userId.')');
      	$user = Set::combine($user_name,'{n}.users.id','{n}.users.username'); 
        }
      	
      	$role = Set::combine($data,'{n}.user_action.action_id','{n}.user_action.role_id');
      	$role = array_unique($role); $roleId = implode(',',$role);
      	if(strlen($roleId) > 0){
      	$role_user = $this->User->query('Select role_id,role_username From user_roles Where role_id in ('.$roleId.')');
      	$roleUser = Set::combine($role_user,'{n}.user_roles.role_id','{n}.user_roles.role_username'); 
      	}
      	
      	$visaData = $this->User->query('Select action_id,app_no From user_action Where type like "%Visa%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and app_no is not null and app_no  <> ""');
      	$visa = Set::combine($visaData,'{n}.user_action.action_id','{n}.user_action.app_no');
      	$visa = array_unique($visa); $visaId = implode(',',$visa);
      	if(strlen($visaId) > 0){
      	$visa_app_no = $this->User->query('Select group_no,group_id From visa_app_group Where group_id in ('.$visaId.')');
      	$visaApp = Set::combine($visa_app_no,'{n}.visa_app_group.group_id','{n}.visa_app_group.group_no'); 
      	}
      	
      	$oktbData = $this->User->query('Select action_id,app_no From user_action Where type like "%OKTB%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and app_no is not null and app_no  <> ""');
      	$oktb = Set::combine($oktbData,'{n}.user_action.action_id','{n}.user_action.app_no');
      	$oktb = array_unique($oktb); $oktbId = implode(',',$oktb);
      	if(strlen($oktbId) > 0){
      	$oktb_app_no = $this->User->query('Select oktb_no,oktb_id From oktb_details Where oktb_id in ('.$oktbId.')');
      	$oktbApp = Set::combine($oktb_app_no,'{n}.oktb_details.oktb_id','{n}.oktb_details.oktb_no');
      	}
      	
      	$extData = $this->User->query('Select action_id,app_no From user_action Where type like "%Extension%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and app_no is not null and app_no  <> ""');
      	$ext = Set::combine($extData,'{n}.user_action.action_id','{n}.user_action.app_no');
      	$ext = array_unique($ext); $extId = implode(',',$ext);
      	if(strlen($extId) > 0){
      	$ext_app_no = $this->User->query('Select ext_no,ext_id From ext_details Where ext_id in ('.$extId.')');
      	$extApp = Set::combine($ext_app_no,'{n}.ext_details.ext_id','{n}.ext_details.ext_no');
      	}
      	
      	$transData = $this->User->query('Select action_id,trans_id From user_action Where type like "%Bank Transaction%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and trans_id is not null and trans_id  <> ""');
      	$trans = Set::combine($transData,'{n}.user_action.action_id','{n}.user_action.trans_id');
      	$trans = array_unique($trans); $transId = implode(',',$trans);
      	if(strlen($transId) > 0){
      	$trans_app_no = $this->User->query('Select trans_no,trans_id,bank_type,amt,bank_name From new_transaction Where trans_id in ('.$transId.') ');
      	$transApp = Set::combine($trans_app_no,'{n}.new_transaction.trans_id','{n}.new_transaction.bank_name');
     	}
      	
      	$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
		$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
      	$query1 = $this->User->query('Select * From oktb_airline Where status = 1 or status = 2');
		$airline = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.a_name');
		
		$src = WWW_ROOT.'uploads/Admin_Report';
 				if(!is_dir($src)){
        		$this->Session->setFlash(__('Download folder does not exist'));
        		}else{ 
        $html='';
        ob_start();
        $view = new View($this, false);
        $view->layout = null;
        $view->viewPath = "Users";
        $view->set('visa_type',$visa_type);
        $view->set('tr_status', $tr_status);
        $view->set('airline',$airline); 		
        $view->set('oktb',$oktbApp);
      	$view->set('ext',$extApp);
      	$view->set('trans',$transApp);
       	$view->set('visa',$visaApp);
       	$view->set('role',$roleUser);
       	$view->set('user',$user);
        $html = $view->render("admin_report");
        //echo $html; exit;
        ob_end_clean();
        $file_name = $src."/Admin_Report-(".date('d-m-Y').").xls";
        file_put_contents($file_name, $html);
        
        $count = array(); $dc = array();
        $dataCount = $this->User->query('Select role_id,role_username From user_roles Where role_status = 1');
        $dc = Set::combine($dataCount,'{n}.user_roles.role_id','{n}.user_roles.role_username');
      // print_r($dc);
        if(count($dataCount) > 0){ foreach($dc as $dc1=>$dc2){ //echo $dc1; echo $dc2;
        	//$visaCount[$dc1] = array(); $oktbCount[$dc1] = array();  $extCount[$dc1] = array(); $transData[$dc1] = array();
        $visaCnt[$dc1] = $this->User->query('Select action_id From user_action Where role_id = '.$dc1.' and type like "%Visa%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and action_type like "%Change Status%" and app_no is not null and app_no  <> " " and status = 1');
        $oktbCnt[$dc1] = $this->User->query('Select action_id From user_action Where  role_id = '.$dc1.' and type like "%OKTB%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and action_type like "%Change Status%"  and app_no is not null and app_no  <> " " and status = 1');
        $extCnt[$dc1] = $this->User->query('Select action_id From user_action Where  role_id = '.$dc1.' and type like "%Extension%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and (action_type like "%Change Ext Status%" || action_type like "%Extension Date%"  )  and status = 1');
        $extDateCnt[$dc1] = $this->User->query('Select action_id From user_action Where  role_id = '.$dc1.' and type like "%Extension Date%" and TIMESTAMPDIFF(DAY , STR_TO_DATE(  `date` ,"%Y-%m-%d" ) , NOW( ) ) = 0 and (action_type like "%Add/Edit%"  )  and status = 1');
        
        $count[$dc1]['visa'] = count($visaCnt[$dc1]); $count[$dc1]['oktb'] = count($oktbCnt[$dc1]); $count[$dc1]['ext'] = count($extCnt[$dc1]) + count($extDateCnt[$dc1]); 
        }
        }
        $from_email = $this->From_email();
        $this->sendAdminDailyReportMail($from_email,$file_name,$count,$dc);
       
        $this->User->query('Insert into cron_data (cr_date,cr_data,to_email,cron_type) values("'.date('d-M-Y H:i:s').'","Admin","'.$from_email.'","admin_daily_report")');
        unlink($file_name);
         }
         echo 11;
      	}else echo 0;
      }
      
public function sendAdminDailyReportMail($from_email,$path,$count,$dc) {
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $from_email;
        	$fromNameConfig = 'Global Voyages';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($from_email);

            $sub = 'User Activity Log (Dated : '.date('d M Y').')'; 
        	$email->subject($sub);
     if(strlen($path) > 0)
		$email->attachments($path);
        	$body="Hello Admin ,<br/><br/>
 <b>Following are the count of Application(s) processed today by User : </b>.<br/><br/>";
  if(count($dc) > 0 ){ 
$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>UserName / App type</th>
<th style = 'padding:3px;'>Visa </th>
<th style = 'padding:3px;'>OKTB </th>
<th style = 'padding:3px;'>Extension </th>
</tr>";
     	foreach($dc as $k=>$c){
$body .= "<tr>
<td style = 'padding:3px;'>".$c."</td>
<td style = 'padding:3px;'>".$count[$k]['visa']."</td>
<td style = 'padding:3px;'>".$count[$k]['oktb']."</td>
<td style = 'padding:3px;'>".$count[$k]['ext']."</td>
</tr>";
     	}
  }		
	
$body .= "</tbody></table><br/><br/>";
$body .= "Please find the attached copy.<br/><br/>	
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
        }
        
        
        public function get_exit_info(){
        	$this->autoRender =false;
       		if(!empty($_POST['id'])){
       			$data = $this->User->query('Select exit_date,exit_reason From visa_app_group Where group_id = '.$_POST['id']);
       			$html = "<div><table><tr><td>Exit Date</td><td>".$data[0]['visa_app_group']['exit_date']."</td><tr><tr><td>Reason</td><td>".$data[0]['visa_app_group']['exit_reason']."</td></tr></table></div>";
       			echo $html;
       		}else echo 'NA';
        }
        
        public function get_app_data1($groupId=null)
        {
        	$this->autoRender = false;
     	   if (!empty($groupId)) {
        		$id = $groupId;
        		$data[0] = '';
        		$appdata= array();
        		
        		$this->Relation->useTable = 'visa_tbl';
        		$data = $this->Relation->query('select app_id,first_name,last_name from visa_tbl where group_id='.$id);
        		
				$app = array(); $visa_app = ''; $name = '';
        		if(is_array($data)){
        		$visa_app = Set::combine($data,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
				$name = Set::combine($data,'{n}.visa_tbl.app_id',array('{0} {1}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name'));
        		$this->Relation->useTable = 'visa_app_group';
				$grp_data = $this->Relation->query('select * from visa_app_group where group_id='.$id.' and status = 1');
        			foreach($grp_data as $g){
        				$adult = $g['visa_app_group']['adult']; $child = $g['visa_app_group']['children']; $infants = $g['visa_app_group']['infants'];
        				$appdata['count'] = $adult + $child + $infants;
						$appdata['group_no'] = $g['visa_app_group']['group_no'];
						$visaType = $g['visa_app_group']['visa_type'];
	        			if(strlen($visaType) > 0){
						$query1 = $this->User->query('Select visa_type From visa_type_master Where visa_type_id = '.$visaType);
						$appdata['visa_type'] = $query1[0]['visa_type_master']['visa_type'];
		        		}
        				$appdata['tent_date'] = $g['visa_app_group']['tent_date'];
        				$appdata['adult'] = $g['visa_app_group']['adult'];
        				$appdata['children'] = $g['visa_app_group']['children'];
        				$appdata['infants'] = $g['visa_app_group']['infants'];
	      				$appdata['app_date'] = $g['visa_app_group']['app_date'];
						$appdata['app_type'] = $g['visa_app_group']['app_type'];
        			}
        			$chk_arr = array('app_no','photograph','pfp','plp','passport_no','emp_type','emp_other','dob_yy','dob_mm','dob_dd','doe_yy','doe_mm','doe_dd');
        			foreach($visa_app as $va){ foreach($chk_arr as $ck){ $visa_meta = array();
        				$this->Relation->useTable = 'visa_meta';
        				$visa_meta = $this->Relation->query('select visa_meta_value from visa_meta where app_id='.$va.' and visa_meta_key like "%'.$ck.'%"');
        				if($ck == 'emp_type' && is_numeric($visa_meta[0]['visa_meta']['visa_meta_value'])){
        					$this->Relation->useTable = 'emp_type_master';
        					$emp =  $this->Relation->query('select emp_type from emp_type_master where emp_type_id =  '.$visa_meta[0]['visa_meta']['visa_meta_value']);
        					$app[$va][$ck] = $emp[0]['emp_type_master']['emp_type'];
        				}else
        					$app[$va][$ck] = $visa_meta[0]['visa_meta']['visa_meta_value'];
	        			} 
	        		}
	        	}
        		return array($appdata,$app,$visa_app,$name);
        	}
        }
        
  public function approve_visa_form(){
      if(!empty($_POST['id']) && !empty($_POST['status']) && !empty($_POST['userid']) && !empty($_POST['visa_type']) && !empty($_POST['prev']))
		{
			$this->set('id',$_POST['id']);
			$this->set('data',$_POST);
		}
      }
    
      public function create_invoice($id,$visatype,$visa_fee,$userId,$groupno,$amount,$amount2 = 0){
      	$this->autoRender = false;
     	if(strlen($id) > 0 && strlen($visatype) > 0 && strlen($visa_fee) > 0 && strlen($userId) > 0 ){
     	//App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
     		$user = array();
     		$app_name = array();
     	$arr_check = array('bus_name','mob_no','pin','city','state');
     	foreach($arr_check as $a){
      	$udata = $this->User->query('Select meta_value From user_meta Where user_id = '.$userId.' and meta_key = "'.$a.'"');
      	$user[$a] =  $udata[0]['user_meta']['meta_value'];
     	}
     	$curr = '';
     	$curdata = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where id = '.$userId);
      	if(count($curdata) > 0) $curr = $curdata[0]['currency_master']['currency_code'];
     	$vdata = $this->User->query('Select first_name,last_name,passport_no,app_id From visa_tbl Where group_id = '.$id);
      	$app_id = Set::combine($vdata,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_id');
      	$app_name = Set::combine($vdata,'{n}.visa_tbl.app_id',array('{0} {1} / {2}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name','{n}.visa_tbl.passport_no'));
    	
      	$html = '';	
      	//$amt = $visa_fee/$count;
       ob_start();
       
       $view = new View($this, false);
       if(count($app_name) > 0 && count($user) > 0){
       $view->set('app_name',$app_name);
       $view->set('app_id',$app_id);
       $view->set('user',$user);
       $view->set('group_no',$groupno);
       //$view->set('visa_fee',$visa_fee);
       $view->set('group_id',$id);
       $view->set('visa_type',$visatype);
       $view->set('curr',$curr);
       $view->set('amt',$amount);
       
       if($amount2 != 0){
      		$profit = 0; $ser_charge = 0; $ser_tax = 0; $edu_cess = 0;
      		$profit = $visa_fee - $amount2;
			$ser_charge = round(($profit / 112.36 *100),2) ;
			$ser_tax = (12 / 100) * $ser_charge;
			$edu_cess = (3 / 100) * $ser_tax ;
			
			$total_charge = round(($amount2 + $ser_charge + $ser_tax + $edu_cess),2);
			$view->set('charge',round($ser_charge,2));
		    $view->set('tax',round($ser_tax,2));
		    $view->set('edu',round($edu_cess,2));
		    $view->set('total_charge',$total_charge);
		    $view->set('admin',1);
      	}else{
      	 	$total_charge = $visa_fee.'.00';
      	}
      	$view->set('visa_fee',$total_charge);
       $view->layout = null;
       $view->viewPath = "Users";
       $html .= $view->render("invoice");
       //echo $html; exit;
       ob_end_clean();
	
		if(file_exists(WWW_ROOT.'uploads/receipt/visa') == false)
		mkdir(WWW_ROOT.'uploads/receipt/visa');
		if($amount2 != 0){
		$my_file = WWW_ROOT.'uploads/receipt/visa/Receipt_('.$groupno.'-A).pdf';	
		}else
		$my_file = WWW_ROOT.'uploads/receipt/visa/Receipt_('.$groupno.').pdf';
		if(file_exists($my_file) == false)
		$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
		
		$this->dompdf = new DOMPDF();
		$papersize='A4';
		$orientation='portrait';
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper($papersize, $orientation);
		$this->dompdf->render();
		$output = $this->dompdf->output();
		//echo $this->dompdf->output();
		file_put_contents($my_file, $output);
		return $my_file;
      	}
     	}
      }
      
	public function get_agent_visa(){
		$this->autoRender = false;
		if(!empty($_POST['id']) && $_POST['id'] != 'select'){
			$visa_type=$this->get_visa_dropdown($_POST['id']);	
			//print_r($visa_type);
			
			$html ='<select name="data[\'User\'][\'visa_type\']" id="UserVisaType">';
			foreach($visa_type as $k=>$q)
			{
				$html .='<option value="'.$k.'"';
				$html .= '>'.$q.' </option>';
			}
			$html .='</select>';
			//echo $html;
			$data = $this->User->query('Select amount From user_wallet Where user_id = '.$_POST['id']);
			if(count($data) > 0) $amount = $data[0]['user_wallet']['amount']; else $amount = 0;
			$data2 = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$_POST['id']);
			
			if(count($data2) > 0)
			$amount .= ' '.$data2[0]['currency_master']['currency_code'];
			else $amount .= ' INR';
			$amt_html = "<button class='btn btn-info'>Agent's Balance Amount : ".$amount."</button>";
			$ret_val = array($html,$amt_html);
			echo json_encode($ret_val);
		}else echo 'Error';
	}
	//End//
}