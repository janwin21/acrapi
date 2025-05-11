<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/config/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/user.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/role.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/permission.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/company.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/permission_group.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/model/role_group.php');

    $models = [new User($conn), new Role($conn), new Permission($conn), new Company($conn), new PermissionGroup($conn), new RoleGroup($conn)];

    function migrate($models) {
        foreach($models as $model) {
            $model->create();
            echo "<br>";
        }
    }

    migrate($models);
?>