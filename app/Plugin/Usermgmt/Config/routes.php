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

// Routes for standard actions

Router::connect('/login', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'logout'));
Router::connect('/forgotPassword', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'forgotPassword'));
Router::connect('/activatePassword/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'activatePassword'));
Router::connect('/register', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'register'));
Router::connect('/changePassword', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'changePassword'));
Router::connect('/changeUserPassword/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'changeUserPassword'));
Router::connect('/addUser', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'addUser'));
Router::connect('/editUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'editUser'));
Router::connect('/deleteUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'deleteUser'));
Router::connect('/viewUser/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'viewUser'));
Router::connect('/userVerification/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'userVerification'));
Router::connect('/allUsers/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'index'));
Router::connect('/dashboard', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'dashboard'));
Router::connect('/permissions', array('plugin' => 'usermgmt', 'controller' => 'user_group_permissions', 'action' => 'index'));
Router::connect('/update_permission', array('plugin' => 'usermgmt', 'controller' => 'user_group_permissions', 'action' => 'update'));
Router::connect('/accessDenied', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'accessDenied'));
Router::connect('/myprofile', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'myprofile'));
Router::connect('/allGroups', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'index'));
Router::connect('/addGroup', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'addGroup'));
Router::connect('/editGroup/*', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'editGroup'));
Router::connect('/deleteGroup/*', array('plugin' => 'usermgmt', 'controller' => 'user_groups', 'action' => 'deleteGroup'));
Router::connect('/approve', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'approve'));
Router::connect('/makeActive/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'makeActive'));
Router::connect('/edit_profile/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'edit_profile'));
Router::connect('/approve_trans', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'approve_trans'));
Router::connect('/settings', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'settings'));
Router::connect('/transaction/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'transaction'));
Router::connect('/deleteTrans/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'deleteTrans'));
Router::connect('/viewTrans/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'viewTrans'));
Router::connect('/search', array('controller' => 'users', 'action' => 'search'));
Router::connect('/apply_for_visa/*', array('controller' => 'users', 'action' => 'apply_for_visa'));
Router::connect('/all_visa_app', array('controller' => 'users', 'action' => 'all_visa_app'));
Router::connect('/all_visa_app/*', array('controller' => 'users', 'action' => 'all_visa_app'));
Router::connect('/new_transaction', array('controller' => 'users', 'action' => 'new_transaction'));
Router::connect('/all_transaction', array('controller' => 'users', 'action' => 'all_transaction'));
Router::connect('/visa_app', array('controller' => 'users', 'action' => 'visa_app'));
Router::connect('/agent_trans/*', array('controller' => 'users', 'action' => 'agent_trans'));

Router::connect('/rel_master', array('controller' => 'admins', 'action' => 'rel_master'));
Router::connect('/mar_status_master', array('controller' => 'admins', 'action' => 'mar_status_master'));
Router::connect('/lang_master', array('controller' => 'admins', 'action' => 'lang_master'));
Router::connect('/religion_master', array('controller' => 'admins', 'action' => 'religion_master'));
Router::connect('/education_master', array('controller' => 'admins', 'action' => 'education_master'));
Router::connect('/profession_master', array('controller' => 'admins', 'action' => 'profession_master'));
Router::connect('/visit_master', array('controller' => 'admins', 'action' => 'visit_master'));
Router::connect('/agent_master', array('controller' => 'admins', 'action' => 'agent_master'));
Router::connect('/emp_master', array('controller' => 'admins', 'action' => 'emp_master'));
Router::connect('/passport_master', array('controller' => 'admins', 'action' => 'passport_master'));
Router::connect('/visa_master', array('controller' => 'admins', 'action' => 'visa_master'));
Router::connect('/airline_master', array('controller' => 'admins', 'action' => 'airline_master'));
Router::connect('/cities_master', array('controller' => 'admins', 'action' => 'cities_master'));
Router::connect('/country_master', array('controller' => 'admins', 'action' => 'country_master'));
Router::connect('/bank_master', array('controller' => 'admins', 'action' => 'bank_master'));
Router::connect('/tr_mode_master', array('controller' => 'admins', 'action' => 'tr_mode_master'));
Router::connect('/currency_master', array('controller' => 'admins', 'action' => 'currency_master'));
Router::connect('/tran_master', array('controller' => 'admins', 'action' => 'tran_master'));
Router::connect('/admin_tran_master', array('controller' => 'admins', 'action' => 'admin_tran_master'));
Router::connect('/ajax_action', array('controller' => 'admins', 'action' => 'ajax_action'));

Router::connect('/cost_settings', array('controller' => 'users', 'action' => 'visa_cost_settings'));
Router::connect('/edit_visa_app/*', array('controller' => 'users', 'action' => 'edit_visa_app'));
Router::connect('/deleteVisa/*', array('controller' => 'users', 'action' => 'deleteVisa'));
Router::connect('/change_cost/*', array('controller' => 'users', 'action' => 'change_cost'));
Router::connect('/save_cost', array('controller' => 'users', 'action' => 'save_cost'));
Router::connect('/view_visa_app/*', array('controller' => 'users', 'action' => 'view_visa_app'));
Router::connect('/after_payment/*', array('controller' => 'users', 'action' => 'after_payment'));
Router::connect('/viewVisaCost/*', array('controller' => 'users', 'action' => 'viewVisaCost'));
Router::connect('/save_app', array('controller' => 'users', 'action' => 'save_app'));
Router::connect('/get_data', array('controller' => 'users', 'action' => 'get_data'));
Router::connect('/edit_upload_data/*', array('controller' => 'users', 'action' => 'edit_upload_data'));
Router::connect('/get_terms', array('controller' => 'users', 'action' => 'get_terms'));
Router::connect('/upload_visa/*', array('controller' => 'users', 'action' => 'upload_visa'));
Router::connect('/upload_visa1/*', array('controller' => 'users', 'action' => 'upload_visa1'));
Router::connect('/download/*', array('controller' => 'users', 'action' => 'download'));
Router::connect('/document', array('controller' => 'users', 'action' => 'document'));
//Router::connect('/online_pay/*', array('controller' => 'users', 'action' => 'online_pay'));
//Router::connect('/afterPay/*', array('controller' => 'users', 'action' => 'afterPay'));
Router::connect('/adocument', array('controller' => 'users', 'action' => 'adocument'));
Router::connect('/export_xls/*', array('controller' => 'users', 'action' => 'export_xls'));
Router::connect('/amt_bal', array('controller' => 'users', 'action' => 'amt_bal'));
Router::connect('/zipData/*', array('controller' => 'users', 'action' => 'zipData'));
Router::connect('/app_cron', array('controller' => 'users', 'action' => 'app_cron'));
Router::connect('/all_visa_app2/*', array('controller' => 'users', 'action' => 'all_visa_app2'));
//Router::connect('/apply_oktb', array('controller' => 'users', 'action' => 'apply_oktb'));
Router::connect('/edit_oktb/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'edit_oktb'));
Router::connect('/save_edit_oktb/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'save_edit_oktb'));

Router::connect('/apply_oktb', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'apply_oktb'));
Router::connect('/apply_oktb_apps/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'apply_oktb_app_old'));
Router::connect('/oktb_apps/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'oktb_apps'));
Router::connect('/get_airline_amt', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'get_airline_amt'));
Router::connect('/oktb_airline_master', array('controller' => 'admins', 'action' => 'oktb_airline_master'));
Router::connect('/agent_airline_cost', array('controller' => 'users', 'action' => 'agent_airline_cost'));
Router::connect('/viewAirlineCost', array('controller' => 'users', 'action' => 'viewAirlineCost'));
Router::connect('/change_airline_cost/*', array('controller' => 'users', 'action' => 'change_airline_cost'));
Router::connect('/viewOktb/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'viewOktb'));
Router::connect('/get_approve_form', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'get_approve_form'));
Router::connect('/approve_oktb', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'approve_oktb'));
Router::connect('/get_oktb_comment', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'get_oktb_comment'));
Router::connect('/download_oktb_doc/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'download_oktb_doc'));
Router::connect('/quick_app', array('controller' => 'users', 'action' => 'quick_app'));
Router::connect('/save_quick_app', array('controller' => 'users', 'action' => 'save_quick_app'));
Router::connect('/quick_visa_app', array('controller' => 'users', 'action' => 'quick_visa_app'));
Router::connect('/login_as_agent/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'login_as_agent'));
Router::connect('/getAirline', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'getAirline'));
Router::connect('/getUrgAirline', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'getUrgAirline'));
Router::connect('/sendOKTBMail/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'sendOKTBMail'));
Router::connect('/urgAirline', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'urgAirline'));
Router::connect('/oktb', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'oktb'));
Router::connect('/group_oktb', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'group_oktb'));
Router::connect('/oktb_view/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'oktb_view'));
Router::connect('/download_group/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'download_group'));
Router::connect('/extension', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extension'));
Router::connect('/all_extension/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_extension'));
Router::connect('/apply_extension/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'apply_extension'));
Router::connect('/extCost', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extCost'));
Router::connect('/changeextCost', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'changeextCost'));
Router::connect('/apply_extension_for_visa', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'apply_extension_for_visa'));
Router::connect('/extension_date/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extension_date'));
Router::connect('/getVisaData', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'getVisaData'));
Router::connect('/save_visa_data', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'save_visa_data'));
Router::connect('/all_visa_extend_data', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'all_visa_extend_data'));
Router::connect('/extension_cron', array('controller' => 'users', 'action' => 'extension_cron'));
Router::connect('/editExtCost/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'editExtCost'));
Router::connect('/agentSetting', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'agentSetting'));
Router::connect('/save_settings', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'save_settings'));
Router::connect('/ext_logs', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'ext_logs'));
Router::connect('/uploadExtVisa/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'uploadExtVisa'));
Router::connect('/threshold', array('controller' => 'users', 'action' => 'threshold'));
Router::connect('/last_day', array('controller' => 'users', 'action' => 'last_day'));
Router::connect('/delete_oktb/*', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'delete_oktb'));
Router::connect('/export_group_oktb', array('plugin' => 'usermgmt', 'controller' => 'users', 'action' => 'export_group_oktb'));
Router::connect('/low_bal_cron', array('controller' => 'users', 'action' => 'low_bal_cron'));
Router::connect('/weekly_app_report', array('controller' => 'users', 'action' => 'weekly_app_report'));
Router::connect('/user_roles', array('controller' => 'users', 'action' => 'user_roles'));
Router::connect('/all_user_roles', array('controller' => 'users', 'action' => 'all_user_roles'));
Router::connect('/access_rights', array('controller' => 'users', 'action' => 'access_rights'));
Router::connect('/delete_user_roles/*', array('controller' => 'users', 'action' => 'delete_user_roles'));
Router::connect('/edit_user_roles/*', array('controller' => 'users', 'action' => 'edit_user_roles'));
Router::connect('/save_edit_roles/*', array('controller' => 'users', 'action' => 'save_edit_roles'));
Router::connect('/extension_list/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'extension_list'));
Router::connect('/apply_extension_old/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'apply_extension_old'));
Router::connect('/ExtVisa/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'ExtVisa'));
Router::connect('/change_password/*', array('plugin' => 'usermgmt','controller' => 'users', 'action' => 'changeUserRolePassword'));





