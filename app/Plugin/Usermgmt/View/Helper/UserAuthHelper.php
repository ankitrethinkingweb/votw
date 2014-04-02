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
class UserAuthHelper extends AppHelper {

	/**
	 * This helper uses following helpers
	 *
	 * @var array
	 */
	var $helpers = array('Session');
	/**
	 * Used to check whether user is logged in or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isLogged() {
		return ($this->getUserId() !== null);
	}
	/**
	 * Used to get user from session
	 *
	 * @access public
	 * @return array
	 */
	public function getUser() {
		return $this->Session->read('UserAuth');
	}
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getUserId() {
		return $this->Session->read('UserAuth.User.id');
	}
	/**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getGroupId() {
		return $this->Session->read('UserAuth.User.user_group_id');
	}
	/**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function getGroupName() {
		return $this->Session->read('UserAuth.UserGroup.alias_name');
	}
	
	public function getUserAmt() {
		App::import("Model", "Usermgmt.User");
			$userModel = new User;
			$data = array();
			//print_r($_SESSION); exit;
			$userId = $this->Session->read('UserAuth.User.id');
			
			$user = array(); $c_code = 'INR'; $balance = 0;
			$user = $userModel->query('Select currency From users Where id = '.$userId.' and currency is not null');
			
			if(count($user) > 0)
			{
				$curr = $userModel->query('Select currency_code From currency_master Where currency_id = '.$user[0]['users']['currency']);	
				//print_r($curr) ;
				if(count($curr) > 0)
				$c_code = $curr[0]['currency_master']['currency_code'];
			}
			
			$userAmt = array(); $total = 0; 
			$userAmt = $userModel->query('Select * From user_wallet Where user_id = '.$userId);
        	if(count($userAmt) > 0)
        	$total = $userAmt[0]['user_wallet']['amount'];
        	
        	$thresAmt = array(); $threshold = 0; 
        	$thresAmt = $userModel->query('Select total_th From threshold Where user_id = '.$userId.' and status = 1');
        	if(count($thresAmt) > 0)
        	$threshold = $thresAmt[0]['threshold']['total_th'];
        	$threshold1 =  $threshold; 
        	$balance = $total - $threshold;
        	
        	if($balance <= 0){
        		$threshold = $threshold + $balance;
        		$balance = 0;
        	}
        	//print_r(array($balance,$threshold,$total,$c_code)); exit;
        	return array($balance,$threshold,$total,$c_code,$threshold1);
	}
	
	
}