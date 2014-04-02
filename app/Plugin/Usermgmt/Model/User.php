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
App::uses('UserMgmtAppModel', 'Usermgmt.Model');
App::uses('CakeEmail', 'Network/Email');

class User extends UserMgmtAppModel {

	/**
	 * This model belongs to following models
	 *
	 * @var array
	 */
	var $belongsTo = array('Usermgmt.UserGroup');
	/**
	 * This model has following models
	 *
	 * @var array
	 */
	var $hasMany = array('LoginToken'=>array('className'=>'Usermgmt.LoginToken','limit' =>1));
	/**
	 * model validation array
	 *
	 * @var array
	 */
	var $validate = array();
	/**
	 * model validation array
	 *
	 * @var array
	 */
	function LoginValidate() {
		$validate1 = array(
				'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email or username')
					),
					'admin_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email address')
					),
				'password'=>array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter password')
					)
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	
	function AdminValidate() {
		$validate1 = array(
					'admin_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email address')
					),
					'oktb_from'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter oktb email address')
					),
					'visa_from'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter visa email address')
					),
					'admin_cost'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter admin cost')
					),
		);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * model validation array
	 *
	 * @var array
	 */
	function RegisterValidate() {
		$validate1 = array(
				"user_group_id" => array(
					'rule' => array('comparison', '!=', 0),
					'message'=> 'Please select group'),
	
					/*'agent_type'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'agenttype_dropdown',
						'message'=> 'Please Select Agent Type')
					),*/
					
				'bus_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Business name')
					),
					'username'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter username',
						'last'=>true),
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This username already taken',
					'last'=>true),
					'mustBeLonger'=>array(
						'rule' => array('minLength', 4),
						'message'=> 'Username must be greater than 3 characters',
						'last'=>true),
					),
				'old_password'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter old password')
					),
				'password'=>array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter password',
						'on' => 'create',
						'last'=>true),
						'mustBeLonger'=>array(
						'rule' => array('minLength', 6),
						'message'=> 'Password must be greater than 5 characters',
						'on' => 'create',
						'last'=>true),
						'mustMatch'=>array(
						'rule' => array('verifies'),
						'message' => 'Password must match with confirm Password field'),
						//'on' => 'create'
					),
					
				'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email',
						'last'=>true),
						'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						'last'=>true),
						'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This email is already registered',
						)
					),
					
					'contact_no'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please enter Contact No.')
					),
					
					'address'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter your Address')
					),
					
					'city'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter City')
					),
					
					'state'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter State')
					),
					
					'country'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'country_dropdown',
						'message'=> 'Please Select Country')
					),
					
					'pin'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter valid Pin no')
					),
					
					'con_name'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter ContactPerson name')
					),
					
					'con_email'=> array(
						'mustNotEmpty'=>array(
						'rule' => array('email'),
						'message'=> 'Please enter Email ID')
					),
					
					'mob_no'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please enter Mobile No.')
					),
					
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	
	function country_dropdown(){
	   $result = $this->data;
       $select = $result['User']['country'] ;
       if($select == 'select')
       return false;
       else return true;
	}
	
	function currency_dropdown(){
	   $result = $this->data;
       $select = $result['User']['currency'] ;
       if($select == 'select')
       return false;
       else return true;
	}
	
	function agenttype_dropdown(){
	   $result = $this->data;
       $select = $result['User']['agent_type'] ;
       if($select == 'select')
       return false;
       else return true;
	}
	/**
	 * Used to match passwords
	 *
	 * @access protected
	 * @return boolean
	 */
	public function verifies() {
		return ($this->data['User']['password']===$this->data['User']['cpassword']);
	}
	/**
	 * Used to send registration mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendRegistrationMail($user,$from_email) {
		// send email to newly created user
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
			//$email->cc('aziz@gbmgulf.com','visa@gbmgulf.com');

		$email->subject('Welcome to Global-Voyages - Signup Verification Mail');
		//$email->transport('Debug');
		 
		$body = "
Dear ".$user['User']['username'].",
		 
Greetings from Global Voyages!

Thank you for registering as a Travel Partner with Global-Voyages.in!

We have received your registration details and will be activating your account shortly. Once activated your login ID and password will be forwarded to your email address.

For any further assistance please feel free to write to us at support@global-voyages.in.

Thank you for your cooperation.

Regards,
Online Administrator
Global Voyages | the. Travel. archer.";

try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send registration email to userid-".$userId;

		}
		$this->log($result, LOG_DEBUG);

	}


public function sendAdminEmail($user,$from_email){
if(is_array($user)){
$email = new CakeEmail();
$fromConfig =$from_email;
$fromNameConfig = 'Global Voyages';
$email->from(array( $fromConfig => $fromNameConfig));
$email->sender(array( $fromConfig => $fromNameConfig));
$email->to($from_email);

$email->subject('New Agent Registered');

$body = " We have received a new Travel Agent application. Please find the details below:
		 
Company Name:".$user['User']['bus_name']." 

Individual Name: ".$user['User']['con_name']."

Date of Application:".$user['User']['created']." 

Contact Number: ".$user['User']['contact_no']."

Email Address: ".$user['User']['email']."

Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		 
		try{
			$result = $email->send($body); 
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin registration email to userid-".$user['User']['id'];

		}
		$this->log($result, LOG_DEBUG);
		}
}
 	
public function sendApprovalMail($user,$from_email) {
		// send email to newly created user
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		//$email->cc('aziz@gbmgulf.com','visa@gbmgulf.com');

		$email->subject('Your application is approved');
		//$email->transport('Debug');
	
	$link = Router::url("/login",true);
	$body = "
	Dear ".$user['User']['username'].",
		 
Welcome to Global Voyages.

Your application has been approved and you can now login to the portal using the username and password provided at the time of registration.

Login Here :".$link."

In case you have any logging issues you can register a complaint to info@global-voyages.in.

Thank you.

Regards,
Online Administrator
Global Voyages | the. Travel. archer.
	";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send approval email to userid-".$user['User']['id'];
		}
		$this->log($result, LOG_DEBUG);
	}
	
public function sendTransApprovalMail($user,$from_email,$transId,$trans_data) {
		// send email to newly created user
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		//$email->cc(array('aziz@gbmgulf.com','visa@gbmgulf.com'));
		$email->subject('Admin : Transaction Approval');
		//$email->transport('Debug');
	$body="Hi ".$user['User']['username']." ,
	Greetings,
	
Your transaction approved successfully for the following transaction. 

Transaction Amount : Rs. ".$trans_data['new_transaction']['amt']."
Transaction Mode : ".$trans_data['new_transaction']['tr_mode']."
Transaction Date : ".date('d-m-Y',strtotime($trans_data['new_transaction']['trans_date']))."
Available Balance : ".$trans_data['new_transaction']['closing_bal']."

		
Regards,
Online Administrator
Global Voyages | the. Travel. archer.";
	
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send transaction approval email to userid-".$user['User']['id'];
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to send email verification mail to user
	 *
	 * @access public
	 * @param array $user user detail array
	 * @return void
	 */
	public function sendVerificationMail($user,$from_email) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		//$email->cc(array('aziz@gbmgulf.com','visa@gbmgulf.com'));

		$email->subject('Signup Verification Mail');
		$activate_key = $this->getActivationKey($user['User']['password']);
		$link = Router::url("/userVerification?ident=$userId&activate=$activate_key",true);
		$body="Hi ".$user['User']['username'].",
		
