<?php 
App::uses('AppModel', 'Model');

App::uses('CakeEmail', 'Network/Email');

Class User extends AppModel { 

    var $name = 'User'; 
 var $useTable = 'visa_tbl';
 
function TransactionValidate() {
		$validate1 = array(
				"bank_type" => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Bank type'),
	
				"country" => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Country'),
		
				"trans_mode" => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Transaction Mode'),
					
				'amount'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'rule' => 'numeric',
						'message'=> 'Please enter Amount')
					),
					'bank_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Bank Name')
					),
					'bank_branch'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Bank Branch')
					),
					'account_no'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Account Number')
					),
					'trans_date'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please Select Transaction Date')
					),
				
				);
		$this->validate=$validate1;
		//return $this->validates();
	}
    
function VisaAppValidate() {
		$validate1 = array(
		'app_type'=>array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Applicant Type'
		),
		'visa_type' => array(
						'rule' => array('comparison', '!=', 'select'),
						'message'=> 'Please select Visa Type'
			),
		  'destination'=>array(
						'rule' => array('comparison', '!=', 'select'),
						'message'=> 'Please select Destination'
			),
			'citizenship' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select your Citizenship'
		),	  
		
		'tent_dd' => array(
					'rule' => array('comparison', '!=', 'dd'),
					'message'=> 'Please select Tentative Date'
		),	  
		'tent_mm' => array(
					'rule' => array('comparison', '!=', 'mm'),
					'message'=> 'Please select Tentative Month'
		),	  
		'tent_yy' => array(
					'rule' => array('comparison', '!=', 'yy'),
					'message'=> 'Please select Tentative Year'
		),	  		
		'given_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Given name'),
		),
		'surname'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Surname'),
		),
		'father_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Father name'),
		),
		
		'mother_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Mother name'),
		),
		
		'marital_status' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Marital Status'
		),
		
		'language' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Language'
		),
		
		'pre_nationality' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select your Previous Nationality'
		),
		'dob' => array(
					 'rule' => 'notEmpty',
					 
			  		 'message' => 'Must be a valid date',
		),
		'birth_place'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter your Birth place'),
		),
		'religion' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Religion'
		),
		'profession' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Profession'
		),
		'education' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Education'
		),
		'passport_no' =>array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
        'issue_date' => array(
					 'rule' => 'notEmpty',
           
			  		 'message' => 'Must be a valid date',
		),
		 'exp_date' => array(
					 'rule' => 'notEmpty',
			  		 'message' => 'Must be a valid date',
		),
		'passport_type' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Passport Type'
		),
		'issue_govt' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Issue Government'
		),
		'issue_country' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Issue Country'
		),
		'issue_place'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Issue place'),
		),
		
		'address1' =>array(
				'mustBeLonger'=>array(
						'rule' => array('minLength', 4),
						'message'=> 'Address must be greater than 4 characters',
						),
		),
		'city' =>array(
				'mustBeLonger'=>array(
						'rule' => array('minLength', 3),
						'message'=> 'City must be greater than 3 characters',
						),
		),
		'pin'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please enter Pin No.')
					),
				
		'email_id'=> array(
						'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						),
					),
		
		'telephone' =>array(
					'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please enter valid Telephone'),
						'mustBeLonger'=>array(
						'rule' => array('minLength', 10),
						'message'=> 'Telephone no. not valid',
						),
		),
		
		'company_contact' =>array(
					
						'rule' => 'numeric',
						'message'=> 'Please enter valid Company Contact'),
						'mustBeLonger'=>array(
						'rule' => array('minLength', 10),
						'message'=> ' Company Contact not valid',
							
		),	
		
		'arr_pnr_no' =>array(
                'rule'     => 'alphaNumeric',             
                'message'  => 'Alphabets and numbers only'
            ),
       	
         'arrival_flight' =>array(
                'rule'     => 'alphaNumeric',
                'message'  => 'Alphabets and numbers only'
            ),
       
			
		);
		$this->validate=$validate1;
		return $this->validates();
	}
	
public function check_value2() {
		return ($this->data['User']['visa_cost'] <= $this->data['User']['visa_scost']);
	}
	
public function VisaCostValidate()
	{
		$validate1 = array(
		'visa_type' => array(
					'rule' => array('comparison', '!=', 'select'),
					'message'=> 'Please select Visa Type'
		),
		'visa_cost' =>array(
					'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please Enter Visa Cost Price'),
						'mustBeLonger'=>array(
						'rule' => array('minLength', 1),
						'message'=> 'Please Enter Valid Visa Cost Price',
						),
		),
		'visa_scost' =>array(
					'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please Enter Visa Selling Price'),
						'mustBeLonger'=>array(
						'rule' => array('minLength', 1),
						'message'=> 'Please Enter Valid Visa Selling Price',
						),
						'mustBeGreater'=>array(
		'rule' => array('check_value2'),
		'message' => 'Selling Price should be greater than Cost Price',
	),
		),
		);
		$this->validate=$validate1;
		return $this->validates();
	}
	
