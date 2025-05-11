<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/config/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/user.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/role.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/permission.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/company.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/permission_group.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/role_group.php');

    // users
    $users = [
        new User(null, 'John', 'Smith', 'johnsmaith@email.com', 'password'),
        new User(null, 'Jane', 'Red', 'janered@email.com', 'password'),
        new User(null, 'Lukas', 'Prec', 'luke@email.com', 'password'),
        new User(null, 'Amy', 'Sky', 'sky@email.com', 'password'),
        new User(null, 'Jenny', 'Arcland', 'jenjen@email.com', 'password')
    ];

    // roles
    $roles = [
        new Role(null, 1, 'acrapi-admin', ''),
        new Role(null, 1, 'acrapi-client', ''),
        new Role(null, 1, 'Librarian', ''),
        new Role(null, 1, 'Reasearcher', ''),
        new Role(null, 1, 'Manager', ''),
        new Role(null, 2, 'Admin', ''),
        new Role(null, 2, 'Principal', '')
    ];

    // permissions
    $permissions = [   
        new Permission(null, 1, 'create books', ''),
        new Permission(null, 1, 'read books', ''),
        new Permission(null, 1, 'update books', ''),
        new Permission(null, 1, 'delete books', ''),
        new Permission(null, 1, 'create research', ''),
        new Permission(null, 1, 'read research', ''),
        new Permission(null, 1, 'update research', ''),
        new Permission(null, 1, 'delete research', ''),
        new Permission(null, 2, 'add library', ''),
        new Permission(null, 2, 'read library', ''),
        new Permission(null, 2, 'update library', ''),
        new Permission(null, 2, 'delete library', '')
    ];

    // companies
    $companies = [   
        new Company(null, 1, 'acrapi', 'api', 'paranaque', '-', 2025),
        new Company(null, 1, 'National Library', 'Education', 'Manila', '12345', 1998),
        new Company(null, 2, 'Quezon Library', 'Education', 'Quezon', '12345', 2010)
    ];

    // permission_groups
    $permission_groups = [
        new PermissionGroup(null, 3, 1), 
        new PermissionGroup(null, 3, 2), 
        new PermissionGroup(null, 3, 3), 
        new PermissionGroup(null, 3, 4),
        new PermissionGroup(null, 4, 5), 
        new PermissionGroup(null, 4, 6), 
        new PermissionGroup(null, 4, 7), 
        new PermissionGroup(null, 4, 8),
        new PermissionGroup(null, 5, 2), 
        new PermissionGroup(null, 5, 6),
        new PermissionGroup(null, 6, 9), 
        new PermissionGroup(null, 6, 10), 
        new PermissionGroup(null, 6, 11), 
        new PermissionGroup(null, 6, 12),
        new PermissionGroup(null, 7, 10)
    ];

    // role_groups
    $role_groups = [
        new RoleGroup(null, 2, 1, 5),
        new RoleGroup(null, 2, 1, 3),
        new RoleGroup(null, 3, 2, 4),
        new RoleGroup(null, 2, 3, 3),
        new RoleGroup(null, 3, 4, 4),
        new RoleGroup(null, 2, 5, 5),
        new RoleGroup(null, 2, 5, 4)
    ];

    foreach($users as $user) { 
        $arr = implode(',', $user->toArray()); 
        $first_name = $user->get_first_name();
        $last_name = $user->get_last_name();
        $email = $user->get_email();
        $password = $user->get_password();

        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES (
            '$first_name', '$last_name', '$email', '$password')
        ";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

    foreach($roles as $role) {
        $arr = implode(',', $role->toArray()); 
        $created_by = $role->get_created_by(); 
        $name = $role->get_name(); 
        $description = $role->get_description();

        $query = "INSERT INTO roles (created_by, name, description) VALUES ($created_by, '$name', '$description')";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

    foreach($permissions as $permission) {
        $arr = implode(',', $permission->toArray());
        $created_by = $permission->get_created_by(); 
        $name = $permission->get_name(); 
        $description = $permission->get_description();

        $query = "INSERT INTO permissions (created_by, name, description) VALUES ($created_by, '$name', '$description')";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

    foreach($companies as $company) {
        $arr = implode(',', $company->toArray());
        $user_id = $company->get_user_id();
        $name = $company->get_name();
        $industry = $company->get_industry();
        $location = $company->get_location();
        $tell_no = $company->get_tell_no();
        $founded_year = $company->get_founded_year();

        $query = "INSERT INTO companies (user_id, name, industry, location, tell_no, founded_year) VALUES (
            $user_id, '$name', '$industry', '$location', '$tell_no', $founded_year
        )";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

    foreach($permission_groups as $permission_group) {
        $arr = implode(',', $permission_group->toArray()); 
        $query = "INSERT INTO permission_groups (role_id, permission_id) VALUES ($arr)";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

    foreach($role_groups as $role_group) {
        $arr = implode(',', $role_group->toArray()); 
        $query = "INSERT INTO role_groups (company_id, user_id, role_id) VALUES ($arr)";
        $result = mysqli_query($conn,$query);
        if($result) { echo $arr . "<br>"; } else { echo "ERROR!<br>"; }
    }
    echo "<br><br>";

?>