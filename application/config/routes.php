<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'Login/logout';

$route['Administrator'] = 'Administrator/Page';
$route['module/(:any)'] = 'Administrator/Page/module/$1';
$route['brachAccess/(:any)'] = 'Administrator/Login/brach_access/$1';
$route['getBrachAccess'] = 'Administrator/Login/branch_access_main_admin';

$route['area'] = 'Administrator/Page/area';
$route['insertarea'] = 'Administrator/Page/insert_area';
$route['areadelete'] = 'Administrator/Page/areadelete';
$route['areaedit/(:any)'] = 'Administrator/Page/areaedit/$1';
$route['areaupdate'] = 'Administrator/Page/areaupdate';
$route['get_districts'] = 'Administrator/Page/getDistricts';

//========================================= Client Route ======================================
$route['customer'] = 'Administrator/Customer';
$route['customer/(:any)'] = 'Administrator/Customer/editCustomer/$1';
$route['customerList'] = 'Administrator/Customer/customerList';
$route['customerList/(:any)'] = 'Administrator/Customer/customerList/$1';
$route['pending_customerList'] = 'Administrator/Customer/pendingcustomerList';
$route['active_customerList'] = 'Administrator/Customer/activecustomerList';
$route['add_customer'] = 'Administrator/Customer/addCustomer';
$route['update_customer'] = 'Administrator/Customer/updateCustomer';
$route['assign_customer'] = 'Administrator/Customer/assignCustomer';
$route['delete_customer'] = 'Administrator/Customer/deleteCustomer';
$route['get_customers'] = 'Administrator/Customer/getCustomers';
//sale
$route['sale_customer'] = 'Administrator/SaleCustomer';
$route['sale_customer/(:any)'] = 'Administrator/SaleCustomer/editCustomer/$1';
$route['sale_customerList'] = 'Administrator/SaleCustomer/customerList';
$route['sale_customerList/(:any)'] = 'Administrator/SaleCustomer/customerList/$1';
$route['pending_sale_customerList'] = 'Administrator/SaleCustomer/pendingcustomerList';
$route['active_sale_customerList'] = 'Administrator/SaleCustomer/activecustomerList';
$route['add_sale_customer'] = 'Administrator/SaleCustomer/addCustomer';
$route['update_sale_customer'] = 'Administrator/SaleCustomer/updateCustomer';
$route['assign_sale_customer'] = 'Administrator/SaleCustomer/assignCustomer';
$route['delete_sale_customer'] = 'Administrator/SaleCustomer/deleteCustomer';
$route['get_sale_customers'] = 'Administrator/SaleCustomer/getCustomers';

//report rent
$route['rent_report/(:any)'] = 'Administrator/Reports/showRentReport/$1';
$route['add_rent_report'] = 'Administrator/Reports/addRentReport';
$route['delete_rent_report'] = 'Administrator/Reports/deleteRentReport';
$route['get_rent_report'] = 'Administrator/Reports/getRentReport';
$route['rent_report_list'] = 'Administrator/Reports/rentReportList';
$route['call_rent_report_list'] = 'Administrator/Reports/callrentReportList';
$route['visit_rent_report_list'] = 'Administrator/Reports/visitrentReportList';
$route['reject_rent_report_list'] = 'Administrator/Reports/rejectrentReportList';
$route['success_rent_report_list'] = 'Administrator/Reports/successrentReportList';
$route['call_sale_report_list'] = 'Administrator/Reports/callsaleReportList';
$route['visit_sale_report_list'] = 'Administrator/Reports/visitsaleReportList';
$route['reject_sale_report_list'] = 'Administrator/Reports/rejectsaleReportList';
$route['success_sale_report_list'] = 'Administrator/Reports/successsaleReportList';

//report sale
$route['sale_report/(:any)'] = 'Administrator/Reports/showSaleReport/$1';
$route['add_sale_report'] = 'Administrator/Reports/addSaleReport';
$route['delete_sale_report'] = 'Administrator/Reports/deleteSaleReport';
$route['get_sale_report'] = 'Administrator/Reports/getSaleReport';

// cs_customer route
$route['cs_customer']        = 'Administrator/CsCustomer';
$route['add_cs_customer'] = 'Administrator/CsCustomer/addCsCustomer';
$route['update_cs_customer'] = 'Administrator/CsCustomer/updateCsCustomer';
$route['delete_cs_customer'] = 'Administrator/CsCustomer/deleteCsCustomer';
$route['get_cs_customer']    = 'Administrator/CsCustomer/getCsCustomer';

