<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AdminsController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	var $scaffold;
	public $components = array('Session');
	public $uses = array(
        'User',
        'Login',
 		'Relation'
 		);
 		 var $useTable = false;
    
public function ajax_action($master_name ='relationship'){
	
	switch($master_name)
	{
		
	case 'mar_status':
		{
			$this->Relation->useTable = 'marital_master';
			$id_key = 'marital_id';
			$value_key ='marital_status';
			$tbl_name= 'marital_master';
			break;
		}
		
	case 'relationship':
		{
			$this->Relation->useTable = 'relation_master';
			$id_key = 'relation_id';
			$value_key ='relation';
			$tbl_name= 'relation_master';
			break;
		}
		
	case 'language':
		{
			$this->Relation->useTable = 'language_master';
			$id_key = 'lang_id';
			$value_key ='language';
			$tbl_name= 'language_master';
			break;
		}
		
	case 'bank_type':
		{
			$this->Relation->useTable = 'bank_master';
			$id_key = 'type_id';
			$value_key ='bank_type';
			$tbl_name= 'bank_master';
			break;
		}
	case 'tr_mode':
		{
			$this->Relation->useTable = 'tr_mode_master';
			$id_key = 'tr_mode_id';
			$value_key ='tr_mode';
			$tbl_name= 'tr_mode_master';
			break;
		}
	case 'education':
		{
			$this->Relation->useTable = 'education_master';
			$id_key = 'education_id';
			$value_key ='education';
			$tbl_name= 'education_master';
			break;
		}
	case 'religion':
		{
			$this->Relation->useTable = 'religion_master';
			$id_key = 'religion_id';
			$value_key ='religion';
			$tbl_name= 'religion_master';
			break;
		}
	case 'profession':
		{
			$this->Relation->useTable = 'profession_master';
			$id_key = 'prof_id';
			$value_key ='profession';
			$tbl_name= 'profession_master';
			break;
		}
	case 'visit':
		{
			$this->Relation->useTable = 'visit_purpose_master';
			$id_key = 'purpose_id';
			$value_key ='purpose';
			$tbl_name= 'visit_purpose_master';
			break;
		}
	case 'agent_type':
		{
			$this->Relation->useTable = 'agent_type_master';
			$id_key = 'type_id';
			$value_key ='type';
			$tbl_name= 'agent_type_master';
			break;
		}
	case 'emp_type':
		{
			$this->Relation->useTable = 'emp_type_master';
			$id_key = 'emp_type_id';
			$value_key ='emp_type';
			$tbl_name= 'emp_type_master';
			break;
		}
		
	case 'passport':
		{
			$this->Relation->useTable = 'passport_type_master';
			$id_key = 'pass_type_id';
			$value_key ='passport_type';
			$tbl_name= 'passport_type_master';
			break;
		}
				
		case 'airline':
		{
			$this->Relation->useTable = 'airline_master';
			$id_key = 'airline_id';
			$value_key ='airline';
			$tbl_name= 'airline_master';
			break;
		}
		
		case 'city':
		{
			$this->Relation->useTable = 'travel_city_master';
			$id_key = 'travel_city_id';
			$value_key ='travel_city';
			$tbl_name= 'travel_city_master';
			break;
		}
		
	case 'country':
		{
			$this->Relation->useTable = 'country_master';
			$id_key = 'country_id';
			$value_key ='country';
			$tbl_name= 'country_master';
			break;
		}
		
	case 'currency':
		{
			$this->Relation->useTable = 'currency_master';
			$id_key = 'currency_id';
			$value_key ='currency';
			$tbl_name= 'currency_master';
			break;
		}
		
	case 'tr_status':
		{
			$this->Relation->useTable = 'tr_status_master';
			$id_key = 'tr_status_id';
			$value_key ='tr_status';
			$tbl_name= 'tr_status_master';
			break;
		}
		
	case 'admin_tr_status':
		{
			$this->Relation->useTable = 'admin_tr_status';
			$id_key = 'atr_status_id';
			$value_key ='atr_status';
			$tbl_name= 'admin_tr_status';
			break;
		}
	}
 	try {
    	if($_REQUEST['action'] == "list")
    	{
    		$data = $this->Relation->find('all',array('limit' => $_REQUEST["jtPageSize"],'offset'=>$_REQUEST["jtStartIndex"], 'order' =>  $_REQUEST["jtSorting"]));
    		$row = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    			$row[] =$r;
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Records'] = $row;
    		$jTableResult['TotalRecordCount'] = count($this->Relation->find('all'));
    		$this->autoRender = false;
    		echo json_encode($jTableResult);
    	}

    	else if($_REQUEST["action"] == "create")
    	{
    		//Insert record into database
    		$this->request->data['Relation'][$value_key] = $_POST[$value_key];
    		$this->request->data['Relation']['status'] = $_POST['status'];
    		$this->request->data['Relation']['create_date'] = date('Y-m-d');
    		$this->request->data['Relation']['update_date'] = date('Y-m-d');
    		$this->Relation->save($this->request->data);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key=>$this->Relation->getLastInsertID())));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    				
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
    	}
    	//Updating a record (updateAction)
    	else if($_REQUEST["action"] == "update")
    	{
    		$id = $_POST[$id_key];
    		$this->Relation->query("UPDATE ".$tbl_name." SET ".$value_key." = '" . $_POST[$value_key] . "', update_date = '".date("Y-m-d")."' , status = '".$_POST["status"]."'  WHERE ".$id_key." = " . $id);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key =>$id)));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		$id = $_POST[$id_key];
		$this->Relation->query("UPDATE ".$tbl_name." SET update_date = '".date("Y-m-d")."' , status = 0  WHERE ".$id_key." = " . $id);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		
		 $this->autoRender = false;
		print json_encode($jTableResult);
	}
 		}
		catch(Exception $ex)
		{
    //Return error message
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message'] = $ex->getMessage();
			
			echo  json_encode($jTableResult);
			}
		}

		public function visa_type_action(){
		
			$this->Relation->useTable = 'visa_type_master';
			$id_key = 'visa_type_id';
			$value_key ='visa_type';
			$value_key1 ='visa_cost';
			$value_key2 ='ext_status';
			$value_key3 ='visa_scost';
			$tbl_name= 'visa_type_master';
			
		 	try {
    	if($_REQUEST['action'] == "list")
    	{
    		$data = $this->Relation->find('all',array('limit' => $_REQUEST["jtPageSize"],'offset'=>$_REQUEST["jtStartIndex"], 'order' =>  $_REQUEST["jtSorting"]));
    		$row = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r[$value_key2] = $d['Relation'][$value_key2];
    			$r[$value_key3] = $d['Relation'][$value_key3];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    			$row[] =$r;
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Records'] = $row;
    		$jTableResult['TotalRecordCount'] = count($this->Relation->find('all'));
    		$this->autoRender = false;
    		echo json_encode($jTableResult);

    	}

    	else if($_REQUEST["action"] == "create")
    	{
    		//Insert record into database
    		$this->request->data['Relation'][$value_key1] = $_POST[$value_key1];
    		$this->request->data['Relation'][$value_key] = $_POST[$value_key];
    		$this->request->data['Relation'][$value_key2] = $_POST[$value_key2];
    		$this->request->data['Relation'][$value_key3] = $_POST[$value_key3];
    		$this->request->data['Relation']['status'] = $_POST['status'];
    		$this->request->data['Relation']['create_date'] = date('Y-m-d');
    		$this->request->data['Relation']['update_date'] = date('Y-m-d');
    		$this->Relation->save($this->request->data);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key=>$this->Relation->getLastInsertID())));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r[$value_key2] = $d['Relation'][$value_key2];
    			$r[$value_key3] = $d['Relation'][$value_key3];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    				
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
    	}
    	//Updating a record (updateAction)
    	else if($_REQUEST["action"] == "update")
    	{
    		$id = $_POST[$id_key];
    		$this->Relation->query("UPDATE ".$tbl_name." SET ".$value_key." = '" . $_POST[$value_key] . "',".$value_key2." = '" . $_POST[$value_key2] . "',".$value_key3." = '" . $_POST[$value_key3] . "', update_date = '".date("Y-m-d")."' ,".$value_key1." = '". $_POST[$value_key1]."', status = '".$_POST["status"]."'  WHERE ".$id_key." = " . $id);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key =>$id)));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r[$value_key2] = $d['Relation'][$value_key2];
    			$r[$value_key3] = $d['Relation'][$value_key3];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		$id = $_POST[$id_key];
		$this->Relation->query("UPDATE ".$tbl_name." SET update_date = '".date("Y-m-d")."' , status = 0  WHERE ".$id_key." = " . $id);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		
		 $this->autoRender = false;
		print json_encode($jTableResult);
	}
 		}
		catch(Exception $ex)
		{
    //Return error message
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message'] = $ex->getMessage();
			echo  json_encode($jTableResult);
			}
		}
		