Click the link below to complete your registration \n\n ".$link."

Regards,
Online Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send verification email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	public function sendConfirmationMail($user,$from_email) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
		//$email->cc(array('aziz@gbmgulf.com','visa@gbmgulf.com'));

		$email->subject('Welcome to Global-Voyages - Confirmation Mail');
		
		$body = "
Dear ".$user['User']['username'].",
		
Welcome, Thank you for your registration. Your username ".$user['User']['username']." and password As Mentioned.

Please visit our website and start applying for visas right away.

Following is our Bank details: -
A/C Name - Global Voyages
Bank - ICICI Bank Ltd.
Branch - Kalbadevi , Mumbai
A/C NO. - 642605500071
IFSC CODE - ICIC0006426

Thank You

Regards,
Online Admnistrator
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send verification email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to generate activation key
	 *
	 * @access public
	 * @param string $password user password
	 * @return hash
	 */
	public function getActivationKey($password) {
		$salt = Configure::read ( "Security.salt" );
		return md5(md5($password).$salt);
	}
	/**
	 * Used to send forgot password mail to user
	 *
	 * @access public
	 * @param array $user user detail
	 * @return void
	 */
	public function forgotPassword($user,$from_email) {
		$userId=$user['User']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['User']['email']);
	//	$email->cc(array('aziz@gbmgulf.com','visa@gbmgulf.com'));

		$email->subject(emailFromName.': Request to Reset Your Password');
		$activate_key = $this->getActivationKey($user['User']['password']);
		$link = Router::url("/activatePassword?ident=$userId&activate=$activate_key",true);
		$body= "Welcome ".$user['User']['username'].", let's help you get signed in

You have requested to have your password reset on ".emailFromName.". Please click the link below to reset your password now :

".$link."


If above link does not work please copy and paste the URL link (above) into your browser address bar to get to the Page to reset password

Choose a password you can remember and please keep it secure.

Regards,

