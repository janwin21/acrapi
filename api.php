<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/config/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/user_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/company_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/role_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/permission_controller.php');

	// controllers
	$user_controller = new UserController($conn);
	$company_controller = new CompanyController($conn);
	$role_controller = new RoleController($conn);
	$permission_controller = new PermissionController($conn);

	$method = $_SERVER['REQUEST_METHOD'];
	$endpoint = $_SERVER['PATH_INFO'];
	
	header('Content-Type: application/json');
	
	switch($method)
	{
		case 'GET':
			if($endpoint === '/users') {
				echo $user_controller->get_all();
			} elseif($endpoint === '/companies') {
				echo $company_controller->get_all();
			} elseif($endpoint === '/users/companies') {
				echo $company_controller->get_all();
			} else if(preg_match("/^\/users\/(\d+)\/companies$/",$endpoint,$matches)) {
				echo $company_controller->get_user_companies($matches[1]);
			} elseif($endpoint === '/roles') {
				echo $role_controller->get_all();
			} elseif($endpoint === '/permissions') {
				echo $permission_controller->get_all();
			} elseif($endpoint === '/users/roles') {
				echo $user_controller->get_all_with_roles();
			} elseif(preg_match("/^\/users\/(\d+)\/roles$/",$endpoint,$matches)) {
				echo $user_controller->get_with_roles($matches[1]);
			} elseif(preg_match("/^\/authorize\/(\d+)\/permission$/",$endpoint,$matches)) {
				echo $user_controller->is_authorize($matches[1]);
			} else if(preg_match("/^\/companies\/(\d+)\/users$/",$endpoint,$matches)) {
				echo $company_controller->get_users(company_id: $matches[1]);
			} else if(preg_match("/^\/roles\/created-by\/(\d+)$/",$endpoint,$matches)) {
				echo $role_controller->get_all_created_by($matches[1]);
			}
		break;
		
		case 'POST':
			if($endpoint === '/register') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $user_controller->register($data, null);
			} elseif($endpoint === '/login-email') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $user_controller->login($data);
			} elseif($endpoint === '/companies') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $company_controller->add($data);
			} elseif($endpoint === '/roles') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $role_controller->add($data);
			} elseif($endpoint === '/permissions') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $permission_controller->add($data);
			} elseif($endpoint === '/assign-roles') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $role_controller->assign_role($data);
			} elseif($endpoint === '/assign-permissions') {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $permission_controller->assign_permission($data);
			}
		break;
		
		case 'PUT':
			if(preg_match("/^\/users\/(\d+)$/",$endpoint,$matches)) {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $user_controller->update($matches[1], $data);
			} elseif(preg_match("/^\/companies\/(\d+)$/",$endpoint,$matches)) {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $company_controller->update($matches[1], $data);
			} elseif(preg_match("/^\/change-role\/companies\/(\d+)\/users\/(\d+)\/roles\/(\d+)$/",$endpoint,$matches)) {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $user_controller->change_role($matches[1], $matches[2], $matches[3], $data);
			} elseif(preg_match("/^\/roles\/(\d+)\/users\/(\d+)$/",$endpoint,$matches)) {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $role_controller->update($matches[1], $matches[2], $data);
			} elseif(preg_match("/^\/permissions\/(\d+)\/users\/(\d+)$/",$endpoint,$matches)) {
				$data = json_decode(file_get_contents('php://input'),true);
				echo $permission_controller->update($matches[1], $matches[2], $data);
			} elseif (preg_match("/^\/employees\/(\d+)$/",$endpoint,$matches)) {
				$employeeId = $matches[1];
				$data = json_decode(file_get_contents('php://input'),true);
				$result = $employeeObj->updateEmployee($employeeId,$data);
				echo json_encode(["success"=>$result]);
			}
		break;
		
		case 'DELETE':
			if(preg_match("/^\/unassign-role\/companies\/(\d+)\/users\/(\d+)\/roles\/(\d+)$/",$endpoint,$matches)) {
				echo $role_controller->delete($matches[1], $matches[2], $matches[3]);
			} elseif(preg_match("/^\/unassign-permission\/roles\/(\d+)\/permissions\/(\d+)$/",$endpoint,$matches)) {
				echo $permission_controller->delete($matches[1], $matches[2]);
			}
		break;
	}
?>
	