//====================================== Common Route ======================================
// zone route
$route['zone'] = 'Administrator/Zone';
$route['get_zone'] = 'Administrator/Zone/getZone';
$route['add_zone'] = 'Administrator/Zone/addZone';
$route['update_zone'] = 'Administrator/Zone/updateZone';
$route['delete_zone'] = 'Administrator/Zone/deleteZone';
// property_category route
$route['property_category'] = 'Administrator/PropertyCategory';
$route['get_property_category'] = 'Administrator/PropertyCategory/getPropertyCategory';
$route['add_property_category'] = 'Administrator/PropertyCategory/addPropertyCategory';
$route['update_property_category'] = 'Administrator/PropertyCategory/updatePropertyCategory';
$route['delete_property_category'] = 'Administrator/PropertyCategory/deletePropertyCategory';
// lift
$route['floor']        = 'Administrator/Floor';
$route['add_floor'] = 'Administrator/Floor/addFloor';
$route['update_floor'] = 'Administrator/Floor/updateFloor';
$route['delete_floor'] = 'Administrator/Floor/deleteFloor';
$route['get_floor']    = 'Administrator/Floor/getFloor';
// lift
$route['lift']        = 'Administrator/Lift';
$route['add_lift'] = 'Administrator/Lift/addLift';
$route['update_lift'] = 'Administrator/Lift/updateLift';
$route['delete_lift'] = 'Administrator/Lift/deleteLift';
$route['get_lift']    = 'Administrator/Lift/getLift';
// generator
$route['generator']        = 'Administrator/PropertyGenerator';
$route['add_generator'] = 'Administrator/PropertyGenerator/addGenerator';
$route['update_generator'] = 'Administrator/PropertyGenerator/updateGenerator';
$route['delete_generator'] = 'Administrator/PropertyGenerator/deleteGenerator';
$route['get_generator']    = 'Administrator/PropertyGenerator/getGenerator';
// gas
$route['gas']        = 'Administrator/Gas';
$route['add_gas'] = 'Administrator/Gas/addGas';
$route['update_gas'] = 'Administrator/Gas/updateGas';
$route['delete_gas'] = 'Administrator/Gas/deleteGas';
$route['get_gas']    = 'Administrator/Gas/getGas';
// sqft
$route['sqft']        = 'Administrator/Sqft';
$route['add_sqft'] = 'Administrator/Sqft/addSqft';
$route['update_sqft'] = 'Administrator/Sqft/updateSqft';
$route['delete_sqft'] = 'Administrator/Sqft/deleteSqft';
$route['get_sqft']    = 'Administrator/Sqft/getSqft';
// bed
$route['bed']        = 'Administrator/Bed';
$route['add_bed'] = 'Administrator/Bed/addBed';
$route['update_bed'] = 'Administrator/Bed/updateBed';
$route['delete_bed'] = 'Administrator/Bed/deleteBed';
$route['get_bed']    = 'Administrator/Bed/getBed';
// servant_bed
$route['servant_bed']        = 'Administrator/ServantBed';
$route['add_servant_bed'] = 'Administrator/ServantBed/addServantBed';
$route['update_servant_bed'] = 'Administrator/ServantBed/updateServantBed';
$route['delete_servant_bed'] = 'Administrator/ServantBed/deleteServantBed';
$route['get_servant_bed']    = 'Administrator/ServantBed/getServantBed';
// bath
$route['bath']        = 'Administrator/Bath';
$route['add_bath'] = 'Administrator/Bath/addBath';
$route['update_bath'] = 'Administrator/Bath/updateBath';
$route['delete_bath'] = 'Administrator/Bath/deleteBath';
$route['get_bath']    = 'Administrator/Bath/getBath';
// servant_bath
$route['servant_bath']        = 'Administrator/ServantBath';
$route['add_servant_bath'] = 'Administrator/ServantBath/addServantBath';
$route['update_servant_bath'] = 'Administrator/ServantBath/updateServantBath';
$route['delete_servant_bath'] = 'Administrator/ServantBath/deleteServantBath';
$route['get_servant_bath']    = 'Administrator/ServantBath/getServantBath';
// balcony
$route['balcony']        = 'Administrator/Balcony';
$route['add_balcony'] = 'Administrator/Balcony/addBalcony';
$route['update_balcony'] = 'Administrator/Balcony/updateBalcony';
$route['delete_balcony'] = 'Administrator/Balcony/deleteBalcony';
$route['get_balcony']    = 'Administrator/Balcony/getBalcony';
// apt_face
$route['apt_face']        = 'Administrator/AptFace';
$route['add_apt_face'] = 'Administrator/AptFace/addAptFace';
$route['update_apt_face'] = 'Administrator/AptFace/updateAptFace';
$route['delete_apt_face'] = 'Administrator/AptFace/deleteAptFace';
$route['get_apt_face']    = 'Administrator/AptFace/getAptFace';
// drawing
$route['drawing']        = 'Administrator/Drawing';
$route['add_drawing'] = 'Administrator/Drawing/addDrawing';
$route['update_drawing'] = 'Administrator/Drawing/updateDrawing';
$route['delete_drawing'] = 'Administrator/Drawing/deleteDrawing';
$route['get_drawing']    = 'Administrator/Drawing/getDrawing';
// apt_type
$route['apt_type']        = 'Administrator/AptType';
$route['add_apt_type'] = 'Administrator/AptType/addAptType';
$route['update_apt_type'] = 'Administrator/AptType/updateAptType';
$route['delete_apt_type'] = 'Administrator/AptType/deleteAptType';
$route['get_apt_type']    = 'Administrator/AptType/getAptType';
// apt_status
$route['apt_status']        = 'Administrator/AptStatus';
$route['add_apt_status'] = 'Administrator/AptStatus/addAptStatus';
$route['update_apt_status'] = 'Administrator/AptStatus/updateAptStatus';
$route['delete_apt_status'] = 'Administrator/AptStatus/deleteAptStatus';
$route['get_apt_status']    = 'Administrator/AptStatus/getAptStatus';
// parking
$route['parking']        = 'Administrator/Parking';
$route['add_parking'] = 'Administrator/Parking/addParking';
$route['update_parking'] = 'Administrator/Parking/updateParking';
$route['delete_parking'] = 'Administrator/Parking/deleteParking';
$route['get_parking']    = 'Administrator/Parking/getParking';
// budget
$route['budget']        = 'Administrator/Budget';
$route['add_budget'] = 'Administrator/Budget/addBudget';
$route['update_budget'] = 'Administrator/Budget/updateBudget';
$route['delete_budget'] = 'Administrator/Budget/deleteBudget';
$route['get_budget']    = 'Administrator/Budget/getBudget';
// member
$route['member']        = 'Administrator/Member';
$route['add_member'] = 'Administrator/Member/addMember';
$route['update_member'] = 'Administrator/Member/updateMember';
$route['delete_member'] = 'Administrator/Member/deleteMember';
$route['get_member']    = 'Administrator/Member/getMember';
// condition
$route['condition']        = 'Administrator/Condition';
$route['add_condition'] = 'Administrator/Condition/addCondition';
$route['update_condition'] = 'Administrator/Condition/updateCondition';
$route['delete_condition'] = 'Administrator/Condition/deleteCondition';
$route['get_condition']    = 'Administrator/Condition/getCondition';
// source
$route['source']        = 'Administrator/Source';
$route['add_source'] = 'Administrator/Source/addSource';
$route['update_source'] = 'Administrator/Source/updateSource';
$route['delete_source'] = 'Administrator/Source/deleteSource';
$route['get_source']    = 'Administrator/Source/getSource';

