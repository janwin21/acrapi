<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/user_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/company_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/role_controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/controller/permission_controller.php');
    
    // instances
    $user = new UserController(0);
    $company = new CompanyController(0);
    $role = new RoleController(0);
    $permission = new PermissionController(0);
 
    // USER | register($isAdmin, $data)
    echo "// POST: acrapi/api/v1/register?isAdmin=boolean</br>";
	echo $user->register(1, 1) . "</br>"; // success
	echo $user->register(0, 1) . "</br></br>"; // error

    // USER | login($email)
    echo "GET: acrapi/api/v1/login-email</br>";
	echo $user->login(1) . "</br>"; // success
	echo $user->login(0) . "</br></br>"; // error

    // USER | get_all()
    echo "GET: acrapi/api/v1/users</br>";
	echo $user->get_all() . "</br></br>"; // success

    // USER | get_with_companies()
    echo "GET: acrapi/api/v1/users/companies</br>";
	echo $user->get_all_with_companies() . "</br></br>"; // success

    // USER | get_user_companies($user_id)
    echo "GET: acrapi/api/v1/users/:user_id/companies</br>";
	echo $company->get_user_companies(1) . "</br>"; // success
	echo $company->get_user_companies(0) . "</br></br>"; // error

    // USER | get_all_with_roles()
    echo "GET: acrapi/api/v1/users/roles</br>";
	echo $user->get_all_with_roles() . "</br></br>"; // success

    // USER | get_with_roles($user_id)
    echo "GET: acrapi/api/v1/users/:user_id/roles</br>";
	echo $user->get_with_roles(1) . "</br>"; // success
	echo $user->get_with_roles(0) . "</br></br>"; // error

    // USER | is_authorize($user_id, $action)
    echo "GET: acrapi/api/v1/authorize/:user_id/permission?action=value</br>";
	echo $user->is_authorize(1, 0) . "</br>"; // success
	echo $user->is_authorize(0, 0) . "</br></br>"; // error

    // USER | is_role_authorize($user_id, $role, $action)
    echo "GET: acrapi/api/v1/authorize/:user_id/permission?role=value1&action=value2</br>";
	echo $user->is_role_authorize(1, 0) . "</br>"; // success
	echo $user->is_role_authorize(0, 0) . "</br></br>"; // error

    // USER | change_role($company_id, $user_id, $role_id, $data)
    echo "PUT: acrapi/api/v1/change-role/companies/:company_id/users/:user_id/roles/:role_id</br>";
	echo $user->change_role(1, 1, 1, 1) . "</br>"; // success
	echo $user->change_role(1, 1, 0, 0) . "</br></br>"; // error

    // USER | update($user_id, $data)
    echo "PUT: acrapi/api/v1/users/:user_id</br>";
	echo $user->update(1, 1) . "</br>"; // success
	echo $user->update(1, 0) . "</br></br>"; // error

    // ROLE | add($data)
    echo "POST: acrapi/api/v1/roles</br>";
	echo $role->add(1) . "</br>"; // success
	echo $role->add(0) . "</br></br>"; // error

    // ROLE | assign_role($data)
    echo "POST: acrapi/api/v1/assign-roles</br>";
	echo $role->assign_role(1) . "</br>"; // success
	echo $role->assign_role(0) . "</br></br>"; // error

    // ROLE | get_all_created_by($created_by)
    echo "GET: acrapi/api/v1/roles/created-by/:created_by</br>";
	echo $role->get_all_created_by(1) . "</br>"; // success
	echo $role->get_all_created_by(0) . "</br></br>"; // error

    // ROLE | get_all()
    echo "GET: acrapi/api/v1/roles</br>";
	echo $role->get_all() . "</br></br>"; // success

    // ROLE | update($role_id, $created_by, $data)
    echo "PUT: acrapi/api/v1/roles/:role_id/users/:created_by</br>";
	echo $role->update(1, 1, 1) . "</br>"; // success
	echo $role->update(1, 0, 0) . "</br></br>"; // error

    // ROLE | delete($company, $user, $role)
    echo "DELETE: acrapi/api/v1/unassign-role/companies/:company_id/users/:user_id/roles/:role_id</br>";
	echo $role->delete(1, 1, 1) . "</br>"; // success
	echo $role->delete(1, 0, 1) . "</br></br>"; // error

    // PERMISSION | add($data)
    echo "POST: acrapi/api/v1/permissions</br>";
	echo $permission->add(1) . "</br>"; // success
	echo $permission->add(0) . "</br></br>"; // error

    // PERMISSION | assign_permission($data)
    echo "POST: acrapi/api/v1/assign-permissions</br>";
	echo $permission->assign_permission(1) . "</br>"; // success
	echo $permission->assign_permission(0) . "</br></br>"; // error

    // PERMISSION | update($role_id, $created_by, $data)
    echo "PUT: acrapi/api/v1/permissions/:permission_id/users/:created_by</br>";
	echo $permission->update(1, 1, 1) . "</br>"; // success
	echo $permission->update(1, 0, 0) . "</br></br>"; // error

    // PERMISSION | delete($role, $permission)
    echo "DELETE: acrapi/api/v1/unassign-permission/roles/:role_id/permissions/:permission_id</br>";
	echo $permission->delete(1, 1) . "</br>"; // success
	echo $permission->delete(1, 0) . "</br></br>"; // error

    // COMPANY | add($data)
    echo "POST: acrapi/api/v1/companies</br>";
	echo $company->add(1) . "</br>"; // success
	echo $company->add(0) . "</br></br>"; // error

    // COMPANY | get_all()
    echo "GET: acrapi/api/v1/companies</br>";
	echo $company->get_all() . "</br></br>"; // success

    // COMPANY | get_users($company_id)
    echo "GET: acrapi/api/v1/companies/:company_id/users</br>";
	echo $company->get_users(1) . "</br>"; // success
	echo $company->get_users(0) . "</br></br>"; // error

    // COMPANY | update($company_id, $data)
    echo "PUT: acrapi/api/v1/companies/:company_id</br>";
	echo $company->update(1, 1) . "</br>"; // success
	echo $company->update(0, 0) . "</br></br>"; // error
?>