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
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class UsersController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Usermgmt.User', 'Usermgmt.UserGroup','UserMeta','Relation','Admin');
	//var $helpers = array('NumberToWord');
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
			$users=$this->User->find('all', array('conditions'=>array('status'=>1,'approve'=>0,'user_group_id'=>2),'order'=>'User.id desc'));
		}else
		$users=$this->User->find('all', array('conditions'=>array('status'=>1,'user_group_id'=>2),'order'=>'User.id desc'));

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
				//print_r($user); exit;
				if (empty($user)) {
					$user = $this->User->findByEmail($email);
					if (empty($user)) {
						$this->Session->setFlash(__('Incorrect Email/Username or Password'));
						return;
					}
				}
			//	print_r($user); exit;
				// check for inactive account
				if ($user['User']['id'] != 1 and $user['User']['active']==0) {
					$this->Session->setFlash(__('Your registration has not been Confirmed please verify your email or contact to Administrator'));
					return;
				}
				if ($user['User']['id'] != 1 and $user['User']['approve']==0) {
					$this->Session->setFlash(__('Your registration has not been Approved. please verify your email or contact to Administrator'));
					return;
				}
				$hashed = md5($password);
				if ($user['User']['password'] === $hashed) {
				//echo $user['User']['user_group_id']; exit;
				$arr_chk = array(1,2,3);
					if(!in_array($user['User']['user_group_id'],$arr_chk)){
						$roleData1 = $this->User->query('Select * From user_roles Where role_id = '.$user['User']['user_group_id']);
						$role1 = Set::combine($roleData1,'{n}.user_roles.role_id','{n}.user_roles');
						$roleData2 = $this->User->query('Select * From user_roles_meta Where role_id = '.$user['User']['user_group_id']);
						$role2 = Set::combine($roleData2,'{n}.user_roles_meta.meta_key','{n}.user_roles_meta.meta_value');
						$this->Session->write('role1', $roleData1[0]['user_roles']);
						$this->Session->write('role2', $role2);
						//echo '<pre>'; print_r($this->Session->read('role1')); print_r($this->Session->read('role2')); exit;
					}
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
					//print_r($_SESSION); exit;
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
	public function changeUserPassword($Id=null,$role=0) {
		if (!empty($Id)) {
			if($role == 1){
				$data = $this->User->query('Select users.id From users join user_roles on users.user_group_id = user_roles.role_id Where users.user_group_id = '.$Id);
				$userId = $data[0]['users']['id'];
			}else{
				$userId = $Id;
			} 
			$name=$this->User->getNameById($userId);
			$this->set('name', $name);
			if ($this->request -> isPost()) {
				$this->User->set($this->data);
				if($this->User->RegisterValidate()) {
					$this->User->id=$userId;
					$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
					$this->User->save($this->request->data,false);
					if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Change Password","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        			}
					$this->Session->setFlash(__('Password for %s changed successfully', $name));
					if($role != 1) $this->redirect('/allUsers'); else $this->redirect('/Users/all_user_roles');
				}
			}
		} else {
				if($role != 1) $this->redirect('/allUsers'); else $this->redirect('/Users/all_user_roles');
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
				if($this->UserAuth->getGroupName() != 'Admin') {
					$this->request->data['User']['role_id']= $this->Session->read('role1.role_id');
				}
				$this->request->data['User']['approve']=1;
				$this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password']);
				date_default_timezone_set('Asia/Kolkata');
				$this->request->data['User']['last_login'] = date('d-m-Y h:i:s A');
				$this->User->save($this->request->data,false);
				$userId=$this->User->getLastInsertID();
				
			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Add","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
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
			
			$country=$this->get_dropdown('country_id', 'country','country_master');
			$this->set('country', $country);
			
			if ($this->request-> isPut()) {
				$this->User->set($this->data);
				if ($this->User->RegisterValidate()) {
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
						
				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Edit","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
					$this->User->useTable = "";
					$this->User->useTable = 'user_meta';
					foreach($res as $key=>$value){
						$this->User->query("Update user_meta set meta_value = '".$value."' Where user_id = ".$userId." and meta_key = '".$key."'");
					}
					$this->Session->setFlash(__('User is successfully updated'));
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
				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Delete","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
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

		$is_user = ($user['User']['user_group_id'] == 2) ? true : false;
		if($is_user){
			$data = $this->get_outstanding($userId);

		} else {
			$data = '';
		}
		
		if(is_array($data)){
		$data[1] = ($data[1] > 0) ? $data[1] : 0;
		$html = "<div style='padding: 10px 10px;' class='alert alert-info'><marquee scrolldelay='150' direction='left'>Your outstanding amount is $data[3] <b>$data[1]</b>. Your Credit limit is $data[3] <b>$data[2]</b>.</marquee></div>";
		} else {
		$html = '';
		}
		$this->set('outstanding', $html);

		$extData = $this->User->query('Select * From visa_app_group Where user_id = '.$userId. ' and last_doe = "'.date('Y-m-d').'"');
		if(count($extData) > 0) $this->set('extension',count($extData)); else $this->set('extension',0);
		$currency = $this->currency_val($userId);
		$this->set('currency',$currency);
		$count = $this->get_count($userId);
		$this->set('count',$count);
	}
	
	public function get_outstanding($userId){
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
	
	public function get_count($userId){
		$user_data  = $this->User->query('Select id From users Where status=1 and username <> "admin"');
		$cnt_data['usr_cnt'] = $this->User->getAffectedRows($user_data);

		$user_app  = $this->User->query('Select id From users Where status=1 and approve = 0 and username <> "admin"');
		$cnt_data['usr_app'] = $this->User->getAffectedRows($user_app);

		if($this->UserAuth->getGroupName() != 'User'){
			$user_trans  = $this->User->query('Select trans_id From new_transaction Where status = 1');
		}else if($this->UserAuth->getGroupName() == 'User') $user_trans  = $this->User->query('Select trans_id From new_transaction Where user_id = '.$userId.' and status = 1');
		$cnt_data['user_trans'] = $this->User->getAffectedRows($user_trans);
		

		if($this->UserAuth->getGroupName() != 'User')
		$user_transapp  = $this->User->query('Select trans_id From new_transaction Where status = 1 and trans_status="P"');
		else
		$user_transapp  = $this->User->query('Select trans_id From new_transaction Where user_id = '.$userId.' and status = 1 and trans_status="P"');
		$cnt_data['user_transapp'] = $this->User->getAffectedRows($user_transapp);

		if($this->UserAuth->getGroupName() != 'User')
	    	if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
			$visa_app  = $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status =1 and tr_status  > 1 and visa_type in ('.$this->Session->read('role1.visa_type').')');
	    	else
	    	$visa_app  = $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status =1 and tr_status  > 1');
		else  $visa_app  = $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1 and upload_status =1 and tr_status  > 1');
		$cnt_data['visa_app'] = $this->User->getAffectedRows($visa_app);
			
		if($this->UserAuth->getGroupName() == 'Admin')
	    $app_apply = $this->User->query('Select group_id From visa_app_group Where status = 1 and tr_status=2');
		else $app_apply  = $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=2');
		$cnt_data['app_apply'] = $this->User->getAffectedRows($app_apply);

		if($this->UserAuth->getGroupName() != 'User'){
			//if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
				//$app_apply = $this->User->query('Select ext_details.ext_id From ext_details join visa_app_group on ext_details.ext_group_id = visa_app_group.group_id Where visa_app_group.visa_type in ('.$this->Session->read('role1.visa_type').') and ext_details.ext_status = 1 ');
				//else 
				$app_apply = $this->User->query('Select ext_id From ext_details Where ext_status = 1');
			}else $app_apply  = $this->User->query('Select ext_id From ext_details Where ext_user_id = '.$userId.' and ext_status = 1');
		$cnt_data['all_ext'] = $this->User->getAffectedRows($app_apply);
		
		if($this->UserAuth->getGroupName() != 'User'){
				//if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
				//$app_apply = $this->User->query('Select ext_details.ext_id From ext_details join visa_app_group on ext_details.ext_group_id = visa_app_group.group_id Where visa_app_group.visa_type in ('.$this->Session->read('role1.visa_type').') and ext_details.ext_payment_status = 2 and ext_details.ext_status = 1 ');
				//else 
				$app_apply = $this->User->query('Select ext_id From ext_details Where ext_payment_status =2 and ext_status = 1 ');
		}else $app_apply  = $this->User->query('Select ext_id From ext_details Where ext_user_id = '.$userId.' and ext_payment_status = 2 and ext_status = 1');
		$cnt_data['ext_in_process'] = $this->User->getAffectedRows($app_apply);
		
		if($this->UserAuth->getGroupName() != 'User'){
			//if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.extension') && $this->Session->read('role1.extension') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
		//$app_apply = $this->User->query('Select ext_details.ext_id From ext_details join visa_app_group on ext_details.ext_group_id = visa_app_group.group_id Where visa_app_group.visa_type in ('.$this->Session->read('role1.visa_type').') and ext_details.ext_payment_status =5 and ext_details.ext_status = 1 ');
		//else 
		$app_apply = $this->User->query('Select ext_id From ext_details Where ext_payment_status =5 and ext_status = 1 ');
		}else $app_apply  = $this->User->query('Select ext_id From ext_details Where ext_user_id = '.$userId.' and ext_payment_status = 5 and ext_status = 1');
		$cnt_data['ext_in_approve'] = $this->User->getAffectedRows($app_apply);
		
		if($this->UserAuth->getGroupName() != 'User'){
			if($this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
			$app_process  = $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status =1 and tr_status  = 2 and visa_type in ('.$this->Session->read('role1.visa_type').')');
	    	else
			$app_process= $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status = 1 and tr_status=2');
		}else $app_process= $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1  and upload_status = 1 and tr_status=2');
		$cnt_data['app_process'] = $this->User->getAffectedRows($app_process);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_hold= $this->User->query('Select group_id From visa_app_group Where status = 1 and tr_status=3');
		else $app_hold= $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=3');
		$cnt_data['app_hold'] = $this->User->getAffectedRows($app_hold);

		if($this->UserAuth->getGroupName() == 'Admin')
		$app_ihold= $this->User->query('Select group_id From visa_app_group Where status = 1 and tr_status=4');
		else $app_ihold= $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=4');
		$cnt_data['app_ihold'] = $this->User->getAffectedRows($app_ihold);

		if($this->UserAuth->getGroupName() != 'User'){
		if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.visa') && $this->Session->read('role1.visa') == 1 && $this->Session->read('role1.visa_type') && strlen($this->Session->read('role1.visa_type')) > 0)
			$app_approve  = $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status =1 and tr_status  = 5 and visa_type in ('.$this->Session->read('role1.visa_type').')');
	    	else
		$app_approve  = $this->User->query('Select group_id From visa_app_group Where status = 1 and upload_status =1 and tr_status=5');
		}else $app_approve  = $this->User->query('Select group_id From visa_app_group Where user_id = '.$userId.' and status = 1 and tr_status=5');
		$cnt_data['app_approve'] = $this->User->getAffectedRows($app_approve);


        if($this->UserAuth->getGroupName() != 'User'){
        	if( $this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0){
       		$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is null and oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').')');
        	}else
			$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is null');
        }else $app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=5  and oktb_group_no is null');
		        $cnt_data['oktb_approve'] = $this->User->getAffectedRows($app_approve);
        
		//echo $this->Session->read('role1.oktb_airline'); exit;
		if($this->UserAuth->getGroupName() != 'User'){
			if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
			$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is null and oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').')');
			else
			$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is null');
		}else $app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=2 and oktb_group_no is null');
		$cnt_data['oktb_process'] = $this->User->getAffectedRows($app_approve);

  		if($this->UserAuth->getGroupName() != 'User'){ 
  			if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0){
			$app_approve  = $this->User->query('Select oktb_group_no From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null and oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') group by oktb_group_no');
  		}else
  			$app_approve  = $this->User->query('Select oktb_group_no From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
  		}else $app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
		$cnt_data['group_oktb_approve'] = $this->User->getAffectedRows($app_approve);
		
		$grpdata = $this->User->query('Select oktb_group_no From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
  		$gdata = Set::combine($grpdata,'{n}.oktb_details.oktb_group_no','{n}.oktb_details.oktb_group_no');
  		$group_appr = implode('","',$gdata);
  		
		if($this->UserAuth->getGroupName() != 'User'){
			if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
			$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status= 2 and oktb_group_no not in ("'.$group_appr.'") and oktb_group_no is not null and oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') group by oktb_group_no');
						else
			$app_approve  = $this->User->query('Select oktb_id From oktb_details Where oktb_status = 1 and oktb_payment_status= 2 and oktb_group_no not in ("'.$group_appr.'") and oktb_group_no is not null group by oktb_group_no');
		}else $app_approve  = $this->User->query('Select oktb_group_no From oktb_details Where oktb_user_id = '.$userId.' and oktb_status = 1 and oktb_payment_status=2 and oktb_group_no not in ("'.$group_appr.'") and oktb_group_no is not null group by oktb_group_no');
		$cnt_data['group_oktb_process'] = $this->User->getAffectedRows($app_approve);
		
		$grp_cnt  = $this->User->query('Select id From user_groups');
		$cnt_data['grp_cnt'] = $this->User->getAffectedRows($grp_cnt);

		$trans_app1 = $this->User->query('Select trans_id From new_transaction Where user_id = '.$userId.' and trans_status = "A" and status = 1 order by trans_date desc');
		$visa_app1 = $this->User->query('Select trans_id From visa_transactions Where user_id = '.$userId.' and status = 1 order by date desc');
		$cnt_data['trans_cnt'] = $this->User->getAffectedRows($trans_app1) + $this->User->getAffectedRows($visa_app1);

		$data = $this->User->query('Select wallet_id,amount From user_wallet Where user_id = '.$userId);
		$count  = $this->User->query('Select trans_id From new_transaction Where user_id = '.$userId.' and status = 1');
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
			
		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Change Status","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
			if($status == 1){
				$data = $this->User->findById($userId);
					
				$this->User->sendApprovalMail($data,$this->From_email());
				echo "<a href='#' onclick = 'approve({$userId},0)'><button id = 'appr_button".$userId."' title= 'Disapprove User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$userId."' class='icon-thumbs-down'></i></span></button></a>";
			}else
			echo "<a href='#' onclick = 'approve({$userId},1)'><button id = 'appr_button".$userId."' title= 'Approve User' type='submit' class='btn btn-round-min btn-success space'><span><i id = 'appr_i".$userId."' class='icon-thumbs-up'></i></span></button></a>";

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

		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Bank Transaction" and action_type = "Change Status" and trans_id = "'.$transId.'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,trans_id,prev_value,updated_value,date,status) values("'.$roleId.'","Bank Transaction","Change Status","'.$transId.'","P","'.$status.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
			$this->autoRender = false;
			if($status == 'A'){
				$userdata = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
				if(count($userdata) > 0){
					$amount = $userdata[0]['user_wallet']['amount'] + $amt;
					$this->User->query('Update new_transaction set opening_bal ="'.$userdata[0]['user_wallet']['amount'].'" , closing_bal ="'.$amount.'" , app_date = "'.date('d-m-Y H:i:s').'" Where trans_id ='.$transId);
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

public function oktb_user_From_email($oktb_airline = null) {
		$email_val = ''; $email = array(); 
		if($oktb_airline != null){
			$this->Relation->useTable = "";
			$this->Relation->useTable = 'user_roles';
			$data = $this->Relation->query("Select role_email,role_id From user_roles Where oktb = 1 and role_status = 1 and (oktb_airline LIKE ('%,".$oktb_airline.",%') OR oktb_airline LIKE ('%,".$oktb_airline."') OR oktb_airline LIKE ('".$oktb_airline.",%') OR oktb_airline = '' OR oktb_airline = ".$oktb_airline.")");
			$email = Set::combine($data,'{n}.user_roles.role_id','{n}.user_roles.role_email');
			}
			$ad_email = $this->oktb_From_email();
			$all_email = array_merge($email,array(count($email)=>$ad_email));
			$all_email = array_unique($all_email);
			$email_val = implode(',',$all_email);
			if(strlen($email_val) > 0) {
			return $email_val;
		}
	}
	
	public function visa_From_email() {
		$this->Relation->useTable = "";
		$this->Relation->useTable = 'admin_settings';
		$data = $this->Relation->query("Select a_value From admin_settings Where a_key = 'visa_from'");
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
			$trans[$i]['new_transaction']['by_admin'] = $data['User']['role_id'];
			
			$trans[$i]['new_transaction']['bank'] = $this->get_master_data('bank_master',$t['new_transaction']['bank_type'],'type_id','bank_type');
			$trans_mode_data = $t['new_transaction']['trans_mode'];
			$trans[$i]['new_transaction']['tr_mode'] = $this->get_master_data('tr_mode_master',$t['new_transaction']['trans_mode'],'tr_mode_id','tr_mode');
			$count_data = $t['new_transaction']['country'];
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
				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Bank Transaction" and action_type = "Delete" and trans_id = "'.$transId.'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,trans_id,date,status) values("'.$roleId.'","Bank Transaction","Delete","'.$transId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
			if ($this->User->query('Update new_transaction set status = 0 Where trans_id = '.$transId)) {
				$this->Session->setFlash(__('Transaction deleted successfully'));
			}
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
		
		
		if($this->UserAuth->getGroupName() != 'User'){
		$data = $this->User->query('Select id,username From users Where status = 1 and id != 1 and user_group_id = 2');
		$user = Set::combine($data,'{n}.users.id','{n}.users.username');
		$user = array('select'=>'Select') + $user;
		$this->set('agent', $user);
		}else{
		$userid=$this->UserAuth->getUserId(); $uCount = 2;
		$urgCount = $this->User->query('Select * From agent_settings Where agent_id = '.$userid.' and a_key = "urgent_date" and status = 1');
		if(count($urgCount) > 0){ $uCount = $urgCount[0]['agent_settings']['a_value'];	}
		$this->set('uCount',$uCount);
		}
		//print_r($user); exit;
		
		//$userId=$this->UserAuth->getUserId();
		//$currency = $this->currency_val($userId);
		//$this->set('currency',$currency);
		
		$this->autoRender = false;
		$this->render('apply_oktb');
	}

	public function get_airline_amt(){
		$this->autoRender =false;
		//echo $_POST['value']; exit;
		if(isset($_POST['value']) && strlen($_POST['value']) > 0){
			$amount =0;
			$data = $this->User->query('Select * From oktb_airline Where a_id = '.$_POST['value']);
				
			if(count($data) > 0){
				$amount =$data[0]['oktb_airline']['a_sprice'];
				if(isset($_POST['agent']) && strlen($_POST['agent']) > 0 && $_POST['agent'] != 'select' && $_POST['agent'] != 'undefined') $userId = $_POST['agent']; else $userId = $this->UserAuth->getUserId();
				$data1 = $this->User->query('Select * From agent_airline_cost Where air_id = '.$_POST['value'].' and user_id = '.$userId.' and a_status = 1' );
				if(count($data1) > 0)
				{
					$amount = (strlen($data1[0]['agent_airline_cost']['air_sprice']) > 0 && $data1[0]['agent_airline_cost']['air_sprice'] != null) ? $data1[0]['agent_airline_cost']['air_sprice'] : $data[0]['oktb_airline']['a_sprice'];
				}
			}
			echo $amount;
		}
	}

	public function save_oktb()
	{
		$this->autoRender =false;
		if ($this->request->isPost())
		{
			//echo 11; exit;
			$wallet_amt=0; $wallet1 = 0; $wallet2 = 0;
			if(isset($this->request->data['agent']) and strlen($this->request->data['agent']) > 0){
				$userid=$this->request->data['agent'];
				$role_id = $this->UserAuth->getUserId();
			}else{
			$userid=$this->UserAuth->getUserId();
			$role_id = '';
			}
			$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
			if(count($userData) > 0)
			{
				$wallet_amt =$userData[0]['user_wallet']['amount'];
			}
	
			$update=0; $success=array(); $fail=array(); $oktb_no1 = ''; $oktb_no = '';

			$rowcount =$this->request->data['rowcount'];
			$uCount =$this->request->data['uCount'];
			
			$no_array = array(); $oktbNo = array();
			$oktbNo = $this->User->query('Select oktb_no,oktb_id From oktb_details Where 1');
			$no_array = Set::combine($oktbNo,'{n}.oktb_details.oktb_id','{n}.oktb_details.oktb_no');
			$oID = '';
			for($i =1;$i<=$rowcount;$i++)
			{
				if($this->request->data['passportno'.$i]!=null and $this->request->data['name'.$i] != null and $this->request->data['pnr'.$i] != null and $this->request->data['d_o_j'.$i]!= null and $this->request->data['visa'.$i]['name'] != null and $this->request->data['from_ticket'.$i]['name'] != null and $this->request->data['to_ticket'.$i]['name'] != null and $this->request->data['airline'.$i] != null and $this->request->data['amount'.$i] != null)
				{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = "";$from_ticket = "";$to_ticket = "";
					$random =rand(111111,999999);
					$oktb_no1 = 'GVO-'.$random;
					
					$oktbId = array();
					//$oktb_no1 = 'GVO-189761';
					$oktb_no = $this->get_oktb_no($oktb_no1,$no_array,'individual');
				
					if(!file_exists(WWW_ROOT.'uploads/OKTB'))
					mkdir(WWW_ROOT.'uploads/OKTB', 0777, true);

					if(!file_exists(WWW_ROOT.'uploads/OKTB/'.$oktb_no))
					mkdir(WWW_ROOT.'uploads/OKTB/'.$oktb_no, 0777, true);
						
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
					
					$name =$this->request->data['name'.$i];
					$pnr = $this->request->data['pnr'.$i];
					$doj = $this->request->data['d_o_j'.$i];
					$airline =$this->request->data['airline'.$i];
					$amount =$this->request->data['amount'.$i];
					$passportno = $this->request->data['passportno'.$i];
					$cr_date=date('Y-m-d H:i:s');
					if(isset($this->request->data['f_hh'.$i]) && $this->request->data['f_hh'.$i]!=null)
					$doj_time =  $this->request->data['f_hh'.$i].':'.$this->request->data['f_mm'.$i];
					else $doj_time = 'hh:00';
					//To Ticket file upload end
					$this->User->useTable ='oktb_details';
					$this->User->query('Insert into oktb_details(oktb_no,role_id,oktb_name,oktb_user_id,oktb_pnr,oktb_d_o_j,oktb_doj_time,oktb_passport,oktb_passportno,oktb_visa,oktb_from_ticket,oktb_to_ticket,oktb_airline_name,oktb_airline_amount,oktb_approve_status,oktb_posted_date,oktb_status,oktb_payment_status) values("'.$oktb_no.'","'.$role_id.'","'.$name.'",'.$userid.',"'.$pnr.'","'.$doj.'","'.$doj_time.'","'.$passport.'","'.$passportno.'","'.$visa.'","'.$from_ticket.'","'.$to_ticket.'","'.$airline.'","'.$amount.'",0,"'.$cr_date.'",1,1)');
					$oktbId = $this->User->query("SELECT LAST_INSERT_ID() as id");
					if(strlen($oID) == 0)
					$oID = $oktbId[0][0]['id'];
					
				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","OKTB","Add","'.$oID.'","'.$userid.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		$oID++;
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
			
		if(strlen($role_id) > 0) {
				$udata = $this->User->query('Select username From users Where id = '.$userid);
				$uname = $udata[0]['users']['username'];
			}
			if(count($success) > 0){
				if(strlen($role_id) > 0)
			$msg .= count($success)." OKTB Applications for ".$uname." is/are successfully submitted. Amount required for processing this applications will be deducted from their wallet.";
			else 
			$msg .="Your ".count($success)." OKTB Applications are successfully submitted. Amount required for processing this applications will be deducted from your wallet.";
			
			$this->sendOKTBMail($pnrOktb,$uCount); 
			}
			if(count($fail) > 0){
				if(strlen($role_id) > 0)
			$msg .='Oops! '.count($fail).' OKTB Applications for '.$uname.' is/are not submitted. They don\'t have sufficient amount in their account for processing this applications.';
			else 
			$msg .='Oops! '.count($fail).' OKTB Applications is/are not submitted.You don\'t have sufficient amount in your account for processing this applications.';
			
			}
			
			if(count($fail) > 0)
			$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));
			else
			$this->Session->setFlash(__($msg));
							
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
			if(isset($this->request->data['agent']) and strlen($this->request->data['agent']) > 0){
				$userid=$this->request->data['agent'];
				$role_id = $this->UserAuth->getUserId();
			}else{
			$userid=$this->UserAuth->getUserId();
			$role_id = '';
			}
			$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
			if(count($userData) > 0)
			{
				$wallet_amt = $userData[0]['user_wallet']['amount'];
			}
				
			$update=0; $success=array(); $fail=array(); $group_no = '';
			
			$no_array = array(); $oktbNo = array();
			$oktbNo = $this->User->query('Select oktb_no,oktb_id From oktb_details Where 1');
			$no_array = Set::combine($oktbNo,'{n}.oktb_details.oktb_id','{n}.oktb_details.oktb_no');
			
			$gno_array = array(); $grpNo = array();
			$grpNo = $this->User->query('Select oktb_group_no From oktb_details Where oktb_group_no is not null');
			$gno_array = Set::combine($grpNo,'{n}.oktb_details.oktb_id','{n}.oktb_details.oktb_group_no');
			
			$total = $this->request->data['total2'];
			if($wallet_amt > $total){
			$rowcount =$this->request->data['rowcount'] + 1;
			$random =rand(111111,999999);
			$group_no1 = 'GVGO-'.$random;
			//$group_no1 = 'GVGO-936990';
			$group_no = $this->get_oktb_no($group_no1,$gno_array,'group');
			$oID = '';
			for($i =1;$i<=$rowcount;$i++)
			{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = "";
					$random =rand(111111,999999);
					$oktb_no1 = 'GVO-'.$random;
					//$oktb_no1 = 'GVO-189761';
					$oktb_no = $this->get_oktb_no($oktb_no1,$no_array,'individual');
						
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
					if(isset($this->request->data['f_hh1']) && $this->request->data['f_hh1']!=null)
					$doj_time =  $this->request->data['f_hh1'].':'.$this->request->data['f_mm1'];
					else $doj_time = 'hh:00';
					
					$this->User->useTable ='oktb_details';
					$this->User->query('Insert into oktb_details(oktb_no,role_id,oktb_group_no,oktb_name,oktb_user_id,oktb_pnr,oktb_d_o_j,oktb_doj_time,oktb_passport,oktb_passportno,oktb_visa,oktb_from_ticket,oktb_to_ticket,oktb_airline_name,oktb_airline_amount,oktb_approve_status,oktb_posted_date,oktb_status,oktb_payment_status) values("'.$oktb_no.'","'.$role_id.'","'.$group_no.'","'.$name.'",'.$userid.',"'.$pnr.'","'.$doj.'","'.$doj_time.'","'.$passport.'","'.$passportno.'","'.$visa.'","'.$from_ticket.'","'.$to_ticket.'","'.$airline.'","'.$amount.'",0,"'.$cr_date.'",1,1)');
					$oktbId = $this->User->query("SELECT LAST_INSERT_ID() as id");
					if(strlen($oID) == 0)
					$oID = $oktbId[0][0]['id'];
					
					if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","OKTB","Add","'.$oID.'","'.$userid.'","'.date('Y-m-d H:i:s').'",1) ');
	        		}
        			$oID++;
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
			if(strlen($role_id) > 0) {
				$udata = $this->User->query('Select username From users Where id = '.$userid);
				$uname = $udata[0]['users']['username'];
			}
			if(count($success) > 0){
				if(strlen($role_id) > 0)
			$msg .= count($success)." OKTB Applications for ".$uname." is/are successfully submitted. Amount required for processing this applications will be deducted from their wallet.";
			else 
			$msg .="Your ".count($success)." OKTB Applications is/are successfully submitted. Amount required for processing this applications will be deducted from your wallet.";
			$this->sendOKTBMail($pnrOktb,$uCount); 
			}
			if(count($fail) > 0){
			if(strlen($role_id) > 0)
				$msg .='Oops! '.count($fail).' OKTB Applications for '.$uname.' is/are not submitted. They don\'t have sufficient amount in their account for processing this applications.';
			else 
				$msg .='Oops! '.count($fail).' OKTB Applications is/are not submitted.You don\'t have sufficient amount in your account for processing this applications.';
			}
			//$msg .='Oops! '.count($fail).' OKTB Applications are not submitted.You don\'t have sufficient amount in your account for processing these applications.';

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
		foreach ($pnr as $key => $value) {
		    if (array_key_exists($value, $result)) {
		        $result[$value] .= ',' . $key;
		    } else {
		        $result[$value] = $key;
		    }
		}
		if(is_array($result)  > 0){
			//print_r($result);
			foreach($result as $k=>$r){
				$pnrData = array();
				$pnrData = explode(',',$r);
				//print_r($pnrData); exit;
				$i = 0; $res1 = array(); $zip = array();  $user_role_email  = ''; $amt = ''; $usr_id = ''; $pnr = '';
				foreach($pnrData as $p){
					$res = array();  $airline_id = ''; $usr_id = ''; 
					$res =$this->User->query('select * from oktb_details where oktb_no = "'.$p.'"');
					$userId = $res[0]['oktb_details']['oktb_user_id'];
					$res1[$p] = Set::combine($res, '{n}.oktb_details.oktb_no', '{n}.oktb_details');
					$zip[$p] =$this->create_oktb_zip_excel($p);
					//$usr_id = $res[0]['oktb_details']['oktb_user_id'];
					$amt = $res[0]['oktb_details']['oktb_airline_amount'];
					$pnr = $res[0]['oktb_details']['oktb_pnr'];
					$time = strtotime($res[0]['oktb_details']['oktb_posted_date']);
					$airline_id = $res[0]['oktb_details']['oktb_airline_name'];
					$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$res[0]['oktb_details']['oktb_airline_name']);
					$cairline = $this->User->query('Select * from agent_airline_cost Where air_id = '.$res[0]['oktb_details']['oktb_airline_name'].' and user_id = '.$res[0]['oktb_details']['oktb_user_id'].' and a_status = 1');
					if(count($cairline) > 0)
					$camt = $cairline[0]['agent_airline_cost']['air_price'];
					else
					$camt = $airline[0]['oktb_airline']['a_price'];
					$airline_name = $airline[0]['oktb_airline']['a_name'];
					$res1[$p]['airline_name'] = $airline[0]['oktb_airline']['a_name'];
					$res1[$p]['airline_email'] = $airline[0]['oktb_airline']['a_email'];
					$res1[$p]['airline_ccemail'] = $airline[0]['oktb_airline']['a_ccemail'];
					$i++;
				}
			//echo $camt; exit;
				 $user_role_email = $this->oktb_user_From_email($airline_id); 
				$data_id = $this->User->query('Select * from users Where id = '.$userId);
				$this->User->sendApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$res1,$r,$uCount);
				//$inv = $this->create_oktb_invoice($pnrData,$res1,$airline_name,$userId,$amt,$pnr,$time);
				//$ainv = $this->create_oktb_invoice($pnrData,$res1,$airline_name,$userId,$amt,$pnr,$time,$camt);
				//$this->User->sendApplyOKTBMail1($data_id[0],$this->oktb_From_email(),$res1,$r,$uCount,$inv);
				
				//$oktbNo = implode("','",$pnrData); 
				//$einv = explode('/',$inv);
				//$eainv =  explode('/',$ainv);
				//$this->User->query('Update oktb_details set inv_path = "'.end($einv).'" ,inv_admin_path = "'.end($eainv).'" Where oktb_no in ( \''.$oktbNo.'\')');
				
				$count = count($res1);
				if($count > 10){
					$zipData = array();
					if(strlen($user_role_email) > 0)
					$this->User->sendAdminApplyOKTBMail1($data_id[0],$user_role_email,$res1,$zipData,$r,$uCount);
					//$this->User->sendAdminApplyOKTBMail1($data_id[0],$user_role_email,$res1,$zipData,$r,$uCount,$ainv);
					$this->User->sendAirlineApplyOKTBMail1($this->oktb_From_email(),$res1,$zipData,$r,$uCount);
				 $x = 10; 
				$splitArr = array_chunk($res1, $x,true);
				
				if(count($splitArr) > 0){
					for($k = 0;$k <= count($splitArr) - 1;$k++){
						
						if(strlen($user_role_email) > 0)
						$this->User->sendAdminApplyOKTBMail1($data_id[0],$user_role_email,$splitArr[$k],$zip,$r,$uCount);
						$this->User->sendAirlineApplyOKTBMail1($this->oktb_From_email(),$splitArr[$k],$zip,$r,$uCount,null);
					}
				}
				}else{
					if(strlen($user_role_email) > 0)
						$this->User->sendAdminApplyOKTBMail1($data_id[0],$user_role_email,$res1,$zip,$r,$uCount);
						//$this->User->sendAdminApplyOKTBMail1($data_id[0],$user_role_email,$res1,$zip,$r,$uCount,$ainv);
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
		
		$res =$this->User->query('select * from oktb_details where oktb_no ="'.$oktb_no.'"');
		if(count($res)>0 and $res[0]['oktb_details']['oktb_status'] == 1)
		{
			$userId = $res[0]['oktb_details']['oktb_user_id'];
			$amt =$res[0]['oktb_details']['oktb_airline_amount'];
			$oID = $res[0]['oktb_details']['oktb_id'];
			$userData=array();
			
			if($amt <= $wallet)
			{
				$tamt =$wallet - $amt;
				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","OKTB","Apply","'.$oID.'","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
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
		$userid=0; $data = array(); $data2 = array();
		
		if($this->UserAuth->getGroupName() == 'User')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
				$data =$this->User->query('select oktb_id from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is null');
				}else{ 
				$data =$this->User->query('select oktb_id from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is null');
				}
			}else
			{
				if($paid == 3){
					$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_payment_status > 1 and oktb_group_no is null');
				}else if($paid != 0 && $paid != 3){
					$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_payment_status ='.$paid.' and oktb_group_no is null');
				}else{ 
					$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_group_no is null  ');
				}
				
			}

		if(count($data) > 0){
			$oktb_id = '';
        	$oktbData = Set::combine($data, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_id');
        	$oktb_id = implode(',',$oktbData);
        	if(strlen($oktb_id) > 0){
        		if($status == null || $status == 0){ 
		        	if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
		        	$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and oktb_details.oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') and users.status = 1 order by oktb_posted_date desc,payment_date desc limit 0,500 ');
					else{
					$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and users.status = 1 order by oktb_posted_date desc,payment_date desc limit 0,500');
					}
					}else{
		        	if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
		        	$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and oktb_details.oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') and users.status = 1  order by oktb_posted_date desc,payment_date desc');
					else 
					$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and users.status = 1  order by oktb_posted_date desc,payment_date desc');
        		}
        	}else $data2 = $data;
		}
		//echo '<pre>'; print_r($data2); exit;
		return $data2;
	}
	
function all_group_oktb_app($paid=0,$status = null)
	{
		$userid=0; $data2 = array();
		if($paid == 2){
			$grpdata = $this->User->query('Select oktb_group_no From oktb_details Where oktb_status = 1 and oktb_payment_status=5 and oktb_group_no is not null group by oktb_group_no');
			$gdata = Set::combine($grpdata,'{n}.oktb_details.oktb_group_no','{n}.oktb_details.oktb_group_no');
			$group_appr = implode('","',$gdata);
		}
		
		if($this->UserAuth->getGroupName() == 'User')
			{
				$userid = $this->UserAuth->getUserId();
				$currency = $this->currency_val($userid);
				$this->set('currency',$currency);
				if($paid != 0){
					if($paid == 2)
						$data =$this->User->query('select oktb_id from oktb_details where oktb_status =1 and oktb_group_no not in ("'.$group_appr.'") and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no ');
					else 
						$data =$this->User->query('select oktb_id from oktb_details where oktb_status =1 and oktb_payment_status ='.$paid.' and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no ');
				}else{ 
				$data =$this->User->query('select oktb_id from oktb_details where oktb_status =1 and oktb_user_id ='.$userid.' and oktb_group_no is not null group by oktb_group_no  ');
				}
				//return $data;
			}else
			{
				if($paid == 3){
				$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_payment_status > 1 and oktb_group_no is not null group by oktb_group_no');
				}else if ($paid != 0 && $paid != 3){
					if($paid == 2){		
						$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_payment_status = '.$paid.' and oktb_group_no not in ("'.$group_appr.'") and oktb_group_no is not null group by oktb_group_no');
					}else{ 
						$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_payment_status = '.$paid.' and oktb_group_no is not null group by oktb_group_no');
					}
				}else{ 
				$data = $this->User->query('select oktb_id from oktb_details where oktb_status = 1 and oktb_group_no is not null group by oktb_group_no');
				}
			}
		
		if(count($data) > 0){
			$oktb_id = '';
        	$oktbData = Set::combine($data, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_id');
        	$oktb_id = implode(',',$oktbData);
        	if(strlen($oktb_id) > 0){
        		if($status == null || $status == 0){
        	if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
        	$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and oktb_details.oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') and users.status = 1 order by oktb_posted_date desc,payment_date desc limit 0,500');
			else 
			$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and users.status = 1 order by oktb_posted_date desc,payment_date desc limit 0,500');
        		//echo $this->Session->read('role1.oktb_airline'); echo count($data2); exit;
        		}else{
        	if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User' && $this->Session->read('role1.oktb') && $this->Session->read('role1.oktb') == 1 && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0)
        	$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and oktb_details.oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') and users.status = 1 order by oktb_posted_date desc,payment_date desc ');
			else 
			$data2 = $this->User->query('Select * From oktb_details join users on oktb_details.oktb_user_id = users.id Where oktb_details.oktb_id in ('.$oktb_id.') and users.status = 1 order by oktb_posted_date desc,payment_date desc ');       		
        			
        		}
        		}else $data2 = $data;
		}
		//echo '<pre>'; print_r($data2); exit;
		return $data2;
	}

	function oktb_apps($paid=0,$wallet='na',$group=0){
		//echo $group;
		$this->set('group',$group);
		$this->set('paid',$paid);
	
		//$userId = $this->UserAuth->getUserId();
		//$curr_val = $this->User->query('Select * From currency_master Where status = 1');
		//$currency = Set::combine($curr_val, '{n}.currency_master.currency_id', '{n}.currency_master.currency_code');
		//$this->set('currency',$currency);
		
		if($paid !=2){
			//$curr = $this->currency_val($userId);
			//$this->set('curr',$curr); 
			$this->set('all_app','all_app');
		}
		
		/*if($wallet == 'na')
		{
		$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
		if(count($userData)>0)
		$this->set('userAmt',$userData[0]['user_wallet']['amount']);
		}else 
		$this->set('userAmt',$wallet);*/
		
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
		//$userId = $this->UserAuth->getUserId();
		
		if($value == 1){
		$data = $this->all_oktb_app($paid,$status);
		}else{
			 $nameResult = array(); $noResult = array(); $result = array(); $pnoResult = array();
			 $data = $this->all_group_oktb_app($paid,$status);
			
			 $result = Set::combine($data, '{n}.oktb_details.oktb_id', '{n}.oktb_details.oktb_group_no');
			 if(count($result) > 0){
				 foreach($result as $k=>$r){
				 	$name[$k] = ''; $no[$k] = ''; $pno[$k] = ''; $nameData = array(); $oktb_fee[$k] = 0;
				 	$nameData = $this->User->query('Select oktb_id,oktb_name,oktb_no,oktb_passportno,oktb_airline_amount From oktb_details Where oktb_group_no = "'.$r.'"');
				 	if(count($nameData) > 0){
				 	$oktb_fee[$k] = count($nameData) * $nameData[0]['oktb_details']['oktb_airline_amount'];
				 	}
				 }
				 $this->set('oktb_fee',$oktb_fee);
			 }
		}
		
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
        	
		$this->set('sortDate',$date);
		$query1 = $this->User->query('Select * From oktb_airline ');
		$airline_name = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.a_name');
		$airline_status = Set::combine($query1, '{n}.oktb_airline.a_id', '{n}.oktb_airline.status');
		$this->set('airline',$airline_name);
		$this->set('air_status',$airline_status);
		
		//$curr_val = $this->User->query('Select * From currency_master Where status = 1');
		//$currency = Set::combine($curr_val, '{n}.currency_master.currency_id', '{n}.currency_master.currency_code');
		//$this->set('currency',$currency);
		
		if($paid !=2){
			//$curr = $this->currency_val($userId);
			//$this->set('curr',$curr); 
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

		/*if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "OKTB" and action_type = "View" and app_no = "'.$id.'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","OKTB","View","'.$id.'","'.date('Y-m-d H:i:s').'",1) ');
        		}*/
        		
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
		
		$res =$this->User->query('select * from oktb_details where oktb_no ="'.$oktb_no.'"');
		
		if(count($res)>0 and $res[0]['oktb_details']['oktb_status'] == 1)
		{
		
			$userId = $res[0]['oktb_details']['oktb_user_id'];
			//$receipt = 'Yes'; $rec = array();
			//$rec = $this->User->query('Select a_value From agent_settings Where a_key = "receipt" and agent_id = '.$userId);
			//if(count($rec) > 0){
			//	$receipt = $rec[0]['agent_settings']['a_value'];
			//}
			$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
			if(count($userData) > 0)
			{
			 $wallet =$userData[0]['user_wallet']['amount']; 
			}
		
			$otbd = array();
			$otbd = Set::combine($res,'{n}.oktb_details.oktb_no','{n}.oktb_details');
			if($res[0]['oktb_details']['oktb_payment_status'] == 1)
			{
				$cairline = $this->User->query('Select * from agent_airline_cost Where air_id = '.$res[0]['oktb_details']['oktb_airline_name'].' and user_id = '.$res[0]['oktb_details']['oktb_user_id'].' and a_status = 1');
				if(count($cairline) > 0)
				$camt = $cairline[0]['agent_airline_cost']['air_price'];
				else
				$camt = $airline[0]['oktb_airline']['a_price'];
				
				$amt =$res[0]['oktb_details']['oktb_airline_amount'];
				$pnr  = $res[0]['oktb_details']['oktb_pnr'];
				$time  = strtotime($res[0]['oktb_details']['oktb_posted_date']);
				if($wallet > 0)
				{
				
				if($amt <= $wallet)
				{
					$user_role_email = '';
					$tamt =$wallet - $amt;
					$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
					$this->User->query('Update oktb_details set oktb_payment_status = 2,payment_date="'.date('Y-m-d H:i:s').'" Where oktb_user_id = '.$userId.' and oktb_id = '.$res[0]['oktb_details']['oktb_id']);
					$this->User->query('Insert into oktb_transactions(user_id,oktb_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['oktb_details']['oktb_id'].',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
					$data_id = $this->User->query('Select id,email,username from users Where id = '.$userId);
					$airline =$this->User->query('Select * from oktb_airline Where a_id = '.$res[0]['oktb_details']['oktb_airline_name']);
					//print_r($airline); exit;
					
					$res[0]['oktb_details']['airline_name'] = $airline[0]['oktb_airline']['a_name'];
					$inv = '';
					$oktbN = array(0=>$oktb_no);
					//if($receipt == 'Yes'){
					//$inv = $this->create_oktb_invoice($oktbN,$otbd,$res[0]['oktb_details']['airline_name'],$userId,$amt,$pnr,$time);
					//$ainv = $this->create_oktb_invoice($oktbN,$otbd,$res[0]['oktb_details']['airline_name'],$userId,$amt,$pnr,$time,$camt);
					$this->User->sendApplyOKTBMail($data_id[0],$this->oktb_From_email(),$res[0]);
					//}else $this->User->sendApplyOKTBMail($data_id[0],$this->oktb_From_email(),$res[0],'');
					$oktbNo = implode("','",$oktbN); 
					$einv = explode('/',$inv);
					$eainv =  explode('/',$ainv);
					$this->User->query('Update oktb_details set inv_path = "'.end($einv).'" ,inv_admin_path = "'.end($eainv).'" Where oktb_no in ( \''.$oktbNo.'\')');
				
					$zip =$this->create_oktb_zip_excel($oktb_no);
					$zip['id']=$res[0]['oktb_details']['oktb_id'];
					
					if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","OKTB","Apply","'.$zip['id'].'","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
	        		}
        		
					$user_role_email = $this->oktb_user_From_email($res[0]['oktb_details']['oktb_airline_name']);
					if(strlen($user_role_email) > 0)
					$this->User->sendAdminApplyOKTBMail($data_id[0],$user_role_email,$res[0],$zip);
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
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
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
	$coment=$this->request->data['comment'];
	$cr_date =date('Y-m-d H:i:s');
	if(strlen($okb_id) > 0)
	{
		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "OKTB" and action_type = "Change Status" and app_no = "'.$okb_id.'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,prev_value,updated_value,date,status) values("'.$roleId.'","OKTB","Change Status","'.$okb_id.'",2,5,"'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
		$grp_no = array();
		$grp_no = $this->User->query('Select oktb_group_no From oktb_details Where oktb_id = '.$okb_id.' and oktb_group_no is not null');
	if(count($grp_no) > 0 && strlen($grp_no[0]['oktb_details']['oktb_group_no']) > 0){
		$this->User->query('update oktb_details set oktb_approve_comments="'.$coment.'",oktb_payment_status =5,oktb_approve_date="'.$cr_date.'" where oktb_group_no = "'.$grp_no[0]['oktb_details']['oktb_group_no'].'"');
	}else
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
		}
		$zip->close();
		if (file_exists($path)) {
		
			$this->response->file($path, array(
	        'download' => true,
	        'name' => $group_no.'.zip',
	        			));
	        return $this->response;
		} else {
	     $this->Session->setFlash(__('Sorry!! Documents Not Found', 'default', array('class' => 'errorMsg')));
         $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
	}
	} else {
	     $this->Session->setFlash(__('Sorry!! Documents Not Found', 'default', array('class' => 'errorMsg')));
         $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));    
	}
   }
}

public function login_as_agent($agent_id)
{
$user = $this->User->findById($agent_id);
if(count($user) > 0)
{
$email = $user['User']['email'];
$password = $user['User']['password'];

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

		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Insert into user_action (role_id,type,action_type,user_id,date,status) values("'.$roleId.'","Agent","Login as Agent","'.$agent_id.'","'.date('Y-m-d H:i:s').'",1) ');
        	}
        		
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
			
			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "OKTB" and action_type = "Edit" and app_no = "'.$data[0]['oktb_details']['oktb_id'].'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","OKTB","Edit","'.$data[0]['oktb_details']['oktb_id'].'","'.date('Y-m-d H:i:s').'",1) ');
        		}
		foreach($data[0]['oktb_details'] as $k=>$v){
        				$oapp[$k] = $v;
        			}
		}
		if (!empty($oapp)) {
        				$this->request->data = $oapp;
        			}
        			
		$this->set('data',$oapp);
		
		$airData=$this->User->query('Select * From oktb_airline Where status = 1 or status = 2');
		$airline =Set::combine($airData,'{n}.oktb_airline.a_id','{n}.oktb_airline.a_name');
		
		//$airline = $this->get_dropdown('a_id', 'a_name','oktb_airline');
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
		
		if($this->UserAuth->getGroupName() != 'User'){
		$data = $this->User->query('Select id,username From users Where status = 1 and id != 1 and user_group_id = 2');
		$user = Set::combine($data,'{n}.users.id','{n}.users.username');
		$user = array('select'=>'Select') + $user;
		$this->set('agent', $user);
		}else{
		$userid=$this->UserAuth->getUserId(); $urgCount = array(); $uCount =2;
		$urgCount = $this->User->query('Select * From agent_settings Where agent_id = '.$userid.' and a_key = "urgent_date" and status = 1');
		if(count($urgCount) > 0){
			$uCount = $urgCount[0]['agent_settings']['a_value'];
		}
		$this->set('uCount',$uCount);
		}
		$airline=$this->get_dropdown('a_id', 'a_name','oktb_airline');
		$this->set('airline', $airline);
		
		//$userId=$this->UserAuth->getUserId();
		//$currency = $this->currency_val($userId);
		//$this->set('currency',$currency);
		
		$this->autoRender = false;
		$this->render('group_oktb');
	}
	
 	public function extension(){
 		if ($this->request -> isPost()) {
 			
 			if(isset($this->request->data['agent']) and strlen($this->request->data['agent']) > 0){
				$userid=$this->request->data['agent'];
				$role_id = $this->UserAuth->getUserId();
			}else{
			$userid=$this->UserAuth->getUserId();
			$role_id = '';
			}
			
 			//$userid=$this->UserAuth->getUserId();
 			$success = array(); $fail = array();
 			$ext = $this->User->query('Select * From agent_ext_cost Where user_id = '.$userid);
 			if(count($ext) > 0){
 				if($ext[0]['agent_ext_cost']['scost'] != null)
 				$extAmt = $ext[0]['agent_ext_cost']['scost'];
 				else $extAmt = 0;
 			}else $extAmt = 0;
 			
 			$rowcount = $this->request->data['rowcount'];
 			
 			$wallet = $this->User->query('Select * From user_wallet Where user_id = '.$userid);
 			if(count($wallet) > 0){
 				$wall = $wallet[0]['user_wallet']['amount'];
 			}else $wall = 0;
 			
 			$extNo = array(); $ext_array = array(); 
 			$extNo = $this->User->query('Select ext_id,ext_no From ext_details Where 1');
 			$ext_array = Set::combine($extNo,'{n}.ext_details.ext_id','{n}.ext_details.ext_no');
 			$eID = '';
 			for($i = 1; $i <= $rowcount; $i++){
 				$result = '';
 				if($this->request->data['passportno'.$i]!=null and $this->request->data['name'.$i] != null and $this->request->data['visa'.$i]['name'] != null )
				{
					$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','rtf','jpeg');
					$passport  = "";$visa = ""; $name = ''; $date = '';
					$random =rand(111111,999999);
					$ext_no1 = 'GVE-'.$random;
					//$ext_no1 = 'GVE-479302';
					$ext_no = $this->get_oktb_no($ext_no1,$ext_array,'extension'); 
						
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
					$this->User->query('Insert into ext_details(ext_name,role_id,ext_passportno,ext_visa,ext_date,ext_user_id,ext_no,ext_amt) Values ("'.$name.'","'.$role_id.'","'.$passport.'","'.$visa.'","'.$date.'","'.$userid.'","'.$ext_no.'",'.$extAmt.')');
					$extId = $this->User->query("SELECT LAST_INSERT_ID() as id");
					if(strlen($eID) == 0)
					$eID = $extId[0][0]['id'];
					
					if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","Extension","Add","'.$eID.'","'.$userid.'","'.date('Y-m-d H:i:s').'",1) ');
	        		}
	        		$eID++;
        		
					$result = $this->apply_extension($ext_no,$wall);
					
					if(is_array($result) and $result[0] == true)
					{
						$success[count($success)] = $ext_no;
						$wall = $result[1];
					}else
					{
						$fail[count($fail)]=$ext_no;
					}
				}
 			}
 			
 			if(strlen($role_id) > 0){
 				$udata = $this->User->query('Select username From users Where id = '.$userid);
 				$uname = $udata[0]['users']['username'];
 			}
 			if(count($success) > 0){
 				if(strlen($role_id) > 0)
 			$msg =count($success) ." Extension Application for ".$uname." is/are successfully submitted. Amount required for processing this application will be deducted from their wallet.";
 				else
 			$msg ="Your ". count($success) ." Extension Application is/are successfully submitted. Amount required for processing this application will be deducted from your wallet.";
 						
 			}
 			if(count($fail) > 0){
 				if(strlen($role_id) > 0)
 			$msg ='Oops! '. count($fail). ' Extension Application for '.$uname.' is/are not submitted.They don\'t have sufficient balance for processing this application.';
 				else				
 			$msg ='Oops! '. count($fail). ' Extension Application is/are not submitted.You don\'t have sufficient balance for processing this application.';
 			}
 			if(count($fail) > 0)
 			$this->Session->setFlash(__($msg, 'default', array('class' => 'errorMsg')));
 			else
 			$this->Session->setFlash(__($msg));
 			
 			
			$this->autoRender =false;
			$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extension_list'));
		
 		}
 		
 		if($this->UserAuth->getGroupName() != 'User'){
		$data = $this->User->query('Select id,username From users Where status = 1 and id != 1 and user_group_id = 2');
		$user = Set::combine($data,'{n}.users.id','{n}.users.username');
		$user = array('select'=>'Select') + $user;
		$this->set('agent', $user);
		}
        	$this->autoRender = false;
        	$this->render('extension');
        }

        public function all_extension($pstatus =null ){
        	$userid=$this->UserAuth->getUserId(); $data = array();
        	
       		$vdata = $this->User->query('Select a.app_id,a.app_no,a.first_name,a.last_name,b.user_id,b.tent_date,b.visa_type,b.app_date,b.tr_status,a.extend_status,a.date_of_exit,a.last_doe From visa_app_group as b join visa_tbl as a on a.group_id = b.group_id  Where b.user_id = '.$userid.' and (a.last_doe between CURDATE() and DATE_ADD(CURDATE(), INTERVAL 10 DAY)) and b.upload_status = 1 and b.status = 1 and b.tr_status = 5 and a.extend_status = 1 ');
			//print_r($vdata); exit;
			$userIdList = '';
			//$groupId = Set::combine($vdata,'{n}.a.app_id','{n}.a.app_id');
			if($this->UserAuth->getGroupName() != 'User'){
			
			$users = Set::combine($vdata,'{n}.a.app_id','{n}.b.user_id');
			$userIdList = implode(',',$users);
				if(strlen($userIdList) > 0){
					$udata = $this->User->query('Select username From users Where id in ('.$userIdList.')');
					$usernameData = Set::combine($udata,'{n}.users.id','{n}.users.username');
					$this->set('username',$usernameData);
				}
			}
			
        	$this->set('data',$vdata);
        			
			$visa_type=$this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
        	$this->set('visa_type',$visa_type);
			
        	$this->autoRender = false;
        	$this->render('all_extension');
        }
      
function apply_extension($ext_no,$wall=0)
	{
		$this->autoRender = false;
		
		
		$res =$this->User->query('select * from ext_details where ext_no ="'.$ext_no.'"');
		if(count($res)>0 and $res[0]['ext_details']['ext_status'] == 1)
		{
			$userId = $res[0]['ext_details']['ext_user_id'];
			$amt =$res[0]['ext_details']['ext_amt'];
			
			//$amt = 100;
			$userData=array();
			if($amt <= $wall)
			{
				$tamt =$wall - $amt;
				$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
				$this->User->query('Update ext_details set ext_payment_status = 2,ext_apply_date="'.date('Y-m-d H:i:s').'" Where ext_id = '.$res[0]['ext_details']['ext_id']);
				$this->User->query('Insert into ext_transactions(user_id,ext_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['ext_details']['ext_id'].',"'.$amt.'","'.$wall.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
				//$data_id = $this->User->query('Select * from users Where id = '.$userId);

					$data_id = $this->User->query('Select * from users Where id = '.$userId);
					$inv = $this->create_ext_invoice($res[0]['ext_details']);
					$ainv = $this->create_ext_invoice($res[0]['ext_details'],1);
					$einv = explode('/',$inv);
					$eainv =  explode('/',$ainv);
					$this->User->query('Update ext_details set inv_path = "'.end($einv).'",inv_apath = "'.end($eainv).'" Where ext_id = '.$res[0]['ext_details']['ext_id']);
					
					$this->User->sendApplyExt($data_id[0],$this->visa_From_email(),$res[0],$inv);
					$zip =$this->create_ext_zip_excel($ext_no);
					$zip['id']=$res[0]['ext_details']['ext_id'];
					
					$user_email = $this->extension_From_email();
					if(strlen($user_email) > 0)
					$this->User->sendAdminApplyExt($data_id[0],$user_email,$res[0],$zip,$ainv);

				return array(true,$tamt);
			}else
			{
				return false;
			}
		}else
		return false;
	}
		
	public function delete_ext_date()
	{
		if(strlen($_POST['id']) > 0 && $_POST['id'] != 0){
			
		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Extension Date" and action_type = "Delete" and app_no2 = '.$_POST['id']);
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no2,date,status) values("'.$roleId.'","Extension Date","Delete","'.$_POST['id'].'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
			$this->User->query('Update visa_tbl set extend_status = 0 , date_of_exit = null, last_doe = null Where app_id = '.$_POST['id']);
			echo 'Success';
		}else echo 'Error';
			$this->autoRender = false;
	}
	
	public function extCost($agent_val = null,$cost = ''){
		
			$data = $this->User->query('Select * From users Where status = 1 and user_group_id = 2');
			if(count($data) > 0){
				$agent['select'] = 'Select';
				foreach($data as $d){
					$eData = array();
					$agent[$d['users']['id']] = $d['users']['username'];
					$currency = $this->get_master_data('currency_master',$d['users']['currency'],'currency_id','currency_code');
					if(count($currency) == 0) $currency = 'INR';  
					$eData = $this->User->query('Select cost,scost From agent_ext_cost Where user_id = '.$d['users']['id']);
					if(count($eData) == 0 || !isset($eData[0]['agent_ext_cost']['scost']) || $eData[0]['agent_ext_cost']['scost'] == null) $price = 0; else $price = $eData[0]['agent_ext_cost']['scost'];
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
        			
        			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and  type = "Ext Cost" and user_id = '.$this->request->data['User']['agent']);
	        			if(count($ans) > 0) $this->User->query('Insert into user_action(role_id,type,user_id,prev_value,updated_value,date,status) values("'.$roleId.'","Ext Cost","'.$this->request->data['User']['agent'].'","'.$ans[0]['agent_ext_cost']['cost'].'","'.$this->request->data['User']['ext_cost'].'","'.date('Y-m-d H:i:s').'",1) ');
	        			else $this->User->query('Insert into user_action(role_id,type,user_id,prev_value,updated_value,date,status) values("'.$roleId.'","Ext Cost","'.$this->request->data['User']['agent'].'",0,"'.$this->request->data['User']['ext_cost'].'","'.date('Y-m-d H:i:s').'",1) ');
        			}
        		
        		
        			if(count($ans) > 0)
        			{
        				$date_cr =date('d-m-Y');
        				$this->User->query('update agent_ext_cost set cost = "'.$this->request->data['User']['ext_cost'].'",scost = "'.$this->request->data['User']['ext_scost'].'", date="'.date('Y-m-d H:i:s').'" where user_id = '.$this->request->data['User']['agent']);
        			}
        			else{
        			//$this->User->save($this->request->data);
        			$this->User->query('INSERT INTO agent_ext_cost(user_id,cost,scost,date) VALUES ("'.$this->request->data['User']['agent'].'","'.$this->request->data['User']['ext_cost'].'","'.$this->request->data['User']['ext_scost'].'","'.date('Y-m-d H:i:s').'")');
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
	

public function apply_extension_for_visa()
	{
		$this->autoRender =false;
		$visa_arr = array(); $user_arr = array(); $success = array(); $fail = array();
		$userId = $this->UserAuth->getUserId();
		$wallet =0;	$userData=array();
		if ($this->request-> isPost() && isset($this->request->data['select'])) {
			if(count($this->request->data['select']) > 0){
				$extCost = $this->User->query('Select cost,scost From agent_ext_cost Where user_id = '.$userId.' and scost is not null');
				if(count($extCost) > 0)
				 $amt =$extCost[0]['agent_ext_cost']['scost'];
				else $amt = 0;
				
				$group_list = implode(',',$this->request->data['select']);
				$res =$this->User->query('select group_id,first_name,last_name,app_id,user_id,app_no from visa_tbl where app_id in ('.$group_list.')');
				$visa_arr = Set::combine($res,'{n}.visa_tbl.app_id','{n}.visa_tbl');
				$user_arr = Set::combine($res,'{n}.visa_tbl.app_id','{n}.visa_tbl.user_id');
				$user_arr = array_unique($user_arr); 
				$userIdList  =implode(',',$user_arr);
				if(count($visa_arr) > 0){
				$userData = $this->User->query('Select amount From user_wallet Where user_id ='.$userId);
				if(count($userData) > 0) $wallet = $userData[0]['user_wallet']['amount']; else $wallet = 0;
				
				if(count($visa_arr) > 0){
				
					foreach($visa_arr as $k=>$v){ $total = 0;
						$grpD = $this->User->query("Select visa_type From visa_app_group Where group_id = ".$v['group_id']);
							$v['visa_type'] = $this->get_master_data('visa_type_master',$grpD[0]['visa_app_group']['visa_type'],'visa_type_id','visa_type');
							//print_r($v); exit;
						if($wallet > $amt){
							$tamt =$wallet - $amt;
							
							$extNo = array(); $ext_array = array(); 
				 			$extNo = $this->User->query('Select ext_id,ext_no From extension Where 1');
				 			$ext_array = Set::combine($extNo,'{n}.extension.ext_id','{n}.extension.ext_no');
			 			
							$random =rand(111111,999999);
							$ext_no1 = 'GVE-'.$random;
							$ext_no = $this->get_oktb_no($ext_no1,$ext_array,'extension');
							
							$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
							$date = date('Y-m-d h:i:s');
							$this->User->query('Insert into ext_details(ext_group_id,ext_apply_date,ext_user_id,ext_no,ext_amt,ext_payment_status) Values ("'.$v['app_id'].'","'.$date.'","'.$userId.'","'.$ext_no.'",'.$amt.',2)');
							$visa_grp_Id = $this->User->query("SELECT LAST_INSERT_ID() as id");
        					$extId = $visa_grp_Id[0][0]['id'];
							$this->User->query('Update visa_tbl set extend_status = 2 Where app_id = '.$v['app_id']);
							$this->User->query('Insert into ext_transactions(user_id,ext_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$extId.',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
							
							$res  = $this->User->query('Select * From ext_details Where ext_id = '.$extId);
							$data_id = $this->User->query('Select * from users Where id = '.$userId);
							
							$inv = $this->create_ext_invoice($res[0]['ext_details']);
							$ainv = $this->create_ext_invoice($res[0]['ext_details'],1);
							$einv = explode('/',$inv);
							$eainv =  explode('/',$ainv);
							$this->User->query('Update ext_details set inv_path = "'.end($einv).'",inv_apath = "'.end($eainv).'" Where ext_id = '.$extId);
					
							$this->User->sendApplyExtMail($data_id[0],$this->visa_From_email(),$v,$amt,$ext_no,$inv);
							$user_email = $this->extension_From_email();
							if(strlen($user_email) > 0)
							$this->User->sendAdminApplyExtMail($data_id[0],$user_email,$v,$amt,$ext_no,$ainv);
							$msg ="Your Application is successfully submitted. Amount required for processing these application will be deducted from your wallet.";
							$this->Session->setFlash(__($msg));
							$wallet =$tamt;
							
							$success[] = $k; 
						}else{
							$fail[] = $k; 
						}
					}

					if(count($fail) > 0){
						$msg ='Oops! Application is not submitted.You don\'t have sufficient amount in your account for processing this application.';
						$this->Session->setFlash(__($msg),'default', array('class' => 'errorMsg'));
					}else{
						$msg ='You Have succesfully applied for this Application.';
						$this->Session->setFlash(__($msg),'default');
					}
				}
			}		
		}
		
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_extension'));
		}else{
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_extension'));
		}
	}
	
	public function groupIdData($group,$visa_type,$group_no){
				$appdata = $this->User->query('Select app_no,first_name,last_name,app_id From visa_tbl Where group_id = '.$group);
				$appNo = Set::combine($appdata,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
				$name = Set::combine($appdata,'{n}.visa_tbl.app_id',array('{0} {1}','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name'));
				$data['appNo'] = $group_no.' <br/>Application No : <br/>'.implode(',<br/>',$appNo); 
				$data['name'] = implode(',<br/>',$name);
				
	
        	if(strlen($visa_type) > 0){
				$query1 = $this->User->query('Select visa_type From visa_type_master Where visa_type_id = '.$visa_type);
				$data['visa'] = $query1[0]['visa_type_master']['visa_type'];
        	}
        	return $data;
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
			if(count($evisa) > 0)
			$eVisa = implode(',',$evisa);
			else $eVisa = 0;
			
			$extend1 = array('select'=>'Select');
			$data = $this->User->query('SELECT b.app_no,b.passport_no,b.first_name,b.last_name,c.username FROM visa_app_group as a join visa_tbl as b on a.group_id = b.group_id join users as c on a.user_id = c.id WHERE a.visa_type in ('.$eVisa.') and a.upload_status = 1 and a.status = 1 and b.extend_status <= 1 and b.date_of_exit is null and a.tr_status = 5');
			//echo '<pre>'; print_r($data); exit;
			$extend = Set::combine($data, '{n}.b.app_no', array('{0} - {1} {2} ( {3} )', '{n}.c.username','{n}.b.first_name', '{n}.b.last_name','{n}.b.app_no'));
			$extend2 = array('other'=>'Other');
			$extend = Set::merge($extend1,$extend2,$extend);
			$this->set('extend',$extend);
	}

	public function getVisaData(){
		$this->autoRender = false;
		if(!empty($_POST['visaId'])){
			$visa = $_POST['visaId'];
			$data = $this->User->query('Select b.app_id,b.app_no,a.visa_type,a.visa_fee,a.tent_date,a.adult,a.children,a.infants,a.user_id,b.date_of_exit,b.last_doe From visa_tbl as b join visa_app_group as a on b.group_id = a.group_id Where b.app_no = "'.$visa.'"');
//print_r($data); exit;
			if(count($data) > 0){
				$fee = 0;
				$total = $data[0]['a']['adult'] + $data[0]['a']['children'] + $data[0]['a']['infants'];
				if($data[0]['a']['visa_fee'] > 0)
				$fee = $data[0]['a']['visa_fee'] / $total;
				$this->set('fee',$fee);
			$this->set('data',$data);
			$cdata = '';
			$cdata = $this->User->query('Select currency_master.currency_code From users join currency_master on currency_master.currency_id = users.currency Where users.id = '.$data[0]['a']['user_id']);
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
			$data = $this->User->query('Select b.app_id,b.app_no,a.visa_type,a.visa_fee,a.tent_date,a.adult,a.children,a.infants,a.user_id,b.date_of_exit,b.last_doe From visa_tbl as b join visa_app_group as a on b.group_id = a.group_id Where b.app_no = "'.$visa.'"');
			if(count($data) > 0){
			$fee = 0;
			$total = $data[0]['a']['adult'] + $data[0]['a']['children'] + $data[0]['a']['infants'];
			if($data[0]['a']['visa_fee'] > 0)
			$fee = $data[0]['a']['visa_fee'] / $total;
			$this->set('fee',$fee);
			$this->set('data',$data);
			$cdata = '';
			$cdata = $this->User->query('Select currency_master.currency_code From users join currency_master on currency_master.currency_id = users.currency Where users.id = '.$data[0]['a']['user_id']);
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
		$data = $this->User->query('Select a.group_no,a.group_id,a.visa_type,a.user_id,a.tent_date,b.currency,b.username,c.app_id,c.app_no,c.date_of_exit,c.last_doe,c.first_name,c.last_name,c.passport_no From visa_app_group as a join users as b on a.user_id = b.id join visa_tbl as c on a.group_id = c.group_id Where c.extend_status = 1 Order by c.date_of_exit desc ');
		//$vData = Set::combine($data, '{n}.a.group_id','{n}.a');
		
		if(count($data) > 0){
		//$bData = Set::combine($data, '{n}.a.group_id','{n}.b.currency');
		//foreach($bData as $k=>$v){ 
		//		$currency[$k] = $this->get_master_data('currency_master',$v,'currency_id','currency_code');
		//		if(count($currency) == 0) $currency[$k] = 'INR';  
		//	}
		//$username = Set::combine($data, '{n}.a.group_id','{n}.b.username');
		$this->set('data',$data);
		
		$visa_type = $this->get_dropdown('visa_type_id', 'visa_type','visa_type_master');
		$this->set('visa_type',$visa_type);
	//	echo '<pre>'; print_r(); exit;
			
			//$this->set('currency',$currency);
		}
			$this->render('all_visa_extend_data');
	}
	
	public function save_visa_data(){
		$this->autoRender = false;
		if ($this->request -> isPost()) {
			//print_r($_POST); exit;
			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$data = $this->User->query('Select date_of_exit From visa_tbl Where app_id = '.$this->request->data['User']['visa'].' and date_of_exit is not null and date_of_exit <> ""'); 
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Extension Date" and action_type = "Add/Edit" and app_no2 = "'.$this->request->data['User']['visa'].'"');
        			if(count($data) > 0)
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no2,prev_value,updated_value,date,status) values("'.$roleId.'","Extension Date","Add/Edit","'.$this->request->data['User']['visa'].'","'.$data[0]['visa_tbl']['date_of_exit'].'","'.$this->request->data['User']['d_o_e'].'","'.date('Y-m-d H:i:s').'",1) ');
        			else  $this->User->query('Insert into user_action (role_id,type,action_type,app_no2,updated_value,date,status) values("'.$roleId.'","Extension Date","Add/Edit","'.$this->request->data['User']['visa'].'","'.$this->request->data['User']['d_o_e'].'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
			$this->User->query('Update visa_tbl set extend_status = 1 ,date_of_exit = "'.$this->request->data['User']['d_o_e'].'" , last_doe = "'.$this->request->data['User']['last_doe'].'" Where app_id = '.$this->request->data['User']['visa']);
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
			//print_r($_POST); exit;
			$setting = $this->request->data['User']['type'];
			$userId = $this->request->data['User']['agent'];
			if($setting == 0){
				$this->User->query('Update users set currency = '.$this->request->data['User']['currency'].' Where id = '.$userId);
			}else if($setting == 1){
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
			}else if($setting == 2){
				$days = $this->request->data['User']['urgent'];
				$urgData = $this->User->query('Select * from agent_settings Where agent_id = '.$userId.' and a_key = "urgent_date"');
				if(count($urgData) > 0) {
					$this->User->query('Update agent_settings set a_value = '.$days.' Where agent_id = '.$userId.' and a_key = "urgent_date"');
				}else{
					$this->User->query('Insert into agent_settings (agent_id,a_key,a_value,date) values('.$userId.',"urgent_date","'.$days.'","'.date('Y-m-d').'")');
				}
			}else if($setting == 3){
				$low_amount = $this->request->data['User']['urgent'];
				$urgData = $this->User->query('Select * from agent_settings Where agent_id = '.$userId.' and a_key = "lowest_bal"');
				if(count($urgData) > 0) {
					$this->User->query('Update agent_settings set a_value = '.$low_amount.' Where agent_id = '.$userId.' and a_key = "lowest_bal"');
				}else{
					$this->User->query('Insert into agent_settings (agent_id,a_key,a_value,date) values('.$userId.',"lowest_bal","'.$low_amount.'","'.date('Y-m-d').'")');
				}
			}else if($setting == 4){
				$receipt = $this->request->data['User']['receipt'];
				if($receipt == 'Yes')
				$receiptType = $this->request->data['User']['receiptType'];
				else $receiptType = null;
				$urgData = $this->User->query('Select * from agent_settings Where agent_id = '.$userId.' and a_key = "receipt"');
				if(count($urgData) > 0) {
					$this->User->query('Update agent_settings set a_value = "'.$receipt.'", a_value2 = "'.$receiptType.'" Where agent_id = '.$userId.' and a_key = "receipt"');
				}else{
					$this->User->query('Insert into agent_settings (agent_id,a_key,a_value,a_value2,date) values('.$userId.',"receipt","'.$receipt.'","'.$receiptType.'","'.date('Y-m-d').'")');
				}
			}
			else{
				
			}
			$this->Session->setFlash(__('Data Saved Successfully'));
			$this->redirect('agentSetting');
			
		}else $this->redirect('agentSetting');
	}
	
	
public function approve_ext(){
	$this->autoRender = false;
	if($this->request->isPost())
	{
		
		  $extId = $_POST['ext_id'];
		  $last_date = $this->request->data['last_date'];
		  $comments = $this->request->data['comments']; 
		$path =0;
		 if(isset($this->request->data['upload']['name']) && strlen($this->request->data['upload']['name']) > 0)
        {
			 $path = $this->ExtVisa($extId,$this->request->data['upload']); 
        }
		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
			    $roleId = $this->Session->read('role1.role_id');
			    $this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Extension" and action_type = "Change Ext Status" and app_no = '.$extId);
			    $this->User->query('Insert into user_action (role_id,type,action_type,app_no,prev_value,updated_value,date,status) values("'.$roleId.'","Extension","Change Ext Status",'.$extId.',2,5,"'.date('Y-m-d H:i:s').'",1) ');
		  }
		  //echo $path; 
		if(strlen($path) > 2){  		
		$this->User->query('Update ext_details set ext_payment_status = 5 , ext_last_date = "'.$last_date.'" ,ext_comments = "'.$comments.'" , ext_approve_date = "'.date('Y-m-d H:i:s').'" Where ext_id = '.$extId);
		$data  =$this->User->query('Select ext_group_id From ext_details Where ext_id = '.$extId. ' and ext_group_id is not null and ext_group_id <> ""');		
		if(count($data) > 0){
			$this->User->query('Update visa_tbl set extend_status = 5 Where app_id = '.$data[0]['ext_details']['ext_group_id']);
		}
		echo json_encode(array('status' => 'Success', 'msg' => 'Extension Approved Successfully'));
		
		}else echo json_encode(array('status' => 'Error', 'msg' => 'Some Error Occured'));
		}else echo json_encode(array('status' => 'Error', 'msg' => 'Some Error Occured'));
	}

public function upload_ext_visa1($extId=null){
        	if($extId != null){
        		if ($this->request ->isPost()) {
        			$email= '';
        			$data = $this->User->query('Select * From ext_details join users on ext_details.ext_user_id = users.id Where ext_details.ext_id='.$extId);
//echo '<pre>'; print_r($data); exit;
        			$ext_no = $data[0]['ext_details']['ext_no'];
        			$email = $data[0]['users']['email'];
        			$username = $data[0]['users']['username'];
        			if(isset($this->request->data['User']['upload']['name']) && strlen($this->request->data['User']['upload']['name']) > 0)
        			{
        				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
			        			$roleId = $this->Session->read('role1.role_id');
			        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Extension" and action_type = "Upload Ext Visa" and app_no = '.$extId);
			        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","Extension","Upload Ext Visa",'.$extId.',"'.date('Y-m-d H:i:s').'",1) ');
		        			}   
        		
        				if(!file_exists(WWW_ROOT.'uploads/Extension/visa/'.$ext_no))
        				mkdir(WWW_ROOT.'uploads/Extension/visa/'.$ext_no, 0777, true);
        					
        				$random =rand(111111,999999);
        				$ext = explode('.',$this->request->data['User']['upload']['name']);
        				$extension = $ext[1];
        				$upload_name = $ext_no.'-Visa'.$random.'.'.$extension;
        				$path =  WWW_ROOT.'uploads/Extension/visa/'.$ext_no.'/'.$upload_name;
        				move_uploaded_file($this->request->data['User']['upload']['tmp_name'],$path);
        				$this->User->query('Update ext_details set ext_visa_path = "'.$upload_name.'" Where ext_id = '.$extId);
        				//echo $this->request->data['User']['upload']['name'] = ''; exit;
        				$this->User->sendUploadExtVisaMail($ext_no,$this->visa_From_email(),$path,$email,$username);
        				$this->set('msg','Extension Visa Uploaded Successfully');

        			}else
        			$this->set('err','Select a File to Upload');
        			$this->set('extId',$extId);
        			$this->render('upload_ext_visa');
        		}else{
        			$this->set('extId',$extId);
        			$this->render('upload_ext_visa');
        		}
        	}else{
        		$this->redirect('extension_list');
        	}
        }
        
        public function get_oktb_no($oktb_no,$no_array,$type){
        	$this->autoRender = false;
        	
        	while(in_array($oktb_no,$no_array)){
        		$random =rand(111111,999999);
        		
				if ($type == 'group')
				$oktb_no1 = 'GVGO-'.$random;
				else if($type = 'extension')
				$oktb_no1 = 'GVE-'.$random;
				else
				$oktb_no1 = 'GVO-'.$random;
				
				$oktb_no = $this->get_oktb_no($oktb_no1,$no_array,$type);
        	}
       			 return $oktb_no;
        }
        
		public function approve_ext_form()
			{
				if(isset($_POST['id']))
				{
					$this->autoRender =false;
					$this->set('extId',$_POST['id']);
					$this->render('approve_ext_form');
				}
			}
			
			public function approve_check(){
				$this->autoRender = false;
				$approve = 0;
				$data = $this->User->query('Select a_value From admin_settings Where a_key = "admin_approve"');
				if(count($data) > 0)
					$approve = $data[0]['admin_settings']['a_value'];
				return $approve;				
			}
			
public function delete_oktb($oktb_id,$type='I'){
				$this->autoRender = false;
        	
        	if(!empty($oktb_id) && $oktb_id != null){
        		$oktb_fee = 0; $data = array();   $userAmt = array();
        		 $total= 0; $amount = 0; $oktbData = 1;
        		
        		$data = $this->User->query('Select * From oktb_details Where oktb_id = '.$oktb_id);
        		if(count($data) > 0){ 
        		
        		if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "OKTB" and action_type = "Delete" and app_no = "'.$oktb_id.'"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","OKTB","Delete","'.$oktb_id.'","'.date('Y-m-d H:i:s').'",1) ');
        		}
        		
        		$userId = $data[0]['oktb_details']['oktb_user_id'];
        		
        		if($type == 'I'){
	        		$oktb_no = $data[0]['oktb_details']['oktb_no'];
	        		$this->User->query('Update oktb_details set oktb_status = 0 Where oktb_id = '.$oktb_id);
	        		$oktb_fee = $data[0]['oktb_details']['oktb_airline_amount'];
        		}else{
	        		$oktb_no = $data[0]['oktb_details']['oktb_group_no'];
	        		$this->User->query('Update oktb_details set oktb_status = 0 Where oktb_group_no = "'.$oktb_no.'"');
	        		$oktbData = $this->User->query('Select oktb_id From oktb_details Where oktb_group_no = "'.$oktb_no.'"');
	        		$oktb_fee = $data[0]['oktb_details']['oktb_airline_amount'] * count($oktbData);
        		}
        		
        		//$this->User->query('Update oktb_transactions set status = 0 Where oktb_id = '.$oktb_id.' and user_id = '.$userId);
        		$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        		if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];

        		$amount = $total + $oktb_fee;
        		$this->User->query('Update user_wallet set amount = '.$amount.' Where user_id = '.$userId);
        		
        		$date = date('Y-m-d H:i:s');
        		$this->User->query('Insert into new_transaction(user_id,bank_type,amt,bank_name,bank_branch,country,account_no,trans_mode,trans_date,remarks,opening_bal,closing_bal,status,admin_status,trans_status,payment_status,date,app_date) values ("'.$userId.'",1,"'.$oktb_fee.'","CREDIT AMOUNT","NO BRANCH",1,"NO ACCOUNT NUMBER",1,"'.$date.'","Deleted OKTB App ('.$oktb_no.')","'.$total.'","'.$amount.'",1,1,"A",1,"'.$date.'","'.$date.'")'); 
        	   	$this->Session->setFlash('OKTB Application Deleted Successfully');
        		}else{
        			$this->Session->setFlash('OKTB Application Does not Exist');
        		} 
        	}
        	if($type == 'I')
       		 $this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb_apps'));
			else
			 $this->redirect('oktb_apps/0/na/1');
			}
			
	public function delete_ext()
	{
		if(strlen($_POST['id']) > 0 && $_POST['id'] != 0){
			$ext_id = $_POST['id']; 
			$data = $this->User->query('Select * From ext_details Where ext_id = '.$ext_id);
			if(count($data) > 0){
				$ext_amt = 0; $total = 0; $userAmt = array();
			$this->User->query('Update ext_details set ext_status = 0 Where ext_id = '.$ext_id);
			$ext_amt = $data[0]['ext_details']['ext_amt'];
			$userId = $data[0]['ext_details']['ext_user_id'];
			$ext_no = $data[0]['ext_details']['ext_no'];
			
			$userAmt = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
        	if(count($userAmt) > 0) $total = $userAmt[0]['user_wallet']['amount'];
			
        	$amount = $total + $ext_amt;
        	$this->User->query('Update user_wallet set amount = '.$amount.' Where user_id = '.$userId);
        		
        	$date = date('Y-m-d H:i:s');
        	$this->User->query('Insert into new_transaction(user_id,bank_type,amt,bank_name,bank_branch,country,account_no,trans_mode,trans_date,remarks,opening_bal,closing_bal,status,admin_status,trans_status,payment_status,date,app_date) values ("'.$userId.'",1,"'.$ext_amt.'","CREDIT AMOUNT","NO BRANCH",1,"NO ACCOUNT NUMBER",1,"'.$date.'","Deleted Extension Application ('.$ext_no.')","'.$total.'","'.$amount.'",1,1,"A",1,"'.$date.'","'.$date.'")'); 
        	//$this->Session->setFlash('Extension Application Deleted Successfully');
        	   
			echo 'Success';
			}else echo 'Error';
		}else echo 'Error';
			$this->autoRender = false;
	}
	
public function export_group_oktb(){
	$this->autoRender = false;
	if($this->UserAuth->getGroupName() != 'User'){
		if($this->UserAuth->getGroupName() != 'Admin' && $this->Session->read('role1.oktb_airline') && strlen($this->Session->read('role1.oktb_airline')) > 0) 
			$data = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_group_no is not null and oktb_payment_status  > 1 and oktb_airline_name in ('.$this->Session->read('role1.oktb_airline').') order by oktb_id desc ');
		else
		$data = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_group_no is not null and oktb_payment_status  > 1 order by oktb_id desc ');
	}else{
	$userId = $this->UserAuth->getUserId();	
	$data = $this->User->query('Select * From oktb_details Where oktb_status = 1 and oktb_group_no is not null and oktb_user_id = '.$userId.' and oktb_payment_status  > 1 order by oktb_id desc ');
	}
		if(count($data) > 0){
			
			if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
        			$roleId = $this->Session->read('role1.role_id');
        			//$data = $this->User->query('Select oktb_id From oktb_details Where oktb_no = "'.$oktb_no.'"');
        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "OKTB" and action_type = "Export Group"');
        			$this->User->query('Insert into user_action (role_id,type,action_type,date,status) values("'.$roleId.'","OKTB","Export Group","'.date('Y-m-d H:i:s').'",1) ');
        		}        
        		//echo strtotime(date('d-m-Y H:i:s')); exit;
			header('Content-type: application/vnd.ms-excel');
			header("Cache-Control: no-store, no-cache");
			header("Content-Disposition: attachment; filename=Group_OKTB-" . strtotime(date('d-m-Y H:i:s')) . ".csv");
			$handle = fopen('php://output', 'w') or die('Cannot open file:  '.$filename);
			if($this->UserAuth->getGroupName() != 'User')
			$header = array('Sr. No.','User Name','Group No','Applied Date Time','Name of Applicant','Passport No','Date/Time of Journey','Airline','PNR No','Amount','Status');
			else 
			$header = array('Sr. No.','Group No','Applied Date Time','Name of Applicant','Passport No','Date/Time of Journey','Airline','PNR No','Amount','Status');
			
			fputcsv($handle, $header,',');
			$i = 1;
			foreach($data as $d){ $airline = ''; $user = ''; $status = ''; $date = '';
			
				$airline = $this->get_master_data('oktb_airline',$d['oktb_details']['oktb_airline_name'],'a_id','a_name');
				$user = $this->get_master_data('users',$d['oktb_details']['oktb_user_id'],'id','username'); 
				$status = $this->get_master_data('tr_status_master',$d['oktb_details']['oktb_payment_status'],'tr_status_id','tr_status'); 
				$date = $d['oktb_details']['oktb_d_o_j'];
				if(strlen($d['oktb_details']['oktb_doj_time']) > 0 && $d['oktb_details']['oktb_doj_time'] != 'hh:00') $date .= ' '.$d['oktb_details']['oktb_doj_time'];
			if($this->UserAuth->getGroupName() != 'User')
				$arrData = array($i,$user,$d['oktb_details']['oktb_group_no'],$d['oktb_details']['oktb_posted_date'],$d['oktb_details']['oktb_name'],$d['oktb_details']['oktb_passportno'],$date,$airline,$d['oktb_details']['oktb_pnr'],$d['oktb_details']['oktb_airline_amount'],$status);
			else 
				$arrData = array($i,$d['oktb_details']['oktb_group_no'],$d['oktb_details']['oktb_posted_date'],$d['oktb_details']['oktb_name'],$d['oktb_details']['oktb_passportno'],$date,$airline,$d['oktb_details']['oktb_pnr'],$d['oktb_details']['oktb_airline_amount'],$status);
	   			//echo '<pre>'; print_r($arrData); exit; 
				fputcsv($handle, $arrData,',');
				$i++;
	  		}
	 		fclose($handle);		
		}
	}

 function extension_list($status = null){
 	
      	$this->autoRender = false; $data = array(); $vdata = array();
      	$userId = $this->UserAuth->getUserId();
      	if($this->UserAuth->getGroupName() != 'User') {
      		if($status == null) $vdata = $this->User->query('Select ext_id From ext_details Where ext_status = 1 order by ext_id desc'); else $vdata = $this->User->query('Select ext_id From ext_details Where ext_status = 1 and ext_payment_status = '.$status.' order by ext_id desc');
      	}else{
      		if($status == null) $vdata = $this->User->query('Select ext_id From ext_details Where ext_status = 1 and ext_user_id = '.$userId.' order by ext_id desc'); else $vdata = $this->User->query('Select ext_id From ext_details Where ext_status = 1 and ext_payment_status = '.$status.' and ext_user_id = '.$userId.' order by ext_id desc');
      	}
      	$data  = array(); $gdata = array(); $groupNo = array(); $name = array(); $visaType = array();
      	if(count($vdata) > 0){
      		$idL =Set::combine($vdata,'{n}.ext_details.ext_id','{n}.ext_details.ext_id');
      		$idlist = implode(',',$idL); $data = array(); $gdata = array();
      		if(strlen($idlist) > 0){
	      			$data = $this->User->query('Select * From ext_details Where ext_id in ('.$idlist.') order by ext_id desc');	
	      			$gdata = $this->User->query('Select * From ext_details Where ext_id in ('.$idlist.') and ext_group_id is not null order by ext_id desc');	
      		}
      	}
      	$userId = Set::combine($data,'{n}.ext_details.ext_id','{n}.ext_details.ext_user_id');
      	$groupId = Set::combine($gdata,'{n}.ext_details.ext_id','{n}.ext_details.ext_group_id');
      	$appN = array(); $userD = array(); $visa = array(); $nameData = array();
      	
      	if(count($data) > 0){
      		$userIdL = array_unique($userId);
      		$userIdList = implode(',',$userIdL);
      		$user = $this->User->query('Select username,id From users Where id in ('.$userIdList.')');
      		$userD = Set::combine($user,'{n}.users.id','{n}.users.username');
      		$groupList = implode(',',$groupId);
      		//foreach($groupId as $vd){
      		if(count($groupId) > 0 && strlen($groupList) >0){
	      		$group = $this->User->query('Select visa_tbl.app_id,visa_tbl.app_no,visa_tbl.passport_no,visa_tbl.first_name,visa_tbl.last_name,visa_app_group.visa_type From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.app_id in ('.$groupList.')');
	      		$groupNo = Set::combine($group,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
				$name = Set::combine($group,'{n}.visa_tbl.app_id',array('{0} {1} / {2} ','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name','{n}.visa_tbl.passport_no'));
				$visaType = Set::combine($group,'{n}.visa_tbl.app_id','{n}.visa_app_group.visa_type');
      			}
      		//}
      	}
      	
      		$this->set('visa',$visaType);
      		$this->set('data',$data);
      		$this->set('user',$userD);
      		$this->set('appNo',$groupNo);
      		$this->set('name',$name);
      		
      		$visaT=$this->User->query('Select visa_type_id,visa_type,status From visa_type_master Where 1');
      		$visa_ty = Set::combine($visaT,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.visa_type');
      		$visaS = Set::combine($visaT,'{n}.visa_type_master.visa_type_id','{n}.visa_type_master.status');
        	$this->set('visa_type', $visa_ty);
        	$this->set('visa_status', $visaS);
        	
        	$tr_status=$this->get_dropdown('tr_status_id', 'tr_status','tr_status_master');
        	$this->set('tr_status', $tr_status);
       //print_r($visaS); exit;
      	$this->render('extension_list');
      }
      
      public function do_not_apply_form(){
      if(isset($_POST['id']))
		{
			$this->autoRender =false;
			$this->set('check_id',$_POST['id']);
			$this->render('do_not_apply_form');
		}
      }
      
 public function do_not_apply(){
 	$this->autoRender =false;
 	if(isset($_POST['check_id']) && strlen($_POST['check_id']) > 0)
		{
		 	$exit_date = $this->request->data['exit_date'];  
		 	$reason = $this->request->data['reason'];  
		 	$userId=$this->UserAuth->getUserId();
		 	$username = $this->Session->read('UserAuth.User.username');
		 	$groupNo = array(); $name = array();
		 	//$groupId = explode(',',$_POST['check_id']);
			$data = $this->User->query('Select app_id,first_name,last_name,passport_no,app_no From visa_tbl Where app_id in ('.$_POST['check_id'].')');
			$groupNo = Set::combine($data,'{n}.visa_tbl.app_id','{n}.visa_tbl.app_no');
			$name = Set::combine($data,'{n}.visa_tbl.app_id',array('{0} {1} / {2} ','{n}.visa_tbl.first_name','{n}.visa_tbl.last_name','{n}.visa_tbl.passport_no'));
			//$visaType = Set::combine($data,'{n}.visa_tbl.app_id','{n}.visa_app_group.visa_type');
			if(count($data) > 0){
				$user_email = $this->extension_From_email();
				if(strlen($user_email) > 0)
				$this->User->DoNotApplyExtensionMail($user_email,$groupNo,$name,$username,$exit_date,$reason);
			}
			$this->User->query('Update visa_tbl set extend_status = 6,exit_date = "'.$exit_date.'",exit_reason = "'.$reason.'" Where app_id in ('.$_POST['check_id'].')');
			echo 'Success';
		}else echo 'Error';
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
	
 public function create_oktb_invoice($oktb,$oktbData,$airline,$usr_id,$amt,$pnr,$time,$camt = 0){
      	$this->autoRender = false;
     	if(count($oktbData) > 0){
     	$user = array();
     	$arr_check = array('bus_name','mob_no','pin','city','state');
     	foreach($arr_check as $a){
      	$udata = $this->User->query('Select meta_value From user_meta Where user_id = '.$usr_id.' and meta_key = "'.$a.'"');
      	$user[$a] =  $udata[0]['user_meta']['meta_value'];
     	}
     	$curr = '';
     	$curdata = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where id = '.$usr_id);
      	if(count($curdata) > 0) $curr = $curdata[0]['currency_master']['currency_code'];
     	
      	$html = '';	
        ob_start();
       
       $view = new View($this, false);
       
       if(count($oktb) > 0 && count($user) > 0){
       $view->set('oktb',$oktbData);
       $view->set('oktb_id',$oktb);
       $view->set('user',$user);
       $view->set('airline',$airline);
       $view->set('curr',$curr);
       if($camt > 0) $view->set('amt',$camt); else $view->set('amt',$amt);
       $sprice = count($oktb) * $amt;
       if($camt > 0){
       	$cprice = count($oktb) * $camt; 
       	$profit = 0; $ser_charge = 0; $ser_tax = 0; $edu_cess = 0;
      		$profit = $sprice - $cprice;
			$ser_charge = round(($profit / 112.36 *100),2) ;
			$ser_tax = (12 / 100) * $ser_charge;
			$edu_cess = (3 / 100) * $ser_tax ;
			
			$total_charge = round(($cprice + $ser_charge + $ser_tax + $edu_cess),2);
			$view->set('charge',round($ser_charge,2));
		    $view->set('tax',round($ser_tax,2));
		    $view->set('edu',round($edu_cess,2));
		    $view->set('sprice',$total_charge);
		    $view->set('admin',1);
       }else $view->set('sprice',$sprice); 
       $view->layout = null;
       $view->viewPath = "Users";
       $html .= $view->render("oktb_invoice");
       ob_end_clean();
	
		if(file_exists(WWW_ROOT.'uploads/receipt/oktb') == false)
		mkdir(WWW_ROOT.'uploads/receipt/oktb');
		 if($camt > 0){
		 $my_file = WWW_ROOT.'uploads/receipt/oktb/Receipt_('.$pnr.'-'.$time.'-A).pdf';
		 }else $my_file = WWW_ROOT.'uploads/receipt/oktb/Receipt_('.$pnr.'-'.$time.').pdf';
		if(file_exists($my_file) == false)
		$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
	//	echo $html; exit;
		
		$this->dompdf = new DOMPDF();
		$papersize='legal';
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
      
public function create_ext_invoice($extD,$admin=0){
	//print_r($extD); exit;
      	$this->autoRender = false;
     	if(count($extD) > 0){
     		
     	$name = '';	 $visa = '';
     	if(isset($extD['ext_group_id']) && $extD['ext_group_id'] != null){
     		$getname = $this->User->query('Select visa_tbl.passport_no,visa_tbl.first_name,visa_tbl.last_name,visa_app_group.visa_type From visa_tbl join visa_app_group on visa_tbl.group_id = visa_app_group.group_id Where visa_tbl.app_id ='.$extD['ext_group_id']);
     		$name = $getname[0]['visa_tbl']['first_name'] . ' ' . $getname[0]['visa_tbl']['last_name'].' / '.$getname[0]['visa_tbl']['passport_no'];
     	$vtype = $this->User->query('Select visa_type From visa_type_master Where visa_type_id = '.$getname[0]['visa_app_group']['visa_type']);
     	$visa = $vtype[0]['visa_type_master']['visa_type'];
     	}else $name = $extD['ext_name'] .' / '. $extD['ext_passportno'];
     	//echo $name; exit;
     	$user = array();
     	$arr_check = array('bus_name','mob_no','pin','city','state');
     	foreach($arr_check as $a){
      	$udata = $this->User->query('Select meta_value From user_meta Where user_id = '.$extD['ext_user_id'].' and meta_key = "'.$a.'"');
      	$user[$a] =  $udata[0]['user_meta']['meta_value'];
     	}
     	$curr = ''; $camt = 0;
     	$curdata = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where id = '.$extD['ext_user_id']);
      	if(count($curdata) > 0) $curr = $curdata[0]['currency_master']['currency_code']; else $curr = 'INR';
     	$val = array();
       	
      	$html = '';	
        ob_start();
       
       $view = new View($this, false);
       if(count($extD) > 0 ){
       $view->set('data',$extD);
       $view->set('user',$user);
       $view->set('curr',$curr);
       $view->set('name',$name);
       if(strlen($visa) > 0)
       $view->set('visa',$visa);
       if($admin == 1){
      		$val = $this->User->query('Select cost , scost From agent_ext_cost Where user_id = '.$extD['ext_user_id']);
      		if(count($val) > 0){
      			$camt = $val[0]['agent_ext_cost']['cost'];		
      		}
      	if($camt > 0){
       		$profit = 0; $ser_charge = 0; $ser_tax = 0; $edu_cess = 0;
      		$profit = $extD['ext_amt'] - $camt;
			$ser_charge =$profit / 112.36 *100 ;
			$ser_tax = (12 / 100) * $ser_charge;
			$edu_cess = (3 / 100) * $ser_tax ;
			
			$total_charge = round(($camt + $ser_charge + $ser_tax + $edu_cess),2);
			$view->set('charge',round($ser_charge,3));
		    $view->set('tax',round($ser_tax,2));
		    $view->set('edu',round($edu_cess,2));
		    $view->set('sprice',$total_charge);
		    $view->set('admin',1);
		    $view->set('price',$camt); 
       }
      }else{
      		$amt = $extD['ext_amt'];
      		$view->set('sprice',$amt);
      		$view->set('price',$amt); 
      	} 
      	
      	
       $view->layout = null;
       $view->viewPath = "Users";
       $html .= $view->render("ext_invoice");
       ob_end_clean();
	
		if(file_exists(WWW_ROOT.'uploads/receipt/ext') == false)
		mkdir(WWW_ROOT.'uploads/receipt/ext');
		 if($camt > 0){
		 $my_file = WWW_ROOT.'uploads/receipt/ext/Receipt_('.$extD['ext_no'].'-A).pdf';
		 }else $my_file = WWW_ROOT.'uploads/receipt/ext/Receipt_('.$extD['ext_no'].').pdf';
		if(file_exists($my_file) == false)
		$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
	//	echo $html; exit;
		
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
      
      public function view_ext(){
      	$this->autoRender = false;
      	if(!empty($_POST['id'])){
      		$ext = $this->User->query('Select * From ext_details Where ext_id ='.$_POST['id']);
      		if(count($ext) > 0)
      		{
      			$ext_visa = trim($ext[0]['ext_details']['ext_visa']);
      			$ext_no = trim($ext[0]['ext_details']['ext_no']);
      			$html = "<table><tr><th>Extension No. </th><td>".$ext[0]['ext_details']['ext_no']."</td></tr>
      			<tr><th>Name of Applicant </th><td>".$ext[0]['ext_details']['ext_name']."</td></tr>
      			<tr><th>Passport No. </th><td>".$ext[0]['ext_details']['ext_passportno']."</td></tr>
      			<tr><th>Ext. Fee </th><td>".$ext[0]['ext_details']['ext_amt']."</td></tr>
      			<tr><th>Visa </th><td><a href = '".$this->webroot."app/webroot/uploads/Extension/".$ext_no."/".$ext_visa."' download><img src='".$this->webroot."app/webroot/images/down.png' style='width:13px;' title='Download Visa'></a>
      			</td></tr>
      			</table>";
      			echo $html;
      		}else echo 'Error';
      	}else echo 'Error';
      }
      
      public function apply_extension_old($ext_no)
	{
		$this->autoRender =false;
		$wallet =0;	$userData=array();
		
		$res =$this->User->query('select * from ext_details where ext_no ="'.$ext_no.'"');
		if(count($res)>0 and $res[0]['ext_details']['ext_status'] == 1)
		{
		 $userId = $res[0]['ext_details']['ext_user_id']; 
		$userData = $this->User->query('Select * From user_wallet Where user_id = '.$userId);
			if(count($userData) > 0)
			{
			  $wallet =$userData[0]['user_wallet']['amount']; 
			}
			
			if($res[0]['ext_details']['ext_payment_status'] == 1)
			{
				$amt =$res[0]['ext_details']['ext_amt'];
				if($wallet > 0)
				{
				if($amt <= $wallet)
				{
					$tamt =$wallet -$amt;
					$this->User->query('Update user_wallet set amount = '.$tamt.' Where user_id = '.$userId);
					$this->User->query('Update ext_details set ext_payment_status = 2,ext_apply_date="'.date('Y-m-d H:i:s').'" Where ext_user_id = '.$userId.' and ext_id = '.$res[0]['ext_details']['ext_id']);
					$this->User->query('Insert into ext_transactions(user_id,ext_id,amount,opening_bal,closing_bal,date) Values('.$userId.','.$res[0]['ext_details']['ext_id'].',"'.$amt.'","'.$wallet.'","'.$tamt.'","'.date('d-m-Y H:i:s').'")');
					$data_id = $this->User->query('Select * from users Where id = '.$userId);
					
	        		$inv = $this->create_ext_invoice($res[0]['ext_details']);
					$ainv = $this->create_ext_invoice($res[0]['ext_details'],1);
					$einv = explode('/',$inv);
					$eainv =  explode('/',$ainv);
					$this->User->query('Update ext_details set inv_path = "'.end($einv).'",inv_apath = "'.end($eainv).'" Where ext_id = '.$res[0]['ext_details']['ext_id']);
					
					$this->User->sendApplyExt($data_id[0],$this->visa_From_email(),$res[0],$inv);
					$zip =$this->create_ext_zip_excel($ext_no);
					$zip['id']=$res[0]['ext_details']['ext_id'];
					
					if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
	        			$roleId = $this->Session->read('role1.role_id');
	        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,user_id,date,status) values("'.$roleId.'","Extension","Apply","'.$zip['id'].'","'.$userId.'","'.date('Y-m-d H:i:s').'",1) ');
	        		}
					$user_email = $this->extension_From_email();
					if(strlen($user_email) > 0)
					$this->User->sendAdminApplyExt($data_id[0],$user_email,$res[0],$zip,$ainv);
					
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
		$this->redirect(array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extension_list'));
	}
	
public function ExtVisa($extId=null,$upload=''){
        	$this->autoRender =false;
        	//echo $extId ; print_r($upload['name']); exit;
        		if ($extId != null &&  strlen($upload['name']) > 0) {
        			$email= '';
        			$data = $this->User->query('Select ext_details.ext_last_date,ext_details.ext_no,users.username,users.email,ext_details.ext_comments From ext_details join users on ext_details.ext_user_id = users.id Where ext_details.ext_id='.$extId);
        			$ext_no = trim($data[0]['ext_details']['ext_no']);
        			$email = $data[0]['users']['email'];
        			$username = $data[0]['users']['username'];
        			$comments = $data[0]['ext_details']['ext_comments'];
        			$last_date = $data[0]['ext_details']['ext_last_date'];
        			
        				if($this->UserAuth->getGroupName() != 'Admin' && $this->UserAuth->getGroupName() != 'User'){
			        			$roleId = $this->Session->read('role1.role_id');
			        			$this->User->query('Update user_action set status = 0 Where role_id = '.$roleId.' and type = "Extension" and action_type = "Upload Ext Visa" and app_no = '.$extId);
			        			$this->User->query('Insert into user_action (role_id,type,action_type,app_no,date,status) values("'.$roleId.'","Extension","Upload Ext Visa",'.$extId.',"'.date('Y-m-d H:i:s').'",1) ');
		        			}   
        				
        				if(!file_exists(WWW_ROOT.'uploads/Extension/visa/'.$ext_no))
        				mkdir(WWW_ROOT.'uploads/Extension/visa/'.$ext_no, 0777, true);
        					
        				$random =rand(111111,999999);
        				$ext = explode('.',$upload['name']);
        				$extension = $ext[1];
        				$upload_name = $ext_no.'-Visa'.$random.'.'.$extension;
        				$path =  WWW_ROOT.'uploads/Extension/visa/'.$ext_no.'/'.$upload_name;
        				move_uploaded_file($upload['tmp_name'],$path);
        				$this->User->query('Update ext_details set ext_visa_path = "'.$upload_name.'" Where ext_id = '.$extId);
        				$this->User->sendUploadExtVisaMail($ext_no,$this->visa_From_email(),$path,$email,$username,$comments,$last_date);
        				//$this->set('msg','Extension Visa Uploaded Successfully');
						
						return $path;
        		}else return 0;
        }
	
        public function UploadExtVisa($extId = null){
        	if($extId != null){
        		$this->set('extId',$extId);
        	}
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
	
	public function get_oktb_info(){
		$this->autoRender = false;
		if(!empty($_POST['id']) && $_POST['id'] != 'select'){
				$userid=$_POST['id']; $uCount = 2;
			$urgCount = $this->User->query('Select * From agent_settings Where agent_id = '.$userid.' and a_key = "urgent_date" and status = 1');
			if(count($urgCount) > 0){ $uCount = $urgCount[0]['agent_settings']['a_value'];	}
			
				$data = $this->User->query('Select amount From user_wallet Where user_id = '.$_POST['id']);
			if(count($data) > 0) $amount = $data[0]['user_wallet']['amount']; else $amount = 0;
			$data2 = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$_POST['id']);
			
			if(count($data2) > 0)
			$amount .= ' '.$data2[0]['currency_master']['currency_code'];
			else $amount .= ' INR';
			$amt_html = "<button class='btn btn-info'>Agent's Balance Amount : ".$amount."</button>";
			$ret_val = array($uCount,$amt_html);
			echo json_encode($ret_val);
			//echo $uCount;
		}else echo 'Error';
	}
	
	public function get_ext_info(){
		$this->autoRender = false;
		if(!empty($_POST['id']) && $_POST['id'] != 'select'){
			$data = $this->User->query('Select amount From user_wallet Where user_id = '.$_POST['id']);
			if(count($data) > 0) $amount = $data[0]['user_wallet']['amount']; else $amount = 0;
			$data2 = $this->User->query('Select currency_master.currency_code From users join currency_master on users.currency = currency_master.currency_id Where users.id = '.$_POST['id']);
			
			if(count($data2) > 0)
			$amount .= ' '.$data2[0]['currency_master']['currency_code'];
			else $amount .= ' INR';
			$amt_html = "<button class='btn btn-info'>Agent's Balance Amount : ".$amount."</button>";
			echo $amt_html;
		}else echo 'Error';
	}
}//End//