public function currency_action(){
		
			$this->Relation->useTable = 'currency_master';
			$id_key = 'currency_id';
			$value_key ='currency';
			$value_key1 ='currency_code';
			$tbl_name= 'currency_master';
			
		 	try {
    	if($_REQUEST['action'] == "list")
    	{
    		$data = $this->Relation->find('all',array('limit' => $_REQUEST["jtPageSize"],'offset'=>$_REQUEST["jtStartIndex"], 'order' =>  $_REQUEST["jtSorting"]));
    		$row = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    			$row[] =$r;
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Records'] = $row;
    		$jTableResult['TotalRecordCount'] = count($this->Relation->find('all'));
    		$this->autoRender = false;
    		echo json_encode($jTableResult);

    	}

    	else if($_REQUEST["action"] == "create")
    	{
    		//Insert record into database
    		$this->request->data['Relation'][$value_key1] = $_POST[$value_key1];
    		$this->request->data['Relation'][$value_key] = $_POST[$value_key];
    		$this->request->data['Relation']['status'] = $_POST['status'];
    		$this->request->data['Relation']['create_date'] = date('Y-m-d');
    		$this->request->data['Relation']['update_date'] = date('Y-m-d');
    		$this->Relation->save($this->request->data);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key=>$this->Relation->getLastInsertID())));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    				
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
    	}
    	//Updating a record (updateAction)
    	else if($_REQUEST["action"] == "update")
    	{
    		$id = $_POST[$id_key];
    		$this->Relation->query("UPDATE ".$tbl_name." SET ".$value_key." = '" . $_POST[$value_key] . "', update_date = '".date("Y-m-d")."' ,".$value_key1." = '". $_POST[$value_key1]."', status = '".$_POST["status"]."'  WHERE ".$id_key." = " . $id);
    		$data = $this->Relation->find('all',array('conditions'=>array($id_key =>$id)));
    		$r = "";
    		foreach($data as $d){
    			$r[$id_key] = $d['Relation'][$id_key];
    			$r[$value_key] = $d['Relation'][$value_key];
    			$r[$value_key1] = $d['Relation'][$value_key1];
    			$r['create_date'] = $d['Relation']['create_date'];
    			$r['update_date'] = $d['Relation']['update_date'];
    			$r['status'] = $d['Relation']['status'];
    				
    		}
    		$jTableResult = array();
    		$jTableResult['Result'] = "OK";
    		$jTableResult['Record'] = $r;
    		$this->autoRender = false;
    		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		$id = $_POST[$id_key];
		$this->Relation->query("UPDATE ".$tbl_name." SET update_date = '".date("Y-m-d")."' ,".$value_key1." = '". $_POST[$value_key1]."', status = 0  WHERE ".$id_key." = " . $id);
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		
		 $this->autoRender = false;
		print json_encode($jTableResult);
	}
 		}
		catch(Exception $ex)
		{
    //Return error message
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message'] = $ex->getMessage();
			
			echo  json_encode($jTableResult);
			}
			
		}
		
 		public function rel_master(){
 			$this->render('/Admin/relationship');
 		}

 		public function mar_status_master(){
 			$this->render('/Admin/marital_status');
 		}
		
 public function lang_master(){
    	$this->render('/Admin/languages');
    }	   

 public function bank_master(){
    	$this->render('/Admin/bank_type');
    }
  
   public function religion_master(){
    	$this->render('/Admin/religion');
    }

   public function education_master(){
    	$this->render('/Admin/education');
    }	 
    		
   public function profession_master(){
    	$this->render('/Admin/profession');
    }	
           
   public function visit_master(){
    	$this->render('/Admin/visit');
    }	
    
   public function agent_master(){
    	$this->render('/Admin/agent_type');
    }		
    
   public function emp_master(){
    	$this->render('/Admin/emp_type');
    }
    
    public function passport_master(){
    	$this->render('/Admin/passport_type');
    }
    		
   public function visa_master(){
    	$this->render('/Admin/visa_type');
    }
 public function tr_mode_master(){
    	$this->render('/Admin/transaction_mode');
    }
   public function airline_master(){
    	$this->render('/Admin/airline');
    }
    
 public function cities_master(){
    	$this->render('/Admin/travel_cities');
    }
    