public function sendApplyVisaMail($user,$from_email,$group_no,$app_type,$nameV,$inv) {
	
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		
		$email->subject('Visa Application Submitted');
		$qapp = '';
		if(strlen($app_type) > 0 && $app_type == 'quick_app'){
			$qapp = 'Quick';
		}
		if(isset($inv) and strlen($inv) > 0)
		{
      		$email->attachments($inv);
		}
		 $body="Hi ".$user['users']['username'].",
		
Congratulations!!! Your ".$qapp." Visa Application for ".$nameV." ( ".$group_no." ) is successfully submitted. 

We have received your application and will process it in time.

Amount required to process this Visa application is deducted from your wallet. 

";
if(isset($inv) and strlen($inv) > 0)
$body .= "Attached is the Invoice."; 

$body .= "<br/>
Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send apply visa mail to userid-".$userId;
		}
		$this->log($result, LOG_DEBUG);
	}
	
public function sendUploadVisaMail($group_no,$from_email,$path,$to_email,$name) {

		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($to_email);
		$email->subject('Visa Application Approved and Uploaded');
		
if(strlen($path) > 0)
		$email->attachments($path);
		
		$body="Hi ".$name.",
		
Congratulations!!! Your Visa Application with Group No - ".$group_no." is successfully approved by Admin. 

Please check the attached Visa Documents.

Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send upload visa mail ";
		}
		$this->log($result, LOG_DEBUG);
	}
	