Online Administrator

Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex){
			// we could not send the email, ignore it
			$result="Could not send forgot password email to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	/**
	 * Used to mark cookie used
	 *
	 * @access public
	 * @param string $type
	 * @param string $credentials
	 * @return array
	 */
	public function authsomeLogin($type, $credentials = array()) {
		switch ($type) {
			case 'guest':
				// You can return any non-null value here, if you don't
				// have a guest account, just return an empty array
				return array();
			case 'cookie':
				list($token, $userId) = split(':', $credentials['token']);
				$duration = $credentials['duration'];

				$loginToken = $this->LoginToken->find('first', array(
					'conditions' => array(
						'user_id' => $userId,
						'token' => $token,
						'duration' => $duration,
						'used' => false,
						'expires <=' => date('Y-m-d H:i:s', strtotime($duration)),
					),
					'contain' => false
				));
				if (!$loginToken) {
					return false;
				}
				$loginToken['LoginToken']['used'] = true;
				$this->LoginToken->save($loginToken);

				$conditions = array(
					'User.id' => $loginToken['LoginToken']['user_id']
				);
			break;
			default:
				return array();
		}
		return $this->find('first', compact('conditions'));
	}
	/**
	 * Used to generate cookie token
	 *
	 * @access public
	 * @param integer $userId user id
	 * @param string $duration cookie persist life time
	 * @return string
	 */
	public function authsomePersist($userId, $duration) {
		$token = md5(uniqid(mt_rand(), true));
		$this->LoginToken->create(array(
			'user_id' => $userId,
			'token' => $token,
			'duration' => $duration,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
		));
		$this->LoginToken->save();
		return "${token}:${userId}";
	}
	/**
	 * Used to get name by user id
	 *
	 * @access public
	 * @param integer $userId user id
	 * @return string
	 */
	public function getNameById($userId) {
		$res = $this->findById($userId);
		$name=(!empty($res)) ? $res['User']['username'] : '';
		return $name;
	}
	
	public function getPasswordById($userId) {
		$res = $this->findById($userId);
		$password=(!empty($res)) ? $res['User']['password'] : '';
		return $password;
	}
	
	public function sendApplyOKTBMail1($user,$from_email,$oktb,$oktb_no,$uCount,$inv) {
		//echo '<pre>'; //print_r($user); 
		//print_r($oktb); 
		//exit;
		
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $from_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		$urg = 0; 
		if($uCount == 0 || $uCount < 0 || $uCount == 1){ $tdate = array(date('Y-m-d')); }
		else{
			$uCnt = $uCount - 1;
			$tdate[0] = date('Y-m-d');
			for($idate = 1;$idate <= $uCnt; $idate++ ){ $tdate[$idate] = date('Y-m-d', strtotime(' +'.$idate.' day')); }
		}
		
		$group = 0;
            foreach($oktb as $k=>$o){ 	
			if(in_array($o[$k]['oktb_d_o_j'],$tdate) && $urg == 0) $urg = 1;
			if(strlen($o[$k]['oktb_group_no']) > 0 && $group == 0) $group = 1;
			}
			
			
$sub = '';
if($urg == 1) $sub .= 'Urgent - ';
if($group == 1) $sub .= 'Group ';		
		$sub .= ' OKTB Application Submission';
		$email->subject($sub);
		
	if(isset($inv) and strlen($inv) > 0)
		{
      		$email->attachments($inv);
		}
		
		$body="Hi ".$user['users']['username'].",<br/><br/>
		 
Congratulations!!! You have Successfully applied ";
if($urg == 1) $body .= "Urgent";
if($group == 1) $body .= " Group";
$body .= " OKTB Application ".$oktb_no." for OK to Board. <br/><br/>

We have received your application and will process it in time.<br/><br/>

Amount required to process this OKTB application is deducted from your wallet. <br/><br/>";

$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>OKTB No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>PNR No</th>
<th style = 'padding:3px;'>Date of Journey</th>
<th style = 'padding:3px;'>Time of Journey</th>
<th style = 'padding:3px;'>Airline</th>
<th style = 'padding:3px;'>Passport</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
<th style = 'padding:3px;'>From Ticket</th>
<th style = 'padding:3px;'>To Ticket</th>
</tr>";
		
		foreach($oktb as $k=>$o){		

$body .= "<tr>
<td style = 'padding:3px;'>".$k."</td>
<td style = 'padding:3px;'>". $o[$k]['oktb_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_d_o_j']."</td>";
if($o[$k]['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$o[$k]['oktb_doj_time']."</td>"; else $body .= "<td>NA</td>";
$body .= "<td style = 'padding:3px;'>".$o['airline_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passport']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_visa']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_to_ticket']."</td>

</tr>";
		
		}
		

$body .= "</tbody></table><br/><br/>";
if(isset($inv) and strlen($inv) > 0)
$body .= " Attached is the Invoice.<br/><br/>";
$body .= "Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send apply oktb mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	public function sendAdminApplyOKTBMail1($user,$from_email,$oktb,$zip=array(),$oktb_no,$uCount,$inv) {
			
		$from = explode(',',$from_email);
		//$from = array_unique($from);

		if(count($from) > 0 ){ $from = array_unique($from); foreach($from as $f_email){ if(strlen($f_email) > 0){
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $f_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($f_email);
		
		$zarr =array(); //$urg = 0; $tdate = array(date('Y-m-d'),date('Y-m-d', strtotime(' +1 day')));
		
		$urg = 0;  $group = 0;
		if($uCount == 0 || $uCount < 0 || $uCount == 1){ $tdate = array(date('Y-m-d')); }
		else{
			$uCnt = $uCount - 1;
			$tdate[0] = date('Y-m-d');
			for($idate = 1;$idate <= $uCnt; $idate++ ){ $tdate[$idate] = date('Y-m-d', strtotime(' +'.$idate.' day')); }
		}
		$zarr = array();
        foreach($oktb as $k=>$o){ 	
			if(in_array($o[$k]['oktb_d_o_j'],$tdate) && $urg == 0) $urg = 1;
			if(strlen($o[$k]['oktb_group_no']) > 0 && $group == 0) $group = 1;
			if(isset($zip[$k]['zip_path']) and strlen($zip[$k]['zip_path']) > 0)
			{
				$zarr=array_merge($zarr,array($zip[$k]['zip_path'])); //$zarr+array($zip[$k]['zip_path']);
			}
		}
		
		if(isset($inv) and strlen($inv) > 0)
		{
      		$zarr = array_merge($zarr,array(count($zarr)=>$inv));
		}
		//print_r($zarr); exit;	
		if(count($zarr) > 0) $email->attachments($zarr);
		
		$sub = $user['users']['username'];
		if($urg == 1) $sub .= ' - Urgent';
		if($group == 1) $sub .= ' Group';
		$sub .= ' OKTB Application- '.$oktb_no;
		$email->subject($sub);
		//$email->transport('Debug');
		
	if(count($zarr) > 0)	
	$email->attachments($zarr);

		
$body="<strong>Hi Admin</strong>,<br/><br/>
		
We Have Received a New ";
if($urg == 1) $body .= "Urgent";
if($group == 1) $body .= " Group";
$body .= " OKTB Application From ".$user['users']['username']."<br/><br/>";
		
$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
		<th style = 'padding:3px;'>OKTB No.</th>
		<th style = 'padding:3px;'>Applicant Name</th>
		<th style = 'padding:3px;'>PNR No</th>
		<th style = 'padding:3px;'>Date of Journey</th>
		<th style = 'padding:3px;'>Time of Journey</th>
		<th style = 'padding:3px;'>Airline</th>
        <th style = 'padding:3px;'>Amount</th>
		<th style = 'padding:3px;'>Passport</th>
		<th style = 'padding:3px;'>Passport No</th>
		<th style = 'padding:3px;'>Visa</th>
		<th style = 'padding:3px;'>From Ticket</th>
		<th style = 'padding:3px;'>To Ticket</th>
		<th style = 'padding:3px;'>Posted Date</th>
		<th style = 'padding:3px;'>Payment Date</th>
		</tr>";
		
		foreach($oktb as $k=>$o){		

$body .= "<tr>
<td style = 'padding:3px;'>".$k."</td>
<td style = 'padding:3px;'>". $o[$k]['oktb_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_d_o_j']."</td>";
if($o[$k]['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$o[$k]['oktb_doj_time']."</td>"; else $body .= "<td style = 'padding:3px;'>NA</td>";
$body .= "<td style = 'padding:3px;'>".$o['airline_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_airline_amount']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passport']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_visa']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_to_ticket']."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s',strtotime($o[$k]['oktb_posted_date']))."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s',strtotime($o[$k]['payment_date']))."</td>
</tr>";

}

$body .= "</tbody></table><br/><br/>

Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin apply visa mail email ";
		}
		$this->log($result, LOG_DEBUG);
		} } }
	
	}
	
		public function sendAirlineApplyOKTBMail1($from_email,$oktb,$zip=array(),$r,$uCount) {
			//echo '<pre>'; print_r($oktb); print_r($zip); 
	$a = array(); $air = array(); $air2 = array(); $a2 = array(); $air_ccemail = array(); $air_email = array();
	foreach($oktb as $k=>$o){	
		$air = explode(',',$o['airline_email']);
		$air_email = array_merge($a,$air);
		if($o['airline_ccemail'] != null)
		$air2 = explode(',',$o['airline_ccemail']);
		$air_ccemail = array_merge($a2,$air2);
	}

	$email = new CakeEmail();
	$email->emailFormat('html');
	foreach($air_email as $air_em)
	{
		if(strlen($air_em) > 0){
		$air_em =trim($air_em);
		$fromConfig = $from_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($air_em);
		if(count($air_ccemail) > 0){
			$email->cc($air_ccemail);
		}
		
		$zarr =array(); //$urg = 0; $tdate = array(date('Y-m-d'),date('Y-m-d', strtotime(' +1 day')));

		$urg = 0; $group = 0;
		if($uCount == 0 || $uCount < 0 || $uCount == 1){ $tdate = array(date('Y-m-d')); }
		else{
			$uCnt = $uCount - 1;
			$tdate[0] = date('Y-m-d');
			for($idate = 1;$idate <= $uCnt; $idate++ ){ $tdate[$idate] = date('Y-m-d', strtotime(' +'.$idate.' day')); }
		}
		
               foreach($oktb as $k=>$o){ 	
			if(in_array($o[$k]['oktb_d_o_j'],$tdate) && $urg == 0) $urg = 1;
			if(strlen($o[$k]['oktb_group_no']) > 0 && $group == 0) $group = 1;
			if(isset($zip[$k]['zip_path']) and strlen($zip[$k]['zip_path']) > 0)
			{
	      		$zarr =array_merge($zarr,array($zip[$k]['zip_path'])); //$zarr +array($zip[$k]['zip_path']);
			}
		}
		$sub = '';
if($urg == 1) $sub .= 'Urgent - ';
		$sub .= 'Verification of User Details For ';
if($group == 1) $sub .= 'Group';
      $sub .= ' OKTB Application';
		$email->subject($sub);
		
if(count($zarr) > 0)
	$email->attachments($zarr);
		
		$body="Hello,<br/><br/>
		
We Have Received a New ";
if($urg == 1) $body .= "Urgent";
if($group == 1) $body .= " Group";
$body .= " OKTB Application.<br/><br/>";

$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
		<th style = 'padding:3px;'>OKTB No.</th>
		<th style = 'padding:3px;'>Applicant Name</th>
		<th style = 'padding:3px;'>PNR No</th>
		<th style = 'padding:3px;'>Date of Journey</th>
		<th style = 'padding:3px;'>Time of Journey</th>
		<th style = 'padding:3px;'>Airline</th>
		<th style = 'padding:3px;'>Passport</th>
		<th style = 'padding:3px;'>Passport No</th>
		<th style = 'padding:3px;'>Visa</th>
		<th style = 'padding:3px;'>From Ticket</th>
		<th style = 'padding:3px;'>To Ticket</th>
		
		</tr>";
			
		foreach($oktb as $k=>$o){		
			
$body .= "<tr>
<td style = 'padding:3px;'>".$k."</td>
<td style = 'padding:3px;'>". $o[$k]['oktb_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_d_o_j']."</td>";
if($o[$k]['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$o[$k]['oktb_doj_time']."</td>"; else $body .= "<td style = 'padding:3px;'>NA</td>";
$body .= "<td style = 'padding:3px;'>".$o['airline_name']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passport']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_visa']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$o[$k]['oktb_to_ticket']."</td>

</tr>";
		}
		
$body .= "</tbody></table><br/><br/>

Online  Administrator<br/>
Global Voyages | the. Travel. archer.<br/>";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin apply visa mail email ";
		}
		$this->log($result, LOG_DEBUG);
	}
	}
}
	
		
		public function sendApproveOKTBMail($user,$from_email,$oktb) {
	
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		if(isset($oktb['oktb_details']['oktb_group_no']) && strlen($oktb['oktb_details']['oktb_group_no']) > 0 && $oktb['oktb_details']['oktb_group_no'] != null)
		$oktb_no = $oktb['oktb_details']['oktb_group_no']; else $oktb_no = $oktb['oktb_details']['oktb_no'];
		$email->subject('Approved OKTB Application :'.$oktb_no);
		$body="Hi ".$user['users']['username'].",
		 
Congratulations!!! OKTB Application ".$oktb_no." is approved successfully. 

Applicant Name: ". $oktb['oktb_details']['oktb_name']."
		
PNR No :".$oktb['oktb_details']['oktb_pnr']."

Date of Journey :".$oktb['oktb_details']['oktb_d_o_j']."

Airline :".$oktb['oktb_details']['airline_name']."

From Ticket :".$oktb['oktb_details']['oktb_from_ticket']."

To Ticket :".$oktb['oktb_details']['oktb_to_ticket']."

OKTB Comment :".$oktb['oktb_details']['oktb_approve_comments']."

Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			$result="Could not send apply oktb mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
		}
		
		public function sendApplyOKTBMail($user,$from_email,$oktb,$inv) {
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $from_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		$email->subject('Successful OKTB Application Submission');
		if(isset($inv) and strlen($inv) > 0)
		{
      		$email->attachments($inv);
		}
		
		$body="Hi ".$user['users']['username'].",<br/><br/> 
		 
Congratulations!!! You have successfully applied OKTB Application ".$oktb['oktb_details']['oktb_no']." for OK to Board. <br/><br/> 

We have received your application and will process it in time.<br/><br/> 

Amount required to process this OKTB application is deducted from your wallet.<br/><br/> 
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>OKTB No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>PNR No</th>
<th style = 'padding:3px;'>Date of Journey</th>
<th style = 'padding:3px;'>Time of Journey</th>
<th style = 'padding:3px;'>Airline</th>
<th style = 'padding:3px;'>Passport</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
<th style = 'padding:3px;'>From Ticket</th>
<th style = 'padding:3px;'>To Ticket</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_no']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_d_o_j']."</td>";
if($oktb['oktb_details']['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_doj_time']."</td>"; else $body .= "<td>NA</td>";
$body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['airline_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passport']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_visa']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_to_ticket']."</td>
</tr>";
		

$body .= "</tbody></table><br/><br/>";
if(isset($inv) and strlen($inv) > 0)
$body .= " Attached is the Invoice.<br/><br/>";
$body .= "Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			$result="Could not send apply oktb mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	public function sendAdminApplyOKTBMail($user,$from_email,$oktb,$zip,$inv) {
		$userId=$user['users']['id'];
        $from = explode(',',$from_email);
		if(count($from) > 0 ){ $from = array_unique($from); foreach($from as $f_email){ if(strlen($f_email) > 0){
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $f_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($f_email);
		$email->subject($user['users']['username'].' - OKTB Application- '.$oktb['oktb_details']['oktb_no']);
		
		$zarr = array();
		if(isset($inv) and strlen($inv) > 0)
		{
      		$zarr = array_merge($zarr,array(count($zarr)=>$inv));
		}
		if(isset($zip['zip_path']) and strlen($zip['zip_path']) > 0)
		{
			$zarr = array_merge($zarr,array(count($zarr)=>$zip['zip_path']));
		}
	
		if(count($zarr) > 0) $email->attachments($zarr);
		$body="Hi Admin,<br/><br/>
		
		We Have Received a New OKTB Application From ".$user['users']['username']."<br/><br/>
		
		Application Details :<br/><br/>
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>OKTB No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>PNR No</th>
<th style = 'padding:3px;'>Date of Journey</th>
<th style = 'padding:3px;'>Time of Journey</th>
<th style = 'padding:3px;'>Airline</th>
<th style = 'padding:3px;'>Passport</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
<th style = 'padding:3px;'>From Ticket</th>
<th style = 'padding:3px;'>To Ticket</th>
<th style = 'padding:3px;'>Posted Date</th>
<th style = 'padding:3px;'>Payment Date</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_no']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_d_o_j']."</td>";
if($oktb['oktb_details']['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_doj_time']."</td>"; else $body .= "<td>NA</td>";
$body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['airline_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passport']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_visa']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_to_ticket']."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s',strtotime($oktb['oktb_details']['oktb_posted_date']))."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s',strtotime($oktb['oktb_details']['payment_date']))."</td>
</tr>";
		
		
$body .= "</tbody></table><br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";


		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin apply visa mail email ";
		}
		$this->log($result, LOG_DEBUG);
}  } }
	}
	
		public function sendAirlineApplyOKTBMail($airline,$from_email,$oktb,$zip) {
	//	$userId=$user['users']['id'];
		$air_ccemail  =array(); $air_cc  = array();
		$email = new CakeEmail();
		$email->emailFormat('html');
		$air = $airline['oktb_airline']['a_email'];
		$air_email = explode(',',$air);
		if($airline['oktb_airline']['a_ccemail'] != null)
		$air_cc = $airline['oktb_airline']['a_ccemail'];
		$air_ccemail = explode(',',$air_cc);
		
	foreach($air_email as $air_em)
	{
		if(strlen($air_em) > 0){
		$air_em =trim($air_em);
		$fromConfig = $from_email;
		$fromNameConfig = 'OKTB Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($air_em);
		if(count($air_ccemail) > 0){
			$email->cc($air_ccemail);
		}
		//$email->cc('aziz@gbmgulf.com');
		//$email->cc('visa@gbmgulf.com');
		$email->subject('Verification of User Details For OKTB Application');
		//$email->transport('Debug');
		
		if(isset($zip['zip_path']) and strlen($zip['zip_path']) > 0)
		{
      		$email->attachments($zip['zip_path']);
		}
		 
$body="Hello,<br/><br/>
We Have Received a New OKTB Application.<br/><br/>
Application Details :<br/>

<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>OKTB No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>PNR No</th>
<th style = 'padding:3px;'>Date of Journey</th>
<th style = 'padding:3px;'>Time of Journey</th>
<th style = 'padding:3px;'>Airline</th>
<th style = 'padding:3px;'>Passport</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
<th style = 'padding:3px;'>From Ticket</th>
<th style = 'padding:3px;'>To Ticket</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_no']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_pnr']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_d_o_j']."</td>";
if($oktb['oktb_details']['oktb_doj_time'] != 'hh:00') $body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_doj_time']."</td>"; else $body .= "<td>NA</td>";
$body .= "<td style = 'padding:3px;'>".$oktb['oktb_details']['airline_name']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passport']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_passportno']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_visa']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_from_ticket']."</td>
<td style = 'padding:3px;'>".$oktb['oktb_details']['oktb_to_ticket']."</td>
</tr>";
		
		
$body .= "</tbody></table><br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";
		