public function country_master(){
    	$this->render('/Admin/country');
    }
    
public function currency_master(){
    	$this->render('/Admin/currency');
    }
    
public function tran_master(){
    	$this->render('/Admin/transaction_status');
    }
    public function oktb_airline_master(){
$this->render('/Admin/oktb_airline');
}

public function oktb_airline(){

$this->Relation->useTable = 'oktb_airline';

if(!isset($_REQUEST['jtSorting']))
$_REQUEST['jtSorting'] = 'a_id asc';
try {
if($_REQUEST['action'] == "list")
{
$data = $this->Relation->find('all',array('limit' => $_REQUEST["jtPageSize"],'offset'=>$_REQUEST["jtStartIndex"], 'order' => $_REQUEST["jtSorting"]));
$row = "";
foreach($data as $d){
$r['a_id'] = $d['Relation']['a_id'];
$r['a_name'] = $d['Relation']['a_name'];
$r['a_price'] = $d['Relation']['a_price'];
$r['a_sprice'] = $d['Relation']['a_sprice'];
$r['a_email'] = $d['Relation']['a_email'];
$r['a_ccemail'] = $d['Relation']['a_ccemail'];
$r['a_contact'] = $d['Relation']['a_contact'];
$r['a_date'] = $d['Relation']['a_date'];
$r['status'] = $d['Relation']['status'];
$row[] =$r;
}
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Records'] = $row;
$jTableResult['TotalRecordCount'] = count($this->Relation->find('all'));
$this->autoRender = false;
echo json_encode($jTableResult);
}

else if($_REQUEST["action"] == "create")
{
//Insert record into database
$this->request->data['Relation']['a_name'] = $_POST['a_name'];
$this->request->data['Relation']['a_price'] = $_POST['a_price'];
$this->request->data['Relation']['a_sprice'] = $_POST['a_sprice'];
$this->request->data['Relation']['a_email'] = $_POST['a_email'];
$this->request->data['Relation']['a_ccemail'] = $_POST['a_ccemail'];
$this->request->data['Relation']['a_contact'] = $_POST['a_contact'];
$this->request->data['Relation']['create_date'] = date('Y-m-d');
$this->Relation->save($this->request->data);
$data = $this->Relation->find('all',array('conditions'=>array('a_id'=>$this->Relation->getLastInsertID())));
$r = "";
foreach($data as $d){
$r['a_id'] = $d['Relation']['a_id'];
$r['a_name'] = $d['Relation']['a_name'];
$r['a_price'] = $d['Relation']['a_price'];
$r['a_sprice'] = $d['Relation']['a_sprice'];
$r['a_email'] = $d['Relation']['a_email'];
$r['a_ccemail'] = $d['Relation']['a_ccemail'];
$r['a_contact'] = $d['Relation']['a_contact'];
$r['a_date'] = $d['Relation']['a_date'];
$r['status'] = $d['Relation']['status'];
}
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $r;
$this->autoRender = false;
print json_encode($jTableResult);
}
//Updating a record (updateAction)
else if($_REQUEST["action"] == "update")
{
$id = $_POST['a_id'];
$this->Relation->query("UPDATE oktb_airline SET a_date = '".date("Y-m-d")."',a_name = '". $_POST['a_name']."',a_price = '". $_POST['a_price']."',a_sprice = '". $_POST['a_sprice']."',a_email = '". $_POST['a_email']."',a_ccemail = '". $_POST['a_ccemail']."',a_contact = '". $_POST['a_contact']."', status = '".$_POST["status"]."' WHERE a_id = " . $id);
$data = $this->Relation->find('all',array('conditions'=>array('a_id' =>$id)));
$r = "";
foreach($data as $d){
$r['a_id'] = $d['Relation']['a_id'];
$r['a_name'] = $d['Relation']['a_name'];
$r['a_price'] = $d['Relation']['a_price'];
$r['a_sprice'] = $d['Relation']['a_sprice'];
$r['a_email'] = $d['Relation']['a_email'];
$r['a_ccemail'] = $d['Relation']['a_ccemail'];
$r['a_contact'] = $d['Relation']['a_contact'];
$r['a_date'] = $d['Relation']['a_date'];
$r['status'] = $d['Relation']['status'];

}
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Record'] = $r;
$this->autoRender = false;
print json_encode($jTableResult);
}
//Deleting a record (deleteAction)
else if($_GET["action"] == "delete")
{
$id = $_POST['a_id'];
$this->Relation->query("UPDATE oktb_airline SET status = 0 WHERE a_id = " . $id);
$jTableResult = array();
$jTableResult['Result'] = "OK";

$this->autoRender = false;
print json_encode($jTableResult);
}
}
catch(Exception $ex)
{
//Return error message
$jTableResult = array();
$jTableResult['Result'] = "ERROR";
$jTableResult['Message'] = $ex->getMessage();
echo json_encode($jTableResult);
}
}

public function admin_tran_master(){
    	$this->render('/Admin/admin_tran_status');
    }

    
}