// ===================================== Property Management =========================================
//rent property
$route['property_entry'] = 'Administrator/Property';
$route['property_entry/(:any)'] = 'Administrator/Property/editProperty/$1';
$route['get_property'] = 'Administrator/Property/getProperty';
$route['add_property'] = 'Administrator/Property/addProperty';
$route['update_property'] = 'Administrator/Property/updateProperty';
$route['delete_property'] = 'Administrator/Property/deleteProperty';
$route['property_list'] = 'Administrator/Property/propertyList';
$route['rent_status_update'] = 'Administrator/Property/rentStatusUpdate';

//sale property
$route['sale_property'] = 'Administrator/SaleProperty';
$route['sale_property/(:any)'] = 'Administrator/SaleProperty/editProperty/$1';
$route['get_sale_property'] = 'Administrator/SaleProperty/getProperty';
$route['add_sale_property'] = 'Administrator/SaleProperty/addProperty';
$route['update_sale_property'] = 'Administrator/SaleProperty/updateProperty';
$route['delete_sale_property'] = 'Administrator/SaleProperty/deleteProperty';
$route['sale_property_list'] = 'Administrator/SaleProperty/propertyList';
$route['sale_status_update'] = 'Administrator/SaleProperty/saleStatusUpdate';

//========================================== User Management ==========================================
$route['user'] = 'Administrator/User_management';
$route['get_users'] = 'Administrator/User_management/getUsers';
$route['get_all_users'] = 'Administrator/User_management/getAllUsers';
$route['userInsert'] = 'Administrator/User_management/user_Insert';
$route['userUpdate'] = 'Administrator/User_management/userupdate';
$route['userEdit/(:any)'] = 'Administrator/User_management/edit/$1';
$route['userDeactive/(:any)'] = 'Administrator/User_management/userDeactive/$1';
$route['userActive/(:any)'] = 'Administrator/User_management/userActive/$1';
$route['access/(:any)'] = 'Administrator/User_management/user_access/$1';
$route['get_user_access'] = 'Administrator/User_management/getUserAccess';
$route['profile'] = 'Administrator/User_management/profile';
$route['password_change'] = 'Administrator/User_management/password_change';
$route['define_access/(:any)'] = 'Administrator/User_management/define_access/$1';
$route['add_user_access'] = 'Administrator/User_management/addUserAccess';
$route['upload_user_image'] = 'Administrator/User_management/uploadUserImage';
$route['user_activity'] = 'Administrator/User_management/userActivity';
$route['get_user_activity'] = 'Administrator/User_management/getUserActivity';
$route['delete_user_activity'] = 'Administrator/User_management/deleteUserActivity';