//echo $body; exit;
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin apply visa mail email ";
		}
		$this->log($result, LOG_DEBUG);
	}
	}
}

public function check_value() {
		return ($this->data['User']['ext_cost'] <= $this->data['User']['ext_scost']);
	}
	
public function ExtCostValidate()
{
$validate1 = array(
'agent' => array(
'rule' => array('comparison', '!=', 'select'),
'message'=> 'Please select an Agent'
),
'ext_cost' =>array(
	'mustNotEmpty'=>array(
		'rule' => 'numeric',
		'message'=> 'Please Enter Extension Charges'),
		'mustBeLonger'=>array(
			'rule' => array('minLength', 1),
			'message'=> 'Please Enter a Valid Extension Charges',
	),
),
'ext_scost' =>array(
	'mustNotEmpty'=>array(
		'rule' => 'numeric',
		'message'=> 'Please Enter Extension Charges'),
		'mustBeLonger'=>array(
			'rule' => array('minLength', 1),
			'message'=> 'Please Enter a Valid Extension Charges',
	),
	'mustBeGreater'=>array(
		'rule' => array('check_value'),
		'message' => 'Selling Price should be greater than Cost Price',
	),
					
),
);
$this->validate=$validate1;
return $this->validates();
}

public function sendApplyExtMail($user,$from_email,$visaD,$total,$extNo,$path) {
		
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $from_email;
		$fromNameConfig = 'Extension(s)';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		$email->subject('Extension Submission');
			if(isset($path) and strlen($path) > 0)
			{
	      		$email->attachments($path);
			}
		$body="Hi ".$user['users']['username'].",<br/><br/>
		 
Congratulations!!! You have Successfully applied for Extension ".$extNo." <br/><br/>

We have received your application and will process it in time.<br/><br/>

Amount required to process this Extension application is deducted from your wallet. <br/><br/>

Application Details :<br/>
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>Extension No.</th>
<th style = 'padding:3px;'>Visa App Details</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>Visa Type</th>
<th style = 'padding:3px;'>Extension Fee</th>
<th style = 'padding:3px;'>Apply Date</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$extNo."</td>
<td style = 'padding:3px;'>".$visaD['app_no']."</td>
<td style = 'padding:3px;'>".$visaD['first_name'].' '.$visaD['last_name']."</td>
<td style = 'padding:3px;'>".$visaD['visa_type']."</td>
<td style = 'padding:3px;'>".$total."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s')."</td>
</tr>";
		
		
$body .= "</tbody></table><br/><br/>";
if(isset($path) and strlen($path) > 0)
$body .= " Attached is the Invoice.<br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

	try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send apply extension mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	
	public function sendAdminApplyExtMail($user,$from_email,$visaD,$total,$extNo,$path) {
		
		$from = explode(',',$from_email);
		if(count($from) > 0 ){ foreach($from as $f_email){ if(strlen($f_email) > 0){
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $f_email;
		$fromNameConfig = 'Extension Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($f_email);
		$email->subject($user['users']['username'].' - Extension Application- '.$extNo);
			if(isset($path) and strlen($path) > 0)
		{
      		$email->attachments($path);
		}
		$body="Hi Admin,<br/><br/>
		
		We Have Received a New Extension Application From ".$user['users']['username']."<br/><br/>
		
		Application Details :<br/><br/>
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>Extension No.</th>
<th style = 'padding:3px;'>Visa App Details</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>Visa Type</th>
<th style = 'padding:3px;'>Extension Fee</th>
<th style = 'padding:3px;'>Apply Date</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$extNo."</td>
<td style = 'padding:3px;'>".$visaD['app_no']."</td>
<td style = 'padding:3px;'>".$visaD['first_name'].' '.$visaD['last_name']."</td>
<td style = 'padding:3px;'>".$visaD['visa_type']."</td>
<td style = 'padding:3px;'>".$total."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s')."</td>
</tr>";
		
		
$body .= "</tbody></table><br/><br/>";
if(isset($path) and strlen($path) > 0)
$body .= " Attached is the Invoice.<br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send admin apply extension mail ";
		}
		$this->log($result, LOG_DEBUG);
		} } } 
	}
	
	
	public function sendExtApprovalMail($data,$from_email) {
	
		$userId=$data[0]['users']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($data[0]['users']['email']);
		$email->subject('Admin Approved your Extension Visa Application');
	
 $body="Hi ".$data[0]['users']['username'].",
 
Please know that we have extended the Visas with Extension No - ".$data[0]['ext_details']['ext_no'].". 
According to the Extension page their last date in Dubai is ".$data[0]['ext_details']['ext_last_date'].". 
Please request your client to exit on or before ".$data[0]['ext_details']['ext_last_date'].".

Please revert once your client confirms.

Thank You
  
Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
//echo $body; exit;
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send email agent visa approval mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	
	public function sendUploadExtVisaMail($ext_no,$from_email,$path,$to_email,$name,$comment,$last_date) {
		$from = explode(',',$from_email);
		//$from = array_unique($from);

		if(count($from) > 0 ){ $from = array_unique($from); foreach($from as $f_email){ if(strlen($f_email) > 0){
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($to_email);
		$email->subject('Extension Visa Application Approved and Uploaded');
		
if(strlen($path) > 0)
$email->attachments($path);
		
		$body="Hi ".$name.",
		
Congratulations!!! Your Visa Extension No - ".$ext_no." is successfully approved by Admin. 

According to the Extension page their last date in Dubai is ".$last_date.".
 
Please request your client to exit on or before ".$last_date.".

Please revert once your client confirms.

Comments - ".$comment."

Please check the attached Extension Visa Documents.

Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			$result="Could not send extension visa upload mail ";
		}
		$this->log($result, LOG_DEBUG);
		} } }
	}
	
	
	public function DoNotApplyExtensionMail($from_email,$appNo,$name,$username,$date,$reason) {
		$from = explode(',',$from_email);
		//print_r($appNo); exit;
		if(count($from) > 0 ){ foreach($from as $f_email){ if(strlen($f_email) > 0){ 
        	$emailBody = '';
        	$email = new CakeEmail();
        	$email->emailFormat('html');
        	$fromConfig = $f_email;
        	$fromNameConfig = 'Extension Visa';
        	$email->from(array( $fromConfig => $fromNameConfig));
        	$email->sender(array( $fromConfig => $fromNameConfig));
        	$email->to($f_email);

            $sub = 'Extension Details'; 
        	$email->subject($sub);
   
        	$body="Hello Admin ,<br/><br/>
 <b>Exit Information of following Visa Application(s) by Agent - ".$username."</b>.<br/><br/>";
  if(count($appNo) > 0 ){ 
$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>App No. </th>
<th style = 'padding:3px;'>Name </th>
<th style = 'padding:3px;'>Exit Date </th>
<th style = 'padding:3px;'>Reason </th>
</tr>";
 foreach($appNo as $a=>$app)  {  
$body .= "<tr>

<td style = 'padding:3px;'>".$app."</td>
<td style = 'padding:3px;'>".$name[$a]."</td>
<td style = 'padding:3px;'>".$date."</td>
<td style = 'padding:3px;'>".$reason."</td>
</tr>";
  }
 }		
	
$body .= "</tbody></table><br/><br/>";
$body .= "Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

        	try{
        		$result = $email->send($body);
        	} catch (Exception $ex) {
        		// we could not send the email, ignore it
        		$result="Could not send cron email ";
        	}
        	$this->log($result, LOG_DEBUG);
		} } } 
	
		}
		
	public function sendApplyExt($user,$from_email,$ext,$path) {
		
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $from_email;
		$fromNameConfig = 'Extension Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		//$email->cc(array('aziz@gbmgulf.com','visa@gbmgulf.com'));		
		$email->subject('Extension Submission');
		
		if(strlen($path) > 0)
$email->attachments($path);
		//$email->transport('Debug');
		$body="Hi ".$user['users']['username'].",<br/><br/>
		 
Congratulations!!! You have Successfully applied for Extension ".$ext['ext_details']['ext_no']." <br/><br/>

We have received your application and will process it in time.<br/><br/>

Amount required to process this Extension application is deducted from your wallet. <br/><br/>";

$body .= "<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>Extension No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
</tr>";

$body .= "<tr>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_no']."</td>
<td style = 'padding:3px;'>". $ext['ext_details']['ext_name']."</td>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_passportno']."</td>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_visa']."</td>
</tr>";
		
