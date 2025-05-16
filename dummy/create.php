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
        new User(null, 'Janwin', 'Toralba', 'janwintoralba@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 1
        new User(null, 'Michaela', 'Green', 'michaelagreen@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 2
        new User(null, 'Rhonzel', 'Santos', 'rhonzelsantos@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 3
        new User(null, 'Diana', 'May', 'dianamay@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 4
        new User(null, 'Marie', 'Donna', 'marriedonna@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 5
        new User(null, 'Ron', 'Cluster', 'roncluster@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)), // 6
        new User(null, 'John', 'Wilson', 'johnwilson@gmail.com', password_hash("mypassword", PASSWORD_DEFAULT)) // 7
    ];

    // roles
    $roles = [
        new Role(null, 1, 'acrapi-admin', ''), // 1
        new Role(null, 4, 'attendance-teacher', ''), // 2
        new Role(null, 4, 'attendance-assistant-teacher', ''), // 3
        new Role(null, 6, 'techno-store-admin', ''), // 4
        new Role(null, 6, 'techno-store-subscriber', '') // 5
    ];

    // permissions
    $permissions = [   
        new Permission(null, 1, 'acrapi-all-around', ''), // 1
        new Permission(null, 4, 'attendance-create', ''), // 2
        new Permission(null, 4, 'attendance-read', ''), // 3
        new Permission(null, 4, 'attendance-update', ''), // 4
        new Permission(null, 4, 'attendance-delete', '') // 5
    ];

    // companies
    $companies = [   
        new Company(null, 1, 'Access Control Management REST API', 'rest api', 'Paranaque City, Metro Manila', '-', 2025), // 1
        new Company(null, 4, 'Student Attendance', 'education', 'Sta. Mesa, Manila', '092-144-9506', 2021), // 2
        new Company(null, 6, 'Technology Online Store', 'technology', 'Brockville, Ontario, Canada', '901-233-8809', 2015) // 3
    ];

    // permission_groups
    $permission_groups = [
        new PermissionGroup(null, 1, 1),

        // client 1
        new PermissionGroup(null, 2, 2),
        new PermissionGroup(null, 2, 3),
        new PermissionGroup(null, 2, 4),
        new PermissionGroup(null, 2, 5),
        new PermissionGroup(null, 3, 3),
        new PermissionGroup(null, 3, 4),

        // client 2 (basic authentication)
        new PermissionGroup(null, 4, 1),
        new PermissionGroup(null, 5, permission_id: 1)
    ];

    // role_groups
    $role_groups = [
        new RoleGroup(null, 1, 1, 1),
        new RoleGroup(null, 1, 2, 1),
        new RoleGroup(null, 1, 3, 1),

        // client 1
        new RoleGroup(null, 2, 4, 2),
        new RoleGroup(null, 2, 5, 3),

        // client 2
        new RoleGroup(null, 3, 6, 4),
        new RoleGroup(null, 3, 7, 5)
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