public function sendAdminApplyVisaMail($user,$from_email,$app,$zip,$inv) {
		$from = explode(',',$from_email);
		if(count($from) > 0){ $from = array_unique($from); foreach($from as $f_email){ if(strlen($f_email) > 0){
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$fromConfig = $f_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->emailFormat('html');
		$email->to($f_email);
	
		$email->subject($user['users']['username'].' - Visa Type - '.$app[0]['visa_type']);
		$qapp = 'No';
		if(isset($app['User']['app_type'])  &&  $app['User']['app_type'] == 'quick_app')
		$qapp = 'Yes';
		$zarr =array();
		if(isset($inv) and strlen($inv) > 0)
		{
      		$zarr=array_merge($zarr,array(count($zarr)=>$inv));
		}
		
		if(isset($zip['zip_path']) and strlen($zip['zip_path']) > 0)
		{
			$zarr = array_merge($zarr,array(count($zarr)=>$zip['zip_path']));
      		
		}
		//print_r($zarr); exit;
		if(is_array($zarr) && count($zarr)) $email->attachments($zarr);
		
		if(isset($app['User']['remarks']) and strlen($app['User']['remarks'] > 0)) $remarks = $app['User']['remarks']; else $remarks = 'No Comments';
		 $body="Hi Admin,<br/><br/>
		We Have Received a New Visa Application from ".$user['users']['username']."<br/><br/>
		  
Application Details :<br/><br/>

Group No - ".$app[0]['group_no']."<br/>
Visa Type - ".$app[0]['visa_type']."<br/>
Tentative Date of Travel - ".$app[0]['tent_date']."<br/>
Number of Travellers - Adult(s) : ".$app[0]['adult']."&nbsp;&nbsp; ,Children(s) :".$app[0]['children']."&nbsp;&nbsp; , Infant(s) :".$app[0]['infants']."<br/>
Application Date -".$app[0]['app_date']."<br/>	
Quick App - ".$qapp."		
			<br/><br/>
			
<br>Application Details</b> :<br/>
<table style = 'border:2px solid #808080;font-size:smaller;'><tbody><tr style = 'background-color: #DFDFEE;'>
<th style = 'padding:3px;'>App No.</th>
<th style = 'padding:3px;'>Name of Applicant</th>
<th style = 'padding:3px;'>Passport No</th>
<th style = 'padding:3px;'>Date Of Birth</th>
<th style = 'padding:3px;'>Date Of Passport Expiry</th>
<th style = 'padding:3px;'>Profession</th>
<th style = 'padding:3px;'>Apply Date</th>
</tr>";
if(isset($app[2])){	foreach($app[2] as $a){	  
$body .= "<tr>

<td style = 'padding:3px;'>".$app[1][$a]['app_no']."</td>
<td style = 'padding:3px;'>".$app[3][$a]."</td>
<td style = 'padding:3px;'>".$app[1][$a]['passport_no']."</td>
<td style = 'padding:3px;'>".$app[1][$a]['dob_dd']."-".$app[1][$a]['dob_mm']."-".$app[1][$a]['dob_yy']."</td>
<td style = 'padding:3px;'>".$app[1][$a]['doe_dd']."-".$app[1][$a]['doe_mm']."-".$app[1][$a]['doe_yy']."</td>
<td style = 'padding:3px;'>";
if($app[1][$a]['emp_type'] == 'other') $body .= $app[1][$a]['emp_other']; else $body .= $app[1][$a]['emp_type'];
$body.= "</td>
<td style = 'padding:3px;'>".date('d-m-Y H:i:s')."</td>
</tr>";
} }
		
$body .= "</tbody></table><br/><br/>
Regards<br/>
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
	
	
public function sendVisaApprovalMail($user,$from_email,$app_data,$status,$comment) {
	
		$userId=$user['users']['id'];
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = emailFromName;
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($user['users']['email']);
		$email->subject('Visa Application Status');

		$body="Hi ".$user['users']['username'].",

Your Visa with Application no : ".$app_data['visa_app_group']['group_no']." is ".$status.".

Comments : ".$comment.".
  
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
	
public function sendAdminTransMail($user,$from_email,$transId,$trans_data) {
		// send email to newly created user
		$from = explode(',',$from_email);
		if(count($from) > 0 ){ foreach($from as $f_email){ if(strlen($f_email) > 0){
		$email = new CakeEmail();
		$fromConfig = $f_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($f_email);
		
		$email->subject('New Transaction Received');
	$body="Hi Admin ,
	
New Transaction made by ".$user[0]['users']['username']."

Transaction Amount : Rs. ".$trans_data[0]."
Transaction Mode : ".$trans_data[1]."
Transaction Date : ".date('d-m-Y',strtotime($trans_data[2]))."

		
Regards,
Online Administrator
Global Voyages | the. Travel. archer.";
	
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			// we could not send the email, ignore it
			$result="Could not send transaction admin email ";
		}
		$this->log($result, LOG_DEBUG);
		} } }
		
	}

public function check_value() {
		return ($this->data['User']['cost_price'] <= $this->data['User']['sell_price']);
	}
	
	public function AirlineCostValidate()
{
$validate1 = array(
'a_name' => array(
'rule' => array('comparison', '!=', 'select'),
'message'=> 'Please select Airline'
),
'cost_price' =>array(
'mustNotEmpty'=>array(
'rule' => 'numeric',
'message'=> 'Please Enter Charges'),
'mustBeLonger'=>array(
'rule' => array('minLength', 1),
'message'=> 'Please Enter Valid Charges',
),
),
'sell_price' =>array(
'mustNotEmpty'=>array(
'rule' => 'numeric',
'message'=> 'Please Enter Charges'),
'mustBeLonger'=>array(
'rule' => array('minLength', 1),
'message'=> 'Please Enter Valid Charges',
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


	
public function sendTransApprovalMail($user,$from_email,$transId,$trans_data) {
		// send email to newly created user
		//print_r($trans_data); exit;
	
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

Transaction Amount : Rs. ".$trans_data[0]['new_transaction']['amt']."
Transaction Mode : ".$trans_data[0]['new_transaction']['tr_mode']."
Transaction Date : ".date('d-m-Y',strtotime($trans_data[0]['new_transaction']['trans_date']))."
Available Balance : ".$trans_data[0]['new_transaction']['closing_bal']."

		
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
	
	
public function sendThresholdMail($name,$to_email,$from_email,$threshold,$currency,$once=0){
		$email = new CakeEmail();
		$fromConfig = $from_email;
		$fromNameConfig = 'Global Voyages';
		$email->from(array( $fromConfig => $fromNameConfig));
		$email->sender(array( $fromConfig => $fromNameConfig));
		$email->to($to_email);
		$email->subject('Credit Limit Set By Admin');
		
		if($once == 0)
		$bodyData = 'Congratulations!!! Your Credit limit is revised to '.$threshold.' '.$currency.' by Admin. ';
		else
		$bodyData = 'Congratulations!!! Your Credit limit is set to '.$threshold.' '.$currency.' by Admin. ';
		
		$body="Hi ".$name.",
		
".$bodyData."

Regards,
Online  Administrator
Global Voyages | the. Travel. archer.";
		try{
			$result = $email->send($body);
		} catch (Exception $ex) {
			$result="Could not send extension visa upload mail ";
		}
		$this->log($result, LOG_DEBUG);
	}
	
	
	function UserRolesValidate() {
		$validate1 = array(
				"name" => array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter Role name')
					),
		
					'username'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter username',
						'last'=>true),
						
						'mustBeLonger'=>array(
						'rule' => array('minLength', 4),
						'message'=> 'Username must be greater than 3 characters',
						'last'=>true),
					),
					
					'password'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter password')
					),
					
					'cpassword'=>array(
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
					
				'emailId'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email',
						'last'=>true),
						'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						'last'=>true),
						
					),
					
					'contact_no'=> array(
						'mustNotEmpty'=>array(
						'rule' => 'numeric',
						'message'=> 'Please enter Contact No.')
					),
			);
		$this->validate=$validate1;
		//echo $this->validates();
		return $this->validates();
	}
	
	///End///
} 
?>