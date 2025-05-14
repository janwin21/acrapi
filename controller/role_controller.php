<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/handler/try_catch_handler.php');

    class RoleController {

		private $conn;
		
		public function __construct($conn) {
			$this->conn = $conn;
		}

        // CREATE
        public function add($data, $query_data = null) {
            return handle(function() use ($data, $query_data) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $created_by = $data['created_by'];
                $name = $data['name'];
                $description = $data['description'];
    
                $query = $query = "INSERT INTO roles (created_by, name, description) VALUES ($created_by, '$name', '$description')";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "message" => "New role successfully created."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // CREATE | ASSIGN ROLE
        public function assign_role($data) {
            return handle(function() use ($data) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $company_id = $data['company_id'];
                $user_id = $data['user_id'];
                $role_id = $data['role_id'];
    
                $query = $query = "INSERT INTO role_groups (company_id, user_id, role_id) VALUES ($company_id, $user_id, $role_id)";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "message" => "Assigning role successfully created."
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
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $query = "
                    SELECT r.id, r.name, GROUP_CONCAT(p.name SEPARATOR ', ') AS permissions
                    FROM roles r
                    LEFT JOIN permission_groups rp ON rp.role_id = r.id
                    LEFT JOIN permissions p ON rp.permission_id = p.id
                    GROUP BY r.id
                ";
                $result = mysqli_query($this->conn,$query);
                $roles = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $roles[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "payload" => $my_user,
                        "roles" => $roles
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_all_created_by($created_by) {
            return handle(function() use ($created_by) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $query = "
                    SELECT r.name, GROUP_CONCAT(p.name SEPARATOR ', ') AS permissions
                    FROM roles r
                    JOIN permission_groups rp ON rp.role_id = r.id
                    JOIN permissions p ON rp.permission_id = p.id
                    WHERE r.created_by = $created_by
                    GROUP BY r.id;
                ";
                $result = mysqli_query($this->conn,$query);
                $roles = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $roles[] = $row;
                }

                if($created_by) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "roles" => $roles
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // UPDATE
        public function update($role_id, $created_by, $data) {
            return handle(function() use ($role_id, $created_by, $data) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $name = $data['name'];
                $description = $data['description'];
                
                $query = "
                    UPDATE roles
                    SET
                        name = '$name',
                        description = '$description'
                    WHERE
                        id = $role_id AND
                        created_by = $created_by
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "message" => "Role successfully updated."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // DELETE
        public function delete($company, $user, $role) {
            return handle(function() use ($company, $user, $role) {
                $header = getallheaders();
                $my_user = authenticateRequest($header);

                $query = "
                    DELETE FROM role_groups
                    WHERE
                        company_id = $company AND
                        user_id = $user AND
                        role_id = $role
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "payload" => $my_user,
                            "message" => "Role successfully deleted."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

    }

?>