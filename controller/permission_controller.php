<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/handler/try_catch_handler.php');

    class PermissionController {
        
		private $conn;
		
		public function __construct($conn) {
			$this->conn = $conn;
		}

        // CREATE
        public function add($data) {
            return handle(function() use ($data) {
                $created_by = $data['created_by'];
                $name = $data['name'];
                $description = $data['description'];
    
                $query = $query = "INSERT INTO permissions (created_by, name, description) VALUES ($created_by, '$name', '$description')";
                $result = mysqli_query($this->conn,$query);
    
                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "New permission successfully created."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // CREATE | ASSIGN PERMISSION
        public function assign_permission($data) {
            return handle(function() use ($data) {
                $role_id = $data['role_id'];
                $permission_id = $data['permission_id'];

                $query = "INSERT INTO permission_groups (role_id, permission_id) VALUES ($role_id, $permission_id)";
                $result = mysqli_query($this->conn,$query);
                
                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "Assigning permission successfully created."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // RETRIEVE
        public function get_all() {
            return handle(function() {
                $query = "SELECT * FROM permissions";
                $result = mysqli_query($this->conn,$query);
                $roles = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $roles[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "roles" => $roles
                    ]
                ];
            });
        }

        // UPDATE
        public function update($permission_id, $created_by, $data) {
            return handle(function() use ($permission_id, $created_by, $data) {
                $name = $data['name'];
                $description = $data['description'];
                
                $query = "
                    UPDATE permissions
                    SET
                        name = '$name',
                        description = '$description'
                    WHERE
                        id = $permission_id AND
                        created_by = $created_by
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "Permission successfully updated."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // DELETE
        public function delete($role, $permission) {
            return handle(function() use ($role, $permission) {
                $query = "
                    DELETE FROM permission_groups
                    WHERE
                        role_id = $role AND
                        permission_id = $permission
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "Permission successfully deleted."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

    }

?>