$body .= "</tbody></table><br/><br/>";
if(isset($path) and strlen($path) > 0)
$body .= " Attached is the Invoice.<br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send apply extension mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
	
	public function sendAdminApplyExt($user,$from_email,$ext,$zip,$path) {
		$from = explode(',',$from_email);
		
		if(count($from) > 0 ){ foreach($from as $f_email){ if(strlen($f_email) > 0){
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$email->emailFormat('html');
		$fromConfig = $f_email;
		$fromNameConfig = 'Extension Application';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($f_email);
		$email->subject($user['users']['username'].' - Extension Application- '.$ext['ext_details']['ext_no']);
		
		$zarr = array();
		if(isset($zip['zip_path']) and strlen($zip['zip_path']) > 0)
		{
      		$zarr = array_merge($zarr,array(count($zarr) => $zip['zip_path']));
		}
		
		
		if(isset($path) and strlen($path) > 0)
		{
      		$zarr = array_merge($zarr,array(count($zarr) => $path));
		}
		
		if(count($zarr) > 0) $email->attachments($zarr);
		$body="Hi Admin,<br/><br/>
		
		We Have Received a New Extension Application From ".$user['users']['username']."<br/><br/>
		
		Application Details :<br/><br/>
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>Extension No.</th>
<th style = 'padding:3px;'>Applicant Name</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Visa</th>
<th style = 'padding:3px;'>Posted Date</th>
<th style = 'padding:3px;'>Payment Date</th>
</tr>
<tr>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_no']."</td>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_name']."</td>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_passportno']."</td>
<td style = 'padding:3px;'>".$ext['ext_details']['ext_visa']."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s',strtotime($ext['ext_details']['ext_date']))."</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s')."</td>
</tr>";
		
		
$body .= "</tbody></table><br/><br/>";
if(isset($path) and strlen($path) > 0)
$body .= " Attached is the Invoice.<br/><br/>
Regards,<br/>
Online  Administrator<br/>
Global Voyages | the. Travel. archer.";

		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			
			$result="Could not send admin apply extension mail ";
		}
		$this->log($result, LOG_DEBUG);
		} } }
	}
////End////		
}