$route['brunch'] = 'Administrator/Page/brunch';
$route['add_branch'] = 'Administrator/Page/addBranch';
$route['update_branch'] = 'Administrator/Page/updateBranch';
$route['brunchEdit'] = 'Administrator/Page/brunch_edit';
$route['brunchUpdate'] = 'Administrator/Page/brunch_update';
$route['brunchDelete'] = 'Administrator/Page/brunch_delete';
$route['get_branches'] = 'Administrator/Page/getBranches';
$route['get_current_branch'] = 'Administrator/Page/getCurrentBranch';
$route['change_branch_status'] = 'Administrator/Page/changeBranchStatus';

$route['companyProfile'] = 'Administrator/Page/company_profile';
$route['company_profile_Update'] = 'Administrator/Page/company_profile_Update';
$route['company_profile_insert'] = 'Administrator/Page/company_profile_insert';
$route['get_company_profile'] = 'Administrator/Page/getCompanyProfile';

//========================================== Employee Management==========================================
$route['employee'] = 'Administrator/employee';
$route['get_employees'] = 'Administrator/Employee/getEmployees';
$route['employeeInsert'] = 'Administrator/Employee/employee_insert/';
$route['emplists/(:any)'] = 'Administrator/Employee/emplists/$1';
$route['employeeEdit/(:any)'] = 'Administrator/Employee/employee_edit/$1';
$route['employeeUpdate'] = 'Administrator/Employee/employee_Update';
$route['employeeDelete'] = 'Administrator/Employee/employee_Delete';
$route['employeeActive'] = 'Administrator/Employee/active';

//salary Payment
$route['salary_payment']                = 'Administrator/Employee/employeePayment';
$route['check_payment_month']           = 'Administrator/Employee/checkPaymentMonth';
$route['get_payments']                  = 'Administrator/Employee/getPayments';
$route['get_salary_details']            = 'Administrator/Employee/getSalaryDetails';
$route['add_salary_payment']            = 'Administrator/Employee/saveSalaryPayment';
$route['update_salary_payment']         = 'Administrator/Employee/updateSalaryPayment';
$route['salary_payment_report']         = 'Administrator/Employee/employeePaymentReport';
$route['delete_payment']                = 'Administrator/Employee/deletePayment';

$route['designation']            = 'Administrator/Employee/designation/';
$route['insertDesignation']      = 'Administrator/Employee/insert_designation';
$route['designationedit/(:any)'] = 'Administrator/Employee/designationedit/$1';
$route['designationUpdate']      = 'Administrator/Employee/designationupdate/';
$route['designationdelete']      = 'Administrator/Employee/designationdelete';

$route['depertment']            = 'Administrator/Employee/depertment';
$route['insertDepertment']      = 'Administrator/Employee/insert_depertment';
$route['depertmentdelete']      = 'Administrator/Employee/depertmentdelete/';
$route['depertmentedit/(:any)'] = 'Administrator/Employee/depertmentedit/$1';
$route['depertmentupdate']      = 'Administrator/Employee/depertmentupdate';

$route['month']            = 'Administrator/Employee/month';
$route['insertMonth']      = 'Administrator/Employee/insert_month';
$route['editMonth/(:any)'] = 'Administrator/Employee/editMonth/$1';
$route['updateMonth']      = 'Administrator/Employee/updateMonth';
$route['get_months']       = 'Administrator/Employee/getMonths';

// Graph
$route['graph'] = 'Administrator/Graph/graph';
$route['get_graph_data'] = 'Administrator/Graph/getGraphData';

// SMS
$route['sms'] = 'Administrator/SMS';
$route['send_sms'] = 'Administrator/SMS/sendSms';
$route['send_bulk_sms'] = 'Administrator/SMS/sendBulkSms';
$route['sms_settings'] = 'Administrator/SMS/smsSettings';
$route['get_sms_settings'] = 'Administrator/SMS/getSmsSettings';
$route['save_sms_settings'] = 'Administrator/SMS/saveSmsSettings';

$route['user_login'] = 'Login/userLogin';
$route['get_otp'] = 'Administrator/Page/getOtp';
$route['update_otp'] = 'Administrator/Page/UpdateOtp';
$route['otp_page'] = 'Administrator/Page/OtpPage';
$route['check_otp'] = 'Administrator/Page/editdeleteAccess';
$route['database_backup'] = 'Administrator/Page/databaseBackup';
