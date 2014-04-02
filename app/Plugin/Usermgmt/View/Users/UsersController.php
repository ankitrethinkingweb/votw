<?php
/*
 This file is part of UserMgmt.

 Author: Chetan Varshney (http://ektasoftwares.com)

 UserMgmt is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 UserMgmt is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

App::uses('UserMgmtAppController', 'Usermgmt.Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Usermgmt.User', 'Usermgmt.UserGroup','UserMeta','Relation');
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
	}
	/**
	 * Used to display all users by Admin
	 *
	 * @access public
	 * @return array
	 */
	public function index($app = null) {
		$this->User->unbindModel( array('hasMany' => array('LoginToken')));
		if($app == 1){
			$users=$this->User->find('all', array('conditions'=>array('status'=>1,'approve'=>0,'username !='=>'admin'),'order'=>'User.id desc'));
		}else
		$users=$this->User->find('all', array('conditions'=>array('status'=>1,'username !='=>'admin'),'order'=>'User.id desc'));

		$this->set('users', $users);
		$bus_name='';
		if(count($users) > 0){
			foreach($users as $user)
			{
				$data =$this->get_meta_data($user['User']['id']);
				if(isset($data['bus_name']))
				$bus_name[$user['User']['id']] = $data['bus_name'];
			}
		}
		$this->set('bus_name',$bus_name);
		$this->set('app',$app);
	}

	/**
	 * Used to display detail of user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return array
	 */

	public function get_meta_data($userId=null)
	{
		if (!empty($userId)) {
			$this->UserMeta->useTable = 'user_meta';
			$usermeta = $this->UserMeta->find('all', array('conditions'=>array('user_id'=>$userId)));
			$userdata='';
				
			foreach($usermeta as $meta)
			{
				if($meta['UserMeta']['meta_key'] == 'bus_name')
				$userdata['bus_name'] =$meta['UserMeta']['meta_value'];

				/*if($meta['UserMeta']['meta_key'] == 'agent_type')
				 {
					$userdata['agent_type'] =$meta['UserMeta']['meta_value'];
					$this->Relation->useTable = 'agent_type_master';
					$ans =$this->Relation->find('all', array('conditions'=>array('type_id'=>$meta['UserMeta']['meta_value'])));;
					$userdata['agent_type_name'] = $ans[0]['Relation']['type'];
					}*/
				if($meta['UserMeta']['meta_key'] == 'contact_no')
				$userdata['contact_no'] =$meta['UserMeta']['meta_value'];

				//if($meta['UserMeta']['meta_key'] == 'website')
				//$userdata['website'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'address')
				$userdata['address'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'city')
				$userdata['city'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'state')
				$userdata['state'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'country')
				{
					$userdata['country'] = $meta['UserMeta']['meta_value'];
					$this->Relation->useTable ='country_master';
					$ans =$this->Relation->query('select * from country_master where country_id = '.$meta['UserMeta']['meta_value']);
					$userdata['country_name'] = $ans[0]['country_master']['country'];
				}
				if($meta['UserMeta']['meta_key'] == 'pin')
				$userdata['pin'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'con_name')
				$userdata['con_name'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'con_email')
				$userdata['con_email'] =$meta['UserMeta']['meta_value'];

				if($meta['UserMeta']['meta_key'] == 'mob_no')
				$userdata['mob_no'] =$meta['UserMeta']['meta_value'];
			}
			return $userdata;
				
		}
	}
	public function viewUser($userId=null) {
		if (!empty($userId)) {
			$user = $this->User->read(null, $userId);
			$this->set('user', $user);

			$userdata = $this->get_meta_data($userId);
				
			$this->set('usermeta', $userdata);
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to display detail of user by user
	 *
	 * @access public
	 * @return array
	 */
	public function myprofile() {
		$userId = $this->UserAuth->getUserId();

		$user = $this->User->read(null, $userId);

		$this->set('user', $user);

		$userdata = $this->get_meta_data($userId);
			
		$this->set('usermeta', $userdata);

		//	$this->set('user', $user);
	}

	public function edit_profile()
	{

		$agentType=$this->get_dropdown('type_id', 'type','agent_type_master' );
		$this->set('agentType', $agentType);
			
		$country=$this->get_dropdown('country_id', 'country','country_master');
		$this->set('country', $country);
		
		$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
		$this->set('currency', $currency);
		
		$userId = $this->UserAuth->getUserId();

		$user = $this->User->read(null, $userId);

		$data = $this->get_meta_data($userId);
		if(is_array($data)){
			foreach($data as $keys=>$values){
				$user['User'][$keys]=$values;
			}
		}


		if (!empty($user)) {
			$user['User']['password']='';
			$this->request->data = $user;
		}

	}

	public function save_profile()
	{
		$userGroups=$this->UserGroup->getGroups();
		$this->set('userGroups', $userGroups);
			
		//$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
		//$this->set('currency', $currency);
			
		$country=$this->get_dropdown('country_id', 'country','country_master');
		$this->set('country', $country);
			
		$userId =  $this->UserAuth->getUserId();
		//echo $this->request->isPut();
			
		if ($this->request->isPost()) {
			$this->User->set($this->request->data);
			if ($this->User->RegisterValidate()) {
					
				//$this->User->useTable = "";
				//$this->User->useTable = 'users';
				//$this->User->query("Update users set currency = '".$this->request->data['User']['currency']."' Where id = ".$userId);
				
				//$res['agent_type'] = $this->request->data['User']['agent_type'];
				$res['bus_name'] = $this->request->data['User']['bus_name'];
				$res['contact_no'] = $this->request->data['User']['contact_no'];
				//$res['website'] = $this->request->data['User']['website'];
				$res['address'] = $this->request->data['User']['address'];
				$res['city'] = $this->request->data['User']['city'];
				$res['state'] = $this->request->data['User']['state'];
				$res['country'] = $this->request->data['User']['country'];
				$res['pin'] = $this->request->data['User']['pin'];
				$res['con_name'] = $this->request->data['User']['con_name'];
				$res['con_email'] = $this->request->data['User']['con_email'];
				$res['mob_no'] = $this->request->data['User']['mob_no'];
					
				$this->User->useTable = "";
				$this->User->useTable = 'user_meta';
				foreach($res as $key=>$value){
					$this->User->query("Update user_meta set meta_value = '".$value."' Where user_id = ".$userId." and meta_key = '".$key."'");
				}
				$this->Session->setFlash(__('Profile is successfully updated'));
				$this->render('users/edit_profile');
					
			}
		}
		else {
			$user = $this->User->read(null, $userId);
			$data = $this->get_meta_data($userId);
			if(is_array($data)){
				foreach($data as $keys=>$values){
					$user['User'][$keys]=$values;
						
				}
			}
			$this->set('user',$user);
			$this->render('users/edit_profile');
		}
	}
	/**
	 * Used to logged in the site
	 *
	 * @access public
	 * @return void
	 */
	public function login() {
		$userId = $this->UserAuth->getUserId();
		if ($userId) {
			$this->redirect("/dashboard");
		}
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if($this->User->LoginValidate()) {
				$email  = $this->data['User']['email'];
				$password = $this->data['User']['password'];

				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$this->Session->setFlash(__('Incorrect Email/Username or Password'));
						return;
					}
				}
				// check for inactive account
				if ($user['User']['id'] != 1 and $user['User']['active']==0) {
					$this->Session->setFlash(__('Your registration has not been confirmed please verify your email or contact to Administrator'));
					return;
				}
				if ($user['User']['id'] != 1 and $user['User']['approve']==0) {
					$this->Session->setFlash(__('Your registration has not been approved. please verify your email or contact to Administrator'));
					return;
				}
				$hashed = md5($password);
				if ($user['User']['password'] === $hashed) {
					$this->UserAuth->login($user);
						
						
					$remember = (!empty($this->data['User']['remember']));
					if ($remember) {
						$this->UserAuth->persist('2 weeks');
					}
					$OriginAfterLogin=$this->Session->read('Usermgmt.OriginAfterLogin');
					$this->Session->delete('Usermgmt.OriginAfterLogin');
						
					date_default_timezone_set('Asia/Kolkata');
					$res = date('d-m-Y h:i:s A');
					$this->User->id = $user['User']['id']; // This avoids the query performed by read()
					$this->User->saveField('last_login', $res);
					$redirect = (!empty($OriginAfterLogin)) ? $OriginAfterLogin : loginRedirectUrl;
					$this->redirect($redirect);
				} else {
					$this->Session->setFlash(__('Incorrect Email/Username or Password'));
					return;
				}
			}
		}

	}
	/**
	 * Used to logged out from the site
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->UserAuth->logout();
		$this->Session->setFlash(__('You are successfully signed out'));
		$this->redirect('/login');
	}
	/**
	 * Used to register on the site
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
		$userId = $this->UserAuth->getUserId();
		if ($userId) {
			$this->redirect("/dashboard");
		}
		if (siteRegistration) {
			$userGroups=$this->UserGroup->getGroupsForRegistration();
			$this->set('userGroups', $userGroups);
				
			$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
			$this->set('currency', $currency);
				
			$country=$this->get_dropdown('country_id', 'country','country_master');
			$this->set('country', $country);
				
			if ($this->request -> isPost()) {
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					if (!isset($this->data['User']['user_group_id'])) {
						$this->request->data['User']['user_group_id']=defaultGroupId;
					} elseif (!$this->UserGroup->isAllowedForRegistration($this->data['User']['user_group_id'])) {
						$this->Session->setFlash(__('Please select correct register as'));
						return;
					}
					if (!emailVerification) {
						$this->request->data['User']['active']=1;
					}
						
					$approve_data = $this->approve_check();
					if($approve_data == 1)
					$this->request->data['User']['approve'] = 0;
					else
					$this->request->data['User']['approve'] = 1;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
					date_default_timezone_set('Asia/Kolkata');
					$this->request->data['User']['last_login'] = date('d-m-Y h:i:s A');
					$this->User->save($this->request->data,false);
					$userId=$this->User->getLastInsertID();
						
					$res['bus_name'] = $this->request->data['User']['bus_name'];
					$res['contact_no'] = $this->request->data['User']['contact_no'];
					$res['address'] = $this->request->data['User']['address'];
					$res['city'] = $this->request->data['User']['city'];
					$res['state'] = $this->request->data['User']['state'];
					$res['country'] = $this->request->data['User']['country'];
					$res['pin'] = $this->request->data['User']['pin'];
					$res['con_name'] = $this->request->data['User']['con_name'];
					$res['con_email'] = $this->request->data['User']['con_email'];
					$res['mob_no'] = $this->request->data['User']['mob_no'];
						
					$this->User->useTable = "";
					$this->User->useTable = 'user_meta';
					foreach($res as $key=>$value){
			 	 $this->User->query("INSERT INTO user_meta(meta_id,user_id,meta_key,meta_value) VALUES ('',$userId,'$key','$value')");
					}
					$user = $this->User->findById($userId);
					$data = $this->User->query("Select * From user_meta Where user_id = ".$userId);
					$i =0;
					foreach($data as $k=>$v){
						$user['User'][$v['user_meta']['meta_key']] = $v['user_meta']['meta_value'];
						$i++;
					}
					$this->User->sendRegistrationMail($user,$this->From_email());
					$this->User->sendVerificationMail($user,$this->From_email());
					$this->User->sendAdminEmail($user,$this->From_email());

					if (isset($this->request->data['User']['active']) && $this->request->data['User']['active']) {
						$this->UserAuth->login($user);
						$this->redirect('/login');
					} else {
						$this->Session->setFlash(__('Please check your mail and confirm your registration'));
						$this->redirect('/login');
					}
				}else{
					$this->Session->setFlash(__('There are some validation errors . Please check...'));
				}
			}
		} else {
			$this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
			$this->redirect('/login');
		}
	}
	/**
	 * Used to change the password by user
	 *
	 * @access public
	 * @return void
	 */
	public function changePassword() {
		$userId = $this->UserAuth->getUserId();
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->RegisterValidate()) {
				if($this->check_old_password($this->request->data['User']['old_password']) == true)
				{
					$this->User->id=$userId;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
					$this->User->save($this->request->data,false);
					$this->Session->setFlash(__('Password changed successfully'));
					$this->redirect('/dashboard');
				}else
				{
					$this->Session->setFlash(__('Old Password does not match'));
				}
			}
		}
	}
	/**
	 * Used to change the user password by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function changeUserPassword($userId=null) {
		if (!empty($userId)) {
			$name=$this->User->getNameById($userId);
			$this->set('name', $name);
			if ($this->request -> isPost()) {
				$this->User->set($this->data);
				if($this->User->RegisterValidate()) {
					$this->User->id=$userId;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
					$this->User->save($this->request->data,false);
					$this->Session->setFlash(__('Password for %s changed successfully', $name));
					$this->redirect('/allUsers');
				}
			}
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to add user on the site by Admin
	 *
	 * @access public
	 * @return void
	 */
	public function addUser() {
		$userGroups=$this->UserGroup->getGroups();
		$this->set('userGroups', $userGroups);
		$agentType=$this->get_dropdown('type_id', 'type','agent_type_master' );
		$this->set('agentType', $agentType);
		$country=$this->get_dropdown('country_id', 'country','country_master');
		$this->set('country', $country);
		$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
		$this->set('currency', $currency);
		
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->RegisterValidate()) {
				$this->request->data['User']['user_group_id']=defaultGroupId;
				if (!emailVerification) {
					$this->request->data['User']['active']=1;
				}
				$this->request->data['User']['approve']=1;
				$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
				date_default_timezone_set('Asia/Kolkata');
				$this->request->data['User']['last_login'] = date('d-m-Y h:i:s A');
				$this->User->save($this->request->data,false);
				$userId=$this->User->getLastInsertID();
				$res['bus_name'] = $this->request->data['User']['bus_name'];
				$res['contact_no'] = $this->request->data['User']['contact_no'];
				$res['address'] = $this->request->data['User']['address'];
				$res['city'] = $this->request->data['User']['city'];
				$res['state'] = $this->request->data['User']['state'];
				$res['country'] = $this->request->data['User']['country'];
				$res['pin'] = $this->request->data['User']['pin'];
				$res['con_name'] = $this->request->data['User']['con_name'];
				$res['con_email'] = $this->request->data['User']['con_email'];
				$res['mob_no'] = $this->request->data['User']['mob_no'];
					
				$this->User->useTable = "";
				$this->User->useTable = 'user_meta';
				foreach($res as $key=>$value){
					$this->User->query("INSERT INTO user_meta(meta_id,user_id,meta_key,meta_value) VALUES ('',$userId,'$key','$value')");
				}

				$user = $this->User->findById($userId);
					
					
				$data = $this->User->query("Select * From user_meta Where user_id = ".$userId);
				$i =0;
				foreach($data as $k=>$v){
					$user['User'][$v['user_meta']['meta_key']] = $v['user_meta']['meta_value'];
					$i++;
				}
				//print_r($user);exit;
				$this->User->sendRegistrationMail($user,$this->From_email());
				$this->User->sendVerificationMail($user,$this->From_email());
				$this->User->sendAdminEmail($user,$this->From_email());
					
				$this->Session->setFlash(__('The user is successfully added'));
				$this->redirect('/viewUser');
			}
			/*$this->User->set($this->data);
			 if ($this->User->RegisterValidate()) {
				$this->request->data['User']['active']=1;
				$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
				$this->User->save($this->request->data,false);
				$this->Session->setFlash(__('The user is successfully added'));
				$this->redirect('/addUser');
				}*/
		}
	}
	/**
	 * Used to edit user on the site by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function editUser($userId=null) {
		if (!empty($userId)) {
			$userGroups=$this->UserGroup->getGroups();
			$this->set('userGroups', $userGroups);
				
			//$agentType=$this->get_dropdown('type_id', 'type','agent_type_master' );
			//$this->set('agentType', $agentType);

			//$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
			//$this->set('currency', $currency);
			
			$country=$this->get_dropdown('country_id', 'country','country_master');
			$this->set('country', $country);
				
				
			if ($this->request-> isPut()) {
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {

			//$this->User->useTable = "";
				//$this->User->useTable = 'users';
				//$this->User->query("Update users set currency = '".$this->request->data['User']['currency']."' Where id = ".$userId);
				
					//$res['agent_type'] = $this->request->data['User']['agent_type'];
					$res['bus_name'] = $this->request->data['User']['bus_name'];
					$res['contact_no'] = $this->request->data['User']['contact_no'];
					//$res['website'] = $this->request->data['User']['website'];
					$res['address'] = $this->request->data['User']['address'];
					$res['city'] = $this->request->data['User']['city'];
					$res['state'] = $this->request->data['User']['state'];
					$res['country'] = $this->request->data['User']['country'];
					$res['pin'] = $this->request->data['User']['pin'];
					$res['con_name'] = $this->request->data['User']['con_name'];
					$res['con_email'] = $this->request->data['User']['con_email'];
					$res['mob_no'] = $this->request->data['User']['mob_no'];
						
					$this->User->useTable = "";
					$this->User->useTable = 'user_meta';
					foreach($res as $key=>$value){
						$this->User->query("Update user_meta set meta_value = '".$value."' Where user_id = ".$userId." and meta_key = '".$key."'");
					}
					$this->Session->setFlash(__('The user is successfully updated'));
					$this->redirect('/allUsers');
				}
			} else {
				$user = $this->User->read(null, $userId);
				$data = $this->get_meta_data($userId);
				if(is_array($data)){
					foreach($data as $keys=>$values){
						$user['User'][$keys]=$values;
					}
				}

				if (!empty($user)) {
						
					$this->request->data = $user;
				}
			}
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to delete the user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function deleteUser($userId = null) {
		if (!empty($userId)) {
			//if ($this->request->isPost()) {
			if ($this->User->query('Update users set active = 0, approve = 0, status = 0 Where id = '.$userId)) {
				$this->Session->setFlash(__('User is successfully deleted'));
			}
			//}
			$this->redirect('/allUsers');
		} else {
			$this->redirect('/allUsers');
		}
	}
	/**
	 * Used to show dashboard of the user
	 *
	 * @access public
	 * @return array
	 */
	public function dashboard() {
		$this->User->unbindModel( array('hasMany' => array('LoginToken')));
		$userId=$this->UserAuth->getUserId();
		$user = $this->User->findById($userId);
		$this->set('user', $user);
		$extData = array();
		$extData = $this->User->query('Select * From visa_app_group Where user_id = '.$userId. ' and last_doe = "'.date('Y-m-d').'"');
		if(count($extData) > 0) $this->set('extension',count($extData)); else $this->set('extension',0);
		$currency = $this->currency_val($userId);
		$this->set('currency',$currency);
		$count = $this->get_count($userId);
		$this->set('count',$count);
	}

	public function get_count($userId){
		$user_data  = $this->User->query('Select * From users Where status=1 and username <> "admin"');
		$cnt_data['usr_cnt'] = $this->User->getAffectedRows($user_data);

		$user_app  = $this->User->query('Select * From users Where status=1 and approve = 0 and username <> "admin"');
		$cnt_data['usr_app'] = $this->User->getAffectedRows($user_app);

		if($this->UserAuth->getGroupName() == 'Admin')
		$user_trans  = $this->User->query('Select * From new_transaction Where status = 1');
		else $user_trans  = $this->User->query('Select * From new_transaction Where user_id = '.$userId.' and status = 1');
		$cnt_data['user_trans'] = $this->User->getAffectedRows($user_trans);

		if($this->UserAuth->getGroupName() == 'Admin')
		$user_transapp  = $this->User->query('Select * From new_transaction Where status = 1 and trans_status="P"');
		else
		$user_transapp  = $this->User->query('Select * From new_transaction Where user_id = '.$userId.' and status = 1 and trans_status="P"');
		$cnt_data['user_transapp'] = $this->User->getAffectedRows($user_transapp);

		if($this->UserAuth->getGroupName() == 'Admin')
		$visa_app  = $this->User->query('Select * From visa_app_group Where status = 1 and upload_status =1 and tr_status  > 1');
		else  $visa_app  = $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and upload_status =1 and tr_status  > 1');
		$cnt_data['visa_app'] = $this->User->getAffectedRows($visa_app);
			
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_apply = $this->User->query('Select * From visa_app_group Where status = 1 and tr_status=2');
		else $app_apply  = $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=1');
		$cnt_data['app_apply'] = $this->User->getAffectedRows($app_apply);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_apply = $this->User->query('Select * From extension Where ext_status = 1 ');
		else $app_apply  = $this->User->query('Select * From extension Where ext_user_id = '.$userId.' and ext_status = 1');
		$cnt_data['all_ext'] = $this->User->getAffectedRows($app_apply);
		
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_apply = $this->User->query('Select * From extension Where ext_payment_status = 2 and ext_status = 1 ');
		else $app_apply  = $this->User->query('Select * From extension Where ext_user_id = '.$userId.' and ext_payment_status = 2 and ext_status = 1');
		$cnt_data['ext_in_process'] = $this->User->getAffectedRows($app_apply);
		
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_apply = $this->User->query('Select * From extension Where ext_payment_status =5 and ext_status = 1 ');
		else $app_apply  = $this->User->query('Select * From extension Where ext_user_id = '.$userId.' and ext_payment_status = 5 and ext_status = 1');
		$cnt_data['ext_in_approve'] = $this->User->getAffectedRows($app_apply);
		
	
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_process= $this->User->query('Select * From visa_app_group Where status = 1 and upload_status = 1 and tr_status=2');
		else $app_process= $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1  and upload_status = 1 and tr_status=2');
		$cnt_data['app_process'] = $this->User->getAffectedRows($app_process);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_hold= $this->User->query('Select * From visa_app_group Where status = 1 and tr_status=3');
		else $app_hold= $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=3');
		$cnt_data['app_hold'] = $this->User->getAffectedRows($app_hold);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_ihold= $this->User->query('Select * From visa_app_group Where status = 1 and tr_status=4');
		else $app_ihold= $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=4');
		$cnt_data['app_ihold'] = $this->User->getAffectedRows($app_ihold);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_approve  = $this->User->query('Select * From visa_app_group Where status = 1 and tr_status=5');
		else $app_approve  = $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=5');
		$cnt_data['app_approve'] = $this->User->getAffectedRows($app_approve);


        if($this->UserAuth->getGroupName() == 'Admin')
		$app_approve  = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is null');
		else $app_approve  = $this->User->query('Select * From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is null');
		$cnt_data['oktb_approve'] = $this->User->getAffectedRows($app_approve);
		
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_approve  = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is null');
		else $app_approve  = $this->User->query('Select * From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is null');
		$cnt_data['oktb_process'] = $this->User->getAffectedRows($app_approve);
	
 if($this->UserAuth->getGroupName() == 'Admin')
		$app_approve  = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
		else $app_approve  = $this->User->query('Select * From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
		echo $cnt_data['group_oktb_approve'] = $this->User->getAffectedRows($app_approve);
		
		if($this->UserAuth->getGroupName() == 'Admin')
		$app_approve  = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is not null group by oktb_group_no');
		else $app_approve  = $this->User->query('Select * From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is not null group by oktb_group_no');
		echo $cnt_data['group_oktb_process'] = $this->User->getAffectedRows($app_approve);
	exit;
		/*if($this->UserAuth->getGroupName() == 'Admin')
		 $app_processing  = $this->User->query('Select * From visa_app_group Where status = 1 and tr_status=6');
		 else  $app_processing  = $this->User->query('Select * From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=6');
		 $cnt_data['app_processing'] = $this->User->getAffectedRows($app_processing);*/

		$grp_cnt  = $this->User->query('Select * From user_groups');
		$cnt_data['grp_cnt'] = $this->User->getAffectedRows($grp_cnt);

		$trans_app1 = $this->User->query('Select * From new_transaction Where user_id = '.$userId.' and trans_status = "A" and status = 1 order by trans_date desc');
		$visa_app1 = $this->User->query('Select * From visa_transactions Where user_id = '.$userId.' and status = 1 order by date desc');
		$cnt_data['trans_cnt'] = $this->User->getAffectedRows($trans_app1) + $this->User->getAffectedRows($visa_app1);

		$data = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
		$count  = $this->User->query('Select * From new_transaction Where user_id = '.$userId.' and trans_status = "A"');
		$cnt_data['cnt'] = $this->User->getAffectedRows($count);
		if(count($data) > 0)
		$cnt_data['amt'] = $data[0]['user_wallet']['amount'];
		else $cnt_data['amt'] = 0;
			
		return $cnt_data;
	}
	/**
	 * Used to activate user by Admin
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function makeActive($userId = null) {
		if (!empty($userId)) {
			$user=array();
			$user['User']['id']=$userId;
			$user['User']['active']=1;
			$this->User->save($user,false);
			$this->Session->setFlash(__('User is successfully activated'));
		}
		$this->redirect('/allUsers');
	}
	/**
	 * Used to show access denied page if user want to view the page without permission
	 *
	 * @access public
	 * @return void
	 */
	public function accessDenied() {

	}
	/**
	 * Used to verify user's email address
	 *
	 * @access public
	 * @return void
	 */
	public function userVerification() {
		if (isset($_GET['ident']) && isset($_GET['activate'])) {
			$userId= $_GET['ident'];
			$activateKey= $_GET['activate'];
			$user = $this->User->read(null, $userId);
			if (!empty($user)) {
				if (!$user['User']['active']) {
					$password = $user['User']['password'];
					$theKey = $this->User->getActivationKey($password);
					if ($activateKey==$theKey) {
						$user['User']['active']=1;
						$this->User->save($user,false);
						if (sendRegistrationMail && emailVerification) {
							$this->User->sendConfirmationMail($user,$this->From_email());
						}
						$this->Session->setFlash(__('Thank you, your account is activated now'));
					}
				} else {
					$this->Session->setFlash(__('Thank you, your account is already activated'));
				}
			} else {
				$this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
			}
		} else {
			$this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
		}
		$this->redirect('/login');
	}
	/**
	 * Used to send forgot password email to user
	 *
	 * @access public
	 * @return void
	 */
	public function forgotPassword() {
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->LoginValidate()) {

				$useremail ='';
				$email = $this->data['User']['email'];
				$user = $this->User->findByUsername($email);
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$this->Session->setFlash(__('Incorrect Email/Username'));
						return;
					}else
					$useremail =$email;
				}else
				$useremail =$this->get_useremail($user['User']['id']);
				// check for inactive account
				if ($user['User']['id'] != 1 and $user['User']['active']==0) {
					$this->Session->setFlash(__('Your registration has not been confirmed yet please verify your email before reset password'));
					return;
				}
				$this->User->forgotPassword($user,$useremail);
				$this->Session->setFlash(__('Please check your mail for reset your password'));
				$this->redirect('/login');
			}
		}
	}

	public function get_useremail($user_id)
	{
		$res =$this->User->query('select * from users where id ='.$user_id);
		if(count($res) > 0)
		return $res[0]['users']['email'];
	}
	/**
	 *  Used to reset password when user comes on the by clicking the password reset link from their email.
	 *
	 * @access public
	 * @return void
	 */
	public function activatePassword() {
		if ($this->request -> isPost()) {
			if (!empty($this->data['User']['ident']) && !empty($this->data['User']['activate'])) {
				$this->set('ident',$this->data['User']['ident']);
				$this->set('activate',$this->data['User']['activate']);
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
					$userId= $this->data['User']['ident'];
					$activateKey= $this->data['User']['activate'];
					$user = $this->User->read(null, $userId);
					if (!empty($user)) {
						$password = $user['User']['password'];
						$thekey =$this->User->getActivationKey($password);
						if ($thekey==$activateKey) {
							$user['User']['password']=$this->data['User']['password'];
							$user['User']['password'] = $this->UserAuth->makePassword($user['User']['password']);
							$this->User->save($user,false);
							$this->Session->setFlash(__('Your password has been reset successfully'));
							$this->redirect('/login');
						} else {
							$this->Session->setFlash(__('Something went wrong, please send password reset link again'));
						}
					} else {
						$this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
					}
				}
			} else {
				$this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
			}
		} else {
			if (isset($_GET['ident']) && isset($_GET['activate'])) {
				$this->set('ident',$_GET['ident']);
				$this->set('activate',$_GET['activate']);
			}
		}
	}

	public function approve() {
		$userId = $_POST['id'];
		$status = $_POST['status'];
		if (!empty($userId)) {
			$user=array();
			$user['User']['id']=$userId;
			$user['User']['approve']=$status;
			$this->User->save($user,false);
			$this->autoRender = false;
			if($status == 1){
				$data = $this->User->findById($userId);
					
				$this->User->sendApprovalMail($data,$this->From_email());
				echo "<a href='#' onclick = 'approve({$userId},0)'><button id = 'appr_button".$userId."' title= 'Disapprove User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$userId."' class='icon-thumbs-down'></i></span></button></a>";
			}else
			echo "<a href='#' onclick = 'approve({$userId},1)'><button id = 'appr_button".$userId."' title= 'Approve User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$userId."' class='icon-thumbs-up'></i></span></button></a>";

			//$this->Session->setFlash(__('User is successfully approved'));
		}
	}

	public function approve_ind() {
		$userId = $_POST['id'];
		$status = $_POST['status'];
		if (!empty($userId)) {
			$user=array();
			$user['User']['id']=$userId;
			$user['User']['approve']=$status;
			$this->User->save($user,false);
			$this->autoRender = false;
			if($status == 1){
				$data = $this->User->findById($userId);
					
				$this->User->sendApprovalMail($data,$this->From_email());
				echo "<a href='javascript:void;' onclick = 'approve(".$userId.",0)'><i class='icon-thumbs-down'></i>Disapprove User</a> ";
			}else
			echo "<a href='javascript:void;' onclick = 'approve(".$userId.",1)'><i class='icon-thumbs-up'></i>Approve User</a> ";

			//$this->Session->setFlash(__('User is successfully approved'));
		}
	}
	public function approve_trans() {
		$transId = $_POST['id'];
		$status = $_POST['status'];
		$userId = $_POST['user_id'];
		$amt = $_POST['amt'];
		$amt = ereg_replace("[^0-9]", "",$amt);
		if (!empty($transId)) {
			$this->User->query('Update new_transaction set trans_status ="'.$status.'" Where trans_id ='.$transId);
				
			$this->autoRender = false;
			if($status == 'A'){
				$userdata = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
				if(count($userdata) > 0){
					$amount = $userdata[0]['user_wallet']['amount'] + $amt;
					$this->User->query('Update new_transaction set opening_bal ="'.$userdata[0]['user_wallet']['amount'].'" , closing_bal ="'.$amount.'" , app_date = "'.date('d-m-Y h:i:s').'" Where trans_id ='.$transId);
					//$this->User->query('Update new_transaction set closing_bal ="'.$amount.'" Where trans_id ='.$transId);
					$this->User->query('Update user_wallet set amount ="'.$amount.'" Where user_id ='.$userId);
				}else{
					$this->User->query('Update new_transaction set closing_bal ="'.$amt.'" Where trans_id ='.$transId);
					$this->User->query('Insert into user_wallet(user_id,amount) Values ('.$userId.','.$amt.') ');
				}
				$user = $this->User->findById($userId);
				$trans_data = $this->User->query('Select * from new_transaction Where trans_id = '.$transId);
				$trans_data[0]['new_transaction']['tr_mode'] = $this->get_master_data('tr_mode_master',$trans_data[0]['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
				$this->User->sendTransApprovalMail($user,$this->From_email(),$transId,$trans_data[0]);
				echo 'Approved';
			}else echo 'Rejected';
		}
	}

	function check_old_password($old_password)
	{
		$userId = $this->UserAuth->getUserId();
		$user = $this->User->read(null, $userId);
		$pass =  $user['User']['password'];
		//	echo $pass;
		//echo md5($old_password);
		if($pass == md5($old_password))
		return true;
		else
		return false;
	}
	function get_dropdown($id_key, $value_key, $table ){
		$this->Relation->useTable = "";
		$this->Relation->useTable = $table;
		$result=$this->Relation->query("Select * From ".$table." Where status = 1");
		$data =array();
		$data['select']='Select';

		foreach ($result as $row)
		{
			$data[$row[$table][$id_key]]=$row[$table][$value_key];
		}
		return $data;
	}


function get_currency_dropdown($id_key, $value_key, $value_key1,$table ){
		$this->Relation->useTable = "";
		$this->Relation->useTable = $table;
		$result=$this->Relation->query("Select * From ".$table." Where status = 1");
		$data =array();
		$data['select']='Select';

		foreach ($result as $row)
		{
			$data[$row[$table][$id_key]]=$row[$table][$value_key] . '( '. $row[$table][$value_key1].' )';
		}
		return $data;
	}
	function settings(){
			
		if ($this->request -> isPost()) {
			$this->User->set($this->data);
			if ($this->User->AdminValidate()) {
				$this->User->useTable = "";
				$this->User->useTable = 'admin_settings';
				$res['admin_email']  = $this->data['User']['admin_email'];
				$res['admin_approve']  = $this->data['User']['admin_approve'];
				$res['oktb_from']  = $this->data['User']['oktb_from'];
				$res['visa_from']  = $this->data['User']['visa_from'];

				foreach($res as $key=>$value){
					$this->User->query("Update admin_settings set a_value = '".$value."'  Where a_key = '".$key."'");
				}
				$this->Session->setFlash(__('Admin Setting saved successfully'));
				$this->redirect('/settings');
			}else{
				$this->Relation->useTable = "";
				$this->Relation->useTable = 'admin_settings';
				$data = $this->Relation->find('all');
				$this->set('admin_email',$data[0]['Relation']['a_value']);
				$this->set('admin_approve',$data[1]['Relation']['a_value']);
					
			}
		}else{
				
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'admin_settings';
			$data = $this->Relation->find('all');
			$this->set('admin_email',$data[0]['Relation']['a_value']);
			$this->set('oktb_from',$data[3]['Relation']['a_value']);
			$this->set('visa_from',$data[4]['Relation']['a_value']);
			$this->set('admin_approve',$data[1]['Relation']['a_value']);
		}
	}

	public function From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'admin_settings';
		$data = $this->Relation->query("Select * From admin_settings Where a_key = 'admin_email'");
		return $data[0]['admin_settings']['a_value'];
	}

	public function oktb_From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'admin_settings';
		$data = $this->Relation->query("Select * From admin_settings Where a_key = 'oktb_from'");
	//	print_r($data[0]['admin_settings']['a_value']); exit;
		return $data[0]['admin_settings']['a_value'];
	}
		
	public function visa_From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'admin_settings';
		$data = $this->Relation->query("Select a_value From admin_settings Where a_key = 'visa_from'");
	//	print_r($data[0]['admin_settings']['a_value']); exit;
		return $data[0]['admin_settings']['a_value'];
	}

	public function transaction($app = null){
		$this->Relation->useTable = "new_transaction";
		if( $app == 1 ){
			$trans=$this->Relation->query('Select * From new_transaction Where status = 1 and trans_status = "P" Order by trans_id desc');
		}else
		$trans=$this->Relation->query('Select * From new_transaction Where status = 1 Order by trans_id desc');

		$i = 0;
		foreach($trans as $t){
			$data = $this->User->findById($t['new_transaction']['user_id']);
			$trans[$i]['new_transaction']['currency'] = $this->currency_val($t['new_transaction']['user_id']); 	
			$trans[$i]['new_transaction']['user'] = $data['User']['username'];
				
			/*$bank_data = $t['new_transaction']['bank_type'];
			 if($bank_data != 'select' ){
			 $this->Relation->useTable = 'bank_master';
			 $ans =$this->Relation->find('all', array('conditions'=>array('type_id'=>$bank_data)));
			 $trans[$i]['new_transaction']['bank'] = $ans[0]['Relation']['bank_type'];
			 }else $trans[$i]['new_transaction']['bank'] = $bank_data;*/
			$trans[$i]['new_transaction']['bank'] = $this->get_master_data('bank_master',$t['new_transaction']['bank_type'],'type_id','bank_type');
				
				
			$trans_mode_data = $t['new_transaction']['trans_mode'];
			/*if($trans_mode_data != 'select'){
			 	
			$this->Relation->useTable = 'tr_mode_master';
			$ans =$this->Relation->query('Select * From tr_mode_master Where tr_mode_id ='.$trans_mode_data);
			$trans[$i]['new_transaction']['tr_mode'] = $ans[0]['tr_mode_master']['tr_mode'];
			$trans[$i]['new_transaction']['tr_mode_id'] = $trans_mode_data;
			}else $trans[$i]['new_transaction']['tr_mode'] = $trans_mode_data;*/
			$trans[$i]['new_transaction']['tr_mode'] = $this->get_master_data('tr_mode_master',$t['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
				
				
			$count_data = $t['new_transaction']['country'];
			/*if($count_data != 'select'){
			 	
			$this->Relation->useTable = 'country_master';
			$ans =$this->Relation->query('Select * From country_master Where country_id ='.$count_data);
			$trans[$i]['new_transaction']['cntry'] = $ans[0]['country_master']['country'];
			}else{
			$trans[$i]['new_transaction']['cntry'] = $count_data;
			}*/
			$trans[$i]['new_transaction']['cntry'] = $this->get_master_data('country_master',$t['new_transaction']['country'],'country_id','country');
				
			$i++;
		}
		$this->set('trans', $trans);
		$this->set('app', $app);
	}

	public function get_master_data($master,$id,$key,$value)
	{
		$this->Relation->useTable = '';
		$this->Relation->useTable = $master;
		if($id != 'select' and strlen($id) > 0)
		{
			$ans = $this->Relation->query('select * from '.$master.' where '.$key.'= '.$id);
			if(count($ans)>0)
			return $ans[0][$master][$value];
			else
			return '';
		}
		else
		return '';
	}

	public function deleteTrans($transId = null) {
		if (!empty($transId)) {
			//if ($this->request->isPost()) {
			if ($this->User->query('Update new_transaction set status = 0 Where trans_id = '.$transId)) {
				$this->Session->setFlash(__('Transaction deleted successfully'));
			}
			//}
			$this->redirect('/transaction');
		} else {
			$this->redirect('/transaction');
		}
	}
	
public function currency_val($id){
        	$data = array(); $currency = '';
        $data = $this->User->query('Select * From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$id.' and currency_master.status = 1');	
        if(count($data) > 0)
        	$currency = $data[0]['currency_master']['currency_code'];
        //	echo $currency; exit;
        	return $currency;
        }
        
	public function viewTrans($transId = null) {
		$transId = $_POST['id'];
		$trans=$this->User->query('Select * From new_transaction Where trans_id = '.$transId.' Order by trans_date desc');

		foreach($trans as $t){
			$data = $this->User->findById($t['new_transaction']['user_id']);
			$trans[0]['new_transaction']['user'] = $data['User']['username'];

			//$userId=$this->UserAuth->getUserId();
        	$trans[0]['new_transaction']['currency'] = $this->currency_val($t['new_transaction']['user_id']);
        	//$this->set('currency',$currency);
        	
        	$bank_data = $t['new_transaction']['bank_type'];
			if($bank_data != 'select' ){
				$this->Relation->useTable = 'bank_master';
				$ans =$this->Relation->find('all', array('conditions'=>array('type_id'=>$bank_data)));
				if(count($ans) > 0)
				$trans[0]['new_transaction']['bank'] = $ans[0]['Relation']['bank_type'];
			}else $trans[0]['new_transaction']['bank'] = $bank_data;
				
			$trans_mode_data = $t['new_transaction']['trans_mode'];
			if($trans_mode_data != 'select'){
				$this->Relation->useTable = '';
				$this->Relation->useTable = 'tr_mode_master';
				$ans =$this->Relation->query('Select * From tr_mode_master Where tr_mode_id ='.$trans_mode_data);
				$trans[0]['new_transaction']['tr_mode'] = $ans[0]['tr_mode_master']['tr_mode'];
				$trans[0]['new_transaction']['tr_mode_id'] = $trans_mode_data;
			}else $trans[0]['new_transaction']['tr_mode'] = $trans_mode_data;
				
			$count_data = $t['new_transaction']['country'];
			if($count_data != 'select'){
				$this->Relation->useTable = '';
				$this->Relation->useTable = 'country_master';
				$ans =$this->Relation->query('Select * From country_master Where country_id ='.$count_data);
				$trans[0]['new_transaction']['cntry'] = $ans[0]['country_master']['country'];
			}else{
				$trans[0]['new_transaction']['cntry'] = $count_data;
			}
			$this->set('trans',$trans);
		}
	}

	public function apply_oktb(){
		$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
		$this->set('airline', $airline);
		
		$userid=$this->UserAuth->getUserId(); $uCount = 2;
		$urgCount = $this->User->query('Select * From agent_settings Where agent_id = '.$userid.' and a_key = "urgent_date" and status = 1');
		if(count($urgCount) > 0){ $uCount = $urgCount[0]['agent_settings']['a_value'];	}
		$this->set('uCount',$uCount);
		
		$userId=$this->UserAuth->getUserId();
		$currency = $this->currency_val($userId);
		$this->set('currency',$currency);
		
		$this->autoRender = false;
		$this->render('apply_oktb');
	}

	public function get_airline_amt(){
		$this->autoRender =false;
	//	echo $_POST['value'];
		if(isset($_POST['value']) && strlen($_POST['value']) > 0){
			$amount =0;
			$data = $this->User->query('Select * From oktb_airline Where a_id = '.$_POST['value']);
				
			if(count($data) > 0){
				$amount =$data[0]['oktb_airline']['a_price'];
				$userId = $this->UserAuth->getUserId();
				$data1 = $this->User->query('Select * From agent_airline_cost Where air_id = '.$_POST['value'].' and user_id = '.$userId.' and a_status = 1' );
				if(count($data1) > 0)
				{
					$amount = $data1[0]['agent_airline_cost']['air_price'];
				}
			}
				
			
			echo $amount;
		}
	}

	public function save_oktb()
	{
		if ($this->request->isPost())
		{
			$wallet_amt=0;
			$userid=$this->UserAuth->getUserId();
			$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
			if(count($userData) > 0)
			{
				$wallet_amt =$userData[0]['user_wallet']['amount'];
			}
				
			$update=0;$success=array();$fail=array();

			$rowcount =$this->request->data['rowcount'];
			$uCount =$this->request->data['uCount'];
			for($i =1;$i<=$rowcount;$i++)
			{
					
				if($this->request->data['passportno'.$i]!=null and $this->request->data['name'.$i] != null and $this->request->data['pnr'.$i] != null and $this->request->data['d_o_j'.$i]!= null and $this->request->data['visa'.$i]['name'] != null and $this->request->data['from_ticket'.$i]['name'] != null and $this->request->data['to_ticket'.$i]['name'] != null and $this->request->data['airline'.$i] != null and $this->request->data['amount'.$i] != null)
				{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = "";$from_ticket = "";$to_ticket = "";
					$random =rand(111111,999999);
					$oktb_no = 'GVO-'.$random;
						
					if(!file_exists(WWW_ROOT.'uploads/OKTB'))
					mkdir(WWW_ROOT.'uploads/OKTB', 0777, true);

					if(!file_exists(WWW_ROOT.'uploads/OKTB/'.$oktb_no))
					mkdir(WWW_ROOT.'uploads/OKTB/'.$oktb_no, 0777, true);

					//Passport file upload start
						
					if(isset($this->request->data['passport'.$i]['name']) && strlen($this->request->data['passport'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['passport'.$i]['name']);
						$extension = $addr_ext[1];
						$passport = 'passport_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['passport'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$passport);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$passport='';
					//$this->request->data['User']['pfp'.$id]='';
						
					//Passport file upload end
						
					//Visa file upload start
						
					if(isset($this->request->data['visa'.$i]['name']) && strlen($this->request->data['visa'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['visa'.$i]['name']);
						$extension = $addr_ext[1];
						$visa = 'visa_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['visa'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$visa);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$visa='';
					//$this->request->data['User']['pfp'.$id]='';
						
					//Visa file upload end
						
					//From Ticket file upload start
						
					if(isset($this->request->data['from_ticket'.$i]['name']) && strlen($this->request->data['from_ticket'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['from_ticket'.$i]['name']);
						$extension = $addr_ext[1];
						$from_ticket = 'from_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['from_ticket'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$from_ticket);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$from_ticket='';
					//$this->request->data['User']['pfp'.$id]='';
						
					//From Ticket file upload end
						

					//To Ticket file upload start
						
					if(isset($this->request->data['to_ticket'.$i]['name']) && strlen($this->request->data['to_ticket'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['to_ticket'.$i]['name']);
						$extension = $addr_ext[1];
						$to_ticket = 'to_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['to_ticket'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$to_ticket);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$to_ticket='';
					//$this->request->data['User']['pfp'.$id]='';
					$name =$this->request->data['name'.$i];
						
					$pnr = $this->request->data['pnr'.$i];
					$doj = $this->request->data['d_o_j'.$i];
					$airline =$this->request->data['airline'.$i];
					$amount =$this->request->data['amount'.$i];
					$passportno = $this->request->data['passportno'.$i];
					$cr_date=date('Y-m-d H:i:s');
					if($this->request->data['f_hh'.$i]!=null)
					$doj_time =  $this->request->data['f_hh'.$i].':'.$this->request->data['f_mm'.$i];
					else $doj_time = '';
					//To Ticket file upload end
					$this->User->useTable ='oktb_details';
					$this->User->query('Insert into oktb_details(oktb_no,oktb_name,oktb_user_id,oktb_pnr,oktb_d_o_j,oktb_doj_time,oktb_passport,oktb_passportno,oktb_visa,oktb_from_ticket,oktb_to_ticket,oktb_airline_name,oktb_airline_amount,oktb_approve_status,oktb_posted_date,oktb_status,oktb_payment_status) values("'.$oktb_no.'","'.$name.'",'.$userid.',"'.$pnr.'","'.$doj.'","'.$doj_time.'","'.$passport.'","'.$passportno.'","'.$visa.'","'.$from_ticket.'","'.$to_ticket.'","'.$airline.'","'.$amount.'",0,"'.$cr_date.'",1,1)');

				
					$result= $this->apply_oktb_app($oktb_no,$wallet_amt);
					if(is_array($result) and $result[0] == true)
					{
						$success[count($success)] = $oktb_no;
						$pnrOktb[$oktb_no] = $pnr;
						$wallet_amt =$result[1];
					}else
					{
						$fail[count($fail)]=$oktb_no;
					}
				}
			}
			$msg ='';
			$total =$this->request->data['total'];
			if(count($success) > 0){
			$msg .="Your ".count($success)." OKTB Applications are successfully submitted. Amount required for processing these applications will be deducted from your wallet.";
			$this->sendOKTBMail($pnrOktb,$uCount); 
			}
			if(count($fail) > 0)
			$msg .='Oops! '.count($fail).' OKTB Applications are not submitted.You don\'t have sufficient amount in your account for processing these applications.';

			if(count($fail) > 0)
			$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));
			else
			$this->Session->setFlash(__($msg));
							
			$this->autoRender =false;
			$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
		}
	}
	
public function save_group_oktb()
	{
		ini_set('max_execution_time',2000);	
		if ($this->request->isPost())
		{
			//print_r($_POST); exit;
			$wallet_amt=0;
			$userid=$this->UserAuth->getUserId();
			$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
			if(count($userData) > 0)
			{
				$wallet_amt = $userData[0]['user_wallet']['amount'];
			}
				
			$update=0; $success=array(); $fail=array(); $group_no = '';
			
			$total = $this->request->data['total2'];
			if($wallet_amt > $total){
			$rowcount =$this->request->data['rowcount'] + 1;
			$random =rand(111111,999999);
			$group_no = 'GVGO-'.$random;
			
			for($i =1;$i<=$rowcount;$i++)
			{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = "";
					$random =rand(111111,999999);
					$oktb_no = 'GVO-'.$random;
						
					if(!file_exists(WWW_ROOT.'uploads/OKTB'))
					mkdir(WWW_ROOT.'uploads/OKTB', 0777, true);

					if(!file_exists(WWW_ROOT.'uploads/OKTB/'.$oktb_no))
					mkdir(WWW_ROOT.'uploads/OKTB/'.$oktb_no, 0777, true);
					
				if($i == 1){
				if($this->request->data['passportno'.$i]!=null and $this->request->data['name'.$i] != null and $this->request->data['pnr'.$i] != null and $this->request->data['d_o_j'.$i]!= null and $this->request->data['visa'.$i]['name'] != null and $this->request->data['from_ticket'.$i]['name'] != null and $this->request->data['to_ticket'.$i]['name'] != null and $this->request->data['airline'.$i] != null and $this->request->data['amount'.$i] != null)
				{
					if(isset($this->request->data['from_ticket'.$i]['name']) && strlen($this->request->data['from_ticket'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['from_ticket'.$i]['name']);
						$extension = $addr_ext[1];
						$from_ticket = 'from_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['from_ticket'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$from_ticket);
					}else
					$from_ticket='';
						
					if(isset($this->request->data['to_ticket'.$i]['name']) && strlen($this->request->data['to_ticket'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['to_ticket'.$i]['name']);
						$extension = $addr_ext[1];
						$to_ticket = 'to_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['to_ticket'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$to_ticket);
					}else
					$to_ticket='';
				}
				}else{
					$from_ticket=$from_ticket;
					$to_ticket=$to_ticket;
				}
				
					if(isset($this->request->data['passport'.$i]['name']) && strlen($this->request->data['passport'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['passport'.$i]['name']);
						$extension = $addr_ext[1];
						$passport = 'passport_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['passport'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$passport);
					}else
					$passport='';
						
					if(isset($this->request->data['visa'.$i]['name']) && strlen($this->request->data['visa'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['visa'.$i]['name']);
						$extension = $addr_ext[1];
						$visa = 'visa_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['visa'.$i]['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$visa);
					}else
					$visa='';
						
					$name = $this->request->data['name'.$i];
					$pnr = $this->request->data['pnr1'];
					$doj = $this->request->data['d_o_j1'];
					$airline =$this->request->data['airline1'];
					$amount =$this->request->data['amount1'];
					$passportno = $this->request->data['passportno'.$i];
					$cr_date=date('Y-m-d H:i:s');
					if($this->request->data['f_hh1']!=null)
					$doj_time =  $this->request->data['f_hh1'].':'.$this->request->data['f_mm1'];
					else $doj_time = '';
					
					$this->User->useTable ='oktb_details';
					$this->User->query('Insert into oktb_details(oktb_no,oktb_group_no,oktb_name,oktb_user_id,oktb_pnr,oktb_d_o_j,oktb_doj_time,oktb_passport,oktb_passportno,oktb_visa,oktb_from_ticket,oktb_to_ticket,oktb_airline_name,oktb_airline_amount,oktb_approve_status,oktb_posted_date,oktb_status,oktb_payment_status) values("'.$oktb_no.'","'.$group_no.'","'.$name.'",'.$userid.',"'.$pnr.'","'.$doj.'","'.$doj_time.'","'.$passport.'","'.$passportno.'","'.$visa.'","'.$from_ticket.'","'.$to_ticket.'","'.$airline.'","'.$amount.'",0,"'.$cr_date.'",1,1)');
		
					$result= $this->apply_oktb_app($oktb_no,$wallet_amt);
					if(is_array($result) and $result[0] == true)
					{
						$success[count($success)] = $oktb_no;
						$pnrOktb[$oktb_no] = $pnr;
						$wallet_amt =$result[1];
					}else
					{
						$fail[count($fail)]=$oktb_no;
					}
			}
			$msg ='';
			$total =$this->request->data['total2'];
			$uCount = $this->request->data['uCount'];
			if(count($success) > 0){
			$msg .="Your ".count($success)." OKTB Applications are successfully submitted. Amount required for processing these applications will be deducted from your wallet.";
			$this->sendOKTBMail($pnrOktb,$uCount); 
			}
			if(count($fail) > 0)
			$msg .='Oops! '.count($fail).' OKTB Applications are not submitted.You don\'t have sufficient amount in your account for processing these applications.';

			if(count($fail) > 0)
			$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));
			else
			$this->Session->setFlash(__($msg));
			}else{
				$msg ='Oops! OKTB Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
				$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));	
			}				
			$this->autoRender =false;
			//$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
			$this->redirect('oktb_apps/0/na/1');
		}
	}
	

function sendOKTBMail($pnr,$uCount){
		if(is_array($pnr)){
			$result = array();
			//$result = array_count_values($pnr);
		foreach ($pnr as $key => $value) {
		    if (array_key_exists($value, $result)) {
		        $result[$value] .= ',' . $key;
		    } else {
		        $result[$value] = $key;
		    }
		}

		$userId = $this->UserAuth->getUserId();
		
		if(is_array($result)  > 0){
			//print_r($result);
			foreach($result as $k=>$r){
				$pnrData = array();
				$pnrData = explode(',',$r);
				//print_r($pnrData);
				$i = 0; $res1 = array(); $zip = array(); 
				foreach($pnrData as $p){
					$res = array(); 
					$res =$this->User->query('select * from oktb_details where oktb_no = "'.$p.'"');
					$res1[$p] = Set::combine($res, '{n}.oktb_details.oktb_no', '{n}.oktb_details');
					$zip[$p] =$this->create_oktb_zip_excel($p);
					$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$res[0]['oktb_details']['oktb_airline_name']);
					$res1[$p]['airline_name'] = $airline[0]['oktb_airline']['a_name'];
					$res1[$p]['airline_email'] = $airline[0]['oktb_airline']['a_email'];
					$res1[$p]['airline_ccemail'] = $airline[0]['oktb_airline']['a_ccemail'];
					$i++;
				}
				$data_id = $this->User->query('Select * from users Where id = '.$userId);
				//echo '<pre>'; //print_r($res1); //print_r($zip);
				$this->User->sendApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$res1,$r,$uCount);
				
				$count = count($res1);
				if($count > 10){
					$zipData = array();
					$this->User->sendAdminApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$res1,$zipData,$r,$uCount);
					$this->User->sendAirlineApplyOKTBMail1($this->oktb_From_email(),$res1,$zipData,$r,$uCount);
				 $x = 10; 
				$splitArr = array_chunk($res1, $x,true);
				
				if(count($splitArr) > 0){
					for($k = 0;$k <= count($splitArr) - 1;$k++){
						//$this->User->sendApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$splitArr[$k],$r);
						$this->User->sendAdminApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$splitArr[$k],$zip,$r,$uCount);
						$this->User->sendAirlineApplyOKTBMail1($this->oktb_From_email(),$splitArr[$k],$zip,$r,$uCount);
					}
				}
				}else{
						$this->User->sendAdminApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$res1,$zip,$r,$uCount);
						$this->User->sendAirlineApplyOKTBMail1($this->oktb_From_email(),$res1,$zip,$r,$uCount);
						$res1 = array(); $zip = array();
						}
		              }
		           }
		         }
		
		$this->autoRender =false;
	}

function fill_chunk($array, $parts) {
    $t = 0;
    $result = array_fill(0, $parts - 1, array());
   // print_r($result);
    $max = ceil(count($array) / $parts);
    foreach($array as $v) {
        count($result[$t]) >= $max and $t ++;
        $result[$t][] = $v;
    }
    return $result;
}

	function apply_oktb_app($oktb_no,$wallet=0)
	{
		$userId = $this->UserAuth->getUserId();
		$res =$this->User->query('select * from oktb_details where oktb_no ="'.$oktb_no.'"');
		if(count($res)>0 and $res[0]['oktb_details']['oktb_status'] == 1)
		{
			$amt =$res[0]['oktb_details']['oktb_airline_amount'];
			$userData=array();
			//$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
			//if(count($userData) > 0)
			//{
			// $wallet =$userData[0]['user_wallet']['amount'];

			if($amt <= $wallet)
			{
				$tamt =$wallet -$amt;
				$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
				$this->User->query('Update oktb_details set oktb_payment_status = 2,payment_date="'.date('Y-m-d H:i:s').'" Where oktb_user_id = '.$userId.' and oktb_id = '.$res[0]['oktb_details']['oktb_id']);
				$this->User->query('Insert into oktb_transactions(user_id,oktb_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['oktb_details']['oktb_id'].',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
				$data_id = $this->User->query('Select * from users Where id = '.$userId);
				
				return array(true,$tamt);
			}else
			{
				return false;
			}
		}else
		return false;
		//	}else
		//	return false;
	}

	function all_oktb_app($paid=0,$status = null)
	{
		$userid=0;
		if($status == null || $status == 0){
			if($this->UserAuth->getGroupName() != 'Admin')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is null order by payment_date desc limit 0,500');
				}else{ 
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is null order by payment_date desc limit 0,500');
				}
				return $data;
			}else
			{
				if($paid == 2){
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and oktb_details.oktb_payment_status > 1 and users.status = 1  and oktb_group_no is null order by oktb_details.payment_date desc limit 0,500');
				}else{ 
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and users.status = 1  and oktb_group_no is null order by oktb_details.payment_date desc limit 0,500');
				}
				return $data;
			}
		}else{
		if($this->UserAuth->getGroupName() != 'Admin')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is null order by payment_date desc ');
				}else{ 
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is null order by payment_date desc ');
				}
				return $data;
			}else
			{
				if($paid == 2){
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and oktb_details.oktb_payment_status > 1 and users.status = 1  and oktb_group_no is null order by oktb_details.payment_date desc');
				}else{ 
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and users.status = 1  and oktb_group_no is null order by oktb_details.payment_date desc ');
				}
				return $data;
			}
			
		}
	}
	
