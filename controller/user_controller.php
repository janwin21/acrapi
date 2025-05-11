<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/error/http_error.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/acrapi/handler/try_catch_handler.php');

    class UserController {

		private $conn;
		
		public function __construct($conn) {
			$this->conn = $conn;
		}

        // CREATE | REGISTER
        public function register($data, $query_data = null) {
            return handle(function() use ($data, $query_data) { 
                $first_name = $data['first_name'];
                $last_name = $data['last_name'];
                $email = $data['email'];
                $password = $data['password'];
                
                $query = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
                $result = mysqli_query($this->conn,$query);
                	
                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 201,
                            "message" => "New user registered successfully."
                        ]
                    ];
                } else {
                    throw new HttpError("401 Unauthorized");
                }
            });
        }

        // LOGIN
        public function login($data) {
            return handle(function() use ($data) { 
                $email = $data['email'];
                $input_password = $data['password'];
                
                $query = "SELECT password FROM users WHERE email LIKE '$email'";
                $result = mysqli_query($this->conn,$query);
                $password = mysqli_fetch_assoc($result);

                if($input_password === $password['password']) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "User login successfully."
                        ]
                    ];
                } else {
                    throw new HttpError("401 Unauthorized");
                }
            });
        }

        // RETRIEVE
        public function get_all() {
            return handle(function() {
                $query = "SELECT id, first_name, last_name, email, created_at, updated_at FROM users";
                $result = mysqli_query($this->conn,$query);
                $users = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "users" => $users
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_all_with_companies() {
            return handle(function() {
                $query = "
                    SELECT u.id, u.first_name, u.last_name, u.email, c.name AS 'company_name', c.industry, c.location, c.founded_year
                    FROM users u
                    INNER JOIN companies c ON c.user_id = u.id
                ";
                $result = mysqli_query($this->conn,$query);
                $users = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "users" => $users
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_all_with_roles() {
            return handle(function() {
                $query = "
                    SELECT u.id, u.first_name, u.last_name, u.email, GROUP_CONCAT(r.name SEPARATOR ', ') AS 'roles', GROUP_CONCAT((
                        SELECT GROUP_CONCAT(p.name SEPARATOR ', ')
                        FROM roles rr
                        JOIN permission_groups rp ON rp.role_id = rr.id
                        JOIN permissions p ON rp.permission_id = p.id
                        WHERE rr.id = r.id
                        GROUP BY rr.id
                    ) SEPARATOR ', ') AS 'permissions'
                    FROM users u
                    JOIN role_groups ur ON ur.user_id = u.id
                    JOIN roles r ON ur.role_id = r.id
                    GROUP BY u.id
                ";
                $result = mysqli_query($this->conn,$query);
                $users = array();
                
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }

                return [
                    "status" => "success",
                    "data" => [
                        "code" => 200,
                        "users" => $users
                    ]
                ];
            });
        }

        // RETRIEVE
        public function get_with_roles($user_id) {
            return handle(function() use ($user_id) {
                $query = "
                    SELECT u.id, u.first_name, u.last_name, u.email, GROUP_CONCAT(r.name SEPARATOR ', ') AS 'roles', GROUP_CONCAT((
                        SELECT GROUP_CONCAT(p.name SEPARATOR ', ')
                        FROM roles rr
                        JOIN permission_groups rp ON rp.role_id = rr.id
                        JOIN permissions p ON rp.permission_id = p.id
                        WHERE rr.id = r.id
                        GROUP BY rr.id
                    ) SEPARATOR ', ') AS 'permissions'
                    FROM users u
                    JOIN role_groups ur ON ur.user_id = u.id
                    JOIN roles r ON ur.role_id = r.id
                    WHERE u.id = $user_id
                    GROUP BY u.id
                ";
                $result = mysqli_query($this->conn,$query);
                $user = mysqli_fetch_assoc($result);

                if($user_id) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "user" => $user
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // RETRIEVE
        public function is_authorize($user_id) {
            return handle(function() use ($user_id) {
                $query_data = [
                    "role" => $_GET["role"] ?? null,
                    "action" => $_GET["action"] ?? null
                ];

                $query = "
                    SELECT IF(COUNT(permission_list) > 0, 'true', 'false') as result
                    FROM (
                        SELECT GROUP_CONCAT((
                            SELECT GROUP_CONCAT(p.name SEPARATOR ', ')
                            FROM roles rr
                            JOIN permission_groups rp ON rp.role_id = rr.id
                            JOIN permissions p ON rp.permission_id = p.id
                            WHERE rr.id = r.id
                            GROUP BY rr.id
                        ) SEPARATOR ', ') AS permission_list
                        FROM users u
                        JOIN role_groups ur ON ur.user_id = u.id
                        JOIN roles r ON ur.role_id = r.id
                        WHERE u.id = $user_id
                        GROUP BY u.id
                    ) AS permissions_for_user
                    WHERE permission_list LIKE '%" . $query_data['action'] . "%'
                ";

                if($query_data['role'] != null) {
                    $query = "
                        SELECT IF(COUNT(permission_list) > 0, 'true', 'false') as result
                        FROM (
                            SELECT GROUP_CONCAT((
                                SELECT GROUP_CONCAT(p.name SEPARATOR ', ')
                                FROM roles rr
                                JOIN permission_groups rp ON rp.role_id = rr.id
                                JOIN permissions p ON rp.permission_id = p.id
                                WHERE rr.id = r.id
                                GROUP BY rr.id
                            ) SEPARATOR ', ') AS permission_list
                            FROM users u
                            JOIN role_groups ur ON ur.user_id = u.id
                            JOIN roles r ON ur.role_id = r.id
                            WHERE u.id = $user_id AND r.name IN ('" . $query_data['role'] . "')
                            GROUP BY u.id
                        ) AS permissions_for_user
                        WHERE permission_list LIKE '%" . $query_data['action'] . "%'
                    ";
                }

                $result = mysqli_query($this->conn,$query);
                $is_authorized = mysqli_fetch_assoc($result);

                if($user_id) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "result" => $is_authorized["result"]
                        ]
                    ];
                } else {
                    throw new HttpError("401 Unauthorized");
                }
            });
        }

        // UPDATE
        public function update($user_id, $data) {
            return handle(function() use ($user_id, $data) {
                $first_name = $data['first_name'];
                $last_name = $data['last_name'];
                $email = $data['email'];
                
                $query = "
                    UPDATE users
                    SET 
                        first_name = '$first_name',
                        last_name = '$last_name',
                        email = '$email'
                    WHERE
                        id = $user_id
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "User successfully updated."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }

        // UPDATED
        public function change_role($company_id, $user_id, $role_id, $data) {
            return handle(function() use ($company_id, $user_id, $role_id, $data) {
                $input_role_id = $data['role_id'];
                
                $query = "
                    UPDATE role_groups
                    SET
                        role_id = $input_role_id
                    WHERE
                        company_id = $company_id AND
                        user_id = $user_id AND
                        role_id = $role_id
                ";
                $result = mysqli_query($this->conn,$query);

                if($result) {
                    return [
                        "status" => "success",
                        "data" => [
                            "code" => 200,
                            "message" => "User's role successfully changed."
                        ]
                    ];
                } else {
                    throw new HttpError("400 Bad Request");
                }
            });
        }
    }

?>