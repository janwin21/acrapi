<?php
    /* Endpoints */
    function call_endpoint($endpoint) {
        // POST: acrapi/api/v1/register?isAdmin=boolean
        if(preg_match("/^\/register\?isAdmin=([^&]+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/login-email
        elseif($endpoint === '/login-email') { echo ' TRUE <br>'; }

        // POST | GET: acrapi/api/v1/companies
        elseif($endpoint === '/companies') { echo ' TRUE <br>'; } 

        // POST | GET: acrapi/api/v1/roles
        elseif($endpoint === '/roles') { echo ' TRUE <br>'; }

        // POST: acrapi/api/v1/permissions
        elseif($endpoint === '/permissions') { echo ' TRUE <br>'; }

        // POST: acrapi/api/v1/assign-roles
        elseif($endpoint === '/assign-roles') { echo ' TRUE <br>'; }

        // POST: acrapi/api/v1/assign-permissions
        elseif($endpoint === '/assign-permissions') { echo ' TRUE <br>'; }

        // GET: acrapi/api/v1/users
        elseif($endpoint === '/users') { echo ' TRUE <br>'; }

        // GET: acrapi/api/v1/users/companies
        elseif($endpoint === '/users/companies') { echo ' TRUE <br>'; }
        
        // GET: acrapi/api/v1/users/:user_id/companies
        elseif(preg_match("/^\/users\/(\d+)\/companies$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/users/roles
        elseif(preg_match("/^\/users\/roles$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/users/:user_id/roles
        elseif(preg_match("/^\/users\/(\d+)\/roles$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/authorize/:user_id/permission?action=value
        elseif(preg_match("/^\/authorize\/(\d+)\/permission\?action=([^&]+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/authorize/:user_id/permission?role=value1&action=value2
        elseif(preg_match("/^\/authorize\/(\d+)\/permission\?role=([^&]+)\&action=([^&]+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/authorize/:user_id/permission?role=value1&action=value2
        elseif(preg_match("/^\/authorize\/(\d+)\/permission\?role=([^&]+)\&action=([^&]+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/companies/:company_id/users
        elseif(preg_match("/^\/companies\/(\d+)\/users$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/roles/created-by/:created_by
        elseif(preg_match("/^\/roles\/created-by\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // PUT: acrapi/api/v1/users/:user_id
        elseif(preg_match("/^\/users\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // PUT: acrapi/api/v1/companies/:company_id
        elseif(preg_match("/^\/companies\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // PUT: acrapi/api/v1/change-role/companies/:company_id/users/:user_id/roles/:role_id
        elseif(preg_match("/^\/change-role\/companies\/(\d+)\/users\/(\d+)\/roles\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // PUT: acrapi/api/v1/roles/:role_id/users/:created_by
        elseif(preg_match("/^\/roles\/(\d+)\/users\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // PUT: acrapi/api/v1/permissions/:permission_id/users/:created_by
        elseif(preg_match("/^\/permissions\/(\d+)\/users\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // DELETE: acrapi/api/v1/unassign-role/companies/:company_id/users/:user_id/roles/:role_id
        elseif(preg_match("/^\/unassign-role\/companies\/(\d+)\/users\/(\d+)\/roles\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }
        
        // DELETE: acrapi/api/v1/unassign-permission/roles/:role_id/permissions/:permission_id
        elseif(preg_match("/^\/unassign-permission\/roles\/(\d+)\/permissions\/(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/users?fields=userId,firstName,lastName,email,etc
        elseif(preg_match("/^\/users\?fields=([^&]+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // GET: acrapi/api/v1/users?sort=-firstName,-lastName&offset=value3&limit=value4
        elseif(preg_match("/^\/users\?sort=([^&]+)\&offset=(\d+)\&limit=(\d+)$/",$endpoint,$matches)) { echo " $matches[0] <br>"; }

        // FAIL
        else { echo ' FALSE ';  return; }
    }

    call_endpoint('/register?isAdmin=true');
    call_endpoint('/login-email');
    call_endpoint('/companies');
    call_endpoint('/roles');
    call_endpoint('/permissions');
    call_endpoint('/assign-roles');
    call_endpoint('/assign-permissions');
    call_endpoint('/users');
    call_endpoint('/users/companies');
    call_endpoint('/users/1/companies');
    call_endpoint('/users/roles');
    call_endpoint('/users/1/roles');
    call_endpoint('/authorize/1/permission?action=read');
    call_endpoint('/authorize/1/permission?role=teacher&action=read');
    call_endpoint('/companies/1/users');
    call_endpoint('/roles/created-by/1');
    call_endpoint('/users/1');
    call_endpoint('/companies/1');
    call_endpoint('/change-role/companies/1/users/2/roles/3');
    call_endpoint('/roles/1/users/2');
    call_endpoint('/permissions/1/users/2');
    call_endpoint('/unassign-role/companies/1/users/2/roles/3');
    call_endpoint('/unassign-permission/roles/1/permissions/2');
    call_endpoint('/users?fields=userId,firstName,lastName,email,etc');
    call_endpoint('/users?sort=-firstName,-lastName&offset=10&limit=5');
?>