function all_group_oktb_app($paid=0,$status = null)
	{
		$userid=0;
		if($status == null || $status == 0){
			if($this->UserAuth->getGroupName() != 'Admin')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no order by payment_date desc limit 0,500');
				}else{ 
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no order by payment_date desc limit 0,500');
				}
				return $data;
			}else
			{
				if($paid == 2){
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and oktb_details.oktb_payment_status > 1 and users.status = 1  and oktb_details.oktb_group_no is not null group by oktb_details.oktb_group_no order by oktb_details.payment_date desc limit 0,500');
				}else{ 
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and users.status = 1  and oktb_details.oktb_group_no is not null group by oktb_details.oktb_group_no order by oktb_details.payment_date desc limit 0,500');
				}
				return $data;
			}
		}else{
		if($this->UserAuth->getGroupName() != 'Admin')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no order by payment_date desc ');
				}else{ 
				$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no order by payment_date desc ');
				}
				return $data;
			}else
			{
				if($paid == 2){
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and oktb_details.oktb_payment_status > 1 and users.status = 1  and oktb_details.oktb_group_no is not null group by oktb_details.oktb_group_no order by oktb_details.payment_date desc');
				}else{ 
				$data = $this->User->query('select * from oktb_details join users on oktb_details.oktb_user_id = users.id where oktb_details.oktb_status = 1 and users.status = 1  and oktb_details.oktb_group_no is not null group by oktb_details.oktb_group_no order by oktb_details.payment_date desc ');
				}
				return $data;
			}
		}
	}

	function oktb_apps($paid=0,$wallet='na',$group=0){
		//echo $group;
		$this->set('group',$group);
		$this->set('paid',$paid);
		$userId = $this->UserAuth->getUserId();
		
		$curr_val = $this->User->query('Select * From currency_master Where status = 1');
		$currency = Set::combine($curr_val, '{n}.currency_master.currency_id', '{n}.currency_master.currency_code');
		$this->set('currency',$currency);
		
		if($paid !=2){
			$curr = $this->currency_val($userId);
			$this->set('curr',$curr); 
			$this->set('all_app','all_app');
		}
		
		if($wallet == 'na')
		{
		$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
		if(count($userData)>0)
		$this->set('userAmt',$userData[0]['user_wallet']['amount']);
		}else 
		$this->set('userAmt',$wallet);
		
		$this->autoRender =false;
		$this->render('all_oktb_app');
	}

	function oktb_view()
	{
		$wallet = 'na';
		if($_POST['paid'] != null) $paid = $_POST['paid'];	else $paid = 0;
		if($_POST['value'] != null) $value = $_POST['value'];	else $value = 1;
		if($_POST['status'] != null) $status = $_POST['status'];	else $status = 0;
		$this->set('value',$value);
		$this->set('paid',$paid);

		$userId = $this->UserAuth->getUserId();
		
		if($value == 1)
		$data = $this->all_oktb_app($paid,$status);
		else{
			 $nameResult = array(); $noResult = array(); $result = array(); $pnoResult = array();
			 $data = $this->all_group_oktb_app($paid,$status);
			
			 $result = Set::combine($data, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_group_no');
			 if(count($result) > 0){
				 foreach($result as $k=>$r){
				 	$name[$k] = ''; $no[$k] = ''; $pno[$k] = ''; $nameData = array(); $oktb_fee[$k] = 0;
				 	$nameData = $this->User->query('Select oktb_id,oktb_name,oktb_no,oktb_passportno,oktb_airline_amount From oktb_details Where oktb_group_no = "'.$r.'"');
				 	if(count($nameData) > 0){
				 	$oktb_fee[$k] = count($nameData) * $nameData[0]['oktb_details']['oktb_airline_amount'];
				 	
				 	/*$nameResult = Set::combine($nameData, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_name');
				 	if(count($nameResult) > 0)			 	
				 	$name[$k] = implode(',<br/>',$nameResult);
				 	
				 	$pnoResult = Set::combine($nameData, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_passportno');
				 	if(count($pnoResult) > 0)			 	
				 	$pno[$k] = implode(',<br/>',$pnoResult);
				 	
				 	$noResult = Set::combine($nameData, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_no');
				 	if(count($noResult) > 0)			
				 	$no[$k] = implode(',<br/>',$noResult);*/
				 	}
				 }
				//$this->set('name',$name);
				//$this->set('oktb_no',$no);
				//$this->set('pno',$pno);
				 $this->set('oktb_fee',$oktb_fee);
			 }
		}
		//echo '<pre>'; print_r($data); exit;
		
		$date = array();
		if(count($data) > 0){
			foreach($data as $d){
				if(strlen($d['oktb_details']['payment_date']) > 0)
				$date[$d['oktb_details']['oktb_id']] = strtotime($d['oktb_details']['payment_date']);
				else 
				$date[$d['oktb_details']['oktb_id']] = strtotime($d['oktb_details']['oktb_posted_date']);
			}
		}
		if(count($date) > 0)
        	arsort($date);
        	
       // echo '<pre>'; print_r($date); exit;
		$this->set('sortDate',$date);
		$query1 = $this->User->query('Select * From oktb_airline Where status = 1 or status = 2');
		$result1 = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.a_name');
		$this->set('airline',$result1);
		
		$curr_val = $this->User->query('Select * From currency_master Where status = 1');
		$currency = Set::combine($curr_val, '{n}.currency_master.currency_id', '{n}.currency_master.currency_code');
		$this->set('currency',$currency);
		
		if($paid !=2){
			$curr = $this->currency_val($userId);
			$this->set('curr',$curr); 
			$this->set('all_app','all_app');
		}
		$this->set('oktb_apps',$data);
	
		if(count($data) > 0){
			$query = $this->User->query('Select * From tr_status_master Where status = 1');
			$result = Set::combine($query, '{n}.tr_status_master.tr_status_id', '{n}.tr_status_master.tr_status');
			$this->set('trans',$result);
		}
		
		$this->autoRender =false;
		$this->render('oktb_view');
	}

	public function viewOktb($id,$group=0){
		$data = array();
		
		$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_id ='.$id);
 		$this->set('oktb_apps',$data);

 		if($group != 0){
 			$groupData = array();
 			$group_no = $data[0]['oktb_details']['oktb_group_no'];
 			$groupData = $this->User->query('Select * From oktb_details Where oktb_group_no = "'.$group_no.'" and oktb_id != '.$id);
 			//echo '<pre>'; print_r($groupData); exit;
 			$count =  count($groupData) + 1; 
 			$oktb_fee = $data[0]['oktb_details']['oktb_airline_amount'] * $count;
 			$this->set('oktb_fee',$oktb_fee);
 			$this->set('group',$groupData);
 		}
		if(count($data) > 0){
			$currency = $this->currency_val($data[0]['oktb_details']['oktb_user_id']);
			$this->set('currency',$currency);
		}
		$query = $this->User->query('Select * From tr_status_master Where status = 1');
		$result = Set::combine($query, '{n}.tr_status_master.tr_status_id', '{n}.tr_status_master.tr_status');
		$this->set('trans',$result);

		$query1 = $this->User->query('Select * From oktb_airline Where status = 1 or status = 2');
		$result1 = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.a_name');
		$this->set('airline',$result1);
	}


	public function create_oktb_zip_excel($oktb_no =0)
	{

	 $this->autoRender = false;
	 $zip_file_name='';
	 $src = WWW_ROOT.'uploads/OKTB/'.$oktb_no;

	 if(!is_dir($src)){
	 	$this->Session->setFlash(__('Download folder does not exist'));
	 } else{
	 	$source = $src;


	 	//code for zip
	 	$zip_file_name = WWW_ROOT.'zip/OKTB/'.$oktb_no.'.zip';

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
	 				//print_r($file); exit;

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
	 return $res_new;
	}
	
	public function apply_oktb_app_old($oktb_no)
	{
		$wallet =0;	$userData=array();
		$userId = $this->UserAuth->getUserId();
		$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
			if(count($userData) > 0)
			{
			 $wallet =$userData[0]['user_wallet']['amount']; 
			}
		
		$res =$this->User->query('select * from oktb_details where oktb_no ="'.$oktb_no.'"');
		if(count($res)>0 and $res[0]['oktb_details']['oktb_status'] == 1)
		{
			if($res[0]['oktb_details']['oktb_payment_status'] == 1)
			{
				$amt =$res[0]['oktb_details']['oktb_airline_amount'];
				if($wallet > 0)
				{
				 //$wallet =$userData[0]['user_wallet']['amount'];
	
				if($amt <= $wallet)
				{
					$tamt =$wallet -$amt;
					$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
					$this->User->query('Update oktb_details set oktb_payment_status = 2,payment_date="'.date('Y-m-d H:i:s').'" Where oktb_user_id = '.$userId.' and oktb_id = '.$res[0]['oktb_details']['oktb_id']);
					$this->User->query('Insert into oktb_transactions(user_id,oktb_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['oktb_details']['oktb_id'].',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
					$data_id = $this->User->query('Select * from users Where id = '.$userId);
					//exit;
					$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$res[0]['oktb_details']['oktb_airline_name']);
					$res[0]['oktb_details']['airline_name'] =$airline[0]['oktb_airline']['a_name'];
					$this->User->sendApplyOKTBMail($data_id[0],$this->oktb_From_email(),$res[0]);
					$zip =$this->create_oktb_zip_excel($oktb_no);
					$zip['id']=$res[0]['oktb_details']['oktb_id'];
					$this->User->sendAdminApplyOKTBMail($data_id[0],$this->oktb_From_email(),$res[0],$zip);
					$this->User->sendAirlineApplyOKTBMail($airline[0],$this->oktb_From_email(),$res[0],$zip);
					$msg ="Your OKTB Application is successfully submitted. Amount required for processing these application will be deducted from your wallet.";
					$this->Session->setFlash(__($msg));
					$wallet =$tamt;
					
				}else
				{
					$msg ='Oops! OKTB Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}
			}else
			{
					$msg ='Oops! OKTB Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
			}
				}else 
				{
				$msg ='You Have already applied for this OKTB Application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}}else
				{
					$msg ='Oops! No OKTB Application found with this OKTB Number.Please Check Your OKTB Number Again.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}
			
			$this->autoRender =false;
			/*$data = $this->all_oktb_app();
			$this->set('userAmt',$wallet);
			$this->set('oktb_apps',$data);
						
			$this->autoRender =false;
			$this->render('all_oktb_app');*/
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
			//$this->oktb_apps(0,$wallet);
	}
	
	public function get_approve_form()
	{
		if(isset($_POST['id']))
		{
			$this->autoRender =false;
			$this->set('oktb_id',$_POST['id']);
			$this->render('oktb_approve_form');
		}
	}
	
public function approve_oktb()
{
	   $this->autoRender =false;
if($this->request->isPost())
{
	$okb_id =$_POST['oktb_id'];
	$coment=$this->request->data('comment');
	$cr_date =date('Y-m-d H:i:s');
	if(strlen($okb_id) > 0)
	{
	$this->User->query('update oktb_details set oktb_approve_comments="'.$coment.'",oktb_payment_status =5,oktb_approve_date="'.$cr_date.'" where oktb_id ='.$okb_id);
	$oktb = $this->User->query('select * from oktb_details where oktb_id ='.$okb_id);
	$data_id = $this->User->query('Select * from users Where id = '.$oktb[0]['oktb_details']['oktb_user_id']);
	$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$oktb[0]['oktb_details']['oktb_airline_name']);
	$oktb[0]['oktb_details']['airline_name'] =$airline[0]['oktb_airline']['a_name'];
	$this->User->sendApproveOKTBMail($data_id[0],$this->oktb_From_email(),$oktb[0]);
   $this->Session->setFlash(__('Congratulations!!! OKTB Application Approved Successfully.'));

	echo 'success';
	}else
	{
		echo 'error';
	}
}else 
echo 'error';
}
public function get_oktb_comment()
{
	$this->autoRender =false;
	if(isset($_POST['id']))
	{
		$userdata = $this->User->query('select * from oktb_details where oktb_id = '.$_POST['id']);
		if(count($userdata) > 0)
		return $userdata[0]['oktb_details']['oktb_approve_comments'];
		else 
		echo 'error';
		
	}else 
	echo 'error';
}	

public function download_oktb_doc($oktb_no)
{
	$this->autoRender =false;
 		$path = WWW_ROOT.'zip/OKTB/'.$oktb_no.'.zip';
        if (file_exists($path)) {
        			$this->response->file($path, array(
        'download' => true,
        'name' => $oktb_no.'.zip',
        			));
        		return $this->response;
        }else 
        {
        	  $this->Session->setFlash(__('Sorry!! Documents Not Found', 'default', array('class' => 'errorMsg')));
        	 $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
        }
}

public function download_group($group_no)
{
	$this->autoRender =false;
 	$path = WWW_ROOT.'zip/OKTB/Group/'.$group_no.'.zip';
 	
	if (file_exists($path)) {
        			$this->response->file($path, array(
        'download' => true,
        'name' => $group_no.'.zip',
        			));
        		return $this->response;
        }else 
        {
        	 
    $src = WWW_ROOT.'uploads/OKTB/'.$group_no;
	$source = $src;
	 	
 	$groupData = $this->User->query('Select * From oktb_details Where oktb_group_no = "'.$group_no.'"');	
 	$group = Set::combine($groupData, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_no');	
	$zip = new ZipArchive;
	$res = $zip->open($path, ZipArchive::CREATE);
	if ($res === TRUE) {
		foreach($group as $g){
					$file = WWW_ROOT.'zip/OKTB/'.$g.'.zip';
					$file = str_replace('\\', '/', $file);
	 				if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
	 				continue;
					if (is_dir($file) === true)
	 				{
	 					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
	 				}
	 				else if (is_file($file) === true)
	 				{
	 					$zip->addFromString(str_replace($source . '/', '', basename($file)), file_get_contents($file));
	 				}		
			
			//$zip->addFromString($oktb_path, 'file content goes here');
		}
		$zip->close();
		if (file_exists($path)) {
			$this->response->file($path, array(
	        'download' => true,
	        'name' => $group_no.'.zip',
	        			));
	        return $this->response;
		}
		
	} else {
	     $this->Session->setFlash(__('Sorry!! Documents Not Found', 'default', array('class' => 'errorMsg')));
         $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
        
	}
   }
        /*if (file_exists($path)) {
        			$this->response->file($path, array(
        'download' => true,
        'name' => $oktb_no.'.zip',
        			));
        		return $this->response;
        }else 
        {
        	  $this->Session->setFlash(__('Sorry!! Documents Not Found', 'default', array('class' => 'errorMsg')));
        	 $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
        }*/
}

public function login_as_agent($agent_id)
{
$user = $this->User->findById($agent_id);
if(count($user) > 0)
{
$email = $user['User']['email'];
$password = $user['User']['password'];


// check for inactive account
if ($user['User']['id'] != 1 and $user['User']['active']==0) {
$this->Session->setFlash(__('Registration has not been confirmed..Email is not Verified'));
$this->redirect('/allUsers');
}
if ($user['User']['id'] != 1 and $user['User']['approve']==0) {
$this->Session->setFlash(__('Registration has not been approved.'));
$this->redirect('/allUsers');
}
$this->UserAuth->logout();
$this->UserAuth->login($user);

date_default_timezone_set('Asia/Kolkata');
$res = date('d-m-Y h:i:s A');
$this->User->id = $user['User']['id']; // This avoids the query performed by read()
$this->User->saveField('last_login', $res);
$redirect = '/dashboard';
$this->redirect($redirect);
}else
{
$this->Session->setFlash(__('Not Registered User !!!'));
$this->redirect('/allUsers');
}

}


public function edit_oktb($oktbNo){
		$data = array();$oapp = array();
		$data =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_no ="'.$oktbNo.'"');
		if(count($data) > 0){
		foreach($data[0]['oktb_details'] as $k=>$v){
        				$oapp[$k] = $v;
        			}
		}
		if (!empty($oapp)) {
        				$this->request->data = $oapp;
        			}
        			
		$this->set('data',$oapp);
		
		$airline=$this->urgAirline();
		$this->set('airline', $airline);
		
		$userId=$this->UserAuth->getUserId();
		$currency = $this->currency_val($userId);
		$this->set('currency',$currency);
		
		$this->set('oktb_no',$oktbNo);
		
		$this->autoRender = false;
		$this->render('edit_oktb');
}


public function save_edit_oktb()
	{
		if ($this->request->isPost())
		{
			$wallet_amt=0;
			$userid=$this->UserAuth->getUserId();
			//print_r($this->request->data['oktb_visa']['name']);exit;
					
				if($this->request->data['oktb_passportno']!=null and $this->request->data['oktb_name'] != null and $this->request->data['oktb_pnr'] != null and $this->request->data['oktb_airline_amount'] != null)
				{
					
					
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = "";$from_ticket = "";$to_ticket = "";
					$random =rand(111111,999999);
					$oktb_no = $this->request->data('oktb_no');

					$Odata =$this->User->query('select * from oktb_details where oktb_status =1 and oktb_no ="'.$oktb_no.'"');
					
					if(!file_exists(WWW_ROOT.'uploads/OKTB'))
					mkdir(WWW_ROOT.'uploads/OKTB', 0777, true);

					if(!file_exists(WWW_ROOT.'uploads/OKTB/'.$oktb_no))
					mkdir(WWW_ROOT.'uploads/OKTB/'.$oktb_no, 0777, true);

					//Passport file upload start
						
					if(isset($this->request->data['oktb_passport']['name']) && strlen($this->request->data['oktb_passport']['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['oktb_passport']['name']);
						$extension = $addr_ext[1];
						$passport = 'passport_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['oktb_passport']['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$passport);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$passport=$Odata[0]['oktb_details']['oktb_passport'];
					
						
					if(isset($this->request->data['oktb_visa']['name']) && strlen($this->request->data['oktb_visa']['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['oktb_visa']['name']);
						$extension = $addr_ext[1];
						$visa = 'visa_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['oktb_visa']['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$visa);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$visa=$Odata[0]['oktb_details']['oktb_visa'];
					
						
					if(isset($this->request->data['oktb_from_ticket']['name']) && strlen($this->request->data['oktb_from_ticket']['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['oktb_from_ticket']['name']);
						$extension = $addr_ext[1];
						$from_ticket = 'from_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['oktb_from_ticket']['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$from_ticket);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$from_ticket=$Odata[0]['oktb_details']['oktb_from_ticket'];
					
						
					if(isset($this->request->data['oktb_to_ticket']['name']) && strlen($this->request->data['oktb_to_ticket']['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['oktb_to_ticket']['name']);
						$extension = $addr_ext[1];
						$to_ticket = 'to_ticket_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['oktb_to_ticket']['tmp_name'], WWW_ROOT.'uploads/OKTB/'.$oktb_no.'/'.$to_ticket);
					}else
					$to_ticket=$Odata[0]['oktb_details']['oktb_to_ticket'];

					$name =$this->request->data['oktb_name'];
					$pnr = $this->request->data['oktb_pnr'];
					
					//$airline =$this->request->data['oktb_airline_name'];
					//$amount =$this->request->data['oktb_airline_amount'];
					$passportno = $this->request->data['oktb_passportno'];
					
					$this->User->useTable ='oktb_details';
					$this->User->query('Update oktb_details set oktb_name = "'.$name.'",oktb_pnr = "'.$pnr.'",oktb_passport = "'.$passport.'",oktb_passportno = "'.$passportno.'",oktb_visa = "'.$visa.'",oktb_from_ticket = "'.$from_ticket.'", oktb_to_ticket = "'.$to_ticket.'" Where oktb_no = "'.$oktb_no.'"');
				
				}
			$msg ='';			
			
			$this->Session->setFlash(__('OK to Board Application updated successfully'));
		
			$this->autoRender = false;
			$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
		}
	}
	
	public function getAirline(){
		$this->autoRender = false;
		$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
		//$this->set('airline', $airline);
		$html = "";
		foreach($airline as $k=>$a)
		$html .= "<option value = '".$k."'>".$a."</option>";
		
		return $html;
	}
	

public function urgAirline(){
$this->Relation->useTable = "";
		$this->Relation->useTable = 'oktb_airline';
$result=$this->Relation->query("Select * From oktb_airline Where status = 2");
		$data =array();
		$data['select']='Select';

		foreach ($result as $row)
		{
		  $data[$row['oktb_airline']['a_id']] =$row['oktb_airline']['a_name'];
		}
return $data;
}
public function getUrgAirline(){
		$this->autoRender = false;


		$airline=$this->urgAirline();
		//$this->set('airline', $airline);
		$html = "";
		foreach($airline as $k=>$a)
		$html .= "<option value = '".$k."'>".$a."</option>";
		
		return $html;
	}
	
	public function oktb(){
		$this->autoRender = false;
		$this->render('oktb'); 
	}
	
	public function group_oktb(){
		$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
		$this->set('airline', $airline);
		$userid=$this->UserAuth->getUserId(); $urgCount = array(); $uCount =2;
		$urgCount = $this->User->query('Select * From agent_settings Where agent_id = '.$userid.' and a_key = "urgent_date" and status = 1');
		if(count($urgCount) > 0){
			$uCount = $urgCount[0]['agent_settings']['a_value'];
		}
		$this->set('uCount',$uCount);
		
		$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
		$this->set('airline', $airline);
		
		$userId=$this->UserAuth->getUserId();
		$currency = $this->currency_val($userId);
		$this->set('currency',$currency);
		
		$this->autoRender = false;
		$this->render('group_oktb');
	}
	
 	public function extension(){
 		if ($this->request -> isPost()) {
 			$userid=$this->UserAuth->getUserId();
 			$success = array(); $fail = array();
 			$ext = $this->User->query('Select * From agent_ext_cost Where user_id = '.$userid);
 			if(count($ext) > 0){
 				$extAmt = $ext[0]['agent_ext_cost']['cost'];
 			}else $extAmt = 0;
 			
 			$rowcount = $this->request->data['rowcount'];
 			
 			$wallet = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
 			if(count($wallet) > 0){
 				$wall = $wallet[0]['user_wallet']['amount'];
 			}else $wall = 0;
 			
 			for($i = 1; $i <= $rowcount; $i++){
 				$result = '';
 				if($this->request->data['passportno'.$i]!=null and $this->request->data['name'.$i] != null and $this->request->data['visa'.$i]['name'] != null )
				{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = ""; $name = ''; $date = '';
					$random =rand(111111,999999);
					$ext_no = 'GVE-'.$random;
						
					if(!file_exists(WWW_ROOT.'uploads/Extension'))
					mkdir(WWW_ROOT.'uploads/Extension', 0777, true);
					
					if(!file_exists(WWW_ROOT.'uploads/Extension/'.$ext_no))
					mkdir(WWW_ROOT.'uploads/Extension/'.$ext_no, 0777, true);
					
					if(isset($this->request->data['visa'.$i]['name']) && strlen($this->request->data['visa'.$i]['name']) > 0)
					{
						$addr_ext = explode('.',$this->request->data['visa'.$i]['name']);
						$extension = $addr_ext[1];
						$visa = 'visa_'.$addr_ext[0].$random.'.'.$addr_ext[1];
						move_uploaded_file($this->request->data['visa'.$i]['tmp_name'], WWW_ROOT.'uploads/Extension/'.$ext_no.'/'.$visa);
						//$this->request->data['User']['pfp'.$id]= $pfp_name;
					}else
					$visa='';
					
					
					$name = $this->request->data['name'.$i];
					$passport = $this->request->data['passportno'.$i];
					$date = date('Y-m-d H:i:s');
					$this->User->useTable = '';
					$this->User->useTable = 'extension';
					$this->User->query('Insert into extension(ext_name,ext_passportno,ext_visa,ext_date,ext_user_id,ext_no,ext_amt) Values ("'.$name.'","'.$passport.'","'.$visa.'","'.$date.'","'.$userid.'","'.$ext_no.'",'.$extAmt.')');
					
					$result = $this->apply_extension($ext_no,$wall);
					if(is_array($result) and $result[0] == true)
					{
						$success[count($success)] = $ext_no;
					}else
					{
						$fail[count($fail)]=$ext_no;
					}
				}
 			}
 			if(count($success) > 0)
 			$msg ="Your ". count($success) ." Application is successfully submitted. Amount required for processing these application will be deducted from your wallet.";
 			
 			///$msg = count($success) . ' Extensions Saved Successfully';
 			if(count($fail) > 0)
 			$msg ='Oops! '. count($fail). ' Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
 			
 			//$msg = count($fail). ' Extensions Not Saved';
 			
 			if(count($fail) > 0)
 			$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));
 			else
 			$this->Session->setFlash(__($msg));
 			
 			
			$this->autoRender =false;
			$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_extension'));
		
 		}
        	$this->autoRender = false;
        	$this->render('extension');
        }

        public function all_extension($pstatus =null ){
        	$userid=$this->UserAuth->getUserId();
        	if($this->UserAuth->getGroupName() == 'Admin')
			{
if($pstatus == null)
	        	$data = $this->User->query('Select * From extension join users on users.id = extension.ext_user_id Where extension.ext_status = 1 and users.status = 1 Order by extension.ext_date desc');
else
$data = $this->User->query('Select * From extension join users on users.id = extension.ext_user_id Where extension.ext_status = 1 and ext_payment_status = '.$pstatus.' and users.status = 1 Order by extension.ext_date desc');

		        $bData = Set::combine($data, '{n}.extension.ext_id','{n}.users.currency');
				foreach($bData as $k=>$v){ 
					$currency[$k] = $this->get_master_data('currency_master',$v,'currency_id','currency_code');
					if(count($currency) == 0) $currency[$k] = 'INR';  
				}
				
			}else{
if($pstatus == null)
				$data = $this->User->query('Select * From extension Where ext_user_id = '.$userid.' and ext_status = 1 Order by ext_date desc');
else
$data = $this->User->query('Select * From extension Where ext_user_id = '.$userid.' and ext_payment_status = '.$pstatus.' and ext_status = 1 Order by ext_date desc');
				$userData = $this->User->query('Select * From users Where id = '.$userid);	
					if(count($userData) == 0){
						 $currency = 'INR'; 
					 }else{
						$currency = $this->get_master_data('currency_master',$userData[0]['users']['currency'],'currency_id','currency_code');
					}
			}
			$this->set('currency',$currency);
        	$this->set('data',$data);
	        if(count($data) > 0){
				$query = $this->User->query('Select * From tr_status_master Where status = 1');
				$result = Set::combine($query, '{n}.tr_status_master.tr_status_id', '{n}.tr_status_master.tr_status');
				$this->set('trans',$result);
			}
			
			
					
        	$this->autoRender = false;
        	$this->render('all_extension');
        }
      
function apply_extension($ext_no,$wall=0)
	{
		$this->autoRender = false;
		$userId = $this->UserAuth->getUserId();
		$wallet = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
 			if(count($wallet) > 0){
 				$wall = $wallet[0]['user_wallet']['amount'];
 			}else $wall = 0;	
 			
		$res =$this->User->query('select * from extension where ext_no ="'.$ext_no.'"');
		if(count($res)>0 and $res[0]['extension']['ext_status'] == 1)
		{
			$amt =$res[0]['extension']['ext_amt'];
			//$amt = 100;
			$userData=array();
			if($amt <= $wall)
			{
				$tamt =$wall - $amt;
				$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
				$this->User->query('Update extension set ext_payment_status = 2,ext_payment_date="'.date('Y-m-d H:i:s').'" Where ext_id = '.$res[0]['extension']['ext_id']);
				$this->User->query('Insert into ext_transactions(user_id,ext_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['extension']['ext_id'].',"'.$amt.'","'.$wall.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
				//$data_id = $this->User->query('Select * from users Where id = '.$userId);
				return array(true,$tamt);
			}else
			{
				return false;
			}
		}else
		return false;
	}
	
	public function delete_ext()
	{
		if(strlen($_POST['id']) > 0 && $_POST['id'] != 0){
			$this->User->query('Update extension set ext_status = 0 Where ext_id = '.$_POST['id']);
			echo 'Success';
		}else echo 'Error';
			$this->autoRender = false;
	}
	
	public function delete_ext_date()
	{
		if(strlen($_POST['id']) > 0 && $_POST['id'] != 0){
			$this->User->query('Update visa_app_group set date_of_entry = null, last_doe = null Where group_id = '.$_POST['id']);
			echo 'Success';
		}else echo 'Error';
			$this->autoRender = false;
	}
	
	public function extCost($agent_val = null,$cost = ''){
		
			$data = $this->User->query('Select * From users Where status = 1 and id <> 1');
			if(count($data) > 0){
				$agent['select'] = 'Select';
				foreach($data as $d){
					$eData = array();
					$agent[$d['users']['id']] = $d['users']['username'];
					$currency = $this->get_master_data('currency_master',$d['users']['currency'],'currency_id','currency_code');
					if(count($currency) == 0) $currency = 'INR';  
					$eData = $this->User->query('Select cost From agent_ext_cost Where user_id = '.$d['users']['id']);
					if(count($eData) == 0 || !isset($eData[0]['agent_ext_cost']['cost']) || $eData[0]['agent_ext_cost']['cost'] == null) $price = 0; else $price = $eData[0]['agent_ext_cost']['cost'];
					$agent[$d['users']['id']] .= ' - '.$price.' '.$currency;
				}
			}
		
		$this->set('ext_cost',$cost);
		$this->set('agent_val',$agent_val);
		$this->set('agent',$agent);
		$this->autoRender = false;
		$this->render('ext_cost_settings');	
	}
	
	 public function save_ext_cost()
        {
        	$this->autoRender = false;
        	if ($this->request ->isPost()) {
        		$this->User->set($this->data);
				if ($this->User->ExtCostValidate())
        		{
        			//$user_id = $this->request->data['User']['user_id'];
        			$this->User->useTable = 'agent_ext_cost';
        			$ans = $this->User->query('Select * From agent_ext_cost Where user_id ='. $this->request->data['User']['agent'].' and status=1');
        			
        			if(count($ans) > 0)
        			{
        				$date_cr =date('d-m-Y');
        				$this->User->query('update agent_ext_cost set cost = "'.$this->request->data['User']['ext_cost'].'", date="'.date('Y-m-d H:i:s').'" where user_id = '.$this->request->data['User']['agent']);
        			}
        			else{
        			//$this->User->save($this->request->data);
        			$this->User->query('INSERT INTO agent_ext_cost(user_id,cost,date) VALUES ("'.$this->request->data['User']['agent'].'","'.$this->request->data['User']['ext_cost'].'","'.date('Y-m-d H:i:s').'")');
        			}

$this->Session->setFlash(__('Extension Cost Updated!!'));
$this->extCost();

}else{
	$this->extCost($this->request->data['User']['agent'],$this->request->data['User']['ext_cost']);
}
}else
{
//$this->autoRender =false;
$this->extCost();
}
}
	
public function apply_extension_old($ext_no)
	{
		$wallet =0;	$userData=array();
		$userId = $this->UserAuth->getUserId();
		$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
			if(count($userData) > 0)
			{
			 $wallet =$userData[0]['user_wallet']['amount']; 
			}
		
		$res =$this->User->query('select * from extension where ext_no ="'.$ext_no.'"');
		if(count($res)>0 and $res[0]['extension']['ext_status'] == 1)
		{
			if($res[0]['extension']['ext_payment_status'] == 1)
			{
				$amt =$res[0]['extension']['ext_amt'];
				if($wallet > 0)
				{
				 //$wallet =$userData[0]['user_wallet']['amount'];
	
				if($amt <= $wallet)
				{
					$tamt =$wallet -$amt;
					$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
					$this->User->query('Update extension set ext_payment_status = 2,ext_payment_date="'.date('Y-m-d H:i:s').'" Where ext_user_id = '.$userId.' and ext_id = '.$res[0]['extension']['ext_id']);
					$this->User->query('Insert into ext_transactions(user_id,ext_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['extension']['ext_id'].',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
					$data_id = $this->User->query('Select * from users Where id = '.$userId);
					//exit;
					//$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$res[0]['oktb_details']['oktb_airline_name']);
					//$res[0]['oktb_details']['airline_name'] =$airline[0]['oktb_airline']['a_name'];
					$this->User->sendApplyExtMail($data_id[0],$this->visa_From_email(),$res[0]);
					$zip =$this->create_ext_zip_excel($ext_no);
					$zip['id']=$res[0]['extension']['ext_id'];
					$this->User->sendAdminApplyExtMail($data_id[0],$this->visa_From_email(),$res[0],$zip);
					$msg ="Your Application is successfully submitted. Amount required for processing these application will be deducted from your wallet.";
					$this->Session->setFlash(__($msg));
					$wallet =$tamt;
					
				}else
				{
					$msg ='Oops! Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}
			}else
			{
					$msg ='Oops! Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
			}
				}else 
				{
				$msg ='You Have already applied for this Application.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}}else
				{
					$msg ='Oops! No Application found with this Extension Number. Please Check Your Extension Number Again.';
					$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
				}
			
		$this->autoRender =false;
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_extension'));
	}
	
public function create_ext_zip_excel($ext_no =0)
	{
	 $this->autoRender = false;
	 $zip_file_name='';
	 $src = WWW_ROOT.'uploads/Extension/'.$ext_no;

	 if(!is_dir($src)){
	 	$this->Session->setFlash(__('Download folder does not exist'));
	 } else{
	 	$source = $src;


	 	//code for zip
	 	$zip_file_name = WWW_ROOT.'zip/Extension/'.$ext_no.'.zip';

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
	 				//print_r($file); exit;

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
	 return $res_new;
	}
	
	public function extension_date(){
		/*if($eid != null){
			$groupData = $this->User->query('Select group_no From visa_app_group Where group_id = '.$eid);
			$this->set('opt_val',$groupData[0]['visa_app_group']['group_no']);
		}*/
			$visa_extendable = $this->User->query('Select * From visa_type_master Where ext_status = 1');
			$evisa = array();
			$evisa = Set::combine($visa_extendable, '{n}.visa_type_master.visa_type_id', '{n}.visa_type_master.visa_type_id');
			$eVisa = implode(',',$evisa);
			$extend1 = array('select'=>'Select');
			$data = $this->User->query('SELECT a.group_no,a.group_id,b.first_name,b.last_name,c.username FROM visa_app_group as a join visa_tbl as b on a.group_id = b.group_id join users as c on a.user_id = c.id WHERE a.visa_type in ('.$eVisa.') and a.tent_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 3 MONTH)  and a.upload_status = 1 and a.status = 1 and a.tr_status > 1 group by b.group_id');
			$extend = Set::combine($data, '{n}.a.group_no', array('{0} - {1} {2} ( {3} )', '{n}.c.username','{n}.b.first_name', '{n}.b.last_name','{n}.a.group_no'));
			$extend2 = array('other'=>'Other');
			$extend = Set::merge($extend1,$extend2,$extend);
		
			$this->set('extend',$extend);
	}

	public function getVisaData($eid=null){
		$this->autoRender = false;
		if(!empty($_POST['visaId'])){
			$visa = $_POST['visaId'];
			$data = $this->User->query('Select * From visa_app_group Where group_no = "'.$visa.'"');
			if(count($data) > 0){
			$vData = Set::combine($data, '{n}.visa_app_group.group_id','{n}.visa_app_group');
			$this->set('visa',$data[0]['visa_app_group']['group_id']);
			$this->set('data',$vData);
			$cdata = '';
			$cdata = $this->User->query('Select currency_master.currency_code From users join currency_master on currency_master.currency_id = users.currency Where users.id = '.$data[0]['visa_app_group']['user_id']);
			//echo '<pre>'; print_r($vData); exit;
			if(is_array($cdata) && strlen($cdata[0]['currency_master']['currency_code']))  $curr = $cdata[0]['currency_master']['currency_code']; else $curr = 'INR';
			$this->set('currency',$curr);
			$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
			$this->set('visa_type',$visa_type);
			$this->render('Users/visa_data');
			}else{
				echo 'Error';
			}
		}	
	}
	
public function editExtCost($eid=null){
		$this->autoRender = false;
		if($eid != null){
			$visa = $eid;
			$data = $this->User->query('Select * From visa_app_group Where group_no = "'.$visa.'"');
			if(count($data) > 0){
			$vData = Set::combine($data, '{n}.visa_app_group.group_id','{n}.visa_app_group');
			$this->set('visa',$data[0]['visa_app_group']['group_id']);
			$this->set('data',$vData);
			$cdata = '';
			$cdata = $this->User->query('Select currency_master.currency_code From users join currency_master on currency_master.currency_id = users.currency Where users.id = '.$data[0]['visa_app_group']['user_id']);
			//echo '<pre>'; print_r($vData); exit;
			if(is_array($cdata) && strlen($cdata[0]['currency_master']['currency_code']))  $curr = $cdata[0]['currency_master']['currency_code']; else $curr = 'INR';
			$this->set('currency',$curr);
			$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
			$this->set('visa_type',$visa_type);
			$this->set('viewhead',1);
			$this->render('Users/visa_data');
			}else{
				$this->Session->setFlash(__('Extension Cannot be edited'));
				$this->redirect('/usermgmt/users/all_visa_extend_data');
			}
		}	
	}
	
	public function all_visa_extend_data(){
		$this->autoRender = false;
		$data = $this->User->query('Select a.group_no,a.group_id,a.visa_fee,a.visa_type,a.user_id,a.tent_date,b.currency,b.username,a.date_of_entry,a.last_doe,c.first_name,c.last_name From visa_app_group as a join users as b on a.user_id = b.id join visa_tbl as c on a.group_id = c.group_id Where a.date_of_entry is not null and a.date_of_entry <> "" Group by c.group_id Order by a.date_of_entry desc ');
		//$vData = Set::combine($data, '{n}.a.group_id','{n}.a');
		
		if(count($data) > 0){
		$bData = Set::combine($data, '{n}.a.group_id','{n}.b.currency');
		foreach($bData as $k=>$v){ 
				$currency[$k] = $this->get_master_data('currency_master',$v,'currency_id','currency_code');
				if(count($currency) == 0) $currency[$k] = 'INR';  
			}
		//$username = Set::combine($data, '{n}.a.group_id','{n}.b.username');
		$this->set('data',$data);
		
		$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
		$this->set('visa_type',$visa_type);
	//	echo '<pre>'; print_r(); exit;
			
			$this->set('currency',$currency);
		}
			$this->render('all_visa_extend_data');
	}
	
	public function save_visa_data(){
		$this->autoRender = false;
		if ($this->request -> isPost()) {
			$this->User->query('Update visa_app_group set date_of_entry = "'.$this->request->data['User']['d_o_e'].'" , last_doe = "'.$this->request->data['User']['last_doe'].'" Where group_id = '.$this->request->data['User']['visa']);
			$this->Session->setFlash(__('Date Of Entry is Saved For this Application'));
		}
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_visa_extend_data'));
	}
	
	public function agentSetting(){
		
			$data = $this->User->query('Select * From users Where status = 1 and id <> 1');
			if(count($data) > 0){
				$agent['select'] = 'Select';
				foreach($data as $d){
					$eData = array();
					$agent[$d['users']['id']] = $d['users']['username'];
				}
			}
		$currency=$this->get_currency_dropdown('currency_id', 'currency','currency_code','currency_master');
		$this->set('currency', $currency);
		
		$this->set('agent',$agent);
		$this->autoRender = false;
		$this->render('agent_settings');	
	}
	
	public function save_settings(){
		$this->autoRender = false;
		if ($this->request->isPost()) {
			$setting = $this->request->data['User']['type'];
			$userId = $this->request->data['User']['agent'];
			if($setting == 0){
				$this->User->query('Update users set currency = '.$this->request->data['User']['currency'].' Where id = '.$userId);
			}else{
				$wallet = 0;
				$data = $this->User->query('Select * from user_wallet Where user_id = '.$userId); 
				if(count($data) > 0){
					$wallet = $data[0]['user_wallet']['amount'];
				}
				$amount = '-'.$this->request->data['User']['amount'];
				$total = $wallet - $this->request->data['User']['amount'];
				$date = date('Y-m-d H:i:s');
				$this->User->query('Update user_wallet set amount = '.$total.' Where user_id = '.$userId );
				$this->User->query('Insert into new_transaction(user_id,bank_type,amt,bank_name,bank_branch,country,account_no,trans_mode,trans_date,remarks,opening_bal,closing_bal,status,admin_status,trans_status,payment_status,date,app_date) values('.$userId.',1,'.$amount.',"No Bank","No Branch",1,"No Account Number",1,"'.$date.'","'.$this->request->data['User']['narration'].'",'.$wallet.','.$total.',1,1,"A",0,"'.$date.'","'.$date.'") ');
			}
			$this->Session->setFlash(__('Data Saved Successfully'));
			$this->redirect('agentSetting');
			
		}else $this->redirect('agentSetting');
	}
	
	/*public function ext_logs(){
		$this->autoRender = false;
		$data = $this->User->query('Select a.group_no,a.group_id,a.visa_fee,a.visa_type,a.user_id,a.tent_date,a.date_of_entry,a.last_doe,c.first_name,c.last_name From visa_app_group as a join visa_tbl as c on a.group_id = c.group_id Where a.date_of_entry is not null and a.date_of_entry <> "" Group by c.group_id Order by a.date_of_entry desc ');
		//$vData = Set::combine($data, '{n}.a.group_id','{n}.a');
		
		if(count($data) > 0){
		$bData = $this->User->query('Select currency Froms users Where id = '.)
				$currency[$k] = $this->get_master_data('currency_master',$v,'currency_id','currency_code');
				if(count($currency) == 0) $currency[$k] = 'INR';  
		
		//$username = Set::combine($data, '{n}.a.group_id','{n}.b.username');
		$this->set('data',$data);
		
		$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
		$this->set('visa_type',$visa_type);
	//	echo '<pre>'; print_r(); exit;
			
			$this->set('currency',$currency);
		}
			$this->render('all_visa_extend_data');
	
	}*/
public function approve_ext(){
		if(!empty($_POST['id'])){
			$this->User->query('Update extension set ext_payment_status = 5  Where ext_id = '.$_POST['id']);
			echo 'Success';
		}else echo 'Error';
			$this->autoRender = false;
	